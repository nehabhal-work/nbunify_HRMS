<?php

namespace App\Services;

use App\Models\Investment;
use App\Models\InvestmentInputBank;
use App\Models\InvestmentNominee;
use App\Models\InvestmentPayoutSchedule;
use App\Models\InvestmentSi;
use App\Models\SchemeMaster;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class InvestmentService
{
    public function __construct(private FileStorageService $fileStorageService) {}

    public function create(array $data)
    {
        // Transform form data to expected structure
        $data = $this->transformFormData($data);

        // Validate all data before starting transaction
        $this->validateInvestmentData($data);
        if (isset($data['input_banks']) && ! empty($data['input_banks'])) {
            $this->validateInputBanks($data['input_banks']);
        }
        if (isset($data['nominees']) && ! empty($data['nominees'])) {
            $this->validateNominees($data['nominees']);
        }
        if (isset($data['standing_instructions']) && ! empty($data['standing_instructions'])) {
            $this->validateStandingInstructions($data['standing_instructions']);
        }

        $data = $this->calculateInvestmentParameters($data);

        // Add maker checker fields
        $data['created_by'] = auth()->id();

        // Extract only fillable fields for Investment model
        $investmentData = [
            'investment_code' => null,
            'investment_date' => $data['investment_date'],
            'investment_type' => $data['investment_type'],
            'first_client_id' => $data['first_client_id'],
            'second_client_id' => $data['second_client_id'] ?? null,
            'third_client_id' => $data['third_client_id'] ?? null,
            'fourth_client_id' => $data['fourth_client_id'] ?? null,
            'scheme_id' => $data['scheme_id'],
            'investment_amount' => $data['investment_amount'],
            'tenure_type' => $data['tenure_type'],
            'tenure_count' => $data['tenure_count'],
            'frequency' => $data['frequency'],
            'roi_percent' => $data['roi_percent'],
            'additional_roi_percent' => $data['additional_roi_percent'] ?? 0,
            'has_tds' => $data['has_tds'] ?? false,
            'from_company_bank_id' => $data['from_company_bank_id'],
            'to_client_bank_id' => $data['to_client_bank_id'],
            'schedule_count' => $data['schedule_count'],
            'annual_payout' => $data['annual_payout'],
            'payout_per_period' => $data['payout_per_period'],
            'maturity_date' => $data['maturity_date'],
            'first_payout_date' => $data['first_payout_date'],
            'last_payout_date' => $data['last_payout_date'],
            'actual_interest_amount' => $data['actual_interest_amount'],
            'paid_interest_amount' => $data['paid_interest_amount'],
            'rounding_off_amount' => $data['rounding_off_amount'],
            'early_payout' => $data['early_payout'] ?? false,
            'status' => $data['status'] ?? 'open',
            'remarks' => $data['remarks'] ?? null,
            'action_status' => $data['action_status'] ?? 'new',
            'exit_load_percent' => $data['exit_load_percent'] ?? 0,
            'lock_in_period' => $data['lock_in_period'] ?? 0,
            'lock_in_period_type' => $data['lock_in_period_type'] ?? 'months',
            'created_by' => $data['created_by'],
        ];

        return DB::transaction(function () use ($investmentData, $data) {
            $investment = Investment::create($investmentData);

            // Handle TDS attachment after investment creation
            if (isset($data['attachment_tds_url']) && $data['attachment_tds_url']) {
                $investment->attachment_tds = $this->fileStorageService->storeInvestmentDocument(
                    $investment->id,
                    $data['attachment_tds_url'],
                    'tds'
                );
                $investment->save();
            }

            // Create input banks
            if (isset($data['input_banks'])) {
                foreach ($data['input_banks'] as $inputBank) {
                    if (isset($inputBank['attachment_instrument_url'])) {
                        $inputBank['attachment_instrument'] = $this->fileStorageService->storeInvestmentDocument(
                            $investment->id,
                            $inputBank['attachment_instrument_url'],
                            'instruments'
                        );
                        unset($inputBank['attachment_instrument_url']); // Remove URL after processing
                    }
                    InvestmentInputBank::create(array_merge($inputBank, ['investment_id' => $investment->id]));
                }
            }

            // Create nominees
            if (isset($data['nominees'])) {
                foreach ($data['nominees'] as $nominee) {
                    InvestmentNominee::create(array_merge($nominee, ['investment_id' => $investment->id]));
                }
            }

            // Create standing instructions
            if (isset($data['standing_instructions'])) {
                $siData = $data['standing_instructions'];
                if (isset($siData['attachment_si_image_url'])) {
                    $siData['attachment_si_image'] = $this->fileStorageService->storeInvestmentDocument(
                        $investment->id,
                        $siData['attachment_si_image_url'],
                        'si'
                    );
                    unset($siData['attachment_si_image_url']); // Remove URL after processing
                }
                if (isset($siData['attachment_notes_image_url'])) {
                    $siData['attachment_notes_image'] = $this->fileStorageService->storeInvestmentDocument(
                        $investment->id,
                        $siData['attachment_notes_image_url'],
                        'notes'
                    );
                    unset($siData['attachment_notes_image_url']); // Remove URL after processing
                }
                InvestmentSi::create(array_merge($siData, ['investment_id' => $investment->id]));
            }

            // Create payout schedules
            foreach ($data['payout_schedule'] as $schedule) {
                InvestmentPayoutSchedule::create([
                    'investment_id' => $investment->id,
                    'sch_payout_date' => $schedule['payout_date'],
                    'sch_payout_amount' => $schedule['amount'],
                    'actual_payout_date' => null,
                    'status' => $schedule['status'],
                    'remarks' => null,
                    'actual_payout_amount' => null,
                    'utr_no' => null,
                    'from_company_bank_id' => $data['from_company_bank_id'],
                    'to_client_bank_id' => $data['to_client_bank_id'],
                ]);
            }

            return array_merge($data, ['investment' => $investment]);
        });
    }

    public function update(Investment $investment, array $data): Investment
    {
        $calculationFields = ['investment_date', 'investment_amount', 'tenure_type', 'tenure_count', 'frequency', 'roi_percent'];

        $needsRecalculation = false;
        foreach ($calculationFields as $field) {
            if (isset($data[$field]) && $data[$field] != $investment->$field) {
                $needsRecalculation = true;
                break;
            }
        }

        if ($needsRecalculation) {
            $calculationData = array_merge($investment->toArray(), $data);
            $calculatedData = $this->calculateInvestmentParameters($calculationData);

            $data = array_merge($data, [
                'annual_payout' => $calculatedData['annual_payout'],
                'payout_per_period' => $calculatedData['payout_per_period'],
                'schedule_count' => $calculatedData['schedule_count'],
                'maturity_date' => $calculatedData['maturity_date'],
                'first_payout_date' => $calculatedData['first_payout_date'],
                'last_payout_date' => $calculatedData['last_payout_date'],
                'actual_interest_amount' => $calculatedData['actual_interest_amount'],
                'paid_interest_amount' => $calculatedData['paid_interest_amount'],
                'rounding_off_amount' => $calculatedData['rounding_off_amount'],
                'early_payout' => $calculatedData['early_payout'] ?? false,
            ]);

            if (isset($calculatedData['payout_schedule'])) {
                DB::transaction(function () use ($investment, $data, $calculatedData) {
                    $investment->payoutSchedules()->delete();

                    foreach ($calculatedData['payout_schedule'] as $schedule) {
                        InvestmentPayoutSchedule::create([
                            'investment_id' => $investment->id,
                            'sch_payout_date' => $schedule['payout_date'],
                            'sch_payout_amount' => $schedule['amount'],
                            'actual_payout_date' => null,
                            'status' => $schedule['status'],
                            'remarks' => null,
                            'actual_payout_amount' => null,
                            'utr_no' => null,
                            'from_company_bank_id' => $investment->from_company_bank_id,
                            'to_client_bank_id' => $investment->to_client_bank_id,
                        ]);
                    }

                    $investment->update($data);
                });
            } else {
                $investment->update($data);
            }
        } else {
            $investment->update($data);
        }

        return $investment->fresh();
    }

    public function delete(Investment $investment): bool
    {
        return $investment->delete();
    }

    public function getAll(): Collection
    {
        return Investment::with(['firstClient', 'secondClient', 'thirdClient', 'fourthClient', 'scheme', 'fromCompanyBank', 'toClientBank', 'createdBy', 'approvedBy', 'approved2By', 'approved3By', 'approved4By', 'standingInstructions'])
            ->orderByDesc('id')->get();
    }

    public function getAllWithFilters(array $filters = []): Collection
    {
        $query = Investment::with(['firstClient', 'secondClient', 'thirdClient', 'fourthClient', 'scheme', 'fromCompanyBank', 'toClientBank', 'createdBy', 'approvedBy', 'approved2By', 'approved3By', 'approved4By', 'standingInstructions']);

        if (! empty($filters['from_date'])) {
            $query->whereDate('investment_date', '>=', $filters['from_date']);
        }

        if (! empty($filters['to_date'])) {
            $query->whereDate('investment_date', '<=', $filters['to_date']);
        }

        if (! empty($filters['scheme_id'])) {
            $query->where('scheme_id', $filters['scheme_id']);
        }

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (! empty($filters['action_status'])) {
            $query->where('action_status', $filters['action_status']);
        }

        if (! empty($filters['client_search'])) {
            $query->whereHas('firstClient', function ($q) use ($filters) {
                $q->where('name', 'like', '%'.$filters['client_search'].'%');
            });
        }

        return $query->orderByDesc('id')->get();
    }

    public function getById(int $id): Investment
    {
        $investment = Investment::with([
            'firstClient',
            'secondClient',
            'thirdClient',
            'fourthClient',
            'scheme',
            'fromCompanyBank',
            'toClientBank.client',
            'createdBy',
            'approvedBy',
            'approved2By',
            'approved3By',
            'approved4By',
            'nominees.clientFamily',
            'InvestmentInputBank',
        ])->findOrFail($id);

        $hasStanding = $investment->standingInstructions()
            ->whereNotNull('approved_by')
            ->where('instruction_type', 'standing')
            ->where('status', 'active')
            ->exists();

        // TODO: If last payout date starts with 01 then we can consider hasScheduled as true otherwise we need to check payout schedule table for any approved standing instruction and if exists then we can consider hasScheduled as true
        $hasScheduled = $investment->last_payout_date && str_starts_with($investment->last_payout_date->format('d'), '01')
            ? true
            : $investment->standingInstructions()
                ->whereNotNull('approved_by')
                ->where('instruction_type', 'schedule')
                ->where('status', 'active')
                ->exists();

        $investment->has_approved_si = $hasStanding && $hasScheduled;

        if ($investment->has_approved_si && $investment->approved4_by == null) {
            $investment->is_payout_approved = false;
        } else {
            $investment->is_payout_approved = true;
        }

        if ($investment->has_approved_si) {
            $investment->approved_standing_instructions = $investment->standingInstructions()
                ->whereNotNull('approved_by')
                ->where('status', 'active')
                ->get();
        } else {
            $investment->approved_standing_instructions = null;
        }

        if (auth()->id() == $investment->created_by) {
            $investment->is_approved = true;
        } else {
            $user = User::find(auth()->id());
            if ($user->level == 1) {
                $investment->is_approved = $investment->approved_by != null;
            } elseif ($user->level == 2 && $investment->approved_by != null) {
                $investment->is_approved = $investment->approved2_by != null;
            } elseif ($user->level == 3 && $investment->approved2_by != null) {
                $investment->is_approved = $investment->approved3_by != null;
            } else {
                $investment->is_approved = true;
            }
        }

        return $investment;
    }

    public function getPaymentSchedule(int $id): Investment
    {
        $payschedule = Investment::with(['payoutSchedules.fromCompanyBank', 'payoutSchedules.toClientBank'])->findOrFail($id);

        // Add serial numbers to payout schedules
        $totalSchedules = $payschedule->payoutSchedules->count();
        $payschedule->payoutSchedules->each(function ($schedule, $index) use ($totalSchedules, $payschedule) {
            $schedule->sr_no = ($index + 1).'/'.$totalSchedules;
            // If the previous schedule is paid, enable marking this as paid else disable
            if ($index === 0) {
                // First schedule can always be marked as paid
                $schedule->enable_marked_as_paid = $schedule->status !== 'done';
            } else {
                // Check if previous schedule is paid
                $previousSchedule = $payschedule->payoutSchedules[$index - 1];
                $schedule->enable_marked_as_paid = $previousSchedule->status === 'done' && $schedule->status !== 'done';
            }
        });

        return $payschedule;
    }

    //  public function getBankInstrument(int $id): Investment
    // {
    //     $bankInstrument = Investment::with(['standingInstructions'])->findOrFail($id);

    //     return $bankInstrument;
    // }

    public function getByClient(int $clientId): Collection
    {
        return Investment::with(['firstClient', 'secondClient', 'thirdClient', 'fourthClient', 'scheme', 'fromCompanyBank', 'toClientBank'])
            ->where('first_client_id', $clientId)
            ->orWhere('second_client_id', $clientId)
            ->orWhere('third_client_id', $clientId)
            ->orWhere('fourth_client_id', $clientId)
            ->get();
    }

    public function calculateInvestmentParameters(array $data)
    {
        // CALCULATE ANNUAL PAYOUT
        $data['annual_payout'] = ($data['investment_amount'] * ($data['roi_percent'])) / 100;
        $investmentDate = Carbon::parse($data['investment_date']);

        // NOW CALCULATE MATURITY DATE
        switch ($data['tenure_type']) {
            case 'months':
                $data['maturity_date'] = $investmentDate->copy()->addMonths((int) $data['tenure_count']);
                break;
            case 'years':
                $data['maturity_date'] = $investmentDate->copy()->addYears((int) $data['tenure_count']);
                break;
            default:
                $data['maturity_date'] = $investmentDate->copy()->addDays((int) $data['tenure_count']);
                break;
        }
        $data['maturity_date'] = $data['maturity_date']->subDay();

        $frequencyMap = [
            'monthly' => ['divisor' => 12, 'months_multiplier' => 1, 'years_multiplier' => 12, 'add_months' => 1],
            'quarterly' => ['divisor' => 4, 'months_multiplier' => 1 / 3, 'years_multiplier' => 4, 'add_months' => 3],
            'half-yearly' => ['divisor' => 2, 'months_multiplier' => 1 / 6, 'years_multiplier' => 2, 'add_months' => 6],
            'yearly' => ['divisor' => 1, 'months_multiplier' => 1 / 12, 'years_multiplier' => 1, 'add_years' => 1],
        ];

        // CALCULATE PAYOUT PER PERIOD, SCHEDULE COUNT AND FIRST PAYOUT DATE
        if ($data['tenure_type'] == 'days') {
            // FOR DAILY TENURE, WE ASSUME LUMP SUM PAYMENT AT MATURITY
            $data['annual_payout'] = $data['annual_payout'] + $data['investment_amount'];
            $data['payout_per_period'] = $data['annual_payout'];
            $data['schedule_count'] = 1;
            $data['first_payout_date'] = $data['maturity_date'];
            $data['last_payout_date'] = $data['maturity_date'];
        } elseif (isset($frequencyMap[$data['frequency']])) {
            // FOR REGULAR FREQUENCY PAYOUTS
            $config = $frequencyMap[$data['frequency']];
            $data['payout_per_period'] = $data['annual_payout'] / $config['divisor'];
            $data['schedule_count'] = $data['tenure_type'] == 'months'
                ? $data['tenure_count'] * $config['months_multiplier']
                : $data['tenure_count'] * $config['years_multiplier'];
            if ($data['frequency'] == 'monthly') {
                $data['first_payout_date'] = $investmentDate->day < 20
                    ? $investmentDate->copy()->addMonths(1)->startOfMonth()
                    : $investmentDate->copy()->addMonths(2)->startOfMonth();
            } elseif (isset($config['add_years'])) {
                $data['first_payout_date'] = $investmentDate->copy()->addYears($config['add_years'])->startOfMonth();
            } else {
                $data['first_payout_date'] = $investmentDate->copy()->addMonths($config['add_months'])->startOfMonth();
            }
        } else {
            // FOR COMPOUNDING FREQUENCY WE ASSUME THE TENURE IS IN YEARS
            $principal = $data['investment_amount'];
            $rate = $data['roi_percent'] / 100;
            $data['payout_per_period'] = $principal * pow(1 + $rate, $data['tenure_count']);
            $data['schedule_count'] = 1;
            $data['first_payout_date'] = $data['maturity_date'];
            $data['last_payout_date'] = $data['maturity_date'];
        }
        $data['payout_schedule'] = [];
        $data['early_payout'] = false;

        if ($data['schedule_count'] == 1) {
            $data['last_payout_date'] = $data['first_payout_date'];
            $data['payout_schedule'][] = [
                'payout_date' => $data['maturity_date']->toDateString(),
                'amount' => round($data['payout_per_period'], 0),
                'actual_payout_date' => null,
                'status' => 'pending',
                'remarks' => null,
                'actual_payout_amount' => 0,
                'utr_no' => null,
                'company_bank_id' => null,
                'client_bank_id' => null,
            ];

            $data['actual_interest_amount'] = $data['payout_per_period'] - $data['investment_amount'];
            $data['paid_interest_amount'] = $data['actual_interest_amount'];

            $data['rounding_off_amount'] = 0;

        } else {
            $lastPayoutDate = null;
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

                if ($payoutDate->lessThan($data['maturity_date'])) {
                    $lastPayoutDate = $payoutDate;
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
                    $data['early_payout'] = true;
                    break;
                }
            }

            $data['actual_interest_amount'] = $data['payout_per_period'] * $data['schedule_count'];
            $data['paid_interest_amount'] = round($data['payout_per_period'], 0) * $data['schedule_count'];

            $data['rounding_off_amount'] = $data['actual_interest_amount'] - $data['paid_interest_amount'];

            if ($data['early_payout']) {
                $lastPayoutDate = $data['maturity_date'];
                $data['payout_schedule'][] = [
                    'payout_date' => $data['maturity_date']->toDateString(),
                    'amount' => round($data['payout_per_period'] + $data['rounding_off_amount'], 0),
                    'actual_payout_date' => null,
                    'status' => 'pending',
                    'remarks' => null,
                    'actual_payout_amount' => 0,
                    'utr_no' => null,
                    'company_bank_id' => null,
                    'client_bank_id' => null,
                ];
            }
            $data['last_payout_date'] = $lastPayoutDate ?? $data['maturity_date'];
        }

        return $data;
    }

    public function approvePayouts($id)
    {
        $investment = Investment::findOrFail($id);

        if ($investment->approved3_by == null) {
            throw new \Exception('Investment must be approved level 3 before approving payouts.');
        }
        if ($investment->approved4_by != null) {
            throw new \Exception('Investment payouts are already approved.');
        }
        $investment->approved4_by = auth()->id();
        $investment->approved4_on = now();
        $investment->save();
    }

    public function approve($id)
    {
        $investment = Investment::findOrFail($id);
        $user = User::find(auth()->id());
        if ($investment != null) {
            if ($user->level == 1 && $investment->approved_by == null) {
                $investment->approved_by = auth()->id();
                $investment->approved_at = now();
                $investment->save();
            } elseif ($user->level == 2 && $investment->approved2_by == null) {
                $investment->approved2_by = auth()->id();
                $investment->approved2_on = now();
                $investment->save();
            } elseif ($user->level == 3 && $investment->approved3_by == null) {
                $investment->approved3_by = auth()->id();
                $investment->approved3_on = now();
                $investment->investment_code = $this->generateInvestmentCode($investment->scheme_id);
                $investment->save();
            } else {
                return abort(401, 'User level not found');
            }
        } else {
            return abort(404, 'Investment Not Found');
        }
    }

    private function validateInvestmentData(array $data): void
    {
        $required = ['investment_date', 'investment_type', 'first_client_id', 'scheme_id', 'investment_amount', 'tenure_type', 'tenure_count', 'frequency', 'roi_percent', 'from_company_bank_id', 'to_client_bank_id'];

        foreach ($required as $field) {
            if (! isset($data[$field]) || empty($data[$field])) {
                throw new \InvalidArgumentException("Required field '{$field}' is missing or empty.");
            }
        }

        $scheme = SchemesMaster::findOrFail($data['scheme_id']);
        $amount = $data['investment_amount'];

        if ($amount < $scheme->min_investment || $amount > $scheme->max_investment) {
            throw new \InvalidArgumentException("Investment amount must be between {$scheme->min_investment} and {$scheme->max_investment}.");
        }

        if ($scheme->investment_denomination > 0 && $amount % $scheme->investment_denomination !== 0) {
            throw new \InvalidArgumentException("Investment amount must be in multiples of {$scheme->investment_denomination}.");
        }
    }

    private function validateInputBanks(array $inputBanks): void
    {
        foreach ($inputBanks as $index => $inputBank) {
            $required = ['from_client_bank_id', 'to_company_bank_id', 'instrument_type', 'client_instrument_date', 'amount', 'company_instrument_date'];

            foreach ($required as $field) {
                if (! isset($inputBank[$field]) || ($inputBank[$field] === '' || $inputBank[$field] === null)) {
                    throw new \InvalidArgumentException("Required field '{$field}' is missing in input bank #{$index}.");
                }
            }

            // Attachment is optional but if provided should not be empty
            if (isset($inputBank['attachment_instrument_url']) && $inputBank['attachment_instrument_url'] === '') {
                throw new \InvalidArgumentException("Attachment URL cannot be empty in input bank #{$index}.");
            }
        }
    }

    private function validateNominees(array $nominees): void
    {
        $totalPercent = 0;

        foreach ($nominees as $index => $nominee) {
            // Only client_family_id and percent are required
            $required = ['client_family_id', 'percent'];

            foreach ($required as $field) {
                if (! isset($nominee[$field]) || ($nominee[$field] === '' || $nominee[$field] === null)) {
                    throw new \InvalidArgumentException("Required field '{$field}' is missing in nominee #{$index}.");
                }
            }

            // Guardian is optional but must be valid if provided
            if (isset($nominee['guardian_client_family_id']) && $nominee['guardian_client_family_id'] === '') {
                throw new \InvalidArgumentException("Guardian client family ID cannot be empty in nominee #{$index}.");
            }

            $totalPercent += (float) $nominee['percent'];
        }

        if (abs($totalPercent - 100) > 0.01) {
            throw new \InvalidArgumentException("Total nominee percentage must equal 100%. Current total: {$totalPercent}%");
        }
    }

    private function validateStandingInstructions(array $siData): void
    {
        $required = ['si_number', 'si_client_bank_id', 'si_company_bank_id', 'si_start_date', 'si_amount', 'si_no_of_payments'];

        foreach ($required as $field) {
            if (! isset($siData[$field]) || ($siData[$field] === '' || $siData[$field] === null)) {
                throw new \InvalidArgumentException("Required field '{$field}' is missing in standing instructions.");
            }
        }
    }

    private function transformFormData(array $data): array
    {
        // Transform input banks from arrays to structured format
        if (isset($data['instrument']) && is_array($data['instrument'])) {
            $data['input_banks'] = [];
            $count = count($data['instrument']);

            for ($i = 0; $i < $count; $i++) {
                if (! empty($data['instrument'][$i])) {
                    // Handle file upload - store temporarily and get URL
                    $attachmentUrl = null;
                    if (isset($data['instrumentImage'][$i]) && $data['instrumentImage'][$i]) {
                        $file = $data['instrumentImage'][$i];
                        if ($file instanceof \Illuminate\Http\UploadedFile) {
                            // Store file temporarily and get URL
                            $tempPath = $file->store('temp/instruments', 'public');
                            $attachmentUrl = asset('storage/'.$tempPath);
                        }
                    }

                    $data['input_banks'][] = [
                        'from_client_bank_id' => $data['client_output_bank'][$i] ?? null,
                        'to_company_bank_id' => $data['company_bank_id'][$i] ?? null,
                        'instrument_type' => $data['instrument'][$i],
                        'client_instrument_date' => $data['instrument_date'][$i] ?? null,
                        'client_reference_no' => $data['reference_no'][$i] ?? null,
                        'amount' => $data['instrument_amt'][$i] ?? null,
                        'attachment_instrument_url' => $attachmentUrl,
                        'company_reference_no' => $data['company_reference_no'][$i] ?? null,
                        'company_instrument_date' => $data['effective_date'][$i] ?? null,
                    ];
                }
            }

            // Clean up array fields
            unset(
                $data['instrument'],
                $data['instrument_date'],
                $data['reference_no'],
                $data['instrument_amt'],
                $data['client_output_bank'],
                $data['instrumentImage'],
                $data['company_bank_id'],
                $data['effective_date'],
                $data['company_reference_no']
            );
        }

        // Transform nominees from arrays to structured format
        if (isset($data['client_family_id']) && is_array($data['client_family_id'])) {
            $data['nominees'] = [];
            $count = count($data['client_family_id']);

            for ($i = 0; $i < $count; $i++) {
                if (! empty($data['client_family_id'][$i])) {
                    $nominee = [
                        'client_family_id' => $data['client_family_id'][$i],
                        'percent' => $data['percent'][$i] ?? 0,
                    ];

                    // Only add guardian if provided and not empty
                    if (isset($data['guardian_client_family_id'][$i]) && ! empty($data['guardian_client_family_id'][$i])) {
                        $nominee['guardian_client_family_id'] = $data['guardian_client_family_id'][$i];
                    } else {
                        // Default to self if no guardian provided
                        $nominee['guardian_client_family_id'] = $data['client_family_id'][$i];
                    }

                    $data['nominees'][] = $nominee;
                }
            }

            // Clean up array fields
            unset($data['client_family_id'], $data['guardian_client_family_id'], $data['percent']);
        }

        // Handle TDS attachment file upload
        if (isset($data['attachment_tds']) && $data['attachment_tds'] instanceof \Illuminate\Http\UploadedFile) {
            $tempPath = $data['attachment_tds']->store('temp/tds', 'public');
            $data['attachment_tds_url'] = asset('storage/'.$tempPath);
            unset($data['attachment_tds']);
        }

        return $data;
    }

    private function generateInvestmentCode(int $schemeId): string
    {
        $scheme = \App\Models\SchemesMaster::findOrFail($schemeId);
        $baseCode = $scheme->scheme_code;
        $counter = 1;

        do {
            $code = $baseCode.str_pad($counter, 3, '0', STR_PAD_LEFT);
            $counter++;
        } while (Investment::where('investment_code', $code)->exists());

        return $code;
    }
}
