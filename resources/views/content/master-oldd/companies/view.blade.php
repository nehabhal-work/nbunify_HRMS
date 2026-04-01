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




    <div class="row align-items-stretch">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Primary Information</h5>
                    <small class="text-muted float-end">Company Basic Details</small>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th colspan="4" class="text-center" style="background-color: #f4ebfc;">Personal
                                        Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>ID</th>
                                    <td><b>{{ $company->id }}</b></td>
                                    <th>Company Name</th>
                                    <td><b>{{ $company->name }}</b></td>
                                </tr>
                                <tr>
                                    <th>Company brand Name </th>
                                    <td><b>{{ ucfirst($company->brand_name) }}</b></td>
                                    <th>Establishment Date</th>
                                    <td><b>{{ $company->est_date }}</b></td>
                                </tr>
                                <tr>
                                    <th>Contact Person Name</th>
                                    <td><b>{{ ucfirst($company->contact_person_name) }}</b></td>
                                    <th>Contact Person Number</th>
                                    <td><b>{{ $company->phone }}</b></td>
                                </tr>
                                <tr>
                                    <th>Contact Person Email</th>
                                    <td><b>{{ ucfirst($company->email) }}</b></td>
                                    <th>Contact Person WhatsApp Number</th>
                                    <td><b>{{ strtoupper($company->whatsapp_no) }}</b></td>
                                </tr>
                                <tr>
                                    <th>Proprietor Name</th>
                                    <td><b>{{ ucfirst(str_replace('_', ' ', $company->proprietor_name)) }}</b>
                                    </td>
                                    <th>Proprietor Contact Number</th>
                                    <td><b>{{ $company->proprietor_phone }}</b></td>
                                </tr>
                                <tr>
                                    <th>Proprietor Email</th>
                                    <td><b>{{ $company->proprietor_email }}</b></td>
                                    <th>Proprietor WhatsApp Number</th>
                                    <td><b>{{ $company->proprietor_whatsapp }}</b></td>
                                </tr>

                            </tbody>

                            <!-- Residential Section -->
                            <thead class="table-light">
                                <tr>
                                    <th colspan="4" class="text-center" style="background-color: #f4ebfc;">Residential
                                        Address</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>Address</th>
                                    <td colspan="3"><b>{{ $company->registered_address }}</b></td>
                                </tr>
                                <tr>
                                    <th>State</th>
                                    <td><b>{{ $company->registered_state }}</b></td>
                                    <th>City</th>
                                    <td><b>{{ $company->registered_city }}</b></td>
                                </tr>
                                <tr>
                                    <th>Pincode</th>
                                    <td><b>{{ $company->registered_pincode }}</b></td>
                                </tr>
                            </tbody>

                            <!-- Office Section -->
                            <thead class="table-light">
                                <tr>
                                    <th colspan="4" class="text-center" style="background-color: #f4ebfc;">Corporate
                                        Address</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>Address</th>
                                    <td colspan="3"><b>{{ $company->corporate_address }}</b></td>
                                </tr>
                                <tr>

                                    <th>State</th>
                                    <td><b>{{ $company->corporate_state }}</b></td>
                                    <th>City</th>
                                    <td><b>{{ $company->corporate_city }}</b></td>
                                </tr>
                                <tr>

                                    <th>Pincode</th>
                                    <td><b>{{ $company->corporate_pincode }}</b></td>
                                </tr>
                            </tbody>

                            <!-- Additional  Address Section -->
                            <thead class="table-light">
                                <tr>
                                    <th colspan="4" class="text-center" style="background-color: #f4ebfc;">Additional
                                        Address For GST
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>Address</th>
                                    <td colspan="3"><b>{{ $company->additional_address }}</b></td>
                                </tr>
                                <tr>

                                    <th>State</th>
                                    <td><b>{{ $company->additional_state }}</b></td>
                                    <th>City</th>
                                    <td><b>{{ $company->additional_city }}</b></td>
                                </tr>
                                <tr>

                                    <th>Pincode</th>
                                    <td><b>{{ $company->additional_pincode }}</b></td>
                                </tr>
                            </tbody>
                            <!-- Official Identification Numbers -->
                            <thead class="table-light">
                                <tr>
                                    <th colspan="4" class="text-center" style="background-color: #f4ebfc;">Official
                                        Identification
                                        Numbers</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>Aadhar Number</th>
                                    <td><b>{{ $company->aadhar_no }}</b></td>
                                    <th>PAN Number</th>
                                    <td><b>{{ $company->pan_no }}</b></td>
                                </tr>
                                <tr>
                                    <th>TAN Number</th>
                                    <td><b>{{ $company->tan_no }}</b></td>
                                    <th>CKYC Number</th>
                                    <td><b>{{ $company->ckyc }}</b></td>

                                </tr>
                                <tr>
                                    <th>GSTIN</th>
                                    <td><b>{{ $company->gstin }}</b></td>
                                    <th>Udyam Aadhar Number</th>
                                    <td><b>{{ $company->udyam_aadhar_no }}</b></td>

                                </tr>
                                <tr>
                                    <th>MSME Certification Number</th>
                                    <td><b>{{ $company->msme_certification_no }}</b></td>
                                    <th>Gumasta Number</th>
                                    <td><b>{{ $company->gumasta_no }}</b></td>
                                </tr>
                            </tbody>

                            <!-- Attachments Section -->
                            <thead class="table-light">
                                <tr>
                                    <th colspan="4" class="text-center" style="background-color: #f4ebfc;">Attachments
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>Logo Attachment</th>
                                    <td>

                                        @if ($company->logo_url)
                                            <a href="{{ $company->logo_url }}" target="_blank">
                                                <img src="{{ $company->logo_url }}" alt="" width="80">
                                            </a>
                                        @endif
                                    </td>
                                    <th>Aadhar Attachment</th>
                                    <td>
                                        @if ($company->attachment_aadhar_url)
                                            <a href="{{ $company->attachment_aadhar_url }}" target="_blank">
                                                <img src="{{ $company->attachment_aadhar_url }}" alt=""
                                                    width="80">
                                            </a>
                                        @endif
                                    </td>

                                </tr>
                                <tr>
                                    <th>PAN Attachment</th>
                                    <td>
                                        @if ($company->attachment_pan_url)
                                            <a href="{{ $company->attachment_pan_url }}" target="_blank">
                                                <img src="{{ $company->attachment_pan_url }}" alt=""
                                                    width="80">
                                            </a>
                                        @endif
                                    </td>
                                    <th>TAN Attachment</th>
                                    <td>
                                        @if ($company->attachment_tan_url)
                                            <a href="{{ $company->attachment_tan_url }}" target="_blank">
                                                <img src="{{ $company->attachment_tan_url }}" alt=""
                                                    width="80">
                                            </a>
                                        @endif
                                    </td>

                                </tr>
                                <tr>
                                    <th>CKYC Attachment</th>
                                    <td>
                                        @if ($company->attachment_ckyc_url)
                                            <a href="{{ $company->attachment_ckyc_url }}" target="_blank">
                                                <img src="{{ $company->attachment_ckyc_url }}" alt=""
                                                    width="80">
                                            </a>
                                        @endif
                                    </td>
                                    <th>GSTIN Attachment</th>
                                    <td>
                                        @if ($company->attachment_gstin_url)
                                            <a href="{{ $company->attachment_gstin_url }}" target="_blank">
                                                <img src="{{ $company->attachment_gstin_url }}" alt=""
                                                    width="80">
                                            </a>
                                        @endif
                                    </td>

                                </tr>
                                <tr>
                                    <th>Udyam Aadhar</th>
                                    <td>
                                        @if ($company->attachment_udyam_aadhar_url)
                                            <a href="{{ $company->attachment_udyam_aadhar_url }}" target="_blank">
                                                <img src="{{ $company->attachment_udyam_aadhar_url }}" alt=""
                                                    width="80">
                                            </a>
                                        @endif
                                    </td>
                                    <th>Gumasta License</th>
                                    <td>
                                        @if ($company->attachment_gumasta_url)
                                            <a href="{{ $company->attachment_gumasta_url }}" target="_blank">
                                                <img src="{{ $company->attachment_gumasta_url }}" alt=""
                                                    width="80">
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                <tr>

                                </tr>
                                <tr>
                                    <th>MSME Certificate</th>
                                    <td colspan="3">
                                        @if ($company->attachment_msme)
                                            <a href="{{ $company->attachment_msme }}" target="_blank">
                                                <img src="{{ $company->attachment_msme }}" alt="" width="80">
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                            <thead class="table-light">
                                <tr>
                                    <th colspan="4" class="text-center" style="background-color: #f4ebfc;">Bank Details
                                    </th>
                                </tr>
                            </thead>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>IFSC</th>
                                        <th>Account No</th>
                                        <th>Bank Name</th>
                                        <th>Branch</th>
                                        <th>Bank Code</th>
                                        <th>Primary</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($company->bankDetails && $company->bankDetails->count() > 0)
                                        @foreach ($company->bankDetails as $b)
                                            <tr>
                                                <td class="text-uppercase"><b>{{ $b->ifsc_code ?? '-' }}</b></td>
                                                <td><b>{{ $b->account_number ?? '-' }}</b></td>
                                                <td><b>{{ $b->bank_name ?? '-' }}</b></td>
                                                <td><b>{{ $b->branch_name ?? '-' }}</b></td>
                                                <td><b>{{ $b->bank_code ?? '-' }}</b></td>
                                                <td><b>{{ $b->is_primary ? 'Yes' : 'No' }}</b></td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">No bank details found for this
                                                client.</td>
                                        </tr>
                                    @endif
                                </tbody>

                            </table>


                        </table>
                    </div>
                </div>
            </div>
        </div>





    </div>
    <!-- Submit -->
    <div class="text-end mt-3">
        <a href="{{ route('master.companies.index') }}" class="btn btn-secondary px-4">Cancel</a>
    </div>


@endsection

@push('scripts')
@endpush
