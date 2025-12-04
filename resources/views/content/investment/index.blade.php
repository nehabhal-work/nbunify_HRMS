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
                                    <th>Status</th>
                                    <th>Reviewed By</th>
                                    <th>Final ROI (%)</th>

                                    <!-- NEW COLUMNS -->
                                    <th>Bank Instrument</th>
                                    <th>Standing Instruction</th>

                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
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
                                                <a class="dropdown-item" href="{{ route('investment.bank-instrument') }}"><i
                                                        class="bx bx-book-add me-1"></i>
                                                    Add Bank Instrument</a>
                                                <a class="dropdown-item"
                                                    href="{{ route('investment.standing-instruction') }}"><i
                                                        class="bx bx-book-add me-1"></i>
                                                    Add Standing Instruction</a>
                                                <a class="dropdown-item" href="#"><i class="bx bx-edit-alt me-1"></i>
                                                    View </a>
                                                <a class="dropdown-item" href="#"><i class="bx bx-edit-alt me-1"></i>
                                                    Renewal </a>
                                                <a class="dropdown-item" href="#"><i class="bx bx-edit-alt me-1"></i>
                                                    Merge </a>
                                                <a class="dropdown-item" href="#"><i class="bx bx-edit-alt me-1"></i>
                                                    Claim </a>
                                                <a class="dropdown-item" href="#"><i class="bx bx-edit-alt me-1"></i>
                                                    Maturity </a>

                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>01 Feb 2025</td>
                                    <td>Ms. Madhavi Acharya</td>
                                    <td>Elite Yearly Income</td>
                                    <td>₹1,20,000</td>
                                    <td>3 Years</td>
                                    <td>Quarterly</td>
                                    <td>10.0%</td>
                                    <td><span class="badge bg-secondary">INACTIVE</span></td>
                                    <td>Arjun Patil</td>
                                    <td>11.0%</td>
                                    <td><span class="badge bg-secondary">Not Set</span></td>
                                    <td><span class="badge bg-primary">View Standing Instruction</span></td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="#"><i class="bx bx-book-add me-1"></i>
                                                    Add Instruction</a>
                                                <a class="dropdown-item" href="#"><i class="bx bx-edit-alt me-1"></i>
                                                    Update Payout</a>
                                                <a class="dropdown-item" href="#"><i class="bx bx-show me-1"></i> View
                                                    Details</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>3</td>
                                    <td>05 Mar 2025</td>
                                    <td>Mr. Vikas Kulkarni</td>
                                    <td>Wealth Builder Yearly Plan</td>
                                    <td>₹1,00,000</td>
                                    <td>3 Years</td>
                                    <td>Yearly</td>
                                    <td>14.0%</td>
                                    <td><span class="badge bg-secondary">Inactive</span></td>
                                    <td>Director</td>
                                    <td>15.0%</td>
                                    <td><span class="badge bg-secondary">Not Set</span></td>
                                    <td><span class="badge bg-secondary">Not Set</span></td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="#"><i class="bx bx-book-add me-1"></i>
                                                    Add Instruction</a>
                                                <a class="dropdown-item" href="#"><i class="bx bx-edit-alt me-1"></i>
                                                    Update Payout</a>
                                                <a class="dropdown-item" href="#"><i class="bx bx-show me-1"></i> View
                                                    Details</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>4</td>
                                    <td>10 Jan 2025</td>
                                    <td>Mr. Sagar Kulkarni</td>
                                    <td>Premium Fixed Return</td>
                                    <td>₹2,00,000</td>
                                    <td>5 Years</td>
                                    <td>Yearly</td>
                                    <td>13.0%</td>
                                    <td><span class="badge bg-success">Active</span></td>
                                    <td>Priya Nagle</td>
                                    <td>14.5%</td>
                                    <td><span class="badge bg-primary">View Bank Instrument</span></td>
                                    <td><span class="badge bg-primary">View Standing Instruction</span></td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="#"><i class="bx bx-book-add me-1"></i>
                                                    Add Instruction</a>
                                                <a class="dropdown-item" href="#"><i class="bx bx-edit-alt me-1"></i>
                                                    Update Payout</a>
                                                <a class="dropdown-item" href="#"><i class="bx bx-show me-1"></i>
                                                    View
                                                    Details</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>5</td>
                                    <td>28 Jan 2025</td>
                                    <td>Ms. Bhavana Desai</td>
                                    <td>Flexi Income Plus</td>
                                    <td>₹90,000</td>
                                    <td>18 Months</td>
                                    <td>Monthly</td>
                                    <td>12.0%</td>
                                    <td><span class="badge bg-secondary">INACTIVE</span></td>
                                    <td>—</td>
                                    <td>12.5%</td>
                                    <td><span class="badge bg-secondary">Not Set</span></td>
                                    <td><span class="badge bg-secondary">Not Set</span></td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="#"><i
                                                        class="bx bx-book-add me-1"></i> Add Instruction</a>
                                                <a class="dropdown-item" href="#"><i
                                                        class="bx bx-edit-alt me-1"></i> Update Payout</a>
                                                <a class="dropdown-item" href="#"><i class="bx bx-show me-1"></i>
                                                    View Details</a>
                                            </div>
                                        </div>
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
