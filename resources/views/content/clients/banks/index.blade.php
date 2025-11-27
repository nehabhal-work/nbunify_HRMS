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

    <div class="d-flex justify-content-between align-items-center">
        <h4 class="fw-bold py-3">
            <span class="text-muted fw-light">Master /</span> <a href="{{ route('master.companies.create') }}">Bank List of
                <span class="text-uppercase">{{ $client->name }}</span></a>
        </h4>
    </div>

    <div class="div d-flex justify-content-end mb-3">
        <a href="{{ route('clients.index') }}" class="btn btn-secondary px-4">Go back</a>

    </div>
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Bank details</h5>
            <small class="text-muted float-end">Bank Information</small>
        </div>
        <div class="card-body" id="bankDetailsWrapper">
            <div class="bank-details-row row" >
                <!-- IFSC -->
                <div class="col-md-4">
                    <label class="form-label">IFSC Code</label>
                    <input type="text" name="banks[0][ifsc_code]"
                        class="form-control ifsc_code @error('banks.0.ifsc_code') is-invalid @enderror"
                        placeholder="Enter IFSC Code">
                    @error('banks.0.ifsc_code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Account No -->
                <div class="col-md-4">
                    <label class="form-label">Account No</label>
                    <input type="text" name="banks[0][account_number]"
                        class="form-control account_number @error('banks.0.account_number') is-invalid @enderror"
                        placeholder="Enter Account Number" maxlength="15">
                    @error('banks.0.account_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Operation Mode -->
                <div class="col-md-4">
                    <label class="form-label">Operation Mode</label>
                    <select name="banks[0][operation_mode]"
                        class="form-select operation_mode @error('banks.0.operation_mode') is-invalid @enderror">
                        <option value="">Select Mode</option>
                        <option value="single">Single</option>
                        <option value="joint">Joint</option>
                        <option value="anyone">Anyone</option>
                    </select>
                    @error('banks.0.operation_mode')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Holder 1 -->
                <div class="col-md-4 holder_names d-none">
                    <label class="form-label">Holder Name 1</label>
                    <input type="text" name="banks[0][holder_name_1]"
                        class="form-control @error('banks.0.holder_name_1') is-invalid @enderror">
                    @error('banks.0.holder_name_1')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Holder 2 -->
                <div class="col-md-4 holder_names d-none">
                    <label class="form-label">Holder Name 2</label>
                    <input type="text" name="banks[0][holder_name_2]"
                        class="form-control @error('banks.0.holder_name_2') is-invalid @enderror">
                    @error('banks.0.holder_name_2')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Holder 3 -->
                <div class="col-md-4 holder_names d-none">
                    <label class="form-label">Holder Name 3</label>
                    <input type="text" name="banks[0][holder_name_3]"
                        class="form-control @error('banks.0.holder_name_3') is-invalid @enderror">
                    @error('banks.0.holder_name_3')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- MICR -->
                <div class="col-md-4">
                    <label class="form-label">MICR Code</label>
                    <input type="text" name="banks[0][micrcode]"
                        class="form-control micrcode bg-secondary-subtle bg-gradient @error('banks.0.micrcode') is-invalid @enderror"
                        readonly>
                    @error('banks.0.micrcode')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Bank Name -->
                <div class="col-md-4">
                    <label class="form-label">Bank Name</label>
                    <input type="text" name="banks[0][bank_name]"
                        class="form-control bank_name bg-secondary-subtle bg-gradient @error('banks.0.bank_name') is-invalid @enderror"
                        readonly>
                    @error('banks.0.bank_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Branch Name -->
                <div class="col-md-4">
                    <label class="form-label">Branch Name</label>
                    <input type="text" name="banks[0][branch_name]"
                        class="form-control branch_name bg-secondary-subtle bg-gradient @error('banks.0.branch_name') is-invalid @enderror"
                        readonly>
                    @error('banks.0.branch_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Bank Code -->
                <div class="col-md-4">
                    <label class="form-label">Bank Code</label>
                    <input type="text" name="banks[0][bank_code]"
                        class="form-control bank_code bg-secondary-subtle bg-gradient @error('banks.0.bank_code') is-invalid @enderror"
                        readonly>
                    @error('banks.0.bank_code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>



                <!-- Cheque Photo -->
                <div class="col-md-4 mb-3">
                    <label class="form-label">Cheque Photo</label>

                    <div class="input-group">
                        <input type="file"
                            class="form-control @error('banks.0.attachment_cancelled_cheque') is-invalid @enderror"
                            id="attachment_cancelled_cheque" name="banks[0][attachment_cancelled_cheque]"
                            onchange="uploadTempFile(this, 'attachment_cancelled_cheque')" accept=".jpg,.jpeg,.png,.pdf">

                        <button class="btn btn-outline-danger" type="button"
                            onclick="document.getElementById('attachment_cancelled_cheque').value = ''">
                            ✕
                        </button>
                    </div>

                    @error('banks.0.attachment_cancelled_cheque')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <!-- Hidden URL -->
                    <input type="hidden" id="attachment_cancelled_cheque_url"
                        value="{{ old('banks.0.attachment_cancelled_cheque_url') }}"
                        name="banks[0][attachment_cancelled_cheque_url]">

                    <!-- Preview -->
                    @if (old('banks.0.attachment_cancelled_cheque_url'))
                        <div id="attachment_cancelled_cheque_preview" class="position-relative d-inline-block mt-2">
                            <img src="{{ old('banks.0.attachment_cancelled_cheque_url') }}" width="100"
                                class="rounded">

                            <button type="button"
                                class="btn btn-sm btn-danger position-absolute top-0 start-100 translate-middle"
                                onclick="removeImage('attachment_cancelled_cheque')">
                                ✕
                            </button>
                        </div>
                    @endif
                </div>


                <!-- Primary -->
                <div class="col-md-4">
                    <label class="form-label d-block">Primary a/c</label>
                    <input type="hidden" name="banks[0][is_primary]" value="0">
                    <input type="checkbox" name="banks[0][is_primary]" value="1"
                        class="form-check-input setPrimary @error('banks.0.is_primary') is-invalid @enderror">
                    @error('banks.0.is_primary')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                 <!-- Submit -->
                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-primary px-4">Save</button>
                        </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- TABLE SECTION -->

        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Bank List</h5>
                    {{-- <a class="btn btn-primary" href="{{ route('client-banks.edit', ['client_id' => $client->id]) }}"
                        role="button">Add Bank
                    </a> --}}
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
                                        {{-- <td>{{ $b->ifsc_code ?? '-' }}</td> --}}
                                        <td>
                                            <a href="javascript:void(0)" data-bs-toggle="modal"
                                                data-bs-target="#editBankModal{{ $b->id }}">
                                                {{ $b->ifsc_code ?? '-' }}
                                            </a>
                                        </td>

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
                                                    {{-- <a class="dropdown-item edit-btn"
                                                        href="{{ route('client-banks.edit', ['client_id' => $client->id]) }}">
                                                        <i class="bx bx-edit-alt me-1"></i> Edit
                                                    </a> --}}
                                                    <a class="dropdown-item"
                                                        href="{{ route('client-banks.edit', ['client_bank' => $b->id]) }}">
                                                        <i class="bx bx-edit-alt me-1"></i> Edit
                                                    </a>


                                                    <!-- Delete -->
                                                    <form action="{{ route('client-banks.destroy', $b->id) }}"
                                                        method="post" onsubmit="return confirmDelete()">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="client_id"
                                                            value="{{ $client->id }}">
                                                        <button type="submit" class="dropdown-item text-danger">
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
                    @foreach ($clientBanks as $b)
                        <!-- Edit Bank Modal -->
                        <div class="modal fade" id="editBankModal{{ $b->id }}" tabindex="-1"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-xl">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Bank Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>


                                    <input type="hidden" name="client_id" value="{{ $client->id }}">

                                    <div class="modal-body">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th class="bg-secondary-subtle ">IFSC Code</th>
                                                <td><b>{{ $b->ifsc_code }}</b></td>

                                                <th class="bg-secondary-subtle ">Account Number</th>
                                                <td><b>{{ $b->account_number }}</b></td>
                                            </tr>



                                            <tr>
                                                <th class="bg-secondary-subtle ">MICR Code</th>
                                                <td><b>{{ $b->micrcode }}</b></td>

                                                <th class="bg-secondary-subtle ">Bank Name</th>
                                                <td><b>{{ $b->bank_name }}</b></td>
                                            </tr>

                                            <tr>
                                                <th class="bg-secondary-subtle ">Branch Name</th>
                                                <td><b>{{ $b->branch_name }}</b></td>

                                                <th class="bg-secondary-subtle ">Bank Code</th>
                                                <td><b>{{ $b->bank_code }}</b></td>
                                            </tr>
                                            @php
                                                $op = trim($b->operation_mode ?? '');
                                            @endphp

                                            <tr>
                                                <th class="bg-secondary-subtle">Operation Mode</th>
                                                <td><b>{{ $op ?: '-' }}</b></td>

                                                {{-- Holder 1 --}}
                                                <th
                                                    class="bg-secondary-subtle {{ in_array($op, ['joint', 'anyone']) ? '' : 'd-none' }}">
                                                    Holder Name 1
                                                </th>
                                                <td class="{{ in_array($op, ['joint', 'anyone']) ? '' : 'd-none' }}">
                                                    <b>{{ in_array($op, ['joint', 'anyone']) ? $b->holder_name_1 : '' }}</b>
                                                </td>
                                            </tr>

                                            <tr>
                                                {{-- Holder 2 --}}
                                                <th class="bg-secondary-subtle {{ $op == 'joint' ? '' : 'd-none' }}">
                                                    Holder Name 2
                                                </th>
                                                <td class="{{ $op == 'joint' ? '' : 'd-none' }}">
                                                    <b>{{ $op == 'joint' ? $b->holder_name_2 : '' }}</b>
                                                </td>

                                                {{-- Holder 3 --}}
                                                <th class="bg-secondary-subtle {{ $op == 'joint' ? '' : 'd-none' }}">
                                                    Holder Name 3
                                                </th>
                                                <td class="{{ $op == 'joint' ? '' : 'd-none' }}">
                                                    <b>{{ $op == 'joint' ? $b->holder_name_3 : '' }}</b>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="bg-secondary-subtle ">Primary A/c</th>
                                                <td><b>{{ $b->is_primary ? 'Yes' : 'No' }}</b></td>

                                                <th class="bg-secondary-subtle ">Cheque Photo</th>
                                                <td>
                                                    <b>
                                                        @if ($b->attachment_cancelled_cheque_url_url)
                                                            <img src="{{ $b->attachment_cancelled_cheque_url_url }}"
                                                                width="120" class="rounded">
                                                        @else
                                                            -
                                                        @endif
                                                    </b>
                                                </td>
                                            </tr>
                                        </table>

                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary"
                                            data-bs-dismiss="modal">Close</button>

                                    </div>

                                    </form>

                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>

    </div>


@endsection

@push('scripts')
@endpush
