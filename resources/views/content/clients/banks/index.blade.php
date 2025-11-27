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
            <span class="text-muted fw-light">Master /</span> <a href="{{ route('master.companies.create') }}">Bank List of
                <span class="text-uppercase">{{ $client->name }}</span></a>
        </h4>
    </div>

    <div class="div d-flex justify-content-end mb-3">
        <a href="{{ route('clients.index') }}" class="btn btn-secondary px-4">Go back</a>

    </div>
    <div class="row">
        <!-- TABLE SECTION -->

        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Bank List</h5>
                    <a class="btn btn-primary" href="{{ route('client-banks.create', ['client_id' => $client->id]) }}"
                        role="button">Add Bank
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-nowrap ">
                        <table class="table srkdataTable ">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>IFSC</th>
                                    <th>Account No</th>
                                    <th>Bank Name</th>
                                    <th>Branch</th>
                                    <th>Bank Code</th>
                                    <th>Primary</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($clientBanks as $b)
                                    <tr>
                                        <td>{{ $b->id ?? '-' }}</td>
                                        <td>{{ $b->ifsc_code ?? '-' }}</td>
                                        <td>{{ $b->account_number ?? '-' }}</td>
                                        <td>{{ $b->bank_name ?? '-' }}</td>
                                        <td>{{ $b->branch_name ?? '-' }}</td>
                                        <td>{{ $b->bank_code ?? '-' }}</td>
                                        <td>{{ $b->is_primary ? 'Yes' : 'No' }}</td>

                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>

                                                <div class="dropdown-menu">

                                                    <!-- Edit Button -->
                                                    <a class="dropdown-item" data-bs-toggle="modal"
                                                        data-bs-target="#editBankModal{{ $b->id }}">
                                                        <i class="bx bx-edit-alt me-1"></i> Edit
                                                    </a>

                                                    <!-- Delete -->
                                                    <form action="{{ route('client-banks.destroy', $b->id) }}"
                                                        method="post" onsubmit="return confirmDelete()">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="client_id" value="{{ $client->id }}">
                                                        <button type="submit" class="dropdown-item text-danger">
                                                            <i class="bx bx-trash me-1"></i> Delete
                                                        </button>
                                                    </form>

                                                </div>
                                            </div>
                                        </td>
                                    </tr>


                                    <!-- Edit Bank Modal -->
                                    <div class="modal fade" id="editBankModal{{ $b->id }}" tabindex="-1"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-xl">
                                            <div class="modal-content">

                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Bank Details</h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>

                                                <form action="{{ route('client-banks.update', $b->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="client_id" value="{{ $client->id }}">

                                                    <div class="modal-body">

                                                        <div
                                                            class="bank-details-row row g-3 mb-3 bg-light position-relative">

                                                            {{-- IFSC --}}
                                                            <div class="col-md-6">
                                                                <label class="form-label">IFSC Code</label>
                                                                <input type="text" name="ifsc_code"
                                                                    value="{{ old('ifsc_code', $b->ifsc_code) }}"
                                                                    class="form-control @error('ifsc_code') is-invalid @enderror"
                                                                    placeholder="Enter IFSC Code">
                                                                @error('ifsc_code')
                                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                                @enderror
                                                            </div>

                                                            {{-- Account No --}}
                                                            <div class="col-md-6">
                                                                <label class="form-label">Account Number</label>
                                                                <input type="text" name="account_number"
                                                                    value="{{ old('account_number', $b->account_number) }}"
                                                                    class="form-control @error('account_number') is-invalid @enderror"
                                                                    maxlength="18" placeholder="Enter Account Number">
                                                                @error('account_number')
                                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                                @enderror
                                                            </div>

                                                            {{-- Bank Name --}}
                                                            <div class="col-md-6">
                                                                <label class="form-label">Bank Name</label>
                                                                <input type="text" name="bank_name"
                                                                    value="{{ old('bank_name', $b->bank_name) }}"
                                                                    class="form-control bg-secondary-subtle bg-gradient
                                        @error('bank_name') is-invalid @enderror"
                                                                    readonly>
                                                                @error('bank_name')
                                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                                @enderror
                                                            </div>

                                                            {{-- Branch Name --}}
                                                            <div class="col-md-6">
                                                                <label class="form-label">Branch Name</label>
                                                                <input type="text" name="branch_name"
                                                                    value="{{ old('branch_name', $b->branch_name) }}"
                                                                    class="form-control bg-secondary-subtle bg-gradient
                                     @error('branch_name') is-invalid @enderror"
                                                                    readonly>
                                                                @error('branch_name')
                                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                                @enderror
                                                            </div>

                                                            {{-- Bank Code --}}
                                                            <div class="col-md-6">
                                                                <label class="form-label">Bank Code</label>
                                                                <input type="text" name="bank_code"
                                                                    value="{{ old('bank_code', $b->bank_code) }}"
                                                                    class="form-control bg-secondary-subtle bg-gradient
                                @error('bank_code') is-invalid @enderror"
                                                                    readonly>
                                                                @error('bank_code')
                                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                                @enderror
                                                            </div>

                                                            {{-- Primary Checkbox --}}
                                                            <div class="col-md-6">
                                                                <label class="form-label d-block">Primary a/c</label>
                                                                <input type="hidden" name="is_primary" value="0">
                                                                <input type="checkbox" name="is_primary" value="1"
                                                                    class="form-check-input @error('is_primary') is-invalid @enderror"
                                                                    {{ old('is_primary', $b->is_primary) ? 'checked' : '' }}>
                                                                @error('is_primary')
                                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                                @enderror
                                                            </div>

                                                        </div>

                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="bx bx-save me-1"></i> Update
                                                        </button>
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
@endpush
