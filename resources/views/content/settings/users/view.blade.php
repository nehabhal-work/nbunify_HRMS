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
            <span class="text-muted fw-light">Master /</span> Users
        </h4>
    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">User Profile</h5>
                    <small class="text-muted">Account & Access Details</small>
                </div>

                <div class="card-body">
                    <div class="row">

                        <!-- Basic Info -->
                        <div class="col-md-6">
                            <table class="table table-borderless table-sm">
                                <tr>
                                    <th width="40%">Name</th>
                                    <td>{{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <th>Level</th>
                                    <td>{{ $user->level }}</td>
                                </tr>
                                <tr>
                                    <th>Email Verified</th>
                                    <td>
                                        @if ($user->email_verified_at)
                                            <span class="badge bg-success">Verified</span>
                                        @else
                                            <span class="badge bg-danger">Not Verified</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Created At</th>
                                    <td>{{ $user->created_at->format('d M Y') }}</td>
                                </tr>
                            </table>
                        </div>

                        <!-- Roles & Permissions -->
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="25%">Module</th>
                                            <th>Permissions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($user->roles as $role)
                                            @php
                                                $groupedPermissions = $role->permissions->groupBy('module');
                                            @endphp

                                            @foreach ($groupedPermissions as $module => $permissions)
                                                <tr>
                                                    <td class="fw-semibold text-capitalize">
                                                        {{ $module }}
                                                    </td>
                                                    <td>
                                                        @foreach ($permissions as $permission)
                                                            <span class="badge bg-light text-dark border mb-1">
                                                                {{ $permission->name }}
                                                            </span>
                                                        @endforeach
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="card-footer text-end">
                    <a href="{{ route('settings.users.index') }}" class="btn btn-secondary">
                        Back
                    </a>
                    <a href="{{ route('settings.users.edit', $user->id) }}" class="btn btn-primary">
                        Edit User
                    </a>
                </div>
            </div>
        </div>
    </div>



@endsection
