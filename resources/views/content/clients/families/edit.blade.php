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
        <span class="text-muted fw-light">Family /</span> <a href="">Edit Family Member</a>
    </h4>
    {{-- {{ $clientFamily }} --}}
    <a href="{{ route('client-families.index', ['client_id' => $clientFamily->client_id]) }}"
        class="btn btn-secondary px-4">Back</a>


    <form action="{{ route('client-families.update', $clientFamily->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" name="client_id" value="{{ $clientFamily->client_id }}">
        {{-- Hidden (readable values) --}}
        <input type="hidden1" name="res_country" id="res_country" value="{{ $client->res_country }}">
        <input type="hidden1" name="res_state" id="res_state" value="{{ $client->res_state }}">
        <input type="hidden1" name="res_city" id="res_city" value="{{ $client->res_city }}">

        <input type="hidden1" name="office_country" id="office_country" value="{{ $client->office_country }}">
        <input type="hidden1" name="office_state" id="office_state" value="{{ $client->office_state }}">
        <input type="hidden1" name="office_city" id="office_city" value="{{ $client->office_city }}">

        <div class="row align-items-stretch">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Family Information</h5>
                        <small class="text-muted float-end">Family Basic Details</small>
                    </div>
                    <div class="card-body">
                        <div class="row">

                            {{-- Full Name --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="name">Full Name</label>
                                <input type="text" class="form-control onlyalpha @error('name') is-invalid @enderror"
                                    id="name" name="name" maxlength="50"
                                    value="{{ old('name', $clientFamily->name) }}">
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
                                        {{ old('gender', $clientFamily->gender) == 'male' ? 'selected' : '' }}>Male
                                    </option>
                                    <option value="female"
                                        {{ old('gender', $clientFamily->gender) == 'female' ? 'selected' : '' }}>Female
                                    </option>
                                    <option value="other"
                                        {{ old('gender', $clientFamily->gender) == 'other' ? 'selected' : '' }}>Other
                                    </option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Date of Birth --}}
                            <div class="col-md-2 mb-3">
                                <label class="form-label" for="dob">Date of Birth</label>
                                <input type="text" class="form-control datepicker @error('dob') is-invalid @enderror"
                                    id="dob" name="dob" readonly placeholder="Select Date"
                                    value="{{ old('dob', $clientFamily->dob) }}">
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
                                        {{ old('live_status', $clientFamily->live_status) == 'alive' ? 'selected' : '' }}>
                                        Live</option>
                                    <option value="deceased"
                                        {{ old('live_status', $clientFamily->live_status) == 'deceased' ? 'selected' : '' }}>
                                        Deceased</option>
                                </select>
                                @error('live_status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Date of Death --}}
                            <div class="col-md-2 mb-3 {{ old('live_status', $clientFamily->live_status) == 'deceased' ? '' : 'd-none' }}"
                                id="dod_box">
                                <label class="form-label" for="dod">Date of Death</label>
                                <input type="text" class="form-control datepicker @error('dod') is-invalid @enderror"
                                    id="dod" name="dod" readonly placeholder="Select Date"
                                    value="{{ old('dod', $clientFamily->dod) }}">
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
                                        {{ old('marital_status', $clientFamily->marital_status) == 'single' ? 'selected' : '' }}>
                                        Single</option>
                                    <option value="married"
                                        {{ old('marital_status', $clientFamily->marital_status) == 'married' ? 'selected' : '' }}>
                                        Married</option>
                                    <option value="divorcee"
                                        {{ old('marital_status', $clientFamily->marital_status) == 'divorcee' ? 'selected' : '' }}>
                                        Divorcee</option>
                                    <option value="widow"
                                        {{ old('marital_status', $clientFamily->marital_status) == 'widow' ? 'selected' : '' }}>
                                        Widow</option>
                                    <option value="other"
                                        {{ old('marital_status', $clientFamily->marital_status) == 'other' ? 'selected' : '' }}>
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
                                    @php
                                        $nationalities = [
                                            'ri' => 'Residential Individual',
                                            'nro' => 'NRO',
                                            'nre' => 'NRE',
                                            'pio' => 'OCI/PIO',
                                            'gch' => 'Green Card Holder',
                                            'trioc' => 'Tax Resident in Other Country',
                                            'fn' => 'Foreign National',
                                            'other' => 'Other',
                                        ];
                                    @endphp

                                    @foreach ($nationalities as $key => $val)
                                        <option value="{{ $key }}"
                                            {{ old('nationality', $clientFamily->nationality) == $key ? 'selected' : '' }}>
                                            {{ $val }}
                                        </option>
                                    @endforeach
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

                                    @php
                                        $occupations = [
                                            'private_sector' => 'Private Sector',
                                            'public_sector' => 'Public Sector',
                                            'government' => 'Government Service',
                                            'business' => 'Business',
                                            'professional' => 'Professional',
                                            'agriculture' => 'Agriculture',
                                            'retired' => 'Retired',
                                            'housewife' => 'Housewife',
                                            'student' => 'Student',
                                            'doctor' => 'Doctor',
                                            'education' => 'Education',
                                            'other' => 'Other',
                                        ];
                                    @endphp

                                    @foreach ($occupations as $key => $val)
                                        <option value="{{ $key }}"
                                            {{ old('occupation', $clientFamily->occupation) == $key ? 'selected' : '' }}>
                                            {{ $val }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('occupation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Mobile --}}
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Mobile Number</label>
                                <input type="text"
                                    class="form-control onlyphone @error('mobile_no') is-invalid @enderror" id="phone"
                                    name="mobile_no" value="{{ old('mobile_no', $clientFamily->mobile_no) }}">
                                @error('mobile_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- WhatsApp --}}
                            <div class="col-md-2 mb-3">
                                <label class="form-label">WhatsApp Number</label>
                                <input type="text"
                                    class="form-control onlyphone @error('whatsapp_no') is-invalid @enderror"
                                    id="whatsapp_no" name="whatsapp_no"
                                    value="{{ old('whatsapp_no', $clientFamily->whatsapp_no) }}">

                                <label>
                                    <input type="checkbox" class="chkbox_fwapp_same_as_mobile"> Same as mobile no.
                                </label>
                                @error('whatsapp_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Landline --}}
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Landline No.</label>
                                <input type="text" class="form-control @error('landline_no') is-invalid @enderror"
                                    name="landline_no" value="{{ old('landline_no', $clientFamily->landline_no) }}">
                                @error('landline_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            {{-- PAN No. --}}
                            <div class="col-md-2 mb-3">
                                <label class="form-label" for="pan_no">PAN No.</label>
                                <input type="text" class="form-control @error('pan_no') is-invalid @enderror"
                                    id="pan_no" name="pan_no" maxlength="10"
                                    value="{{ old('pan_no', $clientFamily->pan_no) }}"
                                    oninput="this.value = this.value.toUpperCase()" onblur1="checkPanExists(this.value)">
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
                                    value="{{ old('aadhar_no', $clientFamily->aadhar_no) }}">
                                @error('aadhar_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            {{-- Email --}}
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email', $clientFamily->email) }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Relation --}}
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Relation with client</label>
                                <select name="relation_id" class="form-select select2">
                                    <option value="">Select Relation</option>
                                    @foreach ($relations as $d)
                                        <option value="{{ $d->id }}"
                                            {{ old('relation_id', $clientFamily->relation_id) == $d->id ? 'selected' : '' }}>
                                            {{ $d->main_relation }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('relation_id')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Remarks --}}
                            <div class="col-md-5 mb-3">
                                <label class="form-label">Remarks / Note</label>
                                <input type="text" class="form-control @error('remarks') is-invalid @enderror"
                                    name="remarks" value="{{ old('remarks', $clientFamily->remarks) }}">
                                @error('remarks')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <!-- ---------------- RESIDENTIAL ADDRESS ---------------- -->
                            <h6 class="my-3">Residential Address</h6>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Address</label>
                                <input type="text" name="res_address" class="form-control"
                                    value="{{ old('res_address', $clientFamily->res_address) }}">
                            </div>

                            {{-- COUNTRY --}}
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Country</label>
                                <select name="res_country_code"
                                    class="form-select select2 @error('res_country_code') is-invalid @enderror">
                                    <option value="{{ $country['iso2'] }}"
                                        {{ old('res_country_code', $clientFamily->res_country_code ?? 'IND') == $country['iso2'] ? 'selected' : '' }}>
                                        {{ $country['name'] }}
                                    </option>
                                </select>
                                @error('res_country_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- STATE --}}
                            <div class="col-md-3 mb-3">
                                <label class="form-label">State</label>
                                <select name="res_state_code"
                                    class="form-select select2 @error('res_state_code') is-invalid @enderror">
                                    @foreach ($states as $state)
                                        <option value="{{ $state['iso2'] }}"
                                            {{ old('res_state_code', $clientFamily->res_state_code ?? 'MH') == $state['iso2'] ? 'selected' : '' }}>
                                            {{ $state['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('res_state_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- CITY --}}
                            <div class="col-md-3 mb-3">
                                <label class="form-label">City</label>
                                <select name="res_city_code"
                                    class="form-select select2 @error('res_city_code') is-invalid @enderror">
                                    @foreach ($cities as $c)
                                        <option value="{{ $c['id'] }}"
                                            {{ old('res_city_code', $client->res_city_code) == $c['id'] ? 'selected' : '' }}>
                                            {{ $c['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('res_city_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


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


                            <!-- ---------------- OFFICE ADDRESS ---------------- -->
                            <h6 class="my-3">Office Address</h6>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Address</label>
                                <input type="text" name="office_address" class="form-control"
                                    value="{{ old('office_address', $clientFamily->office_address) }}">
                            </div>

                            {{-- COUNTRY --}}
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Country</label>
                                <select name="office_country_code" id="office_country_code"
                                    class="form-select select2 @error('office_country_code') is-invalid @enderror">

                                    <option value="{{ $country['iso2'] }}"
                                        {{ old('res_country_code', 'IND') == $country['iso2'] ? 'selected' : '' }}
                                        data-country-name="{{ $country['name'] }}">
                                        {{ $country['name'] }}
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
                                        <option value="{{ $state['iso2'] }}"
                                            {{ old('res_state_code', 'MH') == $state['iso2'] ? 'selected' : '' }}
                                            data-state-name="{{ $state['name'] }}">
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
            // For Firm WhatsApp Number
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
            function toggleDod() {
                if ($('#live_status').val() === 'deceased') {
                    $('#dod').closest('.col-md-2').removeClass('d-none');
                } else {
                    $('#dod').closest('.col-md-2').addClass('d-none');
                }
            }

            toggleDod(); // run when page loads

            $('#live_status').on('change', function() {
                toggleDod();
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
