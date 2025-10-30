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
        <span class="text-muted fw-light">Master /</span> Sub-warehouse
    </h4>


    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Create New Sub-warehouse</h5>
                    <small class="text-muted float-end">Sub-warehouse Information</small>
                </div>
                <div class="card-body">
                    <form action="{{ route('master.sub-warehouses.store') }}" method="POST">
                        @csrf
                        @method('post')

                        <div class="row">
                            <!-- Main Warehouse -->
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Select Warehouse <span class="text-danger">*</span></label>
                                <select class="form-select  @error('warehouse_id') is-invalid @enderror" id="warehouse_id"
                                    name="warehouse_id" required>
                                    <option value="">Select Warehouse</option>
                                    @foreach ($warehouses as $d)
                                        <option value="{{ $d->id }}"
                                            {{ old('warehouse_id') == $d->id ? 'selected' : '' }}>
                                            {{ $d->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('warehouse_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Sub-Warehouse Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" value="{{ old('name') }}"
                                    class="form-control @error('name') is-invalid @enderror"
                                    placeholder="Enter sub-warehouse name" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>


                        <!-- Form Buttons -->
                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-primary px-4">Save</button>
                            <a href="{{ route('master.sub-warehouses.index') }}" class="btn btn-secondary px-4">Cancel</a>
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
                                    <th>Sub-warehouse name</th>
                                    <th>warehouse name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subWarehouses as $d)
                                    <tr>
                                        <td>{{ $d->id }}</td>
                                        <td>{{ $d->name }}</td>
                                        <td>{{ $d->warehouse->name }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#editSubWarehouseModal{{ $d->id }}">
                                                        <i class="bx bx-edit-alt me-1"></i> Edit
                                                    </a>
                                                    <form action="{{ route('master.sub-warehouses.destroy', $d->id) }}"
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

                                    <!-- Edit Sub-Warehouse Modal -->
                                    <div class="modal fade" id="editSubWarehouseModal{{ $d->id }}" tabindex="-1"
                                        aria-labelledby="editSubWarehouseModalLabel{{ $d->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                            <div class="modal-content">

                                                <div class="modal-header">
                                                    <h5 class="modal-title"
                                                        id="editSubWarehouseModalLabel{{ $d->id }}">
                                                        Edit Sub-Warehouse
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>

                                                <form action="{{ route('master.sub-warehouses.update', $d->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <!-- Select Warehouse -->
                                                            <div class="col-md-4 mb-3">
                                                                <label class="form-label">Select Warehouse <span
                                                                        class="text-danger">*</span></label>
                                                                <select
                                                                    class="form-select @error('warehouse_id') is-invalid @enderror"
                                                                    name="warehouse_id" required>
                                                                    <option value="">Select Warehouse</option>
                                                                    @foreach ($warehouses as $w)
                                                                        <option value="{{ $w->id }}"
                                                                            {{ old('warehouse_id', $d->warehouse_id) == $w->id ? 'selected' : '' }}>
                                                                            {{ $w->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                @error('warehouse_id')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>

                                                            <!-- Sub-Warehouse Name -->
                                                            <div class="col-md-4 mb-3">
                                                                <label class="form-label">Sub-Warehouse Name <span
                                                                        class="text-danger">*</span></label>
                                                                <input type="text" name="name"
                                                                    class="form-control @error('name') is-invalid @enderror"
                                                                    value="{{ old('name', $d->name) }}" required
                                                                    placeholder="Enter sub-warehouse name">
                                                                @error('name')
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

@push('scripts')
    <script>
        // $(document).ready(function() {

        //     // Add More Rows
        //     $('#addMore').on('click', function() {
        //         let newRow = $('#subWarehouseContainer .subRow:first').clone();

        //         newRow.find('input').val('');
        //         newRow.find('.is-invalid').removeClass('is-invalid');
        //         newRow.find('.invalid-feedback').remove();
        //         newRow.find('.removeRow').removeClass('d-none');

        //         // 🟩 Add margin-top dynamically
        //         newRow.css('margin-top', '5px');

        //         $('#subWarehouseContainer').append(newRow);
        //     });


        //     // Remove Row
        //     $(document).on('click', '.removeRow', function() {
        //         let totalRows = $('#subWarehouseContainer .subRow').length;

        //         if (totalRows > 1) { // Ensure at least one row remains
        //             $(this).closest('.subRow').remove();
        //         }
        //     });

        // });
    </script>
@endpush
