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

    <style>
        .doc-card {
            border: 1.5px dashed #d0d7e3;
            border-radius: 14px;
            background: #fafbfd;
            transition: all 0.25s ease;
            cursor: pointer;
        }

        .doc-card:hover {
            border-color: #3b82f6;
            background: #f0f5ff;
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.1);
        }

        .doc-card--uploaded {
            border: 1.5px solid #22c55e;
            background: #f0fdf4;
        }

        .doc-card--uploaded:hover {
            border-color: #16a34a;
            background: #dcfce7;
        }

        .doc-badge {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.4px;
            padding: 3px 9px;
            border-radius: 6px;
            text-transform: uppercase;
        }

        .doc-badge--required {
            background: #fff1f1;
            color: #dc2626;
            border: 1px solid #fca5a5;
        }

        .doc-badge--uploaded {
            background: #dcfce7;
            color: #15803d;
            border: 1px solid #86efac;
        }

        .status-dot {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }

        .status-dot--red {
            background: #ef4444;
        }

        .status-dot--green {
            background: #22c55e;
        }
    </style>

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
        <a href="{{ route('master.companies.index') }}">Company</a>
    </h4>

    <form action="{{ route('master.companies.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row align-items-stretch">

            {{-- Basic Information --}}
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Basic Information</h5>
                        <small class="text-muted float-end">Company Primary Details</small>
                    </div>
                    <div class="card-body">
                        <div class="row g-3 mt-2">

                            <div class="col-md-4 mb-3">
                                <label>Company Name <span class="text-danger">*</span></label>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                    placeholder="Enter company name">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">

                                <!-- 📄 LEGAL NAME -->
                                <div class="col-md-4 mb-3">
                                    <label>Legal Name</label>
                                    <input type="text" name="legal_name"
                                        class="form-control @error('legal_name') is-invalid @enderror"
                                        value="{{ old('legal_name') }}" placeholder="Legal registered name">
                                    @error('legal_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- 📧 EMAIL -->
                                <div class="col-md-4 mb-3">
                                    <label>Email</label>
                                    <input type="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email') }}" placeholder="Enter company email">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- ✅ STATUS -->
                                <div class="col-md-4 mb-3">
                                    <label>Status</label>
                                    <select name="is_active" class="form-select @error('is_active') is-invalid @enderror">
                                        <option value="">Select Status</option>
                                        <option value="active" {{ old('is_active') == 'active' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="inactive" {{ old('is_active') == 'inactive' ? 'selected' : '' }}>
                                            Inactive</option>
                                    </select>
                                    @error('is_active')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>

                            <div class="col-md-4 mb-3">
                                <label>Company Type <span class="text-danger">*</span></label>
                                <select name="company_type"
                                    class="form-control @error('company_type') is-invalid @enderror">

                                    <option value="">Select type</option>

                                    @foreach ($companyTypes as $key => $value)
                                        <option value="{{ $key }}"
                                            {{ old('company_type') == $key ? 'selected' : '' }}>
                                            {{ $value }}
                                        </option>
                                    @endforeach

                                </select>

                                @error('company_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Website</label>

                                <div class="input-group">
                                    <span class="input-group-text">https://</span>

                                    <input type="text" name="website"
                                        class="form-control @error('website') is-invalid @enderror"
                                        value="{{ old('website') }}"
                                        placeholder="example.com">
                                </div>

                                @error('website')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            {{-- Address Details --}}
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">📍 Address Details</h5>
                        <span class="text-muted float-end">
                            <div class="form-check">
                                <input type="checkbox" id="sameAddress" class="form-check-input">
                                <label class="form-check-label">Same as Registered address</label>
                            </div>
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="row g-3 mt-2">

                            <!-- REGISTERED -->
                            <div class="col-md-6 border-end pe-4">
                                <h6 class="mb-3 text-muted">Registered Address</h6>

                                <div class="mb-3">
                                    <label>Address Line 1 <span class="text-danger">*</span></label>
                                    <input type="text" name="reg_address_line1" placeholder="Building No., Street, Area"
                                        class="form-control @error('reg_address_line1') is-invalid @enderror"
                                        value="{{ old('reg_address_line1') }}">
                                    @error('reg_address_line1')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label>Address Line 2</label>
                                    <input type="text" name="reg_address_line2" placeholder="Floor, Suite, Landmark"
                                        class="form-control" value="{{ old('reg_address_line2') }}">
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label>City</label>
                                        <input type="text" name="reg_city"
                                            class="form-control @error('reg_city') is-invalid @enderror"
                                            value="{{ old('reg_city') }}" placeholder="City">
                                        @error('reg_city')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>State</label>
                                        <select name="reg_state"
                                            class="form-select @error('reg_state') is-invalid @enderror">
                                            <option value="">Select state...</option>
                                            <option value="Maharashtra"
                                                {{ old('reg_state') == 'Maharashtra' ? 'selected' : '' }}>Maharashtra
                                            </option>
                                        </select>
                                        @error('reg_state')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Postal Code</label>
                                        <input type="text" name="reg_pincode"
                                            class="form-control @error('reg_pincode') is-invalid @enderror"
                                            value="{{ old('reg_pincode') }}" placeholder="Postal Code">
                                        @error('reg_pincode')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Country</label>
                                        <select name="reg_country" class="form-control">
                                            <option value="India">India</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- OPERATIONAL -->
                            <div class="col-md-6 ps-4" id="operationalAddress">
                                <h6 class="mb-3 text-muted">Operational / Correspondence Address</h6>

                                <div class="mb-3">
                                    <label>Address Line 1</label>
                                    <input type="text" name="op_address_line1"
                                        class="form-control @error('op_address_line1') is-invalid @enderror"
                                        value="{{ old('op_address_line1') }}" placeholder="Building No., Street, Area">
                                    @error('op_address_line1')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label>Address Line 2</label>
                                    <input type="text" name="op_address_line2" class="form-control"
                                        value="{{ old('op_address_line2') }}" placeholder="Floor, Suite, Landmark">
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label>City</label>
                                        <input type="text" name="op_city"
                                            class="form-control @error('op_city') is-invalid @enderror"
                                            value="{{ old('op_city') }}" placeholder="City">
                                        @error('op_city')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>State</label>
                                        <select name="op_state"
                                            class="form-select @error('op_state') is-invalid @enderror">
                                            <option value="">Select state...</option>
                                            <option value="Maharashtra"
                                                {{ old('op_state') == 'Maharashtra' ? 'selected' : '' }}>Maharashtra
                                            </option>
                                        </select>
                                        @error('op_state')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Postal Code</label>
                                        <input type="text" name="op_pincode"
                                            class="form-control @error('op_pincode') is-invalid @enderror"
                                            value="{{ old('op_pincode') }}" placeholder="Postal Code">
                                        @error('op_pincode')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Country</label>
                                        <select name="op_country" class="form-control">
                                            <option value="India">India</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            {{-- Registration Details --}}
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Registration Details</h5>
                        <small class="text-muted float-end">Legal & Tax Numbers</small>
                    </div>
                    <div class="card-body">
                        <div class="row g-3 mt-2">

                            <div class="col-md-3 mb-3">
                                <label>CIN No</label>
                                <input type="text" name="cin_no" maxlength="21"
                                    class="form-control @error('cin_no') is-invalid @enderror"
                                    value="{{ old('cin_no') }}" placeholder="Enter CIN Number">
                                @error('cin_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label>PAN No</label>
                                <input type="text" name="pan_no" maxlength="10"
                                    class="form-control @error('pan_no') is-invalid @enderror"
                                    value="{{ old('pan_no') }}" placeholder="ABCDE1234F">
                                @error('pan_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label>TAN No</label>
                                <input type="text" name="tan_no" maxlength="10"
                                    class="form-control @error('tan_no') is-invalid @enderror"
                                    value="{{ old('tan_no') }}" placeholder="TAN Number">
                                @error('tan_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label>GSTIN</label>
                                <input type="text" name="gstin" maxlength="15"
                                    class="form-control @error('gstin') is-invalid @enderror"
                                    value="{{ old('gstin') }}" placeholder="27ABCDE1234F1Z5">
                                @error('gstin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label>Udyam Aadhar</label>
                                <input type="text" name="udyam_aadhar_no" maxlength="19"
                                    class="form-control @error('udyam_aadhar_no') is-invalid @enderror"
                                    value="{{ old('udyam_aadhar_no') }}" placeholder="Udyam Registration No">
                                @error('udyam_aadhar_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label>MSME No</label>
                                <input type="text" name="msme_certification_no" maxlength="100"
                                    class="form-control @error('msme_certification_no') is-invalid @enderror"
                                    value="{{ old('msme_certification_no') }}" placeholder="MSME Certificate No">
                                @error('msme_certification_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label>ROC No</label>
                                <input type="text" name="roc_no" maxlength="100"
                                    class="form-control @error('roc_no') is-invalid @enderror"
                                    value="{{ old('roc_no') }}" placeholder="ROC Number">
                                @error('roc_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label>Partnership Reg. No</label>
                                <input type="text" name="partnership_registration_no" maxlength="100"
                                    class="form-control @error('partnership_registration_no') is-invalid @enderror"
                                    value="{{ old('partnership_registration_no') }}" placeholder="Registration No">
                                @error('partnership_registration_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label>CKYC</label>
                                <input type="text" name="ckyc" maxlength="14"
                                    class="form-control @error('ckyc') is-invalid @enderror" value="{{ old('ckyc') }}"
                                    placeholder="CKYC Number">
                                @error('ckyc')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label>Gumasta No</label>
                                <input type="text" name="gumasta_no" maxlength="100"
                                    class="form-control @error('gumasta_no') is-invalid @enderror"
                                    value="{{ old('gumasta_no') }}" placeholder="Gumasta License No">
                                @error('gumasta_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label>Watermark No</label>
                                <input type="text" name="watermark_no" maxlength="100"
                                    class="form-control @error('watermark_no') is-invalid @enderror"
                                    value="{{ old('watermark_no') }}" placeholder="Watermark Number">
                                @error('watermark_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label>Copyright No</label>
                                <input type="text" name="copyrights_no" maxlength="100"
                                    class="form-control @error('copyrights_no') is-invalid @enderror"
                                    value="{{ old('copyrights_no') }}" placeholder="Copyright Number">
                                @error('copyrights_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label>Establishment Date</label>
                                <input type="date" name="est_date"
                                    class="form-control @error('est_date') is-invalid @enderror"
                                    value="{{ old('est_date') }}">
                                @error('est_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            {{-- Bank Details --}}
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Bank Details</h5>
                        <small class="text-muted float-end">Bank Information</small>
                    </div>
                    <div class="card-body">
                        <div id="bankDetailsWrapper">
                            <div class="bank-details-row row g-3 mt-2 position-relative">

                                <div class="col-md-3">
                                    <label class="form-label">IFSC Code</label>
                                    <input type="text" name="banks[0][ifsc_code]"
                                        class="form-control ifsc_code @error('banks.0.ifsc_code') is-invalid @enderror"
                                        placeholder="Enter IFSC Code" value="{{ old('banks.0.ifsc_code') }}">
                                    @error('banks.0.ifsc_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Account No</label>
                                    <input type="text" name="banks[0][account_number]"
                                        class="form-control @error('banks.0.account_number') is-invalid @enderror"
                                        placeholder="Enter Account Number" maxlength="15"
                                        value="{{ old('banks.0.account_number') }}">
                                    @error('banks.0.account_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Account Type</label>
                                    <select name="banks[0][account_type]"
                                        class="form-select @error('banks.0.account_type') is-invalid @enderror">
                                        <option value="">Select Type</option>
                                        <option value="savings"
                                            {{ old('banks.0.account_type') == 'savings' ? 'selected' : '' }}>Saving
                                            Account</option>
                                        <option value="current"
                                            {{ old('banks.0.account_type') == 'current' ? 'selected' : '' }}>Current
                                            Account</option>
                                        <option value="od_cc"
                                            {{ old('banks.0.account_type') == 'od_cc' ? 'selected' : '' }}>
                                            Overdraft/CC</option>
                                        <option value="nre"
                                            {{ old('banks.0.account_type') == 'nre' ? 'selected' : '' }}>NRE
                                        </option>
                                        <option value="nri"
                                            {{ old('banks.0.account_type') == 'nri' ? 'selected' : '' }}>NRI
                                        </option>
                                        <option value="nro"
                                            {{ old('banks.0.account_type') == 'nro' ? 'selected' : '' }}>NRO
                                        </option>
                                        <option value="tem_deposit"
                                            {{ old('banks.0.account_type') == 'tem_deposit' ? 'selected' : '' }}>Term
                                            Deposit</option>
                                        <option value="ra"
                                            {{ old('banks.0.account_type') == 'ra' ? 'selected' : '' }}>Recurring
                                        </option>
                                    </select>
                                    @error('banks.0.account_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Bank Name</label>
                                    <input type="text" name="banks[0][bank_name]"
                                        class="form-control bank_name bg-secondary-subtle @error('banks.0.bank_name') is-invalid @enderror"
                                        readonly value="{{ old('banks.0.bank_name') }}">
                                    @error('banks.0.bank_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Branch Name</label>
                                    <input type="text" name="banks[0][branch_name]"
                                        class="form-control branch_name bg-secondary-subtle @error('banks.0.branch_name') is-invalid @enderror"
                                        readonly value="{{ old('banks.0.branch_name') }}">
                                    @error('banks.0.branch_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Bank Code</label>
                                    <input type="text" name="banks[0][bank_code]"
                                        class="form-control bank_code bg-secondary-subtle @error('banks.0.bank_code') is-invalid @enderror"
                                        readonly value="{{ old('banks.0.bank_code') }}">
                                    @error('banks.0.bank_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label d-block">Primary</label>
                                    <input type="hidden" name="banks[0][is_primary]" value="0">
                                    <input type="checkbox" name="banks[0][is_primary]" value="1"
                                        class="form-check-input setPrimary @error('banks.0.is_primary') is-invalid @enderror"
                                        {{ old('banks.0.is_primary') == 1 ? 'checked' : '' }}>
                                    @error('banks.0.is_primary')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-1 d-flex align-items-end">
                                    <button type="button" class="btn btn-danger btn-sm removeBankRow d-none">
                                        <i class="bx bx-minus"></i> Remove
                                    </button>
                                </div>

                            </div>
                        </div>

                        <div class="mt-2">
                            <button type="button" id="addMoreBank" class="btn btn-primary">
                                <i class="bx bx-plus"></i> Add More Bank
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Required Documents --}}
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">🔴 Required Documents</h5>
                        <small class="text-muted float-end">Upload all documents</small>
                    </div>
                    <div class="card-body">

                        @php
                            $docs = [
                                ['name' => 'attachment_pan', 'label' => 'PAN Card', 'icon' => '🪪'],
                                ['name' => 'attachment_tan', 'label' => 'TAN Certificate', 'icon' => '📋'],
                                ['name' => 'attachment_gstin', 'label' => 'GST Certificate', 'icon' => '📄'],
                                ['name' => 'attachment_msme', 'label' => 'MSME Certificate', 'icon' => '🏢'],
                                ['name' => 'attachment_udyam_aadhar', 'label' => 'Udyam Aadhar', 'icon' => '🪪'],
                                ['name' => 'attachment_gumasta', 'label' => 'Gumasta License', 'icon' => '📄'],
                                ['name' => 'attachment_ckyc', 'label' => 'CKYC Document', 'icon' => '📄'],
                                [
                                    'name' => 'attachment_cancelled_cheque',
                                    'label' => 'Cancelled Cheque',
                                    'icon' => '🏦',
                                ],
                                ['name' => 'attachment_proprietor', 'label' => 'Proprietor Photo', 'icon' => '👤'],
                                ['name' => 'logo', 'label' => 'Company Logo', 'icon' => '🏷️'],
                            ];
                        @endphp

                        <div class="row g-3 mt-2">
                            @foreach ($docs as $doc)
                                @php $uploadedUrl = old($doc['name'] . '_url'); @endphp

                                <div class="col-md-4">
                                    <div class="doc-card position-relative p-4 text-center {{ $uploadedUrl ? 'doc-card--uploaded' : '' }}"
                                        onclick="triggerFile('{{ $doc['name'] }}')">

                                        {{-- BADGE --}}
                                        @if ($uploadedUrl)
                                            <span class="doc-badge doc-badge--uploaded position-absolute top-0 end-0 m-2">✓
                                                Uploaded</span>
                                        @else
                                            <span
                                                class="doc-badge doc-badge--required position-absolute top-0 end-0 m-2">Required</span>
                                        @endif

                                        {{-- ICON --}}
                                        <div class="mb-2" style="font-size: 28px;">{{ $doc['icon'] }}</div>

                                        {{-- TITLE --}}
                                        <h6 class="fw-semibold mb-1">{{ $doc['label'] }}</h6>

                                        {{-- STATUS ROW --}}
                                        <div class="d-flex align-items-center justify-content-center gap-1 mb-1">
                                            @if ($uploadedUrl)
                                                <span class="status-dot status-dot--green"></span>
                                                <span class="status-text small fw-medium text-success">Uploaded</span>
                                            @else
                                                <span class="status-dot status-dot--red"></span>
                                                <span class="status-text small fw-medium text-danger">Not Uploaded</span>
                                            @endif
                                        </div>

                                        {{-- FORMAT --}}
                                        <p class="text-muted mb-2" style="font-size: 11px;">
                                            PDF, JPG, PNG, JPEG, WEBP &middot; max 5MB
                                        </p>

                                        {{-- FILE INPUT --}}
                                        <input type="file" id="{{ $doc['name'] }}" name="{{ $doc['name'] }}"
                                            accept=".pdf,.jpg,.jpeg,.png,.webp"
                                            class="d-none @error($doc['name']) is-invalid @enderror"
                                            onchange="uploadTempFile(this, '{{ $doc['name'] }}')">

                                        {{-- HINT / FILENAME --}}
                                        <div class="upload-hint">
                                            @if ($uploadedUrl)
                                                <span style="font-size:12px;color:#3b82f6;">📎
                                                    {{ basename($uploadedUrl) }}</span>
                                            @else
                                                <p class="text-muted mb-0 small">Click to upload</p>
                                            @endif
                                        </div>

                                        {{-- VALIDATION ERROR --}}
                                        @error($doc['name'])
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror

                                        {{-- INLINE UPLOAD ERROR (always present for JS) --}}
                                        <div class="upload-error text-danger small mt-1" style="display:none;"></div>

                                        {{-- HIDDEN URL --}}
                                        <input type="hidden" name="{{ $doc['name'] }}_url"
                                            value="{{ $uploadedUrl }}">

                                        {{-- EXISTING PREVIEW --}}
                                        @if ($uploadedUrl)
                                            @php $ext = strtolower(pathinfo($uploadedUrl, PATHINFO_EXTENSION)); @endphp
                                            <div class="mt-3 position-relative d-inline-block doc-preview">
                                                @if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp']))
                                                    <img src="{{ $uploadedUrl }}" width="70" height="70"
                                                        class="rounded shadow-sm"
                                                        style="object-fit:cover;border:2px solid #86efac;">
                                                @else
                                                    <div class="d-flex align-items-center gap-2 rounded px-3 py-2"
                                                        style="background:#f1f5f9;border:1px solid #e2e8f0;font-size:12px;">
                                                        <span style="font-size:22px;">📄</span>
                                                        <span class="text-muted"
                                                            style="max-width:120px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                                                            {{ basename($uploadedUrl) }}
                                                        </span>
                                                    </div>
                                                @endif
                                                <button type="button"
                                                    class="btn btn-sm btn-danger position-absolute top-0 start-100 translate-middle"
                                                    style="width:20px;height:20px;padding:0;font-size:10px;line-height:1;border-radius:50%;"
                                                    onclick="event.stopPropagation(); removeImage('{{ $doc['name'] }}')">✕</button>
                                            </div>
                                        @endif

                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>

        </div>

        <div class="text-end mt-3">
            <button type="submit" class="btn btn-primary px-4">Save</button>
            <a href="{{ route('master.companies.index') }}" class="btn btn-secondary px-4">Cancel</a>
        </div>
    </form>

@endsection

@push('scripts')
    <script>
        // ── Address copy ──────────────────────────────────────────────
        $('#sameAddress').on('change', function() {

            if ($(this).is(':checked')) {

                // Copy values
                $('input[name="op_address_line1"]').val($('input[name="reg_address_line1"]').val());
                $('input[name="op_address_line2"]').val($('input[name="reg_address_line2"]').val());
                $('input[name="op_city"]').val($('input[name="reg_city"]').val());
                $('input[name="op_pincode"]').val($('input[name="reg_pincode"]').val());

                $('select[name="op_state"]').val($('select[name="reg_state"]').val());
                $('select[name="op_country"]').val($('select[name="reg_country"]').val());

            } else {

                // Clear values when unchecked
                $('input[name="op_address_line1"]').val('');
                $('input[name="op_address_line2"]').val('');
                $('input[name="op_city"]').val('');
                $('input[name="op_pincode"]').val('');

                $('select[name="op_state"]').val('');
                $('select[name="op_country"]').val('');

            }

        });



        // ── Doc upload helpers ────────────────────────────────────────
        function triggerFile(id) {
            document.getElementById(id).click();
        }

        function uploadTempFile(input, fieldName) {
            const file = input.files[0];
            if (!file) return;

            const card = input.closest('.doc-card');
            const formData = new FormData();
            formData.append('file', file);

            setCardLoading(card, true);

            fetch('/upload-temp', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: formData
                })
                .then(res => {
                    if (!res.ok) return res.json().then(e => {
                        throw new Error(e.message || 'Server error');
                    });
                    return res.json();
                })
                .then(data => {
                    if (data.url) {
                        card.querySelector(`input[name="${fieldName}_url"]`).value = data.url;
                        setCardUploaded(card, file.name, data.url, file);
                    }
                })
                .catch(err => {
                    console.error('Upload error:', err);
                    const hint = card.querySelector('.upload-hint');
                    if (hint) hint.innerHTML = `<p class="text-muted mb-0 small">Click to upload</p>`;
                    const errorDiv = card.querySelector('.upload-error');
                    if (errorDiv) {
                        errorDiv.textContent = '⚠ Upload failed. Try again.';
                        errorDiv.style.display = 'block';
                        setTimeout(() => errorDiv.style.display = 'none', 4000);
                    }
                })
                .finally(() => setCardLoading(card, false));
        }

        function setCardUploaded(card, fileName, fileUrl, fileObj = null) {
            card.classList.add('doc-card--uploaded');

            const badge = card.querySelector('.doc-badge');
            badge.className = 'doc-badge doc-badge--uploaded position-absolute top-0 end-0 m-2';
            badge.textContent = '✓ Uploaded';

            card.querySelector('.status-dot').className = 'status-dot status-dot--green';
            const st = card.querySelector('.status-text');
            st.className = 'status-text small fw-medium text-success';
            st.textContent = 'Uploaded';

            card.querySelector('.upload-hint').innerHTML =
                `<span style="font-size:12px;color:#3b82f6;">📎 ${fileName}</span>`;

            showPreview(card, fileUrl, fileName, fileObj);
        }

        function showPreview(card, fileUrl, fileName, fileObj = null) {
            const old = card.querySelector('.doc-preview');
            if (old) old.remove();

            const id = card.querySelector('input[type=file]').id;
            const isImage = /\.(jpg|jpeg|png|webp)$/i.test(fileName);
            const preview = document.createElement('div');
            preview.className = 'mt-3 position-relative d-inline-block doc-preview';

            const removeBtn = `<button type="button"
            class="btn btn-sm btn-danger position-absolute top-0 start-100 translate-middle"
            style="width:20px;height:20px;padding:0;font-size:10px;line-height:1;border-radius:50%;"
            onclick="event.stopPropagation(); removeImage('${id}')">✕</button>`;

            if (isImage) {
                const src = fileObj ? URL.createObjectURL(fileObj) : fileUrl;
                preview.innerHTML = `<img src="${src}" width="70" height="70" class="rounded shadow-sm"
                style="object-fit:cover;border:2px solid #86efac;">${removeBtn}`;
            } else {
                preview.innerHTML = `
                <div class="d-flex align-items-center gap-2 rounded px-3 py-2"
                    style="background:#f1f5f9;border:1px solid #e2e8f0;font-size:12px;max-width:180px;">
                    <span style="font-size:24px;flex-shrink:0;">📄</span>
                    <span class="text-muted" style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"
                        title="${fileName}">${fileName}</span>
                </div>${removeBtn}`;
            }

            card.appendChild(preview);
        }

        function setCardLoading(card, loading) {
            card.style.opacity = loading ? '0.6' : '1';
            card.style.pointerEvents = loading ? 'none' : 'auto';
            if (loading) {
                const hint = card.querySelector('.upload-hint');
                if (hint) hint.innerHTML = `
                <span class="small text-muted d-flex align-items-center justify-content-center gap-1">
                    <span class="spinner-border spinner-border-sm" style="width:10px;height:10px;"></span>
                    Uploading...
                </span>`;
            }
        }

        function removeImage(fieldName) {
            const input = document.getElementById(fieldName);
            const card = input.closest('.doc-card');

            const img = card.querySelector('.doc-preview img');
            if (img && img.src.startsWith('blob:')) URL.revokeObjectURL(img.src);

            input.value = '';
            card.querySelector(`input[name="${fieldName}_url"]`).value = '';

            const preview = card.querySelector('.doc-preview');
            if (preview) preview.remove();

            card.classList.remove('doc-card--uploaded');

            const badge = card.querySelector('.doc-badge');
            badge.className = 'doc-badge doc-badge--required position-absolute top-0 end-0 m-2';
            badge.textContent = 'Required';

            card.querySelector('.status-dot').className = 'status-dot status-dot--red';
            const st = card.querySelector('.status-text');
            st.className = 'status-text small fw-medium text-danger';
            st.textContent = 'Not Uploaded';

            card.querySelector('.upload-hint').innerHTML =
                `<p class="text-muted mb-0 small">Click to upload</p>`;
        }
    </script>
@endpush
