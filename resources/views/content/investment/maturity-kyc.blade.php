@extends('layouts.master-layout')

@section('content')
    <style>
        .nav-tabs .nav-link {
            padding: 12px 20px;
        }

        .nav-tabs .nav-link.active {
            background-color: #0d6efd;
            color: #fff !important;
        }
    </style>

    <div class="container my-4">

        <ul class="nav nav-tabs fs-5" id="investmentTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active fw-bold" id="maturity-tab" data-bs-toggle="tab" data-bs-target="#maturity"
                    type="button" role="tab">
                    🏁 Maturity
                </button>
            </li>

            <li class="nav-item" role="presentation">
                <button class="nav-link fw-bold" id="renewal-tab" data-bs-toggle="tab" data-bs-target="#renewal"
                    type="button" role="tab">
                    🔁 Renewal
                </button>
            </li>
        </ul>


        <div class="tab-content mt-4" id="investmentTabsContent">
            <div class="tab-pane fade show active" id="maturity" role="tabpanel">

                <div class="card shadow-sm border-0">

                    <!-- Header -->
                    <div class="card-header bg-danger text-white py-3">
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
                        <div class="mb-4 ">
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
                        <div class="border rounded p-3 mb-4 fs-6 ">
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


                        <!-- SECTION 4 : Remarks -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Any Instructions (Optional)</label>
                            <textarea class="form-control form-control-lg" rows="3"></textarea>
                        </div>

                        <!-- SECTION 5 : Confirmation -->
                        <div class="form-check mb-4 fs-6">
                            <input class="form-check-input" type="checkbox" required>
                            <label class="form-check-label">
                                I confirm that the above information is correct.
                            </label>
                        </div>

                        <!-- SECTION 6 : Submit -->
                        <div class="text-end">
                            <button class="btn btn-success btn-lg px-5">
                                Submit Confirmation
                            </button>
                        </div>

                    </div>
                </div>

            </div>

            <div class="tab-pane fade" id="renewal" role="tabpanel">

                <div class="card shadow-sm border-0">

                    <!-- Header -->
                    <div class="card-header bg-success  py-3">
                        <h4 class="mb-0 text-white1">
                            Investment Renewal Confirmation
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
                        <div class="mb-4 ">
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



                        <!-- SECTION Renwal A :  -->
                        <div class="row mb-3 p-3 border rounded">
                            <label class="form-label fw-bold fs-5 mb-3">
                                Select Scheme Type
                            </label>

                            <div class="col-md-3 form-check fs-5">
                                <input class="form-check-input" type="radio" name="scheme_type" id="scheme_same"
                                    value="same" checked>
                                <label class="form-check-label" for="scheme_same">
                                    Same Scheme
                                </label>
                            </div>

                            <div class="col-md-3 form-check fs-5">
                                <input class="form-check-input" type="radio" name="scheme_type" id="scheme_different"
                                    value="different">
                                <label class="form-check-label" for="scheme_different">
                                    Different Scheme
                                </label>
                            </div>
                            <div class="col-md-4 schemeDropdown d-none">
                                <label class="form-label fw-semibold fs-5">
                                    Select Scheme
                                </label>
                                <select class="form-select form-select-lg" id="">
                                    <option value="">Please Scheme</option>
                                    <option value="">Scheme A</option>
                                    <option value="">Scheme B</option>
                                    <option value="">Scheme C</option>
                                    <option value="">Scheme D</option>
                                </select>
                            </div>
                        </div>

                        <!-- SECTION Renwal B :  -->
                        <div class="mb-4" id="schemeTableWrapper">
                            <h5 class="fw-bold mb-3">📋 Scheme Details</h5>

                            <table class="table table-bordered fs-5">
                                <thead class="table-light">
                                    <tr>
                                        <th>Scheme Name</th>
                                        <th>Rate of Interest (ROI)</th>
                                        <th>Tenure Type</th>
                                    </tr>
                                </thead>
                                <tbody id="schemeTableBody">
                                    <tr>
                                        <td>Senior Secure Plan</td>
                                        <td>7% Per Annum</td>
                                        <td>Quarterly</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- SECTION Renwal C :  -->
                        <div class="row g-4">

                            <div class="col-md-4">
                                <label class="form-label fw-semibold fs-5">
                                    Select Action
                                </label>
                                <select class="form-select form-select-lg" id="actionSelect">
                                    <option value="">Please choose</option>
                                    <option value="renew_full">Renew Full Amount</option>
                                    <option value="renew_principal">Renew Principal Only</option>
                                    <option value="renew_interest">Renew Interest Only</option>
                                    <option value="partial_renew">Renew with Add-on</option>
                                    <option value="close">Renew partial (withdraw some amt)</option>
                                </select>
                            </div>



                            <div class="col-md-4 d-none1" id="partialBox">
                                <label class="form-label fw-semibold fs-5">
                                    Renewal Amount
                                </label>
                                <input type="number" class="form-control form-control-lg" placeholder="Enter amount">
                            </div>



                        </div>

                        <!-- SECTION 4 : Remarks -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Any Instructions (Optional)</label>
                            <textarea class="form-control form-control-lg" rows="3"></textarea>
                        </div>

                        <!-- SECTION 5 : Confirmation -->
                        <div class="form-check mb-4 fs-6">
                            <input class="form-check-input" type="checkbox" required>
                            <label class="form-check-label">
                                I confirm that the above information is correct.
                            </label>
                        </div>

                        <!-- SECTION 6 : Submit -->
                        <div class="text-end">
                            <button class="btn btn-success btn-lg px-5">
                                Submit Confirmation
                            </button>
                        </div>

                    </div>
                </div>

            </div>

        </div>

    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const schemeTableBody = document.getElementById('schemeTableBody');

            document.querySelectorAll('input[name="scheme_type"]').forEach(radio => {
                radio.addEventListener('change', function() {

                    if (this.value === 'same') {
                        schemeTableBody.innerHTML = `
        <tr>
            <td>Senior Secure Plan</td>
            <td>7% Per Annum</td>
            <td>Quarterly</td>
        </tr>`;
                    } else {
                        schemeTableBody.innerHTML = `
        <tr>
            <td>Growth Advantage Plan</td>
            <td>7.5% Per Annum</td>
            <td>Monthly</td>
        </tr>`;
                    }
                });
            });


        });
    </script>

    <script>
        $(document).ready(function() {

            $('input[name="scheme_type"]').on('change', function() {

                if ($(this).val() === 'different') {
                    $('.schemeDropdown').removeClass('d-none');
                } else {
                    $('.schemeDropdown').addClass('d-none');
                }

            });

        });
    </script>
@endpush
