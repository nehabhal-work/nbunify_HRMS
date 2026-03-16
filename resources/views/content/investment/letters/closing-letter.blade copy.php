@extends('layouts.master-layout')
@section('title', 'Investment')
@section('title', 'Investment-create')

@section('content')
    <div class="container">
        {{-- {{ $investment }} --}}
        <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($investment->approved3_on)->format('d F Y') }}</p>

        <p>
            To,<br>
            <strong>{{ $investment->firstClient->name }}</strong><br>
            {{ $investment->firstClient->res_address }}<br>
            {{ $investment->firstClient->res_city }},
            {{ $investment->firstClient->res_state }},
            {{ $investment->firstClient->res_country }}
        </p>

        <p><strong>Subject: Confirmation of Business Loan Closure</strong></p>

        <p>Dear {{ $investment->firstClient->name }},</p>

        <p>
            This letter is to formally confirm that the business loan of
            <strong>Rs. {{ number_format($investment->investment_amount, 2) }}</strong>
            provided by you on
            <strong>{{ \Carbon\Carbon::parse($investment->investment_date)->format('d F Y') }}</strong>
            has been fully repaid.
        </p>

        <p>
            As of
            <strong>{{ \Carbon\Carbon::parse($investment->maturity_date)->format('d F Y') }}</strong>,
            the total outstanding amount, including all applicable principal and interest, has been paid.
        </p>

        <h4>Details of Closure</h4>

        <table border="1" cellpadding="8" width="100%">
            <tr>
                <td><strong>Loan Amount</strong></td>
                <td>Rs. {{ number_format($investment->investment_amount, 2) }}</td>
            </tr>

            <tr>
                <td><strong>Interest Paid</strong></td>
                <td>Rs. {{ number_format($investment->paid_interest_amount, 2) }}</td>
            </tr>

            <tr>
                <td><strong>Total Amount Repaid</strong></td>
                <td>
                    Rs. {{ number_format($investment->investment_amount + $investment->paid_interest_amount, 2) }}
                </td>
            </tr>

            <tr>
                <td><strong>Final Payment Mode</strong></td>
                <td>
                    {{ strtoupper($investment->investmentInputBank[0]->instrument_type) }}
                    ({{ $investment->investmentInputBank[0]->client_reference_no }})
                </td>
            </tr>

            <tr>
                <td><strong>Date of Final Settlement</strong></td>
                <td>{{ \Carbon\Carbon::parse($investment->maturity_date)->format('d F Y') }}</td>
            </tr>

            <tr>
                <td><strong>Investment Code</strong></td>
                <td>{{ $investment->investment_code }}</td>
            </tr>

        </table>

        <br>

        <p>
            We confirm that there are no further dues or outstanding liabilities associated with this loan,
            and the loan account is hereby closed.
        </p>

        <p>
            We truly appreciate your financial support, which has been instrumental to our business.
        </p>

        <p>Kindly retain this letter for your records.</p>

        <br><br>

        <p>
            Sincerely,<br><br>

            <strong>{{ $company->authorized_signatory ?? 'Authorized Signatory' }}</strong><br>
            {{ $company->name }}<br>
            {{ $company->phone ?? '' }}
        </p>

    </div>
@endsection
