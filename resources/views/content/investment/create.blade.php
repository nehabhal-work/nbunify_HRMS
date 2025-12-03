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

    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Master /</span> <a href="{{ route('investment.els.index') }}">ELS-Investment</a>
    </h4>

    <div class="div d-flex justify-content-end mb-3">
        <a href="{{ route('investment.els.index') }}" class="btn btn-secondary px-4">Go back</a>

    </div>
    <form action="{{ route('investment.els.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('post')
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
                                <input type="date" class="form-control @error('investment_date') is-invalid @enderror"
                                    name="investment_date" id="investment_date"
                                    value="{{ old('investment_date', date('Y-m-d')) }}" max="{{ date('Y-m-d') }}">

                                @error('investment_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Investment Type -->
                            <div class="col-md-2">
                                <label for="investment_type" class="form-label">Investment Type</label>
                                <select class="form-select @error('investment_type') is-invalid @enderror"
                                    name="investment_type" id="investment_type">
                                    <option value="single" {{ old('investment_type') == 'single' ? 'selected' : '' }}>Single
                                    </option>
                                    <option value="joined" {{ old('investment_type') == 'joined' ? 'selected' : '' }}>Joined
                                    </option>

                                </select>

                                @error('investment_type')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Investment Holder -->
                            <div class="col-md-3 " id="div_holder_single">
                                <label for="client_id" class="form-label">Investment 1st Holder</label>
                                <select class="form-select select2 @error('client_id') is-invalid @enderror"
                                    name="client_id" id="client_id">
                                    <option value="">Select Holder</option>
                                    @foreach ($clients as $d)
                                        <option value="{{ $d->id }}"
                                            {{ old('client_id') == $d->id ? 'selected' : '' }}>
                                            {{ ucfirst(strtolower($d->name)) }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('client_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-5 d-none" id="div_other_holders">
                                <label for="other_holders" class="form-label">Investment 2nd Holder</label>
                                <select class="form-select select2 @error('other_holders') is-invalid @enderror"
                                    name="other_holders[]" id="other_holders" multiple>
                                    <option value="">Select Holder</option>
                                    @foreach ($clients as $d)
                                        <option value="{{ $d->id }}"
                                            {{ is_array(old('other_holders')) && in_array($d->id, old('other_holders')) ? 'selected' : '' }}>
                                            {{ ucfirst(strtolower($d->name)) }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('other_holders')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Scheme -->
                            <div class="col-md-4">
                                <label for="scheme_id" class="form-label">Scheme Name *</label>
                                <select class="form-select select21 @error('scheme_id') is-invalid @enderror"
                                    name="scheme_id" id="scheme_id">

                                    <option value="">Select Scheme</option>

                                    @forelse ($scheme as $s)
                                        <option value="{{ $s->id }}"
                                            {{ old('scheme_id') == $s->id ? 'selected' : '' }}
                                            data-tenure-type="{{ $s->tenure_type }}"
                                            data-min-tenure="{{ $s->tenure_min }}" data-max-tenure="{{ $s->tenure_max }}"
                                            data-frequencies='@json($s->frequency)'
                                            data-min-roi="{{ $s->roi_min }}" data-max-roi="{{ $s->roi_max }}"
                                            data-addi-roi-min="{{ $s->roi_min_additional }}"
                                            data-addi-roi-max="{{ $s->roi_max_additional }}"
                                            data-scheme-name="{{ $s->scheme_name }}">

                                            {{ $s->scheme_name }}
                                        </option>
                                    @empty
                                        <option value="">No Schemes Available</option>
                                    @endforelse

                                </select>

                                @error('scheme_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>




                            <!-- Total Invested Amount -->
                            <div class="col-md-2">
                                <label for="investment_amount" class="form-label">Total Invested Amount *</label>
                                <div class="input-group">
                                    <span class="input-group-text">₹</span>
                                    <input type="number"
                                        class="form-control onlydigit @error('investment_amount') is-invalid @enderror"
                                        name="investment_amount" id="investment_amount"
                                        value="{{ old('investment_amount') }}">
                                </div>

                                @error('investment_amount')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Tenure Type -->
                            <div class="col-md-2">
                                <label for="tenure_type" class="form-label">Tenure Type</label>
                                <input type="text"
                                    class="form-control bg-secondary-subtle @error('tenure_type') is-invalid @enderror"
                                    name="tenure_type" id="tenure_type" value="{{ old('tenure_type') }}" readonly>

                                @error('tenure_type')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Tenure -->
                            <div class="col-md-2">
                                <label for="tenure" class="form-label">Tenure *</label>
                                <select class="form-select @error('tenure_count') is-invalid @enderror"
                                    name="tenure_count" id="tenure_count">
                                    <!-- options loaded by JS -->
                                </select>

                                @error('tenure_count')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Frequency -->
                            <div class="col-md-2">
                                <label for="frequency" class="form-label">Frequency *</label>
                                <select class="form-select @error('frequency') is-invalid @enderror" name="frequency"
                                    id="frequency">
                                    <!-- Loaded via jQuery -->
                                </select>

                                @error('frequency')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- ROI  -->
                            <div class="col-md-2">
                                <label for="roi_percent" class="form-label">ROI *</label>
                                <div class="input-group">
                                    <input type="text" class="form-control @error('roi') is-invalid @enderror"
                                        name="roi_percent" id="roi_percent" maxlength="5"
                                        value="{{ old('roi_percent') }}">
                                    <span class="input-group-text">%</span>
                                </div>
                                <div id="roi-message"></div>

                                @error('roi_percent')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
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

                        </div>
                    </div>
                </div>
            </div>
        </div>


        {{-- Bank / Instrument Details --}}
        <div class="row align-items-stretch">
            <div class="col-md-12">
                <div class="card mb-4">

                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Bank / Instrument Details</h5>
                        <small class="text-muted float-end">Bank / Instrument Details</small>
                    </div>

                    <div class="card-body">
                        <div class="row g-3">

                            <!-- Instrument -->
                            <div class="col-md-2 mt-3">
                                <label class="form-label">
                                    Instrument <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('instrument') is-invalid @enderror" name="instrument"
                                    required>
                                    <option value="">Select</option>
                                    <option value="rtgs" {{ old('instrument') == 'rtgs' ? 'selected' : '' }}>RTGS
                                    </option>
                                    <option value="cheque" {{ old('instrument') == 'cheque' ? 'selected' : '' }}>CHEQUE
                                    </option>
                                    <option value="upi" {{ old('instrument') == 'upi' ? 'selected' : '' }}>UPI</option>
                                    <option value="neft" {{ old('instrument') == 'neft' ? 'selected' : '' }}>NEFT
                                    </option>
                                    <option value="imps" {{ old('instrument') == 'imps' ? 'selected' : '' }}>IMPS
                                    </option>
                                </select>
                                @error('instrument')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Instrument Date -->
                            <div class="col-md-2 mt-3">
                                <label class="form-label">
                                    Instrument Date <span class="text-danger">*</span>
                                </label>
                                <input type="date" class="form-control @error('instrument_date') is-invalid @enderror"
                                    name="instrument_date" value="{{ old('instrument_date') }}"
                                    max="{{ date('Y-m-d') }}" required>
                                @error('instrument_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Reference No -->
                            <div class="col-md-3 mt-3">
                                <label class="form-label">
                                    Reference No <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control @error('reference_no') is-invalid @enderror"
                                    name="reference_no" value="{{ old('reference_no') }}" maxlength="20" required>
                                @error('reference_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Instrument Amount -->
                            <div class="col-md-2 mt-3">
                                <label class="form-label">
                                    Instrument Amount <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">&#8377;</span>
                                    <input type="number"
                                        class="form-control bg-secondary-subtle onlydigit instrument_amt @error('instrument_amt') is-invalid @enderror"
                                        name="instrument_amt" value="{{ old('instrument_amt') }}" required>
                                </div>
                                @error('instrument_amt')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Client Output Bank -->
                            <div class="col-md-3 mt-3">
                                <label class="form-label">
                                    Client Output Bank <span class="text-danger">*</span>
                                </label>
                                <select
                                    class="form-select clientOutputBank @error('client_output_bank') is-invalid @enderror"
                                    name="client_output_bank" required>
                                    <option value="">Select Bank</option>
                                    <!-- You will populate banks using JS -->
                                </select>
                                @error('client_output_bank')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Company Bank -->
                            <div class="col-md-3 mt-3">
                                <label class="form-label">
                                    Company Bank <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('company_bank_id') is-invalid @enderror"
                                    name="company_bank_id" required>
                                    <option value="">Select Company Bank</option>
                                </select>
                                @error('company_bank_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Instrument Image -->
                            <div class="col-md-3 mt-3">
                                <label class="form-label">
                                    Instrument Image <span class="text-danger">*</span>
                                </label>
                                <input type="file"
                                    class="form-control fileInput instrumentImage @error('instrumentImage') is-invalid @enderror"
                                    name="instrumentImage" accept="image/*,application/pdf">
                                <img src="" class="imgPreview mt-1" style="width:100px; display:none;">
                                @error('instrumentImage')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Effective / Credit Date -->
                            <div class="col-md-2 mt-3">
                                <label class="form-label">
                                    Effective / Credit Date <span class="text-danger">*</span>
                                </label>
                                <input type="date" class="form-control @error('effective_date') is-invalid @enderror"
                                    name="effective_date" value="{{ old('effective_date') }}" max="{{ date('Y-m-d') }}"
                                    required>
                                @error('effective_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>



        {{-- Set standing instruction --}}
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
                                <input type="text" name="reference_no"
                                    class="form-control @error('reference_no') is-invalid @enderror"
                                    placeholder="Enter reference no" value="{{ old('reference_no') }}">

                                @error('reference_no')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Company Bank -->
                            <div class="col-md-3">
                                <label class="form-label">
                                    Company Bank <span class="text-danger">*</span>
                                </label>
                                <select name="company_bank"
                                    class="form-select @error('company_bank') is-invalid @enderror">
                                    <option value="">Select Company Bank</option>

                                    {{-- @foreach ($companyBanks as $bank)
                                <option value="{{ $bank->id }}"
                                    {{ old('company_bank') == $bank->id ? 'selected' : '' }}>
                                    {{ $bank->bank_name }} — {{ $bank->account_no }}
                                </option>
                            @endforeach --}}
                                </select>

                                @error('company_bank')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Client Bank -->
                            <div class="col-md-3">
                                <label class="form-label">
                                    Client Bank <span class="text-danger">*</span>
                                </label>
                                <select name="client_bank"
                                    class="form-select @error('client_bank') is-invalid @enderror">
                                    <option value="">Select Client Bank</option>

                                    {{-- @foreach ($clientBanks as $bank)
                                <option value="{{ $bank->id }}"
                                    {{ old('client_bank') == $bank->id ? 'selected' : '' }}>
                                    {{ $bank->bank_name }} — {{ $bank->account_no }}
                                </option>
                            @endforeach --}}
                                </select>

                                @error('client_bank')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Payment Start Date -->
                            <div class="col-md-3">
                                <label class="form-label">
                                    Payment Start Date <span class="text-danger">*</span>
                                </label>
                                <input type="date" name="payment_start_date"
                                    class="form-control bg-secondary-subtle @error('payment_start_date') is-invalid @enderror"
                                    value="{{ old('payment_start_date') }}" readonly>

                                @error('payment_start_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Amount -->
                            <div class="col-md-3">
                                <label class="form-label">
                                    Amount <span class="text-danger">*</span>
                                </label>
                                <input type="number" step="0.01" name="amount"
                                    class="form-control @error('amount') is-invalid @enderror" placeholder="Enter amount"
                                    value="{{ old('amount') }}">

                                @error('amount')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Instruction Image -->
                            <div class="col-md-3">
                                <label class="form-label">
                                    Instruction Image <span class="text-danger">*</span>
                                </label>
                                <input type="file" name="instruction_image"
                                    class="form-control @error('instruction_image') is-invalid @enderror">

                                @error('instruction_image')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Notes Image -->
                            <div class="col-md-3">
                                <label class="form-label">
                                    Notes Image <span class="text-danger">*</span>
                                </label>
                                <input type="file" name="notes_image"
                                    class="form-control @error('notes_image') is-invalid @enderror">

                                @error('notes_image')
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
                    </div>

                </div>
            </div>
        </div>



        <!-- Submit -->
        <div class="text-end mt-4">
            <button type="submit" class="btn btn-primary px-4">Save</button>
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
@endpush
