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
        <span class="text-muted fw-light">Master /</span> Bags
    </h4>


    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Create New Bag</h5>
                    <small class="text-muted float-end">Bag Information</small>
                </div>
                <div class="card-body">
                    <form action="{{ route('master.bags.store') }}" method="POST">
                        @csrf
                        @method('post')
                        <div class="row">
                            <!-- bag Name -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="name">Bag Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                    placeholder="" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <!-- bag type -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="type">Bag Type <span class="text-danger">*</span></label>
                                <input type="text" name="type" id="type"
                                    class="form-control @error('type') is-invalid @enderror" value="{{ old('type') }}"
                                    placeholder="" required>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <!-- Contact Number -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="capacity">capacity (kg)<span
                                        class="text-danger">*</span></label>
                                <input type="text" name="capacity" id="capacity"
                                    class="form-control onlydigit @error('capacity') is-invalid @enderror"
                                    value="{{ old('capacity') }}" placeholder="" required>
                                @error('capacity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <!-- weight -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="weight">weight (gram)<span
                                        class="text-danger">*</span></label>
                                <input type="text" name="weight" id="weight"
                                    class="form-control onlydigit @error('weight') is-invalid @enderror"
                                    value="{{ old('weight') }}" placeholder="" required>
                                @error('weight')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>




                            <div class="text-end mt-3">
                                <button type="submit" class="btn btn-primary px-4">Save</button>
                                <a href="{{ route('master.bags.index') }}" class="btn btn-secondary px-4">Cancel</a>
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
                                    <th>bag name</th>
                                    <th>bag type</th>
                                    <th>capacity (kg)</th>
                                    <th>weight (gram)</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Example static row (replace with @foreach later) --}}
                                @foreach ($bags as $d)
                                    <tr>
                                        <td>{{ $d->id }}</td>
                                        <td>{{ $d->name }}</td>
                                        <td>{{ $d->type }}</td>
                                        <td>{{ $d->capacity }}</td>
                                        <td>{{ $d->weight }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#editBagModal{{ $d->id }}">
                                                        <i class="bx bx-edit-alt me-1"></i> Edit
                                                    </a>

                                                    <form action="{{ route('master.bags.destroy', $d->id) }}"
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

                                    <!-- Edit Bag Modal -->
                                    <div class="modal fade" id="editBagModal{{ $d->id }}" tabindex="-1"
                                        aria-labelledby="editBagModalLabel{{ $d->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-xl modal-dialog-centered">
                                            <div class="modal-content">

                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editBagModalLabel{{ $d->id }}">
                                                        Edit Bag
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>

                                                <form action="{{ route('master.bags.update', $d->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="modal-body">
                                                        <div class="row">

                                                            <!-- Bag Name -->
                                                            <div class="col-md-3 mb-3">
                                                                <label class="form-label"
                                                                    for="name{{ $d->id }}">Bag Name
                                                                    <span class="text-danger">*</span></label>
                                                                <input type="text" name="name"
                                                                    id="name{{ $d->id }}"
                                                                    class="form-control @error('name') is-invalid @enderror"
                                                                    value="{{ old('name', $d->name) }}" placeholder="" required>
                                                                @error('name')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>

                                                            <!-- Bag Type -->
                                                            <div class="col-md-3 mb-3">
                                                                <label class="form-label"
                                                                    for="type{{ $d->id }}">Bag Type
                                                                    <span class="text-danger">*</span></label>
                                                                <input type="text" name="type"
                                                                    id="type{{ $d->id }}"
                                                                    class="form-control @error('type') is-invalid @enderror"
                                                                    value="{{ old('type', $d->type) }}" placeholder="" required>
                                                                @error('type')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>

                                                            <!-- Capacity -->
                                                            <div class="col-md-3 mb-3">
                                                                <label class="form-label"
                                                                    for="capacity{{ $d->id }}">Capacity (kg)
                                                                    <span class="text-danger">*</span></label>
                                                                <input type="text" name="capacity"
                                                                    id="capacity{{ $d->id }}"
                                                                    class="form-control onlydigit @error('capacity') is-invalid @enderror"
                                                                    value="{{ old('capacity', $d->capacity) }}"
                                                                    placeholder="" required>
                                                                @error('capacity')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>

                                                            <!-- Weight -->
                                                            <div class="col-md-3 mb-3">
                                                                <label class="form-label"
                                                                    for="weight{{ $d->id }}">Weight (gram)
                                                                    <span class="text-danger">*</span></label>
                                                                <input type="text" name="weight"
                                                                    id="weight{{ $d->id }}"
                                                                    class="form-control onlydigit @error('weight') is-invalid @enderror"
                                                                    value="{{ old('weight', $d->weight) }}"
                                                                    placeholder="" required>
                                                                @error('weight')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>

                                                        </div>
                                                    </div>

                                                    <div class="modal-footer text-end">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit"
                                                            class="btn btn-primary px-4">Update</button>
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
