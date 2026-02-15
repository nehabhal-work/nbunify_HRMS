@extends('layouts.master-layout')
@section('title', 'Scheme Management')

@section('content')
    <style>
        table td {
            font-weight: bold;
        }

        table.table th {
            background-color: #f9f3fa !important;
            width: 25%;
            vertical-align: middle;
        }

        .onecolor {
            color: #BC13BE;
        }
    </style>


    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Master /</span> <a href="{{ route('investment.els.index') }}">Scheme details</a>
    </h4>

    <div class="div d-flex justify-content-end mb-3">
        <a href="{{ route('investment.scheme.index') }}" class="btn btn-secondary px-4">Go back</a>

    </div>

    {{-- {{ $scheme }} --}}
    <div class="container">
        <div class="card shadow-sm">
            {{-- ===================== --}}
            {{-- HEADER --}}
            {{-- ===================== --}}
            <div class="card-header bg-light">
                <h4 class="mb-0 text-secondary">
                    Scheme Details :
                    <span class="text-warning fw-semibold">
                        {{ $scheme->name_type_value }} – {{ $scheme->scheme_name }}
                    </span>
                </h4>
            </div>

            <div class="card-body p-0">
                <table class="table table-bordered investment-view mb-0">
                    <tbody>

                        {{-- ===================== --}}
                        {{-- DATE DETAILS --}}
                        {{-- ===================== --}}
                        <tr>
                            <th colspan="4" class="text-center onecolor">Date Details</th>
                        </tr>
                        <tr>
                            <th width="25%">Start Date</th>
                            <td width="25%">
                                {{ \Carbon\Carbon::parse($scheme->start_date)->format('d-m-Y') }}
                            </td>

                            <th width="25%">End Date</th>
                            <td width="25%">
                                {{ \Carbon\Carbon::parse($scheme->end_date)->format('d-m-Y') }}
                            </td>
                        </tr>

                        {{-- ===================== --}}
                        {{-- BASIC INFORMATION --}}
                        {{-- ===================== --}}
                        <tr>
                            <th colspan="4" class="text-center onecolor">Basic Information</th>
                        </tr>
                        <tr>
                            <th>Scheme Code</th>
                            <td>{{ $scheme->scheme_code ?? '—' }}</td>

                            <th>Scheme Name</th>
                            <td>{{ $scheme->scheme_name }}</td>
                        </tr>
                        <tr>
                            <th>Investment Type</th>
                            <td>{{ ucfirst($scheme->investment_type) }}</td>

                            <th>Tenure Type</th>
                            <td>{{ ucfirst($scheme->tenure_type) }}</td>
                        </tr>

                        {{-- ===================== --}}
                        {{-- ROI DETAILS --}}
                        {{-- ===================== --}}
                        <tr>
                            <th colspan="4" class="text-center onecolor">ROI Details</th>
                        </tr>
                        <tr>
                            <th>Minimum ROI</th>
                            <td>{{ $scheme->roi_min }}%</td>

                            <th>Maximum ROI</th>
                            <td>{{ $scheme->roi_max }}%</td>
                        </tr>
                        <tr>
                            <th>Additional ROI (Min)</th>
                            <td>{{ $scheme->roi_min_additional }}%</td>

                            <th>Additional ROI (Max)</th>
                            <td>{{ $scheme->roi_max_additional }}%</td>
                        </tr>

                        {{-- ===================== --}}
                        {{-- TENURE & EXIT DETAILS --}}
                        {{-- ===================== --}}
                        <tr>
                            <th colspan="4" class="text-center onecolor">Tenure & Exit Details</th>
                        </tr>
                        <tr>
                            <th>Minimum Tenure</th>
                            <td>{{ $scheme->tenure_min }} {{ $scheme->tenure_type }}</td>

                            <th>Maximum Tenure</th>
                            <td>{{ $scheme->tenure_max }} {{ $scheme->tenure_type }}</td>
                        </tr>
                        <tr>
                            <th>Lock-in Period</th>
                            <td>
                                {{ $scheme->lock_in_period }}
                                {{ $scheme->lock_in_period_type }}
                            </td>

                            <th>Exit Load</th>
                            <td>{{ $scheme->exit_load_percent }}%</td>
                        </tr>

                        {{-- ===================== --}}
                        {{-- PAYOUT FREQUENCY --}}
                        {{-- ===================== --}}
                        <tr>
                            <th>Payout Frequency</th>
                            <td colspan="3">
                                @forelse ($scheme->frequency as $freq)
                                    <span class="badge bg-primary me-1">
                                        {{ ucfirst($freq) }}
                                    </span>
                                @empty
                                    <span class="text-muted">Not Defined</span>
                                @endforelse
                            </td>
                        </tr>

                        {{-- ===================== --}}
                        {{-- APPROVAL STATUS --}}
                        {{-- ===================== --}}
                        <tr>
                            <th>Approval Status</th>
                            <td colspan="3">
                                @if ($scheme->approved3_by)
                                    <span class="badge bg-success">Approved</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pending Approval</span>
                                @endif
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>

            {{-- ===================== --}}
            {{-- ACTION FOOTER --}}
            {{-- ===================== --}}
            @if (!$scheme->is_approved)
                <div class="card-footer text-end bg-white">
                    <form action="{{ route('investment.scheme.approve', $scheme->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-success px-4">
                            <i class="bi bi-check-circle me-1"></i> Approve Scheme
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>





@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            function validateMinMax(minSelector, maxSelector, errorSelector, message) {

                let min = parseFloat($(minSelector).val());
                let max = parseFloat($(maxSelector).val());

                // clear error
                $(errorSelector).text('');

                if (!isNaN(min) && !isNaN(max)) {
                    if (max < min) {
                        $(errorSelector).text(message);
                    }
                }
            }

            // ROI validation
            $('#roi_min, #roi_max').on('input', function() {
                validateMinMax(
                    '#roi_min',
                    '#roi_max',
                    '#roi_error',
                    'Max ROI must be greater than Min ROI.'
                );
            });

            // Tenure validation
            $('#tenure_min, #tenure_max').on('input', function() {
                validateMinMax(
                    '#tenure_min',
                    '#tenure_max',
                    '#tenure_error',
                    'Max Tenure must be greater than Min Tenure.'
                );
            });

        });
        $('.datepicker-next').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            todayHighlight: true,
            clearBtn: true,
            endDate: false // disallow future dates
        });
    </script>
@endpush
