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
            <span class="text-muted fw-light">Master /</span> <a href="{{ route('clients.create') }}">Pre-Client view</a>
        </h4>
    </div>
    {{-- {{ $client }} --}}

    <div class="container">
        <div class="text-end mb-3">
            <a href="{{ route('clients.index') }}" class="btn btn-secondary px-4">Go back</a>
            {{-- <button type="button" class="btn btn-primary px-4">
                Download PDF
            </button> --}}
            <a href="{{ route('client.kyc.pdf', $preclient->id) }}" class="btn btn-primary">
                Download KYC PDF
            </a>


        </div>
        <div class="card shadow-sm mb-4">
            <div class="card-header text-white text-center" style="background-color: #ead3ff;">
                <h5 class="mb-0">Pre-Client Informations</h5>
            </div>

            <div class="card-body mt-3">
                {{-- {{ $client }} --}}
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
                                    <b> {{ \Carbon\Carbon::parse($preclient->created_at)->format('d-M-Y H:i:s') }} </b>
                                </span>
                            </th>
                        </tr>

                        <tr>
                            <th>CLIENT CODE</th>
                            <td class="value">{{ $preclient->client_code }}</td>
                            <th>Name</th>
                            <td class="value">{{ $preclient->name }}
                                <img src="{{ $preclient->attachment_client_photo_url }}" alt="" srcset=""
                                    width="200" height="200">
                            </td>
                        </tr>

                        <tr>
                            <th>Gender</th>
                            <td class="value">{{ ucfirst($preclient->gender) }}</td>
                            <th>DOB</th>
                            <td class="value">{{ \Carbon\Carbon::parse($preclient->dob)->format('d-M-Y') }}
                                {{ $preclient->age_group ?? '' }}</td>
                        </tr>

                        <tr>
                            <th>Live Status</th>
                            <td class="value">
                                {{ ucfirst($preclient->live_status) }}
                                @if ($preclient->live_status === 'deceased')
                                    {{ $preclient->dod ? ' | ' . \Carbon\Carbon::parse($preclient->dod)->format('d-m-Y') : '' }}
                                @endif
                            </td>
                            <th>Email</th>
                            <td class="value">{{ $preclient->email ? strtolower($preclient->email) : '-' }}</td>

                        </tr>

                        <tr>
                            <th>Marital Status</th>
                            <td class="value">{{ ucfirst($preclient->marital_status) }}</td>
                            <th>Nationality</th>
                            {{-- @php
                                $nationalities = [
                                    'ri' => 'Residential Individual',
                                    'nro' => 'NRO',
                                    'nre' => 'NRE',
                                    'pio' => 'OCI / PIO',
                                    'gch' => 'Green Card Holder',
                                    'trioc' => 'Tax Resident in Other Country',
                                    'fn' => 'Foreign National',
                                    'other' => 'Other',
                                ];
                            @endphp

                            <td class="value">
                                {{ $nationalities[$preclient->nationality] ?? '-' }}
                            </td> --}}
                            <td class="value">
                                {{ strtoupper(config('enum_client.nationality.' . $preclient->nationality) ?? $preclient->nationality) }}
                            </td>

                        </tr>

                        <tr>
                            <th>Occupation</th>
                            <td class="value">{{ ucfirst(str_replace('_', ' ', $preclient->occupation)) }}</td>
                            <th>PAN No</th>
                            <td class="value">{{ $preclient->pan_no }}</td>
                        </tr>

                        <tr>
                            <th>Aadhar</th>
                            <td class="value">{{ $preclient->aadhar_no }}</td>
                            <th>CKYC No</th>
                            <td class="value">{{ $preclient->ckyc_no }}</td>
                        </tr>

                        <tr>
                            <th>Mobile</th>
                            <td class="value">{{ $preclient->mobile_no }}</td>
                            <th>WhatsApp</th>
                            <td class="value">{{ $preclient->whatsapp_no }}</td>
                        </tr>

                        <tr>
                            <th>Landline</th>
                            <td class="value">{{ $preclient->landline_no }}</td>

                            <th>Relationship Manager</th>
                            <td class="value">{{ $preclient->relation_manager_id }}</td>
                        </tr>



                        <!-- RESIDENTIAL ADDRESS -->
                        <tr>
                            <th>Residential Address</th>
                            @if (!empty($preclient->res_address))
                                <td colspan="3" class="value">
                                    {{ $preclient->res_address }},
                                    {{ $preclient->res_city }},
                                    {{ $preclient->res_state }},
                                    {{ $preclient->res_country }} - {{ $preclient->res_pincode }}
                                </td>
                            @endif
                        </tr>

                        <!-- OFFICE ADDRESS -->
                        <tr>
                            <th>Office Address</th>
                            @if (!empty($preclient->office_address))
                                <td colspan="3" class="value">
                                    {{ $preclient->office_address }},
                                    {{ $preclient->office_city }},
                                    {{ $preclient->office_state }},
                                    {{ $preclient->office_country }} - {{ $preclient->office_pincode }}
                                </td>
                            @endif
                        </tr>
                    </table>
                </div>


                <!-- ATTACHMENTS -->

                <div class="table-responsive mt-4">
                    <table class="table table-bordered align-middle">

                        <tr>
                            <th colspan="6" class="text-center section-heading"
                                style="background-color: #ede1f8 !important;">
                                <b>Attachments</b>
                            </th>
                        </tr>

                        <tr class="table-secondary">
                            {{-- <th>Client Photo</th> --}}
                            <th>PAN</th>
                            <th>Aadhar</th>
                            <th>Masked Aadhar</th>
                            <th>CKYC</th>
                            <th>Signature</th>
                            <th>Other Document</th>
                        </tr>

                        <tr>


                            <td class="value">
                                @if ($preclient->attachment_pan_url)
                                    <a href="{{ $preclient->attachment_pan_url }}" target="_blank"
                                        class="text-primary text-decoration-underline">
                                        Click to view
                                    </a>
                                @else
                                    <span class="text-muted">Not available</span>
                                @endif
                            </td>

                            <td class="value">
                                @if ($preclient->attachment_aadhar_front_url)
                                    <a href="{{ $preclient->attachment_aadhar_front_url }}" target="_blank"
                                        class="text-primary text-decoration-underline">
                                        Click to view
                                    </a>
                                @else
                                    <span class="text-muted">Not available</span>
                                @endif
                            </td>

                            <td class="value">
                                @if ($preclient->attachment_aadhar_back_url)
                                    <a href="{{ $preclient->attachment_aadhar_back_url }}" target="_blank"
                                        class="text-primary text-decoration-underline">
                                        Click to view
                                    </a>
                                @else
                                    <span class="text-muted">Not available</span>
                                @endif
                            </td>

                            <td class="value">
                                @if ($preclient->attachment_ckyc_url)
                                    <a href="{{ $preclient->attachment_ckyc_url }}" target="_blank"
                                        class="text-primary text-decoration-underline">
                                        Click to view
                                    </a>
                                @else
                                    <span class="text-muted">Not available</span>
                                @endif
                            </td>

                            <td class="value">
                                @if ($preclient->attachment_signature_url)
                                    <a href="{{ $preclient->attachment_signature_url }}" target="_blank"
                                        class="text-primary text-decoration-underline">
                                        Click to view
                                    </a>
                                @else
                                    <span class="text-muted">Not available</span>
                                @endif
                            </td>

                            <td class="value">
                                @if ($preclient->attachment_other_documents_url)
                                    <a href="{{ $preclient->attachment_other_documents_url }}" target="_blank"
                                        class="text-primary text-decoration-underline">
                                        Click to view
                                    </a>
                                @else
                                    <span class="text-muted">Not available</span>
                                @endif
                            </td>
                        </tr>



                    </table>
                </div>


                {{-- {{ $client }} --}}

                <!-- FAMILY INFO -->
                <div class="table-responsive mt-4">
                    <table class="table table-bordered align-middle">

                        <tr>
                            <th colspan="6" class="text-center section-heading"
                                style="background-color: #ede1f8 !important;">
                                <b>Family Information</b>
                            </th>
                        </tr>

                        @if ($preclient->families->count() > 0)
                            <tr class="table-secondary">
                                <th>Name</th>
                                <th>Gender</th>
                                <th>DOB</th>
                                <th>Live Status</th>
                                <th>Marital Status</th>
                                <th>Relation</th>
                            </tr>

                            {{-- @foreach ($preclient->families as $f)
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
                        @endif --}}

                    </table>
                </div>


                <!-- BANK INFO -->
                <div class="table-responsive mt-4">
                    <table class="table table-bordered align-middle">

                        <tr>
                            <th colspan="7" class="text-center section-heading"
                                style="background-color: #ede1f8 !important;">
                                <b>Bank Information</b>
                            </th>
                        </tr>

                        {{-- @if ($preclient->banks->count() > 0)
                            <tr class="table-secondary">
                                <th>Holder Name</th>
                                <th>Operation Mode</th>
                                <th>Bank Name / IFSC</th>
                                <th>Account No</th>
                                <th>Branch / Bank Code</th>
                                <th>Primary</th>
                                <th>cheque image</th>

                            </tr>

                            @foreach ($clientBank as $b)
                                <tr>
                                    <td class="value">
                                        @if ($b->operation_mode === 'single')
                                            {{ $b->holder_name_1 ?? '-' }}
                                        @else
                                            {{ $b->holder_name_1 ?? '-' }} <br>
                                            {{ $b->holder_name_2 ?? '-' }} <br>
                                            {{ $b->holder_name_3 ?? '-' }}
                                        @endif
                                    </td>
                                    <td class="value">{{ $b->operation_mode ?? '-' }}</td>
                                    <td class="value">{{ $b->bank_name ?? '-' }} <br> {{ $b->ifsc_code ?? '-' }}
                                    <td class="value">{{ $b->account_number ?? '-' }}</td>
                                    <td class="value">{{ $b->branch_name ?? '-' }} <br> {{ $b->branch_code ?? '-' }}
                                    <td class="value">{{ $b->is_primary ?? '-' }}</td>
                                    <td class="value">
                                        @if ($b->attachment_cancelled_cheque_url)
                                            <a href="{{ $b->attachment_cancelled_cheque_url }}" target="_blank"
                                                class="text-primary text-decoration-underline">
                                                Click to view
                                            </a>
                                        @else
                                            <span class="text-muted">Not available</span>
                                        @endif
                                    </td>


                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="text-center text-muted">No bank details found.</td>
                            </tr>
                        @endif --}}

                    </table>
                </div>


            </div>
            <div class="p-3 text-end">
                @if (!$preclient->is_approved)
                    {{-- show approve button --}}
                    <form action="{{ route('client.approve', $preclient->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-success px-4">
                            Approve
                        </button>
                    </form>
                @else
                    {{-- hide button --}}
                @endif


            </div>
        </div>

    </div>
@endsection
@push('scripts')
@endpush
