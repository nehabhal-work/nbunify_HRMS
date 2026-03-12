@extends('layouts.master-layout')
@section('title', 'Investment')
@section('title', 'Investment-create')

@section('content')
    <div>
        @if (session('success'))
            <x-alert-sweet type="success" :message="session('success')" />
        @endif

        @if (session('error'))
            <x-alert-sweet type="danger" :message="session('error')" />
        @endif


    </div>
    @php
        $clientNames = $clients->pluck('name', 'id');
        $schemeNames = $scheme->pluck('scheme_name', 'id'); // adjust column if needed

    @endphp

    <style>
        table td {
            font-weight: bold;

        }

        table.table th {
            background-color: #f9f3fa !important;
        }

        .onecolor {
            color: #BC13BE;
        }
    </style>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- {{ $investment }} --}}
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Master /</span> <a href="{{ route('investment.els.index') }}">ELS-Investment</a>
    </h4>

    <div class="div d-flex justify-content-end mb-3">
        <a href="{{ route('investment.els.index') }}" class="btn btn-secondary px-4">Go back</a>

    </div>

    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <b class="card-title text-warning">Investment Details</b>
                {{-- <h6>Investment code : {{ $investment->investment_code }}</h6> --}}


                <div class="row ">
                    <div class="col-md-12 p-0 m-0">
                        <table class="table table-bordered  investment-view">

                            <tbody>

                                @php
                                    $holders = array_filter([
                                        $investment->first_client_id,
                                        $investment->second_client_id,
                                        $investment->third_client_id,
                                        $investment->fourth_client_id,
                                    ]);
                                @endphp

                                <tr>

                                    <th>Holders</th>
                                    <td class="bg-warning-subtle" colspan="7">
                                        @forelse ($holders as $index => $holderId)
                                            <b>{{ $index + 1 }}. {{ $clientNames[$holderId] ?? '-' }}</b>
                                            @if (!$loop->last)
                                                ,
                                            @endif
                                        @empty
                                            -
                                        @endforelse
                                    </td>

                                </tr>
                            </tbody>

                        </table>
                    </div>
                    <div class="col-md-4 p-0 m-0">
                        <table class="table table-bordered mb-4 investment-view">

                            <tbody>

                                @if ($investment->investment_code)
                                    <tr>
                                        <th>Inv. Code</th>
                                        <td><b>{{ $investment->investment_code }}</b></td>
                                    </tr>
                                @endif
                                @if ($investment->investment_type)
                                    <tr>
                                        <th>Inv. Type</th>
                                        <td><b>{{ ucfirst($investment->investment_type) }}</b></td>
                                    </tr>
                                @endif
                                @if ($investment->actual_interest_amount)
                                    <tr>
                                        <th>Total Interest Amount</th>
                                        <td><b>₹ {{ number_format($investment->actual_interest_amount, 2) }}</b></td>
                                    </tr>
                                @endif
                                @if ($investment->roi_percent !== null)
                                    <tr>
                                        <th>ROI (%)</th>
                                        <td><b>{{ $investment->roi_percent }}%</b></td>
                                    </tr>
                                @endif
                                @if ($investment->frequency)
                                    <tr>
                                        <th>Frequency</th>
                                        <td><b>{{ ucfirst($investment->frequency) }}</b></td>
                                    </tr>
                                @endif
                                @if ($investment->first_payout_date)
                                    <tr>
                                        <th>First Payout Date</th>
                                        <td>
                                            <b>{{ \Carbon\Carbon::parse($investment->first_payout_date)->format('d M Y') }}</b>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>

                        </table>
                    </div>
                    <div class="col-md-4 p-0 m-0">
                        <table class="table table-bordered mb-4 investment-view">

                            <tbody>

                                @if ($investment->investment_date)
                                    <tr>
                                        <th>Inv. Start Date</th>
                                        <td>
                                            <b>{{ \Carbon\Carbon::parse($investment->investment_date)->format('d M Y') }}</b>
                                        </td>

                                    </tr>
                                @endif
                                @if (!empty($schemeNames[$investment->scheme_id]))
                                    <tr>
                                        {{-- {{ $scheme }} --}}
                                        <th>Scheme Name</th>
                                        <td><b>{{ $investment['scheme']['name_type_value'] }} -
                                                {{ $schemeNames[$investment->scheme_id] }}</b>
                                        </td>
                                    </tr>
                                @endif

                                @if ($investment->tenure_count && $investment->tenure_type)
                                    <tr>
                                        <th>Tenure</th>
                                        <td>
                                            <b>{{ $investment->tenure_count }} {{ ucfirst($investment->tenure_type) }}</b>
                                        </td>
                                    </tr>
                                @endif

                                @if ($investment->additional_roi_percent !== null)
                                    <tr>
                                        <th>Additional ROI</th>
                                        <td><b>{{ $investment->additional_roi_percent }}%</b></td>
                                    </tr>
                                @endif

                                @if ($investment->schedule_count)
                                    <tr>
                                        <th>Schedule Count</th>
                                        <td><b>{{ $investment->schedule_count }}</b></td>
                                    </tr>
                                @endif

                            </tbody>

                        </table>
                    </div>
                    <div class="col-md-4 p-0 m-0">
                        <table class="table table-bordered mb-4 investment-view">

                            <tbody>


                                <tr>


                                    @if ($investment->maturity_date)
                                        <th>Inv. End Date</th>
                                        <td>
                                            <b>{{ \Carbon\Carbon::parse($investment->maturity_date)->format('d M Y') }}</b>
                                        </td>
                                    @endif
                                </tr>
                                @if ($investment->investment_amount)
                                    <tr>
                                        <th>Inv. Amount</th>
                                        <td><b>₹ {{ number_format($investment->investment_amount, 2) }}</b></td>
                                    </tr>
                                @endif

                                @if ($investment->lock_in_period)
                                    <tr>
                                        <th>Lock-in Period</th>
                                        <td><b>{{ $investment->lock_in_period }}</b></td>
                                    </tr>
                                @endif

                                @if (!is_null($investment->has_tds))
                                    <tr>
                                        <th>TDS Applicable</th>
                                        <td><b>{{ $investment->has_tds ? 'Yes' : 'No' }}</b></td>
                                    </tr>
                                @endif

                                @if ($investment->payout_per_period)
                                    <tr>
                                        <th>Payout Per Period</th>
                                        <td><b>₹ {{ number_format($investment->payout_per_period, 2) }}</b></td>
                                    </tr>
                                @endif

                            </tbody>

                        </table>
                    </div>
                </div>



                <b class="card-title">Bank / Instrument Details </b>
                <table class="table table-bordered mb-4">
                    <h6 class="text-warning">Client Instrument Details</h6>
                    {{-- Header Row --}}
                    <tr class="bg-warning-subtle">
                        <th>Instrument</th>
                        <th>Instrument Date</th>
                        <th>Reference No</th>
                        <th>Instrument Amount</th>
                        <th>Client Output Bank</th>
                        <th>Instrument Image</th>

                    </tr>

                    {{-- Data Row --}}
                    @forelse($inputBank ?? [] as $b)
                        <tr>
                            <td>{{ $b->instrument_type }}</td>
                            <td>{{ \Carbon\Carbon::parse($b->client_instrument_date)->format('d M Y') }}</td>
                            <td>{{ $b->client_reference_no }}</td>
                            <td>₹ {{ number_format($b->amount, 2) }}</td>
                            <td>{{ $b->fromClientBank?->bank_name ?? '-' }}</td>
                            <td class="value">
                                @if (!empty($b->attachment_instrument))
                                    <a href="{{ $b->attachment_instrument }}" target="_blank"
                                        class="text-primary fw-medium text-decoration-underline">
                                        Click to view
                                    </a>
                                @else
                                    <span class="text-muted">Not available</span>
                                @endif
                            </td>





                        </tr>


                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted">No bank/instrument details available.</td>
                        </tr>
                    @endforelse
                </table>

                {{-- Company Credit Details --}}
                <table class="table table-bordered mb-4">
                    <h6 class="text-warning">Company Credit Details</h6>
                    {{-- Header Row --}}
                    <tr class="bg-warning-subtle">

                        <th>Company Input Bank</th>
                        <th>Credit Date</th>
                        <th>Company Bank Ref No</th>
                        <th>Instrument A mount</th>
                    </tr>

                    {{-- Data Row --}}
                    @forelse($inputBank ?? [] as $b)
                        <tr>

                            <td>{{ $b->toCompanyBank?->bank_name ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($b->company_instrument_date)->format('d M Y') }}</td>
                            <td>{{ $b->company_reference_no }}</td>
                            <td>₹ {{ number_format($b->amount, 2) }}</td>
                        </tr>


                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted">No bank/instrument details available.</td>
                        </tr>
                    @endforelse
                </table>

                <b class="card-title">Outward Bank / Payout Details</b>
                <table class="table table-bordered  mb-4">
                    <tbody>
                        <tr>
                            <th>Company Output Bank</th>
                            <th>Company Output Account No</th>
                            <th>Client Input Bank</th>
                            <th>Client Input Account No</th>
                        </tr>

                        <tr>
                            <td><b>{{ $investment->fromCompanyBank?->bank_name ?? '-' }}</b></td>
                            <td><b>{{ $investment->fromCompanyBank?->account_number ?? '-' }}</b></td>
                            <td><b>{{ $investment->toClientBank?->bank_name ?? '-' }}</b></td>
                            <td><b>{{ $investment->toClientBank?->account_number ?? '-' }}</b></td>
                        </tr>



                    </tbody>

                </table>

                {{-- {{ $investment->nominees }} --}}
                <b class="card-title">Nominee Details </b>
                <table class="table table-bordered mb-4 ">
                    <tbody>
                        <tr>
                            <th width="300">Nominee Name Percentage %</th>
                            <td colspan="3">
                                @php
                                    // Take only first 3 nominees
                                    $nominees = $investment->nominees->take(3);
                                @endphp

                                @foreach ($nominees as $data)
                                    <b>{{ $data->clientFamily->name . ' - ' . $data->percent . '%' }}</b><br>
                                @endforeach
                            </td>
                            <th>Guardian Name</th>
                            <td>
                                @php
                                    // Take only first 3 guardian names if needed
                                    $guardians = $investment->nominees->take(3);
                                @endphp
                                @foreach ($guardians as $data)
                                    <b>{{ $data->guardian_client_family_id ? $data->guardianClientFamily->name : '-' }}</b><br>
                                @endforeach
                            </td>
                        </tr>

                    </tbody>
                </table>
                <div class=" justify-content-end mb-3">
                    <a href="{{ route('investment.payment.schedule.sample') }}" class="btn btn-secondary px-4"
                        data-bs-toggle="tooltip" data-bs-placement="left"
                        title="A standing instruction and payout schedule already exist for this investment. To create a new one, please edit the existing schedule and mark it as inactive.">
                        Downloads Excel file
                    </a>
                </div>
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                        tooltipTriggerList.map(function(tooltipTriggerEl) {
                            return new bootstrap.Tooltip(tooltipTriggerEl)
                        });
                    });
                </script>

                <b class="card-title">Payment Received Schedules</b>

                <table id="payoutTable1" class="table table-bordered nowrap w-100 mb-5">

                    <thead class="table-light">
                        <tr>
                            <th hidden>#</th>
                            <th>Received Date</th>
                            <th class="text-end">received amount (₹)</th>
                            <th>UTR no.</th>
                            <th>From Client Bank A/c</th>
                            <th>To Company Bank A/c</th>
                            <th>Status</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>

                        {{-- ===================== --}}
                        {{-- CREDIT / RECEIVED INVESTMENT ENTRY --}}
                        {{-- ===================== --}}
                        @foreach ($inputBank ?? [] as $key => $b)
                            <tr class="table-light">
                                <td class="d-none">{{ $key + 1 }}</td>
                                <td> {{ \Carbon\Carbon::parse($b->client_instrument_date)->format('d M Y') }} </td>
                                <td class="text-end fw-semibold text-success"> ₹ {{ number_format($b->amount, 2) }}
                                </td>
                                <td> {{ $b->client_reference_no ?? '—' }} </td>
                                <td>{{ $b->fromClientBank->bank_name ?? '-' }}
                                    {{ $b->fromClientBank->account_number ?? '—' }}</td>
                                <td>{{ $b->toCompanyBank->bank_name ?? '-' }}
                                    {{ $b->toCompanyBank->account_number ?? '—' }}</td>

                                <td>
                                    <span class="badge bg-info">Credit</span>
                                </td>

                                <td>
                                    {{ $b->instrument_type }}
                                </td>

                                {{-- <td class="text-center">—</td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- {{ $investment }} --}}
                @if ($investment->has_approved_si === true)
                    <b class="card-title text-warning mb-3">Approved Standing Instruction Details</b>

                    <table class="table table-bordered table-sm mb-5 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Reference No</th>
                                <th>Status</th>
                                <th>Instrument Type</th>
                                <th>Company Output Bank</th>
                                <th>Client Input Bank</th>
                                <th>Payment Start Date</th>
                                <th>Amount</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($investment->approved_standing_instructions as $d)
                                <tr>
                                    <td>1</td>
                                    <td>
                                        <a href="{{ route('investment.si.show', $d->id) }}"
                                            class="fw-semibold text-primary text-decoration-none">
                                            {{ $d->si_number }}
                                        </a>
                                    </td>
                                    <td>
                                        @if ($d->status === 'active')
                                            <span class="badge bg-success text-white">
                                                {{ ucfirst($d->status) }}
                                            </span>
                                        @else
                                            <span class="badge bg-danger text-white">
                                                {{ ucfirst($d->status) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $d->instruction_type }}</td>

                                    <td>{{ $investment->fromCompanyBank->bank_name . ' - ' . $investment->fromCompanyBank->account_number }}
                                    </td>
                                    <td>{{ $investment->ToClientBank->bank_name . ' - ' . $investment->ToClientBank->account_number }}
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($d->si_start_date)->format('d M Y') }}
                                    </td>
                                    <td>{{ $d->si_amount }}</td>

                                </tr>
                            @endforeach


                        </tbody>

                    </table>


                    <b class="card-title mt-3">Payment Schedule</b>
                    <div class="table-responsive">

                        {{-- <table class="table table-bordered "> --}}
                        <table id="payoutTable" class="table table-bordered nowrap w-100">

                            <thead class="table-light">
                                <tr>
                                    <th hidden>#</th>
                                    <th>Payout Date</th>
                                    <th class="text-end">Scheduled (₹)</th>
                                    <th class="text-end">Actual Paid (₹)</th>
                                    <th>Paid Date</th>
                                    <th>UTR no.</th>
                                    <th>From Bank</th>
                                    <th>To Client Bank</th>
                                    <th>Status</th>
                                    <th>Remarks</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                {{-- ===================== --}}
                                {{-- PAYOUT SCHEDULES --}}
                                {{-- ===================== --}}
                                @foreach ($paySchdeule->payoutSchedules as $index => $schedule)
                                    {{-- <h1>{{ $schedule }}</h1> --}}
                                    <tr
                                        class="{{ $schedule->sch_payout_amount == $investment->investment_amount ? 'table-info' : '' }}">

                                        <td class="d-none">
                                            {{ $index + 1 }}
                                        </td>

                                        <td>
                                            {{ \Carbon\Carbon::parse($schedule->sch_payout_date)->format('d M Y') }}
                                        </td>

                                        <td class="text-end fw-semibold">
                                            ₹ {{ number_format($schedule->sch_payout_amount, 2) }}
                                        </td>

                                        <td class="text-end">
                                            {{ $schedule->actual_payout_amount ? '₹ ' . number_format($schedule->actual_payout_amount, 2) : '—' }}
                                        </td>

                                        <td>
                                            {{ $schedule->actual_payout_date ? \Carbon\Carbon::parse($schedule->actual_payout_date)->format('d M Y') : '—' }}
                                        </td>

                                        <td>
                                            {{ $schedule->utr_no ?? '—' }}
                                        </td>

                                        <td>
                                            {{ $schedule->fromCompanyBank->bank_name ?? '-' }}<br>
                                            <small class="text-muted">
                                                {{ $schedule->fromCompanyBank->account_number ?? '' }}
                                            </small>
                                        </td>

                                        <td>
                                            {{ $schedule->toClientBank->bank_name ?? '-' }}<br>
                                            <small class="text-muted">
                                                {{ $schedule->toClientBank->account_number ?? '' }}
                                            </small>
                                        </td>

                                        <td>
                                            @if ($schedule->status === 'done')
                                                <span class="badge bg-success">Paid</span>
                                            @else
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            @endif
                                        </td>

                                        <td>
                                            {{ $schedule->remarks ?? '—' }}
                                        </td>

                                        <td class="text-center">
                                            @if ($schedule->enable_marked_as_paid)
                                                <button class="btn btn-sm btn-outline-success" data-bs-toggle="modal"
                                                    data-bs-target="#markPaidModal" data-id="{{ $schedule->id }}"
                                                    data-amount="{{ $schedule->sch_payout_amount }}"
                                                    data-payout_date="{{ \Carbon\Carbon::parse($schedule->sch_payout_date)->format('Y-m-d\TH:i') }}"
                                                    data-sr_no="{{ $schedule->sr_no }}">
                                                    Mark Paid
                                                </button>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>


                            <tfoot class="table-light">
                                <tr>
                                    <th colspan="1" class="text-end">Total</th>
                                    <th class="text-end">
                                        ₹ {{ number_format($investment->payoutSchedules->sum('sch_payout_amount'), 2) }}
                                    </th>
                                    <th colspan="8"></th>
                                </tr>
                                <tr>
                                    <th colspan="1" class="text-end">Rounding-off</th>
                                    <th class="text-end">
                                        {{ $schedule->rounding_off_amount ? '₹ ' . number_format($schedule->rounding_off_amount, 2) : '—' }}
                                    </th>
                                    <th colspan="8"></th>
                                </tr>
                                <tr>
                                    <td>
                                        <button class="btn btn-outline-success" data-bs-toggle="modal"
                                            data-bs-target="#markPaidModal_payoutScheduleAdd"
                                            data-id="{{ $investment->id }}" data-amount="" data-sr_no="">
                                            Payout Schedule Add
                                        </button>

                                    </td>
                                </tr>
                                @if ($investment->status == 'closed')
                                    <tr>
                                        <td>
                                            <a class="btn btn-outline-info"
                                                href="{{ route('investment.closing.letter.show', $investment->id) }}"
                                                target="_blank">
                                                Send Closing Letter
                                            </a>
                                        </td>

                                        <td>
                                            @if ($investment->closing_letter_sent_at)
                                                Closing letter was sent on
                                                <strong>{{ \Carbon\Carbon::parse($investment->closing_letter_sent_at)->format('d-M-Y') }}</strong>
                                                by <strong>{{ $investment->closing_letter_sent_by }}</strong>
                                                to email ID <strong>{{ $investment->closing_letter_sent_to }}</strong>.
                                            @else
                                                <span class="text-muted">Closing letter has not been sent yet.</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endif

                            </tfoot>

                        </table>
                    </div>
                @else
                    {{-- hide button --}}
                @endif

                <div class="p-3 text-end">
                    @if (!$investment->is_approved)
                        {{-- show approve button --}}
                        <form action="{{ route('investment.approve', $investment->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-success px-4">
                                Approve
                            </button>

                        </form>
                    @else
                        {{-- hide button --}}
                    @endif
                    @if ($investment->is_payout_approved == false)
                        {{-- show approve button --}}
                        <form action="{{ route('investment.approve.payouts', $investment->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-success px-4">
                                Payout Approve
                            </button>

                        </form>
                    @else
                        {{-- hide button --}}
                    @endif
                </div>




            </div>
        </div>
    </div>


    @if ($errors->any() && old('scheme_id'))
        <script>
            $(document).ready(function() {
                $('#scheme_id').trigger('change'); // this will call loadSchemeData()
            });
        </script>
    @endif


    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="modal fade" id="markPaidModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <form method="POST" action="{{ route('investment.payout.mark-paid') }}">
                    @csrf
                    @method('put')

                    <input type="hidden" name="schedule_id" id="schedule_id">

                    <div class="modal-content">
                        <div class="modal-header bg-success-subtle  text-white">
                            <h5 class="modal-title">Mark Payout as Paid</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <div class="row">

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Actual Paid Amount</label>
                                    <input type="number" step="0.01" class="form-control bg-secondary-subtle"
                                        name="actual_payout_amount" id="actual_amount" readonly>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Standing Reference Number</label>
                                    <input type="text" class="form-control bg-secondary-subtle" name="si_number"
                                        id="si_number" readonly
                                        value="{{ optional($investment->standingInstructions()->where('status', 'active')->first())->si_number }}">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Actual Payout Date & Time</label>
                                    <input type="datetime-local" class="form-control" name="actual_payout_date"
                                        id="actual_payout_date" max="2099-12-31T23:59" onkeydown="return false"
                                        onpaste="return false" required>
                                </div>



                                <div class="col-md-4 mb-3">
                                    <label class="form-label">UTR No</label>
                                    <input type="text" class="form-control" name="utr_no" required
                                        pattern="[A-Za-z0-9]+" title="Only letters and numbers are allowed"
                                        oninput="this.value = this.value.replace(/[^A-Za-z0-9]/g, '')">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Extra Charge</label>
                                    <input type="text" class="form-control" name="extra_charge" id="extra_charge">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Reason of Extra Charge</label>

                                    <select class="form-select" name="reason_extra_charge" id="reason_extra_charge">
                                        <option value="">Select Extra Charge</option>
                                        <option value="bank_charges">Bank Charges</option>
                                        <option value="gst">GST</option>
                                        <option value="tds">TDS</option>
                                        <option value="processing_fee">Processing Fee</option>
                                        <option value="penalty">Penalty</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>


                                <div class="col-md-4 mb-3">
                                    <label class="form-label">
                                        reference Image <span class="text-danger">*</span>
                                    </label>

                                    <div class="input-group">
                                        <input type="file"
                                            class="form-control fileInput instrumentImage @error('refImage') is-invalid @enderror"
                                            id="refImage" name="attachment_refImage" accept="image/*,application/pdf"
                                            onchange="uploadTempFile(this, 'refImage')">

                                        <button class="btn btn-outline-danger" type="button"
                                            onclick="document.getElementById('refImage').value = ''">
                                            ✕
                                        </button>
                                    </div>

                                    @error('refImage.0')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror

                                    <input type="hidden" id="attachment_refImage_url" name="attachment_refImage_url"
                                        value="{{ old('attachment_refImage_url') }}">

                                    @if (old('attachment_refImage_url'))
                                        <div id="attachment_refImage_preview"
                                            class="position-relative d-inline-block mt-2">
                                            <img src="{{ old('attachment_refImage_url') }}" width="100"
                                                class="rounded border">

                                            <button type="button"
                                                class="btn btn-sm btn-danger position-absolute top-0 start-100 translate-middle"
                                                onclick="removeImage('attachment_refImage')">
                                                ✕
                                            </button>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Remarks</label>
                                    <textarea class="form-control" name="remarks" id="mark_paid_remarks" rows="3"></textarea>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="modal-footer">
                            <button class="btn btn-success">Confirm Payment</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="markPaidModal_payoutScheduleAdd" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <form method="POST" action="{{ route('investment.payout.schedule.add') }}">
                    @csrf
                    @method('post')

                    <input type="hidden" name="investment_id" id="investment_id_PSA">
                    <input type="hidden" name="from_company_bank_id" value="{{ $investment->fromCompanyBank->id }}">
                    <input type="hidden" name="to_client_bank_id" value="{{ $investment->ToClientBank->id }}">



                    <div class="modal-content">
                        <div class="modal-header bg-success-subtle  text-white">
                            <h5 class="modal-title">Mark extra payout as Paid</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Payout Date & Time</label>
                                    <input type="datetime-local" class="form-control" name="actual_payout_date"
                                        min="{{ now()->format('Y-m-d\TH:i') }}" max="2099-12-31T23:59"
                                        onkeydown="return false" onpaste="return false"
                                        value="{{ now()->format('Y-m-d\TH:i') }}" required>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Actual Paid Amount</label>
                                    <input type="text" step="0.01" class="form-control onlydigit "
                                        name="actual_payout_amount" id="actual_amount" required>
                                </div>


                                <div class="col-md-3 mb-3">
                                    <label class="form-label">UTR No</label>
                                    <input type="text" class="form-control" name="utr_no" required
                                        pattern="[A-Za-z0-9]+" title="Only letters and numbers are allowed"
                                        oninput="this.value = this.value.replace(/[^A-Za-z0-9]/g, '')">
                                </div>



                                <div class="col-md-4 mb-3">
                                    <label class="form-label">
                                        reference Image <span class="text-danger">*</span>
                                    </label>

                                    <div class="input-group">
                                        <input type="file"
                                            class="form-control fileInput instrumentImage @error('refImage') is-invalid @enderror"
                                            id="refImage" name="attachment_refImage" accept="image/*,application/pdf"
                                            onchange="uploadTempFile(this, 'refImage')">

                                        <button class="btn btn-outline-danger" type="button"
                                            onclick="document.getElementById('refImage').value = ''">
                                            ✕
                                        </button>
                                    </div>

                                    @error('refImage.0')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror

                                    <input type="hidden" id="attachment_refImage_url" name="attachment_refImage_url"
                                        value="{{ old('attachment_refImage_url') }}">

                                    @if (old('attachment_refImage_url'))
                                        <div id="attachment_refImage_preview"
                                            class="position-relative d-inline-block mt-2">
                                            <img src="{{ old('attachment_refImage_url') }}" width="100"
                                                class="rounded border">

                                            <button type="button"
                                                class="btn btn-sm btn-danger position-absolute top-0 start-100 translate-middle"
                                                onclick="removeImage('attachment_refImage')">
                                                ✕
                                            </button>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Remarks</label>
                                    <textarea class="form-control" name="remarks" id="mark_paid_remarks" rows="1"></textarea>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="modal-footer">
                            <button class="btn btn-success">Confirm Payment</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            var markPaidModal = document.getElementById('markPaidModal');

            markPaidModal.addEventListener('show.bs.modal', function(event) {

                var button = event.relatedTarget;
                if (!button) return;

                let payoutDate = button.getAttribute('data-payout_date');

                console.log('Payout Date:', payoutDate); // 🔍 DEBUG

                document.getElementById('schedule_id').value =
                    button.getAttribute('data-id');

                document.getElementById('actual_amount').value =
                    button.getAttribute('data-amount');

                document.getElementById('mark_paid_remarks').value =
                    'Payment for SR No. ' + button.getAttribute('data-sr_no');

                let payoutInput = document.getElementById('actual_payout_date');

                // 🔒 restrict earlier dates
                payoutInput.min = payoutDate;

                // 🧠 set default value
                payoutInput.value = payoutDate;
            });
        });
    </script>


    <script>
        var markPaidModalPSA = document.getElementById('markPaidModal_payoutScheduleAdd');
        markPaidModalPSA.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;

            document.getElementById('investment_id_PSA').value = button.getAttribute('data-id');
            // document.getElementById('sch_payout_date').value = button.getAttribute('data-id');
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#payoutTable').DataTable({
                responsive: true,
                pageLength: 10,
                ordering: true,
                autoWidth: false,
                columnDefs: [{
                        responsivePriority: 1,
                        targets: 0
                    }, // #
                    {
                        responsivePriority: 2,
                        targets: 1
                    }, // Payout Date
                    {
                        responsivePriority: 3,
                        targets: 8
                    }, // Status
                    {
                        responsivePriority: 4,
                        targets: -1
                    } // Action
                ]
            });
        });
    </script>
@endpush
