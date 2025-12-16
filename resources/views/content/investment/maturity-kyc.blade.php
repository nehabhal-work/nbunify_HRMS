@extends('layouts.master-layout')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Investment Maturity Confirmation</h5>
                    </div>

                    <div class="card-body">

                        {{-- Investment Summary --}}
                        <div class="mb-3">
                            <h6 class="fw-bold">Investment Details</h6>
                            <table class="table table-bordered small">
                                <tr>
                                    <th>Investment ID</th>
                                    <td>investment->investment_no</td>
                                </tr>
                                <tr>
                                    <th>Principal Amount</th>
                                    <td>₹ investment->principal_amount</td>
                                    {{-- <td>₹ {{ number_format($investment->principal_amount, 2) }}</td> --}}
                                </tr>
                                <tr>
                                    <th>Interest Amount</th>
                                    <td>₹ investment->interest_amount</td>
                                    {{-- <td>₹ {{ number_format($investment->interest_amount, 2) }}</td> --}}
                                </tr>
                                <tr>
                                    <th>Total Maturity Value</th>
                                    <td>total_amount</td>
                                    {{-- <td><strong>₹ {{ number_format($investment->total_amount, 2) }}</strong></td> --}}
                                </tr>
                                <tr>
                                    <th>Maturity Date</th>
                                    <td>maturity_date</td>
                                    {{-- <td>{{ \Carbon\Carbon::parse($investment->maturity_date)->format('d-m-Y') }}</td> --}}
                                </tr>
                            </table>
                        </div>

                        <form method="POST" action="#">
                            {{-- <form method="POST" action="{{ route('investment.maturity.submit') }}"> --}}
                            @csrf

                            {{-- <input type="hidden" name="investment_id" value="{{ $investment->id }}">
                            <input type="hidden" name="token" value="{{ $token }}"> --}}

                            {{-- Action Selection --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Select Action <span class="text-danger">*</span></label>

                                <select class="form-select" name="action" id="action" required>
                                    <option value="">-- Select --</option>
                                    <option value="renew_full">Renew Full Amount</option>
                                    <option value="renew_principal">Renew Principal Only</option>
                                    <option value="renew_interest">Renew Interest Only</option>
                                    <option value="partial_renew">Partial Renewal</option>
                                    <option value="close">Close Investment</option>
                                </select>
                            </div>

                            {{-- Partial Renewal Amount --}}
                            <div class="mb-3 d-none" id="partialAmountBox">
                                <label class="form-label fw-bold">Renewal Amount</label>
                                <input type="number" step="0.01" class="form-control" name="partial_amount"
                                    placeholder="Enter renewal amount">
                            </div>

                            {{-- Bank Details --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Bank Account for Payout</label>
                                <select class="form-select" name="bank_id">
                                    <option value="">-- Select Bank Account --</option>
                                    {{-- @foreach ($banks as $bank)
                                        <option value="{{ $bank->id }}">
                                            {{ $bank->bank_name }} - {{ $bank->account_no }}
                                        </option>
                                    @endforeach --}}
                                </select>
                            </div>

                            {{-- Remarks --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Remarks (Optional)</label>
                                <textarea class="form-control" name="remarks" rows="3" placeholder="Any additional instructions..."></textarea>
                            </div>

                            {{-- Declaration --}}
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" required>
                                <label class="form-check-label">
                                    I confirm that the above instructions are correct.
                                </label>
                            </div>

                            {{-- Submit --}}
                            <div class="text-end">
                                <button type="submit" class="btn btn-success">
                                    Submit Confirmation
                                </button>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('action').addEventListener('change', function() {
            const partialBox = document.getElementById('partialAmountBox');
            if (this.value === 'partial_renew') {
                partialBox.classList.remove('d-none');
            } else {
                partialBox.classList.add('d-none');
            }
        });
    </script>
@endpush
