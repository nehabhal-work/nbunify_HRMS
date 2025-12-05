<?php

namespace App\Services;

use App\Models\ClientFamily;

class ClientFamilyService
{

    public function find($id)
    {
        return ClientFamily::findOrFail($id);
    }

    public function create(array $data): ClientFamily
    {
        return ClientFamily::create($data);
    }

    public function update(ClientFamily $clientFamily, array $data): ClientFamily
    {
        $clientFamily->update($data);
        return $clientFamily->fresh();
    }

    public function delete($id): bool
    {
        $clientFamily = ClientFamily::findOrFail($id);
        return $clientFamily->delete();
    }

    public function getByClient(int $clientId): \Illuminate\Database\Eloquent\Collection
    {
        return ClientFamily::where('client_id', $clientId)->with('client', 'relation')->get();
    }

    public function getBDayList($fromDate, $toDate)
    {
        $fromMonthDay = date('m-d', strtotime($fromDate));
        $toMonthDay = date('m-d', strtotime($toDate));

        $query = ClientFamily::whereNotNull('dob')->select('id', 'client_id', 'name', 'dob', 'mobile_no', 'email');

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

        return $query->get()->map(function ($family) {
            $today = now();
            $birthDate = $family->dob;
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
                'id' => $family->id,
                'client_id' => $family->client_id,
                'name' => $family->name,
                'dob' => $family->dob->format('Y-m-d'),
                'age' => abs($today->diffInYears($birthDate)),
                'mobile' => $family->mobile_no,
                'email' => $family->email,
                'birthday_status' => $birthdayStatus
            ];
        });
    }
}
