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
        <span class="text-muted fw-light">Master /</span> <a href="{{ route('master.companies.index') }}">Client</a>
    </h4>


    <form action="{{ route('master.companies.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('post')
        <div class="row align-items-stretch">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Primary Information</h5>
                        <small class="text-muted float-end">client Basic Details</small>
                    </div>
                    <div class="card-body">
                        <div class="row">



                            {{-- Full Name --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="name">Full Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" maxlength="50" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Gender --}}
                            <div class="col-md-2 mb-3">
                                <label class="form-label" for="gender">Gender</label>
                                <select class="form-select @error('gender') is-invalid @enderror" id="gender"
                                    name="gender">
                                    <option value="">Select</option>
                                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            {{-- Date of Birth --}}
                            <div class="col-md-2 mb-3">
                                <label class="form-label" for="dob">Date of Birth</label>
                                <input type="date" class="form-control @error('dob') is-invalid @enderror" id="dob"
                                    name="dob" value="{{ old('dob') }}">
                                @error('dob')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            {{-- Live Status --}}
                            <div class="col-md-2 mb-3">
                                <label class="form-label" for="live_status">Live Status</label>
                                <select class="form-select @error('live_status') is-invalid @enderror" id="live_status"
                                    name="live_status">
                                    <option value="1" {{ old('live_status', '1') == '1' ? 'selected' : '' }}>Live
                                    </option>
                                    <option value="0" {{ old('live_status') == '0' ? 'selected' : '' }}>Deceased
                                    </option>
                                </select>
                                @error('live_status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>



                            {{-- Date of Death --}}
                            <div class="col-md-2 mb-3 d-none">
                                <label for="dod" class="form-label">Date of Death</label>
                                <input type="date" name="dod" id="dod" class="form-control"
                                    value="{{ old('dod') }}">
                                @error('dod')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>


                            {{-- Marital Status --}}
                            <div class="col-md-2 mb-3">
                                <label class="form-label" for="marital_status">Marital Status</label>
                                <select class="form-select @error('marital_status') is-invalid @enderror"
                                    id="marital_status" name="marital_status">
                                    <option value="">Select</option>
                                    <option value="single" {{ old('marital_status') == 'single' ? 'selected' : '' }}>Single
                                    </option>
                                    <option value="married" {{ old('marital_status') == 'married' ? 'selected' : '' }}>
                                        Married</option>
                                    <option value="divorcee" {{ old('marital_status') == 'divorcee' ? 'selected' : '' }}>
                                        Divorcee</option>
                                    <option value="widow" {{ old('marital_status') == 'widow' ? 'selected' : '' }}>Widow
                                    </option>
                                    <option value="other" {{ old('marital_status') == 'other' ? 'selected' : '' }}>Other
                                    </option>
                                </select>
                                @error('marital_status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            {{-- Nationality --}}
                            <div class="col-md-2 mb-3">
                                <label class="form-label" for="nationality">Nationality</label>
                                <select class="form-select @error('nationality') is-invalid @enderror" id="nationality"
                                    name="nationality">
                                    <option value="">Select</option>
                                    <option value="resident" {{ old('nationality') == 'resident' ? 'selected' : '' }}>
                                        Residential Individual</option>
                                    <option value="nro" {{ old('nationality') == 'nro' ? 'selected' : '' }}>NRO</option>
                                    <option value="nre" {{ old('nationality') == 'nre' ? 'selected' : '' }}>NRE</option>
                                    <option value="oci_pio" {{ old('nationality') == 'oci_pio' ? 'selected' : '' }}>OCI/PIO
                                    </option>
                                    <option value="green_card_holder"
                                        {{ old('nationality') == 'green_card_holder' ? 'selected' : '' }}>Green Card Holder
                                    </option>
                                    <option value="tax_resident"
                                        {{ old('nationality') == 'tax_resident' ? 'selected' : '' }}>Tax Resident in Other
                                        Country</option>
                                    <option value="foreign_nation"
                                        {{ old('nationality') == 'foreign_nation' ? 'selected' : '' }}>Foreign National
                                    </option>
                                    <option value="other" {{ old('nationality') == 'other' ? 'selected' : '' }}>Other
                                    </option>
                                </select>
                                @error('nationality')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            {{-- Occupation --}}
                            <div class="col-md-2 mb-3">
                                <label class="form-label" for="occupation">Occupation</label>
                                <select class="form-select @error('occupation') is-invalid @enderror" id="occupation"
                                    name="occupation">
                                    <option value="">Select</option>
                                    <option value="private_service"
                                        {{ old('occupation') == 'private_service' ? 'selected' : '' }}>Private Sector
                                    </option>
                                    <option value="public_service"
                                        {{ old('occupation') == 'public_service' ? 'selected' : '' }}>Public Sector
                                    </option>
                                    <option value="government_service"
                                        {{ old('occupation') == 'government_service' ? 'selected' : '' }}>Government
                                        Service</option>
                                    <option value="business" {{ old('occupation') == 'business' ? 'selected' : '' }}>
                                        Business</option>
                                    <option value="professional"
                                        {{ old('occupation') == 'professional' ? 'selected' : '' }}>Professional</option>
                                    <option value="agriculture"
                                        {{ old('occupation') == 'agriculture' ? 'selected' : '' }}>
                                        Agriculture</option>
                                    <option value="retired" {{ old('occupation') == 'retired' ? 'selected' : '' }}>Retired
                                    </option>
                                    <option value="housewife" {{ old('occupation') == 'housewife' ? 'selected' : '' }}>
                                        Housewife</option>
                                    <option value="student" {{ old('occupation') == 'student' ? 'selected' : '' }}>Student
                                    </option>
                                    <option value="doctor" {{ old('occupation') == 'doctor' ? 'selected' : '' }}>Doctor
                                    </option>
                                    <option value="education" {{ old('occupation') == 'education' ? 'selected' : '' }}>
                                        Education</option>
                                    <option value="other" {{ old('occupation') == 'other' ? 'selected' : '' }}>Other
                                    </option>
                                </select>
                                @error('occupation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            {{-- PAN No. --}}
                            <div class="col-md-2 mb-3">
                                <label class="form-label" for="pan_no">PAN No.</label>
                                <input type="text" class="form-control @error('pan_no') is-invalid @enderror"
                                    id="pan_no" name="pan_no" maxlength="10" value="{{ old('pan_no') }}"
                                    oninput="this.value = this.value.toUpperCase()"
                                    onblur="validatePAN(this.value,'errpancardno')">
                                @error('pan_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            {{-- Aadhaar No. --}}
                            <div class="col-md-2 mb-3">
                                <label class="form-label" for="aadhar_no">Aadhaar No.</label>
                                <input type="text" class="form-control @error('aadhar_no') is-invalid @enderror"
                                    id="aadhar_no" name="aadhar_no" maxlength="12" value="{{ old('aadhar_no') }}">
                                @error('aadhar_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            {{-- CKYC No --}}
                            <div class="col-md-2 mb-3">
                                <label class="form-label" for="ckyc_no">CKYC No.</label>
                                <input type="text" class="form-control @error('ckyc_no') is-invalid @enderror"
                                    id="ckyc_no" name="ckyc_no" maxlength="20" value="{{ old('ckyc_no') }}">
                                @error('ckyc_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>



                            {{-- Mobile Number --}}
                            <div class="col-md-2 mb-3">
                                <label class="form-label" for="mobile_no">Mobile Number</label>
                                <input type="text"
                                    class="form-control onlyphone @error('mobile_no') is-invalid @enderror"
                                    id="mobile_no" name="mobile_no" maxlength="15" value="{{ old('mobile_no') }}">
                                @error('mobile_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            {{-- WhatsApp Number --}}
                            <div class="col-md-2 mb-3">
                                <label class="form-label" for="whatsapp_no">WhatsApp Number</label>
                                <input type="text"
                                    class="form-control onlyphone @error('whatsapp_no') is-invalid @enderror"
                                    id="whatsapp_no" name="whatsapp_no" maxlength="15"
                                    value="{{ old('whatsapp_no') }}">
                                @error('whatsapp_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            {{-- Landline No --}}
                            <div class="col-md-2 mb-3">
                                <label class="form-label" for="landline_no">Landline No.</label>
                                <input type="text" class="form-control @error('landline_no') is-invalid @enderror"
                                    id="landline_no" name="landline_no" maxlength="15"
                                    value="{{ old('landline_no') }}">
                                @error('landline_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            {{-- Email --}}
                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="email">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>



                            {{-- Relation Manager --}}
                            <div class="col-md-3 mb-3">
                                <label for="relation_manager" class="form-label">Relation Manager</label>
                                <select name="relation_manager_id" id="relation_manager" class="form-select">
                                    <option value="">Select Relation Manager</option>
                                    {{-- @foreach ($relationManagers as $manager)
                                        <option value="{{ $manager->id }}"
                                            {{ old('relation_manager_id') == $manager->id ? 'selected' : '' }}>
                                            {{ $manager->name }}
                                        </option>
                                    @endforeach --}}
                                </select>
                                @error('relation_manager_id')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>


                            {{-- Remarks / Note --}}
                            <div class="col-md-5 mb-3">
                                <label class="form-label" for="remarks">Remarks / Note</label>
                                <input type="text" class="form-control @error('remarks') is-invalid @enderror"
                                    id="remarks" name="remarks" maxlength="100" value="{{ old('remarks') }}">
                                @error('remarks')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>






                            <!-- Residential Address -->
                            <hr>
                            <h6 class="mb-3">Residential Address</h6>
                            <div class="col-6 mb-3">
                                <label class="form-label">Address</label>
                                <input type="text" name="registered_address" id="registered_address"
                                    class="form-control @error('registered_address') is-invalid @enderror"
                                    value="{{ old('registered_address') }}">
                                @error('registered_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            {{-- State --}}
                            <div class="col-md-2 mb-3">
                                <label class="form-label">State</label>
                                <input type="text" name="registered_state" id="registered_state"
                                    class="form-control @error('registered_state') is-invalid @enderror"
                                    value="{{ old('registered_state') }}">
                                @error('registered_state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            {{-- City --}}
                            <div class="col-md-2 mb-3">
                                <label class="form-label">City</label>
                                <input type="text" name="registered_city" id="registered_city"
                                    class="form-control @error('registered_city') is-invalid @enderror"
                                    value="{{ old('registered_city') }}">
                                @error('registered_city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            {{-- Postal Code --}}
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Postal Code</label>
                                <input type="text" name="registered_pincode" id="registered_pincode"
                                    class="form-control onlydigit @error('registered_pincode') is-invalid @enderror"
                                    value="{{ old('registered_pincode') }}" maxlength="6">
                                @error('registered_pincode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>



                            <!-- Additional Address -->
                            <hr>
                            <h6 class="mb-3">Office Address</h6>
                            <div class="col-6 mb-3">
                                <label class="form-label">Address</label>
                                <input type="text" name="additional_address" id="additional_address"
                                    class="form-control @error('additional_address') is-invalid @enderror"
                                    value="{{ old('additional_address') }}">
                                @error('additional_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>



                            <div class="col-md-2 mb-3">
                                <label class="form-label">State</label>
                                <input type="text" name="additional_state" id="additional_state"
                                    class="form-control @error('additional_state') is-invalid @enderror"
                                    value="{{ old('additional_state') }}">
                                @error('additional_state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2 mb-3">
                                <label class="form-label">City</label>
                                <input type="text" name="additional_city" id="additional_city"
                                    class="form-control @error('additional_city') is-invalid @enderror"
                                    value="{{ old('additional_city') }}">
                                @error('additional_city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2 mb-3">
                                <label class="form-label">Pincode</label>
                                <input type="text" name="additional_pincode" id="additional_pincode"
                                    class="form-control onlydigit @error('additional_pincode') is-invalid @enderror"
                                    value="{{ old('additional_pincode') }}" maxlength="6">
                                @error('additional_pincode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>
                </div>
            </div>




            {{-- Family details --}}
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Family details</h5>
                        <small class="text-muted float-end">Family Information</small>
                    </div>
                    <div class="card-body">
                        <div class="col-12 ">
                            <div class="alert alert-info mt-3">
                                <i class="bx bx-info-circle me-1"></i>
                                <strong>Note:</strong>
                                If the family is already registered, please select it from the dropdown.
                                If not, save this record first, then go to the <strong>Family</strong> menu to add a new
                                family member for this profile.


                            </div>
                            <div id="bankDetailsWrapper">

                                <div class="bank-details-row row g-3 mb-3 bg-light position-relative">

                                    {{-- Relation Manager --}}
                                    <div class="col-md-3 mb-3">
                                        <label for="relation_manager" class="form-label">Family from profile</label>
                                        <select name="relation_manager_id" id="relation_manager" class="form-select">
                                            <option value="">Select Relation Manager</option>
                                            {{-- @foreach ($relationManagers as $manager)
                                        <option value="{{ $manager->id }}"
                                            {{ old('relation_manager_id') == $manager->id ? 'selected' : '' }}>
                                            {{ $manager->name }}
                                        </option>
                                    @endforeach --}}
                                        </select>
                                        @error('relation_manager_id')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>



                                    {{-- Relation Manager --}}
                                    <div class="col-md-3 mb-3">
                                        <label for="relation_manager" class="form-label">Relation Manager</label>
                                        <select name="relation_manager_id" id="relation_manager" class="form-select">
                                            <option value="">Select Relation Manager</option>
                                            {{-- @foreach ($relationManagers as $manager)
                                        <option value="{{ $manager->id }}"
                                            {{ old('relation_manager_id') == $manager->id ? 'selected' : '' }}>
                                            {{ $manager->name }}
                                        </option>
                                    @endforeach --}}
                                        </select>
                                        @error('relation_manager_id')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>



                                    <div class="col-md-6 d-flex align-items-end">
                                        <button type="button" class="btn btn-danger btn-sm removeBankRow d-none">
                                            <i class="bx bx-minus"></i> Remove
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Add More Button -->
                            <div class="mt-2">
                                <button type="button" id="addMoreBank" class="btn btn-primary">
                                    <i class="bx bx-plus"></i> Add More Family member
                                </button>
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
                                    <div class="col-md-6">
                                        <label class="form-label">IFSC Code</label>
                                        <input type="text" name="banks[0][ifsc_code]" class="form-control ifsc_code"
                                            placeholder="Enter IFSC Code">
                                        <span class="invalid-feedback errmsg"></span>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Account No</label>
                                        <input type="text" name="banks[0][account_number]"
                                            class="form-control account_number" placeholder="Enter Account Number">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Bank Name</label>
                                        <input type="text" name="banks[0][bank_name]"
                                            class="form-control bank_name bg-secondary-subtle bg-gradient" readonly>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Branch Name</label>
                                        <input type="text" name="banks[0][branch_name]"
                                            class="form-control branch_name bg-secondary-subtle bg-gradient" readonly>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Bank Code</label>
                                        <input type="text" name="banks[0][bank_code]"
                                            class="form-control bank_code bg-secondary-subtle bg-gradient" readonly>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label d-block">Primary a/c</label>
                                        <input type="hidden" name="banks[0][is_primary]" value="0">
                                        <input type="checkbox" name="banks[0][is_primary]" value="1"
                                            class="form-check-input setPrimary">
                                    </div>

                                    <div class="col-md-6 d-flex align-items-end">
                                        <button type="button" class="btn btn-danger btn-sm removeBankRow d-none">
                                            <i class="bx bx-minus"></i> Remove
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Add More Button -->
                            <div class="mt-2">
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
                            <!-- Profile Photo -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Client Photo</label>
                                <div class="input-group">
                                    <input type="file"
                                        class="form-control @error('attachment_client_photo') is-invalid @enderror"
                                        id="attachment_client_photo" name="attachment_client_photo"
                                        accept=".jpg,.jpeg,.png">
                                    <button class="btn btn-outline-danger" type="button"
                                        onclick="document.getElementById('attachment_client_photo').value = ''">✕</button>
                                </div>
                                @error('attachment_client_photo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <!-- Aadhar Card -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">pan Card</label>
                                <div class="input-group">
                                    <input type="file"
                                        class="form-control @error('attachment_pan') is-invalid @enderror"
                                        id="attachment_pan" name="attachment_pan" accept=".pdf,.jpg,.jpeg,.png">
                                    <button class="btn btn-outline-danger" type="button"
                                        onclick="document.getElementById('attachment_pan').value = ''">✕</button>
                                </div>
                                @error('attachment_pan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <!-- aadhar Card front-->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">aadhar Card front</label>
                                <div class="input-group">
                                    <input type="file"
                                        class="form-control @error('attachment_aadhar_front') is-invalid @enderror"
                                        id="attachment_aadhar_front" name="attachment_aadhar_front"
                                        accept=".pdf,.jpg,.jpeg,.png">
                                    <button class="btn btn-outline-danger" type="button"
                                        onclick="document.getElementById('attachment_aadhar_front').value = ''">✕</button>
                                </div>
                                @error('attachment_aadhar_front')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <!-- aadhar Card back -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">aadhar Card Back</label>
                                <div class="input-group">
                                    <input type="file"
                                        class="form-control @error('attachment_aadhar_back') is-invalid @enderror"
                                        id="attachment_aadhar_back" name="attachment_aadhar_back"
                                        accept=".pdf,.jpg,.jpeg,.png">
                                    <button class="btn btn-outline-danger" type="button"
                                        onclick="document.getElementById('attachment_aadhar_back').value = ''">✕</button>
                                </div>
                                @error('attachment_aadhar_back')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>



                            <!-- Signature -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Signature</label>
                                <div class="input-group">
                                    <input type="file"
                                        class="form-control @error('attachment_signature') is-invalid @enderror"
                                        id="attachment_signature" name="attachment_signature"
                                        accept=".pdf,.jpg,.jpeg,.png">
                                    <button class="btn btn-outline-danger" type="button"
                                        onclick="document.getElementById('attachment_signature').value = ''">✕</button>
                                </div>
                                @error('attachment_signature')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Resume -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">ckyc</label>
                                <div class="input-group">
                                    <input type="file"
                                        class="form-control @error('attachment_ckyc') is-invalid @enderror"
                                        id="attachment_ckyc" name="attachment_ckyc" accept=".pdf,.doc,.docx">
                                    <button class="btn btn-outline-danger" type="button"
                                        onclick="document.getElementById('attachment_ckyc').value = ''">✕</button>
                                </div>
                                @error('attachment_ckyc')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Other Supporting Documents -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Other Documents (Optional)</label>
                                <div class="input-group">
                                    <input type="file"
                                        class="form-control @error('attachment_other_documents') is-invalid @enderror"
                                        id="attachment_other_documents" name="attachment_other_documents[]"
                                        accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" multiple>
                                    <button class="btn btn-outline-danger" type="button"
                                        onclick="document.getElementById('attachment_other_documents').value = ''">✕</button>
                                </div>
                                @error('attachment_other_documents')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>



                    </div>
                </div>
            </div>






        </div>



        <!-- Submit -->
        <!-- Info / Note -->


        <div class="text-end mt-3">
            <button type="submit" class="btn btn-primary px-4">Save</button>
            <a href="" class="btn btn-secondary px-4">Cancel</a>
        </div>
    </form>


@endsection

@push('scripts')
@endpush
