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

    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Master /</span> <a href="{{ route('investment.els.index') }}">ELS-Investment</a>
    </h4>

    <div class="div d-flex justify-content-end mb-3">
        <a href="{{ route('investment.els.index') }}" class="btn btn-secondary px-4">Go back</a>

    </div>

    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Investment Details</h5>
                {{-- <h6>Investment code : {{ $investment->investment_code }}</h6> --}}

                <table class="table table-bordered mb-4 investment-view">

                    <tbody>
                        <tr>
                            <th>Investment ID</th>
                            <td><b>{{ $investment->id }}</b></td>

                            <th>Investment Date</th>
                            <td><b>{{ \Carbon\Carbon::parse($investment->investment_date)->format('d M Y') }}</b></td>

                            <th>Investment Type</th>
                            <td><b>{{ ucfirst($investment->investment_type) }}</b></td>
                        </tr>

                        <tr>
                            <th>Scheme Name</th>
                            <td><b>{{ $schemeNames[$investment->scheme_id] ?? '-' }}</b></td>

                            <th>Investment Amount</th>
                            <td><b>₹ {{ number_format($investment->investment_amount, 2) }}</b></td>

                            <th>Interest Amount</th>
                            <td><b>₹ {{ number_format($investment->actual_interest_amount, 2) }}</b></td>
                        </tr>

                        {{-- Always show 1st Holder --}}
                        <tr>
                            <th>1st Holder</th>
                            <td class="bg-warning-subtle" colspan="{{ $investment->investment_type === 'single' ? 5 : 1 }}">
                                <b>{{ $clientNames[$investment->first_client_id] ?? '-' }}</b>
                            </td>

                            @if ($investment->investment_type !== 'single')
                                <th>2nd Holder</th>
                                <td class="bg-warning-subtle">
                                    <b>{{ $clientNames[$investment->second_client_id] ?? '-' }}</b>
                                </td>

                                <th>3rd Holder</th>
                                <td class="bg-warning-subtle">
                                    <b>{{ $clientNames[$investment->third_client_id] ?? '-' }}</b>
                                </td>
                            @endif
                        </tr>

                        {{-- Show 4th holder only for joint --}}
                        @if ($investment->investment_type !== 'single')
                            <tr>
                                <th>4th Holder</th>
                                <td class="bg-warning-subtle" colspan="5">
                                    <b>{{ $clientNames[$investment->fourth_client_id] ?? '-' }}</b>
                                </td>
                            </tr>
                        @endif


                        <tr>
                            {{-- <th>4th Holder</th>
                            <td class="bg-warning-subtle">
                                <b>{{ $investment->investment_type !== 'single' ? $clientNames[$investment->fourth_client_id] ?? '-' : '-' }}</b>
                            </td> --}}

                            <th>Tenure</th>
                            <td><b>{{ $investment->tenure_count }} {{ ucfirst($investment->tenure_type) }}</b></td>

                            <th>Lock-in Period</th>
                            <td><b>{{ $investment->lock_in_period }}</b></td>
                        </tr>

                        <tr>
                            <th>ROI (%)</th>
                            <td><b>{{ $investment->roi_percent }}%</b></td>

                            <th>Additional ROI</th>
                            <td><b>{{ $investment->additional_roi_percent }}%</b></td>

                            <th>TDS Applicable</th>
                            <td><b>{{ $investment->has_tds ? 'Yes' : 'No' }}</b></td>
                        </tr>

                        <tr>
                            <th>Frequency</th>
                            <td><b>{{ ucfirst($investment->frequency) }}</b></td>

                            <th>Schedule Count</th>
                            <td><b>{{ $investment->schedule_count }}</b></td>
                            <th>Payout Per Period</th>
                            <td><b>₹ {{ number_format($investment->payout_per_period, 2) }}</b></td>

                        </tr>

                        <tr>
                            <th>First Payout Date</th>
                            <td>
                                <b>{{ \Carbon\Carbon::parse($investment->first_payout_date)->format('d M Y') }}</b>
                            </td>
                            <th>Maturity Date</th>
                            <td>
                                <b>{{ \Carbon\Carbon::parse($investment->maturity_date)->format('d M Y') }}</b>
                            </td>
                        </tr>
                    </tbody>

                </table>

                <h5 class="card-title">Bank / Instrument Details </h5>
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
                    @forelse($investment->investmentInputBank ?? [] as $b)
                        <tr>
                            <td>{{ $b->instrument_type }}</td>
                            <td>{{ \Carbon\Carbon::parse($b->client_instrument_date)->format('d M Y') }}</td>
                            <td>{{ $b->client_reference_no }}</td>
                            <td>₹ {{ number_format($b->amount, 2) }}</td>
                            <td>{{ $investment->toClientBank?->bank_name ?? '-' }}</td>
                            {{-- <td>{{ $b->attachment_instrument ?? 'No Attachment' }}</td> --}}
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

                <table class="table table-bordered mb-4">
                    <h6 class="text-warning">Company Credit Details</h6>
                    {{-- Header Row --}}
                    <tr class="bg-warning-subtle">

                        <th>Company Bank</th>
                        <th>Credit Date</th>
                        <th>Company Bank Ref No</th>
                        <th>Instrument A mount</th>
                    </tr>

                    {{-- Data Row --}}
                    @forelse($investment->investmentInputBank ?? [] as $b)
                        <tr>

                            <td>{{ $investment->fromCompanyBank?->bank_name ?? '-' }}</td>
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

                <h5 class="card-title">Outward Bank / Payout Details</h5>
                <table class="table table-bordered  mb-4">
                    <tbody>
                        <tr>
                            <th>Company Bank</th>
                            <th>Company Account No</th>
                            <th>Client Bank</th>
                            <th>Client Account No</th>
                        </tr>

                        <tr>
                            <td><b>{{ $investment->fromCompanyBank?->bank_name ?? '-' }}</b></td>
                            <td><b>{{ $investment->fromCompanyBank?->account_number ?? '-' }}</b></td>
                            <td><b>{{ $investment->toClientBank?->bank_name ?? '-' }}</b></td>
                            <td><b>{{ $investment->toClientBank?->account_number ?? '-' }}</b></td>
                        </tr>



                    </tbody>

                </table>

                <h5 class="card-title">Nominee Details </h5>
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


                <h5 class="card-title">Payment Schedule</h5>
                <div class="table-responsive">

                    {{-- <table class="table table-bordered "> --}}
                    <table id="payoutTable" class="table table-bordered nowrap w-100">

                        <thead class="table-light">
                            <tr>
                                {{-- <th>#</th> --}}
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
                            {{-- CREDIT / INVESTMENT ENTRY --}}
                            {{-- ===================== --}}
                            @forelse($investment->investmentInputBank ?? [] as $loopIndex => $b)
                                <tr class="table-light">
                                    {{-- <td class="fw-semibold">
                                        CR-{{ $loopIndex + 1 }}
                                    </td> --}}

                                    <td>
                                        {{ \Carbon\Carbon::parse($b->client_instrument_date)->format('d M Y') }}
                                    </td>

                                    <td class="text-end fw-semibold text-success">
                                        ₹ {{ number_format($b->amount, 2) }}
                                    </td>

                                    <td class="">—</td>
                                    <td>—</td>
                                    <td>—</td>

                                    <td>
                                        {{ $b->client_reference_no ?? '—' }}
                                    </td>

                                    <td>—</td>
                                    <td>—</td>

                                    <td>
                                        <span class="badge bg-info">Credit</span>
                                    </td>

                                    <td>
                                        {{ $b->instrument_type }}
                                    </td>

                                    {{-- <td class="text-center">—</td> --}}
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="text-center text-muted">
                                        No investment credit records found
                                    </td>
                                </tr>
                            @endforelse


                            {{-- ===================== --}}
                            {{-- PAYOUT SCHEDULES --}}
                            {{-- ===================== --}}
                            @foreach ($paySchdeule->payoutSchedules as $index => $schedule)
                                {{-- <h1>{{ $schedule }}</h1> --}}
                                <tr
                                    class="{{ $schedule->sch_payout_amount == $investment->investment_amount ? 'table-info' : '' }}">

                                    <td class="fw-semibold">
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
                                        {{ $schedule->actual_payout_date ? \Carbon\Carbon::parse($schedule->actual_payout_date)->format('d M Y H:i') : '—' }}
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
                                <th colspan="2" class="text-end">Total</th>
                                <th class="text-end">
                                    ₹ {{ number_format($investment->payoutSchedules->sum('sch_payout_amount'), 2) }}
                                </th>
                                <th colspan="8"></th>
                            </tr>
                            <tr>
                                <th colspan="2" class="text-end">Rounding-off</th>
                                <th class="text-end">
                                    {{ $schedule->rounding_off_amount ? '₹ ' . number_format($schedule->rounding_off_amount, 2) : '—' }}
                                </th>
                                <th colspan="8"></th>
                            </tr>
                        </tfoot>


                    </table>
                </div>
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
        <div class="modal-dialog modal-md modal-dialog-centered">
            {{-- <form method="POST" action="#"> --}}
            <form method="POST" action="{{ route('investment.payout.mark-paid') }}">
                @csrf
                @method('put')

                <input type="hidden" name="schedule_id" id="schedule_id">

                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h6 class="modal-title">Mark Payout as Paid</h6>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Actual Paid Amount</label>
                            <input type="number" step="0.01" class="form-control bg-secondary-subtle"
                                name="actual_payout_amount" id="actual_amount" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Actual Payout Date & Time</label>
                            <input type="datetime-local" class="form-control" name="actual_payout_date"
                                value="{{ date('Y-m-d\TH:i') }}" required>
                        </div>


                        <div class="mb-3">
                            <label class="form-label">UTR No</label>
                            <input type="text" class="form-control" name="utr_no" required pattern="[A-Za-z0-9]+"
                                title="Only letters and numbers are allowed"
                                oninput="this.value = this.value.replace(/[^A-Za-z0-9]/g, '')">
                        </div>


                        <div class="mb-3">
                            <label class="form-label">Remarks</label>
                            <textarea class="form-control" name="remarks" id="mark_paid_remarks" rows="3"></textarea>
                        </div>

                        <div class="mb-3">
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
                                <div id="attachment_refImage_preview" class="position-relative d-inline-block mt-2">
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


@endsection

@push('scripts')
    <script>
        var markPaidModal = document.getElementById('markPaidModal');
        markPaidModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            document.getElementById('schedule_id').value = button.getAttribute('data-id');
            document.getElementById('actual_amount').value = button.getAttribute('data-amount');
            document.getElementById('mark_paid_remarks').value = 'Payment for SR No. ' + button.getAttribute(
                'data-sr_no');
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
