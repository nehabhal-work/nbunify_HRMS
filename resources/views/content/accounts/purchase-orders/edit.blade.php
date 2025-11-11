@extends('layouts.master-layout')

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
        <span class="text-muted fw-light">Master /</span> <a href="{{ route('master.head-offices.index') }}">Head-office</a>
    </h4>


    <form action="{{ route('master.head-offices.update', $headOffice->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        {{-- {{ $headOffice }} --}}
        <div class="row align-items-stretch">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">head-offices Information</h5>
                        <small class="text-muted float-end">head-offices Basic Details</small>
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <!-- head-offices Name -->
                            <div class="col-3 mb-3">
                                <label class="form-label">head-offices Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $headOffice->name) }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- head-offices Code -->
                            <div class="col-3 mb-3">
                                <label class="form-label">head-offices Code <span class="text-danger">*</span></label>
                                <input type="text" name="code" id="code"
                                    class="form-control @error('code') is-invalid @enderror"
                                    value="{{ old('code', $headOffice->code) }}">
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="w-100"></div>






                            <!-- Contact Person -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Contact Person</label>
                                <input type="text" name="contact_person" id="contact_person"
                                    class="form-control @error('contact_person') is-invalid @enderror"
                                    value="{{ old('contact_persn', $headOffice->contact_person) }}">
                                @error('contact_persn')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            {{-- contact_person_designation --}}
                            <div class="col-3 mb-3">
                                <label class="form-label">contact person designation <span
                                        class="text-info text-lowercase fst-italic ">(If
                                        required)</span></label>
                                <input type="text" name="contact_person_designation" id="contact_person_designation"
                                    class="form-control @error('contact_person_designation') is-invalid @enderror"
                                    value="{{ old('contact_person_designation', $headOffice->contact_person_designation) }}">
                                @error('contact_person_designation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                            </div>


                            <!-- Contact Number -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Contact Number</label>
                                <input type="text" name="phone" id="phone"
                                    class="form-control onlyphone @error('phone') is-invalid @enderror"
                                    value="{{ old('phone', $headOffice->phone) }}" maxlength="15">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" id="email"
                                    class="form-control no-uppercase @error('email') is-invalid @enderror"
                                    value="{{ old('email', $headOffice->email) }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Registered Address -->
                            <div class="col-6 mb-3">
                                <label class="form-label">Address</label>
                                <input type="text" name="address" id="address"
                                    class="form-control @error('address') is-invalid @enderror"
                                    value="{{ old('address', $headOffice->address) }}">
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="col-md-2 mb-3">
                                <label class="form-label">State</label>
                                <input type="text" name="state" id="state"
                                    class="form-control @error('state') is-invalid @enderror"
                                    value="{{ old('state', $headOffice->state) }}">
                                @error('state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2 mb-3">
                                <label class="form-label">City</label>
                                <input type="text" name="city" id="city"
                                    class="form-control @error('city') is-invalid @enderror"
                                    value="{{ old('city', $headOffice->city) }}">
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2 mb-3">
                                <label class="form-label">Postal Code</label>
                                <input type="text" name="pincode" id="pincode"
                                    class="form-control onlydigit @error('pincode') is-invalid @enderror"
                                    value="{{ old('pincode', $headOffice->pincode) }}" maxlength="6">
                                @error('pincode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>





                            <!-- Submit -->
                            <div class="text-end mt-3">
                                <button type="submit" class="btn btn-primary px-4">Update</button>
                                <a href="{{ route('master.head-offices.index') }}"
                                    class="btn btn-secondary px-4">Cancel</a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>





        </div>
    </form>




@endsection

@push('scripts')
@endpush
