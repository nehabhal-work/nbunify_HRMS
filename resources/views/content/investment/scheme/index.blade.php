@extends('layouts.master-layout')
@section('title', 'Investment Management')

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


    <form action="{{ route('investment.scheme.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('POST')

        <div class="row align-items-stretch">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Scheme Information</h5>
                        <small class="text-muted float-end">Scheme Basic Details</small>
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <!-- Start Date -->
                            <div class="col-md-2 mb-3">
                                <label for="start_date" class="form-label">Start Date <span
                                        class="text-danger">*</span></label>
                                <input type="text"
                                    class="form-control datepicker @error('start_date') is-invalid @enderror"
                                    id="start_date" name="start_date" value="{{ old('start_date') }}">
                                @error('start_date')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- End Date -->
                            <div class="col-md-2 mb-3">
                                <label for="end_date" class="form-label">End Date <span class="text-danger">*</span></label>
                                <input type="text"
                                    class="form-control datepicker-next @error('end_date') is-invalid @enderror"
                                    id="end_date" name="end_date" value="{{ old('end_date') }}">
                                @error('end_date')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>


                            <!-- Scheme Name -->
                            <div class="col-md-4 mb-3">
                                <label for="scheme_name" class="form-label">Scheme Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('scheme_name') is-invalid @enderror"
                                    id="scheme_name" name="scheme_name" placeholder="Enter scheme name"
                                    value="{{ old('scheme_name') }}">
                                @error('scheme_name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Min ROI -->
                            <div class="col-md-2 mb-3">
                                <label for="roi_min" class="form-label">Min ROI (%)</label>
                                <input type="number" class="form-control onlydigit @error('roi_min') is-invalid @enderror"
                                    id="roi_min" name="roi_min" step="0.01" value="{{ old('roi_min') }}">
                                @error('roi_min')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Max ROI -->
                            <div class="col-md-2 mb-3">
                                <label for="roi_max" class="form-label">Max ROI (%)</label>
                                <input type="number" class="form-control onlydigit @error('roi_max') is-invalid @enderror"
                                    id="roi_max" name="roi_max" step="0.01" value="{{ old('roi_max') }}">
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
                                    value="{{ old('roi_min_additional') }}">
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
                                    value="{{ old('roi_max_additional') }}">
                                @error('roi_max_additional')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Tenure Type -->
                            <div class="col-md-2 mb-3">
                                <label for="tenure_type" class="form-label">Tenure Type <span
                                        class="text-danger">*</span></label>
                                <select name="tenure_type" id="tenure_type"
                                    class="form-control @error('tenure_type') is-invalid @enderror">
                                    <option value="" disabled selected>Select Tenure Type</option>
                                    <option value="days" {{ old('tenure_type') == 'days' ? 'selected' : '' }}>Days
                                    </option>
                                    <option value="months" {{ old('tenure_type') == 'months' ? 'selected' : '' }}>Months
                                    </option>
                                    <option value="years" {{ old('tenure_type') == 'years' ? 'selected' : '' }}>Years
                                    </option>
                                </select>
                                @error('tenure_type')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Min Tenure -->
                            <div class="col-md-2 mb-3">
                                <label for="tenure_min" id="min_tenure_label" class="form-label">Min Tenure</label>
                                <input type="number"
                                    class="form-control onlydigit @error('tenure_min') is-invalid @enderror"
                                    id="tenure_min" name="tenure_min" value="{{ old('tenure_min') }}">
                                @error('tenure_min')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Max Tenure -->
                            <div class="col-md-2 mb-3">
                                <label for="tenure_max" id=max_tenure_label class="form-label">Max Tenure</label>
                                <input type="number"
                                    class="form-control onlydigit @error('tenure_max') is-invalid @enderror"
                                    id="tenure_max" name="tenure_max" value="{{ old('tenure_max') }}">
                                @error('tenure_max')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <small id="tenure_error" class="text-danger"></small>
                            </div>

                            <!-- Frequency Dropdown -->
                            <div class="col-md-4 mb-3">
                                <label for="frequency" class="form-label">Payout Frequency <span
                                        class="text-danger">*</span></label>
                                <select name="frequency[]" id="frequency" multiple
                                    class="form-control select2 @error('frequency') is-invalid @enderror">
                                    <option value="monthly" {{ old('frequency') == 'monthly' ? 'selected' : '' }}
                                        selected>Monthly
                                    </option>
                                    <option value="quarterly" {{ old('frequency') == 'quarterly' ? 'selected' : '' }}>
                                        Quarterly</option>
                                    <option value="half-yearly" {{ old('frequency') == 'half-yearly' ? 'selected' : '' }}>
                                        Half-Yearly</option>
                                    <option value="yearly" {{ old('frequency') == 'yearly' ? 'selected' : '' }}>Yearly
                                    </option>
                                    <option value="compounding" {{ old('frequency') == 'compounding' ? 'selected' : '' }}>
                                        Compounding</option>
                                </select>
                                @error('frequency')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>


                        <!-- Submit -->
                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-primary px-4">Save</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </form>



    <!-- TABLE SECTION -->
    <div class="row">
        {{-- {{ $schemes }} --}}
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Scheme List</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table srkdataTable ">
                            <thead>
                                <tr>
                                    <th>Scheme ID</th>
                                    <th>Date</th>
                                    <th>Name</th>
                                    <th>ROI (%)</th>
                                    <th>Addi ROI (%)</th>
                                    <th>Tenure Type</th>
                                    <th>Tenure</th>
                                    <th>Frequency</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($schemes as $key => $scheme)
                                    <tr>
                                        <td>{{ $scheme->scheme_code }}</td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($scheme->start_date)->format('d-m-Y') }}
                                            to
                                            {{ \Carbon\Carbon::parse($scheme->end_date)->format('d-m-Y') }}
                                        </td>
                                        <td data-bs-toggle="modal" data-bs-target="#viewSchemeModal{{ $scheme->id }}">
                                            {{ $scheme->scheme_name }}</td>
                                        <td>{{ $scheme->roi_min }}% - {{ $scheme->roi_max }}%</td>
                                        <td>{{ $scheme->roi_min_additional }}% - {{ $scheme->roi_max_additional }}%</td>
                                        <td>{{ ucfirst($scheme->tenure_type) }}</td>
                                        <td>{{ $scheme->tenure_min }} - {{ $scheme->tenure_max }}</td>

                                        <td>
                                            @foreach ($scheme->frequency as $freq)
                                                <span class="badge bg-primary me-1">{{ ucfirst($freq) }}</span>
                                            @endforeach
                                        </td>

                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>

                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item"
                                                        href="{{ route('investment.scheme.edit', $scheme->id) }}">
                                                        <i class="bx bx-edit-alt me-1"></i> Edit
                                                    </a>

                                                    <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                                        data-bs-target="#viewSchemeModal{{ $scheme->id }}">
                                                        <i class="bx bx-show me-1"></i> View
                                                    </a>

                                                    <form action="{{ route('investment.scheme.destroy', $scheme->id) }}"
                                                        method="post" onsubmit="return confirmDelete()">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="dropdown-item text-danger delete-btn"
                                                            data-id="{{ $scheme->id }}">
                                                            <i class="bx bx-trash me-1"></i> Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- View Modal (NO JS) -->
                                    <div class="modal fade" id="viewSchemeModal{{ $scheme->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                            <div class="modal-content">

                                                <div class="modal-header">
                                                    <h6 class="modal-title fw-bold">SCHEME DETAILS </h6>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>

                                                <div class="modal-body">

                                                    <div class="p-4 border rounded-3 bg-light">

                                                        <!-- Main Title -->
                                                        <h5 class="fw-bold mb-4 text-center">Scheme Details</h5>

                                                        <!-- Date Details -->
                                                        <h6 class="fw-bold mt-3 mb-2">Date Details</h6>
                                                        <div class="row gy-2 mb-3">
                                                            <div class="col-md-6">
                                                                <div class="small text-muted">Start Date</div>
                                                                <div class="fw-semibold">
                                                                    {{ \Carbon\Carbon::parse($scheme->start_date)->format('d-m-Y') }}
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="small text-muted">End Date</div>
                                                                <div class="fw-semibold">
                                                                    {{ \Carbon\Carbon::parse($scheme->end_date)->format('d-m-Y') }}
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Basic Information -->
                                                        <h6 class="fw-bold mt-3 mb-2">Basic Information</h6>
                                                        <div class="row gy-2 mb-3">
                                                            <div class="col-md-6">
                                                                <div class="small text-muted">Scheme Code</div>
                                                                <div class="fw-semibold">{{ $scheme->scheme_code }}</div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="small text-muted">Scheme Name</div>
                                                                <div class="fw-semibold">{{ $scheme->scheme_name }}</div>
                                                            </div>
                                                        </div>

                                                        <!-- ROI Details -->
                                                        <h6 class="fw-bold mt-3 mb-2">ROI Details</h6>
                                                        <div class="row gy-2 mb-3">
                                                            <div class="col-md-6">
                                                                <div class="small text-muted">Minimum ROI</div>
                                                                <div class="fw-semibold">{{ $scheme->roi_min }}%</div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="small text-muted">Maximum ROI</div>
                                                                <div class="fw-semibold">{{ $scheme->roi_max }}%</div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="small text-muted">Min Additional ROI</div>
                                                                <div class="fw-semibold">
                                                                    {{ $scheme->roi_min_additional }}%</div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="small text-muted">Max Additional ROI</div>
                                                                <div class="fw-semibold">
                                                                    {{ $scheme->roi_max_additional }}%</div>
                                                            </div>
                                                        </div>

                                                        <!-- Tenure Details -->
                                                        <h6 class="fw-bold mt-3 mb-2">Tenure Details</h6>
                                                        <div class="row gy-2 mb-3">
                                                            <div class="col-md-4">
                                                                <div class="small text-muted">Tenure Type</div>
                                                                <div class="fw-semibold">
                                                                    {{ ucfirst($scheme->tenure_type) }}</div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="small text-muted">Minimum Tenure</div>
                                                                <div class="fw-semibold">{{ $scheme->tenure_min }}</div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="small text-muted">Maximum Tenure</div>
                                                                <div class="fw-semibold">{{ $scheme->tenure_max }}</div>
                                                            </div>
                                                        </div>

                                                        <!-- Frequency -->
                                                        <h6 class="fw-bold mt-3 mb-2">Payout Frequency</h6>
                                                        <div class="fw-semibold">
                                                            @foreach ($scheme->frequency as $freq)
                                                                <span
                                                                    class="badge bg-primary me-1">{{ ucfirst($freq) }}</span>
                                                            @endforeach
                                                        </div>

                                                    </div>

                                                </div>



                                            </div>
                                        </div>
                                    </div>
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
