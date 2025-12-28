@extends('layouts.master-layout')

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
        <span class="text-muted fw-light">Accounts /</span> <a href="{{ route('accounts.vendors.index') }}">Vendor</a>
    </h4>


    <form action="{{ route('accounts.vendors.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('POST')

        <div class="row align-items-stretch">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"id="salesClient">Primary Information</h5>
                        <small class="text-muted float-end">
                            <span class="text-danger fs-5">*</span> Required fields
                        </small>

                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- optClientVendor Radio Buttons -->
                            <div class="col-md-6 mb-3">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="optClientVendor" id="inlineRadio1"
                                        value="client" {{ old('optClientVendor', 'client') == 'client' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="inlineRadio1">Sales Client</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="optClientVendor" id="inlineRadio2"
                                        value="vendor" {{ old('optClientVendor') == 'vendor' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="inlineRadio2">Purchase Vendor</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="optClientVendor" id="inlineRadio3"
                                        value="both" {{ old('optClientVendor') == 'both' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="inlineRadio3">Both</label>
                                </div>
                            </div>

                            <div class="w-100"></div>

                            <!-- Entity Type -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Types of Entities <span class="text-danger fs-5">*</span></label>
                                <select class="form-select text-uppercase @error('entity_type') is-invalid @enderror"
                                    name="entity_type">
                                    <option value="">Select Option</option>
                                    <option value="individual" {{ old('entity_type') == 'individual' ? 'selected' : '' }}>
                                        Individual
                                    </option>
                                    <option value="non_individual"
                                        {{ old('entity_type') == 'non_individual' ? 'selected' : '' }}>
                                        Non-Individual
                                    </option>
                                </select>
                                @error('entity_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Non-Individual Type -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Non-Individual Type <span
                                        class="text-danger fs-5">*</span></label>
                                <select class="form-select text-uppercase @error('nonindividual') is-invalid @enderror"
                                    name="nonindividual">
                                    <option value="">Select Option</option>
                                    @foreach ($companyTypes as $d)
                                        <option value="{{ $d }}"
                                            {{ old('nonindividual') == $d ? 'selected' : '' }}>
                                            {{ $d }}</option>
                                    @endforeach
                                </select>
                                @error('nonindividual')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- GST Mode -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">GST Mode <span class="text-danger fs-5">*</span></label>
                                <select class="form-select text-uppercase @error('gst_mode') is-invalid @enderror"
                                    name="gst_mode">
                                    <option value="">Select Option</option>
                                    <option value="GST" {{ old('gst_mode') == 'GST' ? 'selected' : '' }}>GST</option>
                                    <option value="Non-GST" {{ old('gst_mode') == 'Non-GST' ? 'selected' : '' }}>Non-GST
                                    </option>
                                </select>
                                @error('gst_mode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>



                            <!-- Client Type -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Client Type</label>
                                <select class="form-select text-uppercase @error('clientType') is-invalid @enderror"
                                    name="clientType">
                                    <option value="">Select Option</option>
                                    <option value="retainer" {{ old('clientType') == 'retainer' ? 'selected' : '' }}>
                                        Retainer</option>
                                    <option value="non-retainer"
                                        {{ old('clientType') == 'non-retainer' ? 'selected' : '' }}>Non-Retainer</option>
                                </select>
                                @error('clientType')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Under Head -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Under Head</label>
                                <select class="form-select select2 text-uppercase @error('underhead') is-invalid @enderror"
                                    name="underhead">
                                    <option value="">Select option</option>
                                    @foreach ($underheads as $head)
                                        <option value="{{ $head }}"
                                            {{ old('underhead') == $head ? 'selected' : '' }}>
                                            {{ $head }}</option>
                                    @endforeach

                                </select>
                                @error('underhead')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- TAN -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">TAN No</label>
                                <input type="text" class="form-control @error('tanno') is-invalid @enderror"
                                    name="tanno" maxlength="10" value="{{ old('tanno') }}">
                                @error('tanno')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- VAT -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">VAT No</label>
                                <input type="text" class="form-control @error('vatno') is-invalid @enderror"
                                    name="vatno" maxlength="12" value="{{ old('vatno') }}">
                                @error('vatno')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Service Charges -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Service Charges</label>
                                <input type="text" class="form-control @error('serCharges') is-invalid @enderror"
                                    name="serCharges" maxlength="10" value="{{ old('serCharges') }}">
                                @error('serCharges')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Client Name -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Name of Client <span class="text-danger fs-5">*</span></label>
                                <input type="text" class="form-control @error('client_name') is-invalid @enderror"
                                    name="client_name" maxlength="50" value="{{ old('client_name') }}">
                                @error('client_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Vendor Mobile -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Vendor Mobile No. </label>
                                <input type="text" class="form-control onlydigit @error('mobno') is-invalid @enderror"
                                    name="mobno" maxlength="10" value="{{ old('mobno') }}">
                                @error('mobno')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Vendor Email -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Vendor Email-ID</label>
                                <input type="email" class="form-control @error('emailid') is-invalid @enderror"
                                    name="emailid" maxlength="50" value="{{ old('emailid') }}">
                                @error('emailid')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Contact Person -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Contact Person Name *</label>
                                <input type="text"
                                    class="form-control @error('contact_person_name') is-invalid @enderror"
                                    name="contact_person_name" maxlength="50" value="{{ old('contact_person_name') }}">
                                @error('contact_person_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Contact Email -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Contact Email-ID</label>
                                <input type="email" class="form-control @error('cmail') is-invalid @enderror"
                                    name="cmail" maxlength="50" value="{{ old('cmail') }}">
                                @error('cmail')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Contact Mobile -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Contact Mobile</label>
                                <input type="text" class="form-control onlydigit @error('cmob') is-invalid @enderror"
                                    name="cmob" maxlength="10" value="{{ old('cmob') }}">
                                {{-- <input type="checkbox" id="same_mobno"> <label for="same_mobno">Same as Vendor Mobile
                                    No</label> --}}
                                @error('cmob')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- PAN -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">PAN No.</label>
                                <input type="text" class="form-control @error('pan') is-invalid @enderror"
                                    name="pan" maxlength="10" value="{{ old('pan') }}">
                                @error('pan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- CIN -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">CIN No.</label>
                                <input type="text" class="form-control @error('cin') is-invalid @enderror"
                                    name="cin" maxlength="25" value="{{ old('cin') }}">
                                @error('cin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- GST -->
                            <div id="divgst" class="col-md-3 mb-3 ">
                                <label class="form-label">GST No.</label>
                                <input type="text" class="form-control @error('gst_no') is-invalid @enderror"
                                    name="gst_no" maxlength="15" value="{{ old('gst_no') }}">
                                @error('gst_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Aadhar -->
                            <div id="divaadhar" class="col-md-3 mb-3 ">
                                <label class="form-label">Aadhar No.</label>
                                <input type="text" class="form-control @error('aadharNo') is-invalid @enderror"
                                    name="aadharNo" maxlength="15" value="{{ old('aadharNo') }}">
                                @error('aadharNo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <hr>
                            <h6 class="mb-3">Vendor Address</h6>
                            <div class="col-6 mb-3">
                                <label class="form-label">Address</label>
                                <input type="text" name="registered_address" id="registered_address"
                                    class="form-control @error('registered_address') is-invalid @enderror"
                                    value="{{ old('registered_address') }}">
                                @error('registered_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="col-md-2 mb-3">
                                <label class="form-label">State</label>
                                <input type="text" name="registered_state" id="registered_state"
                                    class="form-control @error('registered_state') is-invalid @enderror"
                                    value="{{ old('registered_state') }}">
                                @error('registered_state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2 mb-3">
                                <label class="form-label">City</label>
                                <input type="text" name="registered_city" id="registered_city"
                                    class="form-control @error('registered_city') is-invalid @enderror"
                                    value="{{ old('registered_city') }}">
                                @error('registered_city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2 mb-3">
                                <label class="form-label">Postal Code</label>
                                <input type="text" name="registered_pincode" id="registered_pincode"
                                    class="form-control onlydigit @error('registered_pincode') is-invalid @enderror"
                                    value="{{ old('registered_pincode') }}" maxlength="6">
                                @error('registered_pincode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Remarks -->
                            <div class="col-12 mb-3">
                                <label class="form-label">Remarks</label>
                                <input type="text" class="form-control @error('remarks') is-invalid @enderror"
                                    name="remarks" maxlength="100" value="{{ old('remarks') }}">
                                @error('remarks')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>


                    </div>
                </div>
            </div>



            {{-- Bank details --}}
            <div class="col-md-6 d-flex">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Bank details</h5>
                        <small class="text-muted float-end">Bank Information</small>
                    </div>
                    <div class="card-body">
                        <div class="col-12 ">

                            <div id="bankDetailsWrapper">

                                <div class="bank-details-row row g-3 mb-3 bg-light position-relative">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">IFSC Code</label>
                                        <input type="text" name="banks[0][ifsc_code]" class="form-control ifsc_code"
                                            placeholder="Enter IFSC Code">
                                        <span class="invalid-feedback errmsg"></span>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Account No</label>
                                        <input type="text" name="banks[0][account_number]"
                                            class="form-control account_number" placeholder="Enter Account Number">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Bank Name</label>
                                        <input type="text" name="banks[0][bank_name]"
                                            class="form-control bank_name bg-secondary-subtle bg-gradient" readonly>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Branch Name</label>
                                        <input type="text" name="banks[0][branch_name]"
                                            class="form-control branch_name bg-secondary-subtle bg-gradient" readonly>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Bank Code</label>
                                        <input type="text" name="banks[0][bank_code]"
                                            class="form-control bank_code bg-secondary-subtle bg-gradient" readonly>
                                    </div>

                                    <div hidden class="col-md-6 mb-3">
                                        <label class="form-label d-block">Primary</label>
                                        <input type="hidden" name="banks[0][is_primary]" value="0">
                                        <input type="checkbox" name="banks[0][is_primary]" value="1"
                                            class="form-check-input setPrimary" checked>
                                    </div>


                                </div>
                            </div>

                            <!-- Add More Button -->
                            <div hidden class="mt-2">
                                <button type="button" id="addMoreBank" class="btn btn-primary">
                                    <i class="bx bx-plus"></i> Add More Bank
                                </button>
                            </div>
                        </div>


                    </div>
                </div>
            </div>



            {{-- Image Section --}}
            <div class="col-md-6 d-flex">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Image Section</h5>
                        <small class="text-muted float-end">Image Information</small>
                    </div>
                    <div class="card-body">
                        <div class="row">


                            <!-- File Upload: Company images -->


                            <div class="col-md-6 mb-3">
                                <label class="form-label">User photo Attachment</label>
                                <div class="input-group">
                                    <input type="file"
                                        class="form-control @error('attachement_user_photo') is-invalid @enderror"
                                        id="attachement_user_photo" name="attachement_user_photo"
                                        accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                    <button class="btn btn-outline-danger" type="button"
                                        onclick="document.getElementById('attachement_user_photo').value = ''">✕</button>
                                </div>
                                @error('logo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">aadhar Attachment</label>
                                <div class="input-group">
                                    <input type="file"
                                        class="form-control @error('attachement_aadhar') is-invalid @enderror"
                                        id="attachement_aadhar" name="attachement_aadhar"
                                        accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                    <button class="btn btn-outline-danger" type="button"
                                        onclick="document.getElementById('attachement_aadhar').value = ''">✕</button>
                                </div>
                                @error('attachement_aadhar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">pancard Attachment</label>
                                <div class="input-group">
                                    <input type="file"
                                        class="form-control @error('attachment_pan') is-invalid @enderror"
                                        id="attachment_pan" name="attachment_pan"
                                        accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                    <button class="btn btn-outline-danger" type="button"
                                        onclick="document.getElementById('attachment_pan').value = ''">✕</button>
                                </div>
                                @error('attachment_pan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">GST Attachment</label>
                                <div class="input-group">
                                    <input type="file"
                                        class="form-control @error('attachment_gst') is-invalid @enderror"
                                        id="attachment_gst" name="attachment_gst"
                                        accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                    <button class="btn btn-outline-danger" type="button"
                                        onclick="document.getElementById('attachment_gst').value = ''">✕</button>
                                </div>
                                @error('attachment_gstin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Cheque Attachment</label>
                                <div class="input-group">
                                    <input type="file"
                                        class="form-control @error('attachment_cheque') is-invalid @enderror"
                                        id="attachment_cheque" name="attachment_cheque"
                                        accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                    <button class="btn btn-outline-danger" type="button"
                                        onclick="document.getElementById('attachment_cheque').value = ''">✕</button>
                                </div>
                                @error('attachment_cheque')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Additinal Attachment</label>
                                <div class="input-group">
                                    <input type="file"
                                        class="form-control @error('attachment_additinal') is-invalid @enderror"
                                        id="attachment_additinal" name="attachment_additinal"
                                        accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                    <button class="btn btn-outline-danger" type="button"
                                        onclick="document.getElementById('attachment_additinal').value = ''">✕</button>
                                </div>
                                @error('attachment_additinal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>
                </div>
            </div>






        </div>



        <!-- Submit -->
        <div class="text-end mt-3">
            <button type="submit" class="btn btn-primary px-4">Save</button>
            <a href="{{ route('accounts.vendors.index') }}" class="btn btn-secondary px-4">Cancel</a>
        </div>
    </form>


@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('input[name="optClientVendor"]').change(function() {
                if ($(this).val() === 'client') {
                    $('#salesClient').text("GST-TDS/Sales Client");
                    $('#labelcname').text("Name of Client");
                }
                if ($(this).val() === 'both') {
                    $('#salesClient').text("GST-TDS/Vendor & Client");
                    $('#labelcname').text("Name of Vendor & Client");
                } else {
                    $('#salesClient').text("GST-TDS/Purchase Vendor");
                    $('#labelcname').text("Name of Vendor");
                }
            });
        });
    </script>
@endpush
