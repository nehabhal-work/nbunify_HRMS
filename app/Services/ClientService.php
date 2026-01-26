<?php

namespace App\Services;

use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Str;

class ClientService
{
    public function __construct(private FileStorageService $fileStorageService) {}

    public function getAll()
    {
        return Client::with(['createdBy', 'approvedBy', 'families', 'banks', 'approved2By', 'approved3By'])
            ->orderByDesc('id')->get();
    }

    public function getAllApproved()
    {
        return Client::whereNotNull('approved3_by')
            ->with(['createdBy', 'approvedBy', 'families', 'banks', 'approved2By', 'approved3By'])
            ->orderByDesc('id')->get();
    }

    public function getAllExcept(array $clientIds = [])
    {
        return Client::whereNotIn('id', [$clientIds])->get();
    }

    public function find($id)
    {
        // return $id;
        $client = Client::findOrFail($id);
        if (auth()->id() == $client->created_by) {
            $client->is_approved = true;
        } else {
            $user = User::find(auth()->id());
            if ($user->level == 1) {
                $client->is_approved = $client->approved_by != null ? true : false;
            } else if ($user->level == 2 && $client->approved_by != null) {
                $client->is_approved = $client->approved2_by != null ? true : false;
            } else if ($user->level == 3 && $client->approved2_by != null) {
                $client->is_approved = $client->approved3_by != null ? true : false;
            } else {
                $client->is_approved = true;
            }
        }
        return $client;
    }
    public function create(array $data): Client
    {
        $data['client_code'] = $this->generateClientCode();
        $data['created_by'] = auth()->id();
        $client = Client::create($data);
        $data = $this->handleFileUploads($data, $client, 'A');
        $client->update($data);
        return $client;
    }

    public function approve($id)
    {
        $client = Client::findOrFail($id);
        $user = User::find(auth()->id());
        if ($client != null) {
            if ($user->level == 1) {
                $client->approved_by = auth()->id();
                $client->approved_at = now();
                $client->save();
            } else if ($user->level == 2) {
                $client->approved2_by = auth()->id();
                $client->approved2_on = now();
                $client->save();
            } else if ($user->level == 3) {
                $client->approved3_by = auth()->id();
                $client->approved3_on = now();
                $client->save();
            } else {
                return abort(401, 'User level not found');
            }
        } else {
            return abort(404, 'Client Not Found');
        }
    }

    public function update(Client $client, array $data): Client
    {
        $data;
        $data = $this->handleFileUploads($data, $client, 'E');
        $client->update($data);
        return $client->fresh();
    }

    public function delete(Client $client): bool
    {
        $this->deleteFiles($client);
        return $client->delete();
    }

    private function handleFileUploads(array $data, Client $client, string $mode): array
    {
        $fileFields = [
            'attachment_client_photo',
            'attachment_pan',
            'attachment_aadhar_front',
            'attachment_aadhar_back',
            'attachment_signature',
            'attachment_ckyc',
            'attachment_other_documents'
        ];

        if ($mode == 'A') {
            foreach ($fileFields as $field) {
                if (isset($data[$field . '_url'])) {
                    $data[$field] = $this->fileStorageService->storeClientDocument(
                        $client->id,
                        $data[$field . '_url'],
                        str_replace('attachment_', '', $field)
                    );
                }
            }
        } else if ($mode == 'E') {
            foreach ($fileFields as $field) {
                if (isset($data[$field . '_url'])) {
                    if (Str::contains($data[$field . '_url'], 'temp')) {
                        if ($client && $client->$field) {
                            $this->fileStorageService->deleteFile($client->$field);
                        }
                        $data[$field] = $this->fileStorageService->storeClientDocument(
                            $client->id,
                            $data[$field . '_url'],
                            str_replace('attachment_', '', $field)
                        );
                    } else {
                        $data[$field] = $client->$field ?? null;
                    }
                } else {
                    if ($client && $client->$field) {
                        $this->fileStorageService->deleteFile($client->$field);
                    }
                    $data[$field] = null;
                }
            }
        }
        return $data;
    }

