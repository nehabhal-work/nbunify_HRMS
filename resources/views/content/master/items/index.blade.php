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
        <span class="text-muted fw-light">Master /</span> Item
    </h4>


    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Create New Item</h5>
                    <small class="text-muted float-end">Item Information</small>
                </div>
                <div class="card-body">
                    <form action="{{ route('master.items.store') }}" method="POST">
                        @csrf
                        @method('post')
                        <div class="row">
                            <!-- Company Name -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="name">Item Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                    placeholder="" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- hsn_code -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="hsn_code">hsn_code </label>
                                <input type="text" name="hsn_code" id="hsn_code"
                                    class="form-control @error('hsn_code') is-invalid @enderror"
                                    value="{{ old('hsn_code') }}" placeholder="">
                                @error('hsn_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <!-- description -->
                            <div class="col-md-5 mb-3">
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
                                <a href="{{ route('master.items.index') }}" class="btn btn-secondary px-4">Cancel</a>
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
                                    <th>Item name</th>
                                    <th>hsn code</th>
                                    <th>description</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Example static row (replace with @foreach later) --}}
                                @foreach ($items as $d)
                                    <tr>
                                        <td>{{ $d->id }}</td>
                                        <td>{{ $d->name }}</td>
                                        <td>{{ $d->hsn_code }}</td>
                                        <td>{{ $d->description }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#editItemModal{{ $d->id }}">
                                                        <i class="bx bx-edit-alt me-1"></i> Edit
                                                    </a>

                                                    <form action="{{ route('master.items.destroy', $d->id) }}"
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

                                    <!-- Edit Item Modal -->
                                    <div class="modal fade" id="editItemModal{{ $d->id }}" tabindex="-1"
                                        aria-labelledby="editItemModalLabel{{ $d->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-xl modal-dialog-centered">
                                            <div class="modal-content">

                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editItemModalLabel{{ $d->id }}">Edit
                                                        Item</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>

                                                <form action="{{ route('master.items.update', $d->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="modal-body">
                                                        <div class="row">

                                                            <!-- Item Name -->
                                                            <div class="col-md-4 mb-3">
                                                                <label class="form-label"
                                                                    for="name{{ $d->id }}">Item Name <span
                                                                        class="text-danger">*</span></label>
                                                                <input type="text" name="name"
                                                                    id="name{{ $d->id }}"
                                                                    class="form-control @error('name') is-invalid @enderror"
                                                                    value="{{ old('name', $d->name) }}" placeholder="" required>
                                                                @error('name')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>

                                                            <!-- HSN Code -->
                                                            <div class="col-md-4 mb-3">
                                                                <label class="form-label"
                                                                    for="hsn_code{{ $d->id }}">HSN Code</label>
                                                                <input type="text" name="hsn_code"
                                                                    id="hsn_code{{ $d->id }}"
                                                                    class="form-control @error('hsn_code') is-invalid @enderror"
                                                                    value="{{ old('hsn_code', $d->hsn_code) }}"
                                                                    placeholder="">
                                                                @error('hsn_code')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>

                                                            <!-- Description -->
                                                            <div class="col-md-4 mb-3">
                                                                <label class="form-label"
                                                                    for="description{{ $d->id }}">Description</label>
                                                                <input type="text" name="description"
                                                                    id="description{{ $d->id }}"
                                                                    class="form-control @error('description') is-invalid @enderror"
                                                                    value="{{ old('description', $d->description) }}"
                                                                    placeholder="">
                                                                @error('description')
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
