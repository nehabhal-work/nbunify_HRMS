{{-- resources/views/master/branches/edit.blade.php --}}
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
        <a href="{{ route('master.branches.index') }}">Branches</a> /
        <span class="text-muted fw-light">Edit</span>
    </h4>

    <form action="{{ route('master.branches.update', $branch->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row align-items-stretch">

            {{-- Basic Information --}}
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Basic Information</h5>
                        <small class="text-muted">Branch Primary Details</small>
                    </div>
                    <div class="card-body">
                        <div class="row g-3 mt-2">

                            <div class="col-md-4 mb-3">
                                <label>Company <span class="text-danger">*</span></label>
                                <select name="company_id" id="company_id"
                                    class="form-select @error('company_id') is-invalid @enderror"
                                    onchange="loadHeadOffices(this.value)">
                                    <option value="">Select Company</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}"
                                            {{ old('company_id', $branch->company_id) == $company->id ? 'selected' : '' }}>
                                            {{ $company->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('company_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label>Head Office <span class="text-danger">*</span></label>
                                <select name="head_office_id" id="head_office_id"
                                    class="form-select @error('head_office_id') is-invalid @enderror">
                                    <option value="">Select Head Office</option>
                                    @foreach ($headOffices as $ho)
                                        <option value="{{ $ho->id }}"
                                            {{ old('head_office_id', $branch->head_office_id) == $ho->id ? 'selected' : '' }}>
                                            {{ $ho->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('head_office_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label>Branch Name <span class="text-danger">*</span></label>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $branch->name) }}" placeholder="Enter branch name">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label>Branch Code <span class="text-danger">*</span></label>
                                <input type="text" name="code"
                                    class="form-control @error('code') is-invalid @enderror"
                                    value="{{ old('code', $branch->code) }}" placeholder="e.g. BR-MUM-01">
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label>Branch Type</label>
                                <select name="branch_type"
                                    class="form-select @error('branch_type') is-invalid @enderror">
                                    <option value="">Select type</option>
                                    <option value="sales"     {{ old('branch_type', $branch->branch_type) == 'sales'     ? 'selected' : '' }}>Sales</option>
                                    <option value="service"   {{ old('branch_type', $branch->branch_type) == 'service'   ? 'selected' : '' }}>Service</option>
                                    <option value="warehouse" {{ old('branch_type', $branch->branch_type) == 'warehouse' ? 'selected' : '' }}>Warehouse</option>
                                    <option value="regional"  {{ old('branch_type', $branch->branch_type) == 'regional'  ? 'selected' : '' }}>Regional</option>
                                    <option value="zonal"     {{ old('branch_type', $branch->branch_type) == 'zonal'     ? 'selected' : '' }}>Zonal</option>
                                    <option value="franchise" {{ old('branch_type', $branch->branch_type) == 'franchise' ? 'selected' : '' }}>Franchise</option>
                                </select>
                                @error('branch_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label>Status</label>
                                <select name="status"
                                    class="form-select @error('status') is-invalid @enderror">
                                    <option value="active"             {{ old('status', $branch->status) == 'active'             ? 'selected' : '' }}>Active</option>
                                    <option value="inactive"           {{ old('status', $branch->status) == 'inactive'           ? 'selected' : '' }}>Inactive</option>
                                    <option value="temporarily_closed" {{ old('status', $branch->status) == 'temporarily_closed' ? 'selected' : '' }}>Temporarily Closed</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label>Email</label>
                                <input type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', $branch->email) }}" placeholder="branch@example.com">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label>Phone</label>
                                <input type="text" name="phone"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    value="{{ old('phone', $branch->phone) }}" placeholder="+91 9876543210">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label>Employee Count</label>
                                <input type="number" name="employee_count" min="0"
                                    class="form-control @error('employee_count') is-invalid @enderror"
                                    value="{{ old('employee_count', $branch->employee_count) }}" placeholder="0">
                                @error('employee_count')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label>Opening Hours</label>
                                <input type="text" name="opening_hours"
                                    class="form-control @error('opening_hours') is-invalid @enderror"
                                    value="{{ old('opening_hours', $branch->opening_hours) }}" placeholder="Mon–Sat 9am–6pm">
                                @error('opening_hours')
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
                        <small class="text-muted">Branch Manager Info</small>
                    </div>
                    <div class="card-body">
                        <div class="row g-3 mt-2">

                            <div class="col-md-4 mb-3">
                                <label>Manager Name</label>
                                <input type="text" name="manager_name"
                                    class="form-control @error('manager_name') is-invalid @enderror"
                                    value="{{ old('manager_name', $branch->manager_name) }}" placeholder="Full name">
                                @error('manager_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label>Manager Email</label>
                                <input type="email" name="manager_email"
                                    class="form-control @error('manager_email') is-invalid @enderror"
                                    value="{{ old('manager_email', $branch->manager_email) }}" placeholder="manager@example.com">
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
                        <small class="text-muted">Branch Location</small>
                    </div>
                    <div class="card-body">
                        <div class="row g-3 mt-2">

                            <div class="col-md-6 mb-3">
                                <label>Address Line 1 <span class="text-danger">*</span></label>
                                <input type="text" name="address_line_1"
                                    class="form-control @error('address_line_1') is-invalid @enderror"
                                    value="{{ old('address_line_1', $branch->address_line_1) }}" placeholder="Building No., Street, Area">
                                @error('address_line_1')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Address Line 2</label>
                                <input type="text" name="address_line_2"
                                    class="form-control @error('address_line_2') is-invalid @enderror"
                                    value="{{ old('address_line_2', $branch->address_line_2) }}" placeholder="Floor, Suite, Landmark">
                                @error('address_line_2')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label>City <span class="text-danger">*</span></label>
                                <input type="text" name="city"
                                    class="form-control @error('city') is-invalid @enderror"
                                    value="{{ old('city', $branch->city) }}" placeholder="City">
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label>State <span class="text-danger">*</span></label>
                                <select name="state"
                                    class="form-select @error('state') is-invalid @enderror">
                                    <option value="">Select state...</option>
                                    <option value="Maharashtra" {{ old('state', $branch->state) == 'Maharashtra' ? 'selected' : '' }}>Maharashtra</option>
                                    <option value="Gujarat"     {{ old('state', $branch->state) == 'Gujarat'     ? 'selected' : '' }}>Gujarat</option>
                                    <option value="Delhi"       {{ old('state', $branch->state) == 'Delhi'       ? 'selected' : '' }}>Delhi</option>
                                    <option value="Karnataka"   {{ old('state', $branch->state) == 'Karnataka'   ? 'selected' : '' }}>Karnataka</option>
                                    <option value="Tamil Nadu"  {{ old('state', $branch->state) == 'Tamil Nadu'  ? 'selected' : '' }}>Tamil Nadu</option>
                                </select>
                                @error('state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label>Country <span class="text-danger">*</span></label>
                                <select name="country"
                                    class="form-select @error('country') is-invalid @enderror">
                                    <option value="India" {{ old('country', $branch->country) == 'India' ? 'selected' : '' }}>India</option>
                                </select>
                                @error('country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label>Postal Code</label>
                                <input type="text" name="postal_code"
                                    class="form-control @error('postal_code') is-invalid @enderror"
                                    value="{{ old('postal_code', $branch->postal_code) }}" placeholder="400001">
                                @error('postal_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="text-end mt-3">
            <button type="submit" class="btn btn-primary px-4">Update</button>
            <a href="{{ route('master.branches.index') }}" class="btn btn-secondary px-4">Cancel</a>
        </div>
    </form>
@endsection

@push('scripts')
<script>
    function loadHeadOffices(companyId) {
        const select = document.getElementById('head_office_id');
        const currentVal = select.value;
        select.innerHTML = '<option value="">Loading...</option>';

        if (!companyId) {
            select.innerHTML = '<option value="">Select Head Office</option>';
            return;
        }

        fetch(`/api/companies/${companyId}/head-offices`)
            .then(res => res.json())
            .then(data => {
                select.innerHTML = '<option value="">Select Head Office</option>';
                data.forEach(ho => {
                    const selected = ho.id == currentVal ? 'selected' : '';
                    select.innerHTML += `<option value="${ho.id}" ${selected}>${ho.name}</option>`;
                });
            })
            .catch(() => {
                select.innerHTML = '<option value="">Select Head Office</option>';
            });
    }
</script>
@endpush