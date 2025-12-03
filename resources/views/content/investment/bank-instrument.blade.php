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



        {{-- Bank / Instrument Details --}}
        <div class="row align-items-stretch">
            <div class="col-md-12">
                <div class="card mb-4">

                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Bank / Instrument Details</h5>
                        <small class="text-muted float-end">Bank / Instrument Details</small>
                    </div>

                    <div class="card-body">
                        <div class="row g-3">

                            <!-- Instrument -->
                            <div class="col-md-2 mt-3">
                                <label class="form-label">
                                    Instrument <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('instrument') is-invalid @enderror" name="instrument"
                                    required>
                                    <option value="">Select</option>
                                    <option value="rtgs" {{ old('instrument') == 'rtgs' ? 'selected' : '' }}>RTGS
                                    </option>
                                    <option value="cheque" {{ old('instrument') == 'cheque' ? 'selected' : '' }}>CHEQUE
                                    </option>
                                    <option value="upi" {{ old('instrument') == 'upi' ? 'selected' : '' }}>UPI</option>
                                    <option value="neft" {{ old('instrument') == 'neft' ? 'selected' : '' }}>NEFT
                                    </option>
                                    <option value="imps" {{ old('instrument') == 'imps' ? 'selected' : '' }}>IMPS
                                    </option>
                                </select>
                                @error('instrument')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Instrument Date -->
                            <div class="col-md-2 mt-3">
                                <label class="form-label">
                                    Instrument Date <span class="text-danger">*</span>
                                </label>
                                <input type="date" class="form-control @error('instrument_date') is-invalid @enderror"
                                    name="instrument_date" value="{{ old('instrument_date') }}" max="{{ date('Y-m-d') }}"
                                    required>
                                @error('instrument_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Reference No -->
                            <div class="col-md-3 mt-3">
                                <label class="form-label">
                                    Reference No <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control @error('reference_no') is-invalid @enderror"
                                    name="reference_no" value="{{ old('reference_no') }}" maxlength="20" required>
                                @error('reference_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Instrument Amount -->
                            <div class="col-md-2 mt-3">
                                <label class="form-label">
                                    Instrument Amount <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">&#8377;</span>
                                    <input type="number"
                                        class="form-control bg-secondary-subtle onlydigit instrument_amt @error('instrument_amt') is-invalid @enderror"
                                        name="instrument_amt" value="{{ old('instrument_amt') }}" required>
                                </div>
                                @error('instrument_amt')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Client Output Bank -->
                            <div class="col-md-3 mt-3">
                                <label class="form-label">
                                    Client Output Bank <span class="text-danger">*</span>
                                </label>
                                <select
                                    class="form-select clientOutputBank @error('client_output_bank') is-invalid @enderror"
                                    name="client_output_bank" required>
                                    <option value="">Select Bank</option>
                                    <!-- You will populate banks using JS -->
                                </select>
                                @error('client_output_bank')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Company Bank -->
                            <div class="col-md-3 mt-3">
                                <label class="form-label">
                                    Company Bank <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('company_bank_id') is-invalid @enderror"
                                    name="company_bank_id" required>
                                    <option value="">Select Company Bank</option>
                                </select>
                                @error('company_bank_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Instrument Image -->
                            <div class="col-md-3 mt-3">
                                <label class="form-label">
                                    Instrument Image <span class="text-danger">*</span>
                                </label>
                                <input type="file"
                                    class="form-control fileInput instrumentImage @error('instrumentImage') is-invalid @enderror"
                                    name="instrumentImage" accept="image/*,application/pdf">
                                <img src="" class="imgPreview mt-1" style="width:100px; display:none;">
                                @error('instrumentImage')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Effective / Credit Date -->
                            <div class="col-md-2 mt-3">
                                <label class="form-label">
                                    Effective / Credit Date <span class="text-danger">*</span>
                                </label>
                                <input type="date" class="form-control @error('effective_date') is-invalid @enderror"
                                    name="effective_date" value="{{ old('effective_date') }}" max="{{ date('Y-m-d') }}"
                                    required>
                                @error('effective_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Bank / Instrument List</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table class="table srkdataTable">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Instrument</th>
                                <th>Instrument Date</th>
                                <th>Reference No</th>
                                <th>Instrument Amount</th>
                                <th>Client Output Bank</th>
                                <th>Company Bank</th>
                                <th>Instrument Image</th>
                                <th>Effective / Credit Date</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>RTGS</td>
                                <td>05 Mar 2025</td>
                                <td>RTGS12345</td>
                                <td>₹1,00,000</td>
                                <td>HDFC Bank</td>
                                <td>ICICI Corporate</td>
                                <td>rtgs-slip1.jpg</td>
                                <td>06 Mar 2025</td>
                            </tr>

                            <tr>
                                <td>2</td>
                                <td>CHEQUE</td>
                                <td>12 Mar 2025</td>
                                <td>CHQ998877</td>
                                <td>₹50,000</td>
                                <td>SBI Bank</td>
                                <td>Axis Business</td>
                                <td>cheque-img2.png</td>
                                <td>14 Mar 2025</td>
                            </tr>

                            <tr>
                                <td>3</td>
                                <td>UPI</td>
                                <td>18 Mar 2025</td>
                                <td>UPI-REF-7766</td>
                                <td>₹25,000</td>
                                <td>Kotak Bank</td>
                                <td>Yes Bank Current</td>
                                <td>upi-proof3.pdf</td>
                                <td>18 Mar 2025</td>
                            </tr>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>


        <!-- Submit -->
        <div class="text-end mt-4">
            <button type="submit" class="btn btn-primary px-4">Save</button>
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
