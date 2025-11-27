@extends('layouts.master-layout')

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
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Bank details</h5>
            <small class="text-muted float-end">Bank Information</small>
        </div>
        <div class="card-body" id="bankDetailsWrapper">
            <div class="bank-details-row row">
                @php
                    $banks = $client->banks ?? collect([$bank ?? null]);
                @endphp

                @foreach ($banks as $index => $bank)
                    @php
                        $op = old('banks.' . $index . '.operation_mode', $bank->operation_mode ?? '');
                        $showHolder1 = in_array($op, ['joint', 'anyone']);
                        $showHolder2 = $op === 'joint';
                        $showHolder3 = $op === 'joint';

                        // if operation mode is null/empty or 'single', hide all holders
                        if (empty($op) || $op === 'single') {
                            $showHolder1 = $showHolder2 = $showHolder3 = false;
                        }
                    @endphp


                    {{-- IFSC --}}
                    <div class="col-md-4">
                        <label class="form-label">IFSC Code</label>
                        <input type="text" name="banks[{{ $index }}][ifsc_code]"
                            value="{{ old('banks.' . $index . '.ifsc_code', $bank->ifsc_code ?? '') }}"
                            class="form-control ifsc_code @error('banks.' . $index . '.ifsc_code') is-invalid @enderror"
                            placeholder="Enter IFSC Code">
                    </div>

                    {{-- Account Number --}}
                    <div class="col-md-4">
                        <label class="form-label">Account No</label>
                        <input type="text" name="banks[{{ $index }}][account_number]"
                            value="{{ old('banks.' . $index . '.account_number', $bank->account_number ?? '') }}"
                            class="form-control account_number @error('banks.' . $index . '.account_number') is-invalid @enderror"
                            maxlength="18" placeholder="Enter Account Number">
                    </div>

                    {{-- Operation Mode --}}
                    <div class="col-md-4">
                        <label class="form-label">Operation Mode</label>
                        <select name="banks[{{ $index }}][operation_mode]"
                            class="form-select operation_mode @error('banks.' . $index . '.operation_mode') is-invalid @enderror">
                            <option value="">Select Mode</option>
                            <option value="single" {{ $op === 'single' ? 'selected' : '' }}>Single</option>
                            <option value="joint" {{ $op === 'joint' ? 'selected' : '' }}>Joint</option>
                            <option value="anyone" {{ $op === 'anyone' ? 'selected' : '' }}>Anyone</option>
                        </select>
                    </div>

                    {{-- Holder Names --}}
                    @if ($showHolder1)
                        <div class="col-md-4">
                            <label class="form-label">Holder Name 1</label>
                            <input type="text" name="banks[{{ $index }}][holder_name_1]"
                                value="{{ old('banks.' . $index . '.holder_name_1', $bank->holder_name_1 ?? '') }}"
                                class="form-control">
                        </div>
                    @endif

                    @if ($showHolder2)
                        <div class="col-md-4">
                            <label class="form-label">Holder Name 2</label>
                            <input type="text" name="banks[{{ $index }}][holder_name_2]"
                                value="{{ old('banks.' . $index . '.holder_name_2', $bank->holder_name_2 ?? '') }}"
                                class="form-control">
                        </div>
                    @endif

                    @if ($showHolder3)
                        <div class="col-md-4">
                            <label class="form-label">Holder Name 3</label>
                            <input type="text" name="banks[{{ $index }}][holder_name_3]"
                                value="{{ old('banks.' . $index . '.holder_name_3', $bank->holder_name_3 ?? '') }}"
                                class="form-control">
                        </div>
                    @endif

                    {{-- MICR Code --}}
                    <div class="col-md-4">
                        <label class="form-label">MICR Code</label>
                        <input type="text" name="banks[{{ $index }}][micrcode]"
                            value="{{ old('banks.' . $index . '.micrcode', $bank->micrcode ?? '') }}"
                            class="form-control bg-secondary-subtle bg-gradient" readonly>
                    </div>

                    {{-- Bank Name --}}
                    <div class="col-md-4">
                        <label class="form-label">Bank Name</label>
                        <input type="text" name="banks[{{ $index }}][bank_name]"
                            value="{{ old('banks.' . $index . '.bank_name', $bank->bank_name ?? '') }}"
                            class="form-control bg-secondary-subtle bg-gradient" readonly>
                    </div>
                @endforeach
            </div>

            <!-- Submit -->
            <div class="text-end mt-3">
                <button type="submit" class="btn btn-primary px-4">
                    Update
                </button>

                <a href="{{ route('client-banks.index', ['client_id' => $client->id]) }}" class="btn btn-secondary px-4">
                    Back
                </a>
            </div>


        </div>

    </div>

@endsection
