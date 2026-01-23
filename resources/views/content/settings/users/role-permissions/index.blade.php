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
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Master /</span> Users Roles & Permissions
        </h4>
    </div>

    <div class="row">
        <!-- TABLE SECTION -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Users Roles & Permissions</h5>
                    {{-- <a class="btn btn-primary" href="{{ route('master.companies.create') }}" role="button">Add New</a> --}}
                </div>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table srkdataTable ">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Role</th>
                                    <th>Permissions</th>

                                </tr>
                            </thead>
                            <tbody>
                                {{-- Example static row (replace with @foreach later) --}}
                                @foreach ($roles as $d)
                                    <tr>
                                        <td>{{ $d->id }}</td>
                                        <td>
                                            {{ $d->name }}
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                                data-bs-target="#permissionsModal{{ $d->id }}">
                                                View Permissions ({{ $d->permissions->count() }})
                                            </button>
                                        </td>

                                    </tr>
                                    <div class="modal fade" id="permissionsModal{{ $d->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content">

                                                <div class="modal-header">
                                                    <h5 class="modal-title">
                                                        Permissions – {{ $d->name }}
                                                    </h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>

                                                <div class="modal-body">
                                                    @if ($d->permissions->count())
                                                        @foreach ($d->permissions->groupBy('module') as $module => $permissions)
                                                            <div class="mb-3">
                                                                <h6 class="fw-bold text-primary text-capitalize mb-2">
                                                                    {{ str_replace('-', ' ', $module) }}
                                                                </h6>

                                                                <div class="d-flex flex-wrap align-items-center gap-2">
                                                                    @foreach ($permissions as $permission)
                                                                        <span class="d-inline-flex align-items-center">
                                                                            <i
                                                                                class="bx bx-check-circle text-success me-1"></i>
                                                                            {{ $permission->name }}
                                                                        </span>
                                                                    @endforeach
                                                                </div>


                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <p class="text-muted mb-0">No permissions assigned.</p>
                                                    @endif
                                                </div>


                                                <div class="modal-footer">
                                                    <button class="btn btn-secondary" data-bs-dismiss="modal">
                                                        Close
                                                    </button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>


@endsection
