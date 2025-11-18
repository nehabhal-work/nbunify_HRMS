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


    <form action="{{ route('master.companies.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('post')
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
                                <input type="text" class="form-control datepicker @error('dob') is-invalid @enderror" name="dob"
                                    value="{{ old('dob') }}" readonly placeholder="Select Date">
                                @error('dob')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                    name="phone" value="{{ old('phone') }}">
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
                                <input type="text" class="form-control @error('aadhar') is-invalid @enderror"
                                    name="aadhar" id="aadhar" value="{{ old('aadhar') }}">
                                @error('aadhar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- PAN -->
                            <div class="col-md-2 mb-3">
                                <label class="form-label" for="pan">PAN Number</label>
                                <input type="text" class="form-control @error('pan') is-invalid @enderror" name="pan"
                                    id="pan" value="{{ old('pan') }}">
                                @error('pan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Local Address -->
                            <h6 class="my-3">Local Address:</h6>
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

                            <!-- Corporate Address -->
                            <h6 class="my-3">Permanant Address:</h6>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Address</label>
                                <input type="text" name="corporate_address" id="corporate_address"
                                    class="form-control @error('corporate_address') is-invalid @enderror"
                                    value="{{ old('corporate_address') }}">
                                @error('corporate_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>



                            <div class="col-md-2 mb-3">
                                <label class="form-label">State</label>
                                <input type="text" name="corporate_state" id="corporate_state"
                                    class="form-control @error('corporate_state') is-invalid @enderror"
                                    value="{{ old('corporate_state') }}">
                                @error('corporate_state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2 mb-3">
                                <label class="form-label">City</label>
                                <input type="text" name="corporate_city" id="corporate_city"
                                    class="form-control @error('corporate_city') is-invalid @enderror"
                                    value="{{ old('corporate_city') }}">
                                @error('corporate_city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2 mb-3">
                                <label class="form-label">Pincode</label>
                                <input type="text" name="corporate_pincode" id="corporate_pincode"
                                    class="form-control onlydigit @error('corporate_pincode') is-invalid @enderror"
                                    value="{{ old('corporate_pincode') }}" maxlength="6">
                                @error('corporate_pincode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <hr>

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
                                <input type="text" class="form-control datepicker @error('joining_date') is-invalid @enderror"
                                    name="joining_date" value="{{ old('joining_date') }}" placeholder="Select Date" readonly>
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
                                    name="probation_date" value="{{ old('probation_date') }}">
                                @error('probation_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Notice Period -->
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Notice Period in days</label>
                                <input type="text"
                                    class="form-control onlydigit @error('notice_date') is-invalid @enderror"
                                    name="notice_date" value="{{ old('notice_date') }}">
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

                            <div class="col-md-2 mb-3">
                                <label for="status" class="form-label">Previous Salary Amount</label>
                              
                                <input type="text" name="prev_salary" id="prev_salary" class="form-control">
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
                                    step="0.01" min="0">
                                @error('basic_salary')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- HRA -->
                            <div class="col-md-6 mb-3">
                                <label for="hra" class="form-label">HRA</label>
                                <input type="text" class="form-control onlydigit @error('hra') is-invalid @enderror"
                                    name="hra" id="hra" value="{{ old('hra') }}" step="0.01"
                                    min="0">
                                @error('hra')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- travel_allowance -->
                            <div class="col-md-6 mb-3">
                                <label for="travel_allowance" class="form-label">travel allowance</label>
                                <input type="text"
                                    class="form-control onlydigit @error('travel_allowance') is-invalid @enderror"
                                    name="hra" id="travel_allowance" value="{{ old('travel_allowance') }}"
                                    step="0.01" min="0">
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
                                    value="{{ old('conveyance_allowance') }}" step="0.01" min="0">
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
                                    value="{{ old('medical_allowance') }}" step="0.01" min="0">
                                @error('medical_allowance')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- bonus -->
                            <div class="col-md-6 mb-3">
                                <label for="bonus" class="form-label">bonus</label>
                                <input type="text" class="form-control onlydigit @error('bonus') is-invalid @enderror"
                                    name="bonus" id="bonus" value="{{ old('bonus') }}" step="0.01"
                                    min="0">
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
                                    step="0.01" min="0">
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
                                        id="attachment_cv" name="attachment_cv"
                                        accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
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
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Bank details</h5>
                        <small class="text-muted float-end">BankInformation</small>
                    </div>
                    <div class="card-body">
                        <div class="col-12 ">

                            <div id="bankDetailsWrapper">

                                <div class="bank-details-row row g-3 mb-3 bg-light position-relative">
                                    <div class="col-md-2 mb-3">
                                        <label class="form-label">IFSC Code</label>
                                        <input type="text" name="banks[0][ifsc_code]" class="form-control ifsc_code"
                                            placeholder="Enter IFSC Code">
                                        <span class="invalid-feedback errmsg"></span>
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Account No</label>
                                        <input type="text" name="banks[0][account_number]"
                                            class="form-control account_number" placeholder="Enter Account Number">
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Bank Name</label>
                                        <input type="text" name="banks[0][bank_name]"
                                            class="form-control bank_name bg-secondary-subtle bg-gradient" readonly>
                                    </div>

                                    <div class="col-md-2 mb-3">
                                        <label class="form-label">Branch Name</label>
                                        <input type="text" name="banks[0][branch_name]"
                                            class="form-control branch_name bg-secondary-subtle bg-gradient" readonly>
                                    </div>

                                    <div class="col-md-2 mb-3">
                                        <label class="form-label">Bank Code</label>
                                        <input type="text" name="banks[0][bank_code]"
                                            class="form-control bank_code bg-secondary-subtle bg-gradient" readonly>
                                    </div>

                                    <div hidden class="col-md-1 mb-3">
                                        <label class="form-label d-block">Primary</label>
                                        <input type="hidden" name="banks[0][is_primary]" value="0">
                                        <input type="checkbox" name="banks[0][is_primary]" value="1"
                                            class="form-check-input setPrimary" checked>
                                    </div>

                                    <div class="col-md-1 d-flex align-items-end">
                                        <button type="button" class="btn btn-danger btn-sm removeBankRow d-none">
                                            <i class="bx bx-minus"></i> Remove
                                        </button>
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


        </div>



        <!-- Submit -->
        <div class="text-end mt-3">
            <button type="submit" class="btn btn-primary px-4">Save</button>
            <a href="{{ route('master.companies.index') }}" class="btn btn-secondary px-4">Cancel</a>
        </div>
    </form>


@endsection

@push('scripts')
@endpush
