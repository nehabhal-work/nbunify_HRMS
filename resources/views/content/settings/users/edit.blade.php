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

    <form action="{{ route('settings.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row align-items-stretch">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Edit User Information</h5>
                        <small class="text-muted float-end">Update User Details</small>
                    </div>

                    <div class="card-body">
                        <div class="row">

                            <!-- Name -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $user->name) }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', $user->email) }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Password</label>

                                <div class="input-group">
                                    <input type="password" name="password" id="password"
                                        class="form-control @error('password') is-invalid @enderror text-lowercase">

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
                                    class="form-control @error('level') is-invalid @enderror"
                                    value="{{ old('level', $user->level) }}">
                                @error('level')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Roles -->
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Roles <span class="text-danger">*</span></label>
                                <select name="role_ids" class="form-select select2 @error('role_ids') is-invalid @enderror">
                                    <option value="">Select Role</option>

                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}"
                                            {{ old('role_ids', optional($user->roles->first())->id) == $role->id ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('role_ids')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                            </div>

                            <!-- Submit -->
                            <div class="text-end mt-3">
                                <button type="submit" class="btn btn-primary px-4">Update</button>
                                <a href="{{ route('settings.users.index') }}" class="btn btn-secondary px-4">Cancel</a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>




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
