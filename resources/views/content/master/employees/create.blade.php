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
        <span class="text-muted fw-light">Master /</span> <a href="{{ route('master.companies.index') }}">Employee</a>
    </h4>


    <form action="{{ route('master.employees.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('post')

        <input type="hidden" name="res_country" id="res_country">
        <input type="hidden" name="res_state" id="res_state">
        <input type="hidden" name="res_city" id="res_city">


        <div class="row align-items-stretch">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Primary Information</h5>
                        <small class="text-muted float-end">Employee Basic Details</small>
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <!-- Full Name -->
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Full Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name') }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <!-- Gender -->
                            <div class="col-md-2 mb-3">
                                <label class="form-label d-block">Gender</label>
                                <div class="btn-group w-100" role="group" aria-label="Gender toggle">
                                    <input type="radio" class="btn-check" name="gender" id="male" value="male"
                                        {{ old('gender', 'male') == 'male' ? 'checked' : '' }}>
                                    <label class="btn btn-outline-primary" for="male">Male</label>

                                    <input type="radio" class="btn-check" name="gender" id="female" value="female"
                                        {{ old('gender') == 'female' ? 'checked' : '' }}>
                                    <label class="btn btn-outline-primary" for="female">Female</label>
                                </div>
                                @error('gender')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="w-100"></div>
                            <!-- Date of Birth -->
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Date of Birth</label>
                                <input type="text" class="form-control datepicker @error('dob') is-invalid @enderror"
                                    name="dob" value="{{ old('dob') }}"  placeholder="Select Date">
                                @error('dob')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text" class="form-control onlyphone @error('phone') is-invalid @enderror"
                                    id="phone" name="phone" maxlength="10" value="{{ old('phone') }}">

                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="email">Email</label>
                                <input type="email" class="form-control no-uppercase @error('email') is-invalid @enderror"
                                    name="email" id="email" value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Aadhar -->
                            <div class="col-md-2 mb-3">
                                <label class="form-label" for="aadhar">Aadhar Number</label>
                                <input type="text" class="form-control onlydigit @error('aadhar') is-invalid @enderror"
                                    name="aadhar" id="aadhar" value="{{ old('aadhar') }}" maxlength="12">
                                @error('aadhar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- PAN -->
                            <div class="col-md-2 mb-3">
                                <label class="form-label" for="pan">PAN Number</label>
                                <input type="text" class="form-control @error('pan') is-invalid @enderror" id="pan"
                                    name="pan" maxlength="10" value="{{ old('pan') }}"
                                    oninput="this.value = this.value.toUpperCase()"
                                    onblur="validatePAN(this.value,'errpancardno')">
                                @error('pan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>


                        {{-- address section --}}
                        <div class="row my-3">
                            <!-- Residential Address -->
                            <h6> Address</h6>
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

                        </div>



                        <div class="row my-3">

                            <!-- Branch -->
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Branch</label>
                                <select name="branch_id" class="form-select @error('branch_id') is-invalid @enderror">
                                    <option value="">Select Branch</option>
                                    <option value="1" {{ old('branch_id') == 1 ? 'selected' : '' }}>Thane
                                    </option>
                                    <option value="2" {{ old('branch_id') == 2 ? 'selected' : '' }}>Goa
                                    </option>
                                </select>
                                @error('branch_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Department -->
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Department</label>
                                <select name="deptment_id"
                                    class="form-select @error('deptment_id') is-invalid @enderror">
                                    <option value="">Select Department</option>
                                    <option value="1" {{ old('deptment_id') == 1 ? 'selected' : '' }}>HR
                                    </option>
                                    <option value="2" {{ old('deptment_id') == 2 ? 'selected' : '' }}>Finance
                                    </option>
                                </select>
                                @error('deptment_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Designation -->
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Designation</label>
                                <select name="designation_id"
                                    class="form-select @error('designation_id') is-invalid @enderror">
                                    <option value="">Select Designation</option>
                                    <option value="1" {{ old('designation_id') == 1 ? 'selected' : '' }}>
                                        Manager</option>
                                    <option value="2" {{ old('designation_id') == 2 ? 'selected' : '' }}>
                                        Executive</option>
                                </select>
                                @error('designation_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Joining Date -->
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Joining Date</label>
                                <input type="text"
                                    class="form-control datepicker @error('joining_date') is-invalid @enderror"
                                    name="joining_date" value="{{ old('joining_date') }}" placeholder="Select Date"
                                    readonly>
                                @error('joining_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- <!-- Resign Date -->
                                    <div class="col-md-3">
                                        <label class="form-label">Resign Date</label>
                                        <input type="date"
                                            class="form-control @error('resign_date') is-invalid @enderror"
                                            name="resign_date" value="{{ old('resign_date') }}">
                                        @error('resign_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div> --}}

                            <!-- Probation Period -->
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Probation Period in days</label>
                                <input type="text"
                                    class="form-control onlydidigt @error('probation_date') is-invalid @enderror"
                                    name="probation_date" value="{{ old('probation_date') }}" maxlength="3">
                                @error('probation_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Notice Period -->
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Notice Period in days</label>
                                <input type="text"
                                    class="form-control onlydigit @error('notice_date') is-invalid @enderror"
                                    name="notice_date" value="{{ old('notice_date') }}" maxlength="3">
                                @error('notice_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div class="col-md-2 mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="contract"
                                        {{ old('status', 'contract') == 'contract' ? 'selected' : '' }}>Contract
                                    </option>
                                    <option value="permanent" {{ old('status') == 'permanent' ? 'selected' : '' }}>
                                        Permanent</option>
                                    <option value="probation" {{ old('status') == 'probation' ? 'selected' : '' }}>
                                        Probation</option>
                                    <option value="intern" {{ old('status') == 'intern' ? 'selected' : '' }}>
                                        Intern</option>
                                </select>
                                @error('status')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>


                            <!-- Reporting manager -->
                            <div class="col-md-2 mb-3">
                                <label for="status" class="form-label">Reporting manager</label>
                                <select name="reporting_manager" id="reporting_manager" class="form-select">
                                    <option value=""></option>
                                </select>
                                @error('reporting_manager')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>


                            <!-- role -->
                            <div class="col-md-2 mb-3">
                                <label for="status" class="form-label">Role</label>
                                <select name="role" id="role" class="form-select">
                                    <option value=""></option>
                                </select>
                                @error('role')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2 mb-3 d-none">
                                <label for="status" class="form-label">Previous Salary Amount</label>

                                <input type="text" name="prev_salary" id="prev_salary" class="form-control" maxlength="6"
                                    value="{{ old('prev_salary') }}">
                                @error('prev_salary')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>
                </div>
            </div>



            {{-- Salary details --}}
            <div class="col-md-6 d-flex">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Salary details</h5>
                        <small class="text-muted float-end">Salary information</small>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <!-- Basic Salary -->
                            <div class="col-md-6 mb-3">
                                <label for="basic_salary" class="form-label">Basic Salary</label>
                                <input type="text"
                                    class="form-control onlydigit @error('basic_salary') is-invalid @enderror"
                                    name="basic_salary" id="basic_salary" value="{{ old('basic_salary') }}"
                                    step="0.01" min="0" maxlength="6">
                                @error('basic_salary')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- HRA -->
                            <div class="col-md-6 mb-3">
                                <label for="hra" class="form-label">HRA</label>
                                <input type="text" class="form-control onlydigit @error('hra') is-invalid @enderror"
                                    name="hra" id="hra" value="{{ old('hra') }}" step="0.01"
                                    min="0" maxlength="5">
                                @error('hra')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- travel_allowance -->
                            <div class="col-md-6 mb-3">
                                <label for="travel_allowance" class="form-label">travel allowance</label>
                                <input type="text"
                                    class="form-control onlydigit @error('travel_allowance') is-invalid @enderror"
                                    name="travel_allowance" id="travel_allowance" value="{{ old('travel_allowance') }}"
                                    step="0.01" min="0" maxlength="5">
                                @error('travel_allowance')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- conveyance_allowance -->
                            <div class="col-md-6 mb-3">
                                <label for="conveyance_allowance" class="form-label">conveyance allowance</label>
                                <input type="text"
                                    class="form-control onlydigit @error('conveyance_allowance') is-invalid @enderror"
                                    name="conveyance_allowance" id="conveyance_allowance"
                                    value="{{ old('conveyance_allowance') }}" step="0.01" min="0" maxlength="5">
                                @error('conveyance_allowance')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>




                            <!-- medical_allowance -->
                            <div class="col-md-6 mb-3">
                                <label for="medical_allowance" class="form-label">medical allowance</label>
                                <input type="text"
                                    class="form-control onlydigit @error('medical_allowance') is-invalid @enderror"
                                    name="medical_allowance" id="medical_allowance"
                                    value="{{ old('medical_allowance') }}" step="0.01" min="0" maxlength="5">
                                @error('medical_allowance')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- bonus -->
                            <div class="col-md-6 mb-3">
                                <label for="bonus" class="form-label">bonus</label>
                                <input type="text" class="form-control onlydigit @error('bonus') is-invalid @enderror"
                                    name="bonus" id="bonus" value="{{ old('bonus') }}" step="0.01"
                                    min="0" maxlength="5">
                                @error('bonus')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Other Allowances -->
                            <div class="col-md-6 mb-3">
                                <label for="other_allowances" class="form-label">Other Allowances</label>
                                <input type="text"
                                    class="form-control onlydigit @error('other_allowances') is-invalid @enderror"
                                    name="other_allowances" id="other_allowances" value="{{ old('other_allowances') }}"
                                    step="0.01" min="0" maxlength="5">
                                @error('other_allowances')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
                                <label class="form-label">employee photo Attachment</label>
                                <div class="input-group">
                                    <input type="file"
                                        class="form-control @error('attachement_employee_photo') is-invalid @enderror"
                                        id="attachement_employee_photo" name="attachement_employee_photo"
                                        accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                    <button class="btn btn-outline-danger" type="button"
                                        onclick="document.getElementById('attachement_employee_photo').value = ''">✕</button>
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
                                @error('attachment_pan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">release later Attachment</label>
                                <div class="input-group">
                                    <input type="file"
                                        class="form-control @error('attachment_release_letter') is-invalid @enderror"
                                        id="attachment_release_letter" name="attachment_release_letter"
                                        accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                    <button class="btn btn-outline-danger" type="button"
                                        onclick="document.getElementById('attachment_release_letter').value = ''">✕</button>
                                </div>
                                @error('attachment_tan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">experance letter Attachment</label>
                                <div class="input-group">
                                    <input type="file"
                                        class="form-control @error('attachment_expereance') is-invalid @enderror"
                                        id="attachment_expereance" name="attachment_expereance"
                                        accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                    <button class="btn btn-outline-danger" type="button"
                                        onclick="document.getElementById('attachment_expereance').value = ''">✕</button>
                                </div>
                                @error('attachment_gstin')
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
                                @error('attachment_ckyc')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Upload CV Attachment</label>
                                <div class="input-group">
                                    <input type="file"
                                        class="form-control @error('attachment_cv') is-invalid @enderror"
                                        id="attachment_cv" name="attachment_cv" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                    <button class="btn btn-outline-danger" type="button"
                                        onclick="document.getElementById('attachment_cv').value = ''">✕</button>
                                </div>
                                @error('attachment_cv')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>
                </div>
            </div>


            {{-- Bank details --}}
            <div class="col-12 d-flex">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Bank Section</h5>
                        <small class="text-muted float-end">Bank Information</small>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- IFSC -->
                            <div class="col-md-2 mt-3">
                                <label class="form-label">IFSC Code</label>
                                <input type="text"id="ifsc_code" name="ifsc_code" value="{{ old('ifsc_code') }}"
                                    class="form-control ifsc_code @error('ifsc_code') is-invalid @enderror"
                                    placeholder="Enter IFSC Code">
                                @error('ifsc_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Account No -->
                            <div class="col-md-2 mt-3">
                                <label class="form-label">Account No</label>
                                <input type="text" id="account_number" name="account_number"
                                    value="{{ old('account_number') }}"
                                    class="form-control account_number @error('account_number') is-invalid @enderror"
                                    placeholder="Enter Account Number" maxlength="15">
                                @error('account_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- MICR -->
                            <div class="col-md-2 mt-3">
                                <label class="form-label">MICR Code</label>
                                <input type="text" name="micrcode" value="{{ old('micrcode') }}"
                                    class="form-control micrcode bg-secondary-subtle bg-gradient @error('micrcode') is-invalid @enderror"
                                    readonly>
                                @error('micrcode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Bank Name -->
                            <div class="col-md-2 mt-3">
                                <label class="form-label">Bank Name</label>
                                <input type="text" name="bank_name" value="{{ old('bank_name') }}"
                                    class="form-control bank_name bg-secondary-subtle bg-gradient @error('bank_name') is-invalid @enderror"
                                    readonly>
                                @error('bank_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Branch Name -->
                            <div class="col-md-2 mt-3">
                                <label class="form-label">Branch Name</label>
                                <input type="text" name="branch_name" value="{{ old('branch_name') }}"
                                    class="form-control branch_name bg-secondary-subtle bg-gradient @error('branch_name') is-invalid @enderror"
                                    readonly>
                                @error('branch_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Bank Code -->
                            <div class="col-md-2 mt-3">
                                <label class="form-label">Bank Code</label>
                                <input type="text" name="bank_code" value="{{ old('bank_code') }}"
                                    class="form-control bank_code bg-secondary-subtle bg-gradient @error('bank_code') is-invalid @enderror"
                                    readonly>
                                @error('bank_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Cheque Photo -->
                            <div class="col-md-3 mt-3">
                                <label class="form-label">Cheque Photo</label>

                                <div class="input-group">
                                    <input type="file"
                                        class="form-control @error('attachment_cancelled_cheque') is-invalid @enderror"
                                        id="attachment_cancelled_cheque" name="attachment_cancelled_cheque"
                                        onchange="uploadTempFile(this, 'attachment_cancelled_cheque')"
                                        accept=".jpg,.jpeg,.png,.pdf">

                                    <button class="btn btn-outline-danger" type="button"
                                        onclick="document.getElementById('attachment_cancelled_cheque').value = ''">
                                        ✕
                                    </button>
                                </div>

                                @error('attachment_cancelled_cheque')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <input type="hidden" id="attachment_cancelled_cheque_url"
                                    name="attachment_cancelled_cheque_url"
                                    value="{{ old('attachment_cancelled_cheque_url') }}">

                                @if (old('attachment_cancelled_cheque_url'))
                                    <div id="attachment_cancelled_cheque_preview"
                                        class="position-relative d-inline-block mt-2">
                                        <img src="{{ old('attachment_cancelled_cheque_url') }}" width="100"
                                            class="rounded">

                                        <button type="button"
                                            class="btn btn-sm btn-danger position-absolute top-0 start-100 translate-middle"
                                            onclick="removeImage('attachment_cancelled_cheque')">
                                            ✕
                                        </button>
                                    </div>
                                @endif
                            </div>

                            <!-- Primary -->
                            <div class="col-md-4 mt-3">
                                <label class="form-label d-block">Primary a/c</label>

                                <input type="hidden" name="is_primary" value="0">

                                <input type="checkbox" name="is_primary"
                                    class="form-check-input setPrimary @error('is_primary') is-invalid @enderror"
                                    value="1" {{ old('is_primary') ? 'checked' : '' }}>

                                @error('is_primary')
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
            <a href="{{ route('master.employees.index') }}" class="btn btn-secondary px-4">Cancel</a>
        </div>
    </form>


@endsection

@push('scripts')
@endpush
