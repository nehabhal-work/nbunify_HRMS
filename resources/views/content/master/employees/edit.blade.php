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
        <span class="text-muted fw-light">Master /</span> Employee
    </h4>


    <div class="row">
        <div class="col-md-12">
            <div class1="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    {{-- <h5 class="mb-0">Create New Employee</h5> --}}
                </div>
                <div class="card-body">
                    <form action="#" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('POST')

                        <div class="card mb-2">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Employee Information</h5>
                                <small class="text-muted float-end">Employee Basic Details</small>
                            </div>
                            <div class="card-body">
                                <div class="row g-3 mt-3">

                                    <!-- Full Name -->
                                    <div class="col-md-4">
                                        <label class="form-label">Full Name</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            name="name" value="{{ old('name') }}">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <!-- Gender -->
                                    <div class="col-md-2">
                                        <label class="form-label d-block">Gender</label>
                                        <div class="btn-group w-100" role="group" aria-label="Gender toggle">
                                            <input type="radio" class="btn-check" name="gender" id="male"
                                                value="male" {{ old('gender', 'male') == 'male' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-primary" for="male">Male</label>

                                            <input type="radio" class="btn-check" name="gender" id="female"
                                                value="female" {{ old('gender') == 'female' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-primary" for="female">Female</label>
                                        </div>
                                        @error('gender')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="w-100"></div>
                                    <!-- Date of Birth -->
                                    <div class="col-md-2">
                                        <label class="form-label">Date of Birth</label>
                                        <input type="text" class="form-control datepicker @error('dob') is-invalid @enderror"
                                            name="dob" value="{{ old('dob') }}" readonly placeholder="Select Date">
                                        @error('dob')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Phone -->
                                    <div class="col-md-2">
                                        <label class="form-label">Phone</label>
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                            name="phone" value="{{ old('phone') }}">
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Email -->
                                    <div class="col-4">
                                        <label class="form-label" for="email">Email</label>
                                        <input type="email"
                                            class="form-control no-uppercase @error('email') is-invalid @enderror"
                                            name="email" id="email" value="{{ old('email') }}">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Aadhar -->
                                    <div class="col-2">
                                        <label class="form-label" for="aadhar">Aadhar Number</label>
                                        <input type="text" class="form-control @error('aadhar') is-invalid @enderror"
                                            name="aadhar" id="aadhar" value="{{ old('aadhar') }}">
                                        @error('aadhar')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- PAN -->
                                    <div class="col-2">
                                        <label class="form-label" for="pan">PAN Number</label>
                                        <input type="text" class="form-control @error('pan') is-invalid @enderror"
                                            name="pan" id="pan" value="{{ old('pan') }}">
                                        @error('pan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Address --}}
                                    <div class="col-6 ">
                                        <label class="form-label">Address</label>
                                        <input type="text" name="registered_address" id="registered_address"
                                            class="form-control @error('registered_address') is-invalid @enderror"
                                            value="{{ old('registered_address') }}">
                                        @error('registered_address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    {{-- State --}}
                                    <div class="col-md-2">
                                        <label class="form-label">State</label>
                                        <input type="text" name="registered_state" id="registered_state"
                                            class="form-control @error('registered_state') is-invalid @enderror"
                                            value="{{ old('registered_state') }}">
                                        @error('registered_state')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- City --}}
                                    <div class="col-md-2">
                                        <label class="form-label">City</label>
                                        <input type="text" name="registered_city" id="registered_city"
                                            class="form-control @error('registered_city') is-invalid @enderror"
                                            value="{{ old('registered_city') }}">
                                        @error('registered_city')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Postal Code --}}
                                    <div class="col-md-2">
                                        <label class="form-label">Postal Code</label>
                                        <input type="text" name="registered_pincode" id="registered_pincode"
                                            class="form-control onlydigit @error('registered_pincode') is-invalid @enderror"
                                            value="{{ old('registered_pincode') }}" maxlength="6">
                                        @error('registered_pincode')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>





                                    <!-- Branch -->
                                    <div class="col-md-2">
                                        <label class="form-label">Branch</label>
                                        <select name="branch_id"
                                            class="form-select @error('branch_id') is-invalid @enderror">
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
                                    <div class="col-md-2">
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
                                    <div class="col-md-2">
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
                                    <div class="col-md-2">
                                        <label class="form-label">Joining Date</label>
                                        <input type="text"
                                            class="form-control datepicker @error('joining_date') is-invalid @enderror"
                                            name="joining_date" value="{{ old('joining_date') }}" readonly placeholder="Select Date">
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
                                    <div class="col-md-2">
                                        <label class="form-label">Probation Period in days</label>
                                        <input type="text"
                                            class="form-control onlydidigt @error('probation_date') is-invalid @enderror"
                                            name="probation_date" value="{{ old('probation_date') }}">
                                        @error('probation_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Notice Period -->
                                    <div class="col-md-2">
                                        <label class="form-label">Notice Period in days</label>
                                        <input type="text"
                                            class="form-control onlydigit @error('notice_date') is-invalid @enderror"
                                            name="notice_date" value="{{ old('notice_date') }}">
                                        @error('notice_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Status -->
                                    <div class="col-md-2">
                                        <label for="status" class="form-label">Status</label>
                                        <select name="status" id="status" class="form-select">
                                            <option value="contract"
                                                {{ old('status', 'contract') == 'contract' ? 'selected' : '' }}>Contract
                                            </option>
                                            <option value="permanent"
                                                {{ old('status') == 'permanent' ? 'selected' : '' }}>Permanent</option>
                                            <option value="probation"
                                                {{ old('status') == 'probation' ? 'selected' : '' }}>Probation</option>
                                            <option value="intern" {{ old('status') == 'intern' ? 'selected' : '' }}>
                                                Intern</option>
                                        </select>
                                        @error('status')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <!-- Resign Reason -->
                                    {{-- <div class="col-md-6">
                                        <label class="form-label">Resign Reason</label>
                                        <input type="text"
                                            class="form-control @error('resign_reason') is-invalid @enderror"
                                            name="resign_reason" value="{{ old('resign_reason') }}">
                                        @error('resign_reason')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div> --}}
                                </div>
                            </div>


                        </div>

                        {{-- Bank details --}}
                        <div class="card my-4">
                            <div class="card-header">
                                <strong class="text-uppercase">Bank Details</strong>
                            </div>
                            <div class="card-body">
                                <div class="col-12">
                                    <div id="bankDetailsWrapper">
                                        <div class="bank-details-row row g-3 mb-3 bg-light position-relative">
                                            <div class="col-md-2">
                                                <label class="form-label">IFSC Code</label>
                                                <input type="text" name="banks[0][ifsc_code]"
                                                    class="form-control ifsc_code" placeholder="Enter IFSC Code">
                                                <span class="invalid-feedback errmsg"></span>
                                            </div>

                                            <div class="col-md-2">
                                                <label class="form-label">Account No</label>
                                                <input type="text" name="banks[0][account_number]"
                                                    class="form-control account_number"
                                                    placeholder="Enter Account Number">
                                            </div>

                                            <div class="col-md-3">
                                                <label class="form-label">Bank Name</label>
                                                <input type="text" name="banks[0][bank_name]"
                                                    class="form-control bank_name bg-secondary-subtle bg-gradient"
                                                    readonly>
                                            </div>

                                            <div class="col-md-2">
                                                <label class="form-label">Branch Name</label>
                                                <input type="text" name="banks[0][branch_name]"
                                                    class="form-control branch_name bg-secondary-subtle bg-gradient"
                                                    readonly>
                                            </div>

                                            <div class="col-md-2">
                                                <label class="form-label">Bank Code</label>
                                                <input type="text" name="banks[0][bank_code]"
                                                    class="form-control bank_code bg-secondary-subtle bg-gradient"
                                                    readonly>
                                            </div>

                                            <div class="col-md-1">
                                                <label class="form-label d-block">Primary</label>
                                                <input type="hidden" name="banks[0][is_primary]" value="0">
                                                <input type="checkbox" name="banks[0][is_primary]" value="1"
                                                    class="form-check-input setPrimary">
                                            </div>

                                            <div class="col-md-1 d-flex align-items-end">
                                                <button type="button" class="btn btn-danger btn-sm removeBankRow d-none">
                                                    <i class="bx bx-minus"></i> Remove
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        {{-- Salary details --}}
                        <div class="card my-4">
                            <div class="card-header">
                                <strong class="text-uppercase"> salary Details </strong>
                            </div>
                            <div class="card-body">
                                <div class="row g-3 mt-3">
                                    <!-- Employee ID -->
                                    <div class="col-md-3">
                                        <label for="employee_id" class="form-label">Employee ID</label>
                                        <input type="text"
                                            class="form-control @error('employee_id') is-invalid @enderror"
                                            name="employee_id" id="employee_id" value="{{ old('employee_id') }}">
                                        @error('employee_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Basic Salary -->
                                    <div class="col-md-3">
                                        <label for="basic_salary" class="form-label">Basic Salary</label>
                                        <input type="number"
                                            class="form-control @error('basic_salary') is-invalid @enderror"
                                            name="basic_salary" id="basic_salary" value="{{ old('basic_salary') }}"
                                            step="0.01" min="0">
                                        @error('basic_salary')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- HRA -->
                                    <div class="col-md-3">
                                        <label for="hra" class="form-label">HRA</label>
                                        <input type="number" class="form-control @error('hra') is-invalid @enderror"
                                            name="hra" id="hra" value="{{ old('hra') }}" step="0.01"
                                            min="0">
                                        @error('hra')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- DA -->
                                    <div class="col-md-3">
                                        <label for="da" class="form-label">DA</label>
                                        <input type="number" class="form-control @error('da') is-invalid @enderror"
                                            name="da" id="da" value="{{ old('da') }}" step="0.01"
                                            min="0">
                                        @error('da')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Other Allowances -->
                                    <div class="col-md-3">
                                        <label for="other_allowances" class="form-label">Other Allowances</label>
                                        <input type="number"
                                            class="form-control @error('other_allowances') is-invalid @enderror"
                                            name="other_allowances" id="other_allowances"
                                            value="{{ old('other_allowances') }}" step="0.01" min="0">
                                        @error('other_allowances')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Deductions -->
                                    <div class="col-md-3">
                                        <label for="deductions" class="form-label">Deductions</label>
                                        <input type="number"
                                            class="form-control @error('deductions') is-invalid @enderror"
                                            name="deductions" id="deductions" value="{{ old('deductions') }}"
                                            step="0.01" min="0">
                                        @error('deductions')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Gross Salary -->
                                    <div class="col-md-3">
                                        <label for="gross_salary" class="form-label">Gross Salary</label>
                                        <input type="number"
                                            class="form-control @error('gross_salary') is-invalid @enderror"
                                            name="gross_salary" id="gross_salary" value="{{ old('gross_salary') }}"
                                            step="0.01" min="0" readonly>
                                        @error('gross_salary')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Net Salary -->
                                    <div class="col-md-3">
                                        <label for="net_salary" class="form-label">Net Salary</label>
                                        <input type="number"
                                            class="form-control @error('net_salary') is-invalid @enderror"
                                            name="net_salary" id="net_salary" value="{{ old('net_salary') }}"
                                            step="0.01" min="0" readonly>
                                        @error('net_salary')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Effective From -->
                                    <div class="col-md-3">
                                        <label for="effective_from" class="form-label">Effective From</label>
                                        <input type="date"
                                            class="form-control @error('effective_from') is-invalid @enderror"
                                            name="effective_from" id="effective_from"
                                            value="{{ old('effective_from') }}">
                                        @error('effective_from')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Incentives -->
                                    <div class="col-md-3">
                                        <label for="incentives" class="form-label">Incentives</label>
                                        <input type="number"
                                            class="form-control @error('incentives') is-invalid @enderror"
                                            name="incentives" id="incentives" value="{{ old('incentives') }}"
                                            step="0.01" min="0">
                                        @error('incentives')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Advance Salary -->
                                    <div class="col-md-3">
                                        <label for="advance_salary" class="form-label">Advance Salary</label>
                                        <input type="number"
                                            class="form-control @error('advance_salary') is-invalid @enderror"
                                            name="advance_salary" id="advance_salary"
                                            value="{{ old('advance_salary') }}" step="0.01" min="0">
                                        @error('advance_salary')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Loan Deduction -->
                                    <div class="col-md-3">
                                        <label for="loan_deduction" class="form-label">Loan Deduction</label>
                                        <input type="number"
                                            class="form-control @error('loan_deduction') is-invalid @enderror"
                                            name="loan_deduction" id="loan_deduction"
                                            value="{{ old('loan_deduction') }}" step="0.01" min="0">
                                        @error('loan_deduction')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Loan Amount -->
                                    <div class="col-md-3">
                                        <label for="loan_amount" class="form-label">Loan Amount</label>
                                        <input type="number"
                                            class="form-control @error('loan_amount') is-invalid @enderror"
                                            name="loan_amount" id="loan_amount" value="{{ old('loan_amount') }}"
                                            step="0.01" min="0">
                                        @error('loan_amount')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>


                            <div class="m-4">
                                <button type="submit" class="btn btn-primary">submit</button>

                            </div>
                        </div>


                    </form>

                </div>
            </div>
        </div>


    </div>


@endsection
