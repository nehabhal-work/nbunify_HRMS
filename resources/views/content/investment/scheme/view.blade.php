@extends('layouts.master-layout')
@section('title', 'Scheme Management')

@section('content')
    <style>
        .bigtext {
            font-size: 16px;
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
        <span class=" fw-light">Master /</span>Scheme
    </h4>

    <div class="div d-flex justify-content-end mb-3">
        <a href="{{ route('investment.scheme.index') }}" class="btn btn-secondary px-4">Go back</a>
    </div>

    <div class="p-4 border rounded-3 bg-light">

        <!-- Main Title -->
        <h5 class="fw-bold mb-4 text-center">Scheme Details</h5>

        <!-- Date Details -->
        <h6 class="fw-bold mt-3 mb-2">Date Details</h6>
        <div class="row gy-2 mb-3">
            <div class="col-md-6">
                <div class="bigtext ">Start Date</div>
                <b>
                    {{ \Carbon\Carbon::parse($scheme->start_date)->format('d-m-Y') }}
                </b>
            </div>

            <div class="col-md-6">
                <div class="bigtext ">End Date</div>
                <b>
                    {{ \Carbon\Carbon::parse($scheme->end_date)->format('d-m-Y') }}
                </b>
            </div>
        </div>

        <!-- Basic Information -->
        <h6 class="fw-bold mt-3 mb-2">Basic Information</h6>
        <div class="row gy-2 mb-3">
            <div class="col-md-6">
                <div class="bigtext ">Scheme Code</div>
                <b>{{ $scheme->scheme_code }}</b>
            </div>

            <div class="col-md-6">
                <div class="bigtext ">Scheme Name</div>
                <b>{{ $scheme->scheme_name }}</b>
            </div>
        </div>

        <!-- ROI Details -->
        <h6 class="fw-bold mt-3 mb-2">ROI Details</h6>
        <div class="row gy-2 mb-3">
            <div class="col-md-6">
                <div class="bigtext ">Minimum ROI</div>
                <b>{{ $scheme->roi_min }}%</b>
            </div>

            <div class="col-md-6">
                <div class="bigtext ">Maximum ROI</div>
                <b>{{ $scheme->roi_max }}%</b>
            </div>

            <div class="col-md-6">
                <div class="bigtext ">Min Additional ROI</div>
                <b>
                    {{ $scheme->roi_min_additional }}%</b>
            </div>

            <div class="col-md-6">
                <div class="bigtext ">Max Additional ROI</div>
                <b>
                    {{ $scheme->roi_max_additional }}%</b>
            </div>
        </div>

        <!-- Tenure Details -->
        <h6 class="fw-bold mt-3 mb-2">Tenure Details</h6>
        <div class="row gy-2 mb-3">
            <div class="col-md-4">
                <div class="bigtext ">Tenure Type</div>
                <b>
                    {{ ucfirst($scheme->tenure_type) }}</b>
            </div>

            <div class="col-md-4">
                <div class="bigtext ">Minimum Tenure</div>
                <b>{{ $scheme->tenure_min }}</b>
            </div>

            <div class="col-md-4">
                <div class="bigtext ">Maximum Tenure</div>
                <b>{{ $scheme->tenure_max }}</b>
            </div>
        </div>

        <!-- Frequency -->
        <h6 class="fw-bold mt-3 mb-2">Payout Frequency</h6>
        <b>
            @foreach ($scheme->frequency as $freq)
                <span class="badge bg-primary me-1">{{ ucfirst($freq) }}</span>
            @endforeach
        </b>


       

        <div class="p-3 text-end">
            @if (!$scheme->is_approved)
                {{-- show approve button --}}
                <form action="{{ route('investment.scheme.approve', $scheme->id) }}" method="post">
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
