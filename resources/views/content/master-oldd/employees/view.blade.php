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
    <style>
        td {
            font-weight: bold;
        }
    </style>
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


    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Primary Information</h5>
            <small class="text-muted">Employee Basic Details</small>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-striped">

                <tr>
                    <th>ID</th>
                    <td>{{ $employee->id }}</td>
                    <th>Full Name</th>
                    <td>{{ $employee->name }}</td>
                </tr>

                <tr>
                    <th>Gender</th>
                    <td>{{ ucfirst($employee->gender) }}</td>
                    <th>Date of Birth</th>
                    <td>{{ $employee->dob }}</td>
                </tr>

                <tr>
                    <th>Phone</th>
                    <td>{{ $employee->phone }}</td>
                    <th>Email</th>
                    <td>{{ $employee->email }}</td>
                </tr>

                <tr>
                    <th>Aadhar Number</th>
                    <td>{{ $employee->aadhar }}</td>
                    <th>PAN Number</th>
                    <td>{{ $employee->pan }}</td>
                </tr>
                <!-- Full Address Row -->
                <tr>
                    <th>Address</th>
                    <td colspan="3">{{ $employee->res_address }},{{ $employee->res_country_code }},{{ $employee->res_state_code }},{{ $employee->res_city_code }},{{ $employee->res_pincode }}</td>
                </tr>

                <tr>
                    <th>Branch</th>
                    <td>{{ optional($employee->branch)->name }}</td>
                    <th>Department</th>
                    <td>{{ optional($employee->department)->name }}</td>
                </tr>

                <tr>
                    <th>Designation</th>
                    <td>{{ optional($employee->designation)->name }}</td>
                    <th>Joining Date</th>
                    <td>{{ $employee->joining_date }}</td>
                </tr>

                <tr>
                    <th>Probation Period</th>
                    <td>{{ $employee->probation_date }}</td>
                    <th>Notice Period</th>
                    <td>{{ $employee->notice_date }}</td>
                </tr>

                <tr>
                    <th>Status</th>
                    <td>{{ ucfirst($employee->status) }}</td>
                    <th></th>
                    <td></td>
                </tr>

            </table>

        </div>

    </div>

    {{-- Salary Details --}}
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Salary Details</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <tr>
                    <th>Basic Salary</th>
                    <td>{{ $employee->basic_salary }}</td>
                </tr>
                <tr>
                    <th>HRA</th>
                    <td>{{ $employee->hra }}</td>
                </tr>
                <tr>
                    <th>Travel Allowance</th>
                    <td>{{ $employee->travel_allowance }}</td>
                </tr>
                <tr>
                    <th>Conveyance Allowance</th>
                    <td>{{ $employee->conveyance_allowance }}</td>
                </tr>
                <tr>
                    <th>Medical Allowance</th>
                    <td>{{ $employee->medical_allowance }}</td>
                </tr>
                <tr>
                    <th>Bonus</th>
                    <td>{{ $employee->bonus }}</td>
                </tr>
                <tr>
                    <th>Other Allowances</th>
                    <td>{{ $employee->other_allowances }}</td>
                </tr>
            </table>
        </div>
    </div>

    {{-- Image Section --}}
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Image & Document Attachments</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">

                <tr>
                    <th>Employee Photo</th>
                    <td>
                        @if ($employee->attachement_employee_photo)
                            <a href="{{ asset('storage/' . $employee->attachement_employee_photo) }}" target="_blank">View
                                File</a>
                        @else
                            No file uploaded
                        @endif
                    </td>
                </tr>

                <tr>
                    <th>Aadhar Attachment</th>
                    <td>
                        @if ($employee->attachement_aadhar)
                            <a href="{{ asset('storage/' . $employee->attachement_aadhar) }}" target="_blank">View File</a>
                        @else
                            No file uploaded
                        @endif
                    </td>
                </tr>

                <tr>
                    <th>Release Letter</th>
                    <td>
                        @if ($employee->attachment_release_letter)
                            <a href="{{ asset('storage/' . $employee->attachment_release_letter) }}" target="_blank">View
                                File</a>
                        @else
                            No file uploaded
                        @endif
                    </td>
                </tr>

            </table>
        </div>
    </div>


@endsection

@push('scripts')
@endpush
