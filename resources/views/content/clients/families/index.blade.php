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
            <span class="text-muted fw-light">Master /</span> <a href="{{ route('master.companies.create') }}">Families of
                <span class="text-uppercase">{{ $client->name }}</span></a>
        </h4>
    </div>

    <div class="div d-flex">
        <a href="{{ route('clients.index') }}" class="btn btn-secondary px-4">Go back</a>

    </div>
    <div class="row">
        <!-- TABLE SECTION -->

        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Family List</h5>
                    <div>
                        <a class="btn btn-primary"
                            href="{{ route('client-families.create', ['client_id' => $client->id]) }}" role="button">Add
                            new
                            Family Member</a>
                        <a class="btn btn-primary"
                            href="{{ route('client-families.create.existing', ['client_id' => $client->id]) }}"
                            role="button">Add
                            Family from existing list </a>

                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table srkdataTable ">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>families</th>
                                    <th>relation</th>
                                    <th>DOB</th>
                                    <th>Number</th>
                                    <th>Email</th>
                                     <th>Created By</th>
                                    <th>Approved By</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Example static row (replace with @foreach later) --}}
                                @foreach ($clientFamilies as $key => $d)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $d->name }}</td>
                                        <td>{{ $d->relation->relative_relation . '-' . $d->relation->main_relation }}</td>
                                        <td>{{ $d->dob }}</td>
                                        <td>{{ $d->mobile_no }}</td>
                                        <td>{{ $d->email }}</td>
                                         <td
                                            class="{{ !empty($d->created_by) ? 'table-warning fw-semibold rounded px-2 py-1' : '' }}">
                                            @if (!empty($d->created_by))
                                                {{ $d->created_by . ' - ' . ($d->created_at ?? '-') }}
                                            @else
                                                -
                                            @endif
                                        </td>

                                        <td
                                            class="{{ !empty($d->approved_by) ? 'table-success fw-semibold rounded px-2 py-1' : '' }}">
                                            @if (!empty($d->approved_by))
                                                {{ $d->approved_by . ' - ' . ($d->approved_at ?? '-') }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>

                                                <div class="dropdown-menu">
                                                    <!-- Edit -->
                                                    <a class="dropdown-item"
                                                        href="{{ route('client-families.edit', $d->id) }}">
                                                        <i class="bx bx-edit-alt me-1"></i> Edit
                                                    </a>

                                                    <!-- Delete -->
                                                    <form action="{{ route('client-families.destroy', $d->id) }}"
                                                        method="post" onsubmit="return confirmDelete()">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="client_id" value="{{ $d->client_id }}">
                                                        <button type="submit" class="dropdown-item text-danger delete-btn"
                                                            data-id="{{ $d->id }}">
                                                            <i class="bx bx-trash me-1"></i> Delete
                                                        </button>
                                                    </form>

                                                    <!-- Convert to Client -->
                                                    <a class="dropdown-item text-primary" href="#">
                                                        <i class="bx bx-refresh me-1"></i> Convert to Client
                                                    </a>
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
