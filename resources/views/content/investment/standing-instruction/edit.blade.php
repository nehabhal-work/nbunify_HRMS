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

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- {{ $investmentSi }} --}}
    {{-- @php
        if ($investmentSi->investment->investment_amount === $investmentSi->si_amount) {
            $hideDate = 'hidden';
        } else {
            $hideDate = '';
        }
    @endphp --}}
    @php
        $investmentAmount = (float) $investmentSi->investment->investment_amount;
        $siAmount = (float) $investmentSi->si_amount;

        $isFullAmountSI = $investmentAmount === $siAmount;

        // must match your existing label logic
        $showScheduleDate = $investmentSi->instruction_type === 'schedule' && !$isFullAmountSI;
    @endphp



    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Master /</span> <a href="{{ route('investment.els.index') }}">ELS-Investment</a>
    </h4>

    <div class="div d-flex justify-content-end mb-3">
        <a href="{{ route('investment.els.index') }}" class="btn btn-secondary px-4">Go back</a>

    </div>
    <form action="{{ route('investment.si.update', $investmentSi->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Investment ID -->
        <input type="hidden" name="investment_id" value="{{ $investment->id }}">
        <input type="hidden" name="si_no_of_payments" value="{{ $investment->schedule_count }}">


        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm">

                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Edit Standing Instruction</h5>
                        <a href="{{ route('investment.si.index', ['id' => $investment->id]) }}"
                            class="btn btn-sm btn-secondary">
                            Back
                        </a>
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
                                    value="{{ old('si_number', $investmentSi->si_number) }}">
                                @error('si_number')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Reference No -->
                            <div class="col-md-3">
                                <label class="form-label">
                                    Bank Reference No <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="bank_reference_no"
                                    class="form-control @error('bank_reference_no') is-invalid @enderror"
                                    value="{{ old('bank_reference_no', $investmentSi->bank_reference_no) }}">
                                @error('bank_reference_no')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!--  Instruction Type -->
                            <div class="col-md-3">
                                <label class="form-label">
                                    Instruction Type <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('instruction_type') is-invalid @enderror"
                                    name="instruction_type" id="instructionType" required>
                                    <option value="standing"
                                        {{ $investmentSi->instruction_type === 'standing' ? 'selected' : '' }}>
                                        standing
                                    </option>
                                    <option value="schedule"
                                        {{ $investmentSi->instruction_type === 'schedule' ? 'selected' : '' }}>
                                        schedule
                                    </option>
                                </select>

                            </div>
                            <!-- Company Bank -->
                            <div class="col-md-3">
                                <label class="form-label">
                                    Company Bank
                                </label>
                                <input type="text" class="form-control bg-secondary-subtle"
                                    value="{{ $investment->fromCompanyBank->bank_name }} - {{ $investment->fromCompanyBank->account_number }}"
                                    disabled>

                                <input type="hidden" name="si_company_bank_id"
                                    value="{{ $investment->fromCompanyBank->id }}">
                            </div>

                            <!-- Client Bank -->
                            <div class="col-md-3">
                                <label class="form-label">
                                    Client Bank
                                </label>
                                <input type="text" class="form-control bg-secondary-subtle"
                                    value="{{ $investment->toClientBank->bank_name }} - {{ $investment->toClientBank->account_number }}"
                                    disabled>

                                <input type="hidden" name="si_client_bank_id" value="{{ $investment->toClientBank->id }}">
                            </div>

                            <!-- Payment Start Date -->
                            {{-- <div class="col-md-3">
                                <label class="form-label">
                                    Start Date <span class="text-danger">*</span>
                                </label>
                                <input type="date" name="si_start_date"
                                    class="form-control bg-secondary-subtle @error('si_start_date') is-invalid @enderror"
                                    value="{{ $investment->first_payout_date ? \Carbon\Carbon::parse($investment->first_payout_date)->format('Y-m-d') : '' }}"
                                    readonly>
                            </div> --}}
                            <!-- Payment End Date -->
                            {{-- <div {{ $hideDate }} class="col-md-3">
                                <label class="form-label">
                                    End Date <span class="text-danger">*</span>
                                </label>
                                <input type="date" name="si_end_date"
                                    class="form-control bg-secondary-subtle @error('si_end_date') is-invalid @enderror"
                                    value="{{ $investment->maturity_date ? \Carbon\Carbon::parse($investment->maturity_date)->format('Y-m-d') : '' }}"
                                    readonly>
                            </div> --}}



                            {{-- CASE 1: SI amount equals investment amount --}}
                            {{-- SCHEDULE AMOUNT → Schedule Date --}}
                            @if ($showScheduleDate)
                                <div class="col-md-3">
                                    <label class="form-label">
                                        Schedule Date <span class="text-danger">*</span>
                                    </label>

                                    <input type="date" name="si_start_date"
                                        class="form-control bg-secondary-subtle @error('si_start_date') is-invalid @enderror"
                                        value="{{ \Carbon\Carbon::parse($investment->maturity_date)->format('Y-m-d') }}"
                                        readonly>
                                </div>

                                {{-- FULL AMOUNT → Maturity Date --}}
                            @elseif ($isFullAmountSI)
                                <div class="col-md-3">
                                    <label class="form-label">
                                        Maturity Date <span class="text-danger">*</span>
                                    </label>

                                    <input type="date" name="si_start_date"
                                        class="form-control bg-secondary-subtle @error('si_start_date') is-invalid @enderror"
                                        value="{{ \Carbon\Carbon::parse($investment->maturity_date)->format('Y-m-d') }}"
                                        readonly>
                                </div>

                                {{-- NORMAL AMOUNT → Start & End Date --}}
                            @else
                                <div class="col-md-3">
                                    <label class="form-label">
                                        Start Date <span class="text-danger">*</span>
                                    </label>

                                    <input type="date" name="si_start_date"
                                        class="form-control bg-secondary-subtle @error('si_start_date') is-invalid @enderror"
                                        value="{{ \Carbon\Carbon::parse($investment->first_payout_date)->format('Y-m-d') }}"
                                        readonly>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">
                                        End Date <span class="text-danger">*</span>
                                    </label>

                                    <input type="date" name="si_end_date"
                                        class="form-control bg-secondary-subtle @error('si_end_date') is-invalid @enderror"
                                        value="{{ \Carbon\Carbon::parse($investment->last_payout_date)->format('Y-m-d') }}"
                                        readonly>
                                </div>
                            @endif





                            <!-- Amount -->
                            <div class="col-md-3">
                                <label class="form-label">
                                    {{ $showScheduleDate ? 'Schedule Amount' : ($isFullAmountSI ? 'Maturity Amount' : 'Amount') }}
                                </label>

                                <input type="text" name="si_amount" class="form-control bg-secondary-subtle"
                                    value="{{ number_format($investmentSi->si_amount, 2) }}" readonly>
                            </div>


                            {{-- <div class="col-md-3">
                                <label class="form-label">
                                    Payout Count <span class="text-danger">*</span>
                                </label>
                                <input type="number" id="originalPayoutCount" name="si_no_of_payments"
                                    class="form-control bg-secondary-subtle @error('si_no_of_payments') is-invalid @enderror"
                                    value="{{ $investment->schedule_count ?? 1 }}" hidden readonly>
                                <input type="number" name="si_no_of_payments" id="scheduleCount"
                                    class="form-control  @error('si_no_of_payments') is-invalid @enderror">

                                </div> --}}
                            <div class="col-md-3">
                                <label class="form-label">
                                    Payout Count <span class="text-danger">*</span>
                                </label>

                                {{-- ORIGINAL value (reference only, NOT submitted) --}}
                                <input type="number" id="originalPayoutCount"
                                    value="{{ $investment->schedule_count ?? 1 }}" hidden>

                                {{-- VISIBLE + SUBMITTED --}}
                                <input type="number" name="si_no_of_payments" id="scheduleCount"
                                    class="form-control @error('si_no_of_payments') is-invalid @enderror"
                                    value="{{ $investment->schedule_count ?? '-' }}">
                            </div>

                            {{-- source value (DO NOT submit) --}}
                            {{-- <input type="number" id="originalPayoutCount"
                                    value="{{ $investment->schedule_count ?? 1 }}" hidden> --}}

                            {{-- visible + submitted field --}}
                            {{-- <input type="number" name="schedule_count" id="scheduleCount"
                                    class="form-control @error('schedule_count') is-invalid @enderror"> --}}


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
                                    value="{{ old('instruction_image_url', $investmentSi->instruction_image) }}">

                                @if (old('instruction_image_url'))
                                    <div id="instruction_image_preview" class="position-relative d-inline-block mt-2">
                                        <a href="{{ old('instruction_image_url') }}" target="_blank">
                                            <img src="{{ old('instruction_image_url') }}" width="100"
                                                class="rounded border">
                                        </a>
                                        <button type="button"
                                            class="btn btn-sm btn-danger position-absolute top-0 start-100 translate-middle"
                                            onclick="removeImage('instruction_image')">
                                            ✕
                                        </button>
                                    </div>
                                @elseif ($investmentSi->instruction_image)
                                    <div id="instruction_image_preview" class="position-relative d-inline-block mt-2">
                                        <a href="{{ $investmentSi->instruction_image }}" target="_blank">
                                            <img src="{{ $investmentSi->instruction_image }}" width="100"
                                                class="rounded border">
                                        </a>
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
                                    value="{{ old('notes_image_url', $investmentSi->notes_image) }}">

                                @if (old('notes_image_url'))
                                    <div id="notes_image_preview" class="position-relative d-inline-block mt-2">
                                        <a href="{{ old('notes_image_url') }}" target="_blank">
                                            <img src="{{ old('notes_image_url') }}" width="100"
                                                class="rounded border">
                                        </a>
                                        <button type="button"
                                            class="btn btn-sm btn-danger position-absolute top-0 start-100 translate-middle"
                                            onclick="removeImage('notes_image')">
                                            ✕
                                        </button>
                                    </div>
                                @elseif ($investmentSi->notes_image)
                                    <div id="notes_image_preview" class="position-relative d-inline-block mt-2">
                                        <a href="{{ $investmentSi->notes_image }}" target="_blank">
                                            <img src="{{ $investmentSi->notes_image }}" width="100"
                                                class="rounded border">
                                        </a>
                                        <button type="button"
                                            class="btn btn-sm btn-danger position-absolute top-0 start-100 translate-middle"
                                            onclick="removeImage('notes_image')">
                                            ✕
                                        </button>
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">
                                    Status <span class="text-danger">*</span>
                                </label>
                                <select name="status" class="form-control @error('status') is-invalid @enderror">
                                    <option value="active"
                                        {{ old('status', $investmentSi->status) == 'active' ? 'selected' : '' }}>
                                        Active
                                    </option>

                                    <option value="inactive"
                                        {{ old('status', $investmentSi->status) == 'inactive' ? 'selected' : '' }}>
                                        Inactive
                                    </option>
                                </select>


                                @error('status')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Remarks -->
                            <div class="col-md-6">
                                <label class="form-label">
                                    Remarks
                                </label>
                                <textarea name="remarks" rows="3" class="form-control @error('remarks') is-invalid @enderror">{{ old('remarks', $investmentSi->remarks) }}</textarea>

                                @error('remarks')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                        </div>

                        <!-- Submit -->
                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-primary px-4">
                                Update
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>



    @if ($errors->any() && old('scheme_id'))
        <script>
            $(document).ready(function() {
                $('#scheme_id').trigger('change'); // this will call loadSchemeData()
            });
        </script>
    @endif


@endsection

@push('scripts')
    <script src="{{ asset('assets/js/investment.js') }}"></script>
    <script>
        const instructionType = document.getElementById('instructionType');
        const scheduleCount = document.getElementById('scheduleCount');
        const originalPayout = Number(document.getElementById('originalPayoutCount').value);

        function applyRules() {
            if (instructionType.value === 'schedule') {
                scheduleCount.value = 1;
                scheduleCount.readOnly = true;
                scheduleCount.classList.add('bg-secondary', 'bg-opacity-10');
            } else {
                scheduleCount.value = Math.max(originalPayout - 1, 0);
                scheduleCount.readOnly = false;
                scheduleCount.classList.remove('bg-secondary', 'bg-opacity-10');
            }
        }

        instructionType.addEventListener('change', applyRules);
        applyRules(); // MUST run on edit load
    </script>
@endpush
