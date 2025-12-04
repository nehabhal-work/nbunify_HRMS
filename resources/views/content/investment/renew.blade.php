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



        <!-- Withdrawal Form -->
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="row g-4 align-items-end">

                    <!-- Proof of Communication -->
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">
                            Proof of Communication <span class="text-danger">*</span>
                        </label>
                        <input type="file" class="form-control @error('proof_file') is-invalid @enderror"
                            name="proof_file" required>
                        @error('proof_file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Dropdown: Withdraw / Add-On Type -->
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">
                            Action Type <span class="text-danger">*</span>
                        </label>
                        <select name="withdraw_type" id="withdraw_type" class="form-select" required>
                            <option value="" disabled selected>Select Type</option>

                            <!-- Withdraw Options -->
                            <option value="full">Full Amount</option>
                            <option value="principal">Only Principal Amount</option>
                            <option value="interest">Only Interest Amount</option>

                            <!-- Add-On Option -->
                            <option value="addon">Add-On Investment</option>
                        </select>
                    </div>

                    <!-- Amount -->
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">
                            Amount <span class="text-danger">*</span>
                        </label>
                        <input type="number" step="0.01" name="amount" id="amount"
                            class="form-control @error('amount') is-invalid @enderror" required>
                        @error('amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr class="my-4">

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-between">

                        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Back
                        </a>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i> Renew Investment
                        </button>
                    </div>

                </div>

            </div>
        </div>

    </form>







@endsection

@push('scripts')
    <script src="{{ asset('assets/js/investment.js') }}"></script>
@endpush
