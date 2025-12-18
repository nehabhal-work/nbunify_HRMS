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
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Investment List</h5>
                    <a class="btn btn-primary" href="{{ route('investment.els.create') }}" role="button">Add New</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table srkdataTable">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Investment Date</th>
                                    <th>Client Name</th>
                                    <th>Scheme Name</th>
                                    <th>Investment Amount</th>
                                    <th>Tenure</th>
                                    <th>Frequency</th>
                                    <th>ROI (%)</th>
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

                            {{-- <tr>
                                    <td>1</td>
                                    <td>15 Jan 2025</td>
                                    <td>Mr. Rajesh Sharma</td>
                                    <td>Monthly Growth Plan</td>
                                    <td>₹50,000</td>
                                    <td>1 Year</td>
                                    <td>Monthly</td>
                                    <td>12.5%</td>
                                    <td><span class="badge bg-secondary">INACTIVE</span></td>
                                    <td>Neha Bhalerao</td>
                                    <td>13.5%</td>
                                    <td><span class="badge bg-primary">View Bank Instrument</span></td>
                                    <td><span class="badge bg-secondary">Not Set</span></td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="#"><i class="bx bx-edit-alt me-1"></i>
                                                    View </a>

                                                <a class="dropdown-item" href="{{ route('investment.merge') }}"><i
                                                        class="bx bx-edit-alt me-1"></i>
                                                    Merge </a>
                                                <a class="dropdown-item" href="{{ route('investment.claim') }}"><i
                                                        class="bx bx-edit-alt me-1"></i>
                                                    Claim </a>
                                                <a class="dropdown-item" href="{{ route('investment.maturity') }}"><i
                                                        class="bx bx-edit-alt me-1"></i>
                                                    Maturity </a>
                                                <a class="dropdown-item" href="{{ route('investment.maturity-letter') }}"><i
                                                        class="bx bx-edit-alt me-1"></i>
                                                    Maturity-letter </a>

                                            </div>
                                        </div>
                                    </td>
                                </tr> --}}
                            <tbody>
                                @foreach ($investments as $index => $d)
                                    <tr>
                                        <!-- # -->
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ \Carbon\Carbon::parse($d->investment_date)->format('d M Y') }}</td>
                                        <td>
                                            <b>
                                                <a href="{{ route('investment.els.show', $d->id) }}"
                                                    class="text-decoration-none">
                                                    {{ ucfirst($d->firstClient->name ?? '-') }}
                                                </a>
                                            </b>
                                        </td>
                                        <td>{{ $d->scheme->scheme_name ?? '-' }}</td>
                                        <td>₹{{ number_format($d->investment_amount, 2) }}</td>
                                        <td>{{ $d->tenure_count }} {{ ucfirst($d->tenure_type) }}</td>


                                        <td> {{ ucfirst($d->frequency) }}</td> <!-- Frequency -->
                                        <td>{{ $d->roi_percent . '+' . $d->additional_roi_percent }}%</td><!-- ROI -->
                                        <td>show after approval</td>
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
                                                        href="{{ route('investment.els.show', $d->id) }}">
                                                        <i class="bx bx-show me-1"></i> View
                                                    </a>


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
                                                        href="{{ route('investment.clients.welcomeLetter', $d->id) }}">
                                                        <i class="bx bx-show me-1"></i> Welcome letter
                                                    </a>

                                                    <a class="dropdown-item"
                                                        href="{{ route('investment.maturity-letter', $d->id) }}">
                                                        <i class="bx bx-envelope me-1"></i> Maturity Letter
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
