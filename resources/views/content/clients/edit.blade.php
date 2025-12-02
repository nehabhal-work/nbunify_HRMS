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


    <div class="text-end mt-3">
        <a href="{{ route('clients.index') }}" class="btn btn-secondary px-4">Go back</a>
        <a href="{{ route('client-families.index', ['client_id' => $client->id]) }}"
            class="btn btn-warning px-4 text-dark">Show
            Families</a>
    </div>
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
                                <input type="date" class="form-control  @error('dob') is-invalid @enderror"
                                    id="dob" name="dob"
                                    value="{{ old('dob', isset($client->dob) ? \Carbon\Carbon::parse($client->dob)->format('d-m-Y') : '') }}"
                                    max="{{ now()->toDateString() }}"  placeholder="Select Date">

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
                                <input type="text" name="dod" id="dod" class="form-control datepicker"
                                    value="{{ old('dod', $client->dod ?? '') }}" readonly placeholder="Select Date">
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

                            {{-- COUNTRY --}}
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Country</label>
                                <select name="res_country_code" id="res_country_code"
                                    class="form-select select2 @error('res_country_code') is-invalid @enderror">

                                    <option value="{{ $client->res_country_code }}"
                                        data-country-name="{{ $client->res_country }}"
                                        {{ $client->res_country_code == $country['iso2'] ? 'selected' : '' }}>
                                        {{ $client->res_country }}
                                    </option>

                                </select>
                                @error('res_country_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- STATE --}}
                            <div class="col-md-2 mb-3">
                                <label class="form-label">State</label>
                                <select name="res_state_code" id="res_state_code"
                                    class="form-select select2 @error('res_state_code') is-invalid @enderror">

                                    @foreach ($states as $state)
                                        <option value="{{ $state['iso2'] }}" data-state-name="{{ $state['name'] }}"
                                            {{ $client->res_state_code == $state['iso2'] ? 'selected' : '' }}>
                                            {{ $state['name'] }}
                                        </option>
                                    @endforeach

                                </select>
                                @error('res_state_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- CITY --}}
                            <div class="col-md-2 mb-3">
                                <label class="form-label">City</label>
                                <select name="res_city_code" id="res_city_code"
                                    class="form-select select2 @error('res_city_code') is-invalid @enderror">

                                    <option value="{{ $client->res_city_code }}"
                                        data-city-name="{{ $client->res_city }}">
                                        {{ $client->res_city }}
                                    </option>

                                </select>
                                @error('res_city_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Hidden (readable values) --}}
                            <input type="hidden" name="res_country" id="res_country"
                                value="{{ $client->res_country }}">
                            <input type="hidden" name="res_state" id="res_state" value="{{ $client->res_state }}">
                            <input type="hidden" name="res_city" id="res_city" value="{{ $client->res_city }}">


                            {{-- pincode --}}
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Pincode</label>
                                <input type="text" name="res_pincode" id="res_pincode"
                                    class="form-control onlydigit @error('res_pincode') is-invalid @enderror"
                                    value="{{ old('res_pincode', $client->res_pincode ?? '') }}" maxlength="6">
                                @error('res_pincode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>



                            {{-- OFFICE ADDRESS --}}
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

                            {{-- COUNTRY --}}
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Country</label>
                                <select name="office_country_code" id="office_country_code"
                                    class="form-select select2 @error('office_country_code') is-invalid @enderror">

                                    <option value="{{ $client->office_country_code }}"
                                        data-country-name="{{ $client->office_country }}">
                                        {{ $client->office_country }}
                                    </option>

                                </select>
                                @error('office_country_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- STATE --}}
                            <div class="col-md-2 mb-3">
                                <label class="form-label">State</label>
                                <select name="office_state_code" id="office_state_code"
                                    class="form-select select2 @error('office_state_code') is-invalid @enderror">

                                    @foreach ($states as $state)
                                        <option value="{{ $state['iso2'] }}" data-state-name="{{ $state['name'] }}"
                                            {{ $client->office_state_code == $state['iso2'] ? 'selected' : '' }}>
                                            {{ $state['name'] }}
                                        </option>
                                    @endforeach

                                </select>
                                @error('office_state_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- CITY --}}
                            <div class="col-md-2 mb-3">
                                <label class="form-label">City</label>
                                <select name="office_city_code" id="office_city_code"
                                    class="form-select select2 @error('office_city_code') is-invalid @enderror">

                                    <option value="{{ $client->office_city_code }}"
                                        data-city-name="{{ $client->office_city }}">
                                        {{ $client->office_city }}
                                    </option>

                                </select>
                                @error('office_city_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Hidden (readable values) --}}
                            <input type="hidden" name="office_country" id="office_country"
                                value="{{ $client->office_country }}">
                            <input type="hidden" name="office_state" id="office_state"
                                value="{{ $client->office_state }}">
                            <input type="hidden" name="office_city" id="office_city"
                                value="{{ $client->office_city }}">


                            {{-- pincode --}}
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
            <div class="col-md-6 d-flex d-none">
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

                                            {{-- IFSC --}}
                                            <div class="col-md-6">
                                                <label class="form-label">IFSC Code</label>
                                                <input type="text" name="banks[{{ $loop->index }}][ifsc_code]"
                                                    value="{{ old('banks.' . $loop->index . '.ifsc_code', $bank->ifsc_code) }}"
                                                    class="form-control ifsc_code @error('banks.' . $loop->index . '.ifsc_code') is-invalid @enderror"
                                                    placeholder="Enter IFSC Code">
                                                @error('banks.' . $loop->index . '.ifsc_code')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            {{-- Account No --}}
                                            <div class="col-md-6">
                                                <label class="form-label">Account No</label>
                                                <input type="text" name="banks[{{ $loop->index }}][account_number]"
                                                    value="{{ old('banks.' . $loop->index . '.account_number', $bank->account_number) }}"
                                                    class="form-control account_number @error('banks.' . $loop->index . '.account_number') is-invalid @enderror"
                                                    maxlength="18" placeholder="Enter Account Number">
                                                @error('banks.' . $loop->index . '.account_number')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            {{-- Operation Mode --}}
                                            <div class="col-md-6">
                                                <label class="form-label">Operation Mode</label>
                                                <select name="banks[{{ $loop->index }}][operation_mode]"
                                                    class="form-select operation_mode @error('banks.' . $loop->index . '.operation_mode') is-invalid @enderror">
                                                    <option value="">Select Mode</option>
                                                    <option value="single"
                                                        {{ old('banks.' . $loop->index . '.operation_mode', $bank->operation_mode) == 'single' ? 'selected' : '' }}>
                                                        Single</option>
                                                    <option value="joint"
                                                        {{ old('banks.' . $loop->index . '.operation_mode', $bank->operation_mode) == 'joint' ? 'selected' : '' }}>
                                                        Joint</option>
                                                    <option value="anyone"
                                                        {{ old('banks.' . $loop->index . '.operation_mode', $bank->operation_mode) == 'anyone' ? 'selected' : '' }}>
                                                        Anyone</option>
                                                </select>
                                                @error('banks.' . $loop->index . '.operation_mode')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            {{-- Holder Name 1 --}}
                                            <div class="col-md-6 holder_name_1 d-none">
                                                <label class="form-label">Holder Name 1</label>
                                                <input type="text" name="banks[{{ $loop->index }}][holder_name_1]"
                                                    value="{{ old('banks.' . $loop->index . '.holder_name_1', $bank->holder_name_1) }}"
                                                    class="form-control @error('banks.' . $loop->index . '.holder_name_1') is-invalid @enderror">
                                                @error('banks.' . $loop->index . '.holder_name_1')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            {{-- Holder Name 2 --}}
                                            <div class="col-md-6 holder_name_2 d-none">
                                                <label class="form-label">Holder Name 2</label>
                                                <input type="text" name="banks[{{ $loop->index }}][holder_name_2]"
                                                    value="{{ old('banks.' . $loop->index . '.holder_name_2', $bank->holder_name_2) }}"
                                                    class="form-control @error('banks.' . $loop->index . '.holder_name_2') is-invalid @enderror">
                                                @error('banks.' . $loop->index . '.holder_name_2')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            {{-- Holder Name 3 --}}
                                            <div class="col-md-6 holder_name_3 d-none">
                                                <label class="form-label">Holder Name 3</label>
                                                <input type="text" name="banks[{{ $loop->index }}][holder_name_3]"
                                                    value="{{ old('banks.' . $loop->index . '.holder_name_3', $bank->holder_name_3) }}"
                                                    class="form-control @error('banks.' . $loop->index . '.holder_name_3') is-invalid @enderror">
                                                @error('banks.' . $loop->index . '.holder_name_3')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            {{-- MICR Code --}}
                                            <div class="col-md-6">
                                                <label class="form-label">MICR Code</label>
                                                <input type="text" name="banks[{{ $loop->index }}][micrcode]"
                                                    value="{{ old('banks.' . $loop->index . '.micrcode', $bank->micrcode) }}"
                                                    class="form-control micrcode bg-secondary-subtle bg-gradient @error('banks.' . $loop->index . '.micrcode') is-invalid @enderror"
                                                    readonly>
                                                @error('banks.' . $loop->index . '.micrcode')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>




                                            {{-- Bank Name --}}
                                            <div class="col-md-6">
                                                <label class="form-label">Bank Name</label>
                                                <input type="text" name="banks[{{ $loop->index }}][bank_name]"
                                                    value="{{ old('banks.' . $loop->index . '.bank_name', $bank->bank_name) }}"
                                                    class="form-control bank_name bg-secondary-subtle bg-gradient @error('banks.' . $loop->index . '.bank_name') is-invalid @enderror"
                                                    readonly>
                                                @error('banks.' . $loop->index . '.bank_name')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            {{-- Branch Name --}}
                                            <div class="col-md-6">
                                                <label class="form-label">Branch Name</label>
                                                <input type="text" name="banks[{{ $loop->index }}][branch_name]"
                                                    value="{{ old('banks.' . $loop->index . '.branch_name', $bank->branch_name) }}"
                                                    class="form-control branch_name bg-secondary-subtle bg-gradient @error('banks.' . $loop->index . '.branch_name') is-invalid @enderror"
                                                    readonly>
                                                @error('banks.' . $loop->index . '.branch_name')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            {{-- Bank Code --}}
                                            <div class="col-md-6">
                                                <label class="form-label">Bank Code</label>
                                                <input type="text" name="banks[{{ $loop->index }}][bank_code]"
                                                    value="{{ old('banks.' . $loop->index . '.bank_code', $bank->bank_code) }}"
                                                    class="form-control bank_code bg-secondary-subtle bg-gradient @error('banks.' . $loop->index . '.bank_code') is-invalid @enderror"
                                                    readonly>
                                                @error('banks.' . $loop->index . '.bank_code')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            {{-- Cheque Photo --}}
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Cheque Photo</label>
                                                <div class="input-group">
                                                    <input type="file"
                                                        class="form-control @error('banks.0.attachment_cancelled_cheque_url') is-invalid @enderror"
                                                        id="attachment_cancelled_cheque_url"
                                                        name="banks[0][attachment_cancelled_cheque_url]"
                                                        onchange="uploadTempFile(this, 'attachment_cancelled_cheque_url')"
                                                        accept=".jpg,.jpeg,.png,.pdf">

                                                    <button class="btn btn-outline-danger" type="button"
                                                        onclick="document.getElementById('attachment_cancelled_cheque_url').value = ''">
                                                        ✕
                                                    </button>
                                                </div>

                                                @error('banks.0.attachment_cancelled_cheque_url')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror

                                                <!-- Hidden URL -->
                                                <input type="hidden" id="attachment_cancelled_cheque_url_url"
                                                    name="banks[0][attachment_cancelled_cheque_url_url]"
                                                    value="{{ old('banks.0.attachment_cancelled_cheque_url_url', $bank->attachment_cancelled_cheque_url_url ?? '') }}">

                                                <!-- EDIT : Show saved cheque photo -->
                                                @if (!empty($bank->attachment_cancelled_cheque_url_url))
                                                    <div id="attachment_cancelled_cheque_url_previews"
                                                        class="position-relative d-inline-block mt-2">
                                                        <img src="{{ $bank->attachment_cancelled_cheque_url_url }}"
                                                            width="100" class="rounded">

                                                        <button type="button"
                                                            class="btn btn-sm btn-danger position-absolute top-0 start-100 translate-middle"
                                                            onclick="removeImage('attachment_cancelled_cheque_url')">
                                                            ✕
                                                        </button>
                                                    </div>

                                                    <!-- ADD / OLD VALUE -->
                                                @elseif (old('banks.0.attachment_cancelled_cheque_url_url'))
                                                    <div id="attachment_cancelled_cheque_url_preview"
                                                        class="position-relative d-inline-block mt-2">
                                                        <img src="{{ old('banks.0.attachment_cancelled_cheque_url_url') }}"
                                                            width="100" class="rounded">

                                                        <button type="button"
                                                            class="btn btn-sm btn-danger position-absolute top-0 start-100 translate-middle"
                                                            onclick="removeImage('attachment_cancelled_cheque_url')">
                                                            ✕
                                                        </button>
                                                    </div>
                                                @endif
                                            </div>

                                            {{-- Primary Checkbox --}}
                                            <div class="col-md-6">
                                                <label class="form-label d-block">Primary a/c</label>
                                                <input type="hidden" name="banks[{{ $loop->index }}][is_primary]"
                                                    value="0">
                                                <input type="checkbox" name="banks[{{ $loop->index }}][is_primary]"
                                                    value="1"
                                                    class="form-check-input setPrimary @error('banks.' . $loop->index . '.is_primary') is-invalid @enderror"
                                                    {{ old('banks.' . $loop->index . '.is_primary', $bank->is_primary) ? 'checked' : '' }}>
                                                @error('banks.' . $loop->index . '.is_primary')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <!-- Remove Row -->
                                            <div class="col-md-6 d-flex align-items-end">
                                                <button type="button" class="btn btn-danger btn-sm removeBankRow d-none">
                                                    <i class="bx bx-minus"></i> Remove
                                                </button>
                                            </div>


                                        </div>
                                    @endforeach
                                @else
                                    {{-- One empty row when no banks exist --}}
                                    <div class="bank-details-row row g-3 mb-3 bg-light position-relative">

                                        <div class="col-md-6">
                                            <label class="form-label">IFSC Code</label>
                                            <input type="text" name="banks[0][ifsc_code]"
                                                value="{{ old('banks.0.ifsc_code') }}"
                                                class="form-control ifsc_code @error('banks.0.ifsc_code') is-invalid @enderror">
                                            @error('banks.0.ifsc_code')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Account No</label>
                                            <input type="text" name="banks[0][account_number]"
                                                value="{{ old('banks.0.account_number') }}"
                                                class="form-control account_number @error('banks.0.account_number') is-invalid @enderror"
                                                maxlength="15">
                                            @error('banks.0.account_number')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Operation Mode</label>
                                            <select name="banks[0][operation_mode]"
                                                class="form-select operation_mode @error('banks.0.operation_mode') is-invalid @enderror">
                                                <option value="">Select Mode</option>
                                                <option value="single">Single</option>
                                                <option value="joint">Joint</option>
                                                <option value="anyone">Anyone</option>
                                            </select>
                                            @error('banks.0.operation_mode')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 holder_names d-none">
                                            <label class="form-label">Holder Name 1</label>
                                            <input type="text" name="banks[0][holder_name_1]"
                                                value="{{ old('banks.0.holder_name_1') }}"
                                                class="form-control @error('banks.0.holder_name_1') is-invalid @enderror">
                                            @error('banks.0.holder_name_1')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 holder_names d-none">
                                            <label class="form-label">Holder Name 2</label>
                                            <input type="text" name="banks[0][holder_name_2]"
                                                value="{{ old('banks.0.holder_name_2') }}"
                                                class="form-control @error('banks.0.holder_name_2') is-invalid @enderror">
                                            @error('banks.0.holder_name_2')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 holder_names d-none">
                                            <label class="form-label">Holder Name 3</label>
                                            <input type="text" name="banks[0][holder_name_3]"
                                                value="{{ old('banks.0.holder_name_3') }}"
                                                class="form-control @error('banks.0.holder_name_3') is-invalid @enderror">
                                            @error('banks.0.holder_name_3')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">MICR Code</label>
                                            <input type="text" name="banks[0][micrcode]"
                                                value="{{ old('banks.0.micrcode') }}"
                                                class="form-control micrcode bg-secondary-subtle bg-gradient @error('banks.0.micrcode') is-invalid @enderror">
                                            @error('banks.0.micrcode')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>




                                        <div class="col-md-6">
                                            <label class="form-label">Bank Name</label>
                                            <input type="text" name="banks[0][bank_name]"
                                                value="{{ old('banks.0.bank_name') }}"
                                                class="form-control bank_name bg-secondary-subtle bg-gradient @error('banks.0.bank_name') is-invalid @enderror"
                                                readonly>
                                            @error('banks.0.bank_name')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Branch Name</label>
                                            <input type="text" name="banks[0][branch_name]"
                                                value="{{ old('banks.0.branch_name') }}"
                                                class="form-control branch_name bg-secondary-subtle bg-gradient @error('banks.0.branch_name') is-invalid @enderror"
                                                readonly>
                                            @error('banks.0.branch_name')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Bank Code</label>
                                            <input type="text" name="banks[0][bank_code]"
                                                value="{{ old('banks.0.bank_code') }}"
                                                class="form-control bank_code bg-secondary-subtle bg-gradient @error('banks.0.bank_code') is-invalid @enderror"
                                                readonly>
                                            @error('banks.0.bank_code')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>


                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Cheque Photo</label>

                                            <div class="input-group">
                                                <input type="file"
                                                    class="form-control @error('banks.0.attachment_cancelled_cheque') is-invalid @enderror"
                                                    id="attachment_cancelled_cheque"
                                                    name="banks[0][attachment_cancelled_cheque]"
                                                    onchange="uploadTempFile(this, 'attachment_cancelled_cheque')"
                                                    accept=".jpg,.jpeg,.png,.pdf">

                                                <button class="btn btn-outline-danger" type="button"
                                                    onclick="document.getElementById('attachment_cancelled_cheque').value = ''">
                                                    ✕
                                                </button>
                                            </div>

                                            @error('banks.0.attachment_cancelled_cheque')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror

                                            <!-- Hidden URL -->
                                            <input type="hidden" id="attachment_cancelled_cheque_url"
                                                value="{{ old('banks.0.attachment_cancelled_cheque_url') }}"
                                                name="banks[0][attachment_cancelled_cheque_url]">

                                            <!-- Preview -->
                                            @if (old('banks.0.attachment_cancelled_cheque_url'))
                                                <div id="attachment_cancelled_cheque_preview"
                                                    class="position-relative d-inline-block mt-2">
                                                    <img src="{{ old('banks.0.attachment_cancelled_cheque_url') }}"
                                                        width="100" class="rounded">

                                                    <button type="button"
                                                        class="btn btn-sm btn-danger position-absolute top-0 start-100 translate-middle"
                                                        onclick="removeImage('attachment_cancelled_cheque')">
                                                        ✕
                                                    </button>
                                                </div>
                                            @endif
                                        </div>


                                        <div class="col-md-6">
                                            <label class="form-label d-block">Primary a/c</label>
                                            <input type="hidden" name="banks[0][is_primary]" value="0">
                                            <input type="checkbox" name="banks[0][is_primary]" value="1"
                                                class="form-check-input setPrimary @error('banks.0.is_primary') is-invalid @enderror"
                                                {{ old('banks.0.is_primary') ? 'checked' : '' }}>
                                            @error('banks.0.is_primary')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <!-- Remove Row -->
                                        <div class="col-md-6 d-flex align-items-end">
                                            <button type="button" class="btn btn-danger btn-sm removeBankRow d-none">
                                                <i class="bx bx-minus"></i> Remove
                                            </button>
                                        </div>

                                    </div>
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
            <div id="divImageSection">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Image Section</h5>
                        <small class="text-muted float-end">Image Information</small>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Profile Photo -->
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Client Photo</label>
                                <div class="input-group">
                                    <input type="file"
                                        class="form-control @error('attachment_client_photo') is-invalid @enderror"
                                        id="attachment_client_photo" name="attachment_client_photo"
                                        onchange="uploadTempFile(this, 'attachment_client_photo')"
                                        accept=".jpg,.jpeg,.png">
                                    <button class="btn btn-outline-danger" type="button"
                                        onclick="document.getElementById('attachment_client_photo').value = ''">✕</button>
                                </div>

                                @error('attachment_client_photo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <input type="hidden" id="attachment_client_photo_url"
                                    value="{{ old('attachment_client_photo_url', $client->attachment_client_photo_url) }}"
                                    name="attachment_client_photo_url">


                                @if ($client->attachment_client_photo_url)
                                    <div id="attachment_client_photo_previews" class="position-relative d-inline-block">
                                        <img src="{{ $client->attachment_client_photo_url }}" class="rounded">

                                        <!-- Remove (X) button -->
                                        <button type="button"
                                            class="btn btn-sm btn-danger position-absolute top-0 start-100 translate-middle"
                                            onclick="removeImage('attachment_client_photo')">
                                            ✕
                                        </button>
                                    </div>
                                @elseif (old('attachment_client_photo_url'))
                                    <div id="attachment_client_photo_preview" class="position-relative d-inline-block">
                                        <img src="{{ old('attachment_client_photo_url') }}" class="rounded">

                                        <!-- Remove (X) button -->
                                        <button type="button"
                                            class="btn btn-sm btn-danger position-absolute top-0 start-100 translate-middle"
                                            onclick="removeImage('attachment_client_photo')">
                                            ✕
                                        </button>
                                    </div>
                                @endif

                            </div>


                            <!-- pan Card -->
                            <div class="col-md-4 mb-3">
                                <label class="form-label">pan Card</label>
                                <div class="input-group">
                                    <input type="file" onchange="uploadTempFile(this, 'attachment_pan')"
                                        class="form-control @error('attachment_pan') is-invalid @enderror"
                                        id="attachment_pan" name="attachment_pan" accept=".pdf,.jpg,.jpeg,.png">
                                    <button class="btn btn-outline-danger" type="button"
                                        onclick="document.getElementById('attachment_pan').value = ''">✕</button>
                                </div>
                                @error('attachment_pan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <input type="hidden" id="attachment_pan_url"
                                    value="{{ old('attachment_pan_url', $client->attachment_pan_url) }}"
                                    name="attachment_pan_url">

                                @if ($client->attachment_pan_url)
                                    <div id="attachment_pan_previews" class="position-relative d-inline-block">
                                        <img src="{{ $client->attachment_pan_url }}" class="rounded">

                                        <!-- Remove (X) button -->
                                        <button type="button"
                                            class="btn btn-sm btn-danger position-absolute top-0 start-100 translate-middle"
                                            onclick="removeImage('attachment_pan')">
                                            ✕
                                        </button>
                                    </div>
                                @elseif (old('attachment_pan_url'))
                                    <div id="attachment_pan_preview" class="position-relative d-inline-block">
                                        <img src="{{ $client->attachment_pan_url }}" class="rounded">

                                        <!-- Remove (X) button -->
                                        <button type="button"
                                            class="btn btn-sm btn-danger position-absolute top-0 start-100 translate-middle"
                                            onclick="removeImage('attachment_pan')">
                                            ✕
                                        </button>
                                    </div>
                                @endif
                            </div>


                            <!-- aadhar Card front-->
                            <div class="col-md-4 mb-3">
                                <label class="form-label">aadhar Card front</label>
                                <div class="input-group">
                                    <input type="file" onchange="uploadTempFile(this, 'attachment_aadhar_front')"
                                        class="form-control @error('attachment_aadhar_front') is-invalid @enderror"
                                        id="attachment_aadhar_front" name="attachment_aadhar_front"
                                        accept=".pdf,.jpg,.jpeg,.png">
                                    <button class="btn btn-outline-danger" type="button"
                                        onclick="document.getElementById('attachment_aadhar_front').value = ''">✕</button>
                                </div>
                                @error('attachment_aadhar_front')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <input type="hidden" id="attachment_aadhar_front_url"
                                    value="{{ old('attachment_aadhar_front_url', $client->attachment_aadhar_front_url) }}"
                                    name="attachment_aadhar_front_url">

                                @if ($client->attachment_aadhar_front_url)
                                    <div id="attachment_aadhar_front_previews" class="position-relative d-inline-block">
                                        <img src="{{ $client->attachment_aadhar_front_url }}" class="rounded">

                                        <!-- Remove (X) button -->
                                        <button type="button"
                                            class="btn btn-sm btn-danger position-absolute top-0 start-100 translate-middle"
                                            onclick="removeImage('attachment_aadhar_front')">
                                            ✕
                                        </button>
                                    </div>
                                @elseif (old('attachment_aadhar_front_url'))
                                    <div id="attachment_aadhar_front_preview" class="position-relative d-inline-block">
                                        <img src="{{ old('attachment_aadhar_front_url') }}" class="rounded">

                                        <!-- Remove (X) button -->
                                        <button type="button"
                                            class="btn btn-sm btn-danger position-absolute top-0 start-100 translate-middle"
                                            onclick="removeImage('attachment_aadhar_front')">
                                            ✕
                                        </button>
                                    </div>
                                @endif
                            </div>


                            <!-- aadhar Card back -->
                            <div class="col-md-4 mb-3">
                                <label class="form-label">aadhar Card Back</label>
                                <div class="input-group">
                                    <input type="file" onchange="uploadTempFile(this, 'attachment_aadhar_back')"
                                        class="form-control @error('attachment_aadhar_back') is-invalid @enderror"
                                        id="attachment_aadhar_back" name="attachment_aadhar_back"
                                        accept=".pdf,.jpg,.jpeg,.png">
                                    <button class="btn btn-outline-danger" type="button"
                                        onclick="document.getElementById('attachment_aadhar_back').value = ''">✕</button>
                                </div>
                                @error('attachment_aadhar_back')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <input type="hidden" id="attachment_aadhar_back_url"
                                    value="{{ old('attachment_aadhar_back_url', $client->attachment_aadhar_back_url) }}"
                                    name="attachment_aadhar_back_url">

                                @if ($client->attachment_aadhar_back_url)
                                    <div id="attachment_aadhar_back_previews" class="position-relative d-inline-block">
                                        <img src="{{ $client->attachment_aadhar_back_url }}" class="rounded">

                                        <!-- Remove (X) button -->
                                        <button type="button"
                                            class="btn btn-sm btn-danger position-absolute top-0 start-100 translate-middle"
                                            onclick="removeImage('attachment_aadhar_back')">
                                            ✕
                                        </button>
                                    </div>
                                @elseif (old('attachment_aadhar_back_url'))
                                    <div id="attachment_aadhar_back_preview" class="position-relative d-inline-block">
                                        <img src="{{ old('attachment_aadhar_back_url') }}" class="rounded">

                                        <!-- Remove (X) button -->
                                        <button type="button"
                                            class="btn btn-sm btn-danger position-absolute top-0 start-100 translate-middle"
                                            onclick="removeImage('attachment_aadhar_back')">
                                            ✕
                                        </button>
                                    </div>
                                @endif
                            </div>



                            <!-- Signature -->
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Signature</label>
                                <div class="input-group">
                                    <input type="file" onchange="uploadTempFile(this, 'attachment_signature')"
                                        class="form-control @error('attachment_signature') is-invalid @enderror"
                                        id="attachment_signature" name="attachment_signature"
                                        accept=".pdf,.jpg,.jpeg,.png">
                                    <button class="btn btn-outline-danger" type="button"
                                        onclick="document.getElementById('attachment_signature').value = ''">✕</button>
                                </div>
                                @error('attachment_signature')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <input type="hidden" id="attachment_signature_url"
                                    value="{{ old('attachment_signature_url', $client->attachment_signature_url) }}"
                                    name="attachment_signature_url">

                                @if ($client->attachment_signature_url)
                                    <div id="attachment_signature_previews" class="position-relative d-inline-block">
                                        <img src="{{ $client->attachment_signature_url }}" class="rounded">

                                        <!-- Remove (X) button -->
                                        <button type="button"
                                            class="btn btn-sm btn-danger position-absolute top-0 start-100 translate-middle"
                                            onclick="removeImage('attachment_signature')">
                                            ✕
                                        </button>
                                    </div>
                                @elseif (old('attachment_signature_url'))
                                    <div id="attachment_signature_preview" class="position-relative d-inline-block">
                                        <img src="{{ old('attachment_signature_url') }}" class="rounded">

                                        <!-- Remove (X) button -->
                                        <button type="button"
                                            class="btn btn-sm btn-danger position-absolute top-0 start-100 translate-middle"
                                            onclick="removeImage('attachment_signature')">
                                            ✕
                                        </button>
                                    </div>
                                @endif
                            </div>

                            <!-- Resume -->
                            <div class="col-md-4 mb-3">
                                <label class="form-label">ckyc</label>
                                <div class="input-group">
                                    <input type="file" onchange="uploadTempFile(this, 'attachment_ckyc')"
                                        class="form-control @error('attachment_ckyc') is-invalid @enderror"
                                        id="attachment_ckyc" name="attachment_ckyc"
                                        accept=".pdf,.png, ,jpeg, .jpg, .doc,.docx">
                                    <button class="btn btn-outline-danger" type="button"
                                        onclick="document.getElementById('attachment_ckyc').value = ''">✕</button>
                                </div>
                                @error('attachment_ckyc')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <input type="hidden" id="attachment_ckyc_url"
                                    value="{{ old('attachment_ckyc_url', $client->attachment_ckyc_url) }}"
                                    name="attachment_ckyc_url">

                                @if ($client->attachment_ckyc_url)
                                    <div id="attachment_ckyc_preview" class="position-relative d-inline-block">
                                        <img src="{{ $client->attachment_ckyc_url }}" class="rounded">

                                        <!-- Remove (X) button -->
                                        <button type="button"
                                            class="btn btn-sm btn-danger position-absolute top-0 start-100 translate-middle"
                                            onclick="removeImage('attachment_ckyc')">
                                            ✕
                                        </button>
                                    </div>
                                @elseif (old('attachment_ckyc_url'))
                                    <div id="attachment_ckyc_preview" class="position-relative d-inline-block">
                                        <img src="{{ old('attachment_ckyc_url') }}" class="rounded">

                                        <!-- Remove (X) button -->
                                        <button type="button"
                                            class="btn btn-sm btn-danger position-absolute top-0 start-100 translate-middle"
                                            onclick="removeImage('attachment_ckyc')">
                                            ✕
                                        </button>
                                    </div>
                                @endif
                            </div>

                            <!-- Other Supporting Documents -->
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Other Documents (Optional)</label>
                                <div class="input-group">
                                    <input type="file" onchange="uploadTempFile(this, 'attachment_other_documents')"
                                        class="form-control @error('attachment_other_documents') is-invalid @enderror"
                                        id="attachment_other_documents" name="attachment_other_documents[]"
                                        accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" multiple>
                                    <button class="btn btn-outline-danger" type="button"
                                        onclick="document.getElementById('attachment_other_documents').value = ''">✕</button>
                                </div>
                                @error('attachment_other_documents')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <input type="hidden" id="attachment_other_documents_url"
                                    value="{{ old('attachment_other_documents_url', $client->attachment_other_documents_url) }}"
                                    name="attachment_other_documents_url">

                                @if ($client->attachment_other_documents_url)
                                    <div id="attachment_other_documents_previews"
                                        class="position-relative d-inline-block">
                                        <img src="{{ $client->attachment_other_documents_url }}" class="rounded">

                                        <!-- Remove (X) button -->
                                        <button type="button"
                                            class="btn btn-sm btn-danger position-absolute top-0 start-100 translate-middle"
                                            onclick="removeImage('attachment_other_documents')">
                                            ✕
                                        </button>
                                    </div>
                                @elseif (old('attachment_other_documents_url'))
                                    <div id="attachment_other_documents_preview" class="position-relative d-inline-block">
                                        <img src="{{ old('attachment_other_documents_url') }}" class="rounded">

                                        <!-- Remove (X) button -->
                                        <button type="button"
                                            class="btn btn-sm btn-danger position-absolute top-0 start-100 translate-middle"
                                            onclick="removeImage('attachment_other_documents')">
                                            ✕
                                        </button>
                                    </div>
                                @endif
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
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.chkbox_fwapp_same_as_mobile').on('change', function() {
                if ($(this).is(':checked')) {
                    $('#whatsapp_no').val($('#mobile_no').val());
                } else {
                    $('#whatsapp_no').val('');
                }
            });

        });
    </script>

    <script>
        $(document).ready(function() {

            // Trigger state change so cities load automatically
            if ($("#office_state_code").val()) {
                $("#office_state_code").trigger("change");
            }
            if ($("#res_state_code").val()) {
                $("#res_state_code").trigger("change");
            }

            // After AJAX loads city options → set selected city
            $(document).ajaxSuccess(function() {
                let savedCityRes = "{{ $client->res_city_code }}";
                let savedCity = "{{ $client->office_city_code }}";

                // Residence city
                if (savedCityRes) {
                    $("#res_city_code").val(savedCityRes).trigger("change.select2");
                }

                // Office city
                if (savedCity) {
                    $("#office_city_code").val(savedCity).trigger("change.select2");
                }
            });

        });
    </script>
@endpush
