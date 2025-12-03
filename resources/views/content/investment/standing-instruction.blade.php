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
    <form action="{{ route('investment.els.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('post')

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
                                <input type="text" name="reference_no"
                                    class="form-control @error('reference_no') is-invalid @enderror"
                                    placeholder="Enter reference no" value="{{ old('reference_no') }}">

                                @error('reference_no')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Company Bank -->
                            <div class="col-md-3">
                                <label class="form-label">
                                    Company Bank <span class="text-danger">*</span>
                                </label>
                                <select name="company_bank" class="form-select @error('company_bank') is-invalid @enderror">
                                    <option value="">Select Company Bank</option>

                                    {{-- @foreach ($companyBanks as $bank)
                                <option value="{{ $bank->id }}"
                                    {{ old('company_bank') == $bank->id ? 'selected' : '' }}>
                                    {{ $bank->bank_name }} — {{ $bank->account_no }}
                                </option>
                            @endforeach --}}
                                </select>

                                @error('company_bank')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Client Bank -->
                            <div class="col-md-3">
                                <label class="form-label">
                                    Client Bank <span class="text-danger">*</span>
                                </label>
                                <select name="client_bank" class="form-select @error('client_bank') is-invalid @enderror">
                                    <option value="">Select Client Bank</option>

                                    {{-- @foreach ($clientBanks as $bank)
                                <option value="{{ $bank->id }}"
                                    {{ old('client_bank') == $bank->id ? 'selected' : '' }}>
                                    {{ $bank->bank_name }} — {{ $bank->account_no }}
                                </option>
                            @endforeach --}}
                                </select>

                                @error('client_bank')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Payment Start Date -->
                            <div class="col-md-3">
                                <label class="form-label">
                                    Payment Start Date <span class="text-danger">*</span>
                                </label>
                                <input type="date" name="payment_start_date"
                                    class="form-control bg-secondary-subtle @error('payment_start_date') is-invalid @enderror"
                                    value="{{ old('payment_start_date') }}" readonly>

                                @error('payment_start_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Amount -->
                            <div class="col-md-3">
                                <label class="form-label">
                                    Amount <span class="text-danger">*</span>
                                </label>
                                <input type="number" step="0.01" name="amount"
                                    class="form-control @error('amount') is-invalid @enderror" placeholder="Enter amount"
                                    value="{{ old('amount') }}">

                                @error('amount')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
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
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>REF-2025-001</td>
                                <td>ICICI Bank — 0023456789</td>
                                <td>HDFC Bank — 4455667788</td>
                                <td>05 Mar 2025</td>
                                <td>₹50,000</td>
                                <td>instruction_001.jpg</td>
                                <td>notes_001.jpg</td>
                                <td>Monthly SIP standing instruction initiated.</td>
                            </tr>

                            <tr>
                                <td>2</td>
                                <td>REF-2025-002</td>
                                <td>Axis Bank — 8855441122</td>
                                <td>SBI Bank — 9988776655</td>
                                <td>10 Mar 2025</td>
                                <td>₹1,20,000</td>
                                <td>instruction_002.pdf</td>
                                <td>notes_002.png</td>
                                <td>Quarterly payout instruction for investment.</td>
                            </tr>

                            <tr>
                                <td>3</td>
                                <td>REF-2025-003</td>
                                <td>Kotak Bank — 2233114455</td>
                                <td>Yes Bank — 7766554422</td>
                                <td>15 Mar 2025</td>
                                <td>₹75,500</td>
                                <td>instruction_003.jpg</td>
                                <td>notes_003.jpg</td>
                                <td>Instruction for automated transfer to client.</td>
                            </tr>
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
