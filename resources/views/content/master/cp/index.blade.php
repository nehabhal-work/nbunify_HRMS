@extends('layouts.master-layout')

@section('content')
    <div>
        @if (session('success'))
            <x-alert type="success" :message="session('success')" />
        @endif

        @if (session('error'))
            <x-alert type="danger" :message="session('error')" />
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

    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Master /</span> Grade
    </h4>


    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Create New Grade</h5>
                    <small class="text-muted float-end">Grade Information</small>
                </div>
                <div class="card-body">
                    <form action="{{ route('master.food-grades.store') }}" method="POST">
                        @csrf
                        @method('post')
                        <div class="row">
                            <!-- Company Name -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="name">Grade Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                    placeholder="" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>



                            <!-- description -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="description">description </label>
                                <input type="text" name="description" id="description"
                                    class="form-control @error('description') is-invalid @enderror"
                                    value="{{ old('description') }}" placeholder="">
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>



                            <div class="text-end mt-3">
                                <button type="submit" class="btn btn-primary px-4">Save</button>
                                <a href="{{ route('master.food-grades.index') }}" class="btn btn-secondary px-4">Cancel</a>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>

        <!-- TABLE SECTION -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Companies List</h5>
                    <small class="text-muted float-end">All registered companies</small>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table srkdataTable ">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Grade name</th>
                                    <th>description</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Example static row (replace with @foreach later) --}}
                                @foreach ($foodGrades as $d)
                                    <tr>
                                        <td>{{ $d->id }}</td>
                                        <td>{{ $d->name }}</td>
                                        <td>{{ $d->description }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#editgradeModal{{ $d->id }}">
                                                        <i class="bx bx-edit-alt me-1"></i> Edit
                                                    </a>

                                                    <form action="{{ route('master.food-grades.destroy', $d->id) }}"
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

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editgradeModal{{ $d->id }}" tabindex="-1"
                                        aria-labelledby="editModalLabel{{ $d->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-xl modal-dialog-centered">
                                            <div class="modal-content border-0 rounded-3 shadow-lg">
                                                <div class="modal-header  text-white">
                                                    <h5 class="modal-title" id="editModalLabel{{ $d->id }}">Edit
                                                        Food Grade</h5>
                                                    <button type="button" class="btn-close btn-close"
                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>

                                                <form action="{{ route('master.food-grades.update', $d->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="modal-body">
                                                        <div class="row g-3">
                                                            <!-- Grade Name -->
                                                            <div class="col-md-4">
                                                                <label class="form-label fw-semibold">Grade Name <span
                                                                        class="text-danger">*</span></label>
                                                                <input type="text" name="name" class="form-control"
                                                                    value="{{ old('name', $d->name) }}" required>
                                                            </div>

                                                            <!-- Description -->
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-semibold">Description</label>
                                                                <input type="text" name="description"
                                                                    class="form-control"
                                                                    value="{{ old('description', $d->description) }}">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="submit"
                                                            class="btn btn-primary px-4">Update</button>
                                                        <button type="button" class="btn btn-secondary px-4"
                                                            data-bs-dismiss="modal">Cancel</button>
                                                    </div>
                                                </form>
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
