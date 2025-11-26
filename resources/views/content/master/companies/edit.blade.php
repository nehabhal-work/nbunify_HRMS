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
        <span class="text-muted fw-light">Master /</span> <a href="{{ route('master.companies.index') }}">Company</a>
    </h4>


    <form action="{{ route('master.companies.update', $company->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')


        <input type="hidden" name="res_country" id="res_country" value="{{ $company->res_country }}">
        <input type="hidden" name="res_state" id="res_state" value="{{ $company->res_state }}">
        <input type="hidden" name="res_city" id="res_city" value="{{ $company->res_city }}">

        <input type="hidden" name="office_country" id="office_country" value="{{ $company->office_country }}">
        <input type="hidden" name="office_state" id="office_state" value="{{ $company->office_state }}">
        <input type="hidden" name="office_city" id="office_city" value="{{ $company->office_city }}">

        <input type="hidden" name="additional_country" id="additional_country" value="{{ $company->additional_country }}">
        <input type="hidden" name="additional_state" id="additional_state" value="{{ $company->additional_state }}">
        <input type="hidden" name="additional_city" id="additional_city" value="{{ $company->additional_city }}">


        <div class="row align-items-stretch">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Primary Information</h5>
                        <small class="text-muted float-end">Company Basic Details</small>
                    </div>
                    <div class="card-body">

                        {{-- Primary Information --}}
                        <div class="row">

                            <!-- Company Name -->
                            <div class="col-3 mb-3">
                                <label class="form-label">Company Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $company->name) }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Company band -->
                            <div class="col-3 mb-3">
                                <label class="form-label">Company brand Name <span class="text-danger">*</span></label>
                                <input type="text" name="brand_name" id="brand_name"
                                    class="form-control @error('brand_name') is-invalid @enderror"
                                    value="{{ old('brand_name', $company->brand_name) }}">
                                @error('brand_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Company Type -->
                            <div class="col-md-3 mb-3" hidden>
                                <label class="form-label">Company Type <span class="text-danger">*</span></label>
                                <select name="company_type" id="company_type"
                                    class="form-select select2 @error('company_type') is-invalid @enderror">
                                    <option value="">Select Type</option>
                                    @php
                                        $types = [
                                            'sole_proprietorship' => 'Sole Proprietorship',
                                            'partnership' => 'Partnership',
                                            'pvt_ltd' => 'Private Limited',
                                            'public_ltd' => 'Public Limited',
                                            'llp' => 'LLP',
                                            'huf' => 'HUF',
                                            'ngo' => 'NGO',
                                        ];
                                    @endphp
                                    @foreach ($types as $key => $label)
                                        <option value="{{ $key }}"
                                            {{ old('company_type', $company->company_type) == $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('company_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Establishment Date -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Establishment Date</label>

                                <input type="text"
                                    class="form-control datepicker @error('est_date') is-invalid @enderror" id="est_date"
                                    name="est_date"
                                    value="{{ old('est_date', isset($company->est_date) ? \Carbon\Carbon::parse($company->est_date)->format('d-m-Y') : '') }}"
                                    max="{{ now()->toDateString() }}" readonly placeholder="Select Date">

                                @error('est_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="w-100"></div>

                            <!-- Contact Person -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Contact Person Name</label>
                                <input type="text" name="contact_person_name" id="contact_person_name"
                                    class="form-control @error('contact_person_name') is-invalid @enderror"
                                    value="{{ old('contact_person_name', $company->contact_person_name) }}">
                                @error('contact_person_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Contact Number -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Contact Person Number</label>
                                <input type="text" name="phone" id="phone"
                                    class="form-control onlyphone @error('phone') is-invalid @enderror"
                                    value="{{ old('phone', $company->phone) }}" maxlength="15">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Contact Person Email</label>
                                <input type="email" name="email" id="email"
                                    class="form-control  no-uppercase @error('email') is-invalid @enderror"
                                    value="{{ old('email', $company->email) }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            {{-- WhatsApp Number --}}
                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="whatsapp_no">Contact Person WhatsApp Number</label>
                                <input type="text"
                                    class="form-control onlyphone @error('whatsapp_no') is-invalid @enderror"
                                    id="whatsapp_no" name="whatsapp_no" maxlength="15"
                                    value="{{ old('whatsapp_no', $company->whatsapp_no) }}">
                                <label class="uk-margin-right"><input class="uk-checkbox chkbox_fwapp_same_as_mobile"
                                        type="checkbox" id="" value="ON">
                                    Same as mobile no.</label>
                                @error('whatsapp_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Proprietor Contact Person -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Proprietor Name</label>
                                <input type="text" name="proprietor_name" id="proprietor_name"
                                    class="form-control @error('proprietor_name') is-invalid @enderror"
                                    value="{{ old('proprietor_name', $company->proprietor_name) }}">
                                @error('proprietor_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Proprietor Contact Number -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Proprietor Contact Number</label>
                                <input type="text" name="proprietor_phone" id="proprietor_phone"
                                    class="form-control onlyphone @error('proprietor_phone') is-invalid @enderror"
                                    value="{{ old('proprietor_phone', $company->proprietor_phone) }}" maxlength="15">
                                @error('proprietor_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Proprietor Email -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Proprietor Email</label>
                                <input type="email" name="proprietor_email" id="proprietor_email"
                                    class="form-control  no-uppercase @error('proprietor_email') is-invalid @enderror"
                                    value="{{ old('proprietor_email', $company->proprietor_email) }}">
                                @error('proprietor_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Proprietor WhatsApp Number -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="proprietor_whatsapp">Proprietor WhatsApp Number</label>
                                <input type="text"
                                    class="form-control onlyphone @error('proprietor_whatsapp') is-invalid @enderror"
                                    id="proprietor_whatsapp" name="proprietor_whatsapp" maxlength="15"
                                    value="{{ old('proprietor_whatsapp', $company->proprietor_whatsapp) }}">
                                <div class="form-check mt-1">
                                    <input class="form-check-input chkbox_prop_wa_same_as_mobile" type="checkbox"
                                        id="chkbox_prop_wa_same_as_mobile">
                                    <label class="form-check-label" for="chkbox_prop_wa_same_as_mobile">
                                        Same as mobile no.
                                    </label>
                                </div>
                                @error('proprietor_whatsapp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        {{-- address section --}}
                        <div class="row">

                            <!-- Residential Address -->
                            <h6 class="my-3">Residential Address</h6>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Address</label>
                                <input type="text" name="registered_address" id="res_address"
                                    class="form-control @error('registered_address') is-invalid @enderror"
                                    value="{{ old('registered_address', $company->registered_address ?? '') }}">
                                @error('registered_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2 mb-3">
                                <label class="form-label">Country</label>
                                <select name="registered_country" id="res_country_code"
                                    class="form-select select2 @error('registered_country') is-invalid @enderror">
                                    <option value="{{ $country['iso2'] }}"
                                        {{ old('registered_country', $company->registered_country ?? 'IND') == $country['iso2'] ? 'selected' : '' }}
                                        data-country-name="{{ $country['name'] }}">
                                        {{ $country['name'] }}
                                    </option>
                                </select>
                                @error('registered_country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2 mb-3">
                                <label class="form-label">State</label>
                                <select name="registered_state" id="registered_state"
                                    class="form-select select2 @error('registered_state') is-invalid @enderror">
                                    @foreach ($states as $state)
                                        <option value="{{ $state['iso2'] }}"
                                            {{ old('registered_state', $company->registered_state ?? 'MH') == $state['iso2'] ? 'selected' : '' }}
                                            data-state-name="{{ $state['name'] }}">
                                            {{ $state['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('registered_state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2 mb-3">
                                <label class="form-label">City</label>
                                <select name="registered_city" id="registered_city"
                                    class="form-select select2 @error('registered_city') is-invalid @enderror">
                                    <option value="">Select City</option>
                                    @foreach ($cities as $c)
                                        <option value="{{ $c['id'] }}"
                                            {{ old('registered_city', $company->registered_city ?? '') == $c['id'] ? 'selected' : '' }}
                                            data-city-name="{{ $c['name'] }}">
                                            {{ $c['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('registered_city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2 mb-3">
                                <label class="form-label">Pincode</label>
                                <input type="text" name="registered_pincode" id="registered_pincode"
                                    class="form-control onlydigit @error('registered_pincode') is-invalid @enderror"
                                    value="{{ old('registered_pincode', $company->registered_pincode ?? '') }}"
                                    maxlength="6">
                                @error('registered_pincode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Corporate Address -->
                            <h6 class="my-3">Corporate Address</h6>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Address</label>
                                <input type="text" name="corporate_address" id="corporate_address"
                                    class="form-control @error('corporate_address') is-invalid @enderror"
                                    value="{{ old('corporate_address', $company->corporate_address ?? '') }}">
                                @error('corporate_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2 mb-3">
                                <label class="form-label">Country</label>
                                <select name="corporate_country" id="corporate_country"
                                    class="form-select select2 @error('corporate_country') is-invalid @enderror">
                                    <option value="{{ $country['iso2'] }}"
                                        {{ old('corporate_country', $company->corporate_country ?? 'IND') == $country['iso2'] ? 'selected' : '' }}
                                        data-country-name="{{ $country['name'] }}">
                                        {{ $country['name'] }}
                                    </option>
                                </select>
                                @error('corporate_country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2 mb-3">
                                <label class="form-label">State</label>
                                <select name="corporate_state" id="corporate_state"
                                    class="form-select select2 @error('corporate_state') is-invalid @enderror">
                                    @foreach ($states as $state)
                                        <option value="{{ $state['iso2'] }}"
                                            {{ old('corporate_state', $company->corporate_state ?? 'MH') == $state['iso2'] ? 'selected' : '' }}
                                            data-state-name="{{ $state['name'] }}">
                                            {{ $state['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('corporate_state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2 mb-3">
                                <label class="form-label">City</label>
                                <select name="corporate_city" id="corporate_city"
                                    class="form-select select2 @error('corporate_city') is-invalid @enderror">
                                    <option value="">Select City</option>
                                    @foreach ($cities as $c)
                                        <option value="{{ $c['id'] }}"
                                            {{ old('corporate_city', $company->corporate_city ?? '') == $c['id'] ? 'selected' : '' }}
                                            data-city-name="{{ $c['name'] }}">
                                            {{ $c['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('corporate_city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2 mb-3">
                                <label class="form-label">Pincode</label>
                                <input type="text" name="corporate_pincode" id="corporate_pincode"
                                    class="form-control onlydigit @error('corporate_pincode') is-invalid @enderror"
                                    value="{{ old('corporate_pincode', $company->corporate_pincode ?? '') }}"
                                    maxlength="6">
                                @error('corporate_pincode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Additional Address -->
                            <h6 class="my-3">Additional Address For GST</h6>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Address</label>
                                <input type="text" name="additional_address" id="additional_address"
                                    class="form-control @error('additional_address') is-invalid @enderror"
                                    value="{{ old('additional_address', $company->additional_address ?? '') }}">
                                @error('additional_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2 mb-3">
                                <label class="form-label">Country</label>
                                <select name="additional_country_code" id="additional_country_code"
                                    class="form-select select2 @error('additional_country_code') is-invalid @enderror">
                                    <option value="{{ $country['iso2'] }}"
                                        {{ old('additional_country_code', $company->additional_country_code ?? 'IND') == $country['iso2'] ? 'selected' : '' }}
                                        data-country-name="{{ $country['name'] }}">
                                        {{ $country['name'] }}
                                    </option>
                                </select>
                                @error('additional_country_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2 mb-3">
                                <label class="form-label">State</label>
                                <select name="additional_state_code" id="additional_state_code"
                                    class="form-select select2 @error('additional_state_code') is-invalid @enderror">
                                    @foreach ($states as $state)
                                        <option value="{{ $state['iso2'] }}"
                                            {{ old('additional_state_code', $company->additional_state_code ?? 'MH') == $state['iso2'] ? 'selected' : '' }}
                                            data-state-name="{{ $state['name'] }}">
                                            {{ $state['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('additional_state_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- {{ $company }} --}}
                            {{-- <div class="col-md-2 mb-3">
                                <label class="form-label">City</label>
                                <select name="additional_city" id="additional_city"
                                    class="form-select select2 @error('additional_city') is-invalid @enderror">
                                    <option value="">Select City</option>

                                    @foreach ($cities as $c)
                                        <option value="{{ $c['id'] }}"
                                            {{ (string) old('additional_city', $company->additional_city ?? '') === (string) $c['id'] ? 'selected' : '' }}>
                                            {{ $c['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('additional_city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div> --}}
                            
                            <div class="col-md-2 mb-3">
                                <label class="form-label">City</label>
                                <select name="additional_city" id="additional_city"
                                    class="form-select select2 @error('additional_city') is-invalid @enderror">
                                    <option value="">Select City</option>
                                    @foreach ($cities as $c)
                                        <option value="{{ $c['id'] }}"
                                            {{ old('additional_city', $company->additional_city ?? '') == $c['id'] ? 'selected' : '' }}
                                            data-city-name="{{ $c['name'] }}">
                                            {{ $c['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('additional_city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="col-md-2 mb-3">
                                <label class="form-label">Pincode</label>
                                <input type="text" name="additional_pincode" id="additional_pincode"
                                    class="form-control onlydigit @error('additional_pincode') is-invalid @enderror"
                                    value="{{ old('additional_pincode', $company->additional_pincode ?? '') }}"
                                    maxlength="6">
                                @error('additional_pincode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                    </div>
                </div>
            </div>




            <div class="col-md-6 d-flex">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Company Registration & Compliance</h5>
                        <small class="text-muted float-end">Official Identification Numbers</small>
                    </div>

                    <div class="card-body">
                        <div class="row">

                            <!-- CIN Number -->
                            <div class="col-md-6 mb-3 d-none">
                                <label class="form-label">CIN Number</label>
                                <input type="text" name="cin_no" id="cin_no"
                                    class="form-control  @error('cin_no') is-invalid @enderror"
                                    value="{{ old('cin_no', $company->cin_no) }}">
                                @error('cin_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- PAN Number -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">PAN Number of proprietor</label>
                                <input type="text" name="pan_no" id="pan_no"
                                    class="form-control  @error('pan_no') is-invalid @enderror"
                                    value="{{ old('pan_no', $company->pan_no) }}" maxlength="10">
                                @error('pan_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- TAN Number -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">TAN Number</label>
                                <input type="text" name="tan_no" id="tan_no"
                                    class="form-control  @error('tan_no') is-invalid @enderror"
                                    value="{{ old('tan_no', $company->tan_no) }}" maxlength="10">
                                @error('tan_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- GSTIN -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">GSTIN</label>
                                <input type="text" name="gstin" id="gstin"
                                    class="form-control  @error('gstin') is-invalid @enderror"
                                    value="{{ old('gstin', $company->gstin) }}" maxlength="15">
                                @error('gstin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Udyam Aadhar Number -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Udyam Aadhar Number</label>
                                <input type="text" name="udyam_aadhar_no" id="udyam_aadhar_no"
                                    class="form-control  @error('udyam_aadhar_no') is-invalid @enderror"
                                    value="{{ old('udyam_aadhar_no', $company->udyam_aadhar_no) }}" maxlength="19">
                                @error('udyam_aadhar_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Partnership Registration Number -->
                            <div class="col-md-6 mb-3 d-none">
                                <label class="form-label">Partnership Registration Number</label>
                                <input type="text" name="partnership_registration_no" id="partnership_registration_no"
                                    class="form-control @error('partnership_registration_no') is-invalid @enderror"
                                    value="{{ old('partnership_registration_no', $company->partnership_registration_no) }}"
                                    maxlength="15">
                                @error('partnership_registration_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- ROC Number -->
                            <div class="col-md-6 mb-3 d-none">
                                <label class="form-label">ROC Number</label>
                                <input type="text" name="roc_no" id="roc_no"
                                    class="form-control @error('roc_no', $company->roc_no) is-invalid @enderror"
                                    value="{{ old('roc_no', $company->roc_no) }}">
                                @error('roc_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- MSME Certification Number -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">MSME Certification Number</label>
                                <input type="text" name="msme_certification_no" id="msme_certification_no"
                                    class="form-control @error('msme_certification_no') is-invalid @enderror"
                                    value="{{ old('msme_certification_no', $company->msme_certification_no) }}"
                                    maxlength="15">
                                @error('msme_certification_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- CKYC -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">CKYC Number</label>
                                <input type="text" name="ckyc" id="ckyc"
                                    class="form-control @error('ckyc', $company->ckyc) is-invalid @enderror"
                                    value="{{ old('ckyc', $company->ckyc) }}" maxlength="14">
                                @error('ckyc')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Gumasta Number -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Gumasta Number</label>
                                <input type="text" name="gumasta_no" id="gumasta_no"
                                    class="form-control @error('gumasta_no', $company->gumasta_no) is-invalid @enderror"
                                    value="{{ old('gumasta_no', $company->gumasta_no) }}" maxlength="15">
                                @error('gumasta_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Gumasta Number -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">aadhar Number</label>
                                <input type="text" name="aadhar_no" id="aadhar_no"
                                    class="form-control @error('aadhar_no') is-invalid @enderror"
                                    value="{{ old('aadhar_no', $company->aadhar_no) }}" maxlength="12">
                                @error('aadhar_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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


                            <!-- File Upload: Company images -->


                            <div class="col-md-6 mb-3">
                                <label class="form-label">Logo Attachment</label>
                                <div class="input-group">
                                    <input type="file" class="form-control @error('logo') is-invalid @enderror"
                                        id="logo" name="logo" accept=".jpg,.jpeg,.png"
                                        onchange="uploadTempFile(this, 'logo')">
                                    <button class="btn btn-outline-danger" type="button"
                                        onclick="document.getElementById('logo').value = ''">✕</button>
                                </div>
                                @error('logo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <input type="hidden" id="logo_url" value="{{ old('logo_url') }}" name="logo_url">

                                @if ($company->logo_url)
                                    <div id="logo_previews" class="position-relative d-inline-block">
                                        <img src="{{ $company->logo_url }}" class="rounded">

                                        <!-- Remove (X) button -->
                                        <button type="button"
                                            class="btn btn-sm btn-danger position-absolute top-0 start-100 translate-middle"
                                            onclick="removeImage('logo')">
                                            ✕
                                        </button>
                                    </div>
                                @elseif (old('logo_url'))
                                    <div id="logo_preview" class="position-relative d-inline-block">
                                        <img src="{{ old('logo_url') }}" class="rounded">

                                        <!-- Remove (X) button -->
                                        <button type="button"
                                            class="btn btn-sm btn-danger position-absolute top-0 start-100 translate-middle"
                                            onclick="removeImage('logo')">
                                            ✕
                                        </button>
                                    </div>
                                @endif
                            </div>


                            {{-- Aadhar Attachment --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Aadhar Attachment</label>
                                <div class="input-group">
                                    <input type="file"
                                        class="form-control @error('attachment_aadhar') is-invalid @enderror"
                                        id="attachment_aadhar" name="attachment_aadhar"
                                        accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                                        onchange="uploadTempFile(this, 'attachment_aadhar')">
                                    <button class="btn btn-outline-danger" type="button"
                                        onclick="document.getElementById('attachment_aadhar').value = ''">✕</button>
                                </div>
                                @error('attachment_aadhar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <input type="hidden" id="attachment_aadhar_url"
                                    value="{{ old('attachment_aadhar_url') }}" name="attachment_aadhar_url">

                                @if ($company->attachment_aadhar_url)
                                    <div id="attachment_aadhar_preview" class="position-relative d-inline-block">
                                        <img src="{{ $company->attachment_aadhar_url }}" class="rounded">

                                        <!-- Remove (X) button -->
                                        <button type="button"
                                            class="btn btn-sm btn-danger position-absolute bottom-0 start-100 translate-middle"
                                            onclick="removeImage('attachment_aadhar')">
                                            ✕
                                        </button>
                                    </div>
                                @elseif (old('attachment_aadhar_url'))
                                    <div id="attachment_aadhar_preview" class="position-relative d-inline-block">
                                        <img src="{{ old('attachment_aadhar_url') }}" class="rounded">

                                        <!-- Remove (X) button -->
                                        <button type="button"
                                            class="btn btn-sm btn-danger position-absolute bottom-0 start-100 translate-middle"
                                            onclick="removeImage('attachment_aadhar')">
                                            ✕
                                        </button>
                                    </div>
                                @endif
                            </div>


                            {{-- PAN Attachment --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">PAN Attachment</label>
                                <div class="input-group">
                                    <input type="file"
                                        class="form-control @error('attachment_pan') is-invalid @enderror"
                                        id="attachment_pan" name="attachment_pan"
                                        accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                                        onchange="uploadTempFile(this, 'attachment_pan')">
                                    <button class="btn btn-outline-danger" type="button"
                                        onclick="document.getElementById('attachment_pan').value = ''">✕</button>
                                </div>
                                @error('attachment_pan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <input type="hidden" id="attachment_pan_url" value="{{ old('attachment_pan_url') }}"
                                    name="attachment_pan_url">

                                @if ($company->attachment_pan_url)
                                    <div id="attachment_pan_preview" class="position-relative d-inline-block">
                                        <img src="{{ $company->attachment_pan_url }}" class="rounded">

                                        <!-- Remove (X) button -->
                                        <button type="button"
                                            class="btn btn-sm btn-danger position-absolute bottom-0 start-100 translate-middle"
                                            onclick="removeImage('attachment_pan')">
                                            ✕
                                        </button>
                                    </div>
                                @elseif (old('attachment_pan_url'))
                                    <div id="attachment_pan_preview" class="position-relative d-inline-block">
                                        <img src="{{ old('attachment_pan_url') }}" class="rounded">

                                        <!-- Remove (X) button -->
                                        <button type="button"
                                            class="btn btn-sm btn-danger position-absolute bottom-0 start-100 translate-middle"
                                            onclick="removeImage('attachment_pan')">
                                            ✕
                                        </button>
                                    </div>
                                @endif
                            </div>


                            {{-- TAN Attachment --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">TAN Attachment</label>
                                <div class="input-group">
                                    <input type="file"
                                        class="form-control @error('attachment_tan') is-invalid @enderror"
                                        id="attachment_tan" name="attachment_tan"
                                        accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                                        onchange="uploadTempFile(this, 'attachment_tan')">
                                    <button class="btn btn-outline-danger" type="button"
                                        onclick="document.getElementById('attachment_tan').value = ''">✕</button>
                                </div>
                                @error('attachment_tan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <input type="hidden" id="attachment_tan_url" value="{{ old('attachment_tan_url') }}"
                                    name="attachment_tan_url">

                                @if ($company->attachment_tan_url)
                                    <div id="attachment_tan_preview" class="position-relative d-inline-block">
                                        <img src="{{ $company->attachment_tan_url }}" class="rounded">

                                        <!-- Remove (X) button -->
                                        <button type="button"
                                            class="btn btn-sm btn-danger position-absolute bottom-0 start-100 translate-middle"
                                            onclick="removeImage('attachment_tan')">
                                            ✕
                                        </button>
                                    </div>
                                @elseif (old('attachment_tan_url'))
                                    <div id="attachment_tan_preview" class="position-relative d-inline-block">
                                        <img src="{{ old('attachment_tan_url') }}" class="rounded">

                                        <!-- Remove (X) button -->
                                        <button type="button"
                                            class="btn btn-sm btn-danger position-absolute bottom-0 start-100 translate-middle"
                                            onclick="removeImage('attachment_tan')">
                                            ✕
                                        </button>
                                    </div>
                                @endif
                            </div>



                            {{-- GSTIN Attachment --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">GSTIN Attachment</label>
                                <div class="input-group">
                                    <input type="file"
                                        class="form-control @error('attachment_gstin') is-invalid @enderror"
                                        id="attachment_gstin" name="attachment_gstin"
                                        accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                                        onchange="uploadTempFile(this, 'attachment_gstin')">
                                    <button class="btn btn-outline-danger" type="button"
                                        onclick="document.getElementById('attachment_gstin').value = ''">✕</button>
                                </div>
                                @error('attachment_gstin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <input type="hidden" id="attachment_gstin_url"
                                    value="{{ old('attachment_gstin_url') }}" name="attachment_gstin_url">

                                @if ($company->attachment_gstin_url)
                                    <div id="attachment_gstin_preview" class="position-relative d-inline-block">
                                        <img src="{{ $company->attachment_gstin_url }}" class="rounded">

                                        <!-- Remove (X) button -->
                                        <button type="button"
                                            class="btn btn-sm btn-danger position-absolute bottom-0 start-100 translate-middle"
                                            onclick="removeImage('attachment_gstin')">
                                            ✕
                                        </button>
                                    </div>
                                @elseif (old('attachment_gstin_url'))
                                    <div id="attachment_gstin_preview" class="position-relative d-inline-block">
                                        <img src="{{ old('attachment_gstin_url') }}" class="rounded">

                                        <!-- Remove (X) button -->
                                        <button type="button"
                                            class="btn btn-sm btn-danger position-absolute bottom-0 start-100 translate-middle"
                                            onclick="removeImage('attachment_gstin')">
                                            ✕
                                        </button>
                                    </div>
                                @endif
                            </div>


                            {{-- CKYC Attachment --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">CKYC Attachment</label>
                                <div class="input-group">
                                    <input type="file"
                                        class="form-control @error('attachment_ckyc') is-invalid @enderror"
                                        id="attachment_ckyc" name="attachment_ckyc"
                                        accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                                        onchange="uploadTempFile(this, 'attachment_ckyc')">
                                    <button class="btn btn-outline-danger" type="button"
                                        onclick="document.getElementById('attachment_ckyc').value = ''">✕</button>
                                </div>
                                @error('attachment_ckyc')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <input type="hidden" id="attachment_ckyc" value="{{ old('attachment_ckyc') }}"
                                    name="attachment_ckyc">

                                @if ($company->attachment_ckyc)
                                    <div id="attachment_ckyc_preview" class="position-relative d-inline-block">
                                        <img src="{{ $company->attachment_ckyc }}" class="rounded">

                                        <!-- Remove (X) button -->
                                        <button type="button"
                                            class="btn btn-sm btn-danger position-absolute bottom-0 start-100 translate-middle"
                                            onclick="removeImage('attachment_ckyc')">
                                            ✕
                                        </button>
                                    </div>
                                @elseif (old('attachment_ckyc'))
                                    <div id="attachment_ckyc_preview" class="position-relative d-inline-block">
                                        <img src="{{ old('attachment_ckyc') }}" class="rounded">

                                        <!-- Remove (X) button -->
                                        <button type="button"
                                            class="btn btn-sm btn-danger position-absolute bottom-0 start-100 translate-middle"
                                            onclick="removeImage('attachment_ckyc')">
                                            ✕
                                        </button>
                                    </div>
                                @endif
                            </div>

                            {{-- Partnership Deed --}}
                            <div class="col-md-6 mb-3 d-none">
                                <label class="form-label">Partnership Deed</label>
                                <div class="input-group">
                                    <input type="file"
                                        class="form-control @error('attachment_partnership_deed') is-invalid @enderror"
                                        id="attachment_partnership_deed" name="attachment_partnership_deed"
                                        accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                                        onchange="uploadTempFile(this, 'attachment_partnership_deed')">
                                    <button class="btn btn-outline-danger" type="button"
                                        onclick="document.getElementById('attachment_partnership_deed').value = ''">✕</button>
                                </div>
                                @error('attachment_partnership_deed')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <input type="hidden" id="attachment_partnership_deed_url"
                                    value="{{ old('attachment_partnership_deed_url') }}"
                                    name="attachment_partnership_deed_url">

                                @if ($company->attachment_partnership_deed_url)
                                    <div id="attachment_partnership_deed_preview"
                                        class="position-relative d-inline-block">
                                        <img src="{{ $company->attachment_partnership_deed_url }}" class="rounded">

                                        <!-- Remove (X) button -->
                                        <button type="button"
                                            class="btn btn-sm btn-danger position-absolute bottom-0 start-100 translate-middle"
                                            onclick="removeImage('attachment_partnership_deed')">
                                            ✕
                                        </button>
                                    </div>
                                @elseif (old('attachment_partnership_deed_url'))
                                    <div id="attachment_partnership_deed_preview"
                                        class="position-relative d-inline-block">
                                        <img src="{{ old('attachment_partnership_deed_url') }}" class="rounded">

                                        <!-- Remove (X) button -->
                                        <button type="button"
                                            class="btn btn-sm btn-danger position-absolute bottom-0 start-100 translate-middle"
                                            onclick="removeImage('attachment_partnership_deed')">
                                            ✕
                                        </button>
                                    </div>
                                @endif
                            </div>


                            {{-- Udyam Aadhar --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Udyam Aadhar</label>
                                <div class="input-group">
                                    <input type="file"
                                        class="form-control @error('attachment_udyam_aadhar') is-invalid @enderror"
                                        id="attachment_udyam_aadhar" name="attachment_udyam_aadhar"
                                        accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                                        onchange="uploadTempFile(this, 'attachment_udyam_aadhar')">
                                    <button class="btn btn-outline-danger" type="button"
                                        onclick="document.getElementById('attachment_udyam_aadhar').value = ''">✕</button>
                                </div>
                                @error('attachment_udyam_aadhar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <input type="hidden" id="attachment_udyam_aadhar_url"
                                    value="{{ old('attachment_udyam_aadhar_url') }}" name="attachment_udyam_aadhar_url">

                                @if ($company->attachment_udyam_aadhar_url)
                                    <div id="attachment_udyam_aadhar_preview" class="position-relative d-inline-block">
                                        <img src="{{ old('attachment_udyam_aadhar_url') }}" class="rounded">

                                        <!-- Remove (X) button -->
                                        <button type="button"
                                            class="btn btn-sm btn-danger position-absolute bottom-0 start-100 translate-middle"
                                            onclick="removeImage('attachment_udyam_aadhar')">
                                            ✕
                                        </button>
                                    </div>
                                @elseif ($company->attachment_udyam_aadhar_url)
                                    <div id="attachment_udyam_aadhar_preview" class="position-relative d-inline-block">
                                        <img src="{{ old('attachment_udyam_aadhar_url') }}" class="rounded">

                                        <!-- Remove (X) button -->
                                        <button type="button"
                                            class="btn btn-sm btn-danger position-absolute bottom-0 start-100 translate-middle"
                                            onclick="removeImage('attachment_udyam_aadhar')">
                                            ✕
                                        </button>
                                    </div>
                                @endif
                            </div>


                            {{-- Gumasta License --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Gumasta License</label>
                                <div class="input-group">
                                    <input type="file"
                                        class="form-control @error('attachment_gumasta') is-invalid @enderror"
                                        id="attachment_gumasta" name="attachment_gumasta"
                                        accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                                        onchange="uploadTempFile(this, 'attachment_gumasta')">
                                    <button class="btn btn-outline-danger" type="button"
                                        onclick="document.getElementById('attachment_gumasta').value = ''">✕</button>
                                </div>
                                @error('attachment_gumasta')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <input type="hidden" id="attachment_gumasta_url"
                                    value="{{ old('attachment_gumasta_url') }}" name="attachment_gumasta_url">

                                @if ($company->attachment_gumasta_url)
                                    <div id="attachment_gumasta_preview" class="position-relative d-inline-block">
                                        <img src="{{ $company->attachment_gumasta_url }}" class="rounded">

                                        <!-- Remove (X) button -->
                                        <button type="button"
                                            class="btn btn-sm btn-danger position-absolute bottom-0 start-100 translate-middle"
                                            onclick="removeImage('attachment_gumasta')">
                                            ✕
                                        </button>
                                    </div>
                                @elseif (old('attachment_gumasta_url'))
                                    <div id="attachment_gumasta_preview" class="position-relative d-inline-block">
                                        <img src="{{ old('attachment_gumasta_url') }}" class="rounded">

                                        <!-- Remove (X) button -->
                                        <button type="button"
                                            class="btn btn-sm btn-danger position-absolute bottom-0 start-100 translate-middle"
                                            onclick="removeImage('attachment_gumasta')">
                                            ✕
                                        </button>
                                    </div>
                                @endif
                            </div>


                            {{-- MSME Certificate --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">MSME Certificate</label>
                                <div class="input-group">
                                    <input type="file"
                                        class="form-control @error('attachment_msme') is-invalid @enderror"
                                        id="attachment_msme" name="attachment_msme"
                                        accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                                        onchange="uploadTempFile(this, 'attachment_msme')">

                                    <button class="btn btn-outline-danger" type="button"
                                        onclick="document.getElementById('attachment_msme').value = ''">✕</button>
                                </div>


                                @error('attachment_msme')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror

                                <input type="hidden" id="attachment_msme_url" value="{{ old('attachment_msme_url') }}"
                                    name="attachment_msme_url">

                                @if ($company->attachment_msme_url)
                                    <div id="attachment_msme_preview" class="position-relative d-inline-block">
                                        <img src="{{ $company->attachment_msme_url }}" class="rounded">

                                        <!-- Remove (X) button -->
                                        <button type="button"
                                            class="btn btn-sm btn-danger position-absolute bottom-0 start-100 translate-middle"
                                            onclick="removeImage('attachment_msme')">
                                            ✕
                                        </button>
                                    </div>
                                @elseif (old('attachment_msme_url'))
                                    <div id="attachment_msme_preview" class="position-relative d-inline-block">
                                        <img src="{{ old('attachment_msme_url') }}" class="rounded">

                                        <!-- Remove (X) button -->
                                        <button type="button"
                                            class="btn btn-sm btn-danger position-absolute bottom-0 start-100 translate-middle"
                                            onclick="removeImage('attachment_msme')">
                                            ✕
                                        </button>
                                    </div>
                                @endif
                            </div>


                        </div>


                    </div>
                </div>
            </div>

            {{-- Bank details --}}
            <div class="col-md-12 d-flex">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Bank details</h5>
                        <small class="text-muted float-end">Bank Information</small>
                    </div>
                    <div class="card-body">
                        <div id="bankDetailsWrapper">

                            @if ($bankDetails && $bankDetails->count() > 0)
                                @foreach ($bankDetails as $index => $bank)
                                    <div class="bank-details-row row g-3 mb-3 bg-light position-relative">

                                        {{-- IFSC --}}
                                        <div class="col-md-3">
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
                                        <div class="col-md-3">
                                            <label class="form-label">Account No</label>
                                            <input type="text" name="banks[{{ $loop->index }}][account_number]"
                                                value="{{ old('banks.' . $loop->index . '.account_number', $bank->account_number) }}"
                                                class="form-control account_number @error('banks.' . $loop->index . '.account_number') is-invalid @enderror"
                                                maxlength="18" placeholder="Enter Account Number">
                                            @error('banks.' . $loop->index . '.account_number')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        {{-- Account Type --}}
                                        <div class="col-md-3">
                                            <label class="form-label">Account Type</label>
                                            <select name="banks[{{ $loop->index }}][account_type]"
                                                class="form-select @error('banks.' . $loop->index . '.account_type') is-invalid @enderror">

                                                <option value="">Select Type</option>

                                                <option value="savings"
                                                    {{ old('banks.' . $loop->index . '.account_type', $bank->account_type) == 'savings' ? 'selected' : '' }}>
                                                    Saving Account
                                                </option>

                                                <option value="current"
                                                    {{ old('banks.' . $loop->index . '.account_type', $bank->account_type) == 'current' ? 'selected' : '' }}>
                                                    Current Account
                                                </option>

                                                <option value="od_cc"
                                                    {{ old('banks.' . $loop->index . '.account_type', $bank->account_type) == 'od_cc' ? 'selected' : '' }}>
                                                    Overdraft/CC
                                                </option>

                                                <option value="nre"
                                                    {{ old('banks.' . $loop->index . '.account_type', $bank->account_type) == 'nre' ? 'selected' : '' }}>
                                                    NRE
                                                </option>

                                                <option value="nri"
                                                    {{ old('banks.' . $loop->index . '.account_type', $bank->account_type) == 'nri' ? 'selected' : '' }}>
                                                    NRI
                                                </option>

                                                <option value="nro"
                                                    {{ old('banks.' . $loop->index . '.account_type', $bank->account_type) == 'nro' ? 'selected' : '' }}>
                                                    NRO
                                                </option>

                                                <option value="tem_deposit"
                                                    {{ old('banks.' . $loop->index . '.account_type', $bank->account_type) == 'tem_deposit' ? 'selected' : '' }}>
                                                    Term Deposit
                                                </option>

                                                <option value="ra"
                                                    {{ old('banks.' . $loop->index . '.account_type', $bank->account_type) == 'ra' ? 'selected' : '' }}>
                                                    Recurring
                                                </option>

                                            </select>
                                            @error('banks.' . $loop->index . '.account_type')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        {{-- Bank Name --}}
                                        <div class="col-md-3">
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
                                        <div class="col-md-3">
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
                                        <div class="col-md-3">
                                            <label class="form-label">Bank Code</label>
                                            <input type="text" name="banks[{{ $loop->index }}][bank_code]"
                                                value="{{ old('banks.' . $loop->index . '.bank_code', $bank->bank_code) }}"
                                                class="form-control bank_code bg-secondary-subtle bg-gradient @error('banks.' . $loop->index . '.bank_code') is-invalid @enderror"
                                                readonly>
                                            @error('banks.' . $loop->index . '.bank_code')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        {{-- Primary Checkbox --}}
                                        <div class="col-md-3">
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

                                    </div>
                                @endforeach
                            @else
                                {{-- One empty row when no banks exist --}}
                                <div class="bank-details-row row g-3 mb-3 bg-light position-relative">

                                    <div class="col-md-3">
                                        <label class="form-label">IFSC Code</label>
                                        <input type="text" name="banks[0][ifsc_code]"
                                            value="{{ old('banks.0.ifsc_code') }}"
                                            class="form-control ifsc_code @error('banks.0.ifsc_code') is-invalid @enderror">
                                        @error('banks.0.ifsc_code')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label">Account No</label>
                                        <input type="text" name="banks[0][account_number]"
                                            value="{{ old('banks.0.account_number') }}"
                                            class="form-control account_number @error('banks.0.account_number') is-invalid @enderror"
                                            maxlength="18">
                                        @error('banks.0.account_number')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label">Account Type</label>
                                        <select name="banks[0][account_type]"
                                            class="form-select @error('banks.0.account_type') is-invalid @enderror">
                                            <option value="">Select Type</option>
                                            <option value="savings"
                                                {{ old('banks.0.account_type') == 'savings' ? 'selected' : '' }}>Saving
                                                Account</option>
                                            <option value="current"
                                                {{ old('banks.0.account_type') == 'current' ? 'selected' : '' }}>Current
                                                Account</option>
                                            <option value="od_cc"
                                                {{ old('banks.0.account_type') == 'od_cc' ? 'selected' : '' }}>
                                                Overdraft/CC</option>
                                            <option value="nre"
                                                {{ old('banks.0.account_type') == 'nre' ? 'selected' : '' }}>NRE</option>
                                            <option value="nri"
                                                {{ old('banks.0.account_type') == 'nri' ? 'selected' : '' }}>NRI</option>
                                            <option value="nro"
                                                {{ old('banks.0.account_type') == 'nro' ? 'selected' : '' }}>NRO</option>
                                            <option value="tem_deposit"
                                                {{ old('banks.0.account_type') == 'tem_deposit' ? 'selected' : '' }}>Term
                                                Deposit</option>
                                            <option value="ra"
                                                {{ old('banks.0.account_type') == 'ra' ? 'selected' : '' }}>Recurring
                                            </option>
                                        </select>
                                        @error('banks.0.account_type')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label">Bank Name</label>
                                        <input type="text" name="banks[0][bank_name]"
                                            value="{{ old('banks.0.bank_name') }}"
                                            class="form-control bank_name bg-secondary-subtle bg-gradient @error('banks.0.bank_name') is-invalid @enderror"
                                            readonly>
                                        @error('banks.0.bank_name')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label">Branch Name</label>
                                        <input type="text" name="banks[0][branch_name]"
                                            value="{{ old('banks.0.branch_name') }}"
                                            class="form-control branch_name bg-secondary-subtle bg-gradient @error('banks.0.branch_name') is-invalid @enderror"
                                            readonly>
                                        @error('banks.0.branch_name')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label">Bank Code</label>
                                        <input type="text" name="banks[0][bank_code]"
                                            value="{{ old('banks.0.bank_code') }}"
                                            class="form-control bank_code bg-secondary-subtle bg-gradient @error('banks.0.bank_code') is-invalid @enderror"
                                            readonly>
                                        @error('banks.0.bank_code')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label d-block">Primary a/c</label>
                                        <input type="hidden" name="banks[0][is_primary]" value="0">
                                        <input type="checkbox" name="banks[0][is_primary]" value="1"
                                            class="form-check-input setPrimary @error('banks.0.is_primary') is-invalid @enderror"
                                            {{ old('banks.0.is_primary') ? 'checked' : '' }}>
                                        @error('banks.0.is_primary')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
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
        <!-- Submit -->
        <div class="text-end mt-3">
            <button type="submit" class="btn btn-primary px-4">Update</button>
            <a href="{{ route('master.companies.index') }}" class="btn btn-secondary px-4">Cancel</a>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            // Firm WhatsApp same as mobile
            $('.chkbox_fwapp_same_as_mobile').on('change', function() {
                if ($(this).is(':checked')) {
                    $('#whatsapp_no').val($('#phone').val());
                } else {
                    $('#whatsapp_no').val('');
                }
            });

            // Proprietor WhatsApp same as mobile
            $('.chkbox_prop_wa_same_as_mobile').on('change', function() {
                if ($(this).is(':checked')) {
                    $('#proprietor_whatsapp').val($('#proprietor_phone').val());
                } else {
                    $('#proprietor_whatsapp').val('');
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
                let savedCityRes = "{{ $company->res_city_code }}";
                let savedCity = "{{ $company->office_city_code }}";

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
