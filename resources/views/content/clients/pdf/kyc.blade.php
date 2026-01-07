<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Client KYC</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #000;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }

        th,
        td {
            border: 1px solid #444;
            padding: 6px;
            vertical-align: top;
        }

        th {
            background-color: #f2f2f2;
            text-align: left;
        }

        .section-heading {
            background-color: #ffebe4;
            text-align: center;
            font-weight: bold;
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

        img {
            max-width: 120px;
            max-height: 120px;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>

    <h3 class="text-center">Client KYC Details</h3>

    {{-- PERSONAL DETAILS --}}
    <table>
        <tr>
            <th colspan="4" class="section-heading">
                Personal Details
            </th>
        </tr>

        <tr>
            <th>Client Code</th>
            <td>{{ $client->client_code }}</td>
            <th>Name</th>
            <td>
                {{ strtoupper($client->salutation) }} {{ strtoupper($client->name) }}
                <br><br>
                @if ($client->attachment_client_photo_url)
                    <img src="{{ public_path($client->attachment_client_photo_url) }}">
                @endif
            </td>
        </tr>

        <tr>
            <th>Gender</th>
            <td>{{ ucfirst($client->gender) }}</td>
            <th>DOB</th>
            <td>{{ \Carbon\Carbon::parse($client->dob)->format('d-M-Y') }}</td>
        </tr>

        <tr>
            <th>Email</th>
            <td>{{ $client->email ?? '-' }}</td>
            <th>Mobile</th>
            <td>{{ $client->mobile_no }}</td>
        </tr>

        <tr>
            <th>PAN</th>
            <td>{{ $client->pan_no }}</td>
            <th>Aadhar</th>
            <td>{{ $client->aadhar_no }}</td>
        </tr>

        <tr>
            <th>Current Address</th>
            <td colspan="3">
                {{ $client->current_address }},
                {{ $client->current_city_code }},
                {{ $client->current_state_code }} -
                {{ $client->current_pincode }}
            </td>
        </tr>
    </table>

    {{-- ATTACHMENTS --}}
    <table>
        <tr>
            <th colspan="4" class="section-heading">Attachments</th>
        </tr>

        <tr>
            <th>PAN</th>
            <th>Aadhar</th>
            <th>CKYC</th>
            <th>Signature</th>
        </tr>

        <tr>
            <td>
                @if ($client->attachment_pan_url)
                    <img src="{{ public_path($client->attachment_pan_url) }}">
                @else
                    -
                @endif
            </td>

            <td>
                @if ($client->attachment_aadhar_front_url)
                    <img src="{{ public_path($client->attachment_aadhar_front_url) }}">
                @else
                    -
                @endif
            </td>

            <td>
                @if ($client->attachment_ckyc_url)
                    <img src="{{ public_path($client->attachment_ckyc_url) }}">
                @else
                    -
                @endif
            </td>

            <td>
                @if ($client->attachment_signature_url)
                    <img src="{{ public_path($client->attachment_signature_url) }}">
                @else
                    -
                @endif
            </td>
        </tr>
    </table>

    {{-- FAMILY INFO --}}
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
                <td>{{ $f->name }}</td>
                <td>{{ $f->gender }}</td>
                <td>{{ $f->dob ? \Carbon\Carbon::parse($f->dob)->format('d-m-Y') : '-' }}</td>
                <td>{{ $f->live_status }}</td>
                <td>{{ $f->marital_status }}</td>
                <td>{{ $f->relation->main_relation ?? '-' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center text-muted">No family details</td>
            </tr>
        @endforelse
    </table>

    {{-- BANK INFO --}}
    <table>
        <tr>
            <th colspan="6" class="section-heading">Bank Information</th>
        </tr>

        <tr>
            <th>Holder</th>
            <th>Mode</th>
            <th>Bank / IFSC</th>
            <th>Account No</th>
            <th>Branch</th>
            <th>Primary</th>
        </tr>

        @forelse($client->banks as $b)
            <tr>
                <td>{{ $b->holder_name_1 }}</td>
                <td>{{ $b->operation_mode }}</td>
                <td>{{ $b->bank_name }} / {{ $b->ifsc_code }}</td>
                <td>{{ $b->account_number }}</td>
                <td>{{ $b->branch_name }}</td>
                <td>{{ $b->is_primary ? 'Yes' : 'No' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center text-muted">No bank details</td>
            </tr>
        @endforelse
    </table>

    <p class="text-center text-muted">
        This is a system-generated KYC document. No signature required.
    </p>

</body>

</html>
