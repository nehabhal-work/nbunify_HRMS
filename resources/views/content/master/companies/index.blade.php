@extends('layouts.master-layout')

@section('content')
    <style>
        .table td,
        .table th {
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





                <div class="ms-auto text-muted">
                    {{ $companies->count() ?? 0 }} companies
                </div>
            </div>

            <!-- 📊 TABLE -->
            <div class="table-responsive">
                <table class="table align-middle mb-0">

                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Company</th>
                            <th>CIN No.</th>
                            <th>Company Type</th>
                            <th>Country</th>
                            <th>Head Office</th>
                            <th>Branches</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($companies as $company)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <!-- 🏢 COMPANY -->
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                      

                                        <div>
                                            <div class="fw-semibold">{{ $company->name }}</div>
                                            <small class="text-muted">{{ $company->legal_name ?? '—' }}</small>
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
                                        {{ $company->company_type ?? '—' }}
                                    </span>
                                </td>

                                <!-- 🌍 COUNTRY -->
                                <td>{{ $company->country ?? 'India' }}</td>

                                <!-- 🏢 HEAD OFFICE -->
                                <td>{{ $company->head_office ?? '—' }}</td>

                                <!-- 🔢 BRANCH -->
                                <td>{{ $company->branches_count ?? 0 }}</td>



                                <!-- ⚙ ACTION -->
                                <td class="text-end">
                                    <a href="{{ route('master.companies.edit', $company->id) }}"
                                        class="btn btn-sm btn-light border">
                                        <i class="bx bx-edit-alt me-1"></i>
                                    </a>

                                    <form action="{{ route('master.companies.destroy', $company->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')

                                      
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bx bx-trash"></i>
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
