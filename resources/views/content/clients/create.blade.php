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



    <form action="{{ route('clients.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('post')
        <input type="hidden" name="res_country" id="res_country">
        <input type="hidden" name="res_state" id="res_state">
        <input type="hidden" name="res_city" id="res_city">

        <input type="hidden" name="office_country" id="office_country">
        <input type="hidden" name="office_state" id="office_state">
        <input type="hidden" name="office_city" id="office_city">

        <div class="d-flex justify-content-end">
            <a href="{{ route('clients.index') }}" class="btn btn-secondary px-4">Go Back</a>
        </div>
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
                                <input type="text" class="form-control onlyalpha @error('name') is-invalid @enderror"
                                    id="name" name="name" maxlength="50" value="{{ old('name') }}" maxlength="50">
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
                                <input type="text" class="form-control datepicker @error('dob') is-invalid @enderror"
                                    id="dob" name="dob" value="{{ old('dob') }}"
                                    max="{{ now()->toDateString() }}" readonly placeholder="Select Date">

                                @error('dob')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            {{-- Live Status --}}
                            <div class="col-md-2 mb-3">
                                <label class="form-label" for="live_status">Live Status</label>
                                <select class="form-select @error('live_status') is-invalid @enderror" id="live_status"
                                    name="live_status">
                                    <option value="alive" {{ old('live_status', 'alive') == '1' ? 'selected' : '' }}>Alive
                                    </option>
                                    <option value="deceased" {{ old('live_status') == 'deceased' ? 'selected' : '' }}>
                                        Deceased
                                    </option>
                                </select>
                                @error('live_status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>



                            {{-- Date of Death --}}
                            <div class="col-md-2 mb-3 d-none">
                                <label for="dod" class="form-label">Date of Death</label>
                                <input type="text" name="dod" id="dod" class="form-control datepicker"
                                    value="{{ old('dod') }}" readonly placeholder="Select Date">
                                @error('dod')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>


                            {{-- Marital Status --}}
                            <div class="col-md-2 mb-3">
                                <label class="form-label" for="marital_status">Marital Status</label>
                                <select class="form-select @error('marital_status') is-invalid @enderror"
                                    id="marital_status" name="marital_status">
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
                                    <option value="ri" {{ old('nationality') == 'ri' ? 'selected' : '' }}>Residential
                                        Individual</option>
                                    <option value="nro" {{ old('nationality') == 'nro' ? 'selected' : '' }}>NRO
                                    </option>
                                    <option value="nre" {{ old('nationality') == 'nre' ? 'selected' : '' }}>NRE
                                    </option>
                                    <option value="pio" {{ old('nationality') == 'pio' ? 'selected' : '' }}>OCI/PIO
                                    </option>
                                    <option value="gch" {{ old('nationality') == 'gch' ? 'selected' : '' }}>Green Card
                                        Holder</option>
                                    <option value="trioc" {{ old('nationality') == 'trioc' ? 'selected' : '' }}>Tax
                                        Resident in Other Country</option>
                                    <option value="fn" {{ old('nationality') == 'fn' ? 'selected' : '' }}>Foreign
                                        National</option>
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
                                    <option value="private_sector"
                                        {{ old('occupation') == 'private_sector' ? 'selected' : '' }}>Private Sector
                                    </option>
                                    <option value="public_sector"
                                        {{ old('occupation') == 'public_sector' ? 'selected' : '' }}>Public Sector
                                    </option>
                                    <option value="government" {{ old('occupation') == 'government' ? 'selected' : '' }}>
                                        Government
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
                                <input type="text"
                                    class="form-control onlydigit @error('aadhar_no') is-invalid @enderror" id="aadhar_no"
                                    name="aadhar_no" maxlength="12" value="{{ old('aadhar_no') }}">
                                @error('aadhar_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            {{-- CKYC No --}}
                            <div class="col-md-2 mb-3">
                                <label class="form-label" for="ckyc_no">CKYC No.</label>
                                <input type="text"
                                    class="form-control onlydigit @error('ckyc_no') is-invalid @enderror" id="ckyc_no"
                                    name="ckyc_no" maxlength="14" value="{{ old('ckyc_no') }}">
                                @error('ckyc_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>



                            {{-- Mobile Number --}}
                            <div class="col-md-2 mb-3">
                                <label class="form-label" for="mobile_no">Mobile Number</label>
                                <input type="text"
                                    class="form-control onlyphone @error('mobile_no') is-invalid @enderror"
                                    id="phone" name="mobile_no" maxlength="10" value="{{ old('mobile_no') }}">
                                @error('mobile_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            {{-- WhatsApp Number --}}
                            <div class="col-md-2 mb-3">
                                <label class="form-label" for="whatsapp_no">WhatsApp Number</label>
                                <input type="text"
                                    class="form-control onlyphone @error('whatsapp_no') is-invalid @enderror"
                                    id="whatsapp_no" name="whatsapp_no" maxlength="10"
                                    value="{{ old('whatsapp_no') }}">
                                <label class="uk-margin-right"><input class="uk-checkbox chkbox_fwapp_same_as_mobile"
                                        type="checkbox" id="" value="ON">
                                    Same as mobile no.</label>
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
                                <input type="email" class="form-control  @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>



                            {{-- Relation Manager --}}
                            <div class="col-md-3 mb-3 d-none">
                                <label for="relation_manager" class="form-label">Relation /account Manager</label>
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




                            {{-- {{ dd($country) }} --}}

                            <!-- Residential Address -->
                            <h6 class="my-3">Residential Address</h6>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Address</label>
                                <input type="text" name="res_address" id="res_address"
                                    class="form-control @error('res_address') is-invalid @enderror"
                                    value="{{ old('res_address') }}">
                                @error('res_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Country --}}
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Country</label>
                                <select name="res_country_code" id="res_country_code"
                                    class="form-select select2  @error('res_country_code') is-invalid @enderror">
                                    <option value="{{ $country['iso2'] }}"
                                        {{ old('res_country_code', 'IND') == $country['iso2'] ? 'selected' : '' }}
                                        data-country-name="{{ $country['name'] }}">
                                        {{ $country['name'] }}
                                    </option>

                                </select>
                                @error('res_country_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- State --}}
                            <div class="col-md-2 mb-3">
                                <label class="form-label">State</label>
                                <select name="res_state_code" id="res_state_code"
                                    class="form-select select2 @error('res_state_code') is-invalid @enderror">
                                    @foreach ($states as $state)
                                        <option value="{{ $state['iso2'] }}"
                                            {{ old('res_state_code', 'MH') == $state['iso2'] ? 'selected' : '' }}
                                            data-state-name="{{ $state['name'] }}">
                                            {{ $state['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('res_state_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- City --}}
                            <div class="col-md-2 mb-3">
                                <label class="form-label">City</label>
                                <select name="res_city_code" id="res_city_code"
                                    class="form-select select2  @error('res_city_code') is-invalid @enderror">
                                    <option value="">Select City</option>
                                    @foreach ($cities as $c)
                                        <option value="{{ $c['id'] }}"
                                            {{ old('res_city_code') == $c['id'] ? 'selected' : '' }}
                                            data-city-name="{{ $c['name'] }}">
                                            {{ $c['name'] }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('res_city_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Pincode --}}
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Pincode</label>
                                <input type="text" name="res_pincode" id="res_pincode"
                                    class="form-control onlydigit @error('res_pincode') is-invalid @enderror"
                                    value="{{ old('res_pincode') }}" maxlength="6">
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
                                    value="{{ old('office_address') }}">
                                @error('office_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2 mb-3">
                                <label class="form-label">Country</label>
                                <select name="office_country_code" id="office_country_code"
                                    class="form-select select2 @error('office_country_code') is-invalid @enderror">
                                    <option value="{{ $country['iso2'] }}"
                                        {{ old('office_country_code', 'IND') == $country['iso2'] ? 'selected' : '' }}
                                        data-country-name="{{ $country['name'] }}">
                                        {{ $country['name'] }}
                                    </option>

                                </select>
                                @error('office_country_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2 mb-3">
                                <label class="form-label">State</label>
                                <select name="office_state_code" id="office_state_code"
                                    class="form-select select2 @error('office_state_code') is-invalid @enderror">
                                    @foreach ($states as $state)
                                        <option value="{{ $state['iso2'] }}"
                                            {{ old('office_state_code', 'MH') == $state['iso2'] ? 'selected' : '' }}
                                            data-state-name="{{ $state['name'] }}">
                                            {{ $state['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('office_state_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2 mb-3">
                                <label class="form-label">City</label>
                                <select name="office_city_code" id="office_city_code"
                                    class="form-select select2 @error('office_city_code') is-invalid @enderror">
                                    <option value="">Select City</option>
                                    @foreach ($cities as $c)
                                        <option value="{{ $c['id'] }}"
                                            {{ old('office_city_code') == $c['id'] ? 'selected' : '' }}
                                            data-city-name="{{ $c['name'] }}">
                                            {{ $c['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('office_city_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2 mb-3">
                                <label class="form-label">Pincode</label>
                                <input type="text" name="office_pincode" id="office_pincode"
                                    class="form-control onlydigit @error('office_pincode') is-invalid @enderror"
                                    value="{{ old('office_pincode') }}" maxlength="6">
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

                                <div class="bank-details-row row g-3 mb-3 bg-light position-relative">

                                    <!-- IFSC -->
                                    <div class="col-md-6">
                                        <label class="form-label">IFSC Code</label>
                                        <input type="text" name="banks[0][ifsc_code]"
                                            class="form-control ifsc_code @error('banks.0.ifsc_code') is-invalid @enderror"
                                            placeholder="Enter IFSC Code">
                                        @error('banks.0.ifsc_code')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Account No -->
                                    <div class="col-md-6">
                                        <label class="form-label">Account No</label>
                                        <input type="text" name="banks[0][account_number]"
                                            class="form-control account_number @error('banks.0.account_number') is-invalid @enderror"
                                            placeholder="Enter Account Number">
                                        @error('banks.0.account_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Operation Mode -->
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
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Holder 1 -->
                                    <div class="col-md-6 holder_names d-none">
                                        <label class="form-label">Holder Name 1</label>
                                        <input type="text" name="banks[0][holder_name_1]"
                                            class="form-control @error('banks.0.holder_name_1') is-invalid @enderror">
                                        @error('banks.0.holder_name_1')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Holder 2 -->
                                    <div class="col-md-6 holder_names d-none">
                                        <label class="form-label">Holder Name 2</label>
                                        <input type="text" name="banks[0][holder_name_2]"
                                            class="form-control @error('banks.0.holder_name_2') is-invalid @enderror">
                                        @error('banks.0.holder_name_2')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Holder 3 -->
                                    <div class="col-md-6 holder_names d-none">
                                        <label class="form-label">Holder Name 3</label>
                                        <input type="text" name="banks[0][holder_name_3]"
                                            class="form-control @error('banks.0.holder_name_3') is-invalid @enderror">
                                        @error('banks.0.holder_name_3')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- MICR -->
                                    <div class="col-md-6">
                                        <label class="form-label">MICR Code</label>
                                        <input type="text" name="banks[0][micrcode]"
                                            class="form-control micrcode bg-secondary-subtle bg-gradient @error('banks.0.micrcode') is-invalid @enderror"
                                         readonly>
                                        @error('banks.0.micrcode')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Bank Name -->
                                    <div class="col-md-6">
                                        <label class="form-label">Bank Name</label>
                                        <input type="text" name="banks[0][bank_name]"
                                            class="form-control bank_name bg-secondary-subtle bg-gradient @error('banks.0.bank_name') is-invalid @enderror"
                                            readonly>
                                        @error('banks.0.bank_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Branch Name -->
                                    <div class="col-md-6">
                                        <label class="form-label">Branch Name</label>
                                        <input type="text" name="banks[0][branch_name]"
                                            class="form-control branch_name bg-secondary-subtle bg-gradient @error('banks.0.branch_name') is-invalid @enderror"
                                            readonly>
                                        @error('banks.0.branch_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Bank Code -->
                                    <div class="col-md-6">
                                        <label class="form-label">Bank Code</label>
                                        <input type="text" name="banks[0][bank_code]"
                                            class="form-control bank_code bg-secondary-subtle bg-gradient @error('banks.0.bank_code') is-invalid @enderror"
                                            readonly>
                                        @error('banks.0.bank_code')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>



                                    <!-- Cheque Photo -->
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


                                    <!-- Primary -->
                                    <div class="col-md-6">
                                        <label class="form-label d-block">Primary a/c</label>
                                        <input type="hidden" name="banks[0][is_primary]" value="0">
                                        <input type="checkbox" name="banks[0][is_primary]" value="1"
                                            class="form-check-input setPrimary @error('banks.0.is_primary') is-invalid @enderror">
                                        @error('banks.0.is_primary')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Remove Row -->
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
            <div id="divImageSection" class="col-md-6 d-flex">
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
                                        onchange="uploadTempFile(this, 'attachment_client_photo')"
                                        accept=".jpg,.jpeg,.png,.pdf">
                                    <button class="btn btn-outline-danger" type="button"
                                        onclick="document.getElementById('attachment_client_photo').value = ''">✕</button>
                                </div>

                                @error('attachment_client_photo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <input type="hidden" id="attachment_client_photo_url"
                                    value="{{ old('attachment_client_photo_url') }}" name="attachment_client_photo_url">

                                @if (old('attachment_client_photo_url'))
                                    <div id="attachment_client_photo_preview" class="position-relative d-inline-block">
                                        <img src="{{ old('attachment_client_photo_url') }}" width="100"
                                            class="rounded">

                                        <!-- Remove (X) button -->
                                        <button type="button"
                                            class="btn btn-sm btn-danger position-absolute top-0 start-100 translate-middle"
                                            onclick="removeImage('attachment_client_photo')">
                                            ✕
                                        </button>
                                    </div>
                                @endif

                            </div>


                            <!-- Aadhar Card -->
                            <div class="col-md-6 mb-3">
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

                                <input type="hidden" id="attachment_pan_url" value="{{ old('attachment_pan_url') }}"
                                    name="attachment_pan_url">

                                @if (old('attachment_pan_url'))
                                    <div id="attachment_pan_preview" class="position-relative d-inline-block">
                                        <img src="{{ old('attachment_pan_url') }}" width="100" class="rounded">

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
                            <div class="col-md-6 mb-3">
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
                                    value="{{ old('attachment_aadhar_front_url') }}" name="attachment_aadhar_front_url">

                                @if (old('attachment_aadhar_front_url'))
                                    <div id="attachment_aadhar_front_preview" class="position-relative d-inline-block">
                                        <img src="{{ old('attachment_aadhar_front_url') }}" width="100"
                                            class="rounded">

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
                            <div class="col-md-6 mb-3">
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
                                    value="{{ old('attachment_aadhar_back_url') }}" name="attachment_aadhar_back_url">

                                @if (old('attachment_aadhar_back_url'))
                                    <div id="attachment_aadhar_back_preview" class="position-relative d-inline-block">
                                        <img src="{{ old('attachment_aadhar_back_url') }}" width="100"
                                            class="rounded">

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
                            <div class="col-md-6 mb-3">
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
                                    value="{{ old('attachment_signature_url') }}" name="attachment_signature_url">

                                @if (old('attachment_signature_url'))
                                    <div id="attachment_signature_preview" class="position-relative d-inline-block">
                                        <img src="{{ old('attachment_signature_url') }}" width="100"
                                            class="rounded">

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
                            <div class="col-md-6 mb-3">
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

                                <input type="hidden" id="attachment_ckyc_url" value="{{ old('attachment_ckyc_url') }}"
                                    name="attachment_ckyc_url">

                                @if (old('attachment_ckyc_url'))
                                    <div id="attachment_ckyc_preview" class="position-relative d-inline-block">
                                        <img src="{{ old('attachment_ckyc_url') }}" width="100" class="rounded">

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
                            <div class="col-md-6 mb-3">
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
                                    value="{{ old('attachment_other_documents_url') }}"
                                    name="attachment_other_documents_url">

                                @if (old('attachment_other_documents_url'))
                                    <div id="attachment_other_documents_preview" class="position-relative d-inline-block">
                                        <img src="{{ old('attachment_other_documents_url') }}" width="100"
                                            class="rounded">

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
            <button type="submit" class="btn btn-primary px-4">Save</button>

        </div>
    </form>


@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.chkbox_fwapp_same_as_mobile').on('change', function() {
                if ($(this).is(':checked')) {
                    $('#whatsapp_no').val($('#phone').val());
                } else {
                    $('#whatsapp_no').val('');
                }
            });

        });
    </script>
@endpush
