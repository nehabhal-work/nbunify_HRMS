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
        <span class="text-muted fw-light">Family /</span> <a href="">Edit Family Member</a>
    </h4>
    {{ $clientFamily }}
    <a href="" class="btn btn-secondary px-4">Cancel</a>
    <form action="{{ route('client-families.update', $clientFamily->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" name="client_id" value="{{ $client->id }}">
        <div class="row align-items-stretch">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Family Information</h5>
                        <small class="text-muted float-end">Family Basic Details</small>
                    </div>
                    <div class="card-body">
                        <div class="row">



                            {{-- Full Name --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="name">Full Name</label>
                                <input type="text" class="form-control onlyalpha @error('name') is-invalid @enderror"
                                    id="name" name="name" maxlength="50"
                                    value="{{ old('name', $clientFamily->name) }}" maxlength="50">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Gender --}}
                            <div class="col-md-2 mb-3">
                                <label class="form-label" for="gender">Gender</label>
                                <select class="form-select @error('gender') is-invalid @enderror" id="gender"
                                    name="gender">
                                    <option value="">Select</option>
                                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            {{-- Date of Birth --}}
                            <div class="col-md-2 mb-3">
                                <label class="form-label" for="dob">Date of Birth</label>
                                <input type="date" class="form-control @error('dob') is-invalid @enderror" id="dob"
                                    name="dob" value="{{ old('dob', $clientFamily->dob) }}"
                                    max="{{ now()->toDateString() }}">
                                @error('dob')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            {{-- Live Status --}}
                            <div class="col-md-2 mb-3">
                                <label class="form-label" for="live_status">Live Status</label>
                                <select class="form-select @error('live_status') is-invalid @enderror" id="live_status"
                                    name="live_status">
                                    <option value="alive" {{ old('live_status', 'alive') == 'alive' ? 'selected' : '' }}>
                                        Live
                                    </option>
                                    <option value="deceased" {{ old('live_status') == 'deceased' ? 'selected' : '' }}>
                                        Deceased
                                    </option>
                                </select>
                                @error('live_status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>



                            {{-- Date of Death --}}
                            <div class="col-md-2 mb-3 d-none">
                                <label for="dod" class="form-label">Date of Death</label>
                                <input type="date" name="dod" id="dod" class="form-control"
                                    value="{{ old('dod', $clientFamily->dod) }}">
                                @error('dod')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>


                            {{-- Marital Status --}}
                            <div class="col-md-2 mb-3">
                                <label class="form-label" for="marital_status">Marital Status</label>
                                <select class="form-select @error('marital_status') is-invalid @enderror"
                                    id="marital_status" name="marital_status">
                                    <option value="">Select</option>
                                    <option value="single" {{ old('marital_status') == 'single' ? 'selected' : '' }}>Single
                                    </option>
                                    <option value="married" {{ old('marital_status') == 'married' ? 'selected' : '' }}>
                                        Married</option>
                                    <option value="divorcee" {{ old('marital_status') == 'divorcee' ? 'selected' : '' }}>
                                        Divorcee</option>
                                    <option value="widow" {{ old('marital_status') == 'widow' ? 'selected' : '' }}>Widow
                                    </option>
                                    <option value="other" {{ old('marital_status') == 'other' ? 'selected' : '' }}>Other
                                    </option>
                                </select>
                                @error('marital_status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            {{-- Nationality --}}
                            <div class="col-md-2 mb-3">
                                <label class="form-label" for="nationality">Nationality</label>
                                <select class="form-select @error('nationality') is-invalid @enderror" id="nationality"
                                    name="nationality">
                                    <option value="">Select</option>
                                    <option value="ri" {{ old('nationality') == 'ri' ? 'selected' : '' }}>Residential
                                        Individual</option>
                                    <option value="nro" {{ old('nationality') == 'nro' ? 'selected' : '' }}>NRO</option>
                                    <option value="nre" {{ old('nationality') == 'nre' ? 'selected' : '' }}>NRE</option>
                                    <option value="pio" {{ old('nationality') == 'pio' ? 'selected' : '' }}>OCI/PIO
                                    </option>
                                    <option value="gch" {{ old('nationality') == 'gch' ? 'selected' : '' }}>Green Card
                                        Holder</option>
                                    <option value="trioc" {{ old('nationality') == 'trioc' ? 'selected' : '' }}>Tax
                                        Resident in Other Country</option>
                                    <option value="fn" {{ old('nationality') == 'fn' ? 'selected' : '' }}>Foreign
                                        National</option>
                                    <option value="other" {{ old('nationality') == 'other' ? 'selected' : '' }}>Other
                                    </option>
                                </select>

                                @error('nationality')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            {{-- Occupation --}}
                            <div class="col-md-2 mb-3">
                                <label class="form-label" for="occupation">Occupation</label>
                                <select class="form-select @error('occupation') is-invalid @enderror" id="occupation"
                                    name="occupation">
                                    <option value="">Select</option>
                                    <option value="private_sector"
                                        {{ old('occupation') == 'private_sector' ? 'selected' : '' }}>Private Sector
                                    </option>
                                    <option value="public_sector"
                                        {{ old('occupation') == 'public_sector' ? 'selected' : '' }}>Public Sector
                                    </option>
                                    <option value="government" {{ old('occupation') == 'government' ? 'selected' : '' }}>
                                        Government
                                        Service</option>
                                    <option value="business" {{ old('occupation') == 'business' ? 'selected' : '' }}>
                                        Business</option>
                                    <option value="professional"
                                        {{ old('occupation') == 'professional' ? 'selected' : '' }}>Professional</option>
                                    <option value="agriculture"
                                        {{ old('occupation') == 'agriculture' ? 'selected' : '' }}>
                                        Agriculture</option>
                                    <option value="retired" {{ old('occupation') == 'retired' ? 'selected' : '' }}>Retired
                                    </option>
                                    <option value="housewife" {{ old('occupation') == 'housewife' ? 'selected' : '' }}>
                                        Housewife</option>
                                    <option value="student" {{ old('occupation') == 'student' ? 'selected' : '' }}>Student
                                    </option>
                                    <option value="doctor" {{ old('occupation') == 'doctor' ? 'selected' : '' }}>Doctor
                                    </option>
                                    <option value="education" {{ old('occupation') == 'education' ? 'selected' : '' }}>
                                        Education</option>
                                    <option value="other" {{ old('occupation') == 'other' ? 'selected' : '' }}>Other
                                    </option>
                                </select>
                                @error('occupation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            {{-- PAN No. --}}
                            {{-- <div class="col-md-2 mb-3">
                                <label class="form-label" for="pan_no">PAN No.</label>
                                <input type="text" class="form-control @error('pan_no') is-invalid @enderror"
                                    id="pan_no" name="pan_no" maxlength="10"
                                    value="{{ old('pan_no', $clientFamily->pan_no) }}"
                                    oninput="this.value = this.value.toUpperCase()"
                                    onblur="validatePAN(this.value,'errpancardno')">
                                @error('pan_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div> --}}


                            {{-- Aadhaar No. --}}
                            {{-- <div class="col-md-2 mb-3">
                                <label class="form-label" for="aadhar_no">Aadhaar No.</label>
                                <input type="text" class="form-control @error('aadhar_no') is-invalid @enderror"
                                    id="aadhar_no" name="aadhar_no" maxlength="12" value="{{ old('aadhar_no') }}">
                                @error('aadhar_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div> --}}


                            {{-- CKYC No --}}
                            {{-- <div class="col-md-2 mb-3">
                                <label class="form-label" for="ckyc_no">CKYC No.</label>
                                <input type="text" class="form-control @error('ckyc_no') is-invalid @enderror"
                                    id="ckyc_no" name="ckyc_no" maxlength="20" value="{{ old('ckyc_no') }}">
                                @error('ckyc_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div> --}}



                            {{-- Mobile Number --}}
                            <div class="col-md-2 mb-3">
                                <label class="form-label" for="mobile_no">Mobile Number</label>
                                <input type="text"
                                    class="form-control onlyphone @error('mobile_no') is-invalid @enderror" id="phone"
                                    name="mobile_no" maxlength="15" value="{{ old('mobile_no') }}">
                                @error('mobile_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            {{-- WhatsApp Number --}}
                            <div class="col-md-2 mb-3">
                                <label class="form-label" for="whatsapp_no">WhatsApp Number</label>
                                <input type="text"
                                    class="form-control onlyphone @error('whatsapp_no') is-invalid @enderror"
                                    id="whatsapp_no" name="whatsapp_no" maxlength="15"
                                    value="{{ old('whatsapp_no') }}">
                                <label class="uk-margin-right"><input class="uk-checkbox chkbox_fwapp_same_as_mobile"
                                        type="checkbox" id="" value="ON">
                                    Same as mobile no.</label>
                                @error('whatsapp_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            {{-- Landline No --}}
                            <div class="col-md-2 mb-3">
                                <label class="form-label" for="landline_no">Landline No.</label>
                                <input type="text" class="form-control @error('landline_no') is-invalid @enderror"
                                    id="landline_no" name="landline_no" maxlength="15"
                                    value="{{ old('landline_no') }}">
                                @error('landline_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            {{-- Email --}}
                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="email">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email', $clientFamily->email) }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            {{-- Relation with client --}}
                            <div class="col-md-3 mb-3">
                                <label for="relation_id" class="form-label">Relation with client</label>
                                <select name="relation_id" id="relation_id" class="form-select select2">
                                    <option value="">Select Relation Manager</option>
                                    @foreach ($relations as $d)
                                        <option value="{{ $d->id }}"
                                            {{ old('relation_id') == $d->id ? 'selected' : '' }}>
                                            {{ $d->main_relation }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('relation_id')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>


                            {{-- Remarks / Note --}}
                            <div class="col-md-5 mb-3">
                                <label class="form-label" for="remarks">Remarks / Note</label>
                                <input type="text" class="form-control @error('remarks') is-invalid @enderror"
                                    id="remarks" name="remarks" maxlength="100" value="{{ old('remarks') }}">
                                @error('remarks')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>






                            <!-- Residential Address -->
                            <h6 class="my-3">Residential Address</h6>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Address</label>
                                <input type="text" name="res_address" id="res_address"
                                    class="form-control @error('res_address') is-invalid @enderror"
                                    value="{{ old('res_address') }}">
                                @error('res_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2 mb-3">
                                <label class="form-label">Country</label>
                                <select name="res_country" id="res_country"
                                    class="form-select select2  @error('res_country') is-invalid @enderror">
                                    <option value="">Select Country</option>
                                    <option value="India" {{ old('res_country') == 'India' ? 'selected' : '' }}>India
                                    </option>
                                    <option value="USA" {{ old('res_country') == 'USA' ? 'selected' : '' }}>United
                                        States</option>
                                    <option value="UK" {{ old('res_country') == 'UK' ? 'selected' : '' }}>United
                                        Kingdom</option>
                                </select>
                                @error('res_country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2 mb-3">
                                <label class="form-label">State</label>
                                <select name="res_state" id="res_state"
                                    class="form-select select2 @error('res_state') is-invalid @enderror">
                                    <option value="">Select State</option>
                                    <option value="Maharashtra" {{ old('res_state') == 'Maharashtra' ? 'selected' : '' }}>
                                        Maharashtra</option>
                                    <option value="Gujarat" {{ old('res_state') == 'Gujarat' ? 'selected' : '' }}>Gujarat
                                    </option>
                                    <option value="Delhi" {{ old('res_state') == 'Delhi' ? 'selected' : '' }}>Delhi
                                    </option>
                                </select>
                                @error('res_state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2 mb-3">
                                <label class="form-label">City</label>
                                <select name="res_city" id="res_city"
                                    class="form-select select2  @error('res_city') is-invalid @enderror">
                                    <option value="">Select City</option>
                                    <option value="Mumbai" {{ old('res_city') == 'Mumbai' ? 'selected' : '' }}>Mumbai
                                    </option>
                                    <option value="Pune" {{ old('res_city') == 'Pune' ? 'selected' : '' }}>Pune</option>
                                    <option value="Ahmedabad" {{ old('res_city') == 'Ahmedabad' ? 'selected' : '' }}>
                                        Ahmedabad</option>
                                </select>
                                @error('res_city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2 mb-3">
                                <label class="form-label">Pincode</label>
                                <input type="text" name="res_pincode" id="res_pincode"
                                    class="form-control onlydigit @error('res_pincode') is-invalid @enderror"
                                    value="{{ old('res_pincode') }}" maxlength="6">
                                @error('res_pincode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>





                            <!-- Office Address -->
                            <h6 class="my-3">Office Address</h6>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Address</label>
                                <input type="text" name="office_address" id="office_address"
                                    class="form-control @error('office_address') is-invalid @enderror"
                                    value="{{ old('office_address') }}">
                                @error('office_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2 mb-3">
                                <label class="form-label">Country</label>
                                <select name="office_country" id="office_country"
                                    class="form-select select2 @error('office_country') is-invalid @enderror">
                                    <option value="">Select Country</option>
                                    <option value="India" {{ old('office_country') == 'India' ? 'selected' : '' }}>India
                                    </option>
                                    <option value="USA" {{ old('office_country') == 'USA' ? 'selected' : '' }}>United
                                        States</option>
                                    <option value="UK" {{ old('office_country') == 'UK' ? 'selected' : '' }}>United
                                        Kingdom</option>
                                </select>
                                @error('office_country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2 mb-3">
                                <label class="form-label">State</label>
                                <select name="office_state" id="office_state"
                                    class="form-select select2 @error('office_state') is-invalid @enderror">
                                    <option value="">Select State</option>
                                    <option value="Maharashtra"
                                        {{ old('office_state') == 'Maharashtra' ? 'selected' : '' }}>Maharashtra</option>
                                    <option value="Gujarat" {{ old('office_state') == 'Gujarat' ? 'selected' : '' }}>
                                        Gujarat</option>
                                    <option value="Delhi" {{ old('office_state') == 'Delhi' ? 'selected' : '' }}>Delhi
                                    </option>
                                </select>
                                @error('office_state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2 mb-3">
                                <label class="form-label">City</label>
                                <select name="office_city" id="office_city"
                                    class="form-select select2 @error('office_city') is-invalid @enderror">
                                    <option value="">Select City</option>
                                    <option value="Mumbai" {{ old('office_city') == 'Mumbai' ? 'selected' : '' }}>Mumbai
                                    </option>
                                    <option value="Pune" {{ old('office_city') == 'Pune' ? 'selected' : '' }}>Pune
                                    </option>
                                    <option value="Ahmedabad" {{ old('office_city') == 'Ahmedabad' ? 'selected' : '' }}>
                                        Ahmedabad</option>
                                </select>
                                @error('office_city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2 mb-3">
                                <label class="form-label">Pincode</label>
                                <input type="text" name="office_pincode" id="office_pincode"
                                    class="form-control onlydigit @error('office_pincode') is-invalid @enderror"
                                    value="{{ old('office_pincode') }}" maxlength="6">
                                @error('office_pincode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                        </div>
                    </div>
                </div>
            </div>


        </div>



        <!-- Submit -->
        <!-- Info / Note -->


        <div class="text-end mt-3">
            <button type="submit" class="btn btn-primary px-4">Update</button>

        </div>
    </form>


@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // For Firm WhatsApp Number
            $('.chkbox_fwapp_same_as_mobile').on('change', function() {
                if ($(this).is(':checked')) {
                    $('#whatsapp_no').val($('#phone').val());
                } else {
                    $('#whatsapp_no').val('');
                }
            });


        });
    </script>
@endpush
