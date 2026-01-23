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
    <form action="{{ route('settings.users.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('post')


        <div class="row align-items-stretch">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">User Information</h5>
                        <small class="text-muted float-end">User Basic Details</small>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <!-- Name -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Password <span class="text-danger">*</span></label>

                                <div class="input-group">
                                    <input type="password" name="password" id="password"
                                        class="form-control @error('password') is-invalid @enderror">

                                    <span class="input-group-text" onclick="togglePassword()" style="cursor:pointer">
                                        <i class="bx bx-show" id="toggleIcon"></i>
                                    </span>
                                </div>

                                @error('password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror

                                <small class="text-muted">Leave blank to keep existing password</small>
                            </div>

                            <!-- Level -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Level <span class="text-danger">*</span></label>
                                <input type="number" name="level"
                                    class="form-control @error('level') is-invalid @enderror" value="{{ old('level') }}">
                                @error('level')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Roles -->
                            <div class="col-md-4">
                                <label class="form-label">Roles <span class="text-danger">*</span></label>
                                
                                <select name="role_ids" 
                                    class="form-select select2 @error('role_ids') is-invalid @enderror">
                                    <option value="">Select Roles</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}"
                                            {{ collect(old('role_ids'))->contains($role->id) ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('role_ids')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Submit -->
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary px-4">Save</button>
                                {{-- <a href="{{ route('master.head-offices.index') }}"
                                    class="btn btn-secondary px-4">Cancel</a> --}}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>


    <div class="row">
        <!-- TABLE SECTION -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Users List</h5>
                    {{-- <a class="btn btn-primary" href="{{ route('master.companies.create') }}" role="button">Add New</a> --}}
                </div>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table srkdataTable ">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    {{-- <th>Password</th> --}}
                                    <th>Level</th>
                                    <th>Role Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Example static row (replace with @foreach later) --}}
                                @foreach ($users as $d)
                                    <tr>
                                        <td>{{ $d->id }}</td>
                                        <td>
                                            {{-- <a href="{{ route('master.companies.show', $d->id) }}"> --}}
                                            {{ $d->name }}
                                            {{-- </a> --}}
                                        </td>
                                        <td>{{ $d->email }}</td>
                                        {{-- <td>{{ $d->password }}</td> --}}
                                        <td>{{ $d->level }}</td>
                                        <td>{{ $d->roles->pluck('name')->join(', ') }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">

                                                    <a class="dropdown-item"
                                                        href="{{ route('settings.users.show', $d->id) }}">
                                                        <i class="bx bx-show me-1"></i>View</a>

                                                    <a class="dropdown-item"
                                                        href="{{ route('settings.users.edit', $d->id) }}"><i
                                                            class="bx bx-edit-alt me-1"></i> Edit</a>

                                                    <form action="{{ route('settings.users.destroy', $d->id) }}"
                                                        method="post" onsubmit="return confirmDelete()">

                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger delete-btn"
                                                            data-id="{{ $d->id }}">
                                                            <i class="bx bx-trash me-1"></i> Delete
                                                        </button>

                                                    </form>

                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('toggleIcon');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('bx-show', 'bx-hide');
            } else {
                input.type = 'password';
                icon.classList.replace('bx-hide', 'bx-show');
            }
        }
    </script>
@endsection
