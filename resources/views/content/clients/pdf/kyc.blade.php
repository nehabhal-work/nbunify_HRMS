<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Client KYC</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #000;
        }

        h3 {
            text-align: center;
            margin-bottom: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
        }

        th,
        td {
            border: 1px solid #444;
            padding: 6px;
            vertical-align: top;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: left;
        }

        .section-heading {
            background-color: #ede1f8;
            text-align: center;
            font-weight: bold;
            font-size: 12px;
        }

        .value {
            font-weight: normal;
        }

        .text-center {
            text-align: center;
        }

        .text-muted {
            color: #777;
        }

        .img-box {
            max-width: 120px;
            max-height: 120px;
            border: 1px solid #ccc;
            margin: 3px auto;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>

    @php
        function pdfImage($url)
        {
            if (!$url) {
                return null;
            }

            if (str_starts_with($url, 'http')) {
                $path = parse_url($url, PHP_URL_PATH);
                return public_path($path);
            }

            return public_path($url);
        }
    @endphp

    <h3>Client KYC Information</h3>

    {{-- ================= PERSONAL DETAILS ================= --}}
    <table>
        <tr>
            <th colspan="4" class="section-heading">
                Personal Details <br>
                <small>
                    Created Date Time :
                    {{ \Carbon\Carbon::parse($client->created_at)->format('d-M-Y H:i:s') }}
                </small>
            </th>
        </tr>

        <tr>
            <th>Client Code</th>
            <td class="value">{{ $client->client_code }}</td>
            <th>Name</th>
            <td class="value">
                {{ $client->name }}<br>
                @if ($img = pdfImage($client->attachment_client_photo_url))
                    <img src="{{ $img }}" class="img-box">
                @endif
            </td>
        </tr>

        <tr>
            <th>Gender</th>
            <td class="value">{{ ucfirst($client->gender) }}</td>
            <th>DOB</th>
            <td class="value">
                {{ \Carbon\Carbon::parse($client->dob)->format('d-M-Y') }}
                {{ $client->age_group ?? '' }}
            </td>
        </tr>

        <tr>
            <th>Live Status</th>
            <td class="value">
                {{ ucfirst($client->live_status) }}
                @if ($client->live_status === 'deceased' && $client->dod)
                    | {{ \Carbon\Carbon::parse($client->dod)->format('d-m-Y') }}
                @endif
            </td>
            <th>Email</th>
            <td class="value">{{ $client->email ?? '-' }}</td>
        </tr>

        <tr>
            <th>Marital Status</th>
            <td class="value">{{ ucfirst($client->marital_status) }}</td>
            <th>Nationality</th>
            <td class="value">
                {{ strtoupper(config('enum_client.nationality.' . $client->nationality) ?? $client->nationality) }}
            </td>
        </tr>

        <tr>
            <th>Occupation</th>
            <td class="value">{{ ucfirst(str_replace('_', ' ', $client->occupation)) }}</td>
            <th>PAN No</th>
            <td class="value">{{ $client->pan_no }}</td>
        </tr>

        <tr>
            <th>Aadhar No</th>
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
            <th>Residential Address</th>
            <td colspan="3" class="value">
                {{ $client->res_address }},
                {{ $client->res_city }},
                {{ $client->res_state }},
                {{ $client->res_country }} - {{ $client->res_pincode }}
            </td>
        </tr>

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

    {{-- ================= ATTACHMENTS ================= --}}
    <table>
        <tr>
            <th colspan="6" class="section-heading">Attachments</th>
        </tr>

        <tr>
            <th>PAN</th>
            <th>Aadhar</th>
            <th>Masked Aadhar</th>
            <th>CKYC</th>
            <th>Signature</th>
            <th>Other</th>
        </tr>

        <tr>
            <td class="text-center">
                @if ($img = pdfImage($client->attachment_pan_url))
                    <img src="{{ $img }}" class="img-box">
                @else
                    <span class="text-muted">Not available</span>
                @endif
            </td>

            <td class="text-center">
                @if ($img = pdfImage($client->attachment_aadhar_front_url))
                    <img src="{{ $img }}" class="img-box">
                @else
                    <span class="text-muted">Not available</span>
                @endif
            </td>

            <td class="text-center">
                @if ($img = pdfImage($client->attachment_aadhar_back_url))
                    <img src="{{ $img }}" class="img-box">
                @else
                    <span class="text-muted">Not available</span>
                @endif
            </td>

            <td class="text-center">
                @if ($img = pdfImage($client->attachment_ckyc_url))
                    <img src="{{ $img }}" class="img-box">
                @else
                    <span class="text-muted">Not available</span>
                @endif
            </td>

            <td class="text-center">
                @if ($img = pdfImage($client->attachment_signature_url))
                    <img src="{{ $img }}" class="img-box">
                @else
                    <span class="text-muted">Not available</span>
                @endif
            </td>

            <td class="text-center">
                @if ($img = pdfImage($client->attachment_other_documents_url))
                    <img src="{{ $img }}" class="img-box">
                @else
                    <span class="text-muted">Not available</span>
                @endif
            </td>
        </tr>
    </table>

    {{-- ================= FAMILY INFO ================= --}}
    <table>
        <tr>
            <th colspan="6" class="section-heading">Family Information</th>
        </tr>

        <tr>
            <th>Name</th>
            <th>Gender</th>
            <th>DOB</th>
            <th>Status</th>
            <th>Marital</th>
            <th>Relation</th>
        </tr>

        @forelse($client->families as $f)
            <tr>
                <td>{{ $f->name ?? '-' }}</td>
                <td>{{ $f->gender ?? '-' }}</td>
                <td>{{ $f->dob ? \Carbon\Carbon::parse($f->dob)->format('d-m-Y') : '-' }}</td>
                <td>{{ $f->live_status ?? '-' }}</td>
                <td>{{ $f->marital_status ?? '-' }}</td>
                <td>{{ $f->relation->main_relation ?? '-' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center text-muted">No family details found.</td>
            </tr>
        @endforelse
    </table>

    {{-- ================= BANK INFO ================= --}}
    <table>
        <tr>
            <th colspan="7" class="section-heading">Bank Information</th>
        </tr>

        <tr>
            <th>Holder Name</th>
            <th>Mode</th>
            <th>Bank / IFSC</th>
            <th>Account No</th>
            <th>Branch</th>
            <th>Primary</th>
            <th>Cheque</th>
        </tr>

        @forelse($client->banks as $b)
            <tr>
                <td>
                    {{ $b->holder_name_1 }}
                    @if ($b->holder_name_2)
                        <br>{{ $b->holder_name_2 }}
                    @endif
                    @if ($b->holder_name_3)
                        <br>{{ $b->holder_name_3 }}
                    @endif
                </td>
                <td>{{ $b->operation_mode }}</td>
                <td>{{ $b->bank_name }} / {{ $b->ifsc_code }}</td>
                <td>{{ $b->account_number }}</td>
                <td>{{ $b->branch_name }}</td>
                <td>{{ $b->is_primary ? 'Yes' : 'No' }}</td>
                <td class="text-center">
                    @if ($img = pdfImage($b->attachment_cancelled_cheque_url))
                        <img src="{{ $img }}" class="img-box">
                    @else
                        <span class="text-muted">Not available</span>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center text-muted">No bank details found.</td>
            </tr>
        @endforelse
    </table>

    <p class="text-center text-muted">
        This is a system-generated KYC document. No signature is required.
    </p>

</body>

</html>
