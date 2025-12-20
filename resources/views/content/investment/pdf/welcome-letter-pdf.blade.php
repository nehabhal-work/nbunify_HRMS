<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Investment Welcome Letter</title>

    <style>
        @page {
            size: A4;
            margin: 30px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 14px;
            color: #000;
        }

        .letter-box {
            background: #ffffff;
            /* border: 1px solid #e5e5e5;
            border-radius: 6px; */
            padding: 35px;
        }

        .text-center {
            text-align: center;
        }

        .fw-bold {
            font-weight: bold;
        }

        .fw-semibold {
            font-weight: 600;
        }

        .header-line {
            height: 4px;
            width: 100px;
            background-color: #0d6efd;
            margin: 10px auto;
            border-radius: 5px;
        }

        p {
            line-height: 1.6;
            margin: 10px 0;
        }

        ul {
            padding-left: 18px;
        }

        ul li {
            margin-bottom: 6px;
        }

        .footer-text {
            font-size: 12px;
            color: #777;
            text-align: center;
            margin-top: 20px;
        }

        hr {
            border: none;
            border-top: 1px solid #ddd;
            margin: 20px 0;
        }
    </style>
</head>

<body>

    <div class="letter-box">

        <!-- Company Header -->
        <div class="text-center">
            <h2 class="fw-bold">{{ $company->name }}</h2>
            <div class="header-line"></div>
            <p>A Trusted Partner in Financial Growth</p>
        </div>

        <!-- Greeting -->
        <p class="fw-semibold">
            Dear {{ ucwords(strtolower($client->name ?? 'Client')) }},
        </p>

        <p>
            We are delighted to welcome you to <strong>{{ $company->name }}</strong>.
            Thank you for choosing us as your trusted partner for managing your financial journey.
        </p>

        <p>
            We are pleased to confirm that your investment has been successfully recorded in our system
            with the following details:
        </p>

        <p class="fw-semibold">Investment Summary:</p>

        <ul>
            <li><strong>Investment Amount:</strong> ₹{{ number_format($investment->investment_amount, 2) }}</li>
            <li><strong>Tenure:</strong> {{ $investment->tenure_count }} {{ ucfirst($investment->tenure_type) }}</li>
            <li><strong>ROI:</strong> {{ $investment->roi_percent }}%</li>
            <li><strong>Payout Frequency:</strong> {{ ucfirst($investment->frequency) }}</li>
            <li><strong>Annual Payout:</strong> ₹{{ number_format($investment->annual_payout, 2) }}</li>
            <li><strong>Total Interest:</strong> ₹{{ number_format($investment->actual_interest_amount, 2) }}</li>
            <li><strong>First Payout Date:</strong>
                {{ \Carbon\Carbon::parse($investment->first_payout_date)->format('d M Y') }}
            </li>
            <li><strong>Maturity Date:</strong>
                {{ \Carbon\Carbon::parse($investment->maturity_date)->format('d M Y') }}
            </li>
        </ul>

        <p>
            We believe in transparency, trust, and long-term relationships.
            Our experienced team will always be available to guide you with any assistance you need.
        </p>

        <!-- Contact -->
        <p class="fw-semibold">For any queries, feel free to contact us:</p>

        <p><strong>Email:</strong> {{ $company->email }}</p>
        <p><strong>Phone:</strong> {{ $company->phone }}</p>
        <p><strong>Website:</strong> www.yourcompany.com</p>

        <!-- Closing -->
        <p>
            We look forward to serving you and being a part of your financial success.
        </p>

        <p class="fw-semibold">Warm Regards,</p>
        <p>{{ $company->name }}</p>

        <hr>



    </div>

</body>

</html>
