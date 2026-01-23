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
        <span class="text-muted fw-light">Master /</span> <a href="{{ route('investment.els.create') }}">ELS-Investment</a>
    </h4>



    <div class="row">
        <!-- TABLE SECTION -->

        <div class="col-12">
            <form method="GET" action="{{ route('investment.els.index') }}">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row g-3 align-items-end">

                            <!-- From Date -->
                            <div class="col-md-3">
                                <label class="form-label">From Date</label>
                                <input type="date" name="from_date" class="form-control"
                                    value="{{ request('from_date') }}">
                            </div>

                            <!-- To Date -->
                            <div class="col-md-3">
                                <label class="form-label">To Date</label>
                                <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
                            </div>

                            <!-- Scheme Name -->
                            <div class="col-md-3">
                                <label class="form-label">Scheme</label>
                                <select name="scheme_id" class="form-select">
                                    <option value="">All Schemes</option>
                                    @foreach ($schemes as $scheme)
                                        <option value="{{ $scheme->id }}"
                                            {{ request('scheme_id') == $scheme->id ? 'selected' : '' }}>
                                            {{ $scheme->scheme_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Client Name -->
                            <div class="col-md-3">
                                <label class="form-label">Client Name</label>
                                <input type="text" name="client_name" class="form-control" placeholder="Search client"
                                    value="{{ request('client_name') }}">
                            </div>

                            <!-- Status -->
                            <div class="col-md-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="">All</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending
                                    </option>
                                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>
                                        Approved
                                    </option>
                                    <option value="matured" {{ request('status') == 'matured' ? 'selected' : '' }}>Matured
                                    </option>
                                </select>
                            </div>

                            <!-- Buttons -->
                            <div class="col-md-3 d-flex gap-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bx bx-search"></i> Go
                                </button>

                                <a href="{{ route('investment.els.index') }}" class="btn btn-outline-secondary w-100">
                                    Reset
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </form>
            {{-- {{ $investments }} --}}
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Investment List</h5>
                    <a class="btn btn-primary" href="{{ route('investment.els.create') }}" role="button">Add New</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-sm srkdataTable">
                            <thead class="table-light">
                                <tr>
                                    <th hidden>#</th>
                                    <th>Investment Code</th>
                                    <th>Investment Date</th>
                                    <th>Client Name</th>
                                    <th>Scheme Name</th>
                                    <th>Investment Amt /ROI%</th>
                                    <th>Tenure /Frequency</th>
                                    {{-- <th>Frequency</th> --}}
                                    {{-- <th>ROI (%)</th> --}}
                                    <th>Standing Instruction</th>
                                    <th>Status</th>

                                    <!-- NEW COLUMNS -->
                                    <th>Created By</th>
                                    <th>Approved By 1</th>
                                    <th>Approved By 2</th>
                                    <th>Approved By 3</th>

                                    <th>Actions</th>
                                </tr>
                            </thead>


                            <tbody>
                                @foreach ($investments as $index => $d)
                                    <tr>
                                        <!-- # -->
                                        <td hidden>{{ $index + 1 }}</td>
                                        <td>{{ $d->investment_code }}</td>
                                        <td>{{ \Carbon\Carbon::parse($d->investment_date)->format('d M Y') }}</td>
                                        <td>
                                            <b>
                                                <a href="{{ route('investment.els.show', $d->id) }}"
                                                    class="text-decoration-none">
                                                    <b class="text-black"> {{ ucfirst($d->firstClient->name ?? '-') }}</b>
                                                </a>
                                            </b>
                                        </td>
                                        <td>{{ $d->scheme->scheme_name ?? '-' }}</td>
                                        <td>₹{{ number_format($d->investment_amount, 2) }} <br><b>
                                                {{ ($d->roi_percent ?? 0) . ' + ' . ($d->additional_roi_percent ?? 0) }}%</b>
                                        </td>
                                        <td>{{ $d->tenure_count }} {{ ucfirst($d->tenure_type) }} <br> <b>
                                                {{ ucfirst($d->frequency) }}</b> </td>


                                        {{-- <td> {{ ucfirst($d->frequency) }}</td> <!-- Frequency --> --}}
                                        {{-- <td>{{ $d->roi_percent . '+' . $d->additional_roi_percent }}%</td><!-- ROI --> --}}
                                        <td>pending</td>
                                        <td> {{ $d->staus . '' . $d->action_status }}</td> <!-- Status -->

                                        <td
                                            class="{{ !empty($d->createdBy) ? 'table-warning fw-semibold rounded px-2 py-1' : '' }}">
                                            @if (!empty($d->createdBy))
                                                <div class="d-flex justify-content-center text-center">
                                                    {{ $d->createdBy->name }}
                                                </div>
                                                <br>
                                                {{ $d->created_at ?? '-' }}
                                            @else
                                                -
                                            @endif
                                        </td>

                                        <td
                                            class="{{ !empty($d->approvedBy) ? 'table-success fw-semibold rounded px-2 py-1' : '' }}">
                                            @if (!empty($d->approvedBy))
                                                {{ $d->approvedBy->name }} <br>{{ $d->approved_at ?? '-' }}
                                            @else
                                                -
                                            @endif
                                        </td>

                                        <td
                                            class="{{ !empty($d->approved2By) ? 'table-success fw-semibold rounded px-2 py-1' : '' }}">
                                            @if (!empty($d->approved2By))
                                                {{ $d->approved2By->name }} <br>{{ $d->approved2_on ?? '-' }}
                                            @else
                                                -
                                            @endif
                                        </td>

                                        <td
                                            class="{{ !empty($d->approved3By) ? 'table-success fw-semibold rounded px-2 py-1' : '' }}">
                                            @if (!empty($d->approved3By))
                                                {{ $d->approved3By->name }} <br>{{ $d->approved3_on ?? '-' }}
                                            @else
                                                -
                                            @endif
                                        </td>

                                        <!-- Actions -->
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>

                                                <div class="dropdown-menu">

                                                    <a class="dropdown-item"
                                                        href="{{ route('investment.els.edit', $d->id) }}">
                                                        <i class="bx bx-edit me-1"></i> Edit
                                                    </a>
                                                    <a class="dropdown-item"
                                                        href="{{ route('investment.els.show', $d->id) }}">
                                                        <i class="bx bx-show me-1"></i> View
                                                    </a>

                                                    @if (!empty($d->approved3By))
                                                        <a class="dropdown-item"
                                                            href="{{ route('investment.si.index', ['id' => $d->id]) }}">
                                                            <i class="bx bx-check-circle me-1"></i>
                                                            Standing Instruction {{ $d->id }}
                                                        </a>
                                                    @endif





                                                    <a class="dropdown-item"
                                                        href="{{ route('investment.merge', $d->id) }}">
                                                        <i class="bx bx-git-merge me-1"></i> Merge
                                                    </a>

                                                    <a class="dropdown-item"
                                                        href="{{ route('investment.claim', $d->id) }}">
                                                        <i class="bx bx-money me-1"></i> Claim
                                                    </a>

                                                    <a class="dropdown-item"
                                                        href="{{ route('investment.maturity', $d->id) }}">
                                                        <i class="bx bx-timer me-1"></i> Maturity
                                                    </a>

                                                    <a class="dropdown-item"
                                                        href="{{ route('investment.welcomeLetter', $d->id) }}">
                                                        <i class="bx bx-mail-send me-1"></i> Welcome Letter
                                                    </a>

                                                    <a class="dropdown-item"
                                                        href="{{ route('investment.maturity-letter', $d->id) }}">
                                                        <i class="bx bx-envelope me-1"></i> Maturity Letter
                                                    </a>
                                                    <a class="dropdown-item"
                                                        href="{{ route('calculate-investment-parameters', $d->id) }}">
                                                        <i class="bx bx-calendar-check me-1"></i> Show Payment Schedule
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
