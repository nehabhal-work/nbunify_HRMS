@extends('layouts.master-layout')
@section('title', 'Investment')
@section('title', 'Investment-edit')

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
        <span class="text-muted fw-light">Master /</span> <a
            href="{{ route('investment.els.index') }}">EDIT-ELS-Investment</a>
    </h4>

    <div class="div d-flex justify-content-end mb-3">
        <a href="{{ route('investment.els.index') }}" class="btn btn-secondary px-4">Go back</a>

    </div>


    <form action="{{ route('investment.els.update', $investment->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('put')
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

                            {{-- {{ $investment->investment_date  "2026-02-10",}} --}}
                            <!-- Investment Date -->
                            <div class="col-md-2">
                                <label for="investment_date" class="form-label">Investment Date</label>

                                <input type="date"
                                    class="form-control invDate @error('investment_date') is-invalid @enderror"
                                    name="investment_date" id="investment_date"
                                    value="{{ old('investment_date', \Carbon\Carbon::parse($investment->investment_date)->format('Y-m-d')) }}"
                                    max="{{ now()->format('Y-m-d') }}">

                                @error('investment_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>


                            <!-- Scheme -->
                            <div class="col-md-4">
                                <label for="scheme_id" class="form-label">Scheme Name *</label>
                                <select class="form-select select21 @error('scheme_id') is-invalid @enderror"
                                    name="scheme_id" id="scheme_id" required>
                                    <option value="">Select Scheme</option>
                                </select>
                                @error('scheme_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>



                            <!-- Investment Type -->
                            <div class="col-md-2">
                                <label for="investment_type" class="form-label">Investment Type</label>
                                <select class="form-select @error('investment_type') is-invalid @enderror"
                                    id="investment_type" name="investment_type" required>
                                    <option value="single" {{ old('investment_type') == 'single' ? 'selected' : '' }}>
                                        Single
                                    </option>
                                    <option value="joined" {{ old('investment_type') == 'joined' ? 'selected' : '' }}>
                                        Joined
                                    </option>

                                </select>



                                {{-- <input type="text"
                                    class="form-control bg-secondary-subtle  @error('investment_type') is-invalid @enderror"
                                    name="investment_type" id="investment_type"
                                    value="{{ old('investment_type', 'single') }}" readonly> --}}

                                @error('investment_type')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>


                            <!-- Investment Holder -->
                            <div class="col-md-3 " id="div_holder_single">
                                <label for="client_id" class="form-label">Investment 1st Holder</label>
                                <select class="form-select select2 @error('client_id') is-invalid @enderror text-uppercase"
                                    required name="first_client_id" id="first_client_id">
                                    <option value="">Select Holder</option>
                                    @foreach ($clients as $d)
                                        <option value="{{ $d->id }}"
                                            {{ old('first_client_id', $investment->first_client_id ?? '') == $d->id ? 'selected' : '' }}
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
                                                {{ old('second_client_id', $investment->second_client_id ?? '') == $d->id ? 'selected' : '' }}
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
                                                {{ old('third_client_id', $investment->third_client_id ?? '') == $d->id ? 'selected' : '' }}
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
                                                {{ old('fourth_client_id', $investment->fourth_client_id ?? '') == $d->id ? 'selected' : '' }}
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




                            <!-- Total Invested Amount -->
                            <div class="col-md-2">
                                <label for="investment_amount" class="form-label">Total Invested Amt *</label>
                                <div class="input-group">
                                    <span class="input-group-text">₹</span>
                                    <input type="number" required
                                        class="form-control onlydigit @error('investment_amount') is-invalid @enderror"
                                        name="investment_amount" id="investment_amount"
                                        value="{{ old('investment_amount', $investment->investment_amount ?? '') }}">
                                </div>
                                @error('investment_amount')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                                <small class="text-danger investment_amount_msg"></small>
                            </div>

                            <!-- Tenure Type -->
                            <div class="col-md-2">
                                <label for="tenure_type" class="form-label">Tenure Type</label>
                                <input type="text"
                                    class="form-control bg-secondary-subtle tenure_type @error('tenure_type') is-invalid @enderror"
                                    name="tenure_type" id="tenure_type"
                                    value="{{ old('tenure_type', $investment->tenure_type ?? '') }}" readonly>
                                @error('tenure_type')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Tenure -->
                            <div class="col-md-2">
                                <label class="form-label">
                                    Tenure <span class="text-danger">*</span>
                                    <small class="text-muted" id="tenure_type_label"></small>
                                </label>

                                <select class="form-select tenure @error('tenure_count') is-invalid @enderror"
                                    name="tenure_count" id="tenure_count"
                                    data-old="{{ old('tenure_count', $investment->tenure_count ?? '') }}" required>
                                    <option value="">Select Scheme First</option>
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
                                    name="frequency" id="frequency"
                                    value="{{ old('frequency', $investment->frequency ?? '') }}" readonly>

                                @error('frequency')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>


                            <!-- ROI  -->
                            <div class="col-md-2 " id="roi-wrapper">
                                <label for="roi_percent" class="form-label">ROI *</label>
                                <div class="input-group">
                                    <input type="text"
                                        class="form-control onlydigit @error('roi') is-invalid @enderror"
                                        name="roi_percent" id="roi_percent" maxlength="5"
                                        value="{{ old('roi_percent', $investment->roi_percent ?? '') }}" required>

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
                                    name="maturity_date" id="matdate"
                                    value="{{ old('maturity_date', $investment->maturity_date ?? '') }}" readonly
                                    required />
                            </div>

                            <!-- Additional ROI  -->
                            <div class="col-md-2 d-none" id="addi_roi_box">
                                <label for="addi_roi" class="form-label">Additional ROI</label>
                                <div class="input-group">
                                    <input type="text"
                                        class="form-control onlydigit bg-info-subtle @error('additional_roi_percent') is-invalid @enderror"
                                        name="additional_roi_percent" id="addi_roi"
                                        value="{{ old('additional_roi_percent', $investment->additional_roi_percent ?? '') }}"
                                        maxlength="5">
                                    <span class="input-group-text">%</span>
                                </div>
                                <div id="addi-roi-message"></div>
                                @error('additional_roi_percent')
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
                                        id="roi_amount" value="{{ old('roi_amount', $investment->roi_amount ?? '') }}"
                                        readonly placeholder="0.00">
                                </div>
                            </div>

                            {{-- Lock-in Period Type --}}

                            <div class="col-md-2 mb-3">
                                <label class="form-label fw-semibold">
                                    Lock-in Period Type <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                    class="form-control bg-secondary-subtle @error('lock_in_period_type') is-invalid @enderror"
                                    name="lock_in_period_type" id="lock_in_period_type"
                                    value="{{ old('lock_in_period_type', $investment->lock_in_period_type ?? '') }}"
                                    readonly>

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
                                    name="lock_in_period" id="lock_in_period"
                                    value="{{ old('lock_in_period', $investment->lock_in_period ?? '') }}" readonly>

                                @error('lock_in_period')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>




                            @php
                                $hasTds = old('has_tds', $investment->has_tds ?? '0');
                            @endphp

                            <div class="col-md-2">
                                <label for="has_tds" class="form-label">TDS</label>
                                <select class="form-select @error('has_tds') is-invalid @enderror" name="has_tds"
                                    id="has_tds">

                                    <option value="0" {{ (string) $hasTds === '0' ? 'selected' : '' }}>
                                        No
                                    </option>
                                    <option value="1" {{ (string) $hasTds === '1' ? 'selected' : '' }}>
                                        Yes
                                    </option>
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
                                    placeholder="Write remarks">{{ old('remarks', $investment->remarks ?? '') }}</textarea>

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
                        <small class="text-muted">Bank - Instrument Details</small>
                    </div>

                    <div class="card-body">
                        <div id="instrumentContainer">

                            @foreach (old('client_output_bank', $investment->investmentInputBank ?? [null]) as $i => $oldRow)
                                @php
                                    $row = $investment->investmentInputBank[$i] ?? null;
                                @endphp


                                <div class="instrumentRow border rounded p-3 mb-3">

                                    {{-- ROW ID (EDIT SUPPORT) --}}
                                    <input type="hidden" name="row_id[]" value="{{ $row->id ?? '' }}">

                                    <div class="row g-3">

                                        {{-- LEFT --}}
                                        <div class="col-md-6">
                                            <h6 class="fw-bold mb-3 text-primary">Client Instrument Details</h6>
                                            <div class="row g-3">

                                                {{-- Instrument --}}
                                                <div class="col-md-6">
                                                    <label class="form-label">Instrument *</label>
                                                    <select class="form-select instrumentSelect" name="instrument[]"
                                                        required>
                                                        <option value="">Select</option>
                                                        @foreach (['rtgs', 'cheque', 'upi', 'neft', 'imps', 'transfer'] as $type)
                                                            <option value="{{ $type }}"
                                                                @selected(old("instrument.$i", $row->instrument_type ?? '') == $type)>
                                                                {{ strtoupper($type) }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                {{-- Instrument Date --}}
                                                <div class="col-md-6">
                                                    <label class="form-label">Instrument Date *</label>
                                                    <input type="date" class="form-control" name="instrument_date[]"
                                                        value="{{ old("instrument_date.$i", $row->client_instrument_date ?? '') }}"
                                                        max="{{ date('Y-m-d') }}">
                                                </div>

                                                {{-- Reference No --}}
                                                <div class="col-md-6">
                                                    <label class="form-label">Reference No *</label>
                                                    <input type="text" class="form-control" name="reference_no[]"
                                                        value="{{ old("reference_no.$i", $row->client_reference_no ?? '') }}"
                                                        maxlength="50">
                                                </div>

                                                {{-- Amount --}}
                                                <div class="col-md-6">
                                                    <label class="form-label">Instrument Amount *</label>
                                                    <input type="number"
                                                        class="form-control  onlydigit client_instrument_amt"
                                                        name="instrument_amt[]"
                                                        value="{{ old("instrument_amt.$i", $row->amount ?? '') }}">
                                                </div>

                                                {{-- Client Output Bank --}}
                                                <div class="col-md-6">
                                                    <label class="form-label">Client Output Bank *</label>

                                                    <select
                                                        class="form-select clientOutputBank @error("client_output_bank.$i") is-invalid @enderror"
                                                        name="client_output_bank[]"
                                                        data-selected="{{ old("client_output_bank.$i", $row->from_client_bank_id ?? 'bhal') }}"
                                                        required>
                                                        <option value="">Select Bank</option>
                                                    </select>

                                                    @error("client_output_bank.$i")
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                {{-- Attachment --}}
                                                <div class="col-md-6">
                                                    <label class="form-label">Instrument Image</label>
                                                    <input type="file" class="form-control" name="instrumentImage[]">

                                                    <input type="hidden" name="instrumentImage_url[]"
                                                        value="{{ old("instrumentImage_url.$i", $row->attachment_instrument ?? '') }}">

                                                    @if (old("instrumentImage_url.$i", $row->attachment_instrument ?? false))
                                                        <div class="mt-2">
                                                            <a href="{{ old("instrumentImage_url.$i", $row->attachment_instrument) }}"
                                                                target="_blank">
                                                                View Existing
                                                            </a>
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>

                                        {{-- RIGHT --}}
                                        <div class="col-md-6">
                                            <h6 class="fw-bold mb-3 text-success">Company Credit Details</h6>
                                            <div class="row g-3 bg-light rounded p-2">

                                                {{-- Company Bank --}}
                                                <div class="col-md-6">
                                                    <label class="form-label">Company Bank *</label>
                                                    <select class="form-select" name="company_bank_id[]" required>
                                                        <option value="">Select Company Bank</option>
                                                        @foreach ($companyBanks as $bank)
                                                            <option value="{{ $bank->id }}"
                                                                @selected(old("company_bank_id.$i", $row->to_company_bank_id ?? '') == $bank->id)>
                                                                {{ $bank->bank_name }} - {{ $bank->account_number }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                {{-- Credit Date --}}
                                                <div class="col-md-6">
                                                    <label class="form-label">Credit Date *</label>
                                                    <input type="date" class="form-control" name="effective_date[]"
                                                        value="{{ old("effective_date.$i", $row->company_instrument_date ?? '') }}"
                                                        max="{{ date('Y-m-d') }}">
                                                </div>

                                                {{-- Company Ref No --}}
                                                <div class="col-md-6">
                                                    <label class="form-label">Company Ref No *</label>
                                                    <input type="text" class="form-control"
                                                        name="company_reference_no[]" maxlength="50"
                                                        value="{{ old("company_reference_no.$i", $row->company_reference_no ?? '') }}">
                                                </div>

                                                {{-- Company Amount --}}
                                                <div class="col-md-6">
                                                    <label class="form-label">Instrument Amount *</label>
                                                    <input type="number"
                                                        class="form-control bg-secondary-subtle company_instrument_amt bg-light"
                                                        name="company_instrument_amt[]"
                                                        value="{{ old("company_instrument_amt.$i", $row->amount ?? '') }}"
                                                        readonly>
                                                </div>

                                            </div>
                                        </div>

                                    </div>

                                    {{-- Buttons --}}
                                    <div class="mt-3 text-end">
                                        <button type="button" class="btn btn-primary addInstrumentRow">
                                            + Add More
                                        </button>
                                        <button type="button" class="btn btn-danger removeInstrumentRow">
                                            X
                                        </button>
                                    </div>

                                </div>
                            @endforeach

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
                                    <option value="{{ $d->id }}"
                                        {{ $d->id == old('from_company_bank_id', $investment->from_company_bank_id) ? 'selected' : '' }}>
                                        {{ $d->bank_name . '-' . $d->account_number }}</option>
                                @endforeach
                            </select>

                        </div>

                        <!-- Client Bank (To) -->
                        <div class="col-md-4">
                            <label class="form-label">To Client Bank <span class="text-danger">*</span></label>
                            <select class="form-select to_client_bank" name="to_client_bank_id" id="to_client_bank_id"
                                data-selected="{{ old('to_client_bank_id', $investment->to_client_bank_id) }}" required>
                                <option value="">Select Client Bank</option>
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
                        <small class="text-muted">Nominee Details</small>
                    </div>

                    <div class="card-body">

                        <div class="alert alert-info py-2">
                            <strong>Note:</strong> Total nominee percentage must be <strong>100%</strong>
                        </div>

                        <div id="nomineePercentageMsg" class="my-3 fw-semibold"></div>

                        <div id="nomineeContainer">

                            @php
                                $nominees = old('client_family_id')
                                    ? collect(old('client_family_id'))->map(function ($v, $i) {
                                        return (object) [
                                            'client_family_id' => $v,
                                            'guardian_client_family_id' => old("guardian_client_family_id.$i"),
                                            'percent' => old("percent.$i"),
                                        ];
                                    })
                                    : ($investment->nominees->count()
                                        ? $investment->nominees
                                        : collect([null]));
                            @endphp

                            @foreach ($nominees as $i => $nominee)
                                <div class="row nomineeRow mb-3">

                                    <!-- Nominee -->
                                    <div class="col-md-3">
                                        <label>Nominee Name</label>
                                        <select class="form-select select21 nominee_name" name="client_family_id[]"
                                            data-selected="{{ $nominee->client_family_id ?? '' }}" required>
                                            <option value="">Select Holder</option>
                                        </select>
                                    </div>

                                    <!-- Guardian -->
                                    <div
                                        class="col-md-3 guardian_box {{ $nominee->guardian_client_family_id ? '' : 'd-none' }}">
                                        <label>Guardian Name</label>
                                        <select class="form-select guardian_select" name="guardian_client_family_id[]"
                                            data-selected="{{ $nominee->guardian_client_family_id ?? '' }}">
                                            <option value="">Select Guardian</option>
                                        </select>
                                        <small class="text-muted">Required if nominee is minor</small>
                                    </div>

                                    <!-- Percentage -->
                                    <div class="col-md-2 nominee-percentage-wrapper">
                                        <label>Percentage %</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control nominee_percentage"
                                                name="percent[]" value="{{ $nominee->percent ?? '' }}" required>
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>

                                    <!-- Remove -->
                                    <div class="col-md-1 d-flex align-items-end">
                                        <button type="button" class="btn btn-danger removeNomineeRow">X</button>
                                    </div>

                                </div>
                            @endforeach

                        </div>

                        <div class="mt-2">
                            <button type="button" id="addNomineeRow" class="btn btn-primary">
                                Add Nominee
                            </button>
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



    {{-- /* Investment Date (#inv_date) to auto-update on keyup / change based on: instrument_date[] effective_date[] */ --}}
    <script>
        $(document).on('change', '.invDate', function() {

            let investmentDate = $(this).val();
            if (!investmentDate) return;

            // Set all Instrument Dates
            $('input[name="instrument_date[]"]').val(investmentDate);

            // Set all Effective / Credit Dates
            $('input[name="effective_date[]"]').val(investmentDate);
        });
    </script>

    {{-- calculateBtn api call --}}
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
        $(document).ready(function() {

            const selectedSchemeId = "{{ old('scheme_id', $investment->scheme_id ?? '') }}";

            $('#investment_date').on('change', function() {
                let investmentDate = $(this).val();
                if (!investmentDate) return;

                $.ajax({
                    url: "{{ route('investment.schemes.by.date') }}",
                    type: "GET",
                    data: {
                        investment_date: investmentDate
                    },
                    success: function(response) {

                        let $schemeSelect = $('#scheme_id');
                        $schemeSelect.empty();
                        $schemeSelect.append('<option value="">Select Scheme</option>');

                        if (response.length === 0) {
                            $schemeSelect.append(
                                '<option value="">No Schemes Available</option>'
                            );
                            return;
                        }

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
                                data-investment_type="${s.investment_type}">
                                ${s.name_type_value} - ${s.scheme_name}
                            </option>
                        `);
                        });

                        /* ✅ EDIT MODE: re-select saved scheme */
                        if (selectedSchemeId) {
                            $schemeSelect.val(selectedSchemeId).trigger('change');
                        }
                    }
                });
            });

            /* 🔥 Trigger on edit page load */
            $('#investment_date').trigger('change');
            $('#first_client_id').trigger('change');


        });
    </script>

    {{-- Allow submit if everything is valid --}}
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
            const roiInput = roiWrapper.querySelector('input, select');

            function toggleROI() {
                if (tenure.value) {
                    roiInput.readOnly = false;
                } else {
                    roiInput.readOnly = true;
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
