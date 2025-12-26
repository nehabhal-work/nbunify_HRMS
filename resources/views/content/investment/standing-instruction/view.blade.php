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
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Standing Instruction Details</h5>
                    <a href="{{ route('investment.si.index', ['id' => $investment->id]) }}"
                        class="btn btn-sm btn-secondary">
                        Back
                    </a>
                </div>

                <div class="card-body p-0">
                    <table class="table table-bordered table-sm mb-0 align-middle">
                        <tbody>
                            <tr>
                                <th>Reference No</th>
                                <td><strong>{{ $investmentSi->si_number }}</strong></td>

                                <th>Status</th>
                                <td>
                                    <strong
                                        class="{{ $investmentSi->status == 'active' ? 'text-success' : 'text-danger' }}">
                                        {{ ucfirst($investmentSi->status) }}
                                    </strong>
                                </td>
                            </tr>

                            <tr>
                                <th>Company Bank</th>
                                <td>
                                    {{ $investment->fromCompanyBank->bank_name }}
                                    - {{ $investment->fromCompanyBank->account_number }}
                                </td>

                                <th>Client Bank</th>
                                <td>
                                    {{ $investment->toClientBank->bank_name }}
                                    - {{ $investment->toClientBank->account_number }}
                                </td>
                            </tr>

                            <tr>
                                <th>Payment Start Date</th>
                                <td>{{ $investmentSi->si_start_date?->format('d M Y') }}</td>

                                <th>Payout Count</th>
                                <td>{{ $investment->schedule_count }}</td>
                            </tr>

                            <tr>
                                <th>Amount</th>
                                <td>₹ {{ number_format($investmentSi->si_amount, 2) }}</td>

                                <th>Investment ID</th>
                                <td>{{ $investment->id }}</td>
                            </tr>

                            <tr>
                                <th>Instruction Image</th>
                                <td>
                                    {{ $investmentSi->instruction_image ?? '-' }}
                                </td>

                                <th>Notes Image</th>
                                <td>
                                    {{ $investmentSi->notes_image ?? '-' }}
                                </td>
                            </tr>

                            <tr>
                                <th>Remarks</th>
                                <td colspan="3">
                                    {{ $investmentSi->remarks ?? '-' }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
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


@endsection

@push('scripts')
    <script src="{{ asset('assets/js/investment.js') }}"></script>
@endpush