    private function deleteFiles(Client $client): void
    {
        $fileFields = [
            'attachment_client_photo',
            'attachment_pan',
            'attachment_aadhar_front',
            'attachment_aadhar_back',
            'attachment_signature',
            'attachment_ckyc',
            'attachment_other_documents'
        ];

        foreach ($fileFields as $field) {
            if ($client->$field) {
                $this->fileStorageService->deleteFile($client->$field);
            }
        }
    }

    public function getBDayList($fromDate, $toDate)
    {
        $fromMonthDay = date('m-d', strtotime($fromDate));
        $toMonthDay = date('m-d', strtotime($toDate));

        $query = Client::whereNotNull('dob')->select('id', 'name', 'dob', 'mobile_no', 'email');

        if ($fromMonthDay <= $toMonthDay) {
            $query->whereRaw('DATE_FORMAT(dob, "%m-%d") BETWEEN ? AND ?', [$fromMonthDay, $toMonthDay]);
        } else {
            $query->whereRaw('DATE_FORMAT(dob, "%m-%d") >= ? OR DATE_FORMAT(dob, "%m-%d") <= ?', [$fromMonthDay, $toMonthDay]);
        }

        if ($fromMonthDay <= $toMonthDay) {
            $query->orderByRaw('MONTH(dob), DAY(dob)');
        } else {
            $query->orderByRaw('CASE WHEN MONTH(dob) >= ? THEN MONTH(dob) ELSE MONTH(dob) + 12 END, DAY(dob)', [date('m', strtotime($fromDate))]);
        }

        return $query->get()->map(function ($client) {
            $today = now();
            $birthDate = $client->dob;
            $thisYearBirthday = $today->copy()->setMonth($birthDate->month)->setDay($birthDate->day);
            $lastYearBirthday = $thisYearBirthday->copy()->subYear();

            $daysDiffThisYear = $today->diffInDays($thisYearBirthday, false);
            $daysDiffLastYear = $today->diffInDays($lastYearBirthday, false);

            if (abs($daysDiffLastYear) < abs($daysDiffThisYear)) {
                $daysDiff = $daysDiffLastYear;
            } else {
                $daysDiff = $daysDiffThisYear;
            }

            if ($daysDiff == 0) {
                $birthdayStatus = 'Today';
            } elseif ($daysDiff == 1) {
                $birthdayStatus = 'Tomorrow';
            } elseif ($daysDiff == -1) {
                $birthdayStatus = 'Yesterday';
            } elseif ($daysDiff > 0) {
                $birthdayStatus = "In {$daysDiff} days";
            } elseif (abs($daysDiff) > 182) {
                $nextBirthday = 365 + $daysDiff;
                $birthdayStatus = "In {$nextBirthday} days";
            } else {
                $birthdayStatus = abs($daysDiff) . " days ago";
            }

            return [
                'id' => $client->id,
                'name' => $client->name,
                'dob' => $client->dob->format('Y-m-d'),
                'age' => abs($today->diffInYears($birthDate)),
                'mobile' => $client->mobile_no,
                'email' => $client->email,
                'birthday_status' => $birthdayStatus
            ];
        });
    }

    public function generateClientCode(): string
    {
        // $currentDate = now();
        // $currentYear = $currentDate->year;
        // $financialYear = $currentDate->month >= 4 ? $currentYear . '-' . ($currentYear + 1) : ($currentYear - 1) . '-' . $currentYear;

        // $baseCode = 'CC/' . $financialYear . '/';
        $baseCode = 'CL';
        $counter = 1;

        do {
            $code = $baseCode . str_pad($counter, 8, '0', STR_PAD_LEFT);
            $counter++;
        } while (Client::where('client_code', $code)->exists());

        return $code;
    }
}
