<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>
<style>
    /* Make all form inputs uppercase */
    input,
    textarea,
    select {
        text-transform: uppercase;
    }

    /* Exclude email input */
    input[type="email"] {
        text-transform: none;
    }

    h6,
    label {
        text-transform: uppercase;
    }

    .h6two {
        border-left: 2px solid #b644dc;
        color: #b644dc;
        font-weight: bold;
    }

    .card {
        background-color: #fefaff;
    }
</style>

<body>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <main class="container">
        <form action="{{ route('preclients.store') }}" method="POST" enctype="multipart/form-data" class="mb-4">
            @csrf
            @method('post')
            <input type="hidden" name="res_country" id="res_country" value="India">
            <input type="hidden" name="res_state" id="res_state" value="Maharashtra">
            <input type="hidden" name="res_city" id="res_city" value="Thane">

            <input type="hidden" name="office_country" id="office_country" value="India">
            <input type="hidden" name="office_state" id="office_state" value="Maharashtra">
            <input type="hidden" name="office_city" id="office_city" value="Thane">

            <input type="hidden" name="family_res_country" id="family_res_country" value="India">
            <input type="hidden" name="family_res_state" id="family_res_state" value="Maharashtra">
            <input type="hidden" name="family_res_city" id="family_res_city" value="Thane">

            <div class="text-center justify-content-center my-3 text-uppercase">
                <h5>Please enter your basic personal details exactly as per your official records</h5>
                {{-- <a href="{{ route('clients.index') }}" class="btn btn-secondary px-4">Go Back</a> --}}
            </div>
            <div class="row align-items-stretch">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center"
                            style="background-color: #d3e0ff !important;">
                            <h6 class="mb-0 text-uppercase">Primary Information</h6>
                            <small class="text-muted float-end text-uppercase">client Basic Details</small>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                {{-- Full Name --}}
                                <div class="col-md-4 mb-3">
                                    <label class="form-label" for="name">Full Name</label>
                                    <input type="text"
                                        class="form-control onlyalpha @error('name') is-invalid @enderror"
                                        id="name" name="name" maxlength="50" value="{{ old('name') }}"
                                        maxlength="50">
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
                                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male
                                        </option>
                                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female
                                        </option>
                                        <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other
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
                                        id="dob" name="dob" value="{{ old('dob') }}"
                                        max="{{ now()->toDateString() }}" placeholder="Select Date">

                                    @error('dob')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>



                                {{-- Live Status --}}
                                <div class="col-md-2 mb-3">
                                    <label class="form-label" for="live_status">Live Status</label>
                                    <select class="form-select @error('live_status') is-invalid @enderror"
                                        id="live_status" name="live_status">
                                        <option value="alive"
                                            {{ old('live_status', 'alive') == '1' ? 'selected' : '' }}>Alive
                                        </option>
                                        <option value="deceased"
                                            {{ old('live_status') == 'deceased' ? 'selected' : '' }}>
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
                                    <input type="date" name="dod" id="dod" class="form-control "
                                        value="{{ old('dod') }}" placeholder="Select Date"
                                        max="{{ now()->toDateString() }}">
                                    @error('dod')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>


                                {{-- Marital Status --}}
                                <div class="col-md-2 mb-3">
                                    <label class="form-label" for="marital_status">Marital Status</label>
                                    <select class="form-select @error('marital_status') is-invalid @enderror"
                                        id="marital_status" name="marital_status">
                                        <option value="single"
                                            {{ old('marital_status') == 'single' ? 'selected' : '' }}>
                                            Single
                                        </option>
                                        <option value="married"
                                            {{ old('marital_status') == 'married' ? 'selected' : '' }}>
                                            Married</option>
                                        <option value="divorced"
                                            {{ old('marital_status') == 'divorced' ? 'selected' : '' }}>
                                            Divorcee</option>
                                        <option value="widowed"
                                            {{ old('marital_status') == 'widowed' ? 'selected' : '' }}>
                                            Widow
                                        </option>
                                        <option value="other"
                                            {{ old('marital_status') == 'other' ? 'selected' : '' }}>Other
                                        </option>
                                    </select>
                                    @error('marital_status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                                {{-- Nationality --}}
                                <div class="col-md-2 mb-3">
                                    <label class="form-label" for="nationality">Nationality</label>
                                    <select class="form-select  @error('nationality') is-invalid @enderror"
                                        id="nationality" name="nationality">
                                        <option value="ri" {{ old('nationality') == 'ri' ? 'selected' : '' }}>
                                            Residential
                                            Individual</option>
                                        <option value="nro" {{ old('nationality') == 'nro' ? 'selected' : '' }}>NRO
                                        </option>
                                        <option value="nre" {{ old('nationality') == 'nre' ? 'selected' : '' }}>NRE
                                        </option>
                                        <option value="pio" {{ old('nationality') == 'pio' ? 'selected' : '' }}>
                                            OCI/PIO
                                        </option>
                                        <option value="gch" {{ old('nationality') == 'gch' ? 'selected' : '' }}>
                                            Green Card
                                            Holder</option>
                                        <option value="trioc" {{ old('nationality') == 'trioc' ? 'selected' : '' }}>
                                            Tax
                                            Resident in Other Country</option>
                                        <option value="fn" {{ old('nationality') == 'fn' ? 'selected' : '' }}>
                                            Foreign
                                            National</option>
                                        <option value="other" {{ old('nationality') == 'other' ? 'selected' : '' }}>
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
                                    <select class="form-select @error('occupation') is-invalid @enderror"
                                        id="occupation" name="occupation">
                                        <option value="">Select</option>
                                        <option value="private_sector"
                                            {{ old('occupation') == 'private_sector' ? 'selected' : '' }}>Private
                                            Sector
                                        </option>
                                        <option value="public_sector"
                                            {{ old('occupation') == 'public_sector' ? 'selected' : '' }}>Public Sector
                                        </option>
                                        <option value="government"
                                            {{ old('occupation') == 'government' ? 'selected' : '' }}>
                                            Government
                                            Service</option>
                                        <option value="business"
                                            {{ old('occupation') == 'business' ? 'selected' : '' }}>
                                            Business</option>
                                        <option value="professional"
                                            {{ old('occupation') == 'professional' ? 'selected' : '' }}>Professional
                                        </option>
                                        <option value="agriculture"
                                            {{ old('occupation') == 'agriculture' ? 'selected' : '' }}>
                                            Agriculture</option>
                                        <option value="retired"
                                            {{ old('occupation') == 'retired' ? 'selected' : '' }}>Retired
                                        </option>
                                        <option value="housewife"
                                            {{ old('occupation') == 'housewife' ? 'selected' : '' }}>
                                            Housewife</option>
                                        <option value="student"
                                            {{ old('occupation') == 'student' ? 'selected' : '' }}>Student
                                        </option>
                                        <option value="doctor" {{ old('occupation') == 'doctor' ? 'selected' : '' }}>
                                            Doctor
                                        </option>
                                        <option value="education"
                                            {{ old('occupation') == 'education' ? 'selected' : '' }}>
                                            Education</option>
                                        <option value="other" {{ old('occupation') == 'other' ? 'selected' : '' }}>
                                            Other
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
                                        onblur="checkPanExists(this.value)">
                                    @error('pan_no')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <span id="errpancardno" class="text-danger small"></span>
                                </div>


                                {{-- Aadhaar No. --}}
                                <div class="col-md-2 mb-3">
                                    <label class="form-label" for="aadhar_no">Aadhaar No.</label>
                                    <input type="text"
                                        class="form-control onlydigit @error('aadhar_no') is-invalid @enderror"
                                        id="aadhar_no" name="aadhar_no" maxlength="12"
                                        value="{{ old('aadhar_no') }}">
                                    @error('aadhar_no')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                                {{-- CKYC No --}}
                                <div class="col-md-2 mb-3">
                                    <label class="form-label" for="ckyc_no">CKYC No.</label>
                                    <input type="text"
                                        class="form-control onlydigit @error('ckyc_no') is-invalid @enderror"
                                        id="ckyc_no" name="ckyc_no" maxlength="14" value="{{ old('ckyc_no') }}">
                                    @error('ckyc_no')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>



                                {{-- Mobile Number --}}
                                <div class="col-md-2 mb-3">
                                    <label class="form-label" for="mobile_no">Mobile Number</label>
                                    <input type="text"
                                        class="form-control onlyphone @error('mobile_no') is-invalid @enderror"
                                        id="phone" name="mobile_no" maxlength="10"
                                        value="{{ old('mobile_no') }}">
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
                                    <label class="uk-margin-right"><input
                                            class="uk-checkbox chkbox_fwapp_same_as_mobile" type="checkbox"
                                            id="" value="ON">
                                        Same as mobile no.</label>
                                    @error('whatsapp_no')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                                {{-- Landline No --}}
                                <div class="col-md-2 mb-3">
                                    <label class="form-label" for="landline_no">Landline No.</label>
                                    <input type="text"
                                        class="form-control @error('landline_no') is-invalid @enderror"
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
                                <h6 class="my-3 h6two">Residential Address</h6>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Address</label>
                                    <input type="text" name="res_address" id="res_address"
                                        class="form-control @error('res_address') is-invalid @enderror"
                                        value="{{ old('res_address') }}">
                                    @error('res_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- COUNTRY --}}
                                <div class="col-md-2 mb-3">
                                    <label class="form-label">Country</label>
                                    <select name="res_country_code" id="res_country_code"
                                        class="form-select select2 @error('res_country_code') is-invalid @enderror">

                                        @foreach ($country as $c)
                                            <option value="{{ $c['iso2'] }}"
                                                {{ old('res_country_code', 'IN') == $c['iso2'] ? 'selected' : '' }}
                                                data-country-name="{{ $c['name'] }}">
                                                {{ $c['name'] }}
                                            </option>
                                        @endforeach

                                    </select>
                                    @error('res_country_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- STATE --}}
                                <div class="col-md-2 mb-3">
                                    <label class="form-label">State </label>
                                    <select name="res_state_code" id="res_state_code"
                                        class="form-select select2 @error('res_state_code') is-invalid @enderror">
                                        @foreach ($states as $s)
                                            <option value="{{ $s['iso2'] }}"
                                                {{ old('res_state_code', 'MH') == $s['iso2'] ? 'selected' : '' }}
                                                data-state-name="{{ $s['name'] }}">
                                                {{ $s['name'] }} </option>
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
                                        @foreach ($cities as $c)
                                            <option value="{{ $c['id'] }}"
                                                {{ old('res_city_code', '134138') == $c['id'] ? 'selected' : '' }}
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
                                <h6 class="my-3 h6two">Office Address</h6>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Address</label>
                                    <input type="text" name="office_address" id="office_address"
                                        class="form-control @error('office_address') is-invalid @enderror"
                                        value="{{ old('office_address') }}">
                                    @error('office_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- COUNTRY --}}
                                <div class="col-md-2 mb-3">
                                    <label class="form-label">Country</label>
                                    <select name="office_country_code" id="office_country_code"
                                        class="form-select select2 @error('office_country_code') is-invalid @enderror">

                                        @foreach ($country as $c)
                                            <option value="{{ $c['iso2'] }}"
                                                {{ old('office_country_code', 'IN') == $c['iso2'] ? 'selected' : '' }}
                                                data-country-name="{{ $c['name'] }}">
                                                {{ $c['name'] }}
                                            </option>
                                        @endforeach

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
                                        @foreach ($states as $s)
                                            <option value="{{ $s['iso2'] }}"
                                                {{ old('office_state_code', 'MH') == $s['iso2'] ? 'selected' : '' }}
                                                data-state-name="{{ $s['name'] }}">
                                                {{ $s['name'] }}
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
                                        @foreach ($cities as $c)
                                            <option value="{{ $c['id'] }}"
                                                {{ old('office_city_code', '134138') == $c['id'] ? 'selected' : '' }}
                                                data-city-name="{{ $c['name'] }}">
                                                {{ $c['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('office_city_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Pincode --}}
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

                {{-- Image Section --}}
                <div id="divImageSection" class="col-md-12 ">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center"
                            style="background-color: #d3e0ff !important;">
                            <h6 class="mb-0 text-uppercase">Image Section</h6>
                            <small class="text-muted float-end text-uppercase">Image Information</small>
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
                                            accept=".jpg,.jpeg,.png,.pdf">
                                        <button class="btn btn-outline-danger" type="button"
                                            onclick="document.getElementById('attachment_client_photo').value = ''">✕</button>
                                    </div>

                                    @error('attachment_client_photo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                    <input type="hidden" id="attachment_client_photo_url"
                                        value="{{ old('attachment_client_photo_url') }}"
                                        name="attachment_client_photo_url">

                                    @if (old('attachment_client_photo_url'))
                                        <div id="attachment_client_photo_preview"
                                            class="position-relative d-inline-block">
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
                                        value="{{ old('attachment_pan_url') }}" name="attachment_pan_url">

                                    @if (old('attachment_pan_url'))
                                        <div id="attachment_pan_preview" class="position-relative d-inline-block">
                                            <img src="{{ old('attachment_pan_url') }}" width="100"
                                                class="rounded">

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
                                        <input type="file"
                                            onchange="uploadTempFile(this, 'attachment_aadhar_front')"
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
                                        value="{{ old('attachment_aadhar_front_url') }}"
                                        name="attachment_aadhar_front_url">

                                    @if (old('attachment_aadhar_front_url'))
                                        <div id="attachment_aadhar_front_preview"
                                            class="position-relative d-inline-block">
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
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">aadhar Card Back</label>
                                    <div class="input-group">
                                        <input type="file"
                                            onchange="uploadTempFile(this, 'attachment_aadhar_back')"
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
                                        value="{{ old('attachment_aadhar_back_url') }}"
                                        name="attachment_aadhar_back_url">

                                    @if (old('attachment_aadhar_back_url'))
                                        <div id="attachment_aadhar_back_preview"
                                            class="position-relative d-inline-block">
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
                                        value="{{ old('attachment_signature_url') }}"
                                        name="attachment_signature_url">

                                    @if (old('attachment_signature_url'))
                                        <div id="attachment_signature_preview"
                                            class="position-relative d-inline-block">
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
                                        value="{{ old('attachment_ckyc_url') }}" name="attachment_ckyc_url">

                                    @if (old('attachment_ckyc_url'))
                                        <div id="attachment_ckyc_preview" class="position-relative d-inline-block">
                                            <img src="{{ old('attachment_ckyc_url') }}" width="100"
                                                class="rounded">

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
                                        <input type="file"
                                            onchange="uploadTempFile(this, 'attachment_other_documents')"
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
                                        <div id="attachment_other_documents_preview"
                                            class="position-relative d-inline-block">
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

            <div id="FamilySection" class="" class="row align-items-stretch">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center"
                            style="background-color: #d3e0ff !important;">
                            <h6 class="mb-0 text-uppercase">Family Information</h6>
                            <small class="text-muted float-end text-uppercase">Family Basic Details</small>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                {{-- Full Name --}}
                                <div class="col-md-4 mb-3">
                                    <label class="form-label" for="name">Full Name</label>
                                    <input type="text"
                                        class="form-control onlyalpha @error('family_name') is-invalid @enderror"
                                        id="family_name" name="family_name" maxlength="50"
                                        value="{{ old('family_name') }}" maxlength="50">
                                    @error('family_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Gender --}}
                                <div class="col-md-2 mb-3">
                                    <label class="form-label" for="gender">Gender</label>
                                    <select class="form-select @error('family_gender') is-invalid @enderror"
                                        id="family_gender" name="family_gender">
                                        <option value="">Select</option>
                                        <option value="male"
                                            {{ old('family_gender') == 'male' ? 'selected' : '' }}>Male
                                        </option>
                                        <option value="female"
                                            {{ old('family_gender') == 'female' ? 'selected' : '' }}>
                                            Female
                                        </option>
                                        <option value="other"
                                            {{ old('family_gender') == 'other' ? 'selected' : '' }}>
                                            Other
                                        </option>
                                    </select>
                                    @error('family_gender')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                                {{-- Date of Birth --}}
                                <div class="col-md-2 mb-3">
                                    <label class="form-label" for="family_dob">Date of Birth</label>
                                    <input type="date"
                                        class="form-control  @error('family_dob') is-invalid @enderror"
                                        id="family_dob" name="family_dob" value="{{ old('family_dob') }}"
                                        max="{{ now()->toDateString() }}" placeholder="Select Date">
                                    @error('family_dob')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                                {{-- Live Status --}}
                                <div class="col-md-2 mb-3">
                                    <label class="form-label" for="family_live_status">Live Status</label>
                                    <select class="form-select @error('family_live_status') is-invalid @enderror"
                                        id="family_live_status" name="family_live_status">
                                        <option value="alive"
                                            {{ old('family_live_status', 'alive') == 'alive' ? 'selected' : '' }}>
                                            Live
                                        </option>
                                        <option value="deceased"
                                            {{ old('family_live_status') == 'deceased' ? 'selected' : '' }}>
                                            Deceased
                                        </option>
                                    </select>
                                    @error('family_live_status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>



                                {{-- Date of Death --}}
                                <div class="col-md-2 mb-3 d-none">
                                    <label for="family_dod" class="form-label">Date of Death</label>
                                    <input type="date" name="family_dod" id="family_dod" class="form-control "
                                        value="{{ old('family_dod') }}" placeholder="Select Date"
                                        max="{{ now()->toDateString() }}">
                                    @error('family_dod')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>


                                {{-- Marital Status --}}
                                <div class="col-md-2 mb-3">
                                    <label class="form-label" for="family_marital_status">Marital Status</label>
                                    <select class="form-select @error('family_marital_status') is-invalid @enderror"
                                        id="family_marital_status" name="family_marital_status">
                                        <option value="">Select</option>
                                        <option value="single"
                                            {{ old('family_marital_status') == 'single' ? 'selected' : '' }}>
                                            Single
                                        </option>
                                        <option value="married"
                                            {{ old('family_marital_status') == 'married' ? 'selected' : '' }}>
                                            Married</option>
                                        <option value="divorced"
                                            {{ old('family_marital_status') == 'divorced' ? 'selected' : '' }}>
                                            divorced</option>
                                        <option value="widowed"
                                            {{ old('family_marital_status') == 'widowed' ? 'selected' : '' }}>
                                            widowed
                                        </option>
                                        <option value="other"
                                            {{ old('family_marital_status') == 'other' ? 'selected' : '' }}>Other
                                        </option>
                                    </select>
                                    @error('family_marital_status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                                {{-- Nationality --}}
                                <div class="col-md-2 mb-3">
                                    <label class="form-label" for="family_nationality">Nationality</label>
                                    <select class="form-select @error('family_nationality') is-invalid @enderror"
                                        id="family_nationality" name="family_nationality">
                                        <option value="">Select</option>
                                        <option value="ri"
                                            {{ old('family_nationality') == 'ri' ? 'selected' : '' }}>
                                            Residential
                                            Individual</option>
                                        <option value="nro"
                                            {{ old('family_nationality') == 'nro' ? 'selected' : '' }}>
                                            NRO
                                        </option>
                                        <option value="nre"
                                            {{ old('family_nationality') == 'nre' ? 'selected' : '' }}>
                                            NRE
                                        </option>
                                        <option value="pio"
                                            {{ old('family_nationality') == 'pio' ? 'selected' : '' }}>
                                            OCI/PIO
                                        </option>
                                        <option value="gch"
                                            {{ old('family_nationality') == 'gch' ? 'selected' : '' }}>
                                            Green Card
                                            Holder</option>
                                        <option value="trioc"
                                            {{ old('family_nationality') == 'trioc' ? 'selected' : '' }}>
                                            Tax
                                            Resident in Other Country</option>
                                        <option value="fn"
                                            {{ old('family_nationality') == 'fn' ? 'selected' : '' }}>
                                            Foreign
                                            National</option>
                                        <option value="other"
                                            {{ old('family_nationality') == 'other' ? 'selected' : '' }}>
                                            Other
                                        </option>
                                    </select>

                                    @error('family_nationality')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                                {{-- Occupation --}}
                                <div class="col-md-2 mb-3">
                                    <label class="form-label" for="family_occupation">Occupation</label>
                                    <select class="form-select @error('family_occupation') is-invalid @enderror"
                                        id="family_occupation" name="family_occupation">
                                        <option value="">Select</option>
                                        <option value="private_sector"
                                            {{ old('family_occupation') == 'private_sector' ? 'selected' : '' }}>
                                            Private
                                            Sector
                                        </option>
                                        <option value="public_sector"
                                            {{ old('family_occupation') == 'public_sector' ? 'selected' : '' }}>Public
                                            Sector
                                        </option>
                                        <option value="government"
                                            {{ old('family_occupation') == 'government' ? 'selected' : '' }}>
                                            Government
                                            Service</option>
                                        <option value="business"
                                            {{ old('family_occupation') == 'business' ? 'selected' : '' }}>
                                            Business</option>
                                        <option value="professional"
                                            {{ old('family_occupation') == 'professional' ? 'selected' : '' }}>
                                            Professional
                                        </option>
                                        <option value="agriculture"
                                            {{ old('family_occupation') == 'agriculture' ? 'selected' : '' }}>
                                            Agriculture</option>
                                        <option value="retired"
                                            {{ old('family_occupation') == 'retired' ? 'selected' : '' }}>Retired
                                        </option>
                                        <option value="housewife"
                                            {{ old('family_occupation') == 'housewife' ? 'selected' : '' }}>
                                            Housewife</option>
                                        <option value="student"
                                            {{ old('family_occupation') == 'student' ? 'selected' : '' }}>Student
                                        </option>
                                        <option value="doctor"
                                            {{ old('family_occupation') == 'doctor' ? 'selected' : '' }}>
                                            Doctor
                                        </option>
                                        <option value="education"
                                            {{ old('family_occupation') == 'education' ? 'selected' : '' }}>
                                            Education</option>
                                        <option value="other"
                                            {{ old('family_occupation') == 'other' ? 'selected' : '' }}>
                                            Other
                                        </option>
                                    </select>
                                    @error('family_occupation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>



                                {{-- Mobile Number --}}
                                <div class="col-md-2 mb-3">
                                    <label class="form-label" for="family_mobile_no">Mobile Number</label>
                                    <input type="text"
                                        class="form-control onlyphone @error('family_mobile_no') is-invalid @enderror"
                                        id="family_mobile_no" name="family_mobile_no" maxlength="15"
                                        value="{{ old('family_mobile_no') }}">
                                    @error('family_mobile_no')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                                {{-- WhatsApp Number --}}
                                <div class="col-md-2 mb-3">
                                    <label class="form-label" for="family_whatsapp_no">WhatsApp Number</label>
                                    <input type="text"
                                        class="form-control onlyphone @error('family_whatsapp_no') is-invalid @enderror"
                                        id="family_whatsapp_no" name="family_whatsapp_no" maxlength="15"
                                        value="{{ old('family_whatsapp_no') }}">
                                    {{-- <label class="uk-margin-right"><input
                                            class="uk-checkbox chkbox_fwapp_same_as_mobile" type="checkbox"
                                            id="" value="ON">
                                        Same as mobile no.</label> --}}
                                    @error('whatsapp_noff')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                                {{-- Landline No --}}
                                <div class="col-md-2 mb-3">
                                    <label class="form-label" for="family_landline_no">Landline No.</label>
                                    <input type="text"
                                        class="form-control @error('family_landline_no') is-invalid @enderror"
                                        id="family_landline_no" name="family_landline_no" maxlength="15"
                                        value="{{ old('family_landline_no') }}">
                                    @error('family_landline_no')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                                {{-- PAN No. --}}
                                <div class="col-md-2 mb-3">
                                    <label class="form-label" for="family_pan_no">PAN No.</label>
                                    <input type="text"
                                        class="form-control @error('family_pan_no') is-invalid @enderror"
                                        id="family_pan_no" name="family_pan_no" maxlength="10"
                                        value="{{ old('family_pan_no') }}"
                                        oninput="this.value = this.value.toUpperCase()"
                                        onblur1="checkPanExists(this.value)">
                                    @error('family_pan_no')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <span id="errpancardno" class="text-danger small"></span>
                                </div>


                                {{-- Aadhaar No. --}}
                                <div class="col-md-2 mb-3">
                                    <label class="form-label" for="family_aadhar_no">Aadhaar No.</label>
                                    <input type="text"
                                        class="form-control onlydigit @error('family_aadhar_no') is-invalid @enderror"
                                        id="family_aadhar_no" name="family_aadhar_no" maxlength="12"
                                        value="{{ old('family_aadhar_no') }}">
                                    @error('family_aadhar_no')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                                {{-- Email --}}
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="family_email">Email</label>
                                    <input type="email"
                                        class="form-control @error('family_email') is-invalid @enderror"
                                        id="family_email" name="family_email" value="{{ old('family_email') }}">
                                    @error('family_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>



                                {{-- Relation with client --}}
                                <div class="col-md-3 mb-3">
                                    <label for="relation_id" class="form-label">Relation with client</label>
                                    <select name="relation_id" id="relation_id" class="form-select select2">
                                        <option value="">Select Relation Manager</option>
                                        @foreach ($relations as $d)
                                            <option value="{{ $d->id }}"
                                                {{ old('relation_id') == $d->id ? 'selected' : '' }}>
                                                {{ $d->main_relation }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('relation_id')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>


                                {{-- Remarks / Note --}}
                                <div class="col-md-5 mb-3">
                                    <label class="form-label" for="remarks">Remarks / Note</label>
                                    <input type="text" class="form-control @error('remarks') is-invalid @enderror"
                                        id="family_remarks" name="family_remarks" maxlength="100"
                                        value="{{ old('remarks') }}">
                                    @error('remarks')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>






                                <!-- Residential Address -->
                                <h6 class="my-3 h6two">Residential Address</h6>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Address</label>
                                    <input type="text" name="family_res_address" id="family_res_address"
                                        class="form-control @error('family_res_address') is-invalid @enderror"
                                        value="{{ old('family_res_address') }}">
                                    @error('family_res_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- COUNTRY --}}
                                <div class="col-md-2 mb-3">
                                    <label class="form-label">Country</label>
                                    <select name="family_res_country_code" id="family_res_country_code"
                                        class="form-select select2 @error('family_res_country_code') is-invalid @enderror">

                                        @foreach ($country as $c)
                                            <option value="{{ $c['iso2'] }}"
                                                {{ old('family_res_country_code', 'IN') == $c['iso2'] ? 'selected' : '' }}
                                                data-country-name="{{ $c['name'] }}">
                                                {{ $c['name'] }}
                                            </option>
                                        @endforeach

                                    </select>
                                    @error('family_res_country_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- STATE --}}
                                <div class="col-md-2 mb-3">
                                    <label class="form-label">State </label>
                                    <select name="family_res_state_code" id="family_res_state_code"
                                        class="form-select select2 @error('family_res_state_code') is-invalid @enderror">
                                        @foreach ($states as $s)
                                            <option value="{{ $s['iso2'] }}"
                                                {{ old('family_res_state_code', 'MH') == $s['iso2'] ? 'selected' : '' }}
                                                data-state-name="{{ $s['name'] }}">
                                                {{ $s['name'] }} </option>
                                        @endforeach

                                    </select>
                                    @error('family_res_state_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- CITY --}}
                                <div class="col-md-2 mb-3">
                                    <label class="form-label">City</label>
                                    <select name="family_res_city_code" id="family_res_city_code"
                                        class="form-select select2 @error('family_res_city_code') is-invalid @enderror">
                                        @foreach ($cities as $c)
                                            <option value="{{ $c['id'] }}"
                                                {{ old('family_res_city_code', '134138') == $c['id'] ? 'selected' : '' }}
                                                data-city-name="{{ $c['name'] }}">
                                                {{ $c['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('family_res_city_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Pincode --}}
                                <div class="col-md-2 mb-3">
                                    <label class="form-label">Pincode</label>
                                    <input type="text" name="family_res_pincode" id="family_res_pincode"
                                        class="form-control onlydigit @error('family_res_pincode') is-invalid @enderror"
                                        value="{{ old('family_res_pincode') }}" maxlength="6">
                                    @error('family_res_pincode')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>





                                <!-- Office Address -->
                                <h6 class="my-3 h6two">Office Address</h6>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Address</label>
                                    <input type="text" name="office_address" id="office_address"
                                        class="form-control @error('office_address') is-invalid @enderror"
                                        value="{{ old('office_address') }}">
                                    @error('office_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                                {{-- COUNTRY --}}
                                <div class="col-md-2 mb-3">
                                    <label class="form-label">Country</label>
                                    <select name="office_country_code" id="office_country_code"
                                        class="form-select select2 @error('office_country_code') is-invalid @enderror">

                                        @foreach ($country as $c)
                                            <option value="{{ $c['iso2'] }}"
                                                {{ old('office_country_code', 'IN') == $c['iso2'] ? 'selected' : '' }}
                                                data-country-name="{{ $c['name'] }}">
                                                {{ $c['name'] }}
                                            </option>
                                        @endforeach

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
                                        @foreach ($states as $s)
                                            <option value="{{ $s['iso2'] }}"
                                                {{ old('office_state_code', 'MH') == $s['iso2'] ? 'selected' : '' }}
                                                data-state-name="{{ $s['name'] }}">
                                                {{ $s['name'] }}
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
                                        @foreach ($cities as $c)
                                            <option value="{{ $c['id'] }}"
                                                {{ old('office_city_code', '134138') == $c['id'] ? 'selected' : '' }}
                                                data-city-name="{{ $c['name'] }}">
                                                {{ $c['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('office_city_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Pincode --}}
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


            </div>

            <div id="BankSection" class="row align-items-stretch">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center"
                            style="background-color: #d3e0ff !important;">
                            <h6 class="mb-0 text-uppercase">Bank Information</h6>
                            <small class="text-muted float-end text-uppercase">Bank Account Details</small>
                        </div>

                        <div class="card-body">
                            <div class="bank-details-row row">

                                <!-- IFSC Code -->
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">IFSC Code</label>
                                    <input type="text" name="ifsc_code" value="{{ old('ifsc_code') }}"
                                        class="form-control ifsc_code @error('ifsc_code') is-invalid @enderror"
                                        placeholder="Enter IFSC Code" maxlength="11">
                                    @error('ifsc_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <span class="errmsg text-danger"></span>
                                </div>

                                <!-- Account Number -->
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Account Number</label>
                                    <input type="text" name="account_number" value="{{ old('account_number') }}"
                                        class="form-control account_number @error('account_number') is-invalid @enderror"
                                        placeholder="Enter Account Number" maxlength="15">
                                    @error('account_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Account Type -->
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Account Type</label>
                                    <select name="account_type"
                                        class="form-select @error('account_type') is-invalid @enderror">
                                        <option value="">Select Account Type</option>
                                        <option value="savings"
                                            {{ old('account_type') == 'savings' ? 'selected' : '' }}>Savings Account
                                        </option>
                                        <option value="current"
                                            {{ old('account_type') == 'current' ? 'selected' : '' }}>Current Account
                                        </option>
                                        <option value="od_cc"
                                            {{ old('account_type') == 'od_cc' ? 'selected' : '' }}>Overdraft / CC
                                        </option>
                                        <option value="nre" {{ old('account_type') == 'nre' ? 'selected' : '' }}>
                                            NRE</option>
                                        <option value="nri" {{ old('account_type') == 'nri' ? 'selected' : '' }}>
                                            NRI</option>
                                        <option value="nro" {{ old('account_type') == 'nro' ? 'selected' : '' }}>
                                            NRO</option>
                                        <option value="tem_deposit"
                                            {{ old('account_type') == 'tem_deposit' ? 'selected' : '' }}>Term Deposit
                                        </option>
                                        <option value="ra" {{ old('account_type') == 'ra' ? 'selected' : '' }}>
                                            Recurring Account</option>
                                    </select>
                                    @error('account_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Operation Mode -->
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Mode of Operation</label>
                                    <select name="operation_mode"
                                        class="form-select operation_mode @error('operation_mode') is-invalid @enderror">
                                        <option value="single"
                                            {{ old('operation_mode') == 'single' ? 'selected' : '' }}>Single</option>
                                        <option value="joint"
                                            {{ old('operation_mode') == 'joint' ? 'selected' : '' }}>Joint</option>
                                    </select>
                                    @error('operation_mode')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Holder 1 -->
                                <div
                                    class="col-md-3 mb-3 holder_names {{ old('operation_mode') != 'single' ? '' : '' }}">
                                    <label class="form-label">Holder Name 1</label>
                                    <input type="text" name="holder_name_1" value="{{ old('holder_name_1') }}"
                                        class="form-control @error('holder_name_1') is-invalid @enderror">
                                    @error('holder_name_1')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div
                                    class="col-md-3 mb-3 holder_names {{ old('operation_mode') == 'joint' ? '' : 'd-none' }}">
                                    <label class="form-label">Account Holder Name 2</label>
                                    <input type="text" name="holder_name_2" value="{{ old('holder_name_2') }}"
                                        class="form-control @error('holder_name_2') is-invalid @enderror">
                                    @error('holder_name_2')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div
                                    class="col-md-3 mb-3 holder_names {{ old('operation_mode') == 'joint' ? '' : 'd-none' }}">
                                    <label class="form-label">Account Holder Name 3</label>
                                    <input type="text" name="holder_name_3" value="{{ old('holder_name_3') }}"
                                        class="form-control @error('holder_name_3') is-invalid @enderror">
                                    @error('holder_name_3')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Auto-filled Bank Details -->
                                <!-- MICR -->
                                <div class="col-md-3">
                                    <label class="form-label">MICR Code</label>
                                    <input type="text" name="micrcode" value="{{ old('micrcode') }}"
                                        class="form-control micrcode bg-secondary-subtle bg-gradient @error('micrcode') is-invalid @enderror"
                                        readonly>
                                    @error('micrcode')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Bank Name -->
                                <div class="col-md-3">
                                    <label class="form-label">Bank Name</label>
                                    <input type="text" name="bank_name" value="{{ old('bank_name') }}"
                                        class="form-control bank_name bg-secondary-subtle bg-gradient @error('bank_name') is-invalid @enderror"
                                        readonly>
                                    @error('bank_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Branch Name -->
                                <div class="col-md-3">
                                    <label class="form-label">Branch Name</label>
                                    <input type="text" name="branch_name" value="{{ old('branch_name') }}"
                                        class="form-control branch_name bg-secondary-subtle bg-gradient @error('branch_name') is-invalid @enderror"
                                        readonly>
                                    @error('branch_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Bank Code -->
                                <div class="col-md-3">
                                    <label class="form-label">Bank Code</label>
                                    <input type="text" name="bank_code" value="{{ old('bank_code') }}"
                                        class="form-control bank_code bg-secondary-subtle bg-gradient @error('bank_code') is-invalid @enderror"
                                        readonly>
                                    @error('bank_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- Cancelled Cheque -->
                                {{-- <div class="col-md-4 mb-3">
                                    <label class="form-label">Cancelled Cheque</label>
                                    <input type="file" class="form-control" name="attachment_cancelled_cheque"
                                        accept=".jpg,.jpeg,.png,.pdf">
                                </div> --}}

                                <!-- Primary Account -->
                                {{-- <div class="col-md-2 mb-3">
                                    <label class="form-label d-block">Primary Account</label>
                                    <input type="hidden" name="is_primary" value="0">
                                    <input type="checkbox" name="is_primary" class="form-check-input"
                                        value="1">
                                </div> --}}

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit -->
            <div class="text-end mb-5">
                <button type="submit" class="btn btn-primary px-4">Save</button>
            </div>


        </form>
    </main>
    <footer>
        <!-- place footer here -->
    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>

    <script src="{{ asset('assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
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

    <script>
        $(document).ready(function() {
            $('#dob').on('change', function() {

                let dob = $(this).val();
                let $input = $(this);
                let $container = $input.closest('div');

                // Remove old error
                $container.find('.invalid-feedback').remove();
                $input.removeClass('is-invalid');

                if (!dob) return;

                let selected = new Date(dob);
                let today = new Date();

                let year = selected.getFullYear();
                let currentYear = today.getFullYear();

                let message = "";

                // ❌ Year too old (not realistic)
                if (year < 1900) {
                    message = "Please select a valid year.";
                }
                // ❌ Year ahead of current year
                else if (year > currentYear) {
                    message = "Year cannot be greater than the current year.";
                }
                // ❌ Month greater (same year)
                else if (year === currentYear && selected.getMonth() > today.getMonth()) {
                    message = "Month cannot be greater than the current month.";
                }
                // ❌ Full date in future
                else if (selected > today) {
                    message = "Date cannot be in the future.";
                }

                // show message if needed
                if (message !== "") {
                    $input.addClass('is-invalid');
                    $container.append(`<div class="invalid-feedback">${message}</div>`);
                }
            });
        });
    </script>

    <script>
        document.addEventListener("change", function(e) {
            if (e.target.classList.contains("operation_mode")) {

                let row = e.target.closest(".bank-details-row");
                let holders = row.querySelectorAll(".holder_names");

                // hide all holders first
                holders.forEach(h => h.classList.add("d-none"));

                let mode = e.target.value;

                if (mode === "single") {
                    // show only Holder 1
                    if (holders[0]) holders[0].classList.remove("d-none");
                }

                if (mode === "joint") {
                    // show all 3 holders
                    holders.forEach(h => h.classList.remove("d-none"));
                }
            }
        });
    </script>


</body>

</html>
