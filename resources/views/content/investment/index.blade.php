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
            {{-- <form method="GET" action="{{ route('investment.els.index') }}">
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
            </form> --}}

            <style>
                .search-panel {
                    background: rgb(255, 238, 204);
                    border-left: 4px solid #0d6efd;
                }
            </style>
            <form method="GET" action="{{ route('investment.els.index') }}">
                <div class="card mb-4 border-0 shadow-sm search-panel">

                    <!-- Search Header -->
                    <div class="card-header bg-transparent border-0 pb-0">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bx bx-filter-alt text-primary fs-5"></i>
                            <h5 class="mb-0 fw-semibold">Search / Filter Investments</h5>
                        </div>
                        <small class="text-muted">
                            Narrow down records using date, scheme, client, or status
                        </small>
                    </div>

                    <!-- Search Body -->
                    <div class="card-body pt-3">
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

                            <!-- Scheme -->
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

                            <!-- Client -->
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
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                                        Pending
                                    </option>
                                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>
                                        Approved
                                    </option>
                                    <option value="matured" {{ request('status') == 'matured' ? 'selected' : '' }}>
                                        Matured
                                    </option>
                                </select>
                            </div>

                            <!-- Buttons -->
                            <div class="col-md-3 d-flex gap-2">
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="bx bx-search"></i> Search
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
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle table-sm srkdataTable">
                                <thead class="table-light text-center">
                                    <tr>
                                        <th hidden>#</th>
                                        <th>Investment Date</th>
                                        <th>Client / Code</th>
                                        <th>Scheme</th>
                                        <th>Amount / ROI</th>
                                        <th>Tenure / Frequency</th>
                                        <th>Status</th>
                                        <th>Created By</th>
                                        <th>Approved 1</th>
                                        <th>Approved 2</th>
                                        <th>Approved 3</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($investments as $index => $d)
                                        <tr>
                                            <td hidden>{{ $index + 1 }}</td>

                                            {{-- Investment Date --}}
                                            <td class="text-nowrap text-center">
                                                {{ \Carbon\Carbon::parse($d->investment_date)->format('d M Y') }}
                                            </td>

                                            {{-- Client / Code --}}
                                            <td>
                                                <a href="{{ route('investment.els.show', $d->id) }}"
                                                    class="fw-semibold text-decoration-none text-dark">
                                                    {{ ucfirst($d->firstClient->name ?? '-') }}
                                                </a>
                                                <div class="text-muted small">
                                                    {{ $d->investment_code ? 'Code: ' . $d->investment_code : '-' }}
                                                </div>
                                            </td>

                                            {{-- Scheme --}}
                                            <td>
                                                <div class="fw-semibold">
                                                    {{ $d->scheme->name_type_value ?? '-' }}
                                                </div>
                                                <div class="text-muted small">
                                                    {{ $d->scheme->scheme_name ?? '-' }}
                                                </div>
                                            </td>

                                            {{-- Amount / ROI --}}
                                            <td class="text-end">
                                                <div class="fw-semibold">
                                                    ₹{{ number_format($d->investment_amount, 2) }}
                                                </div>
                                                <span class="badge bg-info-subtle text-dark">
                                                    ROI {{ $d->roi_percent ?? 0 }}%
                                                </span>
                                            </td>

                                            {{-- Tenure / Frequency --}}
                                            <td>
                                                <div>
                                                    {{ $d->tenure_count }} {{ ucfirst($d->tenure_type) }}
                                                </div>
                                                <span class="badge bg-secondary-subtle text-dark">
                                                    {{ ucfirst($d->frequency) }}
                                                </span>
                                            </td>

                                            {{-- Status --}}
                                            <td class="text-center">
                                                <span
                                                    class="badge
                            {{ $d->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ ucfirst($d->status) }}
                                                </span>
                                                <div class="small text-muted">
                                                    {{ ucfirst($d->action_status) }}
                                                </div>
                                            </td>

                                            {{-- Created By --}}
                                            <td class="text-center">
                                                @if ($d->createdBy)
                                                    <span class="badge bg-warning text-dark">
                                                        {{ $d->createdBy->name }}
                                                    </span>
                                                    <div class="small text-muted mt-1">
                                                        {{ \Carbon\Carbon::parse($d->created_at)->format('d M Y') }}
                                                    </div>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>

                                            {{-- Approved 1 --}}
                                            <td class="text-center">
                                                @if ($d->approvedBy)
                                                    <span class="badge bg-success">
                                                        {{ $d->approvedBy->name }}
                                                    </span>
                                                    <div class="small text-muted mt-1">
                                                        {{ \Carbon\Carbon::parse($d->approved_at)->format('d M Y') }}
                                                    </div>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>

                                            {{-- Approved 2 --}}
                                            <td class="text-center">
                                                @if ($d->approved2By)
                                                    <span class="badge bg-success">
                                                        {{ $d->approved2By->name }}
                                                    </span>
                                                    <div class="small text-muted mt-1">
                                                        {{ \Carbon\Carbon::parse($d->approved2_on)->format('d M Y') }}
                                                    </div>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>

                                            {{-- Approved 3 --}}
                                            <td class="text-center">
                                                @if ($d->approved3By)
                                                    <span class="badge bg-success">
                                                        {{ $d->approved3By->name }}
                                                    </span>
                                                    <div class="small text-muted mt-1">
                                                        {{ \Carbon\Carbon::parse($d->approved3_on)->format('d M Y') }}
                                                    </div>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>

                                            {{-- Actions --}}
                                            <td class="text-center">
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-light dropdown-toggle"
                                                        data-bs-toggle="dropdown">
                                                        Actions
                                                    </button>

                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('investment.els.edit', $d->id) }}">
                                                                ✏️ Edit
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('investment.els.show', $d->id) }}">
                                                                👁 View
                                                            </a>
                                                        </li>

                                                        @if ($d->approved3By)
                                                            <li>
                                                                <a class="dropdown-item"
                                                                    href="{{ route('investment.si.index', ['id' => $d->id]) }}">
                                                                    ✅ Standing Instruction
                                                                </a>
                                                            </li>
                                                        @endif

                                                        <li>
                                                            <hr class="dropdown-divider">
                                                        </li>

                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('investment.merge', $d->id) }}">
                                                                🔀 Merge
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('investment.claim', $d->id) }}">
                                                                💰 Claim
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('investment.maturity', $d->id) }}">
                                                                ⏳ Maturity
                                                            </a>
                                                        </li>

                                                        <li>
                                                            <hr class="dropdown-divider">
                                                        </li>

                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('investment.welcomeLetter', $d->id) }}">
                                                                📩 Welcome Letter
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('investment.maturity-letter', $d->id) }}">
                                                                ✉️ Maturity Letter
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('calculate-investment-parameters', $d->id) }}">
                                                                📅 Payment Schedule
                                                            </a>
                                                        </li>
                                                    </ul>
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


    </div>



@endsection
