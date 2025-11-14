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

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Master /</span> <a href="{{ route('master.companies.create') }}">Company</a>
        </h4>
    </div>

    <div class="row">
        <!-- TABLE SECTION -->

        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Companies List</h5>
                    <a class="btn btn-primary" href="{{ route('master.companies.create') }}" role="button">Add New</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table srkdataTable ">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Company</th>
                                    <th>Contact Person</th>
                                    <th>Number</th>
                                    <th>Email</th>
                                    <th>GST No</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Example static row (replace with @foreach later) --}}
                                @foreach ($companies as $d)
                                    <tr>
                                        <td>{{ $d->id }}</td>
                                        <td>{{ $d->name }}</td>
                                        <td>{{ $d->contact_person_name }}</td>
                                        <td>{{ $d->phone }}</td>
                                        <td>{{ $d->email }}</td>
                                        <td>{{ $d->gstin }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" data-bs-toggle="modal"
                                                        data-bs-target="#exampleModal{{ $d->id }}">
                                                        <i class="bx bx-show me-1"></i> View
                                                    </a>
                                                    <a class="dropdown-item"
                                                        href="{{ route('master.companies.edit', $d->id) }}"><i
                                                            class="bx bx-edit-alt me-1"></i> Edit</a>
                                                    <form action="{{ route('master.companies.destroy', $d->id) }}"
                                                        method="post" onsubmit="return confirmDelete()">

                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger delete-btn"
                                                            data-id="{{ $d->id }}">
                                                            <i class="bx bx-trash me-1"></i> Delete
                                                        </button>

                                                    </form>

                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @foreach ($companies as $d)
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal{{ $d->id }}" tabindex="-1"
                            aria-labelledby="exampleModalLabel{{ $d->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header" style="background-color: #ead3ff;">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel{{ $d->id }}">
                                            {{ $d->name ?? 'Client Details' }}
                                        </h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered align-middle">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th colspan="4" class="text-center"
                                                            style="background-color: #f4ebfc;">Personal Details</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th>ID</th>
                                                        <td><b>{{ $d->id }}</b></td>
                                                        <th>Company Name</th>
                                                        <td><b>{{ $d->name }}</b></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Company brand Name </th>
                                                        <td><b>{{ ucfirst($d->brand_name) }}</b></td>
                                                        <th>Establishment Date</th>
                                                        <td><b>{{ $d->est_date }}</b></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Contact Person Name</th>
                                                        <td><b>{{ ucfirst($d->contact_person_name) }}</b></td>
                                                        <th>Contact Person Number</th>
                                                        <td><b>{{ $d->phone }}</b></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Contact Person Email</th>
                                                        <td><b>{{ ucfirst($d->email) }}</b></td>
                                                        <th>Contact Person WhatsApp Number</th>
                                                        <td><b>{{ strtoupper($d->whatsapp_no) }}</b></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Proprietor Name</th>
                                                        <td><b>{{ ucfirst(str_replace('_', ' ', $d->proprietor_name)) }}</b>
                                                        </td>
                                                        <th>Proprietor Contact Number</th>
                                                        <td><b>{{ $d->proprietor_phone }}</b></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Proprietor Email</th>
                                                        <td><b>{{ $d->proprietor_email }}</b></td>
                                                        <th>Proprietor WhatsApp Number</th>
                                                        <td><b>{{ $d->proprietor_whatsapp }}</b></td>
                                                    </tr>

                                                </tbody>

                                                <!-- Residential Section -->
                                                <thead class="table-light">
                                                    <tr>
                                                        <th colspan="4" class="text-center"
                                                            style="background-color: #f4ebfc;">Residential Address</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th>Address</th>
                                                        <td colspan="3"><b>{{ $d->registered_address }}</b></td>
                                                    </tr>
                                                    <tr>
                                                        <th>State</th>
                                                        <td><b>{{ $d->registered_state }}</b></td>
                                                        <th>City</th>
                                                        <td><b>{{ $d->registered_city }}</b></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Pincode</th>
                                                        <td><b>{{ $d->registered_pincode }}</b></td>
                                                    </tr>
                                                </tbody>

                                                <!-- Office Section -->
                                                <thead class="table-light">
                                                    <tr>
                                                        <th colspan="4" class="text-center"
                                                            style="background-color: #f4ebfc;">Corporate Address</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th>Address</th>
                                                        <td colspan="3"><b>{{ $d->corporate_address }}</b></td>
                                                    </tr>
                                                    <tr>

                                                        <th>State</th>
                                                        <td><b>{{ $d->corporate_state }}</b></td>
                                                        <th>City</th>
                                                        <td><b>{{ $d->corporate_city }}</b></td>
                                                    </tr>
                                                    <tr>

                                                        <th>Pincode</th>
                                                        <td><b>{{ $d->corporate_pincode }}</b></td>
                                                    </tr>
                                                </tbody>

                                                <!-- Additional  Address Section -->
                                                <thead class="table-light">
                                                    <tr>
                                                        <th colspan="4" class="text-center"
                                                            style="background-color: #f4ebfc;">Additional Address For GST
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th>Address</th>
                                                        <td colspan="3"><b>{{ $d->additional_address }}</b></td>
                                                    </tr>
                                                    <tr>

                                                        <th>State</th>
                                                        <td><b>{{ $d->additional_state }}</b></td>
                                                        <th>City</th>
                                                        <td><b>{{ $d->additional_city }}</b></td>
                                                    </tr>
                                                    <tr>

                                                        <th>Pincode</th>
                                                        <td><b>{{ $d->additional_pincode }}</b></td>
                                                    </tr>
                                                </tbody>
                                                <!-- Official Identification Numbers -->
                                                <thead class="table-light">
                                                    <tr>
                                                        <th colspan="4" class="text-center"
                                                            style="background-color: #f4ebfc;">Official Identification
                                                            Numbers</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th>Aadhar Number</th>
                                                        <td><b>{{ $d->aadhar_no }}</b></td>
                                                        <th>PAN Number</th>
                                                        <td><b>{{ $d->pan_no }}</b></td>
                                                    </tr>
                                                    <tr>
                                                        <th>TAN Number</th>
                                                        <td><b>{{ $d->tan_no }}</b></td>
                                                        <th>CKYC Number</th>
                                                        <td><b>{{ $d->ckyc }}</b></td>

                                                    </tr>
                                                    <tr>
                                                        <th>GSTIN</th>
                                                        <td><b>{{ $d->gstin }}</b></td>
                                                        <th>Udyam Aadhar Number</th>
                                                        <td><b>{{ $d->udyam_aadhar_no }}</b></td>

                                                    </tr>
                                                    <tr>
                                                        <th>MSME Certification Number</th>
                                                        <td><b>{{ $d->msme_certification_no }}</b></td>
                                                        <th>Gumasta Number</th>
                                                        <td><b>{{ $d->gumasta_no }}</b></td>
                                                    </tr>
                                                </tbody>

                                                <!-- Attachments Section -->
                                                <thead class="table-light">
                                                    <tr>
                                                        <th colspan="4" class="text-center"
                                                            style="background-color: #f4ebfc;">Attachments</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th>Logo Attachment</th>
                                                        <td>
                                                            @if ($d->attachment_client_photo)
                                                                <b><a href="{{ asset('storage/' . $d->attachment_client_photo) }}"
                                                                        target="_blank">View</a></b>
                                                            @endif
                                                        </td>
                                                        <th>Aadhar Attachment</th>
                                                        <td>
                                                            @if ($d->attachment_aadhar_back)
                                                                <b><a href="{{ asset('storage/' . $d->attachment_aadhar_back) }}"
                                                                        target="_blank">View</a></b>
                                                            @endif
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <th>PAN Attachment</th>
                                                        <td>
                                                            @if ($d->attachment_pan)
                                                                <b><a href="{{ asset('storage/' . $d->attachment_pan) }}"
                                                                        target="_blank">View</a></b>
                                                            @endif
                                                        </td>
                                                        <th>TAN Attachment</th>
                                                        <td>
                                                            @if ($d->attachment_aadhar_front)
                                                                <b><a href="{{ asset('storage/' . $d->attachment_aadhar_front) }}"
                                                                        target="_blank">View</a></b>
                                                            @endif
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <th>CKYC Attachment</th>
                                                        <td>
                                                            @if ($d->attachment_ckyc)
                                                                <b><a href="{{ asset('storage/' . $d->attachment_ckyc) }}"
                                                                        target="_blank">View</a></b>
                                                            @endif
                                                        </td>
                                                        <th>GSTIN Attachment</th>
                                                        <td>
                                                            @if ($d->attachment_signature)
                                                                <b><a href="{{ asset('storage/' . $d->attachment_signature) }}"
                                                                        target="_blank">View</a></b>
                                                            @endif
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <th>Udyam Aadhar</th>
                                                        <td>
                                                            @if ($d->attachment_other_documents)
                                                                <b><a href="{{ asset('storage/' . $d->attachment_other_documents) }}"
                                                                        target="_blank">View</a></b>
                                                            @endif
                                                        </td>
                                                        <th>Gumasta License</th>
                                                        <td>
                                                            @if ($d->attachment_other_documents)
                                                                <b><a href="{{ asset('storage/' . $d->attachment_other_documents) }}"
                                                                        target="_blank">View</a></b>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>

                                                    </tr>
                                                    <tr>
                                                        <th>MSME Certificate</th>
                                                        <td colspan="3">
                                                            @if ($d->attachment_other_documents)
                                                                <b><a href="{{ asset('storage/' . $d->attachment_other_documents) }}"
                                                                        target="_blank">View</a></b>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                </tbody>
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
                                                        @if (!empty($d->banks) && $d->banks->count() > 0)
                                                            @foreach ($d->banks as $b)
                                                                <tr>
                                                                    <td class="text-uppercase">
                                                                        <b>{{ $b->ifsc_code ?? '-' }}</b>
                                                                    </td>
                                                                    <td><b>{{ $b->account_number ?? '-' }}</b></td>
                                                                    <td><b>{{ $b->bank_name ?? '-' }}</b></td>
                                                                    <td><b>{{ $b->branch_name ?? '-' }}</b></td>
                                                                    <td><b>{{ $b->bank_code ?? '-' }}</b></td>
                                                                    <td><b>{{ $b->is_primary ? 'Yes' : 'No' }}</b></td>
                                                                </tr>
                                                            @endforeach
                                                    </tbody>
                                                </table>
                                            @else
                                                <p class="text-muted">No bank details found for this client.</p>
                    @endif

                    </table>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
    </div>
    @endforeach
    </div>
    </div>
    </div>
    </div>


@endsection
