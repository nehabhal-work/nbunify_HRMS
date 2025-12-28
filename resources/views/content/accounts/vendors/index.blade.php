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
            <span class="text-muted fw-light">Account /</span> vendors List
        </h4>
    </div>

    <div class="row">
        <!-- TABLE SECTION -->

        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Account List</h5>
                    <a class="btn btn-primary" href="{{ route('accounts.vendors.create') }}" role="button">Add New</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-bordered table-hover srkdataTable">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Vendor / Client Name</th>
                                    <th>Type</th>
                                    <th>State</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Created By</th>
                                    <th>Approved By 1</th>
                                    <th>Approved By 2</th>
                                    <th>Approved By 3</th>
                                    <th>action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($vendors as $d)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>

                                        <td>
                                            <strong>{{ $d->client_name }}</strong><br>
                                            <small class="text-muted">{{ $d->vendor_code }}</small>
                                        </td>

                                        <td class="text-capitalize">
                                            {{ $d->opt_client_vendor }}
                                        </td>

                                        <td>
                                            {{ $d->res_state ?? '-' }}
                                        </td>

                                        <td>
                                            {{ $d->vendor_mobile ?? ($d->contact_mobile ?? '-') }}
                                        </td>

                                        <td>
                                            {{ $d->vendor_email ?? ($d->contact_email ?? '-') }}
                                        </td>

                                        {{-- Created By --}}
                                        <td
                                            class="{{ $d->createdBy ? 'table-warning fw-semibold rounded px-2 py-1' : '' }}">
                                            @if ($d->createdBy)
                                                {{ $d->createdBy->name }} <br>
                                                <small>{{ $d->created_at }}</small>
                                            @else
                                                -
                                            @endif
                                        </td>

                                        {{-- Approved By 1 --}}
                                        <td
                                            class="{{ $d->approvedBy ? 'table-success fw-semibold rounded px-2 py-1' : '' }}">
                                            @if ($d->approvedBy)
                                                {{ $d->approvedBy->name }} <br>
                                                <small>{{ $d->approved_at }}</small>
                                            @else
                                                -
                                            @endif
                                        </td>

                                        {{-- Approved By 2 --}}
                                        <td
                                            class="{{ $d->approved2By ? 'table-success fw-semibold rounded px-2 py-1' : '' }}">
                                            @if ($d->approved2By)
                                                {{ $d->approved2By->name }} <br>
                                                <small>{{ $d->approved2_on }}</small>
                                            @else
                                                -
                                            @endif
                                        </td>

                                        {{-- Approved By 3 --}}
                                        <td
                                            class="{{ $d->approved3By ? 'table-success fw-semibold rounded px-2 py-1' : '' }}">
                                            @if ($d->approved3By)
                                                {{ $d->approved3By->name }} <br>
                                                <small>{{ $d->approved3_on }}</small>
                                            @else
                                                -
                                            @endif
                                        </td>

                                        {{-- Action --}}
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item"
                                                        href="{{ route('client-families.index', ['client_id' => $d->id]) }}">
                                                        <i class="bx bxs-group me-1"></i> Add Family
                                                    </a>

                                                    <a class="dropdown-item"
                                                        href="{{ route('client-banks.index', ['client_id' => $d->id]) }}">
                                                        <i class="bx bxs-bank me-1"></i> Add Banks
                                                    </a>

                                                    <a class="dropdown-item" href="{{ route('clients.edit', $d->id) }}">
                                                        <i class="bx bx-edit-alt me-1"></i> Edit
                                                    </a>

                                                    <a class="dropdown-item" href="{{ route('clients.show', $d->id) }}">
                                                        <i class="bx bx-show me-1"></i> View
                                                    </a>

                                                    <hr>

                                                    <form action="{{ route('clients.destroy', $d->id) }}" method="POST"
                                                        onsubmit="return confirmDelete()">
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
                                @empty
                                    <tr>
                                        <td colspan="11" class="text-center text-muted">No records found</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
