@extends('layouts.master-layout')

@section('content')
    <style>
        td {
            color: black;
            font-weight: bold;
        }

        th {
            background-color: #ededed !important;
        }
    </style>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Master /</span> <a href="{{ route('clients.create') }}">Client view</a>
        </h4>
    </div>
    {{-- {{ $client }} --}}

    <div class="container">
        <div class="text-end mb-3">
            <a href="{{ route('clients.index') }}" class="btn btn-secondary px-4">Go back</a>
            <button type="button" class="btn btn-primary px-4">
                Download PDF
            </button>

        </div>
        <div class="card shadow-sm mb-4">
            <div class="card-header text-white text-center" style="background-color: #ead3ff;">
                <h5 class="mb-0">Client Informations</h5>
            </div>

            <div class="card-body mt-3">

                <!-- MAIN DETAILS -->
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">

                        <!-- PERSONAL DETAILS -->
                        <tr>

                            <th colspan="4" class="text-center section-heading"
                                style="background-color: #ede1f8 !important; position: relative;">

                                <b>Personal Details</b>

                                <span style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); ">
                                    Created Date Time :
                                    <b> {{ \Carbon\Carbon::parse($client->created_at)->format('d-M-Y H:i:s') }} </b>
                                </span>
                            </th>
                        </tr>

                        <tr>
                            <th>CLIENT CODE</th>
                            <td class="value">{{ $client->client_code }}</td>
                            <th>Name</th>
                            <td class="value">{{ $client->name }}</td>
                        </tr>

                        <tr>
                            <th>Gender</th>
                            <td class="value">{{ ucfirst($client->gender) }}</td>
                            <th>DOB</th>
                            <td class="value">{{ \Carbon\Carbon::parse($client->dob)->format('d-M-Y') }}
                                -{{ $client->age_group }}</td>
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
                <div class="table-responsive mt-4 clientViewAttachments">
                    <table class="table table-bordered align-middle">

                        <tr>
                            <th colspan="4" class="text-center section-heading"
                                style="background-color: #ede1f8 !important;">
                                <b>Attachments</b>
                            </th>
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
                                        @php
                                            $ext = strtolower(
                                                pathinfo($client->attachment_aadhar_front_url, PATHINFO_EXTENSION),
                                            );
                                            $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                        @endphp
                                        <div class="text-center">
                                            <a href="{{ $client->attachment_aadhar_front_url }}" target="_blank">
                                                @if ($isImage)
                                                    <img src="{{ $client->attachment_aadhar_front_url }}"
                                                        class="attach-img">
                                                @else
                                                    <embed src="{{ $client->attachment_aadhar_front_url }}"
                                                        type="application/pdf" width="100%" height="200px">
                                                @endif
                                            </a>
                                            <div class="doc-title">Aadhar Front</div>
                                        </div>
                                    @endif

                                    @if ($client->attachment_aadhar_back_url)
                                        <div class="text-center">
                                            <a href="{{ $client->attachment_aadhar_back_url }}" target="_blank">
                                                <img src="{{ $client->attachment_aadhar_back_url }}" class="attach-img">
                                            </a>
                                            <div class="doc-title">Mask Adhar</div>
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
                            <th colspan="6" class="text-center section-heading"
                                style="background-color: #ede1f8 !important;">
                                <b>Family Information</b>
                            </th>
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
                            <th colspan="6" class="text-center section-heading"
                                style="background-color: #ede1f8 !important;">
                                <b>Bank Information</b>
                            </th>
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
            <div class="p-3 text-end">

                @if (!$client->is_approved)
                    {{-- show approve button --}}
                    <button type="button" class="btn btn-success px-4">
                        Approve
                    </button>
                @else
                    {{-- hide button --}}
                    <button type="button" class="btn btn-success px-4 d-none">
                        Approve
                    </button>
                @endif


            </div>
        </div>

    </div>
@endsection
@push('scripts')
@endpush
