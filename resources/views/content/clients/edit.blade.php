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


    <form action="{{ route('clients.update', $client->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="row align-items-stretch">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Primary Information</h5>
                        <small class="text-muted float-end">client Basic Details</small>
                    </div>
                    <div class="card-body">
                        <div class="row">



                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="name">Full Name</label>
                                <input type="text" class="form-control onlyalpha @error('name') is-invalid @enderror"
                                    id="name" name="name" maxlength="50"
                                    value="{{ old('name', $client->name ?? '') }}">
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
                                    <option value="male"
                                        {{ old('gender', $client->gender ?? '') == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female"
                                        {{ old('gender', $client->gender ?? '') == 'female' ? 'selected' : '' }}>Female
                                    </option>
                                    <option value="other"
                                        {{ old('gender', $client->gender ?? '') == 'other' ? 'selected' : '' }}>Other
                                    </option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Date of Birth --}}
                            <div class="col-md-2 mb-3">
                                <label class="form-label" for="dob">Date of Birth</label>
                                <input type="date" class="form-control @error('dob') is-invalid @enderror" id="dob"
                                    name="dob"
                                    value="{{ old('dob', isset($client->dob) ? \Carbon\Carbon::parse($client->dob)->format('Y-m-d') : '') }}"
                                    max="{{ now()->toDateString() }}">

                                @error('dob')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Live Status --}}
                            <div class="col-md-2 mb-3">
                                <label class="form-label" for="live_status">Live Status</label>
                                <select class="form-select @error('live_status') is-invalid @enderror" id="live_status"
                                    name="live_status">
                                    <option value="alive"
                                        {{ old('live_status', $client->live_status ?? 'alive') == 'alive' ? 'selected' : '' }}>
                                        Live</option>
                                    <option value="deceased"
                                        {{ old('live_status', $client->live_status ?? '') == 'deceased' ? 'selected' : '' }}>
                                        Deceased</option>
                                </select>
                                @error('live_status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Date of Death --}}
                            <div
                                class="col-md-2 mb-3 {{ old('live_status', $client->live_status ?? '') == 'deceased' ? '' : 'd-none' }}">
                                <label for="dod" class="form-label">Date of Death</label>
                                <input type="date" name="dod" id="dod" class="form-control"
                                    value="{{ old('dod', $client->dod ?? '') }}">
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
                                    <option value="single"
                                        {{ old('marital_status', $client->marital_status ?? '') == 'single' ? 'selected' : '' }}>
                                        Single</option>
                                    <option value="married"
                                        {{ old('marital_status', $client->marital_status ?? '') == 'married' ? 'selected' : '' }}>
                                        Married</option>
                                    <option value="divorcee"
                                        {{ old('marital_status', $client->marital_status ?? '') == 'divorcee' ? 'selected' : '' }}>
                                        Divorcee</option>
                                    <option value="widow"
                                        {{ old('marital_status', $client->marital_status ?? '') == 'widow' ? 'selected' : '' }}>
                                        Widow</option>
                                    <option value="other"
                                        {{ old('marital_status', $client->marital_status ?? '') == 'other' ? 'selected' : '' }}>
                                        Other</option>
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
                                    <option value="ri"
                                        {{ old('nationality', $client->nationality ?? '') == 'ri' ? 'selected' : '' }}>
                                        Residential Individual
                                    </option>
                                    <option value="nro"
                                        {{ old('nationality', $client->nationality ?? '') == 'nro' ? 'selected' : '' }}>
                                        NRO
                                    </option>
                                    <option value="nre"
                                        {{ old('nationality', $client->nationality ?? '') == 'nre' ? 'selected' : '' }}>
                                        NRE
                                    </option>
                                    <option value="pio"
                                        {{ old('nationality', $client->nationality ?? '') == 'pio' ? 'selected' : '' }}>
                                        PIO
                                    </option>
                                    <option value="oci"
                                        {{ old('nationality', $client->nationality ?? '') == 'oci' ? 'selected' : '' }}>
                                        OCI
                                    </option>
                                    <option value="gch"
                                        {{ old('nationality', $client->nationality ?? '') == 'gch' ? 'selected' : '' }}>
                                        Green Card Holder
                                    </option>
                                    <option value="trioc"
                                        {{ old('nationality', $client->nationality ?? '') == 'trioc' ? 'selected' : '' }}>
                                        Tax Resident in Other Country
                                    </option>
                                    <option value="fn"
                                        {{ old('nationality', $client->nationality ?? '') == 'fn' ? 'selected' : '' }}>
                                        Foreign National
                                    </option>
                                    <option value="other"
                                        {{ old('nationality', $client->nationality ?? '') == 'other' ? 'selected' : '' }}>
                                        Other
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
                                    <option value="private_sector"
                                        {{ old('occupation', $client->occupation ?? '') == 'private_sector' ? 'selected' : '' }}>
                                        Private Sector</option>
                                    <option value="public_sector"
                                        {{ old('occupation', $client->occupation ?? '') == 'public_sector' ? 'selected' : '' }}>
                                        Public Sector</option>
                                    <option value="government"
                                        {{ old('occupation', $client->occupation ?? '') == 'government' ? 'selected' : '' }}>
                                        Government Service</option>
                                    <option value="business"
                                        {{ old('occupation', $client->occupation ?? '') == 'business' ? 'selected' : '' }}>
                                        Business</option>
                                    <option value="professional"
                                        {{ old('occupation', $client->occupation ?? '') == 'professional' ? 'selected' : '' }}>
                                        Professional</option>
                                    <option value="agriculture"
                                        {{ old('occupation', $client->occupation ?? '') == 'agriculture' ? 'selected' : '' }}>
                                        Agriculture</option>
                                    <option value="retired"
                                        {{ old('occupation', $client->occupation ?? '') == 'retired' ? 'selected' : '' }}>
                                        Retired</option>
                                    <option value="housewife"
                                        {{ old('occupation', $client->occupation ?? '') == 'housewife' ? 'selected' : '' }}>
                                        Housewife</option>
                                    <option value="student"
                                        {{ old('occupation', $client->occupation ?? '') == 'student' ? 'selected' : '' }}>
                                        Student</option>
                                    <option value="doctor"
                                        {{ old('occupation', $client->occupation ?? '') == 'doctor' ? 'selected' : '' }}>
                                        Doctor</option>
                                    <option value="education"
                                        {{ old('occupation', $client->occupation ?? '') == 'education' ? 'selected' : '' }}>
                                        Education</option>
                                    <option value="other"
                                        {{ old('occupation', $client->occupation ?? '') == 'other' ? 'selected' : '' }}>
                                        Other</option>
                                </select>
                                @error('occupation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- PAN No. --}}
                            <div class="col-md-2 mb-3">
                                <label class="form-label" for="pan_no">PAN No.</label>
                                <input type="text" class="form-control @error('pan_no') is-invalid @enderror"
                                    id="pan_no" name="pan_no" maxlength="10"
                                    value="{{ old('pan_no', $client->pan_no ?? '') }}"
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
                                    id="aadhar_no" name="aadhar_no" maxlength="12"
                                    value="{{ old('aadhar_no', $client->aadhar_no ?? '') }}">
                                @error('aadhar_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Mobile Number --}}
                            <div class="col-md-2 mb-3">
                                <label class="form-label" for="mobile_no">Phone Number</label>
                                <input type="text"
                                    class="form-control onlyphone @error('mobile_no') is-invalid @enderror" id="mobile_no"
                                    name="mobile_no" maxlength="15"
                                    value="{{ old('mobile_no', $client->mobile_no ?? '') }}">
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
                                    value="{{ old('whatsapp_no', $client->whatsapp_no ?? '') }}">
                                <label class="uk-margin-right">
                                    <input class="uk-checkbox chkbox_fwapp_same_as_mobile" type="checkbox"
                                        id="same_as_mobile" value="ON">
                                    <small> Same as phone no.</small>
                                </label>
                                @error('whatsapp_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Landline No --}}
                            <div class="col-md-2 mb-3">
                                <label class="form-label" for="landline_no">Landline No.</label>
                                <input type="text" class="form-control @error('landline_no') is-invalid @enderror"
                                    id="landline_no" name="landline_no" maxlength="15"
                                    value="{{ old('landline_no', $client->landline_no ?? '') }}">
                                @error('landline_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- CKYC No --}}
                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="ckyc_no">CKYC No.</label>
                                <input type="text" class="form-control @error('ckyc_no') is-invalid @enderror"
                                    id="ckyc_no" name="ckyc_no" maxlength="14"
                                    value="{{ old('ckyc_no', $client->ckyc_no ?? '') }}">
                                @error('ckyc_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="email">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email', $client->email ?? '') }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Relation Manager --}}
                            <div class="col-md-3 mb-3">
                                <label for="relation_manager" class="form-label">Relation / Account Manager</label>
                                <select name="relation_manager_id" id="relation_manager" class="form-select">
                                    <option value="">Select Relation Manager</option>
                                    {{-- @foreach ($relationManagers as $manager)
                                        <option value="{{ $manager->id }}"
                                            {{ old('relation_manager_id', $client->relation_manager_id ?? '') == $manager->id ? 'selected' : '' }}>
                                            {{ $manager->name }}
                                        </option>
                                    @endforeach --}}
                                </select>
                                @error('relation_manager_id')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Remarks / Note --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label" for="remarks">Remarks / Note</label>
                                <input type="text" class="form-control @error('remarks') is-invalid @enderror"
                                    id="remarks" name="remarks" maxlength="100"
                                    value="{{ old('remarks', $client->remarks ?? '') }}">
                                @error('remarks')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Residential Address -->
                            <h6 class="my-3">Residential Address</h6>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Address</label>
                                <input type="text" name="res_address" id="res_address"
                                    class="form-control @error('res_address') is-invalid @enderror"
                                    value="{{ old('res_address', $client->res_address ?? '') }}">
                                @error('res_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2 mb-3">
                                <label class="form-label">Country</label>
                                <select name="res_country" id="res_country"
                                    class="form-select select2 @error('res_country') is-invalid @enderror">
                                    <option value="">Select Country</option>
                                    <option value="India"
                                        {{ old('res_country', $client->res_country ?? '') == 'India' ? 'selected' : '' }}>
                                        India</option>
                                    <option value="USA"
                                        {{ old('res_country', $client->res_country ?? '') == 'USA' ? 'selected' : '' }}>
                                        United States</option>
                                    <option value="UK"
                                        {{ old('res_country', $client->res_country ?? '') == 'UK' ? 'selected' : '' }}>
                                        United Kingdom</option>
                                </select>
                                @error('res_country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2 mb-3">
                                <label class="form-label">State</label>
                                <select name="res_state" id="res_state"
                                    class="form-select select2 @error('res_state') is-invalid @enderror">
                                    <option value="">Select State</option>
                                    <option value="Maharashtra"
                                        {{ old('res_state', $client->res_state ?? '') == 'Maharashtra' ? 'selected' : '' }}>
                                        Maharashtra</option>
                                    <option value="Gujarat"
                                        {{ old('res_state', $client->res_state ?? '') == 'Gujarat' ? 'selected' : '' }}>
                                        Gujarat</option>
                                    <option value="Delhi"
                                        {{ old('res_state', $client->res_state ?? '') == 'Delhi' ? 'selected' : '' }}>Delhi
                                    </option>
                                </select>
                                @error('res_state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2 mb-3">
                                <label class="form-label">City</label>
                                <select name="res_city" id="res_city"
                                    class="form-select select2 @error('res_city') is-invalid @enderror">
                                    <option value="">Select City</option>
                                    <option value="Mumbai"
                                        {{ old('res_city', $client->res_city ?? '') == 'Mumbai' ? 'selected' : '' }}>Mumbai
                                    </option>
                                    <option value="Pune"
                                        {{ old('res_city', $client->res_city ?? '') == 'Pune' ? 'selected' : '' }}>Pune
                                    </option>
                                    <option value="Ahmedabad"
                                        {{ old('res_city', $client->res_city ?? '') == 'Ahmedabad' ? 'selected' : '' }}>
                                        Ahmedabad</option>
                                </select>
                                @error('res_city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2 mb-3">
                                <label class="form-label">Pincode</label>
                                <input type="text" name="res_pincode" id="res_pincode"
                                    class="form-control onlydigit @error('res_pincode') is-invalid @enderror"
                                    value="{{ old('res_pincode', $client->res_pincode ?? '') }}" maxlength="6">
                                @error('res_pincode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <!-- Office Address -->
                            <h6 class="my-3">Office Address</h6>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Address</label>
                                <input type="text" name="office_address" id="office_address"
                                    class="form-control @error('office_address') is-invalid @enderror"
                                    value="{{ old('office_address', $client->office_address ?? '') }}">
                                @error('office_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2 mb-3">
                                <label class="form-label">Country</label>
                                <select name="office_country" id="office_country"
                                    class="form-select select2 @error('office_country') is-invalid @enderror">
                                    <option value="">Select Country</option>
                                    <option value="India"
                                        {{ old('office_country', $client->office_country ?? '') == 'India' ? 'selected' : '' }}>
                                        India</option>
                                    <option value="USA"
                                        {{ old('office_country', $client->office_country ?? '') == 'USA' ? 'selected' : '' }}>
                                        United States</option>
                                    <option value="UK"
                                        {{ old('office_country', $client->office_country ?? '') == 'UK' ? 'selected' : '' }}>
                                        United Kingdom</option>
                                </select>
                                @error('office_country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2 mb-3">
                                <label class="form-label">State</label>
                                <select name="office_state" id="office_state"
                                    class="form-select select2 @error('office_state') is-invalid @enderror">
                                    <option value="">Select State</option>
                                    <option value="Maharashtra"
                                        {{ old('office_state', $client->office_state ?? '') == 'Maharashtra' ? 'selected' : '' }}>
                                        Maharashtra</option>
                                    <option value="Gujarat"
                                        {{ old('office_state', $client->office_state ?? '') == 'Gujarat' ? 'selected' : '' }}>
                                        Gujarat</option>
                                    <option value="Delhi"
                                        {{ old('office_state', $client->office_state ?? '') == 'Delhi' ? 'selected' : '' }}>
                                        Delhi</option>
                                </select>
                                @error('office_state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2 mb-3">
                                <label class="form-label">City</label>
                                <select name="office_city" id="office_city"
                                    class="form-select select2 @error('office_city') is-invalid @enderror">
                                    <option value="">Select City</option>
                                    <option value="Mumbai"
                                        {{ old('office_city', $client->office_city ?? '') == 'Mumbai' ? 'selected' : '' }}>
                                        Mumbai</option>
                                    <option value="Pune"
                                        {{ old('office_city', $client->office_city ?? '') == 'Pune' ? 'selected' : '' }}>
                                        Pune</option>
                                    <option value="Ahmedabad"
                                        {{ old('office_city', $client->office_city ?? '') == 'Ahmedabad' ? 'selected' : '' }}>
                                        Ahmedabad</option>
                                </select>
                                @error('office_city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2 mb-3">
                                <label class="form-label">Pincode</label>
                                <input type="text" name="office_pincode" id="office_pincode"
                                    class="form-control onlydigit @error('office_pincode') is-invalid @enderror"
                                    value="{{ old('office_pincode', $client->office_pincode ?? '') }}" maxlength="6">
                                @error('office_pincode')
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
                                @if ($client->banks && $client->banks->count() > 0)
                                    @foreach ($client->banks as $bank)
                                        <div class="bank-details-row row g-3 mb-3 bg-light position-relative">
                                            <div class="col-md-6">
                                                <label class="form-label">IFSC Code</label>
                                                <input type="text" name="banks[{{ $loop->index }}][ifsc_code]"
                                                    value="{{ old('banks.' . $loop->index . '.ifsc_code', $bank->ifsc_code ?? '') }}"
                                                    class="form-control ifsc_code" placeholder="Enter IFSC Code">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Account No</label>
                                                <input type="text" name="banks[{{ $loop->index }}][account_number]"
                                                    value="{{ old('banks.' . $loop->index . '.account_number', $bank->account_number ?? '') }}"
                                                    class="form-control account_number" maxlength="18"
                                                    placeholder="Enter Account Number">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Bank Name</label>
                                                <input type="text" name="banks[{{ $loop->index }}][bank_name]"
                                                    value="{{ old('banks.' . $loop->index . '.bank_name', $bank->bank_name ?? '') }}"
                                                    class="form-control bank_name bg-secondary-subtle bg-gradient"
                                                    readonly>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Branch Name</label>
                                                <input type="text" name="banks[{{ $loop->index }}][branch_name]"
                                                    value="{{ old('banks.' . $loop->index . '.branch_name', $bank->branch_name ?? '') }}"
                                                    class="form-control branch_name bg-secondary-subtle bg-gradient"
                                                    readonly>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Bank Code</label>
                                                <input type="text" name="banks[{{ $loop->index }}][bank_code]"
                                                    value="{{ old('banks.' . $loop->index . '.bank_code', $bank->bank_code ?? '') }}"
                                                    class="form-control bank_code bg-secondary-subtle bg-gradient"
                                                    readonly>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label d-block">Primary a/c</label>
                                                <input type="hidden" name="banks[{{ $loop->index }}][is_primary]"
                                                    value="0">
                                                <input type="checkbox" name="banks[{{ $loop->index }}][is_primary]"
                                                    value="1" class="form-check-input setPrimary"
                                                    {{ old('banks.' . $loop->index . '.is_primary', $bank->is_primary ?? false) ? 'checked' : '' }}>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-muted">No bank details available.</p>
                                @endif

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
                                @if (!empty($client->attachment_client_photo))
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $client->attachment_client_photo) }}"
                                            alt="Client Photo" class="img-fluid rounded" style="max-height: 150px;">
                                    </div>
                                @endif
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

                            <!-- PAN Card -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">PAN Card</label>
                                @if (!empty($client->attachment_pan))
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $client->attachment_pan) }}" alt="PAN Card"
                                            class="img-fluid rounded" style="max-height: 150px;">
                                    </div>
                                @endif
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

                            <!-- Aadhar Front -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Aadhar Card Front</label>
                                @if (!empty($client->attachment_aadhar_front))
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $client->attachment_aadhar_front) }}"
                                            alt="Aadhar Front" class="img-fluid rounded" style="max-height: 150px;">
                                    </div>
                                @endif
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

                            <!-- Aadhar Back -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Aadhar Card Back</label>
                                @if (!empty($client->attachment_aadhar_back))
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $client->attachment_aadhar_back) }}"
                                            alt="Aadhar Back" class="img-fluid rounded" style="max-height: 150px;">
                                    </div>
                                @endif
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
                                @if (!empty($client->attachment_signature))
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $client->attachment_signature) }}" alt="Signature"
                                            class="img-fluid rounded" style="max-height: 150px;">
                                    </div>
                                @endif
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

                            <!-- CKYC -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">CKYC</label>
                                @if (!empty($client->attachment_ckyc))
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $client->attachment_ckyc) }}" alt="CKYC Document"
                                            class="img-fluid rounded" style="max-height: 150px;">
                                    </div>
                                @endif
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

                            <!-- Other Documents -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Other Documents (Optional)</label>
                                @if (!empty($client->attachment_other_documents))
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $client->attachment_other_documents) }}"
                                            alt="Other Documents" class="img-fluid rounded" style="max-height: 150px;">
                                    </div>
                                @endif
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
            <button type="submit" class="btn btn-primary px-4">Update</button>
            <a href="{{ route('clients.index') }}" class="btn btn-secondary px-4">Cancel</a>
        </div>
    </form>


@endsection

@push('scripts')
    <script>
        document.querySelector('.chkbox_fwapp_same_as_mobile').addEventListener('change', function() {
            const mobile = document.getElementById('mobile_no').value;
            const whatsapp = document.getElementById('whatsapp_no');
            if (this.checked) {
                whatsapp.value = mobile;
            } else {
                whatsapp.value = '';
            }
        });
    </script>
@endpush
