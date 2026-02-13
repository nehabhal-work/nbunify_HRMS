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

                <div class="card-body  p-3">
                    <table class="table table-bordered table-sm mb-0 align-middle">
                        <tbody class="table-light">

                            <tr>
                                <th class="bg-light px-3 py-2">Investment ID</th>
                                <td class="px-3 py-2 text-muted">
                                    {{ $investment->id }}
                                </td>
                                <th class="bg-light px-3 py-2">Reference No</th>
                                <td class="px-3 py-2 fw-semibold">
                                    {{ $investmentSi->si_number }}
                                </td>


                            </tr>

                            <tr>
                                <th class="bg-light px-3 py-2">Company Bank</th>
                                <td class="px-3 py-2">
                                    {{ $investment->fromCompanyBank->bank_name }}
                                    <span class="text-muted">– {{ $investment->fromCompanyBank->account_number }}</span>
                                </td>

                                <th class="bg-light px-3 py-2">Client Bank</th>
                                <td class="px-3 py-2">
                                    {{ $investment->toClientBank->bank_name }}
                                    <span class="text-muted">– {{ $investment->toClientBank->account_number }}</span>
                                </td>
                            </tr>

                            <tr>
                                <th class="bg-light px-3 py-2">Payment Start Date</th>
                                <td class="px-3 py-2">
                                    {{ $investmentSi->si_start_date?->format('d M Y') }}
                                </td>

                                <th class="bg-light px-3 py-2">Payout Count</th>
                                <td class="px-3 py-2 fw-semibold">
                                    {{ $investmentSi->is_no_of_payments }}
                                </td>
                            </tr>

                            <tr>
                                <th class="bg-light px-3 py-2">Amount</th>
                                <td class="px-3 py-2 fw-bold text-primary">
                                    ₹ {{ number_format($investmentSi->si_amount, 2) }}
                                </td>
                                <th class="bg-light px-3 py-2">Status</th>
                                <td class="px-3 py-2">
                                    <span
                                        class="fw-semibold badge {{ $investmentSi->status == 'active' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }}">
                                        {{ ucfirst($investmentSi->status) }}
                                    </span>
                                </td>

                            </tr>

                            <tr>
                                <th class="bg-light px-3 py-2">Instruction Image</th>
                                <td class="px-3 py-2 text-muted">
                                    {{ $investmentSi->instruction_image ?? '-' }}
                                </td>

                                <th class="bg-light px-3 py-2">Notes Image</th>
                                <td class="px-3 py-2 text-muted">
                                    {{ $investmentSi->notes_image ?? '-' }}
                                </td>
                            </tr>

                            <tr>
                                <th class="bg-light px-3 py-2">Instruction Type</th>
                                <td class="text-warning"> <b> {{ $investmentSi->instruction_type }}</b></td>
                                <th class="bg-light px-3 py-2">Remarks</th>
                                <td  class="px-3 py-3 bg-warning-subtle fst-italic">
                                    {{ $investmentSi->remarks ?? '-' }}
                                </td>
                            </tr>

                        </tbody>
                    </table>

                    <div class="p-3 text-end">
                        @if ($investmentSi->status === 'active' && $investmentSi->is_approved != 1)
                            {{-- show approve button --}}
                            <form action="{{ route('investment.si.approve', $investmentSi->id) }}" method="post">
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
