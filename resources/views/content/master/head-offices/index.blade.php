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

   <div class="container-fluid">

    <!-- 🌤 HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold py-3">
            <span class="text-muted fw-light">Master /</span> Head Offices
        </h4>

        <div class="d-flex gap-2">
            <button class="btn btn-light border">
                <i class="bx bx-export"></i> Export
            </button>

            <a href="{{ route('master.head-offices.create') }}" class="btn btn-primary">
                <i class="bx bx-plus"></i> New Head Office
            </a>
        </div>
    </div>

    <!-- 🌊 CARD -->
    <div class="card border-0 shadow-sm rounded-4">

        <!-- 🔍 FILTER -->
        <div class="card-body border-bottom d-flex flex-wrap gap-3 align-items-center">
            <div class="flex-grow-1">
                <input type="text" name="search" value="{{ request('search') }}"
                    class="form-control" placeholder="🔍 Search head offices...">
            </div>

            <div class="ms-auto text-muted">
                {{ $headOffices->total() ?? 0 }} head offices
            </div>
        </div>

        <!-- 📊 TABLE -->
        <div class="table-responsive">
            <table class="table align-middle mb-0">

                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Head Office</th>
                        <th>Company</th>
                        <th>Code</th>
                        <th>Contact</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($headOffices as $ho)
                        <tr>

                            <!-- 🔢 INDEX -->
                            <td>{{ $headOffices->firstItem() + $loop->index }}</td>

                            <!-- 🏢 HEAD OFFICE -->
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle bg-light text-center"
                                        style="width:40px;height:40px;line-height:40px;">
                                        {{ strtoupper(substr($ho->name, 0, 1)) }}
                                    </div>

                                    <div>
                                        <div class="fw-semibold">{{ $ho->name }}</div>
                                        <small class="text-muted">{{ $ho->email ?? '—' }}</small>
                                    </div>
                                </div>
                            </td>

                            <!-- 🏢 COMPANY -->
                            <td>{{ $ho->company->name ?? '—' }}</td>

                            <!-- 🏷 CODE -->
                            <td>
                                <span class="badge bg-light text-dark border">
                                    {{ $ho->code }}
                                </span>
                            </td>

                            <!-- 📞 CONTACT -->
                            <td>
                                <div>{{ $ho->phone ?? '—' }}</div>
                            </td>

                            <!-- ✅ STATUS -->
                            <td>
                                @if ($ho->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>

                            <!-- ⚙ ACTION -->
                            <td class="text-end">
                                <a href="{{ route('master.head-offices.edit', $ho->id) }}"
                                    class="btn btn-sm btn-light border">
                                    <i class="bx bx-edit-alt me-1"></i>
                                </a>

                                <form action="{{ route('master.head-offices.destroy', $ho->id) }}"
                                    method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        onclick="return confirm('Delete this head office?')"
                                        class="btn btn-sm btn-outline-danger">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </form>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                No head offices found 🌙
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        <!-- 📄 PAGINATION -->
        <div class="p-3">
            {{ $headOffices->links() }}
        </div>

    </div>
</div>
@endsection