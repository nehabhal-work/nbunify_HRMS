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
        <span class="text-muted fw-light">Master /</span> <a href="{{ route('master.companies.index') }}">Company</a>
    </h4>


    <form action="{{ route('master.companies.update', $company->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row align-items-stretch">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Primary Information</h5>
                        <small class="text-muted float-end">Company Basic Details</small>
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <!-- Company Name -->
                            <div class="col-3 mb-3">
                                <label class="form-label">Company Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $company->name) }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Company Type -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Company Type <span class="text-danger">*</span></label>
                                <select name="company_type" id="company_type"
                                    class="form-select select2 @error('company_type') is-invalid @enderror">
                                    <option value="">Select Type</option>
                                    @php
                                        $types = [
                                            'sole_proprietorship' => 'Sole Proprietorship',
                                            'partnership' => 'Partnership',
                                            'pvt_ltd' => 'Private Limited',
                                            'public_ltd' => 'Public Limited',
                                            'llp' => 'LLP',
                                            'huf' => 'HUF',
                                            'ngo' => 'NGO',
                                        ];
                                    @endphp
                                    @foreach ($types as $key => $label)
                                        <option value="{{ $key }}"
                                            {{ old('company_type', $company->company_type) == $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('company_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Establishment Date -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Establishment Date</label>
                                <input type="date" name="est_date" id="est_date"
                                    class="form-control @error('est_date') is-invalid @enderror"
                                    value="{{ old('est_date', $company->est_date) }}">
                                @error('est_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Contact Person -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Contact Person</label>
                                <input type="text" name="contact_person_name" id="contact_person_name"
                                    class="form-control @error('contact_person_name') is-invalid @enderror"
                                    value="{{ old('contact_person_name', $company->contact_person_name) }}">
                                @error('contact_person_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Contact Number -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Contact Number</label>
                                <input type="text" name="phone" id="phone"
                                    class="form-control onlyphone @error('phone') is-invalid @enderror"
                                    value="{{ old('phone', $company->phone) }}" maxlength="15">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" id="email"
                                    class="form-control no-uppercase @error('email') is-invalid @enderror"
                                    value="{{ old('email', $company->email) }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Registered Address -->
                            <hr>
                            <h6 class="mb-3">Registered Address</h6>
                            <div class="col-6 mb-3">
                                <label class="form-label">Address</label>
                                <input type="text" name="registered_address" id="registered_address"
                                    class="form-control @error('registered_address') is-invalid @enderror"
                                    value="{{ old('registered_address', $company->registered_address) }}">
                                @error('registered_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="col-md-2 mb-3">
                                <label class="form-label">State</label>
                                <input type="text" name="registered_state" id="registered_state"
                                    class="form-control @error('registered_state') is-invalid @enderror"
                                    value="{{ old('registered_state', $company->registered_state) }}">
                                @error('registered_state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2 mb-3">
                                <label class="form-label">City</label>
                                <input type="text" name="registered_city" id="registered_city"
                                    class="form-control @error('registered_city') is-invalid @enderror"
                                    value="{{ old('registered_city', $company->registered_city) }}">
                                @error('registered_city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2 mb-3">
                                <label class="form-label">Postal Code</label>
                                <input type="text" name="registered_pincode" id="registered_pincode"
                                    class="form-control onlydigit @error('registered_pincode') is-invalid @enderror"
                                    value="{{ old('registered_pincode', $company->registered_pincode) }}" maxlength="6">
                                @error('registered_pincode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Corporate Address -->
                            <hr>
                            <h6 class="mb-3">Corporate Address</h6>
                            <div class="col-6 mb-3">
                                <label class="form-label">Address</label>
                                <input type="text" name="corporate_address" id="corporate_address"
                                    class="form-control @error('corporate_address') is-invalid @enderror"
                                    value="{{ old('corporate_address', $company->corporate_address) }}">
                                @error('corporate_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>



                            <div class="col-md-2 mb-3">
                                <label class="form-label">State</label>
                                <input type="text" name="corporate_state" id="corporate_state"
                                    class="form-control @error('corporate_state') is-invalid @enderror"
                                    value="{{ old('corporate_state', $company->corporate_state) }}">
                                @error('corporate_state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2 mb-3">
                                <label class="form-label">City</label>
                                <input type="text" name="corporate_city" id="corporate_city"
                                    class="form-control @error('corporate_city') is-invalid @enderror"
                                    value="{{ old('corporate_city', $company->corporate_city) }}">
                                @error('corporate_city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2 mb-3">
                                <label class="form-label">Pincode</label>
                                <input type="text" name="corporate_pincode" id="corporate_pincode"
                                    class="form-control onlydigit @error('corporate_pincode') is-invalid @enderror"
                                    value="{{ old('corporate_pincode', $company->corporate_pincode) }}" maxlength="6">
                                @error('corporate_pincode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Additional Address -->
                            <hr>
                            <h6 class="mb-3">Additional Address</h6>
                            <div class="col-6 mb-3">
                                <label class="form-label">Address</label>
                                <input type="text" name="additional_address" id="additional_address"
                                    class="form-control @error('additional_address') is-invalid @enderror"
                                    value="{{ old('additional_address', $company->additional_address) }}">
                                @error('additional_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>



                            <div class="col-md-2 mb-3">
                                <label class="form-label">State</label>
                                <input type="text" name="additional_state" id="additional_state"
                                    class="form-control @error('additional_state') is-invalid @enderror"
                                    value="{{ old('additional_state', $company->additional_state) }}">
                                @error('additional_state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2 mb-3">
                                <label class="form-label">City</label>
                                <input type="text" name="additional_city" id="additional_city"
                                    class="form-control @error('additional_city') is-invalid @enderror"
                                    value="{{ old('additional_city', $company->additional_city) }}">
                                @error('additional_city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2 mb-3">
                                <label class="form-label">Pincode</label>
                                <input type="text" name="additional_pincode" id="additional_pincode"
                                    class="form-control onlydigit @error('additional_pincode') is-invalid @enderror"
                                    value="{{ old('additional_pincode', $company->additional_pincode) }}" maxlength="6">
                                @error('additional_pincode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>
                </div>
            </div>




            <div class="col-md-6 d-flex">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Company Registration & Compliance</h5>
                        <small class="text-muted float-end">Official Identification Numbers</small>
                    </div>

                    <div class="card-body">
                        <div class="row">

                            <!-- CIN Number -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">CIN Number</label>
                                <input type="text" name="cin_no" id="cin_no"
                                    class="form-control no-uppercase @error('cin_no') is-invalid @enderror"
                                    value="{{ old('cin_no', $company->cin_no) }}">
                                @error('cin_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- PAN Number -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">PAN Number</label>
                                <input type="text" name="pan_no" id="pan_no"
                                    class="form-control no-uppercase @error('pan_no') is-invalid @enderror"
                                    value="{{ old('pan_no', $company->pan_no) }}" maxlength="10">
                                @error('pan_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- TAN Number -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">TAN Number</label>
                                <input type="text" name="tan_no" id="tan_no"
                                    class="form-control no-uppercase @error('tan_no') is-invalid @enderror"
                                    value="{{ old('tan_no', $company->tan_no) }}" maxlength="10">
                                @error('tan_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- GSTIN -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">GSTIN</label>
                                <input type="text" name="gstin" id="gstin"
                                    class="form-control no-uppercase @error('gstin') is-invalid @enderror"
                                    value="{{ old('gstin', $company->gstin) }}" maxlength="15">
                                @error('gstin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Udyam Aadhar Number -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Udyam Aadhar Number</label>
                                <input type="text" name="udyam_aadhar_no" id="udyam_aadhar_no"
                                    class="form-control no-uppercase @error('udyam_aadhar_no') is-invalid @enderror"
                                    value="{{ old('udyam_aadhar_no', $company->udyam_aadhar_no) }}">
                                @error('udyam_aadhar_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Partnership Registration Number -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Partnership Registration Number</label>
                                <input type="text" name="partnership_registration_no" id="partnership_registration_no"
                                    class="form-control @error('partnership_registration_no') is-invalid @enderror"
                                    value="{{ old('partnership_registration_no', $company->partnership_registration_no) }}">
                                @error('partnership_registration_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- ROC Number -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">ROC Number</label>
                                <input type="text" name="roc_no" id="roc_no"
                                    class="form-control @error('roc_no', $company->roc_no) is-invalid @enderror"
                                    value="{{ old('roc_no', $company->roc_no) }}">
                                @error('roc_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- MSME Certification Number -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">MSME Certification Number</label>
                                <input type="text" name="msme_certification_no" id="msme_certification_no"
                                    class="form-control @error('msme_certification_no') is-invalid @enderror"
                                    value="{{ old('msme_certification_no', $company->msme_certification_no) }}">
                                @error('msme_certification_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- CKYC -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">CKYC Number</label>
                                <input type="text" name="ckyc" id="ckyc"
                                    class="form-control @error('ckyc', $company->ckyc) is-invalid @enderror"
                                    value="{{ old('ckyc', $company->ckyc) }}">
                                @error('ckyc')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Gumasta Number -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Gumasta Number</label>
                                <input type="text" name="gumasta_no" id="gumasta_no"
                                    class="form-control @error('gumasta_no', $company->gumasta_no) is-invalid @enderror"
                                    value="{{ old('gumasta_no', $company->gumasta_no) }}">
                                @error('gumasta_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>
                </div>
            </div>



            <div class="col-md-6 d-flex">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Image Section</h5>
                        <small class="text-muted float-end">Image Information</small>
                    </div>
                    <div class="card-body">
                        <div class="row">


                            <!-- File Upload: Company images -->


                            <div class="col-md-6 mb-3">
                                <label class="form-label">Logo Attachment</label>
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
                            <div class="col-md-6 mb-3">
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

                            <div class="col-md-6 mb-3">
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

                            <div class="col-md-6 mb-3">
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

                            <div class="col-md-6 mb-3">
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

                            <div class="col-md-6 mb-3">
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

                            <div class="col-md-6 mb-3">
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

                            <div class="col-md-6 mb-3">
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

                            <div class="col-md-6 mb-3">
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

                        </div>


                    </div>
                </div>
            </div>

        </div>
        <!-- Submit -->
        <div class="text-end mt-3">
            <button type="submit" class="btn btn-primary px-4">Update</button>
            <a href="{{ route('master.companies.index') }}" class="btn btn-secondary px-4">Cancel</a>
        </div>
    </form>


@endsection

@push('scripts')
@endpush
