@extends('layouts.master-layout')
@section('title', 'designations')

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

    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Master /</span> <a href="{{ route('master.branches.index') }}">designations</a>
    </h4>


    <form action="{{ route('master.designations.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('post')
        <div class="row align-items-stretch">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">designations Information</h5>
                        <small class="text-muted float-end">designations Details</small>
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <!-- branch Name -->
                            <div class="col-3 mb-3">
                                <label class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" id="title"
                                    class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}">
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- branch Code -->
                            <div class="col-3 mb-3">
                                <label class="form-label">Description </label>
                                <input type="text" name="description" id="description"
                                    class="form-control @error('description') is-invalid @enderror"
                                    value="{{ old('description') }}">
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>






                            <!-- Submit -->
                            <div class="text-end mt-3">
                                <button type="submit" class="btn btn-primary px-4">Save</button>
                                <a href="{{ route('master.branches.index') }}" class="btn btn-secondary px-4">Cancel</a>
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
                    <h5 class="mb-0">designations List</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table srkdataTable align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>designations</th>
                                    <th>Description</th>
                                    <th>Sub-designations</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($designations as $d)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $d->title }}</td>
                                        <td>{{ $d->description }}</td>
                                        <td>
                                            <!-- Add New Sub-designations Button -->
                                            <button class="btn btn-sm btn-primary mb-2" data-bs-toggle="modal"
                                                data-bs-target="#addSubDeptModal" data-dept-id="{{ $d->id }}"
                                                data-dept-name="{{ $d->title }}">
                                                <i class="bx bx-plus"></i> Add New
                                            </button>

                                            <!-- List Sub-designations -->
                                            @if ($d->subdesignations->count())
                                                <ul class="list-unstyled mb-0">
                                                    @foreach ($d->subdesignations as $sub)
                                                        <li
                                                            class="d-flex justify-content-between align-items-center border rounded p-2 mb-1">
                                                            <span>{{ $sub->title }}</span>
                                                            <div>
                                                                <!-- Edit Sub-designations Button -->
                                                                <button type="button"
                                                                    class="btn btn-sm btn-outline-secondary"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#editSubdesignationsModal{{ $sub->id }}">
                                                                    <i class="bx bx-edit-alt me-1"></i>
                                                                </button>

                                                                <!-- Delete Sub-designations -->
                                                                <form
                                                                    action="{{ route('master.sub-designations.destroy', $sub->id) }}"
                                                                    method="POST" class="d-inline"
                                                                    onsubmit="return confirm('Delete this sub-designations?')">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="btn btn-sm btn-outline-danger">
                                                                        <i class="bx bx-trash"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </li>

                                                        <!-- Edit Sub-designations Modal -->
                                                        <div class="modal fade"
                                                            id="editSubdesignationsModal{{ $sub->id }}" tabindex="-1"
                                                            aria-labelledby="editSubdesignationsLabel{{ $sub->id }}"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <form method="POST"
                                                                    action="{{ route('master.sub-designations.update', $sub->id) }}">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title"
                                                                                id="editSubdesignationsLabel{{ $sub->id }}">
                                                                                Edit Sub-designations
                                                                            </h5>
                                                                            <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Close"></button>
                                                                        </div>

                                                                        <div class="modal-body">
                                                                            <div class="mb-3">
                                                                                <label class="form-label">Sub-designations
                                                                                    Name</label>
                                                                                <input type="text" name="title"
                                                                                    class="form-control"
                                                                                    value="{{ $sub->title }}" required>
                                                                            </div>

                                                                            <input type="hidden" name="designation_id"
                                                                                value="{{ $d->id }}">
                                                                        </div>

                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-light"
                                                                                data-bs-dismiss="modal">Cancel</button>
                                                                            <button type="submit"
                                                                                class="btn btn-primary">Update</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <small class="text-muted fst-italic">No sub-designations</small>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <!-- Edit designations Modal Trigger -->
                                                    <button type="button" class="dropdown-item" data-bs-toggle="modal"
                                                        data-bs-target="#editdesignationsModal{{ $d->id }}">
                                                        <i class="bx bx-edit-alt me-1"></i> Edit
                                                    </button>

                                                    <!-- Delete designations -->
                                                    <form action="{{ route('master.designations.destroy', $d->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Delete this designations?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger">
                                                            <i class="bx bx-trash me-1"></i> Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Edit designations Modal -->
                                    <div class="modal fade" id="editdesignationsModal{{ $d->id }}" tabindex="-1"
                                        aria-labelledby="editdesignationsLabel{{ $d->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <form method="POST"
                                                action="{{ route('master.designations.update', $d->id) }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="editdesignationsLabel{{ $d->id }}">Edit
                                                            designations
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label">designations Name</label>
                                                            <input type="text" name="title" class="form-control"
                                                                value="{{ $d->title }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Description</label>
                                                            <textarea name="description" class="form-control" rows="2">{{ $d->description }}</textarea>
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light"
                                                            data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                    </div>
                                                </div>
                                            </form>
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


    <!-- Add Sub-designations Modal -->
    <div class="modal fade" id="addSubDeptModal" tabindex="-1" aria-labelledby="addSubDeptLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{ route('master.sub-designations.store') }}" method="POST" id="addSubDeptForm">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addSubDeptLabel">Add Sub-designations</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden1" name="designation_id" id="designations_id">

                        <div class="mb-3">
                            <label class="form-label">Sub-designations Name</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Sub-designations</button>
                    </div>
                </div>
            </form>
        </div>
    </div>





@endsection

@push('scripts')
    <script>
        var addSubDeptModal = document.getElementById('addSubDeptModal');
        addSubDeptModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var deptId = button.getAttribute('data-dept-id');
            var deptName = button.getAttribute('data-dept-name');

            var modalTitle = addSubDeptModal.querySelector('.modal-title');
            var designationsIdInput = addSubDeptModal.querySelector('#designations_id');

            modalTitle.textContent = 'Add Sub-designations to ' + deptName;
            designationsIdInput.value = deptId;
        });
    </script>
@endpush
