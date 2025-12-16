@extends('layouts.master-layout')

@section('content')
      <div class="container">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Investment Maturity Confirmation</h5>
            </div>

            <div class="card-body">

                <!-- Investment Details -->
                <div class="mb-4">
                    <div class="d-flex align-items-center">
                        <h6 class="fw-bold mb-0 me-2">Investment Details</h6>
                        <span class="text-danger">Note: This is your Current Investment details and Bank details</span>
                    </div>

                    <table class="table table-bordered table-sm">
                        <tr>
                            <th>Investment ID</th>
                            <td>INV-00123</td>
                        </tr>
                        <tr>
                            <th>Principal Amount</th>
                            <td>₹ 5,00,000</td>
                        </tr>
                        <tr>
                            <th>Interest Amount</th>
                            <td>₹ 75,000</td>
                        </tr>
                        <tr>
                            <th>Total Maturity Value</th>
                            <td class="fw-bold">₹ 5,75,000</td>
                        </tr>
                        <tr>
                            <th>Maturity Date</th>
                            <td>15-09-2025</td>
                        </tr>
                        <tr>
                            <th>Bank Details</th>
                            <td>
                                <div class="small">
                                    <div><strong>Bank Name:</strong> State Bank of India</div>
                                    <div><strong>Branch:</strong> Connaught Place, New Delhi</div>
                                    <div><strong>Account No:</strong> XXXX-XXXX-1234</div>
                                    <div><strong>IFSC:</strong> SBIN0000691</div>
                                    <div><strong>Account Type:</strong> Savings</div>
                                </div>
                            </td>

                        </tr>
                    </table>
                </div>
                <div class="card-body" id="bankDetailsWrapper">
                    <div class="row g-3">
                        <p class="text-danger">Note : If you want to change the bank details plz add below</p>
                        <!-- IFSC -->
                        <div class="col-md-2">
                            <label class="form-label">IFSC Code</label>
                            <input type="text" class="form-control" placeholder="Enter IFSC Code" maxlength="11">
                            <span class="text-danger small"></span>
                        </div>

                        <!-- Account No -->
                        <div class="col-md-2">
                            <label class="form-label">Account No</label>
                            <input type="text" class="form-control" placeholder="Enter Account Number" maxlength="15">
                        </div>

                        <!-- Account Type -->
                        <div class="col-md-2">
                            <label class="form-label">Account Type</label>
                            <select class="form-select">
                                <option value="">Select Type</option>
                                <option>Savings Account</option>
                                <option>Current Account</option>
                                <option>Overdraft / CC</option>
                                <option>NRE</option>
                                <option>NRI</option>
                                <option>NRO</option>
                                <option>Term Deposit</option>
                                <option>Recurring</option>
                            </select>
                        </div>

                        <!-- Operation Mode -->
                        <div class="col-md-2">
                            <label class="form-label">Operation Mode</label>
                            <select class="form-select" id="operationMode">
                                <option value="single">Single</option>
                                <option value="joint">Joint</option>
                            </select>
                        </div>

                        <!-- Holder 1 -->
                        <div class="col-md-2 holder-names d-none">
                            <label class="form-label">Holder Name 1</label>
                            <input type="text" class="form-control">
                        </div>

                        <!-- Holder 2 -->
                        <div class="col-md-2 holder-names d-none">
                            <label class="form-label">Holder Name 2</label>
                            <input type="text" class="form-control">
                        </div>

                        <!-- Holder 3 -->
                        <div class="col-md-2 holder-names d-none">
                            <label class="form-label">Holder Name 3</label>
                            <input type="text" class="form-control">
                        </div>

                        <!-- MICR -->
                        <div class="col-md-2">
                            <label class="form-label">MICR Code</label>
                            <input type="text" class="form-control bg-secondary-subtle" readonly>
                        </div>

                        <!-- Bank Name -->
                        <div class="col-md-2">
                            <label class="form-label">Bank Name</label>
                            <input type="text" class="form-control bg-secondary-subtle" readonly>
                        </div>

                        <!-- Branch Name -->
                        <div class="col-md-2">
                            <label class="form-label">Branch Name</label>
                            <input type="text" class="form-control bg-secondary-subtle" readonly>
                        </div>

                        <!-- Bank Code -->
                        <div class="col-md-2">
                            <label class="form-label">Bank Code</label>
                            <input type="text" class="form-control bg-secondary-subtle" readonly>
                        </div>

                        <!-- Cheque Photo -->
                        <div class="col-md-4">
                            <label class="form-label">Cheque Photo</label>
                            <div class="input-group">
                                <input type="file" class="form-control" accept=".jpg,.jpeg,.png,.pdf">
                                <button class="btn btn-outline-danger" type="button">✕</button>
                            </div>
                        </div>



                    </div>
                </div>

                <!-- Form -->
                <form>
                    <div class="row mb-3 p-3">
                        <!-- Label -->
                        <label class="form-label fw-semibold d-block mb-2">Select Scheme Type</label>

                        <!-- Radio buttons -->
                        <div class="col-md-2 form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="scheme_type" id="scheme_same" checked>
                            <label class="form-check-label" for="scheme_same">Same Scheme</label>
                        </div>

                        <div class="col-md-2 form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="scheme_type" id="scheme_different">
                            <label class="form-check-label" for="scheme_different">Different Scheme</label>
                        </div>
                    </div>
                    <div class="row">
                        

                        <!-- Action -->
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Scheme Name<span
                                    class="text-danger">*</span></label>
                            <select class="form-select mb-2" id="schemeSelect">
                                <option value="">-- Select Scheme --</option>
                                <option value="scheme1">Scheme 1</option>
                                <option value="scheme2">Scheme 2</option>
                                <option value="scheme3">Scheme 3</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                           <label class="form-label">Rate of Interest (ROI)</label>
                            <select class="form-select" id="roiSelect">
                                <option value="">-- Select ROI --</option>
                                <option value="5">5%</option>
                                <option value="6">6%</option>
                                <option value="7">7%</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Select Action <span
                                    class="text-danger">*</span></label>
                            <select class="form-select" id="actionSelect" required>
                                <option value="">-- Select --</option>
                                <option value="renew_full">Renew Full Amount</option>
                                <option value="renew_principal">Renew Principal Only</option>
                                <option value="renew_interest">Renew Interest Only</option>
                                <option value="partial_renew">Partial Renewal</option>
                                <option value="close">Close Investment</option>
                            </select>
                        </div>
                        <!-- Different Scheme Section (hidden by default) -->
                        <div class="col-md-3 different-scheme-box ">
                            <h6 class="fw-semibold mb-2">Different Scheme Details</h6>
                            <input type="text" class="form-control" placeholder="Enter new scheme name">
                        </div>



                        <!-- Partial Renewal -->
                        <div class="col-md-3" id="partialBox">
                            <label class="form-label fw-semibold">Renewal Amount</label>
                            <input type="number" class="form-control" placeholder="Enter amount">
                        </div>

                        <!-- Bank -->
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Bank Account for Payout</label>
                            <select class="form-select">
                                <option value="">-- Select Bank Account --</option>
                                <option>HDFC Bank – XXXX1234</option>
                                <option>ICICI Bank – XXXX5678</option>
                            </select>
                        </div>

                    </div>


                    <!-- Remarks -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Remarks</label>
                        <textarea class="form-control" rows="3" placeholder="Any additional instructions..."></textarea>
                    </div>

                    <!-- Declaration -->
                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" required>
                        <label class="form-check-label">
                            I confirm that the above instructions are correct.
                        </label>
                    </div>

                    <!-- Submit -->
                    <div class="text-end">
                        <button class="btn btn-success px-4">
                            Submit Confirmation
                        </button>
                    </div>

                </form>
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
