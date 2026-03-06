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
            href="{{ route('investment.els.index') }}">ELS-Investment</a>/ Standing Instruction- create
    </h4>

    <div class="div d-flex justify-content-end mb-3">
        <a href="{{ route('investment.els.index') }}" class="btn btn-secondary px-4">Go back</a>

    </div>





    <form action="{{ route('investment.si.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Investment ID -->
        <input type="hidden" name="investment_id" value="">
        <input type="hidden" name="si_no_of_payments" value="">


        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm">

                    {{-- <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Edit Standing Instruction</h5>
                        <a href="" class="btn btn-sm btn-secondary">
                            Back
                        </a>
                    </div> --}}

                    <div class="card-body">
                        <div class="row g-3">

                            <!-- Reference No -->
                            <div class="col-md-2">
                                <label class="form-label">
                                    Reference No <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="si_number"
                                    class="form-control  @error('si_number') is-invalid @enderror"
                                    value="{{ old('si_number') }}">
                                @error('si_number')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>



                            <!--  Instruction Type -->
                            <div class="col-md-2">
                                <label class="form-label">
                                    Instruction Type
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
                            <div class="col-md-2">
                                <label class="form-label">
                                    Company Bank
                                </label>
                                <select class="form-select @error('instruction_type') is-invalid @enderror"
                                    name="instruction_type" id="instructionType" required>
                                    <option value="">bank 1</option>
                                    <option value="">bank 2</option>
                                </select>

                            </div>

                            <!-- Client Bank -->
                            <div class="col-md-2">
                                <label class="form-label">
                                    Client Bank
                                </label>
                                <select class="form-select @error('instruction_type') is-invalid @enderror"
                                    name="instruction_type" id="instructionType" required>
                                    <option value="">bank 1</option>
                                    <option value="">bank 2</option>
                                </select>
                            </div>


                            {{-- CASE 1: SI amount equals investment amount --}}
                            {{-- SCHEDULE AMOUNT → Schedule Date --}}
                            @php
                                $showScheduleDate = '';
                                $isFullAmountSI = '';
                            @endphp
                            @if ($showScheduleDate)
                                <div class="col-md-2">
                                    <label class="form-label">
                                        Schedule Date <span class="text-danger">*</span>
                                    </label>

                                    <input type="date" name="si_start_date"
                                        class="form-control bg-secondary-subtle @error('si_start_date') is-invalid @enderror"
                                        value="" readonly>
                                </div>

                                {{-- FULL AMOUNT → Maturity Date --}}
                            @elseif ($isFullAmountSI)
                                <div class="col-md-2">
                                    <label class="form-label">
                                        Maturity Date <span class="text-danger">*</span>
                                    </label>

                                    <input type="date" name="si_start_date"
                                        class="form-control bg-secondary-subtle @error('si_start_date') is-invalid @enderror"
                                        value="" readonly>
                                </div>

                                {{-- NORMAL AMOUNT → Start & End Date --}}
                            @else
                                <div class="col-md-2">
                                    <label class="form-label">
                                        Start Date <span class="text-danger">*</span>
                                    </label>

                                    <input type="date" name="si_start_date"
                                        class="form-control bg-secondary-subtle @error('si_start_date') is-invalid @enderror"
                                        value="" readonly>
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label">
                                        End Date <span class="text-danger">*</span>
                                    </label>

                                    <input type="date" name="si_end_date"
                                        class="form-control bg-secondary-subtle @error('si_end_date') is-invalid @enderror"
                                        value="{{ \Carbon\Carbon::parse($investmentSi->si_end_date)->format('Y-m-d') }}"
                                        readonly>
                                </div>
                            @endif


                            <!-- Amount -->
                            <div class="col-md-2">
                                <label class="form-label">
                                    {{ $showScheduleDate ? 'Schedule Amount' : ($isFullAmountSI ? 'Maturity Amount' : 'Amount') }}
                                </label>

                                <input type="text" name="si_amount" class="form-control bg-secondary-subtle"
                                    value="" readonly>
                            </div>




                            {{-- Payout Count --}}
                            <div class="col-md-2">
                                <label class="form-label">
                                    rest Payout Count
                                </label>

                                {{-- ORIGINAL value (reference only, NOT submitted) --}}
                                <input type="number" id="originalPayoutCount"
                                    value="{{ $investmentSi->si_no_of_payments ?? 1 }}" hidden>

                                {{-- VISIBLE + SUBMITTED --}}
                                <input type="number" name="si_no_of_payments" id="scheduleCount"
                                    class="form-control bg-secondary-subtle @error('si_no_of_payments') is-invalid @enderror"
                                    value="{{ $investmentSi->si_no_of_payments ?? '-' }}" readonly>
                            </div>



                            <!-- Reference No -->
                            <div class="col-md-2">
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

                            {{-- status active --}}
                            <div class="col-md-2">
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

                            <!-- Instruction Image -->
                            <div class="col-md-4 mb-3">
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
                            <div class="col-md-4 mb-3">
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



                            <!-- Remarks -->
                            <div class="col-md-6">
                                <label class="form-label">
                                    Remarks
                                </label>
                                <textarea name="remarks" rows="1" class="form-control @error('remarks') is-invalid @enderror">{{ old('remarks', $investmentSi->remarks) }}</textarea>

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
