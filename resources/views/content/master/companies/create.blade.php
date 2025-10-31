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
                    <form action="{{ route('master.companies.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('post')
                        <div class="row">
                            <!-- Company Name -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Company Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Contact Person -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Contact Person</label>
                                <input type="text" name="contact_person" id="contact_person"
                                    class="form-control @error('contact_person') is-invalid @enderror"
                                    value="{{ old('contact_person') }}">
                                @error('contact_person')
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


                            <!-- GST No -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">GST No</label>
                                <input type="text" name="gst_number" id="gst_number"
                                    class="form-control @error('gst_number') is-invalid @enderror"
                                    value="{{ old('gst_number') }}" maxlength="15">
                                @error('gst_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- PAN No -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">PAN No</label>
                                <input type="text" name="pan_number" id="pan_number"
                                    class="form-control @error('pan_number') is-invalid @enderror"
                                    value="{{ old('pan_number') }}" maxlength="10">
                                @error('pan_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>



                            <!-- Address -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Address</label>
                                <input type="text" name="address" id="address"
                                    class="form-control @error('address') is-invalid @enderror"
                                    value="{{ old('address') }}">
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Country -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Country</label>
                                <input type="text" name="country_code" id="country_code"
                                    class="form-control @error('country_code') is-invalid @enderror"
                                    value="{{ old('country_code') }}">
                                @error('country_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- State -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">State</label>
                                <input type="text" name="state" id="state"
                                    class="form-control @error('state') is-invalid @enderror" value="{{ old('state') }}">
                                @error('state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- City -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">City</label>
                                <input type="text" name="city" id="city"
                                    class="form-control @error('city') is-invalid @enderror" value="{{ old('city') }}">
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Postal Code -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Postal Code</label>
                                <input type="text" name="postal_code" id="postal_code"
                                    class="form-control onlydigit @error('postal_code') is-invalid @enderror"
                                    value="{{ old('postal_code') }}" maxlength="6">
                                @error('postal_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="w-100"></div>

                            <!-- File Uploads -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Company Logo</label>
                                <div class="input-group">
                                    <input type="file" class="form-control @error('logo') is-invalid @enderror"
                                        id="logo" name="logo" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                    <button class="btn btn-outline-danger" type="button"
                                        onclick="document.getElementById('logo').value = ''">✕</button>
                                </div>
                                @error('logo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">PAN Attachment</label>
                                <div class="input-group">
                                    <input type="file"
                                        class="form-control @error('attachment_pan') is-invalid @enderror"
                                        id="attachment_pan" name="attachment_pan"
                                        accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                    <button class="btn btn-outline-danger" type="button"
                                        onclick="document.getElementById('attachment_pan').value = ''">✕</button>
                                </div>
                                @error('attachment_pan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">TAN Attachment</label>
                                <div class="input-group">
                                    <input type="file"
                                        class="form-control @error('attachment_tan') is-invalid @enderror"
                                        id="attachment_tan" name="attachment_tan"
                                        accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                    <button class="btn btn-outline-danger" type="button"
                                        onclick="document.getElementById('attachment_tan').value = ''">✕</button>
                                </div>
                                @error('attachment_tan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">GSTIN Attachment</label>
                                <div class="input-group">
                                    <input type="file"
                                        class="form-control @error('attachment_gstin') is-invalid @enderror"
                                        id="attachment_gstin" name="attachment_gstin"
                                        accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                    <button class="btn btn-outline-danger" type="button"
                                        onclick="document.getElementById('attachment_gstin').value = ''">✕</button>
                                </div>
                                @error('attachment_gstin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">CKYC Attachment</label>
                                <div class="input-group">
                                    <input type="file"
                                        class="form-control @error('attachment_ckyc') is-invalid @enderror"
                                        id="attachment_ckyc" name="attachment_ckyc"
                                        accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                    <button class="btn btn-outline-danger" type="button"
                                        onclick="document.getElementById('attachment_ckyc').value = ''">✕</button>
                                </div>
                                @error('attachment_ckyc')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Partnership Deed</label>
                                <div class="input-group">
                                    <input type="file"
                                        class="form-control @error('attachment_partnership_deed') is-invalid @enderror"
                                        id="attachment_partnership_deed" name="attachment_partnership_deed"
                                        accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                    <button class="btn btn-outline-danger" type="button"
                                        onclick="document.getElementById('attachment_partnership_deed').value = ''">✕</button>
                                </div>
                                @error('attachment_partnership_deed')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Udyam Aadhar</label>
                                <div class="input-group">
                                    <input type="file"
                                        class="form-control @error('attachment_udyam_aadhar') is-invalid @enderror"
                                        id="attachment_udyam_aadhar" name="attachment_udyam_aadhar"
                                        accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                    <button class="btn btn-outline-danger" type="button"
                                        onclick="document.getElementById('attachment_udyam_aadhar').value = ''">✕</button>
                                </div>
                                @error('attachment_udyam_aadhar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Gumasta License</label>
                                <div class="input-group">
                                    <input type="file"
                                        class="form-control @error('attachment_gumasta') is-invalid @enderror"
                                        id="attachment_gumasta" name="attachment_gumasta"
                                        accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                    <button class="btn btn-outline-danger" type="button"
                                        onclick="document.getElementById('attachment_gumasta').value = ''">✕</button>
                                </div>
                                @error('attachment_gumasta')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">MSME Certificate</label>
                                <div class="input-group">
                                    <input type="file"
                                        class="form-control @error('attachment_msme') is-invalid @enderror"
                                        id="attachment_msme" name="attachment_msme"
                                        accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                    <button class="btn btn-outline-danger" type="button"
                                        onclick="document.getElementById('attachment_msme').value = ''">✕</button>
                                </div>
                                @error('attachment_msme')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Submit -->
                            <div class="text-end mt-3">
                                <button type="submit" class="btn btn-primary px-4">Save</button>
                                <a href="{{ route('master.companies.index') }}" class="btn btn-secondary px-4">Cancel</a>
                            </div>
                        </div>
                    </form>


                </div>
            </div>
        </div>

    </div>


@endsection
