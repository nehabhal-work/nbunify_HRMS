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
            <span class="text-muted fw-light">Master /</span> <a href="{{ route('clients.create') }}">Client</a>
        </h4>
    </div>

    <div class="row">
        <!-- TABLE SECTION -->

        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Client List</h5>
                    <a class="btn btn-primary" href="{{ route('clients.create') }}" role="button">Add New</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table srkdataTable ">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Client name</th>
                                    <th>pan no</th>
                                    <th>addhar no</th>
                                    <th>phone</th>
                                    <th>Email</th>
                                    <th>address</th>
                                    <th>Family info</th>
                                    <th>bank info</th>
                                    <th>action</th>
                                </tr>
                            <tbody>
                                @foreach ($clients as $d)
                                    <tr>
                                        <td>{{ $d->id }}</td>
                                        <td>{{ $d->name }}</td>
                                        <td>{{ $d->pan_no }}</td>
                                        <td>{{ $d->aadhar_no }}</td>
                                        <td>{{ $d->mobile_no }}</td>
                                        <td>{{ $d->email }}</td>
                                        <td>{{ $d->res_address }}</td>

                                        <td>
                                            <a href="{{ route('client-families.index', ['client_id' => $d->id]) }}"
                                                class="btn btn-sm btn-info">
                                                View Family Info
                                            </a>
                                        </td>

                                        <td>
                                            @if ($d->banks->count() > 0)
                                                <button type="button" class="btn btn-sm btn-secondary"
                                                    data-bs-toggle="modal" data-bs-target="#bankmodal{{ $d->id }}">
                                                    View Bank Info
                                                </button>
                                            @else
                                                <button type="button" class="btn btn-sm btn-secondary" disabled>
                                                    No Bank Info
                                                </button>
                                            @endif
                                        </td>

                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="{{ route('clients.edit', $d->id) }}"><i
                                                            class="bx bx-edit-alt me-1"></i> Edit</a>
                                                    <!-- Button trigger modal -->
                                                    <a class="dropdown-item" data-bs-toggle="modal"
                                                        data-bs-target="#exampleModal{{ $d->id }}">
                                                        <i class="bx bx-show me-1"></i> View
                                                    </a>

                                                    <form action="{{ route('clients.destroy', $d->id) }}" method="post"
                                                        onsubmit="return confirmDelete()">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger delete-btn"
                                                            data-id="">
                                                            <i class="bx bx-trash me-1"></i> Delete
                                                        </button>

                                                    </form>

                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                            </thead>

                        </table>
                    </div>
                </div>
                @foreach ($clients as $d)
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
                                                    <th>Name</th>
                                                    <td><b>{{ $d->name }}</b></td>
                                                </tr>
                                                <tr>
                                                    <th>Gender</th>
                                                    <td><b>{{ ucfirst($d->gender) }}</b></td>
                                                    <th>Date of Birth</th>
                                                    <td><b>{{ $d->dob }}</b></td>
                                                </tr>
                                                <tr>
                                                    <th>Live Status</th>
                                                    <td><b>{{ ucfirst($d->live_status) }}</b></td>
                                                    <th>Date of Death</th>
                                                    <td><b>{{ $d->dod }}</b></td>
                                                </tr>
                                                <tr>
                                                    <th>Marital Status</th>
                                                    <td><b>{{ ucfirst($d->marital_status) }}</b></td>
                                                    <th>Nationality</th>
                                                    <td><b>{{ strtoupper($d->nationality) }}</b></td>
                                                </tr>
                                                <tr>
                                                    <th>Occupation</th>
                                                    <td><b>{{ ucfirst(str_replace('_', ' ', $d->occupation)) }}</b></td>
                                                    <th>PAN No</th>
                                                    <td><b>{{ $d->pan_no }}</b></td>
                                                </tr>
                                                <tr>
                                                    <th>Aadhar No</th>
                                                    <td><b>{{ $d->aadhar_no }}</b></td>
                                                    <th>CKYC No</th>
                                                    <td><b>{{ $d->ckyc_no }}</b></td>
                                                </tr>
                                                <tr>
                                                    <th>Mobile No</th>
                                                    <td><b>{{ $d->mobile_no }}</b></td>
                                                    <th>WhatsApp No</th>
                                                    <td><b>{{ $d->whatsapp_no }}</b></td>
                                                </tr>
                                                <tr>
                                                    <th>Landline No</th>
                                                    <td><b>{{ $d->landline_no }}</b></td>
                                                    <th>Email</th>
                                                    <td><b>{{ $d->email }}</b></td>
                                                </tr>
                                                <tr>
                                                    <th>Relation Manager ID</th>
                                                    <td colspan="3"><b>{{ $d->relation_manager_id }}</b></td>
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
                                                    <td colspan="3"><b>{{ $d->res_address }}</b></td>
                                                </tr>
                                                <tr>
                                                    <th>Country</th>
                                                    <td><b>{{ $d->res_country }}</b></td>
                                                    <th>State</th>
                                                    <td><b>{{ $d->res_state }}</b></td>
                                                </tr>
                                                <tr>
                                                    <th>City</th>
                                                    <td><b>{{ $d->res_city }}</b></td>
                                                    <th>Pincode</th>
                                                    <td><b>{{ $d->res_pincode }}</b></td>
                                                </tr>
                                            </tbody>

                                            <!-- Office Section -->
                                            <thead class="table-light">
                                                <tr>
                                                    <th colspan="4" class="text-center"
                                                        style="background-color: #f4ebfc;">Office Address</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th>Address</th>
                                                    <td colspan="3"><b>{{ $d->office_address }}</b></td>
                                                </tr>
                                                <tr>
                                                    <th>Country</th>
                                                    <td><b>{{ $d->office_country }}</b></td>
                                                    <th>State</th>
                                                    <td><b>{{ $d->office_state }}</b></td>
                                                </tr>
                                                <tr>
                                                    <th>City</th>
                                                    <td><b>{{ $d->office_city }}</b></td>
                                                    <th>Pincode</th>
                                                    <td><b>{{ $d->office_pincode }}</b></td>
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
                                                    <th>Client Photo</th>
                                                    <td>
                                                        @if ($d->attachment_client_photo)
                                                            <b><a href="{{ asset('storage/' . $d->attachment_client_photo) }}"
                                                                    target="_blank">View</a></b>
                                                        @endif
                                                    </td>
                                                    <th>PAN Attachment</th>
                                                    <td>
                                                        @if ($d->attachment_pan)
                                                            <b><a href="{{ asset('storage/' . $d->attachment_pan) }}"
                                                                    target="_blank">View</a></b>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Aadhar Front</th>
                                                    <td>
                                                        @if ($d->attachment_aadhar_front)
                                                            <b><a href="{{ asset('storage/' . $d->attachment_aadhar_front) }}"
                                                                    target="_blank">View</a></b>
                                                        @endif
                                                    </td>
                                                    <th>Aadhar Back</th>
                                                    <td>
                                                        @if ($d->attachment_aadhar_back)
                                                            <b><a href="{{ asset('storage/' . $d->attachment_aadhar_back) }}"
                                                                    target="_blank">View</a></b>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Signature</th>
                                                    <td>
                                                        @if ($d->attachment_signature)
                                                            <b><a href="{{ asset('storage/' . $d->attachment_signature) }}"
                                                                    target="_blank">View</a></b>
                                                        @endif
                                                    </td>
                                                    <th>CKYC Attachment</th>
                                                    <td>
                                                        @if ($d->attachment_ckyc)
                                                            <b><a href="{{ asset('storage/' . $d->attachment_ckyc) }}"
                                                                    target="_blank">View</a></b>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Other Documents</th>
                                                    <td colspan="3">
                                                        @if ($d->attachment_other_documents)
                                                            <b><a href="{{ asset('storage/' . $d->attachment_other_documents) }}"
                                                                    target="_blank">View</a></b>
                                                        @endif
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Bank Info Modal -->

                @foreach ($clients as $d)
                    <!-- Modal for this client -->
                    <div class="modal fade" id="bankmodal{{ $d->id }}" tabindex="-1"
                        aria-labelledby="bankmodalLabel{{ $d->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">

                                <div class="modal-header" style="background-color: #ead3ff;">
                                    <h5 class="modal-title" id="bankmodalLabel{{ $d->id }}">
                                        Bank Information - {{ $d->name }}
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    @if ($d->banks->count() > 0)
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
                                                @foreach ($d->banks as $b)
                                                    <tr>
                                                        <td class="text-uppercase"><b> {{ $b->ifsc_code ?? '-' }}</b></td>
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
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
