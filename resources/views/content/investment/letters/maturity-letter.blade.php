<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Investment Maturity Notification</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 14px;
            color: #333;
            line-height: 1.6;
        }

        .container {
            width: 100%;
        }

        .header {
            margin-bottom: 20px;
        }

        .company-name {
            font-size: 18px;
            font-weight: bold;
        }

        .divider {
            border-bottom: 1px solid #ccc;
            margin: 10px 0 20px 0;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }

        .details-table th,
        .details-table td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        .details-table th {
            background-color: #f5f5f5;
        }

        .action-box {
            background: #f9f9f9;
            border: 1px solid #ddd;
            padding: 12px;
            margin: 20px 0;
        }

        .footer {
            margin-top: 40px;
        }

        .btn {
            display: inline-block;
            padding: 10px 16px;
            background: #0d6efd;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="container">

        {{-- Header --}}
        <div class="header">
            <div class="company-name">companyName </div>
            <div>companyAddress </div>
            <div>Email: companyEmail | Phone: companyPhone </div>
        </div>

        <div class="divider"></div>

        {{-- Date --}}
        <p><strong>Date:</strong> {{ \Carbon\Carbon::now()->format('d-m-Y') }}</p>

        {{-- Client --}}
        <p>
            <strong>To,</strong><br>
            clientName <br>
            clientAddress
        </p>

        <p><strong>Subject:</strong> Investment Maturity Notification</p>

        {{-- Body --}}
        <p>Dear clientName,</p>

        <p>
            We hope this letter finds you well.
            This is to formally inform you that your investment with
            <strong>companyName </strong> is reaching its maturity.
            Kindly review the investment details mentioned below.
        </p>

        {{-- Investment Details --}}
        <table class="details-table">
            <tr>
                <th>Investment ID</th>
                <td>{investment->investment_no </td>
            </tr>
            <tr>
                <th>Investment Date</th>
                <td>start date</td>
                {{-- <td>{{ \Carbon\Carbon::parse($investment->start_date)->format('d-m-Y') }}</td> --}}
            </tr>
            <tr>
                <th>Maturity Date</th>
                <td>maturity_date</td>
                {{-- <td>{{ \Carbon\Carbon::parse($investment->maturity_date)->format('d-m-Y') }}</td> --}}
            </tr>
            <tr>
                <th>Principal Amount</th>
                <td>principal_amount</td>
                {{-- <td>₹ {{ number_format($investment->principal_amount, 2) }}</td> --}}
            </tr>
            <tr>
                <th>Interest Amount</th>
                <td>interest_amount</td>
                {{-- <td>₹ {{ number_format($investment->interest_amount, 2) }}</td> --}}
            </tr>
            <tr>
                <th>Total Maturity Value</th>
                <td>total_amount</td>
                {{-- <td><strong>₹ {{ number_format($investment->total_amount, 2) }}</strong></td> --}}
            </tr>
        </table>

        {{-- Action --}}
        <div class="action-box">
            <p>
                To proceed further, kindly submit your maturity instructions
                by clicking the link below:
            </p>

            <p style="text-align:center;">
                <a href="{{ route('investment.maturity-kyc') }}" class="btn">
                    Submit Maturity Instructions
                </a>
            </p>

            <p>
                You may choose to renew or close the investment, confirm
                payout details, or provide additional instructions through
                the above link.
            </p>
        </div>

        <p>
            We request you to submit your response on or before
            <strong>30 dec 2025</strong>
            {{-- <strong>{{ \Carbon\Carbon::parse($responseDeadline)->format('d-m-Y') }}</strong> --}}
            to avoid any delay in processing.
        </p>

        <p>
            In case of any assistance, please feel free to contact us.
        </p>

        {{-- Footer --}}
        <div class="footer">
            <p>
                Yours sincerely,<br>
                <strong>companyName</strong><br>
                Investment Management Team
            </p>
        </div>

    </div>

</body>

</html>
