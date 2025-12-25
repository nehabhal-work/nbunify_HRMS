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
    <form action="{{ route('investment.si.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('post')

        <input type="hidden" name="investment_id" value="{{ request()->get('id') }}">
        <input type="hidden" name="si_no_of_payments" value="{{ $investment->schedule_count }}">

        {{-- Set standing instruction --}}
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm">

                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Set Standing Instruction</h5>
                    </div>

                    <div class="card-body">
                        <div class="row g-3">

                            <!-- Reference No -->
                            <div class="col-md-3">
                                <label class="form-label">
                                    Reference No <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="si_number"
                                    class="form-control @error('si_number') is-invalid @enderror"
                                    placeholder="Enter reference no" value="{{ old('si_number') }}">

                                @error('si_number')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Company Bank -->
                            <div class="col-md-3">
                                <label class="form-label">
                                    Company Bank <span class="text-danger">*</span>
                                </label>

                                <!-- Display (Disabled Input) -->
                                <input type="text" class="form-control  bg-subtle"
                                    value="{{ $investment->fromCompanyBank->bank_name . '-' . $investment->fromCompanyBank->account_number }}"
                                    disabled>
                                <!-- Hidden Field (Actual Value Submitted) -->
                                <input type="hidden" name="si_company_bank_id"
                                    value="{{ $investment->fromCompanyBank->id }}">


                            </div>


                            <!-- Client Bank -->
                            <div class="col-md-3">
                                <label class="form-label">
                                    Client Bank <span class="text-danger">*</span>
                                </label>

                                <!-- Display (Disabled Input) -->
                                <input type="text" class="form-control  bg-subtle"
                                    value="{{ $investment->toClientBank->bank_name . '-' . $investment->toClientBank->account_number }}"
                                    disabled>
                                <!-- Hidden Field (Actual Value Submitted) -->
                                <input type="hidden" name="si_client_bank_id" value="{{ $investment->toClientBank->id }}">


                            </div>

                            <!-- Payment Start Date -->
                            <div class="col-md-3">
                                <label class="form-label">
                                    Payment Start Date <span class="text-danger">*</span>
                                </label>
                                <input type="date" name="si_start_date"
                                    class="form-control bg-secondary-subtle @error('si_start_date') is-invalid @enderror"
                                    value="{{ $investment->first_payout_date ? \Carbon\Carbon::parse($investment->first_payout_date)->format('Y-m-d') : '' }}"
                                    readonly>



                            </div>

                            <!-- Amount -->
                            <div class="col-md-3">
                                <label class="form-label">
                                    Amount <span class="text-danger">*</span>
                                </label>
                                <input type="text" step="0.01" name="si_amount" readonly
                                    class="form-control bg-secondary-subtle @error('amount') is-invalid @enderror"
                                    placeholder="Enter amount" value="{{ $investment->payout_per_period }}">

                            </div>

                            <!-- Instruction Image -->
                            <div class="col-md-3">
                                <label class="form-label">
                                    Instruction Image <span class="text-danger">*</span>
                                </label>
                                <input type="file" name="instruction_image"
                                    class="form-control @error('instruction_image') is-invalid @enderror">

                                @error('instruction_image')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Notes Image -->
                            <div class="col-md-3">
                                <label class="form-label">
                                    Notes Image <span class="text-danger">*</span>
                                </label>
                                <input type="file" name="notes_image"
                                    class="form-control @error('notes_image') is-invalid @enderror">

                                @error('notes_image')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Remarks -->
                            <div class="col-md-6">
                                <label class="form-label">
                                    Remarks <span class="text-danger">*</span>
                                </label>
                                <textarea name="remarks" rows="3" class="form-control @error('remarks') is-invalid @enderror"
                                    placeholder="Write remarks">{{ old('remarks') }}</textarea>

                                @error('remarks')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                        </div>
                        <!-- Submit -->
                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-primary px-4">Save</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="card my-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Bank / Instrument List</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table class="table srkdataTable">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Reference No</th>
                                <th>Company Bank</th>
                                <th>Client Bank</th>
                                <th>Payment Start Date</th>
                                <th>Amount</th>
                                <th>Instruction Image</th>
                                <th>Notes Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($investment->standingInstructions as $d)
                                <tr>
                                    <td>1</td>
                                    <td>{{ $d->si_number }}</td>
                                    <td>{{ $investment->fromCompanyBank->bank_name . ' - ' . $investment->fromCompanyBank->account_number }}
                                    </td>
                                    <td>{{ $investment->ToClientBank->bank_name . ' - ' . $investment->ToClientBank->account_number }}
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($d->si_start_date)->format('d M Y') }}
                                    </td>
                                    <td>{{ $d->si_amount }}</td>
                                    <td>instruction_001.jpg</td>
                                    <td>notes_001.jpg</td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>

                                            <div class="dropdown-menu">

                                                <a class="dropdown-item edit-btn"
                                                    href="{{ route('investment.si.edit', $d->id) }}">
                                                    <i class="bx bx-edit-alt me-1"></i> Edit
                                                </a>

                                                <form action="{{ route('investment.si.destroy', $d->id) }}"
                                                    method="POST" onsubmit="return confirmDelete()">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="dropdown-item text-danger">
                                                        Delete
                                                    </button>
                                                </form>
                                              



                                            </div>
                                        </div>

                                    </td>
                                </tr>
                            @endforeach


                        </tbody>


                    </table>
                </div>
            </div>
        </div>


    </form>



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
