@extends('layouts.master-layout')
@section('title', 'Client Welcome Letter')

@section('content')
    <style>
        .letter-box {
            background: #ffffff;
            border-radius: 8px;
            padding: 40px;
            border: 1px solid #e5e5e5;
        }

        .header-line {
            height: 4px;
            width: 100px;
            background: #0d6efd;
            border-radius: 5px;
        }

        .footer-text {
            font-size: 13px;
            color: #777;
        }
    </style>

    <div>
        @if (session('success'))
            <x-alert-sweet type="success" :message="session('success')" />
        @endif

        @if (session('error'))
            <x-alert-sweet type="danger" :message="session('error')" />
        @endif


    </div>

    <div class="letter-box shadow-sm">

        <!-- Company Header -->
        <div class="text-center mb-4">
            <h2 class="fw-bold">{{ $company->name }}</h2>
            <div class="header-line mx-auto"></div>
            <p class="text-muted mt-2">A Trusted Partner in Financial Growth</p>
        </div>
        {{-- {{ $client }} --}}
        <!-- Greeting -->
        <p class="fw-semibold">Dear {{ ucwords(strtolower($client->name ?? 'Client')) }}</p>

        <p>
            Welcome to our system! We are pleased to inform you that your client profile has been successfully created.
        </p>

        <!-- Body Content -->
        <p>
            We are pleased to confirm that your investment has been successfully recorded in our system with the following
            details:
        </p>

        <p>
            Investment Summary:
        </p>

        <ul>
            <li><strong>Investment Amount:</strong> ₹{{ number_format($investment->investment_amount, 2) }}</li>
            <li><strong>Tenure:</strong> {{ $investment->tenure_count }} {{ ucfirst($investment->tenure_type) }}</li>
            <li><strong>ROI:</strong> {{ $investment->roi_percent }}%</li>
            <li><strong>Payout Frequency:</strong> {{ ucfirst($investment->frequency) }}</li>
            <li><strong>Annual Payout:</strong> ₹{{ number_format($investment->annual_payout, 2) }}</li>
            <li><strong>Total Interest:</strong> ₹{{ number_format($investment->actual_interest_amount, 2) }}</li>
            <li><strong>First Payout Date:</strong>
                {{ \Carbon\Carbon::parse($investment->first_payout_date)->format('d M Y') }}</li>
            <li><strong>Maturity Date:</strong> {{ \Carbon\Carbon::parse($investment->maturity_date)->format('d M Y') }}
            </li>
        </ul>



        <p>
            We believe in transparency, trust and long-term relationships.
            Our experienced team will always be available to guide you with any assistance you need.
        </p>

        <!-- Contact Section -->
        <div class="mt-4">
            <p>
                For any queries, feel free to contact us:
            </p>

            <p class="mb-0"><strong>Email:</strong> {{ $company->email }}</p>
            <p class="mb-0"><strong>Phone:</strong> {{ $company->phone }}</p>
            <p><strong>Website:</strong> www.yourcompany.com</p>
        </div>

        <!-- Closing -->
        <p class="mt-4">
            We look forward to serving you and being a part of your financial success.
        </p>

        <p class="fw-semibold mb-1">Warm Regards,</p>
        <p class="mb-0">{{ $company->name }}</p>

        <hr>

        <!-- Footer -->
        <p class="footer-text text-center mb-0">
            This is an auto-generated welcome letter from {{ $company->name }}.
        </p>

    </div>

    <div class="mt-4 d-flex gap-2">
        <a href="{{ route('investment.welcome.pdf', $investment->id) }}" class="btn btn-primary">
            Download PDF
        </a>

        <a href="{{ route('investment.welcome.email', $investment->id) }}" class="btn btn-success">
            Send Email
        </a>
    </div>

@endsection
{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome Letter</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .letter-box {
            background: #ffffff;
            border-radius: 8px;
            padding: 40px;
            border: 1px solid #e5e5e5;
        }

        .header-line {
            height: 4px;
            width: 100px;
            background: #0d6efd;
            border-radius: 5px;
        }

        .footer-text {
            font-size: 13px;
            color: #777;
        }
    </style>
</head>

<body class="bg-light">

    <div class="container my-5">
        <div class="letter-box shadow-sm">

            <!-- Company Header -->
            <div class="text-center mb-4">
                <h2 class="fw-bold">{{ $company->name }}</h2>
                <div class="header-line mx-auto"></div>
                <p class="text-muted mt-2">A Trusted Partner in Financial Growth</p>
            </div>
            {{ $client }}
            <!-- Greeting -->
            <p class="fw-semibold">Dear {{ ucwords(strtolower($client->name ?? 'Client')) }}</p>

            <p>
                We are delighted to welcome you to <strong>{{ $company->name }}</strong>.
                Thank you for choosing us as your trusted partner for managing your financial journey.
            </p>

            <!-- Body Content -->
            <p>
                Your profile has been successfully created in our system.
                Our team will now ensure you receive complete support for your investments, documentation,
                services, and future financial planning.
            </p>

            <p>
                You can now access:
            </p>

            <ul>
                <li>Your investment portfolio</li>
                <li>Service requests & follow-ups</li>
                <li>Personalized financial solutions</li>
                <li>Secure document management</li>
            </ul>

            <p>
                We believe in transparency, trust and long-term relationships.
                Our experienced team will always be available to guide you with any assistance you need.
            </p>

            <!-- Contact Section -->
            <div class="mt-4">
                <p>
                    For any queries, feel free to contact us:
                </p>

                <p class="mb-0"><strong>Email:</strong> {{ $company->email }}</p>
                <p class="mb-0"><strong>Phone:</strong> {{ $company->phone }}</p>
                <p><strong>Website:</strong> www.yourcompany.com</p>
            </div>

            <!-- Closing -->
            <p class="mt-4">
                We look forward to serving you and being a part of your financial success.
            </p>

            <p class="fw-semibold mb-1">Warm Regards,</p>
            <p class="mb-0">{{ $company->name }}</p>

            <hr>

            <!-- Footer -->
            <p class="footer-text text-center mb-0">
                This is an auto-generated welcome letter from {{ $company->name }}.
            </p>

        </div>
    </div>

</body>

</html> --}}
