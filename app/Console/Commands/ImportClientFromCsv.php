<?php

namespace App\Console\Commands;

use App\Models\Client;
use App\Services\FileStorageService;
use Illuminate\Console\Command;

class ImportClientFromCsv extends Command
{
    protected $signature = 'import:clients {file : CSV filename in storage/private folder}';
    protected $description = 'Import clients from CSV file';

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
            'ckyc' => 'ckyc_no',
            'fname' => 'name',
            'dob' => 'dob',
            'gender_id' => 'gender',
            'marital_id' => 'marital_status',
            'panno' => 'pan_no',
            'aadharno' => 'aadhar_no',
            'mobileno' => 'mobile_no',
            'landline' => 'landline_no',
            'wappno' => 'whatsapp_no',
            'emailid' => 'email',
            'occupation_id' => 'occupation',
            'nat_id' => 'nationality',
            'live_status' => 'live_status',
            'dod' => 'dod',
            'resaddrs' => 'res_address',
            'city' => 'res_city',
            'pincode' => 'res_pincode',
            'offaddrs' => 'office_address',
            'notes' => 'remarks'
        ];



        $successCount = 0;
        $errorCount = 0;

        $index = 0;
        while (($row = fgetcsv($handle)) !== false) {
            if ($index % 5 === 0) {
                gc_collect_cycles();
                \DB::reconnect();
                $this->info("Processed {$index} rows...");
            }

            $csvData = array_combine($headers, $row);
            if (!$csvData) continue;

            $mappedData = [];
            foreach ($fieldMapping as $csvField => $modelField) {
                if (isset($csvData[$csvField]) && $csvData[$csvField] !== 'NULL' && $csvData[$csvField] !== '') {
                    $mappedData[$modelField] = $csvData[$csvField];
                }
            }

            if (isset($mappedData['gender'])) {
                $mappedData['gender'] = match($mappedData['gender']) {
                    '1' => 'male',
                    '2' => 'female',
                    default => 'other'
                };
            }

            if (isset($mappedData['marital_status'])) {
                $mappedData['marital_status'] = match($mappedData['marital_status']) {
                    '1' => 'single',
                    '2' => 'married',
                    '3' => 'divorced',
                    '4' => 'widowed',
                    default => null
                };
            }

            if (isset($mappedData['occupation'])) {
                $mappedData['occupation'] = match($mappedData['occupation']) {
                    '1' => 'private_sector',
                    '2' => 'public_sector',
                    '3' => 'government',
                    '4' => 'business',
                    '5' => 'professional',
                    '6' => 'agriculture',
                    '7' => 'retired',
                    '8' => 'housewife',
                    '9' => 'other',
                    '10' => 'student',
                    '11' => 'other',
                    '12' => 'doctor',
                    '13' => 'eduation',
                    default => null
                };
            }

            if (isset($mappedData['nationality'])) {
                $mappedData['nationality'] = match($mappedData['nationality']) {
                    '1' => 'ri',
                    '2' => 'nro',
                    '3' => 'nre',
                    '4' => 'oci',
                    '5' => 'gch',
                    '6' => 'trioc',
                    '7' => 'fn',
                    '8' => 'other',
                    default => null
                };
            }

            if (isset($mappedData['aadhar_no'])) {
                $mappedData['aadhar_no'] = substr($mappedData['aadhar_no'], 0, 12);
            }

            if (isset($mappedData['mobile_no'])) {
                $mappedData['mobile_no'] = substr($mappedData['mobile_no'], 0, 15);
            }

            if (isset($mappedData['whatsapp_no'])) {
                $mappedData['whatsapp_no'] = substr($mappedData['whatsapp_no'], 0, 15);
            }

            if (isset($mappedData['pan_no'])) {
                $mappedData['pan_no'] = substr($mappedData['pan_no'], 0, 10);
            }

            if (isset($mappedData['res_pincode'])) {
                $mappedData['res_pincode'] = substr($mappedData['res_pincode'], 0, 6);
            }

            if (isset($mappedData['dob'])) {
                $date = \DateTime::createFromFormat('Y-m-d', $mappedData['dob']);
                if (!$date || $date->format('Y') < 1900) {
                    unset($mappedData['dob']);
                }
            }

            if (isset($mappedData['dod'])) {
                $date = \DateTime::createFromFormat('Y-m-d', $mappedData['dod']);
                if (!$date || $date->format('Y') < 1900) {
                    unset($mappedData['dod']);
                }
            }

            try {
                $mappedData['client_code'] = 'CL' . str_pad((Client::max('id') + 1), 8, '0', STR_PAD_LEFT);
                $client = Client::create($mappedData);

                if (isset($csvData['userimg']) && !empty($csvData['userimg']) && $csvData['userimg'] != 'NULL') {
                    $this->fileStorageService->storeExternalClientDocument($client->id,'https://erp.easylifesolutions.co.in/storage/'. $csvData['userimg'], 'client_photo');
                }
                if (isset($csvData['pancardimg']) && !empty($csvData['pancardimg']) && $csvData['pancardimg'] != 'NULL') {
                    $this->fileStorageService->storeExternalClientDocument($client->id,'https://erp.easylifesolutions.co.in/storage/'. $csvData['pancardimg'], 'pan');
                }
                if (isset($csvData['aadharfronimg']) && !empty($csvData['aadharfronimg']) && $csvData['aadharfronimg'] != 'NULL') {
                    $this->fileStorageService->storeExternalClientDocument($client->id,'https://erp.easylifesolutions.co.in/storage/'. $csvData['aadharfronimg'], 'aadhar_front');
                }
                if (isset($csvData['aadharbackimg']) && !empty($csvData['aadharbackimg']) && $csvData['aadharbackimg'] != 'NULL') {
                    $this->fileStorageService->storeExternalClientDocument($client->id,'https://erp.easylifesolutions.co.in/storage/'. $csvData['aadharbackimg'], 'aadhar_back');
                }
                if (isset($csvData['signimg']) && !empty($csvData['signimg']) && $csvData['signimg'] != 'NULL') {
                    $this->fileStorageService->storeExternalClientDocument($client->id,'https://erp.easylifesolutions.co.in/storage/'. $csvData['signimg'], 'signature');
                }
                if (isset($csvData['img_ckyc']) && !empty($csvData['img_ckyc']) && $csvData['img_ckyc'] != 'NULL') {
                    $this->fileStorageService->storeExternalClientDocument($client->id,'https://erp.easylifesolutions.co.in/storage/'. $csvData['img_ckyc'], 'ckyc');
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

        $this->info("Import completed: {$successCount} successful, {$errorCount} failed");
        return 0;
    }
}
