<?php

namespace App\Console\Commands;

use App\Models\Client;
use App\Models\ClientBank;
use App\Services\FileStorageService;
use Illuminate\Console\Command;

class ImportClientBankFromCsv extends Command
{
    protected $signature = 'import:client-banks {file : CSV filename in storage/private folder}';
    protected $description = 'Import client bank information from CSV file';

    public function __construct(
        private FileStorageService $fileStorageService
    ) {
        parent::__construct();
    }

    public function handle()
    {
        ini_set('memory_limit', '1G');
        \DB::disableQueryLog();
        \DB::connection()->getPdo()->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);

        $fileName = $this->argument('file');
        $filePath = storage_path('app/private/' . $fileName);

        if (!file_exists($filePath)) {
            $this->error("File not found: {$filePath}");
            return 1;
        }

        $handle = fopen($filePath, 'r');
        $headers = fgetcsv($handle);

        $fieldMapping = [
            'bank_name' => 'bank_name',
            'bank_code' => 'bank_code',
            'fname' => 'holder_name_1',
            'holder2' => 'holder_name_2',
            'holder3' => 'holder_name_3',
            'branch' => 'branch_name',
            'accountno' => 'account_number',
            'micrcode' => 'micrcode',
            'ifsccode' => 'ifsc_code',
            'acct_type_id_name' => 'account_type',
            'opmode_id_name' => 'operation_mode'
        ];

        $successCount = 0;
        $errorCount = 0;
        $notFoundCount = 0;

        $index = 0;
        while (($row = fgetcsv($handle)) !== false) {
            if ($index % 100 === 0) {
                gc_collect_cycles();
                \DB::reconnect();
                $this->info("Processed {$index} rows...");
            }

            $csvData = array_combine($headers, $row);
            if (!$csvData) continue;

            // Find client by PAN number
            if (empty($csvData['panno']) || $csvData['panno'] === 'NULL') {
                $this->error("Row " . ($index + 2) . ": Missing PAN number");
                $errorCount++;
                $index++;
                continue;
            }

            $client = Client::where('pan_no', $csvData['panno'])->first();
            if (!$client) {
                $this->warn("Row " . ($index + 2) . ": Client not found for PAN: " . $csvData['panno']);
                $notFoundCount++;
                $index++;
                continue;
            }

            $mappedData = ['client_id' => $client->id];
            foreach ($fieldMapping as $csvField => $modelField) {
                if (isset($csvData[$csvField]) && $csvData[$csvField] !== 'NULL' && $csvData[$csvField] !== '') {
                    $mappedData[$modelField] = $csvData[$csvField];
                }
            }

            // Truncate fields to match database constraints
            if (isset($mappedData['micrcode'])) {
                $mappedData['micrcode'] = substr($mappedData['micrcode'], 0, 9);
            }
            if (isset($mappedData['account_number'])) {
                $mappedData['account_number'] = substr($mappedData['account_number'], 0, 20);
            }
            if (isset($mappedData['ifsc_code'])) {
                $mappedData['ifsc_code'] = substr($mappedData['ifsc_code'], 0, 11);
            }

            // Set as primary if it's the first bank account for this client
            $mappedData['is_primary'] = !ClientBank::where('client_id', $client->id)->exists();

            try {
                $clientBank = ClientBank::updateOrCreate(
                    [
                        'client_id' => $client->id,
                        'account_number' => $mappedData['account_number'] ?? null,
                    ],
                    $mappedData
                );

                // Store cheque photo if available
                if (isset($csvData['cheque_photo']) && !empty($csvData['cheque_photo']) && $csvData['cheque_photo'] != 'NULL') {
                    $this->fileStorageService->storeExternalClientDocument(
                        $client->id,
                        'https://erp.easylifesolutions.co.in/storage/' . $csvData['cheque_photo'],
                        'cancelled_cheque'
                    );
                    $clientBank->update(['attachment_cancelled_cheque' => $csvData['cheque_photo']]);
                }

                unset($mappedData, $csvData, $row);
                $index++;
                $successCount++;
            } catch (\Exception $e) {
                $this->error("Row " . ($index + 2) . " failed to save: " . $e->getMessage());
                $errorCount++;
                $index++;
            }
        }

        fclose($handle);

        $this->info("Import completed: {$successCount} successful, {$errorCount} failed, {$notFoundCount} clients not found");
        return 0;
    }
}
