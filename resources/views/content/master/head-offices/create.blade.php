{{-- resources/views/master/head-offices/create.blade.php --}}
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
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Master /</span>
        <a href="{{ route('master.head-offices.index') }}">Head Offices</a> /
        <span class="text-muted fw-light">Create</span>
    </h4>

    <form action="{{ route('master.head-offices.store') }}" method="POST">
        @csrf

        <div class="row align-items-stretch">

            {{-- Basic Information --}}
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Basic Information</h5>
                        <small class="text-muted">Head Office Primary Details</small>
                    </div>
                    <div class="card-body">
                        <div class="row g-3 mt-2">

                            <div class="col-md-4 mb-3">
                                <label>Company <span class="text-danger">*</span></label>
                                <select name="company_id"
                                    class="form-select @error('company_id') is-invalid @enderror">
                                    <option value="">Select Company</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}"
                                            {{ old('company_id') == $company->id ? 'selected' : '' }}>
                                            {{ $company->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('company_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label>Head Office Name <span class="text-danger">*</span></label>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name') }}" placeholder="Enter head office name">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label>Code <span class="text-danger">*</span></label>
                                <input type="text" name="code"
                                    class="form-control @error('code') is-invalid @enderror"
                                    value="{{ old('code') }}" placeholder="e.g. HO-MUM-01">
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label>Email <span class="text-danger">*</span></label>
                                <input type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}" placeholder="office@example.com">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label>Phone</label>
                                <input type="text" name="phone"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    value="{{ old('phone') }}" placeholder="Enter phone number">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label>Fax</label>
                                <input type="text" name="fax"
                                    class="form-control @error('fax') is-invalid @enderror"
                                    value="{{ old('fax') }}" placeholder="Fax number">
                                @error('fax')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label>Timezone</label>
                                <input type="text" name="timezone"
                                    class="form-control @error('timezone') is-invalid @enderror"
                                    value="{{ old('timezone', 'Asia/Kolkata') }}" placeholder="Asia/Kolkata">
                                @error('timezone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label>Currency</label>
                                <input type="text" name="currency"
                                    class="form-control @error('currency') is-invalid @enderror"
                                    value="{{ old('currency', 'INR') }}" placeholder="INR">
                                @error('currency')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label>Established Date</label>
                                <input type="date" name="established_at"
                                    class="form-control @error('established_at') is-invalid @enderror"
                                    value="{{ old('established_at') }}">
                                @error('established_at')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label>Status</label>
                                <select name="is_active"
                                    class="form-select @error('is_active') is-invalid @enderror">
                                    <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('is_active')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            {{-- Manager Details --}}
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">👤 Manager Details</h5>
                        <small class="text-muted">Head Office Manager Info</small>
                    </div>
                    <div class="card-body">
                        <div class="row g-3 mt-2">

                            <div class="col-md-4 mb-3">
                                <label>Manager Name</label>
                                <input type="text" name="manager_name"
                                    class="form-control @error('manager_name') is-invalid @enderror"
                                    value="{{ old('manager_name') }}" placeholder="Full name">
                                @error('manager_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label>Manager Email</label>
                                <input type="email" name="manager_email"
                                    class="form-control @error('manager_email') is-invalid @enderror"
                                    value="{{ old('manager_email') }}" placeholder="manager@example.com">
                                @error('manager_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            {{-- Address --}}
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">📍 Address Details</h5>
                        <small class="text-muted">Head Office Location</small>
                    </div>
                    <div class="card-body">
                        <div class="row g-3 mt-2">

                            <div class="col-md-6 mb-3">
                                <label>Address Line 1 <span class="text-danger">*</span></label>
                                <input type="text" name="address_line_1"
                                    class="form-control @error('address_line_1') is-invalid @enderror"
                                    value="{{ old('address_line_1') }}" placeholder="Building No., Street, Area">
                                @error('address_line_1')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Address Line 2</label>
                                <input type="text" name="address_line_2"
                                    class="form-control @error('address_line_2') is-invalid @enderror"
                                    value="{{ old('address_line_2') }}" placeholder="Floor, Suite, Landmark">
                                @error('address_line_2')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label>City <span class="text-danger">*</span></label>
                                <input type="text" name="city"
                                    class="form-control @error('city') is-invalid @enderror"
                                    value="{{ old('city') }}" placeholder="City">
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label>State <span class="text-danger">*</span></label>
                                <select name="state"
                                    class="form-select @error('state') is-invalid @enderror">
                                    <option value="">Select state...</option>
                                    <option value="Maharashtra" {{ old('state') == 'Maharashtra' ? 'selected' : '' }}>Maharashtra</option>
                                    <option value="Gujarat"     {{ old('state') == 'Gujarat'     ? 'selected' : '' }}>Gujarat</option>
                                    <option value="Delhi"       {{ old('state') == 'Delhi'       ? 'selected' : '' }}>Delhi</option>
                                    <option value="Karnataka"   {{ old('state') == 'Karnataka'   ? 'selected' : '' }}>Karnataka</option>
                                    <option value="Tamil Nadu"  {{ old('state') == 'Tamil Nadu'  ? 'selected' : '' }}>Tamil Nadu</option>
                                </select>
                                @error('state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label>Country <span class="text-danger">*</span></label>
                                <select name="country"
                                    class="form-select @error('country') is-invalid @enderror">
                                    <option value="India" {{ old('country', 'India') == 'India' ? 'selected' : '' }}>India</option>
                                </select>
                                @error('country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label>Pincode</label>
                                <input type="text" name="pincode"
                                    class="form-control @error('pincode') is-invalid @enderror"
                                    value="{{ old('pincode') }}" placeholder="400001">
                                @error('pincode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="text-end mt-3">
            <button type="submit" class="btn btn-primary px-4">Save</button>
            <a href="{{ route('master.head-offices.index') }}" class="btn btn-secondary px-4">Cancel</a>
        </div>
    </form>
@endsection