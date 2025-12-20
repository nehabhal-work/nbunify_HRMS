@extends('layouts.master-layout')
@section('title', 'Investment')
@section('title', 'Investment-create')

@section('content')
    <div>
        @if (session('success'))
            <x-alert-sweet type="success" :message="session('success')" />
        @endif

        @if (session('error'))
            <x-alert-sweet type="danger" :message="session('error')" />
        @endif


    </div>
    <style>
        table td {
            font-weight: bold;

        }

        table.table th {
            background-color: #f9f3fa !important;
        }
    </style>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Master /</span> <a href="{{ route('investment.els.index') }}">ELS-Investment</a>
    </h4>

    <div class="div d-flex justify-content-end mb-3">
        <a href="{{ route('investment.els.index') }}" class="btn btn-secondary px-4">Go back</a>

    </div>

    <div class="container">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Investment Details</h5>
                <table class="table table-bordered mb-4 investment-view">
                    <tbody>
                        <tr>
                            <th>Investment Date</th>
                            <td>
                                <b>{{ \Carbon\Carbon::parse($investment->investment_date)->format('d M Y') }}</b>
                            </td>
                            <th>Investment Type</th>
                            <td><b>{{ ucfirst($investment->investment_type) }}</b></td>
                        </tr>

                        <tr>
                            <th>Investment Amount</th>
                            <td><b>₹ {{ number_format($investment->investment_amount, 2) }}</b></td>
                            <th>Frequency</th>
                            <td><b>{{ ucfirst($investment->frequency) }}</b></td>
                        </tr>

                        <tr>
                            <th>Tenure</th>
                            <td><b>{{ $investment->tenure_count }} {{ ucfirst($investment->tenure_type) }}</b></td>
                            <th>ROI (%)</th>
                            <td><b>{{ $investment->roi_percent }}%</b></td>
                        </tr>

                        <tr>
                            <th>Additional ROI</th>
                            <td><b>{{ $investment->additional_roi_percent }}%</b></td>
                            <th>TDS Applicable</th>
                            <td><b>{{ $investment->has_tds ? 'Yes' : 'No' }}</b></td>
                        </tr>

                        <tr>
                            <th>Schedule Count</th>
                            <td><b>{{ $investment->schedule_count }}</b></td>
                            <th>Annual Payout</th>
                            <td><b>₹ {{ number_format($investment->annual_payout, 2) }}</b></td>
                        </tr>

                        <tr>
                            <th>Payout Per Period</th>
                            <td><b>₹ {{ number_format($investment->payout_per_period, 2) }}</b></td>
                            <th>First Payout Date</th>
                            <td><b>{{ \Carbon\Carbon::parse($investment->first_payout_date)->format('d M Y') }}</b></td>
                        </tr>

                        <tr>
                            <th>Maturity Date</th>
                            <td><b>{{ \Carbon\Carbon::parse($investment->maturity_date)->format('d M Y') }}</b></td>
                            <th>Total Interest</th>
                            <td><b>₹ {{ number_format($investment->actual_interest_amount, 2) }}</b></td>
                        </tr>

                        <tr>
                            <th>Paid Interest</th>
                            <td><b>₹ {{ number_format($investment->paid_interest_amount, 2) }}</b></td>
                            <th>Rounding Off</th>
                            <td><b>₹ {{ number_format($investment->rounding_off_amount, 2) }}</b></td>
                        </tr>
                        <tr>

                            <th>Company Bank</th>
                            <td><b>{{ $investment->fromCompanyBank?->bank_name ?? '-' }}</b></td>
                            <th>Client Bank</th>
                            <td><b>{{ $investment->toClientBank?->bank_name ?? '-' }}</b></td>
                        </tr>
                    </tbody>
                </table>



                <h5 class="card-title">Bank Details</h5>

                <table class="table table-bordered  mb-4">
                    <tbody>
                        <tr>
                            <th>Company Bank</th>
                            <td><b>{{ $investment->fromCompanyBank?->bank_name ?? '-' }}</b></td>
                            <th>Company Account No</th>
                            <td><b>{{ $investment->fromCompanyBank?->account_number ?? '-' }}</b></td>
                        </tr>

                        <tr>
                            <th>Client Bank</th>
                            <td><b>{{ $investment->toClientBank?->bank_name ?? '-' }}</b></td>
                            <th>Client Account No</th>
                            <td><b>{{ $investment->toClientBank?->account_number ?? '-' }}</b></td>
                        </tr>



                    </tbody>

                </table>

                <h5 class="card-title">Nominee Details </h5>
                <table class="table table-bordered ">
                    <tbody>
                        <tr>
                            <th width="300">Nominee Name Percentage %</th>
                            {{-- <td><b>{{ $investment->nominees->nominee_name }}</b></td> --}}
                            <td colspan="3">
                                @foreach ($investment->nominees as $data)
                                    <b>{{ $data->client_family_id . '-' . $data->Percent }}</b><br>
                                @endforeach
                            </td>

                        </tr>

                    </tbody>
                </table>

                <div class="p-3 text-end">
                    @if (!$investment->is_approved)
                        {{-- show approve button --}}
                        <form action="{{ route('investment.approve', $investment->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-success px-4">
                                Approve
                            </button>

                        </form>
                    @else
                        {{-- hide button --}}
                    @endif


                </div>

            </div>
        </div>
    </div>



    @if ($errors->any() && old('scheme_id'))
        <script>
            $(document).ready(function() {
                $('#scheme_id').trigger('change'); // this will call loadSchemeData()
            });
        </script>
    @endif

    <meta name="csrf-token" content="{{ csrf_token() }}">

@endsection

@push('scripts')
@endpush
