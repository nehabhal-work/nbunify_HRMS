@extends('layouts.master-layout')

@section('content')
<style>
    .table td, .table th {
    vertical-align: middle;
}

.badge {
    font-weight: 500;
    border-radius: 8px;
}

.card {
    border-radius: 16px;
}

input::placeholder {
    color: #aaa;
}
</style>
    <div class="container-fluid">

        <!-- 🌤 HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-4">
           
             <h4 class="fw-bold py-3 ">
            <span class="text-muted fw-light">Master /</span> Companies
        </h4>

            <div class="d-flex gap-2">


                <button class="btn btn-light border">
                    <i class="bx bx-export"></i> Export
                </button>

                <a href="{{ route('master.companies.create') }}" class="btn btn-primary">
                    <i class="bx bx-plus"></i> New Company
                </a>
            </div>
        </div>

        <!-- 🌊 CARD -->
        <div class="card border-0 shadow-sm rounded-4">

            <!-- 🔍 FILTER BAR -->
            <div class="card-body border-bottom d-flex flex-wrap gap-3 align-items-center">

                <div class="flex-grow-1">
                    <input type="text" class="form-control" placeholder="🔍 Search companies...">
                </div>

                <select class="form-select w-auto">
                    <option>All Status</option>
                    <option>Active</option>
                    <option>Inactive</option>
                </select>



                <div class="ms-auto text-muted">
                    {{ $companies->count() ?? 0 }} companies
                </div>
            </div>

            <!-- 📊 TABLE -->
            <div class="table-responsive">
                <table class="table align-middle mb-0">

                    <thead class="table-light">
                        <tr>
                            <th>Company</th>
                            <th>Reg. No.</th>
                            <th>Industry</th>
                            <th>Country</th>
                            <th>Head Office</th>
                            <th>Branches</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($companies as $company)
                            <tr>

                                <!-- 🏢 COMPANY -->
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="rounded-circle bg-light text-center"
                                            style="width:40px;height:40px;line-height:40px;">
                                            {{ strtoupper(substr($company->name, 0, 1)) }}
                                        </div>

                                        <div>
                                            <div class="fw-semibold">{{ $company->name }}</div>
                                            <small class="text-muted">{{ $company->industry ?? '—' }}</small>
                                        </div>
                                    </div>
                                </td>

                                <!-- 📄 REG -->
                                <td>
                                    <span class="badge bg-light text-dark border">
                                        {{ $company->cin_no ?? 'N/A' }}
                                    </span>
                                </td>

                                <!-- 🏷 INDUSTRY -->
                                <td>
                                    <span class="badge bg-light border">
                                        {{ $company->industry ?? '—' }}
                                    </span>
                                </td>

                                <!-- 🌍 COUNTRY -->
                                <td>{{ $company->country ?? 'India' }}</td>

                                <!-- 🏢 HEAD OFFICE -->
                                <td>{{ $company->head_office ?? '—' }}</td>

                                <!-- 🔢 BRANCH -->
                                <td>{{ $company->branches_count ?? 0 }}</td>

                                <!-- 🟢 STATUS -->
                                <td>
                                    @if ($company->status == 1)
                                        <span class="badge bg-success-subtle text-success px-3 py-2">
                                            ● Active
                                        </span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger px-3 py-2">
                                            ● Inactive
                                        </span>
                                    @endif
                                </td>

                                <!-- ⚙ ACTION -->
                                <td class="text-end">
                                    <a href="{{ route('master.companies.edit', $company->id) }}"
                                        class="btn btn-sm btn-light border">
                                        ✏
                                    </a>

                                    <form action="{{ route('master.companies.destroy', $company->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-sm btn-light border text-danger">
                                            🗑
                                        </button>
                                    </form>
                                </td>

                            </tr>

                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">
                                    No companies found 🌙
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>
            </div>

        </div>
    </div>
@endsection
