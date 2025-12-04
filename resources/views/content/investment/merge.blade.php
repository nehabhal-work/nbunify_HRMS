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

    <div class="d-flex align-items-center justify-content-between mb-4">
        <h4 class="fw-bold py-3 mb-0">
            <span class="text-muted fw-light">Master /</span>
            <span class="text-primary">ELS-Investment renew</span>
            <br>
            <div class="mt-2 small text-secondary">
                For <strong class="text-dark">client->name</strong>
                <span class="mx-2">|</span>
                Scheme: <strong class="text-primary">scheme->scheme_name</strong>
                <span class="mx-2">|</span>
                Code: <span class="text-muted">scheme->scheme_code</span>
            </div>


        </h4>
    </div>

    <div class="div d-flex justify-content-end mb-3">
        <a href="{{ route('investment.els.index') }}" class="btn btn-secondary px-4">Go back</a>

    </div>

    <!-- Investment Summary (Display Only - Hardcoded for Demo) -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header">
            <h5 class="mb-0">Investment Summary</h5>
        </div>

        <div class="card-body">
            <div class="row g-4">

                <!-- Current Principal Amount -->
                <div class="col-md-4">
                    <div class="p-3 border rounded bg-light">
                        <label class="fw-semibold text-secondary">Current Principal Amount</label>
                        <div class="fs-5 fw-bold text-dark">
                            ₹1,00,000
                        </div>
                    </div>
                </div>

                <!-- Total Interest Amount -->
                <div class="col-md-4">
                    <div class="p-3 border rounded bg-light">
                        <label class="fw-semibold text-secondary">Total Interest Amount</label>
                        <div class="fs-5 fw-bold text-dark">
                            ₹18,000
                        </div>
                    </div>
                </div>

                <!-- Paid Interest Amount -->
                <div class="col-md-4">
                    <div class="p-3 border rounded bg-light">
                        <label class="fw-semibold text-secondary">Paid Interest Amount</label>
                        <div class="fs-5 fw-bold text-dark">
                            ₹6,000
                        </div>
                    </div>
                </div>

                <!-- Remaining Interest Amount -->
                <div class="col-md-4">
                    <div class="p-3 border rounded bg-light">
                        <label class="fw-semibold text-secondary">Remaining Interest Amount</label>
                        <div class="fs-5 fw-bold text-dark">
                            ₹12,000
                        </div>
                    </div>
                </div>

                <!-- Total Maturity Amount -->
                <div class="col-md-4">
                    <div class="p-3 border rounded bg-light">
                        <label class="fw-semibold text-secondary">Total Maturity Amount</label>
                        <div class="fs-5 fw-bold text-dark">
                            ₹1,18,000
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <form action="#" method="POST" enctype="multipart/form-data">
        @csrf
        @method('post')



        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <h5 class="mb-0 fw-bold">Merge Investment</h5>
                <small class="text-muted">Select an investment to merge and add top-up if needed</small>
            </div>

            <div class="card-body">
                <div class="row g-4">

                    <!-- Select Investment -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Select Investment <span class="text-danger">*</span></label>
                        <select name="merge_investment_id" id="merge_investment_id"
                            class="form-select select2 @error('merge_investment_id') is-invalid @enderror" required>

                            <option value="" disabled selected>-- Select Investment --</option>

                            <!-- Own Investment List -->
                            <optgroup label="Your Investments">
                                <option value="101">INV-101 → Principal: ₹100,000 | Tenure: 3 Yr</option>
                                <option value="102">INV-102 → Principal: ₹150,000 | Tenure: 5 Yr</option>
                            </optgroup>

                            <!-- Family Investments -->
                            <optgroup label="Family Member Investments">
                                <option value="201">INV-201 → (Wife) Anjali → ₹80,000</option>
                                <option value="202">INV-202 → (Father) Ramesh → ₹120,000</option>
                            </optgroup>

                            <!-- Other Investments -->
                            <optgroup label="Other Investments">
                                <option value="301">INV-301 → Joint Holder</option>
                                <option value="302">INV-302 → Company Investment</option>
                            </optgroup>

                        </select>

                        @error('merge_investment_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Top-Up or As-Is Option -->
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">Select Action <span class="text-danger">*</span></label>

                        <select name="merge_action" id="merge_action"
                            class="form-select @error('merge_action') is-invalid @enderror" required>
                            <option value="" disabled selected>-- Select --</option>
                            <option value="asis">As It Is (No Top-Up)</option>
                            <option value="topup">Top-Up Amount</option>
                        </select>

                        @error('merge_action')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Top-Up Amount -->
                    <div class="col-md-3 d-none" id="topupAmountBox">
                        <label class="form-label fw-semibold">Top-Up Amount</label>
                        <div class="input-group">
                            <span class="input-group-text">₹</span>
                            <input type="number" step="0.01" name="topup_amount" id="topup_amount"
                                value="{{ old('topup_amount') }}"
                                class="form-control @error('topup_amount') is-invalid @enderror" placeholder="Enter amount">
                        </div>
                        @error('topup_amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Amount -->
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">
                            Amount <span class="text-danger">*</span>
                        </label>
                        <input type="number" step="0.01" name="amount" id="amount"
                            class="form-control @error('amount') is-invalid @enderror" required>
                        @error('amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                    <!-- Remarks -->
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Remarks</label>
                        <input type="text" name="remarks" value="{{ old('remarks') }}"
                            class="form-control @error('remarks') is-invalid @enderror" placeholder="Remarks (optional)">
                        @error('remarks')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <hr class="my-4">

                <!-- Action Buttons -->
                <div class="d-flex justify-content-between">

                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Back
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-1"></i> Merge Investment
                    </button>
                </div>
            </div>
        </div>


    </form>







@endsection

@push('scripts')
    <script src="{{ asset('assets/js/investment.js') }}"></script>
@endpush
