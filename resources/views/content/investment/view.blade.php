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

    <div class="container">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Investment Details</h5>
                <h6>Investment ID : {{ $investment->id }}</h6>

                <table class="table table-bordered mb-4 investment-view">
                    {{-- <tbody>
                        <tr>
                            <th>Investment ID</th>
                            <td>
                                <b>{{ $investment->id }}</b>
                            </td>
                            <th>Investment Date</th>
                            <td>
                                <b>{{ \Carbon\Carbon::parse($investment->investment_date)->format('d M Y') }}</b>
                            </td>
                            <th>Investment Type</th>
                            <td><b>{{ ucfirst($investment->investment_type) }}</b></td>
                        </tr>
                        <tr>
                            <th>Investment Holder Name</th>
                            <td class="bg-warning-subtle"><b>{{ $clientNames[$investment->first_client_id] ?? '-' }}</b>
                            </td>

                            @if ($investment->investment_type !== 'single')
                                <th>Investment 2nd Holder</th>
                                <td class="bg-warning-subtle">
                                    <b>{{ $clientNames[$investment->second_client_id] ?? '-' }}</b>
                                </td>
                            @else
                                <td colspan="2"></td>
                            @endif
                        </tr>

                        @if ($investment->investment_type !== 'single')
                            <tr>
                                <th>Investment 3rd Holder</th>
                                <td class="bg-warning-subtle"><b>{{ $clientNames[$investment->third_client_id] ?? '-' }}</b>
                                </td>

                                <th>Investment 4th Holder</th>
                                <td class="bg-warning-subtle">
                                    <b>{{ $clientNames[$investment->fourth_client_id] ?? '-' }}</b>
                                </td>
                            </tr>
                        @endif


                        <tr>
                            <th>Scheme Name</th>
                            <td><b>{{ $schemeNames[$investment->scheme_id] ?? '-' }}</b></td>
                            <th>Investment Amount</th>
                            <td><b>₹ {{ number_format($investment->investment_amount, 2) }}</b></td>
                        </tr>
                        <tr>
                            <th>Tenure</th>
                            <td><b>{{ $investment->tenure_count }} {{ ucfirst($investment->tenure_type) }}</b></td>
                            <th>Frequency</th>
                            <td><b>{{ ucfirst($investment->frequency) }}</b></td>
                        </tr>

                        <tr>
                            <th>ROI (%)</th>
                            <td><b>{{ $investment->roi_percent }}%</b></td>
                            <th>Maturity Date</th>
                            <td><b>{{ \Carbon\Carbon::parse($investment->maturity_date)->format('d M Y') }}</b></td>
                        </tr>
                        <tr>
                            <th>Interest Amount</th>
                            <td><b>₹ {{ number_format($investment->actual_interest_amount, 2) }}</b></td>
                            <th>Lock in Period</th>
                            <td><b>{{ $investment->lock_in_period }}</b></td>
                        </tr>

                        <tr>
                            <th>Additional ROI</th>
                            <td><b>{{ $investment->additional_roi_percent }}%</b></td>
                            <th>TDS Applicable</th>
                            <td><b>{{ $investment->has_tds ? 'Yes' : 'No' }}</b></td>
                        </tr>

                        <tr>
                            <th>Schedule Count</th>
                            <td><b>{{ $investment->schedule_count }}</b></td>
                            <th>Annual Payout</th>
                            <td><b>₹ {{ number_format($investment->annual_payout, 2) }}</b></td>
                        </tr>

                        <tr>
                            <th>Payout Per Period</th>
                            <td><b>₹ {{ number_format($investment->payout_per_period, 2) }}</b></td>
                            <th>First Payout Date</th>
                            <td><b>{{ \Carbon\Carbon::parse($investment->first_payout_date)->format('d M Y') }}</b></td>
                        </tr>


                    </tbody> --}}
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
                            <td class="bg-warning-subtle"
                                colspan="{{ $investment->investment_type === 'single' ? 5 : 1 }}">
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
                <table class="table table-bordered ">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
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
                        @foreach ($investment->payoutSchedules as $index => $schedule)
                            <tr
                                class="{{ $schedule->sch_payout_amount == $investment->investment_amount ? 'table-info' : '' }}">
                                <td>{{ $index + 1 }}</td>

                                <td>{{ \Carbon\Carbon::parse($schedule->sch_payout_date)->format('d M Y') }}</td>

                                <td class="text-end fw-semibold">
                                    ₹ {{ number_format($schedule->sch_payout_amount, 2) }}
                                </td>

                                <td class="text-end">
                                    {{ $schedule->actual_payout_amount ? '₹ ' . number_format($schedule->actual_payout_amount, 2) : '—' }}
                                </td>

                                <td>
                                    {{ $schedule->actual_payout_date ? \Carbon\Carbon::parse($schedule->actual_payout_date)->format('d M Y') : '—' }}
                                </td>
                                <td>{{ $schedule->utr_no }}</td>

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

                                <td>{{ $schedule->remarks ?? '—' }}</td>

                                <td class="text-center">
                                    @if ($schedule->status === 'pending')
                                        <button class="btn btn-sm btn-outline-success" data-bs-toggle="modal"
                                            data-bs-target="#markPaidModal" data-id="{{ $schedule->id }}"
                                            data-amount="{{ $schedule->sch_payout_amount }}">
                                            Mark Paid
                                        </button>
                                    @else
                                        <a href="{{ route('investment.payout.send-mail', $schedule->id) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            Send Mail
                                        </a>
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
                            <th colspan="7"></th>
                        </tr>
                    </tfoot>


                </table>

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
                            <input type="number" step="0.01" class="form-control" name="actual_payout_amount"
                                id="actual_amount" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Actual Payout Date</label>
                            <input type="date" class="form-control" name="actual_payout_date"
                                value="{{ date('Y-m-d') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">UTR No</label>
                            <input type="text" class="form-control" name="utr_no" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Remarks</label>
                            <textarea class="form-control" name="remarks" rows="3"></textarea>
                        </div>
                    </div>

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
        $('#calculateBtn').on('click', function() {

            $.ajax({
                url: "http://localhost:8000/api/calculate-investment-parameters",
                type: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                },
                contentType: "application/json",
                data: JSON.stringify({
                    "investment_amount": 50000,
                    "roi_percent": 12.5,
                    "additional_roi_percent": 1,
                    "frequency": "monthly",
                    "tenure_count": 1,
                    "tenure_type": "years",
                    "investment_date": "2025-09-10"
                }),


                success: function(response) {
                    console.log("API Response:", response);

                    $('#resultCard').show();

                    let data = response.data;

                    $("#inv_amount").text("₹" + data.investment_amount.toLocaleString());
                    $("#roi").text(data.roi_percent + "%");
                    $("#add_roi").text(data.additional_roi_percent + "%");
                    $("#frequency").text(data.frequency);
                    $("#tenure").text(data.tenure_count + " " + data.tenure_type);
                    $("#inv_date").text(data.investment_date);
                    $("#maturity_date").text(data.maturity_date.substring(0, 10));

                    $("#annual_payout").text("₹" + data.annual_payout);
                    $("#period_payout").text("₹" + data.payout_per_period);
                    $("#schedule_count").text(data.schedule_count);

                    // Table
                    let rows = "";
                    data.payout_schedule.forEach((item, index) => {
                        rows += `
            <tr>
                <td>${index + 1}</td>
                <td>${item.payout_date}</td>
                <td>₹${item.amount}</td>
                <td><span class="badge bg-warning text-dark">${item.status}</span></td>
                <td>${item.remarks ?? ""}</td>
            </tr>`;
                    });

                    $("#schedule_table_body").html(rows);
                    // You can show response inside HTML
                    // $("#result").html(JSON.stringify(response));
                },
                error: function(xhr) {
                    console.log("Error:", xhr.responseText);
                }
            });

        });
    </script>

    <script>
        var markPaidModal = document.getElementById('markPaidModal');
        markPaidModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            document.getElementById('schedule_id').value = button.getAttribute('data-id');
            document.getElementById('actual_amount').value = button.getAttribute('data-amount');
        });
    </script>
@endpush
