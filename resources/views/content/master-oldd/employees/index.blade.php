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
            <span class="text-muted fw-light">Master /</span> Employees List
        </h4>
    </div>
    {{-- {{ $employees }} --}}
    <div class="row">
        <!-- TABLE SECTION -->

        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Employees List</h5>
                    <a class="btn btn-primary" href="{{ route('master.employees.create') }}" role="button">Add New</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table srkdataTable ">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Branch</th>
                                    <th>Phone</th>
                                    {{-- <th>Email</th> --}}
                                    <th>designation</th>
                                    <th>login id</th>
                                    <th>status</th>
                                    <th>rights</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employees as $index => $emp)
                                    <tr>
                                        <td>
                                            <a href="{{ route('master.employees.edit', $emp->id) }}"
                                                class="text-decoration-none text-reset">
                                                {{ $index + 1 }}
                                            </a>
                                        </td>
                                        <td>{{ $emp->name }}</td>

                                        <td>{{ $emp->branch->name ?? '-' }}</td>

                                        <td>{{ $emp->phone ?? '-' }}</td>

                                        {{-- <td>{{ $emp->email ?? '-' }}</td> --}}

                                        <td>{{ $emp->designation->name ?? '-' }}</td>
                                        <td>login id</td>
                                        <td>status</td>
                                        <td>rights</td>

                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item"
                                                        href="{{ route('master.employees.edit', $emp->id) }}">
                                                        <i class="bx bx-edit-alt me-1"></i> Edit
                                                    </a>
                                                    <a class="dropdown-item"
                                                        href="{{ route('master.employees.show', $emp->id) }}">
                                                        <i class="bx bx-show-alt me-1"></i> view
                                                    </a>
                                                    <a class="dropdown-item"
                                                        href="{{ route('master.employees.hr-letter', ['type' => 'appointment', 'id' => $emp->id]) }}">
                                                        <i class="bx bx-briefcase me-1"></i>
                                                        Appointment Letter
                                                    </a>
                                                    <a class="dropdown-item"
                                                        href="{{ route('master.employees.hr-letter', ['type' => 'offer', 'id' => $emp->id]) }}">
                                                        <i class="bx bx-gift me-1"></i>
                                                        Offer Letter
                                                    </a>
                                                    <a class="dropdown-item"
                                                        href="{{ route('master.employees.hr-letter', ['type' => 'confirmation', 'id' => $emp->id]) }}">
                                                        <i class="bx bx-check-shield me-1"></i>
                                                        Confirmation Letter
                                                    </a>
                                                    <a class="dropdown-item"
                                                        href="{{ route('master.employees.hr-letter', ['type' => 'experience', 'id' => $emp->id]) }}">
                                                        <i class="bx bx-book me-1"></i> Experience Letter
                                                    </a>
                                                    <a class="dropdown-item"
                                                        href="{{ route('master.employees.hr-letter', ['type' => 'relieving', 'id' => $emp->id]) }}">
                                                        <i class="bx bx-log-out me-1"></i>
                                                        Relieving Letter
                                                    </a>
                                                    <a class="dropdown-item"
                                                        href="{{ route('master.employees.hr-letter', ['type' => 'salary-increment', 'id' => $emp->id]) }}">
                                                        <i class="bx bx-trending-up me-1"></i>Salary Increment Letter
                                                    </a>



                                                    <form action="{{ route('master.employees.destroy', $emp->id) }}"
                                                        method="POST" onsubmit="return confirm('Are you sure?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item">
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
