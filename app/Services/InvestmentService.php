<?php

namespace App\Services;

use App\Models\Investment;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;

class InvestmentService
{
    public function create(array $data)
    {
        $data = $this->calculateInvestmentParameters($data);

        return $data;
    }

    public function update(Investment $investment, array $data): Investment
    {
        $investment->update($data);
        return $investment->fresh();
    }

    public function delete(Investment $investment): bool
    {
        return $investment->delete();
    }

    public function getAll(): Collection
    {
        return Investment::with(['client', 'scheme'])->get();
    }

    public function getById(int $id): Investment
    {
        return Investment::with(['client', 'scheme'])->findOrFail($id);
    }

    public function getByClient(int $clientId): Collection
    {
        return Investment::with(['client', 'scheme'])
            ->where('client_id', $clientId)
            ->get();
    }

    private function calculateInvestmentParameters(array $data)
    {
        $data['annual_payout'] = ($data['investment_amount'] * ($data['roi_percent'] + $data['additional_roi_percent'] ?? 0)) / 100;

        $data['client_bank_id'] = '';
        $data['company_bank_id'] = '';
        $data['utr_no'] = '';
        $data['remarks'] = '';
        $data['status'] = ['draft', 'active', 'closed', 'matured','cancelled','suspended','renewed'];

        if ($data['frequency'] === 'monthly') {
            $data['payout_per_period'] = $data['annual_payout'] / 12;
            $data['schedule_count'] = $data['tenure_count'] * 12;
        } elseif ($data['frequency'] === 'quarterly') {
            $data['payout_per_period'] = $data['annual_payout'] / 4;
            $data['schedule_count'] = $data['tenure_count'] * 4;
        } elseif ($data['frequency'] === 'half-yearly') {
            $data['payout_per_period'] = $data['annual_payout'] / 2;
            $data['schedule_count'] = $data['tenure_count'] * 2;
        } elseif ($data['frequency'] === 'yearly') {
            $data['payout_per_period'] = $data['annual_payout'];
            $data['schedule_count'] = $data['tenure_count'];
        } else {
            $principal = $data['investment_amount'];
            $rate = ($data['roi_percent'] + $data['additional_roi_percent']) / 100;
            $n = $data['tenure_count'];
            $data['payout_per_period'] = $principal * pow(1 + $rate, $n);
            $data['schedule_count'] = $data['tenure_count'];
        }

        $investmentDate = Carbon::parse($data['investment_date']);

        switch ($data['tenure_type']) {
            case 'months':
                $data['maturity_date'] = $investmentDate->copy()->addMonths((int) $data['tenure_count']);
                break;
            case 'years':
                $data['maturity_date'] = $investmentDate->copy()->addYears((int) $data['tenure_count']);
                break;
            default: // days
                $data['maturity_date'] = $investmentDate->copy()->addDays((int) $data['tenure_count']);
                break;
        }
        $data['maturity_date'] = $data['maturity_date']->subDay();

        switch ($data['frequency']) {
            case 'monthly':
                if ($investmentDate->day < 20) {
                    $data['first_payout_date'] = $investmentDate->copy()->addMonths(1)->startOfMonth();
                } else {
                    $data['first_payout_date'] = $investmentDate->copy()->addMonths(2)->startOfMonth();
                }
                break;
            case 'quarterly':
                $data['first_payout_date'] = $investmentDate->copy()->addMonths(3)->startOfMonth();
                break;
            case 'half-yearly':
                $data['first_payout_date'] = $investmentDate->copy()->addMonths(6)->startOfMonth();
                break;
            case 'yearly':
                $data['first_payout_date'] = $investmentDate->copy()->addYears(1)->startOfMonth();
                break;
            default:
                $data['first_payout_date'] = $data['maturity_date'];
                break;
        }

        $data['payout_schedule'] = [];

        $data['standing_instructions'] = [
            'instrument_type' => 1,
            'instrument_date' => null,
            'reference_no' => null,
            'instrument_amount' => null,
            'company_bank_id' => null,
            'client_bank_id' => null,
            'attachment_instrument_image' => null,
            'effective_date' => null
        ];

        $returnPrincipalWithInterest = false;

        for ($i = 0; $i < $data['schedule_count']; $i++) {
            switch ($data['frequency']) {
                case 'monthly':
                    $payoutDate = Carbon::parse($data['first_payout_date'])->addMonths($i);
                    break;
                case 'quarterly':
                    $payoutDate = Carbon::parse($data['first_payout_date'])->addMonths($i * 3);
                    break;
                case 'half-yearly':
                    $payoutDate = Carbon::parse($data['first_payout_date'])->addMonths($i * 6);
                    break;
                case 'yearly':
                    $payoutDate = Carbon::parse($data['first_payout_date'])->addYears($i);
                    break;
                default:
                    $payoutDate = Carbon::parse($data['maturity_date']);
                    break;
            }

            if ($payoutDate->lessThanOrEqualTo($data['maturity_date'])) {
                $data['payout_schedule'][] = [
                    'payout_date' => $payoutDate->toDateString(),
                    'amount' => round($data['payout_per_period'], 0),
                    'actual_payout_date' => null,
                    'status' => 'pending',
                    'remarks' => null,
                    'actual_payout_amount' => 0,
                    'utr_no' => null,
                    'company_bank_id' => null,
                    'client_bank_id' => null,
                ];
            } else {
                $returnPrincipalWithInterest = true;
                $data['payout_schedule'][] = [
                    'payout_date' => $data['maturity_date']->toDateString(),
                    'amount' => round($data['payout_per_period'] + $data['investment_amount'], 0),
                    'actual_payout_date' => null,
                    'status' => 'pending',
                    'remarks' => null,
                    'actual_payout_amount' => 0,
                    'utr_no' => null,
                    'company_bank_id' => null,
                    'client_bank_id' => null,
                ];
                break;
            }
        }

        if (!$returnPrincipalWithInterest) {
            $data['payout_schedule'][] = [
                'payout_date' => $data['maturity_date']->toDateString(),
                'amount' => round($data['investment_amount'], 0),
                'actual_payout_date' => null,
                'status' => 'pending',
                'remarks' => null,
                'actual_payout_amount' => 0,
                'utr_no' => null,
                'company_bank_id' => null,
                'client_bank_id' => null,
            ];
        }

        return $data;
    }
}
