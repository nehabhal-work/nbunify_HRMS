{{-- resources/views/master/branches/index.blade.php --}}
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

    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Master /</span> Branches
    </h4>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">All Branches</h5>
            <a href="{{ route('master.branches.create') }}" class="btn btn-primary btn-sm">
                <i class="bx bx-plus"></i> Add Branch
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Company</th>
                            <th>Head Office</th>
                            <th>Branch Name</th>
                            <th>Code</th>
                            <th>Type</th>
                            <th>Email</th>
                            <th>City</th>
                            <th>Employees</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($branches as $branch)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $branch->company->name ?? '—' }}</td>
                                <td>{{ $branch->headOffice->name ?? '—' }}</td>
                                <td>{{ $branch->name }}</td>
                                <td><span class="badge bg-secondary">{{ $branch->code }}</span></td>
                                <td>{{ ucfirst($branch->branch_type ?? '—') }}</td>
                                <td>{{ $branch->email ?? '—' }}</td>
                                <td>{{ $branch->city ?? '—' }}</td>
                                <td>{{ $branch->employee_count ?? '—' }}</td>
                                <td>
                                    @php
                                        $statusMap = [
                                            'active'      => 'success',
                                            'inactive'    => 'danger',
                                            'temporarily_closed' => 'warning',
                                        ];
                                        $color = $statusMap[$branch->status] ?? 'secondary';
                                    @endphp
                                    <span class="badge bg-{{ $color }}">
                                        {{ ucwords(str_replace('_', ' ', $branch->status ?? 'Unknown')) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('master.branches.edit', $branch->id) }}"
                                        class="btn btn-sm btn-warning">
                                        <i class="bx bx-edit"></i>
                                    </a>
                                    <form action="{{ route('master.branches.destroy', $branch->id) }}"
                                        method="POST" class="d-inline"
                                        onsubmit="return confirm('Delete this branch?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center text-muted py-4">No branches found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $branches->links() }}
            </div>
        </div>
    </div>
@endsection