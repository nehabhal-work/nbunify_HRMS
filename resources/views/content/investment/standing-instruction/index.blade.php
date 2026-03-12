@extends('layouts.master-layout')

@section('title', 'Investment')

@section('content')
    <div>

        @if (session('success'))
            <x-alert-sweet type="success" :message="session('success')" />
        @endif

        @if (session('error'))
            <x-alert-sweet type="danger" :message="session('error')" />
        @endif
        @if (session('warning'))
            <x-alert-sweet type="warning" :message="session('warning')" />
        @endif


    </div>

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
        <span class="text-muted fw-light">Master /</span> <a class="text-muted fw-light"
            href="{{ route('investment.els.index') }}">ELS-Investment</a>/ Standing Instruction
    </h4>

    <div class="div d-flex justify-content-end mb-3">
        <a href="{{ route('investment.els.index') }}" class="btn btn-secondary px-4">Go back</a>

    </div>

    <div class="card p-3 mb-3">
        <h5>Standing Instruction Details</h5>
        <table class="table table-bordered table-striped table-sm align-middle  investment-view styled-investment-table">
            <tbody>
                <tr>
                    <th>Investment Date</th>
                    <td>
                        <b>{{ \Carbon\Carbon::parse($investment->investment_date)->format('d M Y') }}</b>
                    </td>
                    <th>Investment Type</th>
                    <td><b>{{ ucfirst($investment->investment_type) }}</b></td>
                </tr>
                <tr>
                    <th>Investment Holder Name</th>
                    <td class="bg-warning-subtle"><b><small class="text-info">
                                @if ($investment->firstClient)
                                    {{ $investment->firstClient->name }}
                                @endif
                                @if ($investment->secondClient)
                                    , {{ $investment->secondClient->name }}
                                @endif
                                @if ($investment->thirdClient)
                                    , {{ $investment->thirdClient->name }}
                                @endif
                                @if ($investment->fourthClient)
                                    , {{ $investment->fourthClient->name }}
                                @endif
                            </small></b>
                    </td>
                    <th>Scheme Name</th>
                    <td><b>{{ $investment->scheme->scheme_name ?? '-' }}</b></td>
                </tr>

                {{-- @if ($investment->investment_type !== 'single')
                        <tr>
                            <th>Investment 3rd Holder</th>
                            <td class="bg-warning-subtle"><b>{{ $clientNames[$investment->third_client_id] ?? '-' }}</b>
                            </td>

                            <th>Investment 4th Holder</th>
                            <td class="bg-warning-subtle">
                                <b>{{ $clientNames[$investment->fourth_client_id] ?? '-' }}</b>
                            </td>
                        </tr>
                    @endif --}}


                <tr>
                    <th>Schedule Count</th>
                    <td><b>{{ $investment->schedule_count }}</b></td>

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
                    <th>Payout Per {{ ucfirst($investment->frequency) }}</th>
                    <td><b>₹ {{ number_format($investment->payout_per_period, 2) }}</b></td>
                    <th>First Payout Date</th>
                    <td><b>{{ \Carbon\Carbon::parse($investment->first_payout_date)->format('d M Y') }}</b></td>
                </tr>


            </tbody>
        </table>
    </div>





    <div class="card my-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Bank / Instrument List</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-bordered table-hover align-middle table-sm srkdataTable">
                    <thead class="table-light">
                        <tr>
                            <th hidden>#</th>
                            <th>Reference No</th>
                            <th>Status</th>
                            <th>Instruction / Pay Count</th>
                            <th>Company Bank</th>
                            <th>Client Bank</th>
                            <th>start date - end date</th>
                            <th>Amount</th>
                            <th>Instruction Image</th>
                            <th>Notes Image</th>
                            <th>Created By</th>
                            <th>Approved By</th>
                            <th>Action</th>
                        </tr>
                    </thead>


                    <tbody>
                        @foreach ($investment->standingInstructions as $key => $d)
                            <tr>
                                <td hidden>{{ $key + 1 }}</td>

                                <td>
                                    <a href="{{ route('investment.si.show', $d->id) }}"
                                        class="fw-semibold text-primary text-decoration-none">
                                        {{ $d->si_number }}
                                    </a>
                                </td>

                                <td>
                                    <span class="badge {{ $d->status === 'active' ? 'bg-success' : 'bg-danger' }}">
                                        {{ ucfirst($d->status) }}
                                    </span>
                                </td>

                                {{-- ✅ Instruction Type + Pay Count --}}
                                <td>
                                    <div class="fw-semibold">{{ $d->instruction_type }}</div>
                                    <small class="text-muted">
                                        Pay Count: {{ $d->si_no_of_payments }}
                                    </small>
                                </td>

                                <td>
                                    {{ $investment->fromCompanyBank->bank_name }} -
                                    {{ $investment->fromCompanyBank->account_number }}
                                </td>

                                <td>
                                    {{ $investment->ToClientBank->bank_name }} -
                                    {{ $investment->ToClientBank->account_number }}
                                </td>

                                {{-- ✅ Start Date – End Date --}}
                                <td>
                                    <div class="fw-semibold">
                                        {{ \Carbon\Carbon::parse($d->si_start_date)->format('d M Y') }}
                                    </div>
                                    <small class="text-muted">
                                        to {{ \Carbon\Carbon::parse($d->si_end_date)->format('d M Y') }}
                                    </small>
                                </td>

                                <td>{{ number_format($d->si_amount, 2) }}</td>

                                <td>instruction_001.jpg</td>
                                <td>notes_001.jpg</td>

                                <td class="{{ $d->createdBy ? 'table-warning fw-semibold' : '' }}">
                                    @if ($d->createdBy)
                                        {{ $d->createdBy->name }}<br>
                                        <small>{{ $d->created_at }}</small>
                                    @else
                                        -
                                    @endif
                                </td>

                                <td class="{{ $d->approvedBy ? 'table-success fw-semibold' : '' }}">
                                    @if ($d->approvedBy)
                                        {{ $d->approvedBy->name }}<br>
                                        <small>{{ $d->approved_at }}</small>
                                    @else
                                        -
                                    @endif
                                </td>

                                <td>
                                    <div class="dropdown">
                                        <button class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('investment.si.edit', $d->id) }}">
                                                <i class="bx bx-edit-alt me-1"></i> Edit
                                            </a>
                                            <a class="dropdown-item" href="{{ route('investment.si.show', $d->id) }}">
                                                <i class="bx bx-show-alt me-1"></i> View
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
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
    <script>
        const instructionType = document.getElementById('instructionType');
        const scheduleCount = document.getElementById('scheduleCount');
        const originalPayout = document.getElementById('originalPayoutCount').value;

        function applyRules() {
            if (instructionType.value === 'schedule') {
                scheduleCount.value = 1;
                scheduleCount.readOnly = true;

                // background for readonly state
                scheduleCount.classList.add('bg-secondary', 'bg-opacity-10');
            } else {
                scheduleCount.value = Math.max(originalPayout, 0);
                // scheduleCount.value = Math.max(originalPayout - 1, 0);
                scheduleCount.readOnly = false;

                scheduleCount.classList.remove('bg-secondary', 'bg-opacity-10');
            }
        }

        instructionType.addEventListener('change', applyRules);
        applyRules();
    </script>


    <script>
        function toggleInstructionFields() {
            const type = document.getElementById('instructionType').value;

            const startWrapper = document.getElementById('startDateWrapper');
            const endLabel = document.getElementById('endDateLabel');

            if (type === 'schedule') {
                // Hide start date
                startWrapper.style.display = 'none';

                // Change end date label
                endLabel.innerHTML = 'Payout Date <span class="text-danger">*</span>';
            } else {
                // Show start date
                startWrapper.style.display = 'block';

                // Reset label
                endLabel.innerHTML = 'End Date <span class="text-danger">*</span>';
            }
        }

        // On change
        document.getElementById('instructionType').addEventListener('change', toggleInstructionFields);

        // On page load
        document.addEventListener('DOMContentLoaded', toggleInstructionFields);
    </script>



@endsection

@push('scripts')
    <script src="{{ asset('assets/js/investment.js') }}"></script>
@endpush
