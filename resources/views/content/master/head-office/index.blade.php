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
        <span class="text-muted fw-light">Master /</span> Head Offices
    </h4>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">All Head Offices</h5>
            <a href="{{ route('master.head-offices.create') }}" class="btn btn-primary btn-sm">
                <i class="bx bx-plus"></i> Add Head Office
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Company</th>
                            <th>Name</th>
                            <th>Code</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>City</th>
                            <th>State</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($headOffices as $ho)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $ho->company->name ?? '—' }}</td>
                                <td>{{ $ho->name }}</td>
                                <td><span class="badge bg-secondary">{{ $ho->code }}</span></td>
                                <td>{{ $ho->email }}</td>
                                <td>{{ $ho->phone ?? '—' }}</td>
                                <td>{{ $ho->city }}</td>
                                <td>{{ $ho->state }}</td>
                                <td>
                                    @if ($ho->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('master.head-offices.edit', $ho->id) }}"
                                        class="btn btn-sm btn-warning">
                                        <i class="bx bx-edit"></i>
                                    </a>
                                    <form action="{{ route('master.head-offices.destroy', $ho->id) }}"
                                        method="POST" class="d-inline"
                                        onsubmit="return confirm('Delete this head office?')">
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
                                <td colspan="10" class="text-center text-muted py-4">No head offices found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $headOffices->links() }}
            </div>
        </div>
    </div>
@endsection