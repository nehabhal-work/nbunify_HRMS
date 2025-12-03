@extends('layouts.master-layout')
@section('title', 'Investment')

@section('content')
    <div>
        @if (session('success'))
            <x-alert-sweet type="success" :message="session('success')" />
        @endif

        @if (session('error'))
            <x-alert-sweet type="danger" :message="session('error')" />
        @endif


    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <div class="d-flex align-items-center justify-content-between mb-4">
        <h4 class="fw-bold py-3 mb-0">
            <span class="text-muted fw-light">Master /</span>
            <span class="text-primary">ELS-Payout Schedule</span>
            <br>
            <div class="mt-2 small text-secondary">
                For <strong class="text-dark">{{ $client->name }}</strong>
                <span class="mx-2">|</span>
                Scheme: <strong class="text-primary">{{ $scheme->scheme_name }}</strong>
                <span class="mx-2">|</span>
                Code: <span class="text-muted">{{ $scheme->scheme_code }}</span>
            </div>


        </h4>
    </div>


    <!-- Investment Summary -->
    <div class="card shadow-sm mb-4 p-4">
        <h6 class="fw-bold mb-2">Investment Summary</h6>

        <div class="row mb-1">
            <div class="col-md-4">
                <strong>Investment Date:</strong>
                {{ \Carbon\Carbon::parse($result['investment_date'])->format('d-M-Y') }}
            </div>

            <div class="col-md-4">
                <strong>Investment Type:</strong>
                {{ ucfirst($result['investment_type']) }}
            </div>

            <div class="col-md-4">
                <strong>Investment Amount:</strong>
                ₹{{ number_format($result['investment_amount'], 2) }}
            </div>
        </div>

        <div class="row mb-1">
            <div class="col-md-4">
                <strong>Tenure:</strong>
                {{ $result['tenure_count'] }} {{ ucfirst($result['tenure_type']) }}
            </div>

            <div class="col-md-4">
                <strong>Frequency:</strong>
                {{ ucfirst($result['frequency']) }}
            </div>

            <div class="col-md-4">
                <strong>ROI (%):</strong>
                {{ $result['roi_percent'] }}%
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <strong>Annual Payout:</strong>
                ₹{{ number_format($result['annual_payout'], 2) }}
            </div>

            <div class="col-md-4">
                <strong>Client Bank ID:</strong>
                {{ $result['client_bank_id'] ?: '-' }}
            </div>

            <div class="col-md-4">
                <strong>Company Bank ID:</strong>
                {{ $result['company_bank_id'] ?: '-' }}
            </div>
        </div>
    </div>


    <div class="row">
        <!-- TABLE SECTION -->

        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Review Payout Schedule</h5>


                </div>

                <div class="card-body">

                    <!-- Info Message -->


                    <div class="table-responsive text-nowrap">
                        <table class="table table-bordered table-striped srkdataTable">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 60px;">#</th>
                                    <th>Payout Date</th>
                                    <th>Amount (₹)</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($result['payout_schedule'] as $d)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>

                                        <td>
                                            {{ $d['payout_date'] ? \Carbon\Carbon::parse($d['payout_date'])->format('d-M-Y') : '-' }}
                                        </td>

                                        <td>{{ number_format($d['amount'], 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div>
                        {{-- <a class="btn btn-primary " href="{{ view('content.investment.standing-instruction.index') }}">
                            Set Standing instruction
                        </a> --}}
                    </div>

                </div>
            </div>

        </div>
    </div>



@endsection

@push('scripts')
@endpush
