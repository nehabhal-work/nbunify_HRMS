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


    {{-- <div class="d-flex align-items-center justify-content-between mb-4">
        <h4 class="fw-bold py-3 mb-0">
            <span class="text-muted fw-light">Master /</span>
            <span class="text-primary">ELS-Payout Schedule</span>
            <br>
            <div class="mt-2 small text-secondary">
                For <strong class="text-dark">{{ $client->name }}</strong>
                <span class="mx-2">|</span>
                Scheme: <strong class="text-primary">{{ $scheme->scheme_name }}</strong>
                <span class="mx-2">|</span>
                Code: <span class="text-muted">{{ $scheme->scheme_code }}</span>
            </div>


        </h4>
    </div> --}}


    <!-- Investment Summary -->
    {{-- <div class="card shadow-sm mb-4 p-4">
        <h6 class="fw-bold mb-2">Investment Summary</h6>

        <div class="row mb-1">
            <div class="col-md-4">
                <strong>Investment Date:</strong>
                {{ \Carbon\Carbon::parse($result['investment_date'])->format('d-M-Y') }}
            </div>

            <div class="col-md-4">
                <strong>Investment Type:</strong>
                {{ ucfirst($result['investment_type']) }}
            </div>

            <div class="col-md-4">
                <strong>Investment Amount:</strong>
                ₹{{ number_format($result['investment_amount'], 2) }}
            </div>
        </div>

        <div class="row mb-1">
            <div class="col-md-4">
                <strong>Tenure:</strong>
                {{ $result['tenure_count'] }} {{ ucfirst($result['tenure_type']) }}
            </div>

            <div class="col-md-4">
                <strong>Frequency:</strong>
                {{ ucfirst($result['frequency']) }}
            </div>

            <div class="col-md-4">
                <strong>ROI (%):</strong>
                {{ $result['roi_percent'] }}%
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <strong>Annual Payout:</strong>
                ₹{{ number_format($result['annual_payout'], 2) }}
            </div>

            <div class="col-md-4">
                <strong>Client Bank ID:</strong>
                {{ $result['client_bank_id'] ?: '-' }}
            </div>

            <div class="col-md-4">
                <strong>Company Bank ID:</strong>
                {{ $result['company_bank_id'] ?: '-' }}
            </div>
        </div>
    </div> --}}


    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Set standing instruction</h5>


                </div>

                <div class="card-body">

                    <form action="{{ route('investment.els.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')

                        <div class="row g-3">

                            <!-- Reference No -->
                            <div class="col-md-3">
                                <label class="form-label">Reference No</label>
                                <input type="text" name="reference_no"
                                    class="form-control @error('reference_no') is-invalid @enderror"
                                    value="{{ old('reference_no') }}" placeholder="Enter reference no">

                                @error('reference_no')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Company Bank -->
                            <div class="col-md-3">
                                <label class="form-label">Company Bank</label>
                                <select name="company_bank" class="form-select @error('company_bank') is-invalid @enderror">
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
                                <label class="form-label">Client Bank</label>
                                <select name="client_bank" class="form-select @error('client_bank') is-invalid @enderror">
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
                                <label class="form-label">Payment Start Date</label>
                                <input type="date" name="payment_start_date"
                                    class="form-control @error('payment_start_date') is-invalid @enderror"
                                    value="{{ old('payment_start_date') }}">

                                @error('payment_start_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Amount -->
                            <div class="col-md-3">
                                <label class="form-label">Amount</label>
                                <input type="number" step="0.01" name="amount"
                                    class="form-control @error('amount') is-invalid @enderror" value="{{ old('amount') }}"
                                    placeholder="Enter amount">

                                @error('amount')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Instruction Image -->
                            <div class="col-md-3">
                                <label class="form-label">Instruction Image</label>
                                <input type="file" name="instruction_image"
                                    class="form-control @error('instruction_image') is-invalid @enderror">

                                @error('instruction_image')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Notes Image -->
                            <div class="col-md-3">
                                <label class="form-label">Notes Image</label>
                                <input type="file" name="notes_image"
                                    class="form-control @error('notes_image') is-invalid @enderror">

                                @error('notes_image')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Remarks -->
                            <div class="col-md-6">
                                <label class="form-label">Remarks</label>
                                <textarea name="remarks" rows="3" class="form-control @error('remarks') is-invalid @enderror"
                                    placeholder="Write remarks">{{ old('remarks') }}</textarea>

                                @error('remarks')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                        </div>

                        <!-- Submit -->
                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-primary px-4">Save</button>
                        </div>
                    </form>




                </div>
            </div>

        </div>
    </div>



@endsection

@push('scripts')
@endpush
