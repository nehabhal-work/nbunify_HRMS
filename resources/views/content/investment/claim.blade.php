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
            <span class="text-primary">ELS-Investment Claim</span>
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

                    <h5 class="fw-bold mb-3">Upload Required Documents</h5>

                    <div class="row g-4">

                        <!-- Death Intimation Letter -->
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Death Intimation Letter / Mail <span
                                    class="text-danger">*</span></label>
                            <input type="file" name="death_intimation"
                                class="form-control @error('death_intimation') is-invalid @enderror"
                                accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" required>
                            @error('death_intimation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- PAN Card -->
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">PAN Card <span class="text-danger">*</span></label>
                            <input type="file" name="pan_card"
                                class="form-control @error('pan_card') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png"
                                required>
                            @error('pan_card')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Aadhar Card -->
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Aadhar Card <span class="text-danger">*</span></label>
                            <input type="file" name="aadhar_card"
                                class="form-control @error('aadhar_card') is-invalid @enderror"
                                accept=".pdf,.jpg,.jpeg,.png" required>
                            @error('aadhar_card')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Cheque Copy -->
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Cheque Copy <span class="text-danger">*</span></label>
                            <input type="file" name="cheque_copy"
                                class="form-control @error('cheque_copy') is-invalid @enderror"
                                accept=".pdf,.jpg,.jpeg,.png" required>
                            @error('cheque_copy')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Death Certificate -->
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Death Certificate <span
                                    class="text-danger">*</span></label>
                            <input type="file" name="death_certificate"
                                class="form-control @error('death_certificate') is-invalid @enderror"
                                accept=".pdf,.jpg,.jpeg,.png" required>
                            @error('death_certificate')
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
                                <i class="bi bi-check-circle me-1"></i> Submit
                            </button>
                        </div>

                    </div>


                </div>

            </div>
        </div>

    </form>







@endsection

@push('scripts')
    <script src="{{ asset('assets/js/investment.js') }}"></script>
@endpush
