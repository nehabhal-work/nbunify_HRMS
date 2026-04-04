@extends('layouts.master-layout')

@section('content')
    <div class="container mt-4">

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Company Details</h5>
            </div>

            <div class="card-body">

                {{-- Basic Info --}}
                <div class="row mb-3">
                    <div class="col-md-3"><strong>Name:</strong></div>
                    <div class="col-md-3">{{ $company->name }}</div>

                    <div class="col-md-3"><strong>Legal Name:</strong></div>
                    <div class="col-md-3">{{ $company->legal_name }}</div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3"><strong>Type:</strong></div>
                    <div class="col-md-3">{{ strtoupper($company->company_type) }}</div>

                    <div class="col-md-3"><strong>Website:</strong></div>
                    <div class="col-md-3">
                        <a href="{{ $company->website }}" target="_blank">{{ $company->website }}</a>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3"><strong>Email:</strong></div>
                    <div class="col-md-3">{{ $company->email }}</div>

                    <div class="col-md-3"><strong>Mobile:</strong></div>
                    <div class="col-md-3">{{ $company->mobile }}</div>
                </div>

                {{-- Address --}}
                <hr>
                <h6 class="mb-3">Registered Address</h6>

                <div class="row mb-3">
                    <div class="col-md-6">
                        {{ $company->reg_address_line1 }},
                        {{ $company->reg_address_line2 }},
                        {{ $company->reg_city }},
                        {{ $company->reg_state }},
                        {{ $company->reg_country }} - {{ $company->reg_pincode }}
                    </div>
                </div>

                {{-- Compliance --}}
                <hr>
                <h6 class="mb-3">Compliance Details</h6>

                <div class="row mb-2">
                    <div class="col-md-3"><strong>PAN:</strong></div>
                    <div class="col-md-3">{{ $company->pan_no }}</div>

                    <div class="col-md-3"><strong>GSTIN:</strong></div>
                    <div class="col-md-3">{{ $company->gstin }}</div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-3"><strong>CIN:</strong></div>
                    <div class="col-md-3">{{ $company->cin_no }}</div>

                    <div class="col-md-3"><strong>TAN:</strong></div>
                    <div class="col-md-3">{{ $company->tan_no }}</div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-3"><strong>Udyam No:</strong></div>
                    <div class="col-md-3">{{ $company->udyam_aadhar_no }}</div>

                    <div class="col-md-3"><strong>MSME:</strong></div>
                    <div class="col-md-3">{{ $company->msme_certification_no }}</div>
                </div>

                {{-- Logo --}}
                @if ($company->logo)
                    <hr>
                    <h6 class="mb-3">Company Logo</h6>
                    <img src="{{ asset('storage/' . $company->logo) }}" width="120">
                @endif

            </div>
        </div>

        {{-- Head Offices --}}
        <div class="card shadow-sm mt-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">Head Offices</h5>
            </div>

            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Code</th>
                            <th>Email</th>
                            <th>City</th>
                            <th>State</th>
                            <th>Pincode</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($company->headOffices as $office)
                            <tr>
                                <td>{{ $office->name }}</td>
                                <td>{{ $office->code }}</td>
                                <td>{{ $office->email }}</td>
                                <td>{{ $office->city }}</td>
                                <td>{{ $office->state }}</td>
                                <td>{{ $office->pincode }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Bank Details --}}
        <div class="card shadow-sm mt-4">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Bank Details</h5>
            </div>

            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Bank</th>
                            <th>Branch</th>
                            <th>IFSC</th>
                            <th>Account No</th>
                            <th>Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($company->companyBank as $bank)
                            <tr>
                                <td>{{ $bank->bank_name }}</td>
                                <td>{{ $bank->branch_name }}</td>
                                <td>{{ strtoupper($bank->ifsc_code) }}</td>
                                <td>{{ $bank->account_number }}</td>
                                <td>{{ ucfirst($bank->account_type) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
