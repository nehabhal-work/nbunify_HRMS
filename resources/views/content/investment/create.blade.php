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
    <style>
        /* Dropdown list items */
        .select2-results__option {
            text-transform: uppercase;
        }

        /* Selected value */
        .select2-selection__rendered {
            text-transform: uppercase;
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
    <form action="{{ route('investment.els.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('post')
        <input type="hidden" id="nomineePerentageSum" value="0">
        {{-- investment Basic Details --}}
        <div class="row align-items-stretch">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">investment Information</h5>
                        <small class="text-muted float-end">investment Basic Details</small>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">


                            <!-- Investment Date -->
                            <div class="col-md-2">
                                <label for="investment_date" class="form-label">Investment Date</label>
                                <input type="date" class="form-control invDate" name="investment_date"
                                    id="investment_date" value="{{ old('investment_date', date('Y-m-d')) }}"
                                    max="{{ date('Y-m-d') }}">


                                @error('investment_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Investment Type -->
                            <div class="col-md-2">
                                <label for="investment_type" class="form-label">Investment Type</label>
                                <select class="form-select @error('investment_type') is-invalid @enderror"
                                    name="investment_type" id="investment_type">
                                    <option value="single" {{ old('investment_type') == 'single' ? 'selected' : '' }}>
                                        Single
                                    </option>
                                    <option value="joined" {{ old('investment_type') == 'joined' ? 'selected' : '' }}>
                                        Joined
                                    </option>

                                </select>

                                @error('investment_type')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>


                            {{-- {{ $clients }} --}}
                            <!-- Investment Holder -->
                            <div class="col-md-3 " id="div_holder_single">
                                <label for="client_id" class="form-label">Investment 1st Holder</label>
                                <select class="form-select select2 @error('client_id') is-invalid @enderror text-uppercase"
                                    required name="first_client_id" id="first_client_id">
                                    <option value="">Select Holder</option>
                                    @foreach ($clients as $d)
                                        <option value="{{ $d->id }}"
                                            {{ old('client_id') == $d->id ? 'selected' : '' }}
                                            data-banks='@json($d->banks)'
                                            data-families='@json($d->families)'>
                                            {{ $d->name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('client_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div id="div_other_holders" class="row d-none mt-3">

                                <!-- 2nd Holder -->
                                <div class="col-md-3 holder-box" id="holder_2">
                                    <label class="form-label">Investment 2nd Holder</label>
                                    <select class="form-select select2" name="second_client_id" id="second_client">
                                        <option value="">Select Holder</option>
                                        @foreach ($clients as $d)
                                            <option value="{{ $d->id }}"
                                                {{ old('second_client_id') == $d->id ? 'selected' : '' }}
                                                data-banks='@json($d->banks)'
                                                data-families='@json($d->families)'>
                                                {{ ucfirst(strtolower($d->name)) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- 3rd Holder -->
                                <div class="col-md-3 holder-box d-none" id="holder_3">
                                    <label class="form-label">Investment 3rd Holder</label>
                                    <select class="form-select select2" name="third_client_id" id="third_client">
                                        <option value="">Select Holder</option>
                                        @foreach ($clients as $d)
                                            <option value="{{ $d->id }}"
                                                {{ old('third_client_id') == $d->id ? 'selected' : '' }}
                                                data-banks='@json($d->banks)'
                                                data-families='@json($d->families)'>
                                                {{ ucfirst(strtolower($d->name)) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- 4th Holder -->
                                <div class="col-md-3 holder-box d-none" id="holder_4">
                                    <label class="form-label">Investment 4th Holder</label>
                                    <select class="form-select select2" name="fourth_client_id" id="fourth_client">
                                        <option value="">Select Holder</option>
                                        @foreach ($clients as $d)
                                            <option value="{{ $d->id }}"
                                                {{ old('fourth_client_id') == $d->id ? 'selected' : '' }}
                                                data-banks='@json($d->banks)'
                                                data-families='@json($d->families)'>
                                                {{ ucfirst(strtolower($d->name)) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Add More Button -->
                                <!-- Action Buttons -->
                                <div class="col-md-3 align-self-end d-flex gap-2">
                                    <button type="button" class="btn btn-outline-primary btn-sm" id="addHolderBtn">
                                        + Add Holder
                                    </button>
                                    <button type="button" class="btn btn-outline-danger btn-sm d-none"
                                        id="removeHolderBtn">
                                        − Remove Holder
                                    </button>
                                </div>


                            </div>

                            <!-- Scheme -->
                            <div class="col-md-4">
                                <label for="scheme_id" class="form-label">Scheme Name *</label>
                                <select class="form-select select21 @error('scheme_id') is-invalid @enderror"
                                    name="scheme_id" id="scheme_id" required>

                                    <option value="">Select Scheme</option>

                                    {{-- @forelse ($scheme as $s)
                                        <option value="{{ $s->id }}"
                                            {{ old('scheme_id') == $s->id ? 'selected' : '' }}
                                            data-tenure-type="{{ $s->tenure_type }}"
                                            data-min-tenure="{{ $s->tenure_min }}" data-max-tenure="{{ $s->tenure_max }}"
                                            data-frequencies='@json($s->frequency)'
                                            data-min-roi="{{ $s->roi_min }}" data-max-roi="{{ $s->roi_max }}"
                                            data-addi-roi-min="{{ $s->roi_min_additional }}"
                                            data-addi-roi-max="{{ $s->roi_max_additional }}"
                                            data-scheme-name="{{ $s->scheme_name }}"
                                            data-start-date="{{ $s->scheme_name }}"
                                            data-end-date="{{ $s->scheme_name }}">

                                            {{ $s->scheme_name }}
                                        </option>
                                    @empty
                                        <option value="">No Schemes Available</option>
                                    @endforelse --}}
                                </select>
                                @error('scheme_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>


                            <!-- Total Invested Amount -->
                            <div class="col-md-2">
                                <label for="investment_amount" class="form-label">Total Invested Amt *</label>
                                <div class="input-group">
                                    <span class="input-group-text">₹</span>
                                    <input type="number" required
                                        class="form-control onlydigit @error('investment_amount') is-invalid @enderror"
                                        name="investment_amount" id="investment_amount"
                                        value="{{ old('investment_amount') }}">
                                </div>
                                @error('investment_amount')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                                <small class="text-danger errmsg "></small>
                            </div>

                            <!-- Tenure Type -->
                            <div class="col-md-2">
                                <label for="tenure_type" class="form-label">Tenure Type</label>
                                <input type="text"
                                    class="form-control bg-secondary-subtle tenure_type @error('tenure_type') is-invalid @enderror"
                                    name="tenure_type" id="tenure_type" value="{{ old('tenure_type') }}" readonly>
                                @error('tenure_type')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Tenure -->
                            <div class="col-md-2">
                                <label for="tenure" class="form-label">Tenure *</label>
                                <select class="form-select tenure @error('tenure_count') is-invalid @enderror"
                                    name="tenure_count" id="tenure_count" required>
                                    <!-- options loaded by JS -->
                                </select>
                                @error('tenure_count')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Frequency -->

                            <div class="col-md-2">
                                <label for="frequency" class="form-label">Frequency *</label>
                                <input type="text"
                                    class="form-control bg-secondary-subtle @error('frequency') is-invalid @enderror"
                                    name="frequency" id="frequency" readonly>

                                @error('frequency')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>


                            <!-- ROI  -->
                            <div class="col-md-2 d-none" id="roi-wrapper">
                                <label for="roi_percent" class="form-label">ROI *</label>
                                <div class="input-group">
                                    <input type="text"
                                        class="form-control onlydigit @error('roi') is-invalid @enderror"
                                        name="roi_percent" id="roi_percent" maxlength="5"
                                        value="{{ old('roi_percent') }}" required>

                                    <span class="input-group-text">%</span>
                                </div>
                                <div id="roi-message"></div>

                                @error('roi_percent')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Maturity Date -->
                            <div class="col-md-2">
                                <label class="form-label">Maturity Date</label>
                                <input type="date" class="form-control matdate bg-secondary-subtle"
                                    name="maturity_date" id="matdate" readonly required />
                            </div>

                            <!-- Additional ROI  -->
                            <div class="col-md-2 d-none" id="addi_roi_box">
                                <label for="addi_roi" class="form-label">Additional ROI</label>
                                <div class="input-group">
                                    <input type="text"
                                        class="form-control onlydigit bg-info-subtle @error('addi_roi') is-invalid @enderror"
                                        name="additional_roi_percent" id="addi_roi" maxlength="5">
                                    <span class="input-group-text">%</span>
                                </div>
                                <div id="addi-roi-message"></div>
                                @error('addi_roi')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-2 mb-3">
                                <label class="form-label fw-semibold">Interest Amount</label>

                                <div class="input-group">
                                    <span class="input-group-text">
                                        ₹
                                    </span>
                                    <input type="text" class="form-control text-end fw-semibold bg-info-subtle"
                                        id="roi_amount" readonly placeholder="0.00">
                                </div>
                            </div>

                            {{-- Lock-in Period Type --}}

                            <div class="col-md-2 mb-3">
                                <label class="form-label fw-semibold">
                                    Lock-in Period Type <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                    class="form-control bg-secondary-subtle @error('lock_in_period_type') is-invalid @enderror"
                                    name="lock_in_period_type" id="lock_in_period_type" readonly>

                                @error('lock_in_period_type')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>



                            {{-- Lock-in Period --}}

                            <div class="col-md-2 mb-3">
                                <label class="form-label fw-semibold">
                                    Lock-in Period <span class="text-danger">*</span>
                                </label>
                                <input type="number"
                                    class="form-control bg-secondary-subtle @error('lock_in_period') is-invalid @enderror"
                                    name="lock_in_period" id="lock_in_period" readonly>

                                @error('lock_in_period')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>




                            <!-- TDS -->
                            <div class="col-md-2">
                                <label for="has_tds" class="form-label">TDS</label>
                                <select class="form-select @error('has_tds') is-invalid @enderror" name="has_tds"
                                    id="has_tds">
                                    <option value="0" {{ old('has_tds') == '0' ? 'selected' : '' }}>No</option>
                                    <option value="1" {{ old('has_tds') == '1' ? 'selected' : '' }}>Yes</option>
                                </select>

                                @error('has_tds')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <!-- Remarks -->
                            <div class="col-md-4">
                                <label class="form-label">
                                    Remarks
                                </label>
                                <textarea name="remarks" rows="2" class="form-control @error('remarks') is-invalid @enderror"
                                    placeholder="Write remarks">{{ old('remarks') }}</textarea>

                                @error('remarks')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div>
            <h3 id="remainingBalanceMsg" class="fw-semibold d-block mt-1"></h3>
        </div>
        {{-- Bank / Instrument Details --}}
        <div class="row align-items-stretch">
            <div class="col-md-12">
                <div class="card mb-4">

                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Bank / Instrument Details</h5>
                        <small class="text-muted float-end">Bank - Instrument Details</small>
                    </div>

                    <div class="card-body">
                        <div id="instrumentContainer">

                            <div class="instrumentRow border rounded p-3 mb-3">
                                <div class="row g-3">

                                    <!-- LEFT SIDE -->
                                    <div class="col-md-6">
                                        <h6 class="fw-bold mb-3 text-primary">Client Instrument Details</h6>
                                        <div class="row g-3">
                                            <!-- Instrument -->
                                            <div class="col-md-6">
                                                <label class="form-label">Instrument <span
                                                        class="text-danger">*</span></label>
                                                <select
                                                    class="form-select instrumentSelect @error('instrument') is-invalid @enderror"
                                                    name="instrument[]" required>

                                                    <option value="">select..</option>
                                                    <option value="rtgs"
                                                        {{ old('instrument') == 'rtgs' ? 'selected' : '' }}>
                                                        RTGS
                                                    </option>
                                                    <option value="cheque"
                                                        {{ old('instrument') == 'cheque' ? 'selected' : '' }}>
                                                        CHEQUE</option>
                                                    <option value="upi"
                                                        {{ old('instrument') == 'upi' ? 'selected' : '' }}>UPI
                                                    </option>
                                                    <option value="neft"
                                                        {{ old('instrument') == 'neft' ? 'selected' : '' }}>
                                                        NEFT
                                                    </option>
                                                    <option value="imps"
                                                        {{ old('instrument') == 'imps' ? 'selected' : '' }}>
                                                        IMPS
                                                    </option>
                                                    <option value="transfer"
                                                        {{ old('instrument') == 'transfer' ? 'selected' : '' }}>
                                                        TRANSFER
                                                    </option>
                                                </select>
                                                @error('instrument')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Instrument Date -->
                                            <div class="col-md-6">
                                                <label class="form-label">Instrument Date <span
                                                        class="text-danger">*</span></label>
                                                <input type="date"
                                                    class="form-control @error('instrument_date.0') is-invalid @enderror"
                                                    name="instrument_date[]" value="{{ old('instrument_date.0') }}"
                                                    max="{{ date('Y-m-d') }}">
                                                @error('instrument_date.0')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Reference No -->
                                            <div class="col-md-6">
                                                <label class="form-label">Reference No <span
                                                        class="text-danger">*</span></label>
                                                <input type="text"
                                                    class="form-control @error('reference_no.0') is-invalid @enderror"
                                                    name="reference_no[]" value="{{ old('reference_no.0') }}"
                                                    maxlength="20">
                                                @error('reference_no.0')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Instrument Amount -->
                                            <div class="col-md-6">
                                                <label class="form-label">Instrument Amount <span
                                                        class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text">&#8377;</span>
                                                    <input type="number"
                                                        class="form-control bg-secondary-subtle onlydigit instrument_amt client_instrument_amt @error('instrument_amt.0') is-invalid @enderror"
                                                        name="instrument_amt[]" value="{{ old('instrument_amt.0') }}">
                                                </div>
                                                @error('instrument_amt.0')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Client Output Bank -->
                                            <div class="col-md-6">
                                                <label class="form-label">Client Output Bank <span
                                                        class="text-danger">*</span></label>
                                                <select
                                                    class="form-select clientOutputBank @error('client_output_bank.0') is-invalid @enderror"
                                                    name="client_output_bank[]" required>
                                                    <option value="">Select Bank</option>
                                                </select>
                                                @error('client_output_bank.0')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Instrument Image -->
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">
                                                    Instrument Image <span class="text-danger">*</span>
                                                </label>

                                                <div class="input-group">
                                                    <input type="file"
                                                        class="form-control fileInput instrumentImage @error('instrumentImage.0') is-invalid @enderror"
                                                        id="instrumentImage_0" name="instrumentImage[]"
                                                        accept="image/*,application/pdf"
                                                        onchange="uploadTempFile(this, 'instrumentImage_0')">

                                                    <button class="btn btn-outline-danger" type="button"
                                                        onclick="document.getElementById('instrumentImage_0').value = ''">
                                                        ✕
                                                    </button>
                                                </div>

                                                @error('instrumentImage.0')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror

                                                <input type="hidden" id="instrumentImage_0_url"
                                                    name="instrumentImage_url[]"
                                                    value="{{ old('instrumentImage_url.0') }}">

                                                @if (old('instrumentImage_url.0'))
                                                    <div id="instrumentImage_0_preview"
                                                        class="position-relative d-inline-block mt-2">
                                                        <img src="{{ old('instrumentImage_url.0') }}" width="100"
                                                            class="rounded border">

                                                        <button type="button"
                                                            class="btn btn-sm btn-danger position-absolute top-0 start-100 translate-middle"
                                                            onclick="removeImage('instrumentImage_0')">
                                                            ✕
                                                        </button>
                                                    </div>
                                                @endif
                                            </div>


                                        </div>
                                    </div>

                                    <!-- RIGHT SIDE -->
                                    <div class="col-md-6  ">

                                        <h6 class="fw-bold mb-3 text-success">Company Credit Details</h6>
                                        <div class="row g-3 rounded" style="background:#f8f9fa;">

                                            <!-- Company Bank -->
                                            <div class="col-md-6">
                                                <label class="form-label">
                                                    Company Bank <span class="text-danger">*</span>
                                                </label>
                                                <select class="form-select @error('company_bank_id') is-invalid @enderror"
                                                    name="company_bank_id[]" required>
                                                    <option value="">Select Company Bank</option>
                                                    @foreach ($companyBanks as $d)
                                                        <option value="{{ $d->id }}">
                                                            {{ $d->bank_name . '-' . $d->account_number }}</option>
                                                    @endforeach
                                                </select>
                                                @error('company_bank_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Effective / Credit Date -->
                                            <div class="col-md-6">
                                                <label class="form-label">
                                                    Effective / Credit Date <span class="text-danger">*</span>
                                                </label>
                                                <input type="date"
                                                    class="form-control @error('effective_date.0') is-invalid @enderror"
                                                    name="effective_date[]" value="{{ old('effective_date.0') }}"
                                                    max="{{ date('Y-m-d') }}">
                                                @error('effective_date.0')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Company Bank Reference No -->
                                            <div class="col-md-6 mb-5">
                                                <label class="form-label">
                                                    Company Bank Ref No <span class="text-danger">*</span>
                                                </label>
                                                <input type="text"
                                                    class="form-control companyBankRef @error('company_reference_no.0') is-invalid @enderror"
                                                    name="company_reference_no[]"
                                                    value="{{ old('company_reference_no.0') }}" maxlength="20">

                                                @error('company_reference_no.0')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Instrument Amount -->
                                            <div class="col-md-6 mb-5">
                                                <label class="form-label">Instrument Amount <span
                                                        class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text">&#8377;</span>
                                                    <input type="number"
                                                        class="form-control bg-secondary-subtle onlydigit instrument_amt company_instrument_amt @error('instrument_amt.0') is-invalid @enderror"
                                                        name="company_instrument_amt[]"
                                                        value="{{ old('instrument_amt.0') }}">
                                                </div>
                                                @error('instrument_amt.0')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <!-- Add / Remove Buttons -->
                                <div class="mt-3 text-end">
                                    <button type="button" class="btn btn-primary btn-s addInstrumentRow">+ Add
                                        More</button>
                                    <button type="button" class="btn btn-danger btn-sm1 removeInstrumentRow">X</button>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>



        <!-- 🔹 NEW OUTWARD / PAYOUT DETAILS SECTION -->
        <div class="card mb-4">
            <div class="card-body">
                <h5>Outward Bank / Payout Details</h5>
                <div id="outwardContainer" class="mb-2">
                    <div class="row g-3 outwardRow mb-2">
                        <!-- Company Bank (From) -->
                        <div class="col-md-4">
                            <label class="form-label ">From Company Bank *</label>
                            <select class="form-select" id="from_company_bank_id" name="from_company_bank_id" required>
                                <option value="">Select Company Bank</option>
                                @foreach ($companyBanks as $d)
                                    <option value="{{ $d->id }}">
                                        {{ $d->bank_name . '-' . $d->account_number }}</option>
                                @endforeach
                            </select>

                        </div>

                        <!-- Client Bank (To) -->
                        <div class="col-md-4">
                            <label class="form-label ">To Client Bank *</label>
                            <select class="form-select to_client_bank" name="to_client_bank_id" id="to_client_bank_id"
                                required>
                                {{-- <option value="">Select Client Bank</option> --}}
                                <option data-banks='@json($d->banks)'>...</option>

                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        {{-- Nominee Information --}}
        <div class="row align-items-stretch">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Nominee Information</h5>
                        <small class="text-muted float-end">Nominee Details</small>
                    </div>

                    <div class="card-body">
                        <div class="alert alert-info py-2">
                            <strong>Note:</strong> Total nominee percentage must be <strong>100%</strong> across all
                            nominees
                            added.
                        </div>
                        <div id="nomineePercentageMsg" class="my-3 fw-semibold"></div>
                        <div id="nomineeContainer">

                            <div class="row nomineeRow mb-3">

                                <div class="col-md-3">
                                    <label>Nominee Name</label>
                                    <select class="form-select select21 nominee_name" name="client_family_id[]" required>
                                        <option value="">Select Holder</option>
                                    </select>
                                </div>

                                <div class="col-md-3 guardian_box d-none">
                                    <label>Guardian Name</label>
                                    <select class="form-select guardian_select" name="guardian_client_family_id[]">
                                        <option value="">Select Guardian</option>
                                    </select>
                                    <small class="text-muted">Required because nominee is minor</small>
                                </div>

                                <div class="col-md-2 d-none nominee-percentage-wrapper">
                                    <label>Percentage %</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control nominee_percentage" name="percent[]"
                                            required>
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>


                                <div class="col-md-1 d-flex align-items-end">
                                    <button type="button" class="btn btn-danger removeNomineeRow">X</button>
                                </div>

                            </div>

                        </div>

                        <div class="mt-2">
                            <button type="button" id="addNomineeRow" class="btn btn-primary">Add Nominee</button>
                        </div>


                    </div>
                </div>
            </div>
        </div>


        <div class="card shadow-sm mt-3" id="resultCard" style="display:none;">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0 text-white">Calculated Investment Summary</h5>
            </div>

            <div class="card-body">

                {{-- Investment Overview --}}
                <div class="row g-3">

                    <div class="col-md-3">
                        <label class="fw-bold text-secondary">Investment Amount</label>
                        <div id="inv_amount" class="fs-6 fw-semibold"></div>
                    </div>

                    <div class="col-md-3">
                        <label class="fw-bold text-secondary">ROI (%)</label>
                        <div id="roi" class="fs-6 fw-semibold"></div>
                    </div>

                    <div class="col-md-3">
                        <label class="fw-bold text-secondary">Additional ROI (%)</label>
                        <div id="add_roi" name="add_roi" class="fs-6 fw-semibold"></div>
                    </div>

                    <div class="col-md-3">
                        <label class="fw-bold text-secondary">Frequency</label>
                        <div id="frequency" name="frequency" class="fs-6 fw-semibold text-capitalize"></div>
                    </div>

                    <div class="col-md-3">
                        <label class="fw-bold text-secondary">Tenure</label>
                        <div id="tenure" class="fs-6 fw-semibold"></div>
                    </div>

                    <div class="col-md-3">
                        <label class="fw-bold text-secondary">Investment Date</label>
                        <div id="inv_date" name="inv_date" class="fs-6 fw-semibold"></div>
                    </div>

                    <div class="col-md-3">
                        <label class="fw-bold text-secondary">Maturity Date</label>
                        <div id="maturity_date" class="fs-6 fw-semibold"></div>
                    </div>
                </div>

                <hr>

                {{-- Payout Summary --}}
                <div class="row g-3">

                    <div class="col-md-3">
                        <label class="fw-bold text-secondary">Annual Payout</label>
                        <div id="annual_payout" class="fs-6 fw-semibold"></div>
                    </div>

                    <div class="col-md-3">
                        <label class="fw-bold text-secondary">Payout Per Period</label>
                        <div id="period_payout" class="fs-6 fw-semibold"></div>
                    </div>

                    <div class="col-md-3">
                        <label class="fw-bold text-secondary">Total Schedules</label>
                        <div id="schedule_count" class="fs-6 fw-semibold"></div>
                    </div>

                </div>

                <hr>

                {{-- Payout Schedule Table --}}
                <h6 class="fw-bold text-primary mb-2 mt-3">Payout Schedule</h6>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Payout Date</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody id="schedule_table_body"></tbody>
                    </table>
                </div>

            </div>
        </div>




        <!-- Submit -->
        <div class="text-end mt-4">
            <button type="submit" id="btnSubmit" class="btn btn-primary px-4">Submit</button>
            <small class="text-danger" id="errSubmit"></small>
        </div>

    </form>



    @if ($errors->any() && old('scheme_id'))
        <script>
            $(document).ready(function() {
                $('#scheme_id').trigger('change'); // this will call loadSchemeData()
            });
        </script>
    @endif

    <meta name="csrf-token" content="{{ csrf_token() }}">

@endsection

@push('scripts')
    <script src="{{ asset('assets/js/investment.js') }}?v={{ time() }}"></script>
    {{-- // ---------------------------type = number maxlength 10 ------------- --}}

    <script>
        $(document).on("input",
            "#investment_amount, #roi_amount, #payout_count, #instrument_amt, #instrument_amt",
            function() {
                if (this.value.length > 10) {
                    this.value = this.value.slice(0, 10); // ✅ keep only first 10 digits
                }
            });
    </script>

    <script>
        /* Investment Date (#inv_date) to auto-update on keyup / change based on: instrument_date[] effective_date[] */

        $(document).on('change', '.invDate', function() {

            let investmentDate = $(this).val();
            if (!investmentDate) return;

            // Set all Instrument Dates
            $('input[name="instrument_date[]"]').val(investmentDate);

            // Set all Effective / Credit Dates
            $('input[name="effective_date[]"]').val(investmentDate);
        });
    </script>
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


    {{-- keep this ajax on page only. external js not working. --}}
    <script>
        $('#investment_date').on('change', function() {
            console.log("Investment date changed");
            let investmentDate = $(this).val();

            if (!investmentDate) return;

            $.ajax({
                url: "{{ route('investment.schemes.by.date') }}",
                type: "GET",
                data: {
                    investment_date: investmentDate
                },
                success: function(response) {
                    console.log("Schemes loaded:", response);
                    let $schemeSelect = $('#scheme_id');

                    // Clear existing options
                    $schemeSelect.empty();
                    $schemeSelect.append('<option value="">Select Scheme</option>');

                    if (response.length === 0) {
                        $schemeSelect.append(
                            '<option value="">No Schemes Available</option>');
                    } else {

                        $.each(response, function(key, s) {

                            $schemeSelect.append(`
    <option value="${s.id}"
        data-tenure-type="${s.tenure_type}"
        data-min-tenure="${s.tenure_min}"
        data-max-tenure="${s.tenure_max}"
        data-frequencies='${JSON.stringify(s.frequency)}'
        data-min-roi="${s.roi_min}"
        data-max-roi="${s.roi_max}"
        data-addi-roi-min="${s.roi_min_additional}"
        data-addi-roi-max="${s.roi_max_additional}"
        data-lock-in-period="${s.lock_in_period}"
data-lock-in-period-type="${s.lock_in_period_type}"

        data-scheme-name="${s.scheme_name}"
        data-start-date="${s.start_date}"
        data-end-date="${s.end_date}"
        data-min-investment="${s.min_investment}"
        data-max-investment="${s.max_investment}"
        data-investment-denomination="${s.investment_denomination}"
        >
        ${s.scheme_name}
    </option>
`);

                        });
                    }

                    // Refresh Select2
                    $schemeSelect.val('').trigger('change');
                }
            });
        });
        $('#investment_date').trigger('change'); // Trigger change on page load to load schemes
        $(sdocument).ready(function() {});
    </script>

    <script>
        $('form').on('submit', function(e) {

            let total = 0;
            let investmentAmount = parseFloat($('#investment_amount').val()) || 0;
            let nomineeTotal = parseFloat($('#nomineePerentageSum').val()) || 0;

            $('.client_instrument_amt').each(function() {
                total += parseFloat($(this).val()) || 0;
            });

            /* ===============================
             * Instrument Amount Validation
             * =============================== */
            if (total !== investmentAmount) {
                e.preventDefault();
                alert(
                    `Total Instrument Amount (₹${total.toFixed(2)}) must equal Investment Amount (₹${investmentAmount.toFixed(2)}).`
                );
                return false; // ⛔ HARD STOP
            }

            /* ===============================
             * Nominee Percentage Validation
             * =============================== */
            if (nomineeTotal >= 1 && nomineeTotal <= 99) {
                e.preventDefault();
                alert(
                    `Total Nominee Percentage (${nomineeTotal}%) must be exactly 100%.`
                );
                return false; // ⛔ HARD STOP
            }

            // ✅ Allow submit if everything is valid
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tenure = document.getElementById('tenure_count');
            const roiWrapper = document.getElementById('roi-wrapper');

            function toggleROI() {
                if (tenure.value) {
                    roiWrapper.classList.remove('d-none');
                } else {
                    roiWrapper.classList.add('d-none');
                }
            }

            toggleROI();
            tenure.addEventListener('change', toggleROI);
        });
    </script>
    <script>
        $(document).ready(function() {

            $(document).on('change', '.nominee_name', function() {
                let $row = $(this).closest('.row');
                let $percentageWrapper = $row.find('.nominee-percentage-wrapper');

                if ($(this).val()) {
                    $percentageWrapper.removeClass('d-none');
                } else {
                    $percentageWrapper.addClass('d-none');
                    $percentageWrapper.find('.nominee_percentage').val('');
                }
            });

        });
    </script>

    <script>
        $(document).on('input change', '#investment_date', function() {
            const today = new Date();
            today.setHours(0, 0, 0, 0);

            if (!this.value) return;

            const selected = new Date(this.value);
            selected.setHours(0, 0, 0, 0);

            // If future date → snap back to today
            if (selected > today) {
                this.value = today.toISOString().split('T')[0];
            }
        });
    </script>
@endpush
