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
   <form action="{{ route('investment.si.update', $investmentSi->id) }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Investment ID -->
        <input type="hidden" name="investment_id" value="{{ $investment->id }}">
                <input type="hidden" name="si_no_of_payments" value="{{ $investment->schedule_count }}">


        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm">

                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Edit Standing Instruction</h5>
                        <a href="{{ route('investment.si.index', ['id' => $investment->id]) }}"
                           class="btn btn-sm btn-secondary">
                            Back
                        </a>
                    </div>

                    <div class="card-body">
                        <div class="row g-3">

                            <!-- Reference No -->
                            <div class="col-md-3">
                                <label class="form-label">
                                    Reference No <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       name="si_number"
                                       class="form-control @error('si_number') is-invalid @enderror"
                                       value="{{ old('si_number', $investmentSi->si_number) }}">
                                @error('si_number')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Company Bank -->
                            <div class="col-md-3">
                                <label class="form-label">
                                    Company Bank
                                </label>
                                <input type="text"
                                       class="form-control bg-secondary-subtle"
                                       value="{{ $investment->fromCompanyBank->bank_name }} - {{ $investment->fromCompanyBank->account_number }}"
                                       disabled>

                                <input type="hidden"
                                       name="si_company_bank_id"
                                       value="{{ $investment->fromCompanyBank->id }}">
                            </div>

                            <!-- Client Bank -->
                            <div class="col-md-3">
                                <label class="form-label">
                                    Client Bank
                                </label>
                                <input type="text"
                                       class="form-control bg-secondary-subtle"
                                       value="{{ $investment->toClientBank->bank_name }} - {{ $investment->toClientBank->account_number }}"
                                       disabled>

                                <input type="hidden"
                                       name="si_client_bank_id"
                                       value="{{ $investment->toClientBank->id }}">
                            </div>

                            <!-- Payment Start Date -->
                            <div class="col-md-3">
                                <label class="form-label">
                                    Payment Start Date
                                </label>
                                <input type="date"
                                       name="si_start_date"
                                       class="form-control bg-secondary-subtle"
                                       value="{{ $investmentSi->si_start_date?->format('Y-m-d') }}"
                                       readonly>
                            </div>

                            <!-- Amount -->
                            <div class="col-md-3">
                                <label class="form-label">
                                    Amount
                                </label>
                                <input type="text"
                                       name="si_amount"
                                       class="form-control bg-secondary-subtle"
                                       value="{{ $investmentSi->si_amount }}"
                                       readonly>
                            </div>

                            <!-- Instruction Image -->
                            <div class="col-md-3">
                                <label class="form-label">
                                    Instruction Image
                                </label>
                                <input type="file"
                                       name="instruction_image"
                                       class="form-control @error('instruction_image') is-invalid @enderror">

                                @if($investmentSi->instruction_image)
                                    <small class="text-muted d-block mt-1">
                                        Current: {{ $investmentSi->instruction_image }}
                                    </small>
                                @endif

                                @error('instruction_image')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Notes Image -->
                            <div class="col-md-3">
                                <label class="form-label">
                                    Notes Image
                                </label>
                                <input type="file"
                                       name="notes_image"
                                       class="form-control @error('notes_image') is-invalid @enderror">

                                @if($investmentSi->notes_image)
                                    <small class="text-muted d-block mt-1">
                                        Current: {{ $investmentSi->notes_image }}
                                    </small>
                                @endif

                                @error('notes_image')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Remarks -->
                            <div class="col-md-6">
                                <label class="form-label">
                                    Remarks
                                </label>
                                <textarea name="remarks"
                                          rows="3"
                                          class="form-control @error('remarks') is-invalid @enderror">{{ old('remarks', $investmentSi->remarks) }}</textarea>

                                @error('remarks')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                        </div>

                        <!-- Submit -->
                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-primary px-4">
                                Update
                            </button>
                        </div>

                    </div>
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
