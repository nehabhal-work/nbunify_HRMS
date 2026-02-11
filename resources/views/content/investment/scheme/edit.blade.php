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
                                <input type="date" id="start_date"
                                    class="form-control  @error('start_date') is-invalid @enderror" name="start_date"
                                    value="{{ old('start_date', \Carbon\Carbon::parse($scheme->start_date)->format('Y-m-d')) }}">
                                {{-- <input type="date" id="start_date"
                                    class="form-control datepicker1 @error('start_date') is-invalid @enderror"
                                    name="start_date"
                                    value="{{ old('start_date', $scheme->start_date) }}"> --}}

                                @error('start_date')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- End Date --}}
                            <div class="col-md-2 mb-3">
                                <label class="form-label">End Date <span class="text-danger">*</span></label>
                                <input type="date" id="end_date"
                                    class="form-control datepicker1 @error('end_date') is-invalid @enderror" name="end_date"
                                    value="{{ old('end_date', \Carbon\Carbon::parse($scheme->end_date)->format('Y-m-d')) }}">

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


                            <!-- Scheme Name Type -->
                            <div class="col-md-2 mb-3">
                                <label for="name_type" class="form-label">
                                    Scheme Name Type <span class="text-danger">*</span>
                                </label>

                                <select name="name_type" id="name_type"
                                    class="form-select @error('name_type') is-invalid @enderror" required>
                                    <option value="">-- Select Scheme --</option>

                                    @foreach (config('scheme.name_types') as $code => $label)
                                        <option value="{{ $code }}"
                                            {{ old('name_type', $scheme->name_type ?? '') == $code ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('name_type')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="col-md-2 mb-3">
                                <label for="investment_type" class="form-label">
                                    Investment Category <span class="text-danger">*</span>
                                </label>

                                <select name="investment_type" id="investment_type"
                                    class="form-select @error('investment_type') is-invalid @enderror" required>
                                    <option value="">-- Select Category --</option>

                                    <option value="individual"
                                        {{ old('investment_type', $scheme->investment_type ?? '') == 'individual' ? 'selected' : '' }}>
                                        Individual
                                    </option>

                                    <option value="joint"
                                        {{ old('investment_type', $scheme->investment_type ?? '') == 'joint' ? 'selected' : '' }}>
                                        Joint
                                    </option>
                                </select>

                                @error('investment_type')
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
                                <select name="tenure_type"
                                    class="form-control @error('tenure_type') is-invalid @enderror">
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
                                <select name="frequency[]"
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

                            {{-- Lock-in Period Type --}}
                            <div class="col-md-2 mb-3">
                                <label class="form-label fw-semibold">
                                    Lock-in Period Type <span class="text-danger">*</span>
                                </label>
                                {{-- Lock-in Period Type --}}
                                <select class="form-select @error('lock_in_period_type') is-invalid @enderror"
                                    name="lock_in_period_type" id="lock_in_period_type" required>
                                    <option value="">Select</option>
                                    <option value="months"
                                        {{ old('lock_in_period_type', $scheme->lock_in_period_type) == 'months' ? 'selected' : '' }}>
                                        Months
                                    </option>
                                    <option value="years"
                                        {{ old('lock_in_period_type', $scheme->lock_in_period_type) == 'years' ? 'selected' : '' }}>
                                        Years
                                    </option>
                                </select>

                                @error('lock_in_period_type')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>


                            {{-- Lock-in Period --}}
                            <div class="col-md-2 mb-3">
                                <label class="form-label fw-semibold">
                                    Lock-in Period <span class="text-danger">*</span>
                                </label>
                                {{-- Lock-in Period --}}
                                <input type="number" min="1"
                                    class="form-control onlydigit @error('lock_in_period') is-invalid @enderror"
                                    name="lock_in_period" id="lock_in_period"
                                    value="{{ old('lock_in_period', $scheme->lock_in_period) }}" required>

                                @error('lock_in_period')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-2 mb-3">
                                <label class="form-label">
                                    Min Investment <span class="text-danger">*</span>
                                </label>

                                <input type="number" name="min_investment"
                                    class="form-control @error('min_investment') is-invalid @enderror" x min="0"
                                    value="{{ old('min_investment', $scheme->min_investment ?? '') }}">

                                @error('min_investment')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-2 mb-3">
                                <label class="form-label">
                                    Max Investment <span class="text-danger">*</span>
                                </label>

                                <input type="number" name="max_investment"
                                    class="form-control @error('max_investment') is-invalid @enderror" min="0"
                                    value="{{ old('max_investment', $scheme->max_investment ?? '') }}">

                                @error('max_investment')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="col-md-3 mb-3">
                                <label class="form-label">
                                    Investment Multiple off value
                                </label>

                                <input type="number" name="multiple_off"
                                    class="form-control @error('multiple_off') is-invalid @enderror" min="1"
                                    value="{{ old('multiple_off', $scheme->multiple_off ?? '') }}">

                                @error('multiple_off')
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

        $(document).ready(function() {

            function toggleLockInPeriod() {
                let type = $('#lock_in_period_type').val();

                if (type) {
                    $('#lock_in_period').prop('disabled', false);
                } else {
                    $('#lock_in_period').prop('disabled', true).val('');
                }
            }

            // On change
            $('#lock_in_period_type').on('change', function() {
                toggleLockInPeriod();
            });

            // On page load (IMPORTANT for edit page)
            toggleLockInPeriod();
        });
    </script>
@endpush
