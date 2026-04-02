@extends('layouts.master-layout')

@section('content')

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .page-title {
            font-size: 20px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 4px;
        }

        .page-sub {
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 24px;
        }

        /* ── Section Card ── */
        .sc {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            margin-bottom: 20px;
            overflow: hidden;
        }

        .sc-head {
            padding: 14px 20px;
            border-bottom: 1px solid #f3f4f6;
            display: flex;
            align-items: center;
            gap: 10px;
            background: #fafafa;
        }

        .sc-head-icon {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            background: #eff6ff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            flex-shrink: 0;
        }

        .sc-head-title {
            font-size: 14px;
            font-weight: 600;
            color: #111827;
        }

        .sc-head-sub {
            font-size: 12px;
            color: #9ca3af;
            margin-left: auto;
        }

        .sc-body {
            padding: 20px;
        }

        /* ── Form grid ── */
        .fg {
            display: grid;
            gap: 16px;
        }

        .fg-2 {
            grid-template-columns: repeat(2, 1fr);
        }

        .fg-3 {
            grid-template-columns: repeat(3, 1fr);
        }

        .fg-4 {
            grid-template-columns: repeat(4, 1fr);
        }

        .fg-6 {
            grid-template-columns: repeat(6, 1fr);
        }

        .col-span-2 {
            grid-column: span 2;
        }

        .col-span-3 {
            grid-column: span 3;
        }

        .fl label {
            display: block;
            font-size: 11.5px;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            margin-bottom: 5px;
        }

        .fl input,
        .fl select,
        .fl textarea {
            width: 100%;
            padding: 8px 11px;
            border: 1px solid #d1d5db;
            border-radius: 7px;
            font-size: 13.5px;
            color: #111827;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #fff;
            transition: border-color 0.15s, box-shadow 0.15s;
            outline: none;
        }

        .fl input:focus,
        .fl select:focus,
        .fl textarea:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .fl input[readonly] {
            background: #f9fafb;
            color: #9ca3af;
            cursor: not-allowed;
        }

        .fl .req {
            color: #ef4444;
        }

        .input-group-wrap {
            display: flex;
            border: 1px solid #d1d5db;
            border-radius: 7px;
            overflow: hidden;
            transition: border-color 0.15s, box-shadow 0.15s;
        }

        .input-group-wrap:focus-within {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .input-group-wrap .prefix {
            padding: 8px 11px;
            background: #f3f4f6;
            color: #6b7280;
            font-size: 13px;
            border-right: 1px solid #d1d5db;
            white-space: nowrap;
        }

        .input-group-wrap input {
            border: none !important;
            box-shadow: none !important;
            border-radius: 0 !important;
            flex: 1;
        }

        /* ── Address split ── */
        .addr-split {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .addr-col {}

        .addr-col-title {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: #3b82f6;
            margin-bottom: 14px;
            padding-bottom: 8px;
            border-bottom: 1px solid #eff6ff;
        }

        .same-addr-row {
            display: flex;
            align-items: center;
            gap: 7px;
            margin-left: auto;
            font-size: 12.5px;
            color: #6b7280;
            cursor: pointer;
        }

        .same-addr-row input[type=checkbox] {
            accent-color: #3b82f6;
            width: 14px;
            height: 14px;
        }

        /* ── Doc cards ── */
        .doc-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 14px;
        }

        .doc-card {
            border: 1.5px dashed #d1d5db;
            border-radius: 10px;
            padding: 16px 10px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            background: #fafafa;
            position: relative;
        }

        .doc-card:hover {
            border-color: #3b82f6;
            background: #eff6ff;
        }

        .doc-card.uploaded {
            border-style: solid;
            border-color: #22c55e;
            background: #f0fdf4;
        }

        .doc-card input[type=file] {
            display: none;
        }

        .doc-card-icon {
            font-size: 24px;
            margin-bottom: 6px;
        }

        .doc-card-label {
            font-size: 11.5px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
            line-height: 1.3;
        }

        .doc-status {
            font-size: 10.5px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
        }

        .doc-status .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            display: inline-block;
        }

        .doc-status.ok {
            color: #16a34a;
        }

        .doc-status.ok .dot {
            background: #22c55e;
        }

        .doc-status.miss {
            color: #dc2626;
        }

        .doc-status.miss .dot {
            background: #ef4444;
        }

        /* Doc image preview */
        .doc-preview-img {
            width: 100%;
            height: 64px;
            object-fit: contain;
            border-radius: 6px;
            margin-bottom: 6px;
            border: 1px solid #e5e7eb;
            background: #fff;
        }

        .doc-preview-file {
            font-size: 10px;
            color: #6b7280;
            word-break: break-all;
            margin-bottom: 4px;
        }

        .doc-remove-btn {
            position: absolute;
            top: 6px;
            right: 6px;
            width: 18px;
            height: 18px;
            background: #ef4444;
            color: #fff;
            border: none;
            border-radius: 50%;
            font-size: 9px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            line-height: 1;
        }

        /* ── Bank rows ── */
        .bank-row {
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 16px;
            margin-bottom: 12px;
            position: relative;
            background: #fafafa;
        }

        .bank-row-num {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #3b82f6;
            margin-bottom: 12px;
        }

        .bank-remove {
            position: absolute;
            top: 14px;
            right: 14px;
            background: #fee2e2;
            border: none;
            color: #dc2626;
            font-size: 11.5px;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 6px;
            cursor: pointer;
        }

        .bank-remove:hover {
            background: #fca5a5;
        }

        /* ── Primary checkbox ── */
        .check-row {
            display: flex;
            align-items: center;
            gap: 7px;
            padding-top: 26px;
        }

        .check-row input[type=checkbox] {
            accent-color: #3b82f6;
            width: 15px;
            height: 15px;
        }

        .check-row label {
            font-size: 13px;
            color: #374151;
            cursor: pointer;
            margin: 0;
        }

        /* ── Bottom actions ── */
        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            padding-top: 4px;
            margin-bottom: 48px;
        }

        .btn-save {
            background: #2563eb;
            color: #fff;
            border: none;
            padding: 10px 28px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            font-family: 'Plus Jakarta Sans', sans-serif;
            transition: background 0.15s;
        }

        .btn-save:hover {
            background: #1d4ed8;
        }

        .btn-cancel {
            background: #f3f4f6;
            color: #374151;
            border: 1px solid #d1d5db;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            font-family: 'Plus Jakarta Sans', sans-serif;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }

        .btn-cancel:hover {
            background: #e5e7eb;
            color: #111827;
        }

        .btn-add {
            background: #fff;
            color: #2563eb;
            border: 1px dashed #93c5fd;
            padding: 8px 16px;
            border-radius: 7px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            font-family: 'Plus Jakarta Sans', sans-serif;
            margin-top: 4px;
        }

        .btn-add:hover {
            background: #eff6ff;
        }

        /* ── Divider ── */
        .sec-divider {
            height: 1px;
            background: #f3f4f6;
            margin: 4px 0 16px;
        }

        @media (max-width: 1024px) {
            .fg-4 {
                grid-template-columns: repeat(2, 1fr);
            }

            .fg-6 {
                grid-template-columns: repeat(3, 1fr);
            }

            .doc-grid {
                grid-template-columns: repeat(3, 1fr);
            }

            .addr-split {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 640px) {

            .fg-2,
            .fg-3,
            .fg-4 {
                grid-template-columns: 1fr;
            }

            .doc-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>

    {{-- Alerts --}}
    <div>
        @if (session('success'))
            <x-alert-sweet type="success" :message="session('success')" />
        @endif
        @if (session('error'))
            <x-alert-sweet type="danger" :message="session('error')" />
        @endif
    </div>

    @if ($errors->any())
        <div class="alert alert-danger mb-3">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="page-title">{{ $company->name }}</div>
    <div class="page-sub">
        <span class="text-muted">Master / <a href="{{ route('master.companies.index') }}"
                class="text-decoration-none text-muted">Company</a> /</span>
        Edit
    </div>

    <form action="{{ route('master.companies.update', $company->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- ── 1. Basic Information ── --}}
        <div class="sc">
            <div class="sc-head">
                <div class="sc-head-icon">🏢</div>
                <div class="sc-head-title">Basic Information</div>
                <span class="sc-head-sub">Primary Details</span>
            </div>
            <div class="sc-body">
                <div class="fg fg-4">
                    <div class="fl col-span-2">
                        <label>Company Name <span class="req">*</span></label>
                        <input type="text" name="name" class="@error('name') is-invalid @enderror"
                            value="{{ old('name', $company->name) }}" placeholder="Company name">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="fl col-span-2">
                        <label>Legal Name</label>
                        <input type="text" name="legal_name" class="@error('legal_name') is-invalid @enderror"
                            value="{{ old('legal_name', $company->legal_name) }}" placeholder="Legal registered name">
                        @error('legal_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="fl">
                        <label>Company Type <span class="req">*</span></label>
                        <select name="company_type" class="@error('company_type') is-invalid @enderror">
                            <option value="">Select type</option>
                            @foreach ($companyTypes as $key => $value)
                                <option value="{{ $key }}"
                                    {{ old('company_type', $company->company_type) == $key ? 'selected' : '' }}>
                                    {{ $value }}</option>
                            @endforeach
                        </select>
                        @error('company_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="fl">
                        <label>Status</label>
                        <select name="is_active" class="@error('is_active') is-invalid @enderror">
                            <option value="">Select status</option>
                            <option value="active"
                                {{ old('is_active', $company->is_active) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive"
                                {{ old('is_active', $company->is_active) == 'inactive' ? 'selected' : '' }}>Inactive
                            </option>
                        </select>
                        @error('is_active')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="fl col-span-2">
                        <label>Website</label>
                        <div class="input-group-wrap">
                            <span class="prefix">https://</span>
                            <input type="text" name="website" class="@error('website') is-invalid @enderror"
                                value="{{ old('website', $company->website) }}" placeholder="example.com">
                        </div>
                        @error('website')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="fl">
                        <label>Email</label>
                        <input type="email" name="email" class="@error('email') is-invalid @enderror"
                            value="{{ old('email', $company->email) }}" placeholder="company@email.com">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="fl">
                        <label>Mobile Number</label>
                        <input type="text" name="mobile" class="onlydigit @error('mobile') is-invalid @enderror"
                            value="{{ old('mobile', $company->mobile) }}" placeholder="10-digit mobile number"
                            maxlength="10">
                        @error('mobile')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="fl">
                        <label>Establishment Date</label>
                        <input type="date" name="est_date" class="@error('est_date') is-invalid @enderror"
                            value="{{ old('est_date', optional($company->est_date)->format('Y-m-d')) }}">
                        @error('est_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- ── 2. Address Details ── --}}
        <div class="sc">
            <div class="sc-head">
                <div class="sc-head-icon">📍</div>
                <div class="sc-head-title">Address Details</div>
                <label class="same-addr-row">
                    <input type="checkbox" id="sameAddress"> Same as Registered Address
                </label>
            </div>
            <div class="sc-body">
                <div class="addr-split">

                    {{-- Registered --}}
                    <div class="addr-col">
                        <div class="addr-col-title">Registered Address</div>
                        <div class="fg" style="gap:12px;">
                            <div class="fl">
                                <label>Address Line 1 <span class="req">*</span></label>
                                <input type="text" name="reg_address_line1"
                                    class="@error('reg_address_line1') is-invalid @enderror"
                                    value="{{ old('reg_address_line1', $company->reg_address_line1) }}"
                                    placeholder="Building, Street, Area">
                                @error('reg_address_line1')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="fl">
                                <label>Address Line 2</label>
                                <input type="text" name="reg_address_line2"
                                    value="{{ old('reg_address_line2', $company->reg_address_line2) }}"
                                    placeholder="Floor, Suite, Landmark">
                            </div>
                            <div class="fg fg-2" style="gap:12px;">
                                <div class="fl">
                                    <label>City</label>
                                    <input type="text" name="reg_city" class="@error('reg_city') is-invalid @enderror"
                                        value="{{ old('reg_city', $company->reg_city) }}" placeholder="City">
                                    @error('reg_city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="fl">
                                    <label>State</label>
                                    <select name="reg_state" class="@error('reg_state') is-invalid @enderror">
                                        <option value="">Select state</option>
                                        <option value="Maharashtra"
                                            {{ old('reg_state', $company->reg_state) == 'Maharashtra' ? 'selected' : '' }}>
                                            Maharashtra</option>
                                    </select>
                                    @error('reg_state')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="fl">
                                    <label>Postal Code</label>
                                    <input type="text" name="reg_pincode"
                                        class="onlydigit @error('reg_pincode') is-invalid @enderror"
                                        value="{{ old('reg_pincode', $company->reg_pincode) }}" placeholder="Pincode"
                                        maxlength="6">
                                    @error('reg_pincode')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="fl">
                                    <label>Country</label>
                                    <select name="reg_country">
                                        <option value="India">India</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Operational --}}
                    <div class="addr-col" id="operationalAddress">
                        <div class="addr-col-title">Operational / Correspondence Address</div>
                        <div class="fg" style="gap:12px;">
                            <div class="fl">
                                <label>Address Line 1</label>
                                <input type="text" name="op_address_line1"
                                    class="@error('op_address_line1') is-invalid @enderror"
                                    value="{{ old('op_address_line1', $company->op_address_line1) }}"
                                    placeholder="Building, Street, Area">
                                @error('op_address_line1')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="fl">
                                <label>Address Line 2</label>
                                <input type="text" name="op_address_line2"
                                    value="{{ old('op_address_line2', $company->op_address_line2) }}"
                                    placeholder="Floor, Suite, Landmark">
                            </div>
                            <div class="fg fg-2" style="gap:12px;">
                                <div class="fl">
                                    <label>City</label>
                                    <input type="text" name="op_city" class="@error('op_city') is-invalid @enderror"
                                        value="{{ old('op_city', $company->op_city) }}" placeholder="City">
                                    @error('op_city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="fl">
                                    <label>State</label>
                                    <select name="op_state" class="@error('op_state') is-invalid @enderror">
                                        <option value="">Select state</option>
                                        <option value="Maharashtra"
                                            {{ old('op_state', $company->op_state) == 'Maharashtra' ? 'selected' : '' }}>
                                            Maharashtra</option>
                                    </select>
                                    @error('op_state')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="fl">
                                    <label>Postal Code</label>
                                    <input type="text" name="op_pincode"
                                        class="onlydigit @error('op_pincode') is-invalid @enderror"
                                        value="{{ old('op_pincode', $company->op_pincode) }}" placeholder="Pincode"
                                        maxlength="6">
                                    @error('op_pincode')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="fl">
                                    <label>Country</label>
                                    <select name="op_country">
                                        <option value="India">India</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- ── 3. Registration Details ── --}}
        <div class="sc">
            <div class="sc-head">
                <div class="sc-head-icon">📋</div>
                <div class="sc-head-title">Registration Details</div>
                <span class="sc-head-sub">Legal &amp; Tax Numbers</span>
            </div>
            <div class="sc-body">
                <div class="fg fg-4">
                    <div class="fl">
                        <label>CIN No</label>
                        <input type="text" name="cin_no" maxlength="21"
                            class="@error('cin_no') is-invalid @enderror" value="{{ old('cin_no', $company->cin_no) }}"
                            placeholder="CIN Number">
                        @error('cin_no')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="fl">
                        <label>PAN No</label>
                        <input type="text" name="pan_no" maxlength="10"
                            class="@error('pan_no') is-invalid @enderror" value="{{ old('pan_no', $company->pan_no) }}"
                            placeholder="ABCDE1234F">
                        @error('pan_no')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="fl">
                        <label>TAN No</label>
                        <input type="text" name="tan_no" maxlength="10"
                            class="@error('tan_no') is-invalid @enderror" value="{{ old('tan_no', $company->tan_no) }}"
                            placeholder="TAN Number">
                        @error('tan_no')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="fl">
                        <label>GSTIN</label>
                        <input type="text" name="gstin" maxlength="15"
                            class="@error('gstin') is-invalid @enderror" value="{{ old('gstin', $company->gstin) }}"
                            placeholder="27ABCDE1234F1Z5">
                        @error('gstin')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="fl">
                        <label>Udyam Aadhar</label>
                        <input type="text" name="udyam_aadhar_no" maxlength="19"
                            class="@error('udyam_aadhar_no') is-invalid @enderror"
                            value="{{ old('udyam_aadhar_no', $company->udyam_aadhar_no) }}" placeholder="Udyam Reg. No">
                        @error('udyam_aadhar_no')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="fl">
                        <label>MSME No</label>
                        <input type="text" name="msme_certification_no" maxlength="100"
                            class="@error('msme_certification_no') is-invalid @enderror"
                            value="{{ old('msme_certification_no', $company->msme_certification_no) }}"
                            placeholder="MSME Certificate No">
                        @error('msme_certification_no')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="fl">
                        <label>ROC No</label>
                        <input type="text" name="roc_no" maxlength="100"
                            class="@error('roc_no') is-invalid @enderror" value="{{ old('roc_no', $company->roc_no) }}"
                            placeholder="ROC Number">
                        @error('roc_no')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="fl">
                        <label>Partnership Reg. No</label>
                        <input type="text" name="partnership_registration_no" maxlength="100"
                            class="@error('partnership_registration_no') is-invalid @enderror"
                            value="{{ old('partnership_registration_no', $company->partnership_registration_no) }}"
                            placeholder="Registration No">
                        @error('partnership_registration_no')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="fl">
                        <label>CKYC</label>
                        <input type="text" name="ckyc" maxlength="14" class="@error('ckyc') is-invalid @enderror"
                            value="{{ old('ckyc', $company->ckyc) }}" placeholder="CKYC Number">
                        @error('ckyc')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="fl">
                        <label>Gumasta No</label>
                        <input type="text" name="gumasta_no" maxlength="100"
                            class="@error('gumasta_no') is-invalid @enderror"
                            value="{{ old('gumasta_no', $company->gumasta_no) }}" placeholder="Gumasta License No">
                        @error('gumasta_no')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="fl">
                        <label>Watermark No</label>
                        <input type="text" name="watermark_no" maxlength="100"
                            class="@error('watermark_no') is-invalid @enderror"
                            value="{{ old('watermark_no', $company->watermark_no) }}" placeholder="Watermark Number">
                        @error('watermark_no')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="fl">
                        <label>Copyright No</label>
                        <input type="text" name="copyrights_no" maxlength="100"
                            class="@error('copyrights_no') is-invalid @enderror"
                            value="{{ old('copyrights_no', $company->copyrights_no) }}" placeholder="Copyright Number">
                        @error('copyrights_no')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- ── 4. Bank Details ── --}}
        <div class="sc">
            <div class="sc-head">
                <div class="sc-head-icon">🏦</div>
                <div class="sc-head-title">Bank Details</div>
                <span class="sc-head-sub">Bank Information</span>
            </div>
            <div class="sc-body">
                <div id="bankWrapper">
                    @foreach ($company->banks ?? [] as $i => $bank)
                        <div class="bank-row">
                            <div class="bank-row-num">Bank {{ $i + 1 }}</div>
                            @if ($i > 0)
                                <button type="button" class="bank-remove" onclick="this.closest('.bank-row').remove()">✕
                                    Remove</button>
                            @endif
                            <div class="fg fg-4" style="gap:14px;">
                                <div class="fl">
                                    <label>IFSC Code</label>
                                    <input type="text" name="banks[{{ $i }}][ifsc_code]"
                                        class="ifsc_code @error('banks.' . $i . '.ifsc_code') is-invalid @enderror"
                                        value="{{ old('banks.' . $i . '.ifsc_code', $bank->ifsc_code) }}"
                                        placeholder="IFSC Code">
                                    @error('banks.' . $i . '.ifsc_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="fl">
                                    <label>Account No</label>
                                    <input type="text" name="banks[{{ $i }}][account_number]"
                                        class="@error('banks.' . $i . '.account_number') is-invalid @enderror"
                                        value="{{ old('banks.' . $i . '.account_number', $bank->account_number) }}"
                                        placeholder="Account Number" maxlength="15">
                                    @error('banks.' . $i . '.account_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="fl">
                                    <label>Account Type</label>
                                    <select name="banks[{{ $i }}][account_type]"
                                        class="@error('banks.' . $i . '.account_type') is-invalid @enderror">
                                        <option value="">Select type</option>
                                        @foreach (['savings' => 'Saving Account', 'current' => 'Current Account', 'od_cc' => 'Overdraft/CC', 'nre' => 'NRE', 'nri' => 'NRI', 'nro' => 'NRO', 'tem_deposit' => 'Term Deposit', 'ra' => 'Recurring'] as $val => $label)
                                            <option value="{{ $val }}"
                                                {{ old('banks.' . $i . '.account_type', $bank->account_type) == $val ? 'selected' : '' }}>
                                                {{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @error('banks.' . $i . '.account_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="fl">
                                    <label>Bank Name</label>
                                    <input type="text" name="banks[{{ $i }}][bank_name]" class="bank_name"
                                        value="{{ old('banks.' . $i . '.bank_name', $bank->bank_name) }}" readonly>
                                </div>
                                <div class="fl">
                                    <label>Branch Name</label>
                                    <input type="text" name="banks[{{ $i }}][branch_name]"
                                        class="branch_name"
                                        value="{{ old('banks.' . $i . '.branch_name', $bank->branch_name) }}" readonly>
                                </div>
                                <div class="fl">
                                    <label>Bank Code</label>
                                    <input type="text" name="banks[{{ $i }}][bank_code]" class="bank_code"
                                        value="{{ old('banks.' . $i . '.bank_code', $bank->bank_code) }}" readonly>
                                </div>
                                <div class="check-row">
                                    <input type="hidden" name="banks[{{ $i }}][is_primary]" value="0">
                                    <input type="checkbox" id="primary_{{ $i }}"
                                        name="banks[{{ $i }}][is_primary]" value="1" class="setPrimary"
                                        {{ old('banks.' . $i . '.is_primary', $bank->is_primary) == 1 ? 'checked' : '' }}>
                                    <label for="primary_{{ $i }}">Primary Account</label>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button type="button" class="btn-add" onclick="addBankRow()">＋ Add More Bank</button>
            </div>
        </div>

        {{-- ── 5. Documents ── --}}
        <div class="sc">
            <div class="sc-head">
                <div class="sc-head-icon">📂</div>
                <div class="sc-head-title">Documents</div>
                <span class="sc-head-sub">PDF, JPG, PNG · max 5MB</span>
            </div>
            <div class="sc-body">
                @php
                    $docs = [
                        ['name' => 'attachment_pan', 'label' => 'PAN Card', 'icon' => '🪪'],
                        ['name' => 'attachment_tan', 'label' => 'TAN Certificate', 'icon' => '📋'],
                        ['name' => 'attachment_gstin', 'label' => 'GST Certificate', 'icon' => '📄'],
                        ['name' => 'attachment_msme', 'label' => 'MSME Certificate', 'icon' => '🏢'],
                        ['name' => 'attachment_udyam_aadhar', 'label' => 'Udyam Aadhar', 'icon' => '🪪'],
                        ['name' => 'attachment_gumasta', 'label' => 'Gumasta License', 'icon' => '📄'],
                        ['name' => 'attachment_ckyc', 'label' => 'CKYC Document', 'icon' => '📄'],
                        ['name' => 'attachment_cancelled_cheque', 'label' => 'Cancelled Cheque', 'icon' => '🏦'],
                        ['name' => 'attachment_proprietor', 'label' => 'Proprietor Photo', 'icon' => '👤'],
                        ['name' => 'logo', 'label' => 'Company Logo', 'icon' => '🏷️'],
                    ];
                @endphp

                <div class="doc-grid">
                    @foreach ($docs as $doc)
                        @php
                            $existing = $company->{$doc['name']} ?? null;
                            $isImage = $existing && preg_match('/\.(jpg|jpeg|png|webp)$/i', $existing);
                            $isPdf = $existing && preg_match('/\.pdf$/i', $existing);
                            $hasFile = (bool) $existing;
                        @endphp

                        <div class="doc-card {{ $hasFile ? 'uploaded' : '' }}"
                            onclick="document.getElementById('{{ $doc['name'] }}').click()">

                            {{-- existing remove button --}}
                            @if ($hasFile)
                                <button type="button" class="doc-remove-btn"
                                    onclick="event.stopPropagation(); removeDoc('{{ $doc['name'] }}')">✕</button>
                            @endif

                            {{-- image preview --}}
                            @if ($isImage)
                                <img src="{{ asset('storage/' . $existing) }}" class="doc-preview-img"
                                    id="preview_{{ $doc['name'] }}" alt="{{ $doc['label'] }}">
                            @elseif ($isPdf)
                                <div class="doc-card-icon">📄</div>
                                <div class="doc-preview-file" id="preview_{{ $doc['name'] }}">{{ basename($existing) }}
                                </div>
                            @else
                                <div class="doc-card-icon" id="icon_{{ $doc['name'] }}">{{ $doc['icon'] }}</div>
                            @endif

                            <div class="doc-card-label">{{ $doc['label'] }}</div>

                            <div class="doc-status {{ $hasFile ? 'ok' : 'miss' }}" id="status_{{ $doc['name'] }}">
                                <span class="dot"></span>
                                {{ $hasFile ? 'Uploaded' : 'Not Uploaded' }}
                            </div>

                            {{-- file input --}}
                            <input type="file" id="{{ $doc['name'] }}" name="{{ $doc['name'] }}"
                                accept=".pdf,.jpg,.jpeg,.png,.webp" onchange="previewDoc(this, '{{ $doc['name'] }}')">

                            {{-- keep existing if not replaced --}}
                            <input type="hidden" name="{{ $doc['name'] }}_existing" value="{{ $existing }}">

                            @error($doc['name'])
                                <div style="font-size:10.5px;color:#dc2626;margin-top:4px;">{{ $message }}</div>
                            @enderror

                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ── Actions ── --}}
        <div class="form-actions">
            <a href="{{ route('master.companies.index') }}" class="btn-cancel">Cancel</a>
            <button type="submit" class="btn-save">Save Changes</button>
        </div>

    </form>

@endsection

@push('scripts')
    <script>
        // ── Same Address ──
        document.getElementById('sameAddress').addEventListener('change', function() {
            const fields = ['address_line1', 'address_line2', 'city', 'pincode'];
            const selects = ['state', 'country'];
            if (this.checked) {
                fields.forEach(f => document.querySelector(`[name="op_${f}"]`).value = document.querySelector(
                    `[name="reg_${f}"]`).value);
                selects.forEach(s => document.querySelector(`[name="op_${s}"]`).value = document.querySelector(
                    `[name="reg_${s}"]`).value);
            } else {
                fields.forEach(f => document.querySelector(`[name="op_${f}"]`).value = '');
                selects.forEach(s => {
                    const el = document.querySelector(`[name="op_${s}"]`);
                    if (el) el.value = '';
                });
            }
        });

        // ── Doc preview on file select ──
        function previewDoc(input, name) {
            const file = input.files[0];
            if (!file) return;
            const card = input.closest('.doc-card');
            card.classList.add('uploaded');

            const status = document.getElementById('status_' + name);
            status.className = 'doc-status ok';
            status.innerHTML = '<span class="dot"></span> Uploaded';

            // show image or filename
            const isImage = /\.(jpg|jpeg|png|webp)$/i.test(file.name);
            let preview = document.getElementById('preview_' + name);
            const icon = document.getElementById('icon_' + name);

            if (isImage) {
                if (!preview) {
                    preview = document.createElement('img');
                    preview.id = 'preview_' + name;
                    preview.className = 'doc-preview-img';
                    card.insertBefore(preview, card.querySelector('.doc-card-label'));
                    if (icon) icon.remove();
                }
                preview.src = URL.createObjectURL(file);
            } else {
                if (!preview) {
                    preview = document.createElement('div');
                    preview.id = 'preview_' + name;
                    preview.className = 'doc-preview-file';
                    card.insertBefore(preview, card.querySelector('.doc-card-label'));
                    if (icon) icon.remove();
                }
                preview.textContent = file.name;
            }
        }

        // ── Remove doc ──
        function removeDoc(name) {
            const input = document.getElementById(name);
            input.value = '';
            const card = input.closest('.doc-card');
            card.classList.remove('uploaded');

            const status = document.getElementById('status_' + name);
            status.className = 'doc-status miss';
            status.innerHTML = '<span class="dot"></span> Not Uploaded';

            const preview = document.getElementById('preview_' + name);
            if (preview) preview.remove();

            card.querySelector('input[name$="_existing"]').value = '';

            // restore icon
            const label = card.querySelector('.doc-card-label');
            const rmBtn = card.querySelector('.doc-remove-btn');
            if (rmBtn) rmBtn.remove();
        }

        // ── Add bank row ──
        let bankIndex = {{ count($company->banks ?? []) }};

        function addBankRow() {
            const i = bankIndex++;
            const accountTypes = {
                savings: 'Saving Account',
                current: 'Current Account',
                od_cc: 'Overdraft/CC',
                nre: 'NRE',
                nri: 'NRI',
                nro: 'NRO',
                tem_deposit: 'Term Deposit',
                ra: 'Recurring'
            };
            let opts = Object.entries(accountTypes).map(([v, l]) => `<option value="${v}">${l}</option>`).join('');

            const html = `
        <div class="bank-row">
            <div class="bank-row-num">Bank ${i + 1}</div>
            <button type="button" class="bank-remove" onclick="this.closest('.bank-row').remove()">✕ Remove</button>
            <div class="fg fg-4" style="gap:14px;">
                <div class="fl"><label>IFSC Code</label><input type="text" name="banks[${i}][ifsc_code]" class="ifsc_code" placeholder="IFSC Code"></div>
                <div class="fl"><label>Account No</label><input type="text" name="banks[${i}][account_number]" maxlength="15" placeholder="Account Number"></div>
                <div class="fl"><label>Account Type</label><select name="banks[${i}][account_type]"><option value="">Select type</option>${opts}</select></div>
                <div class="fl"><label>Bank Name</label><input type="text" name="banks[${i}][bank_name]" class="bank_name" readonly></div>
                <div class="fl"><label>Branch Name</label><input type="text" name="banks[${i}][branch_name]" class="branch_name" readonly></div>
                <div class="fl"><label>Bank Code</label><input type="text" name="banks[${i}][bank_code]" class="bank_code" readonly></div>
                <div class="check-row">
                    <input type="hidden" name="banks[${i}][is_primary]" value="0">
                    <input type="checkbox" id="primary_${i}" name="banks[${i}][is_primary]" value="1" class="setPrimary">
                    <label for="primary_${i}">Primary Account</label>
                </div>
            </div>
        </div>`;

            document.getElementById('bankWrapper').insertAdjacentHTML('beforeend', html);
        }
    </script>
@endpush
