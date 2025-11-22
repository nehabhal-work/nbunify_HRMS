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

        <input type="hidden" name="res_country" id="res_country" value="{{ $branch->res_country }}">
        <input type="hidden" name="res_state" id="res_state" value="{{ $branch->res_state }}">
        <input type="hidden" name="res_city" id="res_city" value="{{ $branch->res_city }}">


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

                        </div>


                        {{-- address section --}}
                        <div class="row">
                            <!-- Residential Address -->
                            <h6 class="my-3"> Address</h6>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Address</label>
                                <input type="text" name="res_address" id="res_address"
                                    class="form-control @error('res_address') is-invalid @enderror"
                                    value="{{ old('res_address') }}">
                                @error('res_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Country --}}
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Country</label>
                                <select name="res_country_code" id="res_country_code"
                                    class="form-select select2  @error('res_country_code') is-invalid @enderror">
                                    <option value="{{ $country['iso2'] }}"
                                        {{ old('res_country_code', 'IND') == $country['iso2'] ? 'selected' : '' }}
                                        data-country-name="{{ $country['name'] }}">
                                        {{ $country['name'] }}
                                    </option>

                                </select>
                                @error('res_country_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- State --}}
                            <div class="col-md-2 mb-3">
                                <label class="form-label">State</label>
                                <select name="res_state_code" id="res_state_code"
                                    class="form-select select2 @error('res_state_code') is-invalid @enderror">
                                    @foreach ($states as $state)
                                        <option value="{{ $state['iso2'] }}"
                                            {{ old('res_state_code', 'MH') == $state['iso2'] ? 'selected' : '' }}
                                            data-state-name="{{ $state['name'] }}">
                                            {{ $state['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('res_state_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- City --}}
                            <div class="col-md-2 mb-3">
                                <label class="form-label">City</label>
                                <select name="res_city_code" id="res_city_code"
                                    class="form-select select2  @error('res_city_code') is-invalid @enderror">
                                    <option value="">Select City</option>
                                    @foreach ($cities as $c)
                                        <option value="{{ $c['id'] }}"
                                            {{ old('res_city_code') == $c['id'] ? 'selected' : '' }}
                                            data-city-name="{{ $c['name'] }}">
                                            {{ $c['name'] }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('res_city_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Pincode --}}
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Pincode</label>
                                <input type="text" name="res_pincode" id="res_pincode"
                                    class="form-control onlydigit @error('res_pincode') is-invalid @enderror"
                                    value="{{ old('res_pincode') }}" maxlength="6">
                                @error('res_pincode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                        </div>





                        <!-- Submit -->
                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-primary px-4">Update</button>
                            <a href="{{ route('master.head-offices.index') }}" class="btn btn-secondary px-4">Cancel</a>
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
