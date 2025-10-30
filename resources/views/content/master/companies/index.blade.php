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
        <span class="text-muted fw-light">Master /</span> Company
    </h4>


    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Create New Company</h5>
                    <small class="text-muted float-end">Company Information</small>
                </div>
                <div class="card-body">
                    <form action="{{ route('master.companies.store') }}" method="POST">
                        @csrf
                        @method('post')
                        <div class="row">
                            <!-- Company Name -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="company">Company Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                    placeholder="" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Contact Person -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="contact_person">Contact Person</label>
                                <input type="text" name="contact_person" id="contact_person"
                                    class="form-control @error('contact_person') is-invalid @enderror"
                                    value="{{ old('contact_person') }}" placeholder="">
                                @error('contact_person')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Contact Number -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="phone">Contact Number</label>
                                <input type="text" name="phone" id="phone"
                                    class="form-control onlyphone @error('phone') is-invalid @enderror"
                                    value="{{ old('phone') }}" placeholder="" maxlength="15">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Email -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="email">Email</label>
                                <input type="email" name="email" id="email"
                                    class="form-control no-uppercase @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}" placeholder="">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Address -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="address">Address</label>
                                <textarea name="address" id="address" rows="2" class="form-control @error('address') is-invalid @enderror"
                                    placeholder="">{{ old('address') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- GST No -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="gstno">GST No</label>
                                <input type="text" name="gst_number" id="gstn_o"
                                    class="form-control @error('gst_no') is-invalid @enderror" value="{{ old('gst_no') }}"
                                    placeholder="" maxlength="15">
                                @error('gst_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- PAN No -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="panno">PAN No</label>
                                <input type="text" name="pan_number" id="pan_no"
                                    class="form-control @error('pan_no') is-invalid @enderror" value="{{ old('pan_no') }}"
                                    placeholder="" maxlength="10">
                                @error('pan_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Challan Prefix -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="challan_prefix">Set Challan Prefix /code
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="code" id="code"
                                    class="form-control @error('code') is-invalid @enderror" value="{{ old('code') }}"
                                    placeholder="" required>
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="w-100"></div>
                            <!-- country -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="challan_series">country</label>
                                <input type="text" name="country_code" id="country"
                                    class="form-control @error('country_code') is-invalid @enderror"
                                    value="{{ old('country_code') }}" placeholder="">
                                @error('country_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- state -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="challan_series">state</label>
                                <input type="text" name="state" id="state"
                                    class="form-control @error('state') is-invalid @enderror" value="{{ old('state') }}"
                                    placeholder="">
                                @error('state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- city -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="challan_series">city</label>
                                <input type="text" name="city" id="country"
                                    class="form-control @error('city') is-invalid @enderror" value="{{ old('city') }}"
                                    placeholder="">
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- postal code -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="challan_series">postal code</label>
                                <input type="text" name="postal_code" id="postal_code"
                                    class="form-control onlydigit @error('postal_code') is-invalid @enderror"
                                    value="{{ old('postal_code') }}" placeholder="" maxlength="6">
                                @error('postal_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="text-end mt-3">
                                <button type="submit" class="btn btn-primary px-4">Save</button>
                                <a href="{{ route('master.companies.index') }}" class="btn btn-secondary px-4">Cancel</a>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>

        <!-- TABLE SECTION -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Companies List</h5>
                    <small class="text-muted float-end">All registered companies</small>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table srkdataTable ">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Company</th>
                                    <th>Contact Person</th>
                                    <th>Number</th>
                                    <th>Email</th>
                                    <th>GST No</th>
                                    <th>PAN No</th>
                                    <th>Challan Prefix</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Example static row (replace with @foreach later) --}}
                                @foreach ($companies as $d)
                                    <tr>
                                        <td>{{ $d->id }}</td>
                                        <td>{{ $d->name }}</td>
                                        <td>{{ $d->contact_person }}</td>
                                        <td>{{ $d->phone }}</td>
                                        <td>{{ $d->email }}</td>
                                        <td>{{ $d->gst_number }}</td>
                                        <td>{{ $d->pan_number }}</td>
                                        <td>{{ $d->code }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item"
                                                        href="{{ route('master.companies.edit', $d->id) }}"><i
                                                            class="bx bx-edit-alt me-1"></i> Edit</a>
                                                   <form action="{{ route('master.companies.destroy', $d->id) }}" method="post"                         onsubmit="return confirmDelete()">

                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger delete-btn"
                                                            data-id="{{ $d->id }}">
                                                            <i class="bx bx-trash me-1"></i> Delete
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
        </div>
    </div>


@endsection
