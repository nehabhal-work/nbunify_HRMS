@extends('layouts.master-layouts')
@section('title')
    investment
@endsection
@section('investment')
    active open
@endsection
@section('submenu-elsinv')
    active
@endsection

@section('content')
    <style>
        .light-style .select2-container--default .select2-selection__placeholder {
            color: #697b8d !important;
        }

        option,
        select {
            text-transform: uppercase;
        }
    </style>
    <div class="">
        @if (session('status'))
            <x-alert type="success" :message="session('status')" />
        @endif
        @if (session('error'))
            <x-alert type="danger" :message="session('error')" />
        @endif




        <form class="spinner-form needs-validation" action="{{ route('investmentels.store') }}" method="post"
            enctype="multipart/form-data" novalidate>
            @csrf
            @method('post')
            <h3>Create Investment Record</h3>
            <div class="d-flex justify-content-between align-items-center">
                <p class="text-danger mb-0">
                    <strong>Note:</strong> Fields marked in <span class="fw-bold text-danger">*</span> are mandatory.
                </p>
                <a href="{{ route('investmentels.index') }}" class="btn btn-outline-secondary my-2">Back</a>
            </div>


            <div class="card mb-4">
                <div class="card-body">
                    <div class="row g-2">

                        <!-- Investment Date -->
                        <div class="col-md-2">
                            <label class="form-label">Investment Date</label>
                            <input type="date" class="form-control invDate" name="investment_date" id="invDate"
                                value="{{ old('investment_date', date('Y-m-d')) }}" max="{{ date('Y-m-d') }}" required />
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Investment Type</label>
                            <select class="form-select invType" name="investment_type" required>
                                <option value="single" selected>Single</option>
                                <option value="joined">Joined</option>
                            </select>
                        </div>

                        <!-- Investment Holder -->
                        <div class="col-md-3 holderBox" id="singleHolder" style1="display:none;">
                            <label class="form-label">Investment Holder</label>
                            <select class="form-select select2 profile_id " name="profile_id" required>
                                <option value="">Select Holder</option>
                                @foreach ($profile as $d)
                                    <option value="{{ $d->id }}" data-banks='@json($d->banking)'
                                        data-family='@json($d->family)' data-dob='{{ $d->dob }}'>
                                        {{ ucfirst(strtolower($d->fname)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Joined Investment Holder -->
                        <div class="col-md-3 holderBox" id="joinedHolder" style="display:none;">
                            <label class="form-label">Joined Investment Holder</label>
                            <select class="form-select select2 profile_id1 " multiple name="joined_profile_id">
                                <option value="">Select Holder</option>
                                @foreach ($profile as $d)
                                    <option value="{{ $d->id }}" data-banks='@json($d->banking)'
                                        data-family='@json($d->family)' data-dob='{{ $d->dob }}'>
                                        {{ ucfirst(strtolower($d->fname)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Scheme Name -->
                        <div class="col-md-2">
                            <label class="form-label text-danger">Scheme Name *</label>
                            <select class="form-select scheme_id" name="scheme_id" required>
                                <option value="">Select Scheme</option>
                                @forelse ($elsScheme as $s)
                                    <option value="{{ $s->id }}" data-tenure-type="{{ $s->tenure_type }}"
                                        data-min-tenure="{{ $s->min_tenure }}" data-max-tenure="{{ $s->max_tenure }}"
                                        data-frequencies='{{ $s->frequency }}' data-min-roi="{{ $s->min_roi }}"
                                        data-max-roi="{{ $s->max_roi }}" data-addi-roi="{{ $s->additional_roi }}"
                                        data-scheme_name="{{ $s->name }}">
                                        {{ $s->name }}
                                    </option>

                                @empty
                                    <option value="">No Schemes Available</option>
                                @endforelse
                            </select>

                        </div>


                        {{-- Total Invested Amount --}}
                        <div class="col-md-2">
                            <label class="form-label text-danger">Total Invested Amount *</label>
                            <div class="input-group">
                                <span class="input-group-text">&#8377;</span>
                                <input type="number" class="form-control onlydigit invested_amount " id="invested_amount"
                                    name="invested_amount" value="{{ old('invested_amount') }}" required />
                            </div>
                        </div>

                        {{-- Tenure Type --}}
                        <div class="col-md-2">
                            <label class="form-label">Tenure Type</label>
                            <input type="text" class="form-control modepay tenure_type bg-secondary-subtle"
                                name="tenure_type" id="tenure_type" readonly required>
                        </div>

                        <!-- Tenure -->
                        <div class="col-md-2">
                            <label class="form-label text-danger" id="tenure_label">Tenure *</label>
                            <select class="form-select tenure" name="tenure" id="tenure" required>
                                {{-- options load dynamically --}}
                            </select>
                        </div>

                        <!-- Frequency -->
                        <div class="col-md-2">
                            <label class="form-label text-danger">Frequency *</label>
                            <select class="form-select modepay" name="frequency" required>
                                {{-- load from jquery --}}
                            </select>
                        </div>

                        <!-- ROI -->
                        <div class="col-md-2">
                            <label for="roi" class="form-label text-danger">ROI *</label>
                            <div class="input-group">
                                <input type="text" class="form-control roi" name="roi" id="roi" maxlength="5"
                                    required />

                                <span class="input-group-text">%</span>
                            </div>
                            <small class="text-muted roi-hint d-block mt-1">
                                Please select a scheme to see allowed ROI range.
                            </small>
                            <div id="roi-message" class="mt-1"></div>
                        </div>


                        <!-- Additional ROI -->
                        <div id="divAddiRoi" class="col-md-2 d-none">
                            <label for="roi" class="form-label ">additional ROI *</label>
                            <div class="input-group">
                                <input type="text" class="form-control onlydigit bg-info-subtle" name="addi_roi"
                                    id="addi_roi" maxlength="5" />

                                <span class="input-group-text">%</span>
                            </div>

                        </div>




                        <!-- Maturity Date -->
                        <div class="col-md-2">
                            <label class="form-label">Maturity Date</label>
                            <input type="date" class="form-control matdate bg-secondary-subtle" name="maturity_date"
                                id="matdate" readonly required />
                        </div>

                        {{-- Interest/Payout Amount --}}
                        <div class="col-md-2">
                            <label class="form-label">Interest/Payout Amount</label>
                            <div class="input-group">
                                <span class="input-group-text">&#8377;</span>
                                <input type="number" class="form-control onlydigit payout_amount bg-secondary-subtle "
                                    id="int_payout_amount" name="int_payout_amount" readonly required />
                            </div>
                        </div>
                        <!-- TDS -->
                        <div class="col-md-2">
                            <label class="form-label">TDS</label>
                            <select class="form-select" name="tds">
                                <option value="no">No</option>
                                <option value="yes">Yes</option>
                            </select>
                        </div>
                        <!-- TDS Image -->
                        {{-- <div class="col-md-4 d-none" id="divForm15">
                            <label class="form-label" id="form15Label">Form 15 Image</label>
                            <input type="file" name="form15Image" class="form-control fileInput form15Image"
                                data-preview="imgPreview" accept="image/*,application/pdf">
                            <img src="" class="imgPreview mt-1" style="width:100px; display:none;">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">TDS (%)</label>
                            <input type="number" name="tdspercent" class="form-control  tdspercent">
                        </div> --}}
                        <div class="col-md-2" hidden>
                            <label class="form-label">payout count</label>
                            <input type="number" id="payout_count" name="payout_count" class="form-control ">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bank / Instrument Details --}}
            <div id="instrumentSection" class="card mb-4 d-none" style="background-color: #fafaee">
                <div class="card-body">
                    <h5>Bank / Instrument Details</h5>
                    <div id="bankContainer">
                        <div class="bankRow position-relative mb-4 border rounded p-3">
                            <!-- Close button -->
                            <button type="button"
                                class="btn btn-sm btn-danger position-absolute top-0 end-0 removeBankRow">✖</button>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="row">
                                        <!-- Instrument Type -->
                                        <div class="col-md-6 mt-3">
                                            <label class="form-label text-danger">Instrument *</label>
                                            <select class="form-select" name="instrument[]" required>
                                                <option value="">Select</option>
                                                <option value="rtgs">RTGS</option>
                                                <option value="cheque">CHEQUE</option>
                                                <option value="upi">UPI</option>
                                                <option value="neft">NEFT</option>
                                                <option value="imps">IMPS</option>
                                            </select>
                                        </div>

                                        <!-- Instrument Date -->

                                        <div class="col-md-6 mt-3">
                                            <label class="form-label text-danger" id="instrument-label">Instrument Date
                                                *</label>
                                            <input type="date" class="form-control" name="instrument_date[]"
                                                max="{{ date('Y-m-d') }}" required />
                                        </div>
                                        <!-- Reference No -->
                                        <div class="col-md-6 mt-3">
                                            <label class="form-label text-danger">Reference No *</label>
                                            <input type="text" class="form-control" name="reference_no[]"
                                                maxlength="20" required />
                                        </div>

                                        <!-- Amount -->
                                        <div class="col-md-6 mt-3">
                                            <label class="form-label">Instrument Amounts</label>
                                            <div class="input-group">
                                                <span class="input-group-text">&#8377;</span>
                                                <input type="number" class="form-control onlydigit instrument_amt"
                                                    name="instrument_amt[]" required />
                                            </div>
                                            <div class="instrument-message" class="mt-2"></div>
                                        </div>

                                        <!-- Output Bank -->
                                        <div class="col-12 mt-3">
                                            <label class="form-label text-danger">Client Output Bank *</label>
                                            <select class="form-select clientOutputBank" name="client_output_bank[]"
                                                required>
                                                <option value="">Select Bank</option>
                                            </select>
                                        </div>

                                        {{-- <!-- Account No -->
                                        <div class="col-md-6 mt-3">
                                            <label class="form-label">Client Account No</label>
                                            <select class="form-select client_bank_accountno" name="account_no[]">
                                                <option value="">Select Account No</option>
                                            </select>
                                        </div> --}}

                                        <!-- Instrument Image -->
                                        <div class="col-12 mt-3">
                                            <label class="form-label">Instrument Image</label>
                                            <input type="file" name="instrumentImage[]"
                                                class="form-control fileInput instrumentImage" data-preview="imgPreview"
                                                accept="image/*,application/pdf">
                                            <img src="" class="imgPreview mt-1"
                                                style="width:100px; display:none;">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 border-start">
                                    <div class="row">
                                        <!-- Company Bank -->
                                        <div class="col-md-6 mt-3">
                                            <label class="form-label text-danger">Company Bank *</label>
                                            <select class="form-select" name="company_bank_id[]" required>
                                                <option value="">Select Company Bank</option>
                                                @foreach ($elsBank as $cb)
                                                    <option value="{{ $cb->id }}">
                                                        {{ $cb->name . '-' . $cb->acctno }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Company Bank Date -->
                                        <div class="col-md-6 mt-3">
                                            <label class="form-label text-danger">Effective / Credit Date *</label>
                                            <input type="date" class="form-control" name="effective_date[]"
                                                max="{{ date('Y-m-d') }}" required />
                                        </div>

                                        <!-- Company Amount -->
                                        <div class="col-md-6 mt-3">
                                            <label class="form-label">Company Amount</label>
                                            <div class="input-group">
                                                <span class="input-group-text">&#8377;</span>
                                                <input type="text"
                                                    class="form-control bg-secondary-subtle company_bank_amount"
                                                    id="company_bank_amount" name="company_bank_amount[]" maxlength="20"
                                                    readonly />
                                            </div>
                                        </div>

                                        <!-- Company Ref No -->
                                        <div class="col-md-6 mt-3">
                                            <label class="form-label">Company Bank Ref No</label>
                                            <input type="text" class="form-control" name="company_bank_ref[]" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" id="addBankRow" class="btn btn-primary btn-sm">+ Add More</button>
                </div>
            </div>

            <!-- 🔹 NEW OUTWARD / PAYOUT DETAILS SECTION -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5>Outward Bank / Payout Details</h5>
                    <div id="outwardContainer" class="mb-2">
                        <div class="row g-3 outwardRow mb-2">
                            <!-- Company Bank (From) -->
                            <div class="col-md-4">
                                <label class="form-label text-danger">From Company Bank *</label>
                                <select class="form-select" id="out_company_bank" name="out_company_bank" required>
                                    <option value="">Select Company Bank</option>
                                    @foreach ($elsBank as $cb)
                                        <option value="{{ $cb->id }}" data-acctno="{{ $cb->acctno }}"
                                            data-ifsc="{{ $cb->ifsc }}" data-name="{{ $cb->name }}">
                                            {{ $cb->name . '-' . $cb->acctno }}
                                        </option>
                                    @endforeach
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
                    </div>
                </div>
            </div>

            {{-- Nominee Details --}}
            <div class="card mb-4">
                <div class="card-body">
                    <h5>Nominee Details</h5>
                    <div id="nomineeContainer">
                        <div class="nomineeRow border rounded position-relative mb-4">
                            <!-- Close button top-right -->
                            <button type="button"
                                class="btn btn-sm btn-danger position-absolute top-0 end-0 removeNomineeRow">✖</button>

                            <div class="row g-3 p-3">
                                <div class="col-md-3">
                                    <label class="form-label">Nominee Name</label>

                                    <!-- Dropdown -->
                                    <select class="form-select nominee_name" name="nominee_name[]">
                                        <option value="">Select Nominee</option>
                                    </select>

                                    <!-- Message if no family members -->
                                    <div class="text-muted small mt-1"><i>
                                            No family member found? Enter nominee manually below.
                                        </i>
                                    </div>

                                    <!-- Manual input (always shown) -->
                                    <input type="text" class="form-control mt-2 nominee_input"
                                        name="nominee_name_manual[]" placeholder="Enter Nominee Name">
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label">Relationship</label>
                                    <select class="form-select " name="nominee_relation[]" id="">
                                        <option selected>Select one</option>
                                        @foreach ($relationship as $r)
                                            <option value="{{ $r->name }}">{{ $r->name }}</option>
                                        @endforeach

                                    </select>

                                </div>
                                <div class="col-md-2">
                                    <label class="form-label text-danger">Percentage *</label>
                                    <input type="text" class="form-control nominee_percent onlydigit "
                                        name="nominee_percent[]" maxlength="3" required />
                                    <div id="nominee-message" class="mt-2 nominee-message"></div>
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label">DOB</label>
                                    <input type="date" class="form-control dob" name="dob[]" />
                                    <small class="text-muted age-text"></small>
                                </div>
                                <div class="col-md-3 guardian-wrapper d-none">
                                    <label class="form-label">Guardian OR Power Of Attorney</label>
                                    <input type="text" class="form-control" name="guardian[]" maxlength="50" />
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Mobile</label>
                                    <input type="text" class="form-control onlydigit" name="nominee_mobile[]"
                                        maxlength="10" />
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="nominee_email[]" maxlength="50" />
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Pan No</label>
                                    <input type="text" class="form-control" name="pan[]" maxlength="10" />
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Adhar NO</label>
                                    <input type="text" class="form-control onlydigit" name="aadharno[]"
                                        maxlength="12" />
                                </div>


                                <div class="col-md-3">
                                    <label class="form-label">Photo</label>
                                    <input type="file" class="form-control fileInput nomineePhotoImage"
                                        data-preview="imgPreviewPhoto" name="nominee_photo[]" accept="image/*" />
                                    <img src="" class="imgPreviewPhoto mt-1" style="width:100px; display:none;">
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">PAN Card</label>
                                    <input type="file" class="form-control fileInput nomineePanImage"
                                        data-preview="imgPreviewPan" name="nominee_pan[]"
                                        accept="image/*,application/pdf" />
                                    <img src="" class="imgPreviewPan mt-1" style="width:100px; display:none;">
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Aadhar Card</label>
                                    <input type="file" class="form-control fileInput nomineeAadharImage"
                                        data-preview="imgPreviewAadhar" name="nominee_aadhar[]"
                                        accept="image/*,application/pdf" />
                                    <img src="" class="imgPreviewAadhar mt-1" style="width:100px; display:none;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" id="addNomineeRow" class="btn btn-info btn-sm">+ Add More Nominee</button>
                </div>
            </div>

            <!-- Image Modal -->
            <div class="modal fade" id="imgModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-body text-center">
                            <img src="" id="modalImg" class="img-fluid" alt="Full Image">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Save button -->
            <button type="submit" class="btn btn-success my-2 saveBtn">Save</button>

            <a href="{{ route('investmentels.index') }}" class="btn btn-outline-secondary my-2">Back</a>
        </form>

    </div>
@endsection

@push('jscontent')
    <script>
        $(document).ready(function() {
            // When frequency changes
            $('select[name="frequency"]').on('change', function() {
                let freq = $(this).val();
                let label = $('#instrument-label');

                if (freq === 'compounding') {
                    label.text('Schedule Date *');
                } else {
                    label.text('Instrument Date *');
                }
            });

            // Trigger change on page load if needed
            $('select[name="frequency"]').trigger('change');
        });
    </script>
    {{-- Always load jQuery first --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".dob").forEach(function(input) {
                input.addEventListener("input", function() {
                    let parts = this.value.split("-"); // yyyy-mm-dd

                    // ✅ If year exists and it's more than 4 digits → reset input
                    if (parts[0] && parts[0].length > 4) {
                        this.value = "";
                        return;
                    }

                    // ✅ If month exists and is more than 12 → fix it to 12
                    if (parts[1] && parseInt(parts[1]) > 12) {
                        parts[1] = "12";
                        this.value = parts.join("-");
                    }
                });
            });
        });
    </script>


    {{-- Then your custom script --}}
    <script src="{{ asset('assets/js/elsinvestment.js') }}?v={{ time() }}"></script>
    <script>
        $(function() {
            "use strict";

            // jQuery equivalent of Bootstrap 5 validation
            $(".needs-validation").on("submit", function(event) {
                let form = this;

                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }

                $(form).addClass("was-validated");
            });

            // 🔄 Reset validation state whenever input changes
            $(".needs-validation").on("input change", "input, select, textarea", function() {
                let form = $(this).closest("form")[0];
                if (form.checkValidity()) {
                    $(form).removeClass("was-validated"); // allow fresh validation on submit
                    $(".saveBtn").prop("disabled", false); // enable Save button
                } else {
                    $(".saveBtn").prop("disabled", true); // disable until valid
                }
            });

            // Run once on page load
            $(".needs-validation").trigger("input");
        });
    </script>
    <script>
        $(document).on("change keyup", ".dob", function() {
            let dob = new Date($(this).val());
            let today = new Date();

            if (!isNaN(dob)) {
                let age = today.getFullYear() - dob.getFullYear();
                let m = today.getMonth() - dob.getMonth();
                if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
                    age--;
                }

                // Show age beside DOB
                $(this).siblings(".age-text").text("Age: " + age + " years");

                // Find guardian field relative to this DOB input
                let guardianField = $(this).closest(".row, .col-md-2").siblings(".guardian-wrapper");

                if (age < 18) {
                    guardianField.removeClass("d-none");
                } else {
                    guardianField.addClass("d-none");
                    guardianField.find("input").val(""); // clear value
                }
            } else {
                // Reset if invalid date
                $(this).siblings(".age-text").text("");
            }
        });

        // Allow only digits and dot while typing
        $(document).on("input", ".roi", function(e) {
            let input = this;
            let start = input.selectionStart;
            let val = input.value;

            // remove invalid characters
            val = val.replace(/[^0-9.]/g, "");

            // allow only first dot
            let firstDot = val.indexOf(".");
            if (firstDot !== -1) {
                let beforeDot = val.slice(0, firstDot).slice(0, 2); // max 2 digits before
                let afterDot = val.slice(firstDot + 1).slice(0, 2); // max 2 digits after
                val = beforeDot + "." + afterDot;
            } else {
                val = val.slice(0, 2); // max 2 digits if no dot
            }

            if (val !== input.value) {
                input.value = val;
                input.setSelectionRange(start, start);
            }
        });

        // Format to two decimals on blur
        $(document).on("blur", ".roi", function() {
            let val = parseFloat($(this).val());
            if (!isNaN(val)) {
                $(this).val(val.toFixed(2)); // always show 2 decimals
            }
        });
    </script>

    {{-- out_company_bank change --}}
    <script></script>
    {{-- // ---------------------------type = number maxlength 10 ------------- --}}
    <script>
        $(document).on("input",
            "#invested_amount, #int_payout_amount, #payout_count, #instrument_amt, #company_bank_amount",
            function() {
                if (this.value.length > 10) {
                    this.value = this.value.slice(0, 10); // ✅ keep only first 10 digits
                }
            });
    </script>
@endpush
