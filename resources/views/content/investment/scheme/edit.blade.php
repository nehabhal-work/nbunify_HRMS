@extends('layouts.master-layout')
@section('title', 'Scheme Management')

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
        <span class="text-muted fw-light">Master /</span>Scheme
    </h4>

    <div class="div d-flex justify-content-end mb-3">
        <a href="{{ route('investment.scheme.index') }}" class="btn btn-secondary px-4">Go back</a>
    </div>

    <form action="{{ route('investment.scheme.update', $scheme->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row align-items-stretch">
            <div class="col-md-12">
                <div class="card mb-4">

                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Edit Scheme</h5>
                        <small class="text-muted">Update Scheme Details</small>
                    </div>

                    <div class="card-body">
                        <div class="row">

                            {{-- Start Date --}}
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Start Date <span class="text-danger">*</span></label>
                                {{-- <input type="text" id="start_date"
                                    class="form-control datepicker @error('start_date') is-invalid @enderror"
                                    name="start_date" value="{{ old('start_date', $scheme->start_date) }}"> --}}
                                <input type="date" id="start_date"
                                    class="form-control datepicker1 @error('start_date') is-invalid @enderror"
                                    name="start_date"
                                    value="{{ old('start_date', \Carbon\Carbon::parse($scheme->start_date)->format('d-m-Y')) }}">

                                @error('start_date')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- End Date --}}
                            <div class="col-md-2 mb-3">
                                <label class="form-label">End Date <span class="text-danger">*</span></label>
                                <input type="date" id="end_date"
                                    class="form-control datepicker1 @error('end_date') is-invalid @enderror" name="end_date"
                                    value="{{ old('end_date', \Carbon\Carbon::parse($scheme->end_date)->format('d-m-Y')) }}">

                                @error('end_date')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Scheme Name --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Scheme Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('scheme_name') is-invalid @enderror"
                                    name="scheme_name" placeholder="Enter scheme name"
                                    value="{{ old('scheme_name', $scheme->scheme_name) }}">
                                @error('scheme_name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Min ROI --}}
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Min ROI (%)</label>
                                <input type="number" id="roi_min"
                                    class="form-control onlydigit @error('roi_min') is-invalid @enderror" name="roi_min"
                                    step="0.01" value="{{ old('roi_min', $scheme->roi_min) }}">
                                @error('roi_min')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Max ROI --}}
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Max ROI (%)</label>
                                <input type="number" id="roi_max"
                                    class="form-control onlydigit @error('roi_max') is-invalid @enderror" name="roi_max"
                                    step="0.01" value="{{ old('roi_max', $scheme->roi_max) }}">
                                @error('roi_max')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <small id="roi_error" class="text-danger"></small>
                            </div>

                            <!-- Additional ROI min -->
                            <div class="col-md-2 mb-3">
                                <label for="roi_min_additional" class="form-label">Min Additional ROI (%)</label>
                                <input type="number"
                                    class="form-control onlydigit @error('roi_min_additional') is-invalid @enderror"
                                    id="roi_min_additional" name="roi_min_additional" step="0.01"
                                    value="{{ old('roi_min_additional', $scheme->roi_min_additional) }}">
                                @error('roi_min_additional')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Additional ROI max -->
                            <div class="col-md-2 mb-3">
                                <label for="roi_max_additional" class="form-label">Max Additional ROI (%)</label>
                                <input type="number"
                                    class="form-control onlydigit @error('roi_max_additional') is-invalid @enderror"
                                    id="roi_max_additional" name="roi_max_additional" step="0.01"
                                    value="{{ old('roi_max_additional', $scheme->roi_max_additional) }}">
                                @error('roi_max_additional')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Tenure Type --}}
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Tenure Type <span class="text-danger">*</span></label>
                                <select name="tenure_type" class="form-control @error('tenure_type') is-invalid @enderror">
                                    <option value="" disabled>Select Tenure Type</option>
                                    <option value="days"
                                        {{ old('tenure_type', $scheme->tenure_type) == 'days' ? 'selected' : '' }}>Days
                                    </option>
                                    <option value="months"
                                        {{ old('tenure_type', $scheme->tenure_type) == 'months' ? 'selected' : '' }}>Months
                                    </option>
                                    <option value="years"
                                        {{ old('tenure_type', $scheme->tenure_type) == 'years' ? 'selected' : '' }}>Years
                                    </option>
                                </select>
                                @error('tenure_type')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Min Tenure --}}
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Minimum Tenure</label>
                                <input type="number" id="tenure_min"
                                    class="form-control onlydigit @error('tenure_min') is-invalid @enderror"
                                    name="tenure_min" value="{{ old('tenure_min', $scheme->tenure_min) }}">
                                @error('tenure_min')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Max Tenure --}}
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Maximum Tenure</label>
                                <input type="number" id="tenure_max"
                                    class="form-control onlydigit @error('tenure_max') is-invalid @enderror"
                                    name="tenure_max" value="{{ old('tenure_max', $scheme->tenure_max) }}">
                                @error('tenure_max')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <small id="tenure_error" class="text-danger"></small>
                            </div>

                            {{-- Frequency --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Payout Frequency <span class="text-danger">*</span></label>
                                <select name="frequency[]" multiple
                                    class="form-control select2 @error('frequency') is-invalid @enderror">

                                    @php
                                        $selectedFreq = old('frequency', $scheme->frequency ?? []);
                                    @endphp

                                    <option value="monthly" {{ in_array('monthly', $selectedFreq) ? 'selected' : '' }}>
                                        Monthly</option>
                                    <option value="quarterly"
                                        {{ in_array('quarterly', $selectedFreq) ? 'selected' : '' }}>Quarterly</option>
                                    <option value="half-yearly"
                                        {{ in_array('half-yearly', $selectedFreq) ? 'selected' : '' }}>Half-Yearly</option>
                                    <option value="yearly" {{ in_array('yearly', $selectedFreq) ? 'selected' : '' }}>
                                        Yearly</option>
                                    <option value="compounding"
                                        {{ in_array('compounding', $selectedFreq) ? 'selected' : '' }}>Compounding</option>

                                </select>
                                @error('frequency')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- exit_load_percent -->
                            <div class="col-md-2 mb-3">
                                <label for="exit_load_percent" class="form-label">Exit load (%)</label>
                                <input type="number"
                                    class="form-control onlydigit @error('exit_load_percent') is-invalid @enderror"
                                    id="exit_load_percent" name="exit_load_percent" step="0.01"
                                    value="{{ old('exit_load_percent', $scheme->exit_load_percent) }}">
                                @error('exit_load_percent')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>

                        {{-- Submit --}}
                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-primary px-4">Update</button>
                        </div>

                    </div>

                </div>
            </div>
        </div>

    </form>



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
