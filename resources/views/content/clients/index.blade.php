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
                                    <th>client-code</th>
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
                                        <td>{{ $d->client_code }}</td>
                                        <td>{{ strtoupper($d->name) }}</td>
                                        <td>{{ $d->pan_no ?? '' }}</td>
                                        <td>{{ $d->aadhar_no ?? '' }}</td>
                                        <td>{{ $d->mobile_no ?? '' }}</td>
                                        <td class="email">{{ strtolower($d->email ?? '') }}</td>
                                        <td class="text-truncate" style="max-width: 250px;" data-bs-toggle="tooltip"
                                            title="{{ strtoupper($d->res_address) }}">
                                            {{ \Illuminate\Support\Str::limit(strtoupper($d->res_address), 200) }}
                                        </td>


                                        <td>

                                            @if ($d->families->count() > 0)
                                                <a href="{{ route('client-families.index', ['client_id' => $d->id]) }}"
                                                    class="btn btn-sm btn-info">
                                                    View Family Info
                                                </a>
                                            @else
                                                <button type="button" class="btn btn-sm btn-secondary" disabled>
                                                    No Family Info
                                                </button>
                                            @endif

                                        </td>

                                        <td>
                                            @if ($d->banks->count() > 0)
                                                <a href="{{ route('client-banks.index', ['client_id' => $d->id]) }}"
                                                    class="btn btn-sm btn-warning">
                                                    View Bank Info
                                                </a>
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
                                                    <a class="dropdown-item"
                                                        href="{{ route('client-families.index', ['client_id' => $d->id]) }}">
                                                        <i class="bx bxs-group me-1"></i>
                                                        Add Family
                                                    </a>
                                                    <a class="dropdown-item edit-btn"
                                                        href="{{ route('clients.edit', $d->id) }}">
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


    </div>
@endsection

@push('scripts')
@endpush
