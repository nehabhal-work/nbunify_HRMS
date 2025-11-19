@extends('layouts.master-layout')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Master /</span> <a href="{{ route('clients.create') }}">Client view</a>
        </h4>
    </div>

    <div class="row">
        {{ $client }}
        <div class="table-responsive">
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
        </div>


        <!-- Bank Info Modal (Separate) -->
        {{-- @foreach ($clients as $client)
            <div class="modal fade" id="bankmodal{{ $client->id }}" tabindex="-1"
                aria-labelledby="bankmodalLabel{{ $client->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: #ead3ff;">
                            <h5 class="modal-title" id="bankmodalLabel{{ $client->id }}">
                                Bank Information - {{ $client->name }}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            @if ($client->banks->count() > 0)
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
                                    </tbody>
                                </table>
                            @else
                                <p class="text-muted">No bank details found for this client.</p>
                            @endif
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach --}}
    </div>
@endsection
