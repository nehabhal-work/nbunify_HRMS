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


    <div class="container">
        <div class="card">
            <div class="card-header"><b class="card-title text-warning">Scheme Details</b></div>
            <table class="table table-bordered investment-view">

                <tbody>

                    {{-- ===================== --}}
                    {{-- DATE DETAILS --}}
                    {{-- ===================== --}}
                    <tr>
                        <th colspan="4" class="text-center onecolor">Date Details</th>
                    </tr>
                    <tr>
                        <th>Start Date</th>
                        <td>{{ \Carbon\Carbon::parse($scheme->start_date)->format('d-m-Y') }}</td>

                        <th>End Date</th>
                        <td>{{ \Carbon\Carbon::parse($scheme->end_date)->format('d-m-Y') }}</td>
                    </tr>

                    {{-- ===================== --}}
                    {{-- BASIC INFORMATION --}}
                    {{-- ===================== --}}
                    <tr>
                        <th colspan="4" class="text-center onecolor">Basic Information</th>
                    </tr>
                    <tr>
                        <th>Scheme Code</th>
                        <td>{{ $scheme->scheme_code }}</td>

                        <th>Scheme Name</th>
                        <td>{{ $scheme->scheme_name }}</td>
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
                        <th>Min Additional ROI</th>
                        <td>{{ $scheme->roi_min_additional }}%</td>

                        <th>Max Additional ROI</th>
                        <td>{{ $scheme->roi_max_additional }}%</td>
                    </tr>

                    {{-- ===================== --}}
                    {{-- TENURE DETAILS --}}
                    {{-- ===================== --}}
                    <tr>
                        <th colspan="4" class="text-center onecolor">Tenure Details</th>
                    </tr>
                    <tr>
                        <th>Tenure Type</th>
                        <td>{{ ucfirst($scheme->tenure_type) }}</td>

                        <th>Minimum Tenure</th>
                        <td>{{ $scheme->tenure_min }}</td>
                    </tr>
                    <tr>
                        <th>Maximum Tenure</th>
                        <td>{{ $scheme->tenure_max }}</td>

                        <th>Exit Load %</th>
                        <td>{{ $scheme->exit_load_percent }}</td>
                    </tr>
                    <tr>
                        <th>Lock-in Period Type</th>
                        <td>{{ $scheme->lock_in_period_type }}</td>

                        <th>Lock-in Period</th>
                        <td>{{ $scheme->lock_in_period }}</td>
                    </tr>

                    {{-- ===================== --}}
                    {{-- PAYOUT FREQUENCY --}}
                    {{-- ===================== --}}
                    <tr>
                        <th>Payout Frequency</th>
                        <td colspan="3">
                            @forelse ($scheme->frequency as $freq)
                                <span class="badge bg-primary me-1">{{ ucfirst($freq) }}</span>
                            @empty
                                -
                            @endforelse
                        </td>
                    </tr>

                </tbody>
            </table>

            {{-- ===================== --}}
            {{-- APPROVAL BUTTON --}}
            {{-- ===================== --}}
            <div class="text-end mt-3">
                @if (!$scheme->is_approved)
                    <form action="{{ route('investment.scheme.approve', $scheme->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-success px-4">
                            Approve
                        </button>
                    </form>
                @endif
            </div>
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
