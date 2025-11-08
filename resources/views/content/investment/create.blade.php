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
        <span class="text-muted fw-light">Master /</span> <a
            href="{{ route('investment.els-investment.create') }}">ELS-Investment</a>
    </h4>


    <form action="{{ route('investment.els-investment.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('post')
        <div class="row align-items-stretch">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">investment Information</h5>
                        <small class="text-muted float-end">investment Basic Details</small>
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <!-- investment Name -->
                            <div class="col-3 mb-3">
                                <label class="form-label">investment Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- investment Code -->
                            <div class="col-3 mb-3">
                                <label class="form-label">investment Code <span class="text-danger">*</span></label>
                                <input type="text" name="code" id="code"
                                    class="form-control @error('code') is-invalid @enderror" value="{{ old('code') }}">
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="w-100"></div>
                            {{-- gumasta --}}
                            <div class="col-3 mb-3">
                                <label class="form-label">gumasta no. <span class="text-info text-lowercase fst-italic ">(If
                                        required)</span></label>
                                <input type="text" name="gumasta" id="gumasta"
                                    class="form-control @error('gumasta') is-invalid @enderror"
                                    value="{{ old('gumasta') }}">
                                @error('gumasta')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                            </div>





                            <!-- Contact Person -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Contact Person</label>
                                <input type="text" name="contact_person" id="contact_person"
                                    class="form-control @error('contact_person') is-invalid @enderror"
                                    value="{{ old('contact_persn') }}">
                                @error('contact_persn')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Contact Number -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Contact Number</label>
                                <input type="text" name="phone" id="phone"
                                    class="form-control onlyphone @error('phone') is-invalid @enderror"
                                    value="{{ old('phone') }}" maxlength="15">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" id="email"
                                    class="form-control no-uppercase @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Registered Address -->
                            <div class="col-6 mb-3">
                                <label class="form-label">Address</label>
                                <input type="text" name="address" id="address"
                                    class="form-control @error('address') is-invalid @enderror"
                                    value="{{ old('address') }}">
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="col-md-2 mb-3">
                                <label class="form-label">State</label>
                                <input type="text" name="state" id="state"
                                    class="form-control @error('state') is-invalid @enderror" value="{{ old('state') }}">
                                @error('state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2 mb-3">
                                <label class="form-label">City</label>
                                <input type="text" name="city" id="city"
                                    class="form-control @error('city') is-invalid @enderror" value="{{ old('city') }}">
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2 mb-3">
                                <label class="form-label">Postal Code</label>
                                <input type="text" name="pincode" id="pincode"
                                    class="form-control onlydigit @error('pincode') is-invalid @enderror"
                                    value="{{ old('pincode') }}" maxlength="6">
                                @error('pincode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>





                            <!-- Submit -->
                            <div class="text-end mt-3">
                                <button type="submit" class="btn btn-primary px-4">Save</button>
                                <a href="{{ route('investment.els-investment.index') }}"
                                    class="btn btn-secondary px-4">Cancel</a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>





        </div>
    </form>



    <div class="row">
        <!-- TABLE SECTION -->

        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">investment List</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table srkdataTable ">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>investment</th>
                                    <th>code</th>
                                    <th>Contact Person</th>
                                    <th>Number</th>
                                    <th>Email</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Example static row (replace with @foreach later) --}}

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection

@push('scripts')
@endpush
