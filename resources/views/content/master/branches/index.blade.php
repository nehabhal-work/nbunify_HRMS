@extends('layouts.master-layout')

@section('content')

<div class="container-fluid">

    <!-- 🌤 HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold py-3">
            <span class="text-muted fw-light">Master /</span> Branches
        </h4>

        <div class="d-flex gap-2">
            <button class="btn btn-light border">
                <i class="bx bx-export"></i> Export
            </button>

            <a href="{{ route('master.branches.create') }}" class="btn btn-primary">
                <i class="bx bx-plus"></i> New Branch
            </a>
        </div>
    </div>

    <!-- 🌊 CARD -->
    <div class="card border-0 shadow-sm rounded-4">

        <!-- 🔍 FILTER BAR -->
        <div class="card-body border-bottom d-flex flex-wrap gap-3 align-items-center">

            <div class="flex-grow-1">
                <input type="text" name="search" value="{{ request('search') }}"
                    class="form-control" placeholder="🔍 Search branches...">
            </div>

            <div class="ms-auto text-muted">
                {{ $branches->total() ?? 0 }} branches
            </div>
        </div>

        <!-- 📊 TABLE -->
        <div class="table-responsive">
            <table class="table align-middle mb-0">

                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Branch</th>
                        <th>Company</th>
                        <th>Head Office</th>
                        <th>Code</th>
                        <th>Location</th>
                        <th>Employees</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($branches as $branch)
                        <tr>

                            <!-- 🔢 INDEX -->
                            <td>{{ $branches->firstItem() + $loop->index }}</td>

                            <!-- 🏢 BRANCH -->
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle bg-light text-center"
                                        style="width:40px;height:40px;line-height:40px;">
                                        {{ strtoupper(substr($branch->name, 0, 1)) }}
                                    </div>

                                    <div>
                                        <div class="fw-semibold">{{ $branch->name }}</div>
                                        <small class="text-muted">{{ $branch->email ?? '—' }}</small>
                                    </div>
                                </div>
                            </td>

                            <!-- 🏢 COMPANY -->
                            <td>{{ $branch->company->name ?? '—' }}</td>

                            <!-- 🏢 HEAD OFFICE -->
                            <td>{{ $branch->headOffice->name ?? '—' }}</td>

                            <!-- 🏷 CODE -->
                            <td>
                                <span class="badge bg-light text-dark border">
                                    {{ $branch->code }}
                                </span>
                            </td>

                            <!-- 📍 LOCATION -->
                            <td>
                                <div>{{ $branch->city ?? '—' }}</div>
                                <small class="text-muted">{{ ucfirst($branch->branch_type ?? '') }}</small>
                            </td>

                            <!-- 👥 EMPLOYEE COUNT -->
                            <td>{{ $branch->employee_count ?? 0 }}</td>

                            <!-- ✅ STATUS -->
                            <td>
                                @php
                                    $statusMap = [
                                        'active' => 'success',
                                        'inactive' => 'danger',
                                        'temporarily_closed' => 'warning',
                                    ];
                                    $color = $statusMap[$branch->status] ?? 'secondary';
                                @endphp

                                <span class="badge bg-{{ $color }}">
                                    {{ ucwords(str_replace('_', ' ', $branch->status ?? 'Unknown')) }}
                                </span>
                            </td>

                            <!-- ⚙ ACTION -->
                            <td class="text-end">
                                <a href="{{ route('master.branches.edit', $branch->id) }}"
                                    class="btn btn-sm btn-light border">
                                    <i class="bx bx-edit-alt me-1"></i>
                                </a>

                                <form action="{{ route('master.branches.destroy', $branch->id) }}"
                                    method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        onclick="return confirm('Delete this branch?')"
                                        class="btn btn-sm btn-outline-danger">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </form>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">
                                No branches found 🌙
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        <!-- 📄 PAGINATION -->
        <div class="p-3">
            {{ $branches->links() }}
        </div>

    </div>
</div>

@endsection