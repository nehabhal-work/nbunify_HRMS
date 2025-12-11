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

        <form action="{{ route('client-banks.update', $clientBank->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('put')

            <input type="hidden" name="client_id" value="{{ $client->id }}">
            <div class="card-body" id="bankDetailsWrapper">
                @php
                    $op = old('operation_mode', $clientBank->operation_mode ?? 'single');
                @endphp

                <div class="bank-details-row row g-4">

                    <!-- IFSC -->
                    <div class="col-md-3">
                        <label class="form-label">IFSC Code</label>
                        <input type="text" name="ifsc_code" value="{{ old('ifsc_code', $clientBank->ifsc_code ?? '') }}"
                            class="form-control ifsc_code @error('ifsc_code') is-invalid @enderror"
                            placeholder="Enter IFSC Code">
                    </div>

                    <!-- Account Number -->
                    <div class="col-md-3">
                        <label class="form-label">Account No</label>
                        <input type="text" name="account_number"
                            value="{{ old('account_number', $clientBank->account_number ?? '') }}"
                            class="form-control account_number @error('account_number') is-invalid @enderror" maxlength="18"
                            placeholder="Enter Account Number">
                    </div>

                    <!-- Operation Mode -->
                    <div class="col-md-3">
                        <label class="form-label">Operation Mode</label>
                        <select name="operation_mode"
                            class="form-select operation_mode @error('operation_mode') is-invalid @enderror">
                            <option value="single" {{ $op === 'single' ? 'selected' : '' }}>Single</option>
                            <option value="joint" {{ $op === 'joint' ? 'selected' : '' }}>Joint</option>
                        </select>
                    </div>

                    <!-- Account Type -->
                    <div class="col-md-3">
                        <label class="form-label">Account Type</label>
                        <select name="account_type" class="form-select @error('account_type') is-invalid @enderror">
                            <option value="">Select Type</option>
                            @php
                                $selected = old('account_type', $clientBank->account_type ?? '');
                            @endphp

                            <option value="savings" {{ $selected === 'savings' ? 'selected' : '' }}>Saving Account</option>
                            <option value="current" {{ $selected === 'current' ? 'selected' : '' }}>Current Account</option>
                            <option value="od_cc" {{ $selected === 'od_cc' ? 'selected' : '' }}>Overdraft/CC</option>
                            <option value="nre" {{ $selected === 'nre' ? 'selected' : '' }}>NRE</option>
                            <option value="nri" {{ $selected === 'nri' ? 'selected' : '' }}>NRI</option>
                            <option value="nro" {{ $selected === 'nro' ? 'selected' : '' }}>NRO</option>
                            <option value="tem_deposit" {{ $selected === 'tem_deposit' ? 'selected' : '' }}>Term Deposit
                            </option>
                            <option value="ra" {{ $selected === 'ra' ? 'selected' : '' }}>Recurring</option>
                        </select>


                        @error('account_type')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Holder 1 -->
                    <div class="col-md-3 holder_names {{ in_array($op, ['joint', 'single']) ? '' : 'd-none' }}">
                        <label class="form-label">Holder Name 1</label>
                        <input type="text" name="holder_name_1"
                            value="{{ old('holder_name_1', $clientBank->holder_name_1 ?? '') }}" class="form-control">
                    </div>

                    <!-- Holder 2 -->
                    <div class="col-md-3 holder_names {{ $op === 'joint' ? '' : 'd-none' }}">
                        <label class="form-label">Holder Name 2</label>
                        <input type="text" name="holder_name_2"
                            value="{{ old('holder_name_2', $clientBank->holder_name_2 ?? '') }}" class="form-control">
                    </div>

                    <!-- Holder 3 -->
                    <div class="col-md-3 holder_names {{ $op === 'joint' ? '' : 'd-none' }}">
                        <label class="form-label">Holder Name 3</label>
                        <input type="text" name="holder_name_3"
                            value="{{ old('holder_name_3', $clientBank->holder_name_3 ?? '') }}" class="form-control">
                    </div>

                    <!-- MICR -->
                    <div class="col-md-3">
                        <label class="form-label">MICR Code</label>
                        <input type="text" name="micrcode" value="{{ old('micrcode', $clientBank->micrcode ?? '') }}"
                            class="form-control micrcode bg-secondary-subtle bg-gradient" readonly>
                    </div>

                    <!-- Bank Name -->
                    <div class="col-md-3">
                        <label class="form-label">Bank Name</label>
                        <input type="text" name="bank_name" value="{{ old('bank_name', $clientBank->bank_name ?? '') }}"
                            class="form-control bank_name bg-secondary-subtle bg-gradient" readonly>
                    </div>

                    <!-- Branch Name -->
                    <div class="col-md-3">
                        <label class="form-label">Branch Name</label>
                        <input type="text" name="branch_name"
                            value="{{ old('branch_name', $clientBank->branch_name ?? '') }}"
                            class="form-control branch_name bg-secondary-subtle bg-gradient" readonly>
                    </div>

                    <!-- Bank Code -->
                    <div class="col-md-3">
                        <label class="form-label">Bank Code</label>
                        <input type="text" name="bank_code" value="{{ old('bank_code', $clientBank->bank_code ?? '') }}"
                            class="form-control bank_code bg-secondary-subtle bg-gradient" readonly>
                    </div>

                    <!-- Cancelled Cheque Upload -->
                    {{-- {{ $clientBank->attachment_cancelled_cheque }} --}}


                    <div class="col-md-4 mb-3 ">
                        <label class="form-label">Cheque Photo</label>
                        <div class="input-group">
                            <input type="file"
                                class="form-control @error('attachment_cancelled_cheque') is-invalid @enderror"
                                id="attachment_cancelled_cheque" name="attachment_cancelled_cheque"
                                onchange="uploadTempFile(this, 'attachment_cancelled_cheque')"
                                accept=".jpg,.jpeg,.png,.pdf">
                            <button class="btn btn-outline-danger" type="button"
                                onclick="document.getElementById('attachment_cancelled_cheque').value = ''">✕</button>
                        </div>

                        @error('attachment_cancelled_cheque')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <input type="hidden" id="attachment_cancelled_cheque_url"
                            value="{{ old('attachment_cancelled_cheque_url', $clientBank->attachment_cancelled_cheque_url) }}"
                            name="attachment_cancelled_cheque_url">


                        @if ($clientBank->attachment_cancelled_cheque_url)
                            @php
                                $url = $clientBank->attachment_cancelled_cheque_url;
                                $isPdf = Str::contains(strtolower($url), 'pdf');
                            @endphp


                            <div id="attachment_cancelled_cheque_previews" class="position-relative d-inline-block my-3">

                                <a href="{{ $clientBank->attachment_cancelled_cheque_url }}" target="_blank">
                                    Click to view image &nbsp;&nbsp;&nbsp;&nbsp;
                                </a>


                                <!-- Remove (X) button -->
                                <button type="button"
                                    class="btn btn-sm btn-danger position-absolute top-0 start-100 translate-middle"
                                    onclick="removeImage('attachment_cancelled_cheque')">
                                    ✕
                                </button>
                            </div>
                        @elseif (old('attachment_cancelled_cheque_url'))
                            <div id="attachment_cancelled_cheque_preview" class="position-relative d-inline-block">
                                <img src="{{ old('attachment_cancelled_cheque_url') }}" class="rounded"
                                    style="width:200px; height:200px;">

                                <!-- Remove (X) button -->
                                <button type="button"
                                    class="btn btn-sm btn-danger position-absolute top-0 start-100 translate-middle"
                                    onclick="removeImage('attachment_cancelled_cheque')">
                                    ✕
                                </button>
                            </div>
                        @endif

                    </div>


                    <!-- Primary a/c -->
                    <div class="col-md-2">
                        <label class="form-label d-block">Primary a/c</label>
                        <input type="hidden" name="is_primary" value="0">
                        <input type="checkbox" name="is_primary"
                            class="form-check-input setPrimary @error('is_primary') is-invalid @enderror" value="1"
                            {{ old('is_primary', $clientBank->is_primary ?? 0) == 1 ? 'checked' : '' }}>

                        @error('is_primary')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>



                </div>


                <!-- Submit -->
                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-primary px-4">
                        Update
                    </button>

                    <a href="{{ route('client-banks.index', ['client_id' => $client->id]) }}"
                        class="btn btn-secondary px-4">
                        Back
                    </a>
                </div>


            </div>
        </form>
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener("change", function(e) {
            if (e.target.classList.contains("operation_mode")) {

                let row = e.target.closest(".bank-details-row");
                let holders = row.querySelectorAll(".holder_names");

                // hide all holders first
                holders.forEach(h => h.classList.add("d-none"));

                let mode = e.target.value;

                if (mode === "single") {
                    // show only Holder 1
                    if (holders[0]) holders[0].classList.remove("d-none");
                }

                if (mode === "joint") {
                    // show all 3 holders
                    holders.forEach(h => h.classList.remove("d-none"));
                }
            }
        });
    </script>
@endpush
