@extends('layouts.master-layout')
@section('title', 'Investment')
@section('title', 'Investment-create')

@section('content')
    <div class="container">
        {{ $investment->approved_by->name }}
        {{-- <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($investment->approved4_on)->format('d F Y') }}</p>

        <p>
            To,<br>
            <strong>{{ $investment->first_client->name }}</strong><br>
            {{ $investment->first_client->res_address }}<br>
            {{ $investment->first_client->res_city }},
            {{ $investment->first_client->res_state }},
            {{ $investment->first_client->res_country }}
        </p>

        <p><strong>Subject: Confirmation of Business Loan Closure</strong></p>

        <p>Dear {{ $investment->first_client->name }},</p>

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
                    {{ strtoupper($investment->investment_input_bank[0]->instrument_type) }}
                    ({{ $investment->investment_input_bank[0]->client_reference_no }})
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
        </p> --}}

    </div>
@endsection
