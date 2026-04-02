@extends('layouts.master-layout')

@section('content')

<style>
    .view-mode {
        display: inline-block;
        padding: 8px 0;
        font-size: 15px;
        color: #1f2937;
    }

    .edit-mode {
        display: none;
        border-radius: 8px;
    }

    .label-col {
        color: #6b7280;
        font-weight: 600;
    }

    .card {
        border-radius: 14px;
    }
</style>

<form action="{{ route('master.companies.update', $company->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    {{-- 🔹 BASIC INFORMATION --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header fw-semibold bg-light">Basic Information</div>
        <div class="card-body">

            {{-- Company Name --}}
            <div class="row mb-3">
                <div class="col-md-3 label-col">Company Name</div>
                <div class="col-md-9">
                    <span class="view-mode">{{ $company->name }}</span>
                    <input type="text" name="name" class="form-control edit-mode"
                        value="{{ old('name', $company->name) }}">
                </div>
            </div>

            {{-- Legal Name --}}
            <div class="row mb-3">
                <div class="col-md-3 label-col">Legal Name</div>
                <div class="col-md-9">
                    <span class="view-mode">{{ $company->legal_name ?? '-' }}</span>
                    <input type="text" name="legal_name" class="form-control edit-mode"
                        value="{{ old('legal_name', $company->legal_name) }}">
                </div>
            </div>

            {{-- Email --}}
            <div class="row mb-3">
                <div class="col-md-3 label-col">Email</div>
                <div class="col-md-9">
                    <span class="view-mode">{{ $company->email ?? '-' }}</span>
                    <input type="email" name="email" class="form-control edit-mode"
                        value="{{ old('email', $company->email) }}">
                </div>
            </div>

            {{-- Status --}}
            <div class="row mb-3">
                <div class="col-md-3 label-col">Status</div>
                <div class="col-md-9">
                    <span class="view-mode text-capitalize">{{ $company->status }}</span>

                    <select name="status" class="form-select edit-mode">
                        <option value="active" {{ $company->status=='active'?'selected':'' }}>Active</option>
                        <option value="inactive" {{ $company->status=='inactive'?'selected':'' }}>Inactive</option>
                    </select>
                </div>
            </div>

        </div>
    </div>

    {{-- 🔹 ADDRESS --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header fw-semibold bg-light">Address Details</div>
        <div class="card-body">

            <div class="row mb-3">
                <div class="col-md-3 label-col">Registered Address</div>
                <div class="col-md-9">
                    <span class="view-mode">
                        {{ $company->reg_address_line1 }},
                        {{ $company->reg_city }},
                        {{ $company->reg_state }} - {{ $company->reg_pincode }}
                    </span>

                    <input type="text" name="reg_address_line1" class="form-control edit-mode mb-2"
                        value="{{ $company->reg_address_line1 }}">
                    <input type="text" name="reg_city" class="form-control edit-mode mb-2"
                        value="{{ $company->reg_city }}">
                    <input type="text" name="reg_pincode" class="form-control edit-mode"
                        value="{{ $company->reg_pincode }}">
                </div>
            </div>

        </div>
    </div>

    {{-- 🔹 REGISTRATION --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header fw-semibold bg-light">Registration Details</div>
        <div class="card-body">

            <div class="row mb-3">
                <div class="col-md-3 label-col">PAN No</div>
                <div class="col-md-9">
                    <span class="view-mode">{{ $company->pan_no ?? '-' }}</span>
                    <input type="text" name="pan_no" class="form-control edit-mode"
                        value="{{ $company->pan_no }}">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3 label-col">GSTIN</div>
                <div class="col-md-9">
                    <span class="view-mode">{{ $company->gstin ?? '-' }}</span>
                    <input type="text" name="gstin" class="form-control edit-mode"
                        value="{{ $company->gstin }}">
                </div>
            </div>

        </div>
    </div>

    {{-- 🔹 BANK DETAILS --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header fw-semibold bg-light">Bank Details</div>
        <div class="card-body">

            @foreach ($bankDetails as $i => $bank)
                <div class="border rounded p-3 mb-3">

                    <div class="view-mode">
                        <strong>IFSC:</strong> {{ $bank->ifsc_code }} <br>
                        <strong>Account:</strong> {{ $bank->account_number }} <br>
                        <strong>Bank:</strong> {{ $bank->bank_name }} <br>
                        <strong>Primary:</strong> {{ $bank->is_primary ? 'Yes' : 'No' }}
                    </div>

                    <div class="edit-mode">
                        <input type="text" name="banks[{{ $i }}][ifsc_code]"
                            class="form-control mb-2" value="{{ $bank->ifsc_code }}">

                        <input type="text" name="banks[{{ $i }}][account_number]"
                            class="form-control mb-2" value="{{ $bank->account_number }}">

                        <input type="text" name="banks[{{ $i }}][bank_name]"
                            class="form-control mb-2" value="{{ $bank->bank_name }}">

                        <label>
                            <input type="checkbox" name="banks[{{ $i }}][is_primary]" value="1"
                                {{ $bank->is_primary ? 'checked' : '' }}>
                            Primary
                        </label>
                    </div>

                </div>
            @endforeach

        </div>
    </div>

    {{-- 🔹 DOCUMENTS --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header fw-semibold bg-light">Documents</div>
        <div class="card-body">

            @php
                $docs = [
                    ['name'=>'attachment_pan','label'=>'PAN Card'],
                    ['name'=>'attachment_gstin','label'=>'GST Certificate'],
                    ['name'=>'logo','label'=>'Company Logo']
                ];
            @endphp

            @foreach($docs as $doc)
                <div class="row mb-3">
                    <div class="col-md-3 label-col">{{ $doc['label'] }}</div>

                    <div class="col-md-9">

                        {{-- VIEW --}}
                        <span class="view-mode">
                            @if($company->{$doc['name']})
                                <span class="text-success">✅ Uploaded</span>
                            @else
                                <span class="text-danger">❌ Not Uploaded</span>
                            @endif
                        </span>

                        {{-- EDIT --}}
                        <input type="file" name="{{ $doc['name'] }}" class="form-control edit-mode">

                    </div>
                </div>
            @endforeach

        </div>
    </div>

    {{-- 🔘 BUTTONS --}}
    <div class="text-end">
        <button type="button" id="editBtn" class="btn btn-outline-primary">✏️ Edit</button>
        <button type="submit" id="saveBtn" class="btn btn-success d-none">💾 Update</button>
        <a href="{{ route('master.companies.index') }}" class="btn btn-secondary">Cancel</a>
    </div>

</form>

@endsection


@push('scripts')
<script>
    document.getElementById('editBtn').addEventListener('click', function () {

        document.querySelectorAll('.view-mode').forEach(el => el.style.display = 'none');
        document.querySelectorAll('.edit-mode').forEach(el => el.style.display = 'block');

        document.getElementById('editBtn').classList.add('d-none');
        document.getElementById('saveBtn').classList.remove('d-none');
    });
</script>
@endpush    