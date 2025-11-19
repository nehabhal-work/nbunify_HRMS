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
            <span class="text-muted fw-light">Master /</span> <a href="{{ route('clients.create') }}">Client</a>
        </h4>
    </div>

    <div class="row">
        <!-- TABLE SECTION -->
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Client List</h5>
                    <a class="btn btn-primary" href="{{ route('clients.create') }}" role="button">Add New</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table srkdataTable">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Client name</th>
                                    <th>pan no</th>
                                    <th>addhar no</th>
                                    <th>phone</th>
                                    <th>Email</th>
                                    <th>address</th>
                                    <th>Family info</th>
                                    <th>bank info</th>
                                    <th>action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($clients as $d)
                                    <tr>
                                        <td>{{ $d->id }}</td>
                                        <td>{{ strtoupper($d->name) }}</td>
                                        <td>{{ $d->pan_no }}</td>
                                        <td>{{ $d->aadhar_no }}</td>
                                        <td>{{ $d->mobile_no }}</td>
                                        <td>{{ $d->email }}</td>
                                        <td>{{ strtoupper($d->res_address) }}</td>

                                        <td>

                                            @if ($d->banks->count() > 0)
                                                <a href="{{ route('client-families.index', ['client_id' => $d->id]) }}"
                                                    class="btn btn-sm btn-info">
                                                    View Family Info
                                                @else
                                                    <button type="button" class="btn btn-sm btn-secondary" disabled>
                                                        No Family Info
                                                    </button>
                                            @endif
                                        </td>

                                        <td>
                                            @if ($d->banks->count() > 0)
                                                <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                                    data-bs-target="#bankmodal{{ $d->id }}">
                                                    View Bank Info
                                                </button>
                                            @else
                                                <button type="button" class="btn btn-sm btn-secondary" disabled>
                                                    No Bank Info
                                                </button>
                                            @endif
                                        </td>

                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="{{ route('clients.edit', $d->id) }}">
                                                        <i class="bx bx-edit-alt me-1"></i> Edit
                                                    </a>
                                                    <a class="dropdown-item" href="{{ route('clients.show', $d->id) }}">
                                                        <i class="bx bx-show me-1"></i> View
                                                    </a>

                                                    <form action="{{ route('clients.destroy', $d->id) }}" method="post"
                                                        onsubmit="return confirmDelete()">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger delete-btn">
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

        <!-- Bank Info Modal (Separate) -->
        {{-- @foreach ($clients as $d)
            <div class="modal fade" id="bankmodal{{ $d->id }}" tabindex="-1"
                aria-labelledby="bankmodalLabel{{ $d->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: #ead3ff;">
                            <h5 class="modal-title" id="bankmodalLabel{{ $d->id }}">
                                Bank Information - {{ $d->name }}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            @if ($d->banks->count() > 0)
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>IFSC</th>
                                            <th>Account No</th>
                                            <th>Bank Name</th>
                                            <th>Branch</th>
                                            <th>Bank Code</th>
                                            <th>Primary</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($d->banks as $b)
                                            <tr>
                                                <td class="text-uppercase"><b>{{ $b->ifsc_code ?? '-' }}</b></td>
                                                <td><b>{{ $b->account_number ?? '-' }}</b></td>
                                                <td><b>{{ $b->bank_name ?? '-' }}</b></td>
                                                <td><b>{{ $b->branch_name ?? '-' }}</b></td>
                                                <td><b>{{ $b->bank_code ?? '-' }}</b></td>
                                                <td><b>{{ $b->is_primary ? 'Yes' : 'No' }}</b></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p class="text-muted">No bank details found for this client.</p>
                            @endif
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach --}}
    </div>
@endsection
