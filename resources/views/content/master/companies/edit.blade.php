@extends('layouts.master-layout')

@section('content')
    <div>
        @if (session('success'))
            <x-alert type="success" :message="session('success')" />
        @endif

        @if (session('error'))
            <x-alert type="danger" :message="session('error')" />
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
        <span class="text-muted fw-light">Master /</span> Company Edit
    </h4>


    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Edit Company</h5>
                    <small class="text-muted float-end">Company Information</small>
                </div>
                <div class="card-body">
                
                    <form action="{{ route('master.companies.update', $company->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Company Name -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="name">Company Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $company->name) }}" placeholder="" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Contact Person -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="contact_person">Contact Person</label>
                                <input type="text" name="contact_person" id="contact_person"
                                    class="form-control @error('contact_person') is-invalid @enderror"
                                    value="{{ old('contact_person', $company->contact_person) }}" placeholder="">
                                @error('contact_person')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Contact Number -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="phone">Contact Number</label>
                                <input type="text" name="phone" id="phone"
                                    class="form-control onlyphone @error('phone') is-invalid @enderror"
                                    value="{{ old('phone', $company->phone) }}" placeholder="" maxlength="15" required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="email">Email</label>
                                <input type="email" name="email" id="email"
                                    class="form-control no-uppercase @error('email') is-invalid @enderror"
                                    value="{{ old('email', $company->email) }}" placeholder="">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Address -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="address">Address</label>
                                <textarea name="address" id="address" rows="2" class="form-control @error('address') is-invalid @enderror"
                                    placeholder="">{{ old('address', $company->address) }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- GST No -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="gst_number">GST No</label>
                                <input type="text" name="gst_number" id="gst_number"
                                    class="form-control @error('gst_number') is-invalid @enderror"
                                    value="{{ old('gst_number', $company->gst_number) }}" placeholder="" maxlength="15">
                                @error('gst_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- PAN No -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="pan_number">PAN No</label>
                                <input type="text" name="pan_number" id="pan_number"
                                    class="form-control @error('pan_number') is-invalid @enderror"
                                    value="{{ old('pan_number', $company->pan_number) }}" placeholder="" maxlength="10">
                                @error('pan_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Challan Prefix -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="code">Set Challan Prefix / Code
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="code" id="code"
                                    class="form-control @error('code') is-invalid @enderror"
                                    value="{{ old('code', $company->code) }}" placeholder="" required>
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="w-100"></div>

                            <!-- Country -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="country_code">Country</label>
                                <input type="text" name="country_code" id="country_code"
                                    class="form-control @error('country_code') is-invalid @enderror"
                                    value="{{ old('country_code', $company->country_code) }}" placeholder="">
                                @error('country_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- State -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="state">State</label>
                                <input type="text" name="state" id="state"
                                    class="form-control @error('state') is-invalid @enderror"
                                    value="{{ old('state', $company->state) }}" placeholder="">
                                @error('state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- City -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="city">City</label>
                                <input type="text" name="city" id="city"
                                    class="form-control @error('city') is-invalid @enderror"
                                    value="{{ old('city', $company->city) }}" placeholder="">
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Postal Code -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="postal_code">Postal Code</label>
                                <input type="text" name="postal_code" id="postal_code"
                                    class="form-control onlydigit @error('postal_code') is-invalid @enderror"
                                    value="{{ old('postal_code', $company->postal_code) }}" placeholder="">
                                @error('postal_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="text-end mt-3">
                                <button type="submit" class="btn btn-primary px-4">Update</button>
                                <a href="{{ route('master.companies.index') }}" class="btn btn-secondary px-4">Back</a>
                            </div>
                        </div>
                    </form>


                </div>
            </div>
        </div>


    </div>



@endsection
