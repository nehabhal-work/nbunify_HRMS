@extends('layouts.master-layout')

@section('content')
    <div class="container my-4">

        <div class="card shadow-sm border-0">

            <!-- Header -->
            <div class="card-header bg-primary text-white py-3">
                <h4 class="mb-0 text-white">
                    Investment Maturity Confirmation
                </h4>
                <small>Please review carefully and confirm your choice</small>
            </div>

            <div class="card-body fs-5">

                <!-- SECTION 1 : Investment Summary -->
                <div class="my-4">
                    <h5 class="fw-bold mb-3">📄 Your Investment Details</h5>

                    <div class="alert alert-warning fs-6">
                        This information is shown as per our records.
                        If any bank detail needs correction, you may update it below.
                    </div>

                    <table class="table table-bordered align-middle fs-6">
                        <tr>
                            <th width="40%">Investment ID</th>
                            <td>INV-00123</td>
                        </tr>
                        <tr>
                            <th>Principal Amount</th>
                            <td>₹ 5,00,000</td>
                        </tr>
                        <tr>
                            <th>Interest Earned</th>
                            <td>₹ 75,000</td>
                        </tr>
                        <tr class="table-success">
                            <th>Total Maturity Amount</th>
                            <td class="fw-bold">₹ 5,75,000</td>
                        </tr>
                        <tr>
                            <th>Maturity Date</th>
                            <td>15-09-2025</td>
                        </tr>
                    </table>
                </div>

                <!-- SECTION 2 : Bank Details -->
                <div class="mb-4">
                    <h5 class="fw-bold mb-3">🏦 Bank Account (For Payment)</h5>

                    <div class="bg-light p-3 rounded fs-6">
                        <p class="mb-1"><strong>Bank:</strong> State Bank of India</p>
                        <p class="mb-1"><strong>Branch:</strong> Connaught Place, New Delhi</p>
                        <p class="mb-1"><strong>Account No:</strong> XXXX-XXXX-1234</p>
                        <p class="mb-1"><strong>IFSC:</strong> SBIN0000691</p>
                    </div>

                    <p class="text-danger mt-3 fs-6">
                        If you wish to change bank details, please fill the section below.
                    </p>
                </div>

                <!-- SECTION 3 : Optional Bank Change -->
                <div class="border rounded p-3 mb-4 fs-6">
                    <h6 class="fw-bold mb-3">✏️ Update Bank Details (Optional)</h6>

                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">IFSC Code</label>
                            <input type="text" class="form-control form-control-lg">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Account Number</label>
                            <input type="text" class="form-control form-control-lg">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Account Type</label>
                            <select class="form-select form-select-lg">
                                <option>Savings</option>
                                <option>Current</option>
                                <option>NRE / NRO</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Upload Cancelled Cheque</label>
                            <input type="file" class="form-control form-control-lg">
                        </div>
                    </div>

                    <input hidden name="micr" type="text" class="form-control bg-secondary-subtle">
                    <input hidden name="bankname" type="text" class="form-control bg-secondary-subtle">
                    <input hidden name="brnach name" type="text" class="form-control bg-secondary-subtle">
                    <input hidden name="bank code" type="text" class="form-control bg-secondary-subtle">
                </div>


                <!-- SECTION 4 : What do you want to do -->
                <!-- Remarks -->
                <div class="mb-4">
                    <label class="form-label fw-semibold">Any Instructions (Optional)</label>
                    <textarea class="form-control form-control-lg" rows="3"></textarea>
                </div>

                <!-- Confirmation -->
                <div class="form-check mb-4 fs-6">
                    <input class="form-check-input" type="checkbox" required>
                    <label class="form-check-label">
                        I confirm that the above information is correct.
                    </label>
                </div>

                <!-- Submit -->
                <div class="text-end">
                    <button class="btn btn-success btn-lg px-5">
                        Submit Confirmation
                    </button>
                </div>

            </div>
        </div>
    </div>
@endsection
