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

    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Master /</span> <a href="{{ route('investment.els.create') }}">ELS-Payout
            schedue</a>
    </h4>

    <div class="row">
        <!-- TABLE SECTION -->

        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Review Payout Schedule</h5>

                    <a class="btn btn-primary btn-sm" href="#">
                        Confirm
                    </a>
                </div>

                <div class="card-body">

                    <!-- Info Message -->
                    <div class="alert alert-warning mb-4" role="alert">
                        <strong>Note:</strong> Review your payout data carefully.
                        <br>Once confirmed, you will <strong>not be able to make any changes.</strong>
                    </div>

                    <div class="table-responsive text-nowrap">
                        <table class="table table-bordered table-striped">
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

                </div>
            </div>

        </div>
    </div>



@endsection

@push('scripts')
@endpush
