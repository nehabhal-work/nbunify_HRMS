@extends('layouts.master-layout')

@section('content')
    <div>
        @if (session('success'))
            <x-alert type="success" :message="session('success')" />
        @endif

        @if (session('error'))
            <x-alert type="danger" :message="session('error')" />
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
        <span class="text-muted fw-light">Master /</span> Ledger
    </h4>


    <div class="row">
        <div class="card p-5">
            <!-- Filter Section -->
            <div class="container filter-section mb-3">
                <form id="filterForm">
                    @csrf
                    @method('post')

                    <div class="row g-3 align-items-end mb-3">
                        <!-- Type Dropdown -->
                        <div class="col-md-3">
                            <label for="filterType" class="form-label">Type</label>
                            <select id="filterType" name="type" class="form-select">
                                <option value="">-- Select --</option>
                                <option value="purchase">Purchase</option>
                                <option value="sales">Sales</option>
                                <option value="exp-voucher">Expenses</option>
                                <option value="po">Purchase-order</option>
                                <option value="bank">Bank</option>
                            </select>
                        </div>

                        <!-- Financial Year Dropdown -->
                        <div class="col-md-3">
                            <label for="financialYear" class="form-label">Financial Year</label>
                            <select id="financialYear" name="financial_year" class="form-select">
                                <option value="all">All</option>
                                <option value="2526" selected>2025-26</option>
                                <option value="2425">2024-25</option>
                                <option value="2324">2023-24</option>
                            </select>
                        </div>

                        <!-- From Date -->
                        <div class="col-md-2">
                            <label for="fromDate" class="form-label">From Date</label>
                            <input type="date" class="form-control" id="fromDate" name="from_date">
                        </div>

                        <!-- To Date -->
                        <div class="col-md-2">
                            <label for="toDate" class="form-label">To Date</label>
                            <input type="date" class="form-control" id="toDate" name="to_date">
                        </div>

                        <!-- Filter Button -->
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">Filter</button>
                        </div>
                    </div>

                    <div class="row">
                        <div id="divVendorClient" class="col-md-3 d-none">
                            <label id="labelVendorClient" for="vendorClient" class="form-label">
                                {{-- auto load --}}
                            </label>
                            <select id="vendorClient" name="vendorClient" class="form-select">
                                <option value="" selected>All</option>
                                {{-- auto load from ajax --}}
                            </select>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Table Section -->
            <div class="container ">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped text-center bg-secondary-subtle" id="resultTable">
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Date</th>
                                <th>Particular</th>
                                <th>bill Amount</th>
                                <th>CGST</th>
                                <th>SGST</th>
                                <th>IGST</th>
                                <th>Net Amount (₹)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data rows go here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <!-- JS Script -->
    <script>
        // Handle form submission with AJAX
        $('#filterForm').on('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            $.ajax({
                url: '#',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log('ajax response', response);
                    const tbody = $('#resultTable tbody');
                    tbody.empty();

                    if (!response.data || response.data.length === 0) {
                        tbody.append('<tr><td colspan="8" class="text-center">No data found</td></tr>');
                        return;
                    }

                    response.data.forEach((item, index) => {
                        let gstDetails = '';

                        if (Array.isArray(item.GstPurchaseDetail)) {
                            item.GstPurchaseDetail.forEach(detail => {
                                let particular = detail.particular || '';
                                let qty = parseFloat(detail.quantity || 0);
                                let rate = parseFloat(detail.rate || 0);
                                let total = (qty * rate).toFixed(2);

                                gstDetails +=
                                    `<div>${particular} &nbsp; ${qty} × ${rate} = ${total}</div>`;
                            });
                        }

                        tbody.append(`
        <tr>
          <td>${index + 1}</td>
          <td>${item.invbilldt}</td>
          <td>
            ${item.vendor.name || ''}
            ${gstDetails}
          </td>
          <td>${item.sumBillAmt}</td>
          <td>${item.sumCgst}</td>
          <td>${item.sumSgst}</td>
          <td>${item.sumIgst}</td>
          <td>${item.sumTotalAmt}</td>
        </tr>
      `);
                    });
                },
                error: function() {
                    alert("Error fetching data.");
                }
            });



        });
    </script>

    <script>
        $(document).ready(function() {
            $('#filterType').on('change', function() {
                const selectedType = $(this).val();
                console.log('Selected Type:', selectedType);

                if (selectedType !== '') {
                    if (selectedType === 'sales') {
                        console.log('');
                        $('#divVendorClient').removeClass('d-none'); // show the div
                        $('#labelVendorClient').text('Client'); // update label
                        $('#vendorClient').empty().append('<option value="">Select client</option>');

                    } else if (selectedType === 'purchase' || selectedType === 'expenses') {
                        console.log('Selected Type is purchase or expenses');
                        $('#divVendorClient').removeClass('d-none'); // show the div
                        $('#labelVendorClient').text('Vendor'); // update label
                        $('#vendorClient').empty().append('<option value="">Select vendor</option>');
                    } else if (selectedType === 'bank') {
                        $('#divVendorClient').removeClass('d-none'); // show the div
                        $('#labelVendorClient').text('Bank'); // update label
                        $('#vendorClient').empty().append('<option value="">Select Bank</option>');

                    } else {
                        console.log('Selected Type is not sales, purchase, or expenses');
                        $('#divVendorClient').addClass('d-none'); // hide the div if no valid type selected
                    }


                    $.ajax({
                        url: '#', // replace with your route
                        method: 'GET',
                        data: {
                            type: selectedType,
                            _token: $('meta[name="csrf-token"]').attr('content') // CSRF token
                        },
                        success: function(response) {

                            console.log('Response:', response);
                            $.each(response, function(key, value) {
                                $('#vendorClient').append('<option value="' + key +
                                    '">' + value + '</option>');
                            });
                        },
                        error: function() {
                            alert('Failed to fetch data');
                        }
                    });
                } else {
                    $('#vendorClient').empty().append('<option value="">Select vendor</option>');
                }
            });
        });
    </script>
@endpush
