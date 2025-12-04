@extends('layouts.master-layout')
@section('title', 'Investment')

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
        <span class="text-muted fw-light">Master /</span> <a href="{{ route('investment.els.create') }}">B'day list'</a>
    </h4>



    <div class="row">

        <div class="container my-5">

            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="fw-bold">🎂 Client Birthday List</h3>
                <button class="btn btn-primary">
                    <i class="bi bi-download"></i> Export List
                </button>
            </div>

            <!-- Table -->
            <div class="card shadow-sm">
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Client Name</th>
                                    <th>DOB</th>
                                    <th>Age</th>
                                    <th>Mobile</th>
                                    <th>Category</th>
                                    <th>Birthday Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>

                                <!-- Record 1 -->
                                <tr>
                                    <td>1</td>
                                    <td><strong>Mr. Rahul Sharma</strong></td>
                                    <td>05 Dec 1990</td>
                                    <td>34</td>
                                    <td>9876543210</td>
                                    <td>Own Client</td>
                                    <td>
                                        <span class="badge bg-success">Today 🎉</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-send"></i> Send Wish
                                        </button>
                                    </td>
                                </tr>

                                <!-- Record 2 -->
                                <tr>
                                    <td>2</td>
                                    <td><strong>Mrs. Kavita Patil</strong></td>
                                    <td>08 Dec 1985</td>
                                    <td>39</td>
                                    <td>9823456789</td>
                                    <td>Family Member</td>
                                    <td>
                                        <span class="badge bg-warning text-dark">Upcoming</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary">Send Wish</button>
                                    </td>
                                </tr>

                                <!-- Record 3 -->
                                <tr>
                                    <td>3</td>
                                    <td><strong>Mr. Suresh Kulkarni</strong></td>
                                    <td>25 Nov 1978</td>
                                    <td>46</td>
                                    <td>9876001122</td>
                                    <td>Other Investor</td>
                                    <td>
                                        <span class="badge bg-secondary">Passed</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary">Send Wish</button>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>


    </div>


@endsection
