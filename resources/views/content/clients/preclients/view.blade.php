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
            <a href="{{ route('preclients.index') }}" class="btn btn-secondary px-4">Go back</a>
         
            {{-- <a href="{{ route('preclients.kyc.pdf', $preclient->id) }}" class="btn btn-primary">
                Download KYC PDF
            </a> --}}


        </div>
        <div class="card shadow-sm mb-4">
            <div class="card-header text-white text-center" style="background-color: #d3e0ff;">
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
                                style="background-color: #d3e0ff !important; position: relative;">

                                <b>Personal Details</b>

                                <span style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); ">
                                    Created Date Time :
                                    <b> {{ \Carbon\Carbon::parse($preclient->created_at)->format('d-M-Y H:i:s') }} </b>
                                </span>
                            </th>
                        </tr>

                        <tr>
                            {{-- <th>CLIENT CODE</th>
                            <td class="value">{{ $preclient->client_code }}</td> --}}
                            <th>Name</th>

                            <td class="value" colspan="6">
                                <div class="d-flex align-items-center justify-content-between">
                                    <span>{{ $preclient->name }}</span>

                                    <img src="{{ $preclient->attachment_client_photo_url }}" alt="Client Photo"
                                        width="200" height="200">
                                </div>
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

                            <th>Remarks</th>
                            <td class="value">{{ $preclient->remarks }}</td>
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
                                style="background-color: #d3e0ff !important;">
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
                                style="background-color: #d3e0ff !important;">
                                <b>Family Information</b>
                            </th>
                        </tr>

                        @if ($preclient->families->count())
                            <tr class="table-secondary">
                                <th>Name</th>
                                <th>Gender</th>
                                <th>DOB</th>
                                <th>Live Status</th>
                                <th>Marital Status</th>
                                <th>Relation</th>
                            </tr>

                            @foreach ($preclient->families as $family)
                                <tr>
                                    <td class="value">{{ $family->name ?? '-' }}</td>
                                    <td class="value">{{ ucfirst($family->gender) ?? '-' }}</td>
                                    <td class="value">
                                        {{ $family->dob ? \Carbon\Carbon::parse($family->dob)->format('d-M-Y') : '-' }}
                                    </td>
                                    <td class="value">{{ ucfirst($family->live_status) ?? '-' }}</td>
                                    <td class="value">{{ ucfirst($family->marital_status) ?? '-' }}</td>
                                    <td class="value">
                                        {{ optional($family->relation)->main_relation ?? '-' }}
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="text-center text-muted">No family records found</td>
                            </tr>
                        @endif

                    </table>
                </div>



                <!-- BANK INFO -->
                <div class="table-responsive mt-4">
                    <table class="table table-bordered align-middle">

                        <tr>
                            <th colspan="7" class="text-center section-heading"
                                style="background-color: #d3e0ff !important;">
                                <b>Bank Information</b>
                            </th>
                        </tr>

                        @if ($preClientBanks->count())
                            <tr class="table-secondary">
                                <th>Holder Name</th>
                                <th>Operation Mode</th>
                                <th>Bank / IFSC</th>
                                <th>Account No</th>
                                <th>Branch</th>
                                <th>Primary</th>
                                <th>Cancelled Cheque</th>
                            </tr>

                            @foreach ($preClientBanks as $bank)
                                <tr>
                                    <td class="value">
                                        {{ $bank->holder_name_1 ?? '-' }}
                                        @if ($bank->holder_name_2)
                                            <br>{{ $bank->holder_name_2 }}
                                        @endif
                                        @if ($bank->holder_name_3)
                                            <br>{{ $bank->holder_name_3 }}
                                        @endif
                                    </td>

                                    <td class="value">{{ ucfirst($bank->operation_mode) ?? '-' }}</td>

                                    <td class="value">
                                        {{ $bank->bank_name ?? '-' }} <br>
                                        <small class="text-muted">{{ $bank->ifsc_code ?? '-' }}</small>
                                    </td>

                                    <td class="value">{{ $bank->account_number ?? '-' }}</td>

                                    <td class="value">
                                        {{ $bank->branch_name ?? '-' }} <br>
                                        <small class="text-muted">{{ $bank->bank_code ?? '-' }}</small>
                                    </td>

                                    <td class="value">
                                        {{ $bank->is_primary ? 'Yes' : 'No' }}
                                    </td>

                                    <td class="value">
                                        @if ($bank->attachment_cancelled_cheque_url)
                                            <a href="{{ $bank->attachment_cancelled_cheque_url }}" target="_blank"
                                                class="text-primary text-decoration-underline">
                                                View
                                            </a>
                                        @else
                                            <span class="text-muted">Not available</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="text-center text-muted">No bank details found</td>
                            </tr>
                        @endif

                    </table>
                </div>



            </div>
            <div class="p-3 text-end">
                {{-- @if (!$preclient->is_approved)
                    <form action="{{ route('preclients.approve', $preclient->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-success px-4">
                            Approve
                        </button>
                    </form>
                @else
                @endif --}}


            </div>
        </div>

    </div>
@endsection
{{-- @push('scripts')
@endpush --}}
