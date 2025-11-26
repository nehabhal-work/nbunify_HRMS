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
                                    value="{{ old('investment_date', date('Y-m-d')) }}" max="{{ date('Y-m-d') }}" required>

                                @error('investment_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Investment Type -->
                            <div class="col-md-2">
                                <label for="investment_type" class="form-label">Investment Type</label>
                                <select class="form-select @error('investment_type') is-invalid @enderror"
                                    name="investment_type" id="investment_type" required>
                                    <option value="single" selected>Single</option>
                                    <option value="joined">Joined</option>
                                </select>

                                @error('investment_type')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Investment Holder -->
                            <div class="col-md-8 holderBox" id="holder_single">
                                <label for="client_id" class="form-label">Investment Holder</label>
                                <select class="form-select select2 @error('client_id') is-invalid @enderror"
                                    name="client_id" id="client_id" required>
                                    <option value="">Select Holder</option>
                                    {{-- @foreach ($profile as $d)
                                        <option value="{{ $d->id }}" data-banks='@json($d->banking)'
                                            data-family='@json($d->family)' data-dob="{{ $d->dob }}">
                                            {{ ucfirst(strtolower($d->fname)) }}
                                        </option>
                                    @endforeach --}}
                                </select>

                                @error('client_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Scheme -->
                            <div class="col-md-4">
                                <label for="scheme_id" class="form-label">Scheme Name *</label>
                                <select
                                    class="form-select
                                    @error('scheme_id') is-invalid @enderror"
                                    name="scheme_id" id="scheme_id" required>
                                    <option value="">Select Scheme</option>

                                    {{-- @forelse ($elsScheme as $s)
                                        <option value="{{ $s->id }}" data-tenure-type="{{ $s->tenure_type }}"
                                            data-min-tenure="{{ $s->min_tenure }}" data-max-tenure="{{ $s->max_tenure }}"
                                            data-frequencies="{{ $s->frequency }}" data-min-roi="{{ $s->min_roi }}"
                                            data-max-roi="{{ $s->max_roi }}" data-addi-roi="{{ $s->additional_roi }}"
                                            data-scheme-name="{{ $s->name }}">
                                            {{ $s->name }}
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
                                <label for="invested_amount" class="form-label">Total Invested Amount *</label>
                                <div class="input-group">
                                    <span class="input-group-text">₹</span>
                                    <input type="number"
                                        class="form-control onlydigit @error('invested_amount') is-invalid @enderror"
                                        name="invested_amount" id="invested_amount" value="{{ old('invested_amount') }}"
                                        required>
                                </div>

                                @error('invested_amount')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Tenure Type -->
                            <div class="col-md-2">
                                <label for="tenure_type" class="form-label">Tenure Type</label>
                                <input type="text"
                                    class="form-control bg-secondary-subtle @error('tenure_type') is-invalid @enderror"
                                    name="tenure_type" id="tenure_type" readonly required>

                                @error('tenure_type')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Tenure -->
                            <div class="col-md-2">
                                <label for="tenure" class="form-label">Tenure *</label>
                                <select class="form-select @error('tenure') is-invalid @enderror" name="tenure"
                                    id="tenure" required>
                                    <!-- options loaded by JS -->
                                </select>

                                @error('tenure')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Frequency -->
                            <div class="col-md-2">
                                <label for="frequency" class="form-label">Frequency *</label>
                                <select class="form-select @error('frequency') is-invalid @enderror" name="frequency"
                                    id="frequency" required>
                                    <!-- Loaded via jQuery -->
                                </select>

                                @error('frequency')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- ROI -->
                            <div class="col-md-2">
                                <label for="roi" class="form-label">ROI *</label>
                                <div class="input-group">
                                    <input type="text" class="form-control @error('roi') is-invalid @enderror"
                                        name="roi" id="roi" maxlength="5" required>
                                    <span class="input-group-text">%</span>
                                </div>

                                <small class="text-muted d-block mt-1">Select a scheme to see allowed ROI range</small>
                                <div id="roi-message"></div>

                                @error('roi')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Additional ROI -->
                            <div class="col-md-2 d-none" id="addi_roi_box">
                                <label for="addi_roi" class="form-label">Additional ROI</label>
                                <div class="input-group">
                                    <input type="text"
                                        class="form-control onlydigit bg-info-subtle @error('addi_roi') is-invalid @enderror"
                                        name="addi_roi" id="addi_roi" maxlength="5">
                                    <span class="input-group-text">%</span>
                                </div>

                                @error('addi_roi')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Maturity Date -->
                            <div class="col-md-2">
                                <label for="maturity_date" class="form-label">Maturity Date</label>
                                <input type="date"
                                    class="form-control bg-secondary-subtle @error('maturity_date') is-invalid @enderror"
                                    name="maturity_date" id="maturity_date" readonly required>

                                @error('maturity_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Payout Amount -->
                            <div class="col-md-2">
                                <label for="payout_amount" class="form-label">Interest / Payout Amount</label>
                                <div class="input-group">
                                    <span class="input-group-text">₹</span>
                                    <input type="number"
                                        class="form-control bg-secondary-subtle onlydigit @error('int_payout_amount') is-invalid @enderror"
                                        name="int_payout_amount" id="payout_amount" readonly required>
                                </div>

                                @error('int_payout_amount')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- TDS -->
                            <div class="col-md-2">
                                <label for="tds" class="form-label">TDS</label>
                                <select class="form-select @error('tds') is-invalid @enderror" name="tds"
                                    id="tds">
                                    <option value="no">No</option>
                                    <option value="yes">Yes</option>
                                </select>

                                @error('tds')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>








                        </div>

                        {{-- address section --}}
                        <div class="row">
                            <!-- Residential Address -->
                            <h6 class="my-3">Residential Address</h6>

                            <!-- Company Bank (From) -->
                            <div class="col-md-4">
                                <label class="form-label text-danger">From Company Bank *</label>
                                <select class="form-select" id="out_company_bank" name="out_company_bank" required>
                                    <option value="">Select Company Bank</option>

                                </select>

                            </div>

                            <!-- Client Bank (To) -->
                            <div class="col-md-4">
                                <label class="form-label text-danger">To Client Bank *</label>
                                <select class="form-select to_client_bank" name="to_client_bank" required>
                                    <option value="">Select Client Bank</option>
                                </select>
                            </div>



                        </div>

                        <!-- Submit -->
                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-primary px-4">Save</button>
                            <a href="{{ route('investment.els.index') }}" class="btn btn-secondary px-4">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>





        </div>
    </form>



    <div class="row">
        <!-- TABLE SECTION -->

        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">investment List</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table srkdataTable ">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>investment</th>
                                    <th>code</th>
                                    <th>Contact Person</th>
                                    <th>Number</th>
                                    <th>Email</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Example static row (replace with @foreach later) --}}

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection

@push('scripts')
@endpush
