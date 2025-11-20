@extends('layouts.master-layout')

@section('content')
<style>
    td{
        color: black;
        font-weight:bold;
    }
    th{
        background-color: #ededed!important;
    }
</style>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Master /</span> <a href="{{ route('clients.create') }}">Client view</a>
        </h4>
    </div>

    <div class="row">
        {{-- <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <!-- Personal Details Section -->
                <thead class="table-light">
                    <tr>
                        <th colspan="4" class="text-center" style="background-color: #f4ebfc;">
                            Personal Details
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>ID</th>
                        <td><b>{{ $client->client_code }}</b></td>
                        <th>Name</th>
                        <td><b>{{ $client->name }}</b></td>
                    </tr>
                    <tr>
                        <th>Gender</th>
                        <td><b>{{ ucfirst($client->gender) }}</b></td>
                        <th>Date of Birth</th>
                        <td><b>{{ $client->dob }}</b></td>
                    </tr>
                    <tr>
                        <th>Live Status</th>
                        <td><b>{{ ucfirst($client->live_status) }}</b></td>
                        <th>Date of Death</th>
                        <td><b>{{ $client->dod }}</b></td>
                    </tr>
                    <tr>
                        <th>Marital Status</th>
                        <td><b>{{ ucfirst($client->marital_status) }}</b></td>
                        <th>Nationality</th>
                        <td><b>{{ strtoupper($client->nationality) }}</b></td>
                    </tr>
                    <tr>
                        <th>Occupation</th>
                        <td><b>{{ ucfirst(str_replace('_', ' ', $client->occupation)) }}</b></td>
                        <th>PAN No</th>
                        <td><b>{{ $client->pan_no }}</b></td>
                    </tr>
                    <tr>
                        <th>Aadhar No</th>
                        <td><b>{{ $client->aadhar_no }}</b></td>
                        <th>CKYC No</th>
                        <td><b>{{ $client->ckyc_no }}</b></td>
                    </tr>
                    <tr>
                        <th>Mobile No</th>
                        <td><b>{{ $client->mobile_no }}</b></td>
                        <th>WhatsApp No</th>
                        <td><b>{{ $client->whatsapp_no }}</b></td>
                    </tr>
                    <tr>
                        <th>Landline No</th>
                        <td><b>{{ $client->landline_no }}</b></td>
                        <th>Email</th>
                        <td><b>{{ $client->email }}</b></td>
                    </tr>
                    <tr>
                        <th>Relation Manager ID</th>
                        <td colspan="3"><b>{{ $client->relation_manager_id }}</b></td>
                    </tr>
                </tbody>

                <!-- Residential Address Section -->
                <thead class="table-light">
                    <tr>
                        <th colspan="4" class="text-center" style="background-color: #f4ebfc;">
                            Residential Address
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>Address</th>
                        <td colspan="3"><b>{{ $client->res_address }}</b></td>
                    </tr>
                    <tr>
                        <th>Country</th>
                        <td><b>{{ $client->res_country }}</b></td>
                        <th>State</th>
                        <td><b>{{ $client->res_state }}</b></td>
                    </tr>
                    <tr>
                        <th>City</th>
                        <td><b>{{ $client->res_city }}</b></td>
                        <th>Pincode</th>
                        <td><b>{{ $client->res_pincode }}</b></td>
                    </tr>
                </tbody>

                <!-- Office Address Section -->
                <thead class="table-light">
                    <tr>
                        <th colspan="4" class="text-center" style="background-color: #f4ebfc;">
                            Office Address
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>Address</th>
                        <td colspan="3"><b>{{ $client->office_address }}</b></td>
                    </tr>
                    <tr>
                        <th>Country</th>
                        <td><b>{{ $client->office_country }}</b></td>
                        <th>State</th>
                        <td><b>{{ $client->office_state }}</b></td>
                    </tr>
                    <tr>
                        <th>City</th>
                        <td><b>{{ $client->office_city }}</b></td>
                        <th>Pincode</th>
                        <td><b>{{ $client->office_pincode }}</b></td>
                    </tr>
                </tbody>

                <!-- Attachments Section -->
                <thead class="table-light">
                    <tr>
                        <th colspan="4" class="text-center" style="background-color: #f4ebfc;">
                            Attachments
                        </th>
                    </tr>
                </thead>
                <tbody id="clientViewAttachments">
                    <tr>
                        <th>Client Photos</th>
                        <td>
                            @if ($client->attachment_client_photo_url)
                                <a href="{{ $client->attachment_client_photo_url }}" target="_blank">
                                    <img src="{{ $client->attachment_client_photo_url }}" alt="" width="200">
                                </a>
                            @endif
                        </td>
                        <th>PAN Attachment</th>
                        <td>
                            @if ($client->attachment_pan_url)
                                <a href="{{ $client->attachment_pan_url }}" target="_blank">
                                    <img src="{{ $client->attachment_pan_url }}" alt="">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Aadhar Front</th>
                        <td>
                            @if ($client->attachment_aadhar_front_url)
                                <a href="{{ $client->attachment_aadhar_front_url }}" target="_blank">
                                    <img src="{{ $client->attachment_aadhar_front_url }}" alt="">
                                </a>
                            @endif
                        </td>
                        <th>Aadhar Back</th>
                        <td>
                            @if ($client->attachment_aadhar_back_url)
                                <a href="{{ $client->attachment_aadhar_back_url }}" target="_blank">
                                    <img src="{{ $client->attachment_aadhar_back_url }}" alt="">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Signature</th>
                        <td>
                            @if ($client->attachment_signature_url)
                                <a href="{{ $client->attachment_signature_url }}" target="_blank">
                                    <img src="{{ $client->attachment_signature_url }}" alt="">
                                </a>
                            @endif
                        </td>
                        <th>CKYC Attachment</th>
                        <td>
                            @if ($client->attachment_ckyc_url)
                                <a href="{{ $client->attachment_ckyc_url }}" target="_blank">
                                    <img src="{{ $client->attachment_ckyc_url }}" alt="">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Other Documents</th>
                        <td colspan="3">
                            @if ($client->attachment_other_documents_url)
                                <a href="{{ $client->attachment_other_documents_url }}" target="_blank">
                                    <img src="{{ $client->attachment_other_documents_url }}" alt="">
                                </a>
                            @endif
                        </td>
                    </tr>
                </tbody>

                <!-- Bank Information Section -->
                <thead class="table-light">
                    <tr>
                        <th colspan="6" class="text-center" style="background-color: #f4ebfc;">
                            Bank Information
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @if ($client->banks->count() > 0)
                        <tr>
                            <th>IFSC</th>
                            <th>Account No</th>
                            <th>Bank Name</th>
                            <th>Branch</th>
                            <th>Bank Code</th>
                            <th>Primary</th>
                        </tr>
                        @foreach ($client->banks as $b)
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
                            <td colspan="6" class="text-center text-muted">
                                No bank details found for this client.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div> --}}


        {{-- <style>
            .section-heading {
                background: #8a4bef;
                font-weight: 600;
                padding: 6px 0;
                text-transform: uppercase;
                border-left: 4px solid #8a4bef;
            }

            .value {
                font-weight: 600;
                color: #333;
            }

            .attach-img {
                height: 80px;
                border: 1px solid #ddd;
                padding: 3px;
                border-radius: 5px;
                background: #fff;
                margin-right: 8px;
            }
        </style> --}}

    </div>
    {{-- ------------------------------------------------------------------------------- --}}

    <div class="container">
        <div class="text-end mb-3">
            <a href="{{ route('clients.index') }}" class="btn btn-secondary px-4">Go back</a>
        </div>
        <div class="card shadow-sm mb-4">
            <div class="card-header text-white text-center" style="background-color: #ead3ff;">
                <h5 class="mb-0">Client Information</h5>
            </div>

            <div class="card-body mt-3">

                <!-- MAIN DETAILS -->
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">

                        <!-- PERSONAL DETAILS -->
                        <tr>
                            <th colspan="4" class="text-center section-heading" style="background-color: #ede1f8 !important;">
                             <b>Personal Details</b></th>
                        </tr>

                        <tr>
                            <th>ID</th>
                            <td class="value">{{ $client->id }}</td>
                            <th>Name</th>
                            <td class="value">{{ $client->name }}</td>
                        </tr>

                        <tr>
                            <th>Gender</th>
                            <td class="value">{{ ucfirst($client->gender) }}</td>
                            <th>DOB</th>
                            <td class="value">{{ $client->dob }}</td>
                        </tr>

                        <tr>
                            <th>Live Status</th>
                            <td class="value">{{ ucfirst($client->live_status) }}</td>
                            <th>DOD</th>
                            <td class="value">{{ $client->dod ?: '-' }}</td>
                        </tr>

                        <tr>
                            <th>Marital Status</th>
                            <td class="value">{{ ucfirst($client->marital_status) }}</td>
                            <th>Nationality</th>
                            <td class="value">{{ strtoupper($client->nationality) }}</td>
                        </tr>

                        <tr>
                            <th>Occupation</th>
                            <td class="value">{{ ucfirst(str_replace('_', ' ', $client->occupation)) }}</td>
                            <th>PAN No</th>
                            <td class="value">{{ $client->pan_no }}</td>
                        </tr>

                        <tr>
                            <th>Aadhar</th>
                            <td class="value">{{ $client->aadhar_no }}</td>
                            <th>CKYC No</th>
                            <td class="value">{{ $client->ckyc_no }}</td>
                        </tr>

                        <tr>
                            <th>Mobile</th>
                            <td class="value">{{ $client->mobile_no }}</td>
                            <th>WhatsApp</th>
                            <td class="value">{{ $client->whatsapp_no }}</td>
                        </tr>

                        <tr>
                            <th>Landline</th>
                            <td class="value">{{ $client->landline_no }}</td>
                            <th>Email</th>
                            <td class="value">{{ $client->email }}</td>
                        </tr>

                        <tr>
                            <th>Relationship Manager</th>
                            <td colspan="3" class="value">{{ $client->relation_manager_id }}</td>
                        </tr>

                        <!-- RESIDENTIAL ADDRESS -->
                        <tr>
                            <th>Residential Address</th>
                            <td colspan="3" class="value">
                                {{ $client->res_address }},
                                {{ $client->res_city }},
                                {{ $client->res_state }},
                                {{ $client->res_country }} - {{ $client->res_pincode }}
                            </td>
                        </tr>

                        <!-- OFFICE ADDRESS -->
                        <tr>
                            <th>Office Address</th>
                            <td colspan="3" class="value">
                                {{ $client->office_address }},
                                {{ $client->office_city }},
                                {{ $client->office_state }},
                                {{ $client->office_country }} - {{ $client->office_pincode }}
                            </td>
                        </tr>
                    </table>
                </div>


                <!-- ATTACHMENTS -->
                <div class="table-responsive mt-4">
                    <table class="table table-bordered align-middle">

                        <tr>
                            <th colspan="4" class="text-center section-heading" style="background-color: #ede1f8 !important;">
                              <b>Attachments</b></th>
                        </tr>

                        <tr>
                            <th>Documents :</th>
                            <td colspan="3">
                                <div class="d-flex flex-wrap gap-3">

                                    @if ($client->attachment_client_photo_url)
                                        <div class="text-center">
                                            <a href="{{ $client->attachment_client_photo_url }}" target="_blank">
                                                <img src="{{ $client->attachment_client_photo_url }}" class="attach-img">
                                            </a>
                                            <div class="doc-title">Client Photo</div>
                                        </div>
                                    @endif

                                    @if ($client->attachment_pan_url)
                                        <div class="text-center">
                                            <a href="{{ $client->attachment_pan_url }}" target="_blank">
                                                <img src="{{ $client->attachment_pan_url }}" class="attach-img">
                                            </a>
                                            <div class="doc-title">PAN</div>
                                        </div>
                                    @endif

                                    @if ($client->attachment_aadhar_front_url)
                                        <div class="text-center">
                                            <a href="{{ $client->attachment_aadhar_front_url }}" target="_blank">
                                                <img src="{{ $client->attachment_aadhar_front_url }}" class="attach-img">
                                            </a>
                                            <div class="doc-title">Aadhar Front</div>
                                        </div>
                                    @endif

                                    @if ($client->attachment_aadhar_back_url)
                                        <div class="text-center">
                                            <a href="{{ $client->attachment_aadhar_back_url }}" target="_blank">
                                                <img src="{{ $client->attachment_aadhar_back_url }}" class="attach-img">
                                            </a>
                                            <div class="doc-title">Aadhar Back</div>
                                        </div>
                                    @endif

                                    @if ($client->attachment_signature_url)
                                        <div class="text-center">
                                            <a href="{{ $client->attachment_signature_url }}" target="_blank">
                                                <img src="{{ $client->attachment_signature_url }}" class="attach-img">
                                            </a>
                                            <div class="doc-title">Signature</div>
                                        </div>
                                    @endif

                                    @if ($client->attachment_ckyc_url)
                                        <div class="text-center">
                                            <a href="{{ $client->attachment_ckyc_url }}" target="_blank">
                                                <img src="{{ $client->attachment_ckyc_url }}" class="attach-img">
                                            </a>
                                            <div class="doc-title">CKYC</div>
                                        </div>
                                    @endif

                                    @if ($client->attachment_other_documents_url)
                                        <div class="text-center">
                                            <a href="{{ $client->attachment_other_documents_url }}" target="_blank">
                                                <img src="{{ $client->attachment_other_documents_url }}"
                                                    class="attach-img">
                                            </a>
                                            <div class="doc-title">Other Document</div>
                                        </div>
                                    @endif

                                </div>
                            </td>
                        </tr>
                    </table>
                </div>


                <!-- FAMILY INFO -->
                <div class="table-responsive mt-4">
                    <table class="table table-bordered align-middle">

                        <tr>
                            <th colspan="6" class="text-center section-heading" style="background-color: #ede1f8 !important;">
                             <b>Family Information</b></th>
                        </tr>

                        @if ($client->families->count() > 0)
                            <tr class="table-secondary">
                                <th>Name</th>
                                <th>Gender</th>
                                <th>DOB</th>
                                <th>Live Status</th>
                                <th>Marital Status</th>
                                <th>Relation</th>
                            </tr>

                            @foreach ($client->families as $f)
                                <tr>
                                    <td class="value">{{ $f->name ?? '-' }}</td>
                                    <td class="value">{{ $f->gender ?? '-' }}</td>
                                    <td class="value">
                                        {{ $f->dob ? \Carbon\Carbon::parse($f->dob)->format('d-m-Y') : '-' }}</td>
                                    <td class="value">{{ $f->live_status ?? '-' }}</td>
                                    <td class="value">{{ $f->marital_status ?? '-' }}</td>
                                    <td class="value">
                                        {{ $f->relation->main_relation . ' - ' . $f->relation->relative_relation }}
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="text-center text-muted">No families found.</td>
                            </tr>
                        @endif

                    </table>
                </div>


                <!-- BANK INFO -->
                <div class="table-responsive mt-4">
                    <table class="table table-bordered align-middle">

                        <tr>
                            <th colspan="6" class="text-center section-heading" style="background-color: #ede1f8 !important;">
                              <b>Bank Information</b></th>
                        </tr>

                        @if ($client->banks->count() > 0)
                            <tr class="table-secondary">
                                <th>IFSC</th>
                                <th>Account No</th>
                                <th>Bank Name</th>
                                <th>Branch</th>
                                <th>Bank Code</th>
                                <th>Primary</th>
                            </tr>

                            @foreach ($client->banks as $b)
                                <tr>
                                    <td class="value">{{ $b->ifsc_code ?? '-' }}</td>
                                    <td class="value">{{ $b->account_number ?? '-' }}</td>
                                    <td class="value">{{ $b->bank_name ?? '-' }}</td>
                                    <td class="value">{{ $b->branch_name ?? '-' }}</td>
                                    <td class="value">{{ $b->bank_code ?? '-' }}</td>
                                    <td class="value">{{ $b->is_primary ? 'Yes' : 'No' }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="text-center text-muted">No bank details found.</td>
                            </tr>
                        @endif

                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection
