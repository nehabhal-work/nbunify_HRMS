@extends('layouts.master-layout')

@section('content')

<style>
    .view-mode { display: block; }
    .edit-mode { display: none; }

    .view-box {
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 9px 12px;
        font-weight: 500;
        color: #111827;
    }

    .view-box.small { font-size: 13px; }

    .doc-card { display: none; } /* hidden in view mode */
</style>

<div class="text-end mb-3">
    <button type="button" id="editBtn" class="btn btn-outline-primary">✏️ Edit</button>
    <button type="submit" form="companyForm" id="updateBtn" class="btn btn-success d-none">💾 Update</button>
</div>

<form id="companyForm" action="{{ route('master.companies.update', $company->id) }}" method="POST" enctype="multipart/form-data">
@csrf
@method('PUT')

<div class="card mb-4">
    <div class="card-header">Basic Information</div>
    <div class="card-body row g-3">

        {{-- Company Name --}}
        <div class="col-md-4">
            <label>Company Name</label>

            <div class="view-mode">
                <div class="view-box">{{ $company->name }}</div>
            </div>

            <input type="text" name="name" class="form-control edit-mode"
                value="{{ old('name', $company->name) }}">
        </div>

        {{-- Legal Name --}}
        <div class="col-md-4">
            <label>Legal Name</label>

            <div class="view-mode">
                <div class="view-box">{{ $company->legal_name ?? '-' }}</div>
            </div>

            <input type="text" name="legal_name" class="form-control edit-mode"
                value="{{ old('legal_name', $company->legal_name) }}">
        </div>

        {{-- Email --}}
        <div class="col-md-4">
            <label>Email</label>

            <div class="view-mode">
                <div class="view-box">{{ $company->email ?? '-' }}</div>
            </div>

            <input type="email" name="email" class="form-control edit-mode"
                value="{{ old('email', $company->email) }}">
        </div>

        {{-- Status --}}
        <div class="col-md-4">
            <label>Status</label>

            <div class="view-mode">
                <div class="view-box">{{ ucfirst($company->status) }}</div>
            </div>

            <select name="status" class="form-select edit-mode">
                <option value="active" {{ $company->status=='active'?'selected':'' }}>Active</option>
                <option value="inactive" {{ $company->status=='inactive'?'selected':'' }}>Inactive</option>
            </select>
        </div>

    </div>
</div>

{{-- ADDRESS --}}
<div class="card mb-4">
    <div class="card-header">Address</div>
    <div class="card-body">

        <label>Registered Address</label>

        <div class="view-mode">
            <div class="view-box small">
                {{ $company->reg_address_line1 }},
                {{ $company->reg_city }},
                {{ $company->reg_state }} - {{ $company->reg_pincode }}
            </div>
        </div>

        <div class="edit-mode">
            <input type="text" name="reg_address_line1" class="form-control mb-2"
                value="{{ $company->reg_address_line1 }}">
            <input type="text" name="reg_city" class="form-control mb-2"
                value="{{ $company->reg_city }}">
            <input type="text" name="reg_pincode" class="form-control"
                value="{{ $company->reg_pincode }}">
        </div>

    </div>
</div>

{{-- BANK --}}
<div class="card mb-4">
    <div class="card-header">Bank Details</div>
    <div class="card-body">

        @foreach ($bankDetails as $i => $bank)

            <div class="mb-3">

                {{-- VIEW --}}
                <div class="view-mode">
                    <div class="view-box small">
                        IFSC: {{ $bank->ifsc_code }} |
                        Acc: {{ $bank->account_number }} |
                        Bank: {{ $bank->bank_name }} |
                        Primary: {{ $bank->is_primary ? 'Yes' : 'No' }}
                    </div>
                </div>

                {{-- EDIT --}}
                <div class="edit-mode">
                    <input type="text" name="banks[{{ $i }}][ifsc_code]" class="form-control mb-2"
                        value="{{ $bank->ifsc_code }}">

                    <input type="text" name="banks[{{ $i }}][account_number]" class="form-control mb-2"
                        value="{{ $bank->account_number }}">

                    <input type="text" name="banks[{{ $i }}][bank_name]" class="form-control mb-2"
                        value="{{ $bank->bank_name }}">

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

{{-- DOCUMENTS --}}
<div class="card mb-4">
    <div class="card-header">Documents</div>
    <div class="card-body">

        @php
            $docs = [
                ['name'=>'attachment_pan','label'=>'PAN'],
                ['name'=>'attachment_gstin','label'=>'GST'],
                ['name'=>'logo','label'=>'Logo']
            ];
        @endphp

        @foreach($docs as $doc)

            <div class="mb-3">

                {{-- VIEW --}}
                <div class="view-mode">
                    <div class="view-box small">
                        {{ $doc['label'] }} :
                        @if($company->{$doc['name']})
                            <span class="text-success">Uploaded</span>
                        @else
                            <span class="text-danger">Not Uploaded</span>
                        @endif
                    </div>
                </div>

                {{-- EDIT --}}
                <input type="file" name="{{ $doc['name'] }}" class="form-control edit-mode">

            </div>

        @endforeach

    </div>
</div>

</form>

@endsection

@push('scripts')
<script>
document.getElementById('editBtn').addEventListener('click', function () {

    document.querySelectorAll('.view-mode').forEach(el => el.style.display = 'none');
    document.querySelectorAll('.edit-mode').forEach(el => el.style.display = 'block');

    document.querySelectorAll('.doc-card').forEach(el => el.style.display = 'block');

    this.classList.add('d-none');
    document.getElementById('updateBtn').classList.remove('d-none');
});
</script>
@endpush