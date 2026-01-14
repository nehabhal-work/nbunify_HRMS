<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Client Information Form</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #000;
            margin: 20px;
        }

        .card {
            border: 1.5px solid #000;
            padding: 12px;
            margin-bottom: 20px;
        }

        .card-header {
            border-bottom: 1px solid #000;
            padding-bottom: 6px;
            margin-bottom: 10px;
        }

        .card-header h3 {
            margin: 0;
            font-size: 16px;
            text-transform: uppercase;
        }

        .card-header small {
            font-size: 11px;
            color: #333;
        }

        .section-title {
            margin-top: 15px;
            margin-bottom: 5px;
            padding: 6px;
            font-weight: bold;
            background: #f2f2f2;
            border: 1px solid #000;
            text-transform: uppercase;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        td {
            border: 1px solid #000;
            padding: 10px 6px;
            vertical-align: middle;
        }

        .label {
            width: 22%;
            font-weight: bold;
            background: #fafafa;
        }

        .value {
            width: 28%;
            height: 28px;
        }

        .checkbox {
            font-size: 14px;
            letter-spacing: 2px;
        }

        .note {
            font-size: 10px;
            margin-top: 6px;
            color: #333;
        }
    </style>
</head>

<body>

    <!-- ================= PRIMARY INFORMATION ================= -->
    <div class="card">
        <div class="card-header">
            <h3>Primary Information</h3>
            <small>Client Basic Details (To be filled in BLOCK letters)</small>
        </div>

        <table>
            <tr>
                <td class="label">Full Name</td>
                <td class="value" colspan="3"></td>
            </tr>

            <tr>
                <td class="label">Gender</td>
                <td class="value checkbox">
                    ☐ Male &nbsp;&nbsp; ☐ Female &nbsp;&nbsp; ☐ Other
                </td>

                <td class="label">Date of Birth</td>
                <td class="value"></td>
            </tr>

            <tr>
                <td class="label">Live Status</td>
                <td class="value checkbox">
                    ☐ Alive &nbsp;&nbsp; ☐ Deceased
                </td>

                <td class="label">Marital Status</td>
                <td class="value"></td>
            </tr>

            <tr>
                <td class="label">Nationality</td>
                <td class="value"></td>

                <td class="label">Occupation</td>
                <td class="value"></td>
            </tr>

            <tr>
                <td class="label">PAN Number</td>
                <td class="value"></td>

                <td class="label">Aadhaar Number</td>
                <td class="value"></td>
            </tr>

            <tr>
                <td class="label">CKYC Number</td>
                <td class="value"></td>

                <td class="label">Mobile Number</td>
                <td class="value"></td>
            </tr>

            <tr>
                <td class="label">WhatsApp Number</td>
                <td class="value"></td>

                <td class="label">Email Address</td>
                <td class="value"></td>
            </tr>

            <tr>
                <td class="label">Remarks (if any)</td>
                <td class="value" colspan="3" style="height:40px;"></td>
            </tr>
        </table>

        <!-- RESIDENTIAL ADDRESS -->
        <div class="section-title">Residential Address</div>
        <table>
            <tr>
                <td class="label">Complete Address</td>
                <td class="value" colspan="3" style="height:40px;"></td>
            </tr>

            <tr>
                <td class="label">City</td>
                <td class="value"></td>

                <td class="label">State</td>
                <td class="value"></td>
            </tr>

            <tr>
                <td class="label">Country</td>
                <td class="value"></td>

                <td class="label">Pincode</td>
                <td class="value"></td>
            </tr>
        </table>

        <!-- OFFICE ADDRESS -->
        <div class="section-title">Office Address</div>
        <table>
            <tr>
                <td class="label">Complete Address</td>
                <td class="value" colspan="3" style="height:40px;"></td>
            </tr>

            <tr>
                <td class="label">City</td>
                <td class="value"></td>

                <td class="label">State</td>
                <td class="value"></td>
            </tr>

            <tr>
                <td class="label">Country</td>
                <td class="value"></td>

                <td class="label">Pincode</td>
                <td class="value"></td>
            </tr>
        </table>
    </div>

    <!-- ================= FAMILY INFORMATION ================= -->
    <div class="card">
        <div class="card-header">
            <h3>Family Information</h3>
            <small>Details of Family Member</small>
        </div>

        <table>
            <tr>
                <td class="label">Full Name</td>
                <td class="value" colspan="3"></td>
            </tr>

            <tr>
                <td class="label">Gender</td>
                <td class="value checkbox">
                    ☐ Male &nbsp;&nbsp; ☐ Female
                </td>

                <td class="label">Date of Birth</td>
                <td class="value"></td>
            </tr>

            <tr>
                <td class="label">Relation with Client</td>
                <td class="value"></td>

                <td class="label">Mobile Number</td>
                <td class="value"></td>
            </tr>

            <tr>
                <td class="label">PAN Number</td>
                <td class="value"></td>

                <td class="label">Aadhaar Number</td>
                <td class="value"></td>
            </tr>

            <tr>
                <td class="label">Remarks</td>
                <td class="value" colspan="3" style="height:35px;"></td>
            </tr>
        </table>
    </div>

    <!-- ================= BANK INFORMATION ================= -->
    <div class="card">
        <div class="card-header">
            <h3>Bank Information</h3>
            <small>Client Bank Account Details</small>
        </div>

        <table>
            <tr>
                <td class="label">Bank Name</td>
                <td class="value"></td>

                <td class="label">Branch Name</td>
                <td class="value"></td>
            </tr>

            <tr>
                <td class="label">IFSC Code</td>
                <td class="value"></td>

                <td class="label">MICR Code</td>
                <td class="value"></td>
            </tr>

            <tr>
                <td class="label">Account Number</td>
                <td class="value"></td>

                <td class="label">Account Type</td>
                <td class="value checkbox">
                    ☐ Savings &nbsp; ☐ Current &nbsp; ☐ Other
                </td>
            </tr>

            <tr>
                <td class="label">Mode of Operation</td>
                <td class="value checkbox">
                    ☐ Single &nbsp;&nbsp; ☐ Joint
                </td>

                <td class="label">Cancelled Cheque</td>
                <td class="value checkbox">
                    ☐ Attached
                </td>
            </tr>
        </table>

        <div class="note">
            Note: Please attach self-attested copies of PAN, Aadhaar, and cancelled cheque.
        </div>
    </div>

</body>

</html>
