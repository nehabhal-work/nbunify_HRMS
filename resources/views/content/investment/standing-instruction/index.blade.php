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
        <span class="text-muted fw-light">Master /</span> <a href="{{ route('investment.els.index') }}">ELS-Investment</a>
    </h4>

    <div class="div d-flex justify-content-end mb-3">
        <a href="{{ route('investment.els.index') }}" class="btn btn-secondary px-4">Go back</a>

    </div>
    <style>


    </style>
    <form action="{{ route('investment.si.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('post')

        <input type="hidden" name="investment_id" value="{{ request()->get('id') }}">

        {{-- Set standing instruction --}}
        <div class="card p-3 mb-3">
            <h5>Standing Instruction Details</h5>
            <table
                class="table table-bordered table-striped table-sm align-middle  investment-view styled-investment-table">
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
                        <td><b>{{ $investment->si_no_of_payments }}</b></td>

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
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm">

                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Set Standing Instruction</h5>


                    </div>

                    <div class="card-body">
                        <div class="row g-3">

                            <!-- Reference No -->
                            <div class="col-md-3">
                                <label class="form-label">
                                    Reference No <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="si_number"
                                    class="form-control @error('si_number') is-invalid @enderror"
                                    placeholder="Enter reference no" value="{{ old('si_number') }}">

                                @error('si_number')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">
                                    Instruction Type <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('instruction_type') is-invalid @enderror"
                                    name="instruction_type" id="instructionType" required>
                                    <option value="standing"
                                        {{ $investment->instruction_type === 'standing' ? 'selected' : '' }}>
                                        standing
                                    </option>
                                    <option value="schedule"
                                        {{ $investment->instruction_type === 'schedule' ? 'selected' : '' }}>
                                        schedule
                                    </option>
                                </select>
                            </div>

                            <!-- Company Bank -->
                            <div class="col-md-3">
                                <label class="form-label">
                                    Company Bank <span class="text-danger">*</span>
                                </label>

                                <!-- Display (Disabled Input) -->
                                <input type="text" class="form-control  bg-subtle"
                                    value="{{ $investment->fromCompanyBank->bank_name . '-' . $investment->fromCompanyBank->account_number }}"
                                    disabled>
                                <!-- Hidden Field (Actual Value Submitted) -->
                                <input type="hidden" name="si_company_bank_id"
                                    value="{{ $investment->fromCompanyBank->id }}">


                            </div>


                            <!-- Client Bank -->
                            <div class="col-md-3">
                                <label class="form-label">
                                    Client Bank <span class="text-danger">*</span>
                                </label>

                                <!-- Display (Disabled Input) -->
                                <input type="text" class="form-control  bg-subtle"
                                    value="{{ $investment->toClientBank->bank_name . '-' . $investment->toClientBank->account_number }}"
                                    disabled>
                                <!-- Hidden Field (Actual Value Submitted) -->
                                <input type="hidden" name="si_client_bank_id" value="{{ $investment->toClientBank->id }}">


                            </div>

                            <!-- Payment Start Date -->
                            <div class="col-md-3">
                                <label class="form-label">
                                    Start Date <span class="text-danger">*</span>
                                </label>
                                <input type="date" name="si_start_date"
                                    class="form-control bg-secondary-subtle @error('si_start_date') is-invalid @enderror"
                                    value="{{ $investment->first_payout_date ? \Carbon\Carbon::parse($investment->first_payout_date)->format('Y-m-d') : '' }}"
                                    readonly>
                            </div>
                            <!-- Payment End Date -->
                            <div class="col-md-3">
                                <label class="form-label">
                                    End Date <span class="text-danger">*</span>
                                </label>
                                <input type="date" name="si_end_date"
                                    class="form-control bg-secondary-subtle @error('si_end_date') is-invalid @enderror"
                                    value="{{ $investment->maturity_date ? \Carbon\Carbon::parse($investment->maturity_date)->format('Y-m-d') : '' }}"
                                    readonly>
                            </div>

                            <!-- Amount -->
                            <div class="col-md-3">
                                <label class="form-label">
                                    Amount <span class="text-danger">*</span>
                                </label>
                                <input type="text" step="0.01" name="si_amount" readonly
                                    class="form-control bg-secondary-subtle @error('amount') is-invalid @enderror"
                                    placeholder="Enter amount" value="{{ $investment->payout_per_period }}">

                            </div>

                            <div class="col-md-3">
                                <label class="form-label">
                                    Payout Count <span class="text-danger">*</span>
                                </label>
                                <input type="number" id="originalPayoutCount" name="si_no_of_payments"
                                    class="form-control bg-secondary-subtle @error('si_no_of_payments') is-invalid @enderror"
                                    value="{{ $investment->si_no_of_payments ?? 1 }}" hidden readonly>
                                <input type="number" name="si_no_of_payments" id="scheduleCount"
                                    class="form-control  @error('si_no_of_payments') is-invalid @enderror">
                            </div>


                            <!-- Instruction Image -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">
                                    Instruction Image <span class="text-danger">*</span>
                                </label>

                                <div class="input-group">
                                    <input type="file"
                                        class="form-control fileInput @error('instruction_image') is-invalid @enderror"
                                        id="instruction_image" name="instruction_image" accept="image/*,application/pdf"
                                        onchange="uploadTempFile(this, 'instruction_image')">

                                    <button class="btn btn-outline-danger" type="button"
                                        onclick="document.getElementById('instruction_image').value = ''">
                                        ✕
                                    </button>
                                </div>

                                @error('instruction_image')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror

                                <input type="hidden" id="instruction_image_url" name="instruction_image_url"
                                    value="{{ old('instruction_image_url') }}">

                                @if (old('instruction_image_url'))
                                    <div id="instruction_image_preview" class="position-relative d-inline-block mt-2">
                                        <img src="{{ old('instruction_image_url') }}" width="100"
                                            class="rounded border">

                                        <button type="button"
                                            class="btn btn-sm btn-danger position-absolute top-0 start-100 translate-middle"
                                            onclick="removeImage('instruction_image')">
                                            ✕
                                        </button>
                                    </div>
                                @endif
                            </div>


                            <!-- Notes Image -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">
                                    Notes Image <span class="text-danger">*</span>
                                </label>

                                <div class="input-group">
                                    <input type="file"
                                        class="form-control fileInput @error('notes_image') is-invalid @enderror"
                                        id="notes_image" name="notes_image" accept="image/*,application/pdf"
                                        onchange="uploadTempFile(this, 'notes_image')">

                                    <button class="btn btn-outline-danger" type="button"
                                        onclick="document.getElementById('notes_image').value = ''">
                                        ✕
                                    </button>
                                </div>

                                @error('notes_image')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror

                                <input type="hidden" id="notes_image_url" name="notes_image_url"
                                    value="{{ old('notes_image_url') }}">

                                @if (old('notes_image_url'))
                                    <div id="notes_image_preview" class="position-relative d-inline-block mt-2">
                                        <img src="{{ old('notes_image_url') }}" width="100" class="rounded border">

                                        <button type="button"
                                            class="btn btn-sm btn-danger position-absolute top-0 start-100 translate-middle"
                                            onclick="removeImage('notes_image')">
                                            ✕
                                        </button>
                                    </div>
                                @endif
                            </div>

                            <!-- Status -->
                            <div class="col-md-3">
                                <label class="form-label">
                                    Status <span class="text-danger">*</span>
                                </label>
                                <select name="status" class="form-control @error('status') is-invalid @enderror">
                                    {{-- <option value="">Select Status</option> --}}
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive
                                    </option>
                                </select>

                                @error('status')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Remarks -->
                            <div class="col-md-6">
                                <label class="form-label">
                                    Remarks <span class="text-danger">*</span>
                                </label>
                                <textarea name="remarks" rows="3" class="form-control @error('remarks') is-invalid @enderror"
                                    placeholder="Write remarks">{{ old('remarks') }}</textarea>

                                @error('remarks')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                        </div>
                        <!-- Submit -->
                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-primary px-4">Save</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </form>

    <div class="card my-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Bank / Instrument List</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table srkdataTable">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Reference No</th>
                            <th>Status</th>
                            <th>Company Bank</th>
                            <th>Client Bank</th>
                            <th>Payment Start Date</th>
                            <th>Amount</th>
                            <th>Instruction Image</th>
                            <th>Notes Image</th>
                            <th>Created By</th>
                            <th>Approved By 1</th>
                            {{-- <th>Approved By 2</th>
                            <th>Approved By 3</th> --}}
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($investment->standingInstructions as $d)
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


                                <td>{{ $investment->fromCompanyBank->bank_name . ' - ' . $investment->fromCompanyBank->account_number }}
                                </td>
                                <td>{{ $investment->ToClientBank->bank_name . ' - ' . $investment->ToClientBank->account_number }}
                                </td>
                                <td>{{ \Carbon\Carbon::parse($d->si_start_date)->format('d M Y') }}
                                </td>
                                <td>{{ $d->si_amount }}</td>
                                <td>instruction_001.jpg</td>
                                <td>notes_001.jpg</td>

                                <td
                                    class="{{ !empty($d->createdBy) ? 'table-warning fw-semibold rounded px-2 py-1' : '' }}">
                                    @if (!empty($d->createdBy))
                                        {{-- <div class="d-flex justify-content-center text-center"> --}}
                                        {{ $d->createdBy->name }}
                                        {{-- </div> --}}
                                        <br>
                                        {{ $d->created_at ?? '-' }}
                                    @else
                                        -
                                    @endif
                                </td>

                                <td
                                    class="{{ !empty($d->approvedBy) ? 'table-success fw-semibold rounded px-2 py-1' : '' }}">
                                    @if (!empty($d->approvedBy))
                                        {{ $d->approvedBy->name }} <br>{{ $d->approved_at ?? '-' }}
                                    @else
                                        -
                                    @endif
                                </td>

                                {{-- <td
                                    class="{{ !empty($d->approved2By) ? 'table-success fw-semibold rounded px-2 py-1' : '' }}">
                                    @if (!empty($d->approved2By))
                                        {{ $d->approved2By->name }} <br>{{ $d->approved2_on ?? '-' }}
                                    @else
                                        -
                                    @endif
                                </td>

                                <td
                                    class="{{ !empty($d->approved3By) ? 'table-success fw-semibold rounded px-2 py-1' : '' }}">
                                    @if (!empty($d->approved3By))
                                        {{ $d->approved3By->name }} <br>{{ $d->approved3_on ?? '-' }}
                                    @else
                                        -
                                    @endif
                                </td> --}}


                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>

                                        <div class="dropdown-menu">

                                            <a class="dropdown-item edit-btn"
                                                href="{{ route('investment.si.edit', $d->id) }}">
                                                <i class="bx bx-edit-alt me-1"></i> Edit
                                            </a>
                                            <a class="dropdown-item edit-btn"
                                                href="{{ route('investment.si.show', $d->id) }}">
                                                <i class="bx bx-show-alt me-1"></i> View
                                            </a>

                                            {{-- <form action="{{ route('investment.si.destroy', $d->id) }}" method="POST"
                                                onsubmit="return confirmDelete()">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="dropdown-item text-danger">
                                                    Delete
                                                </button>
                                            </form> --}}




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
                scheduleCount.value = Math.max(originalPayout - 1, 0);
                scheduleCount.readOnly = false;

                scheduleCount.classList.remove('bg-secondary', 'bg-opacity-10');
            }
        }

        instructionType.addEventListener('change', applyRules);
        applyRules();
    </script>





@endsection

@push('scripts')
    <script src="{{ asset('assets/js/investment.js') }}"></script>
@endpush
