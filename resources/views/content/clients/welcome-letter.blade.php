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

        <!-- Greeting -->
        <p class="fw-semibold">
            Dear {{ ucwords(strtolower($client->name ?? 'Client')) }},
        </p>

        <p>
            Welcome to our system! We are pleased to inform you that your client profile has been
            successfully created.
        </p>

        <p>
            Your profile includes your <strong>personal details, bank details, and family details</strong>
            as provided during onboarding.
        </p>

        <!-- Investment Details -->
        <p class="fw-semibold mt-3">To ensure your information is always accurate and up to date, we have provided you with
            login access to our system. Using the credentials below, you can log in anytime and update (KYC update) your
            details if required.</p>


        <!-- Login Section -->
        <div class="mt-4 p-3 border rounded bg-light">
            <p class="fw-semibold mb-2">Client Login & Details Update</p>

            <p class="mb-2">
                If you wish to update (KYC update) or correct any of your details, you can log in to our
                client portal using the credentials below:
            </p>

            <p class="mb-1"><strong>Login URL:</strong> login url</p>
            <p class="mb-1"><strong>Username:</strong> login email</p>
            <p class="mb-0"><strong>Password:</strong> pwd</p>

            <p class="mt-2 text-muted mb-0">
                For security reasons, we recommend changing your password after your first login.
            </p>
        </div>

        <!-- Trust Message -->
        <p class="mt-4">
            We believe in transparency, trust, and long-term relationships.
            Our experienced team is always available to assist you whenever required.
        </p>

        <!-- Contact Section -->
        <div class="mt-4">
            <p class="fw-semibold mb-1">For any queries, feel free to contact us:</p>
            <p class="mb-0"><strong>Realation Manager:</strong> RM name provide</p>
            <p class="mb-0"><strong>Email:</strong> {{ $company->email }}</p>
            <p class="mb-0"><strong>Phone:</strong> {{ $company->phone }}</p>
            <p><strong>Website:</strong> {{ $company->website ?? 'www.yourcompany.com' }}</p>
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
        <a href="#" class="btn btn-primary">
            Download PDF
        </a>

        <a href="#" class="btn btn-success">
            Send Email
        </a>
    </div>

@endsection
