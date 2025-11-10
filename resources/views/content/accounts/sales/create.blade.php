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

    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Accounts /</span> <a href="{{ route('accounts.sales.index') }}">Sales</a>
    </h4>


    <form action="{{ route('accounts.sales.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('post')
        <div class="row align-items-stretch">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Sales Information</h5>
                        <small class="text-muted float-end">sales Basic Details</small>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Financial Year</label>

                                @php
                                    $today = date('Y-m-d');
                                    $currentYear = date('Y');
                                @endphp

                                <!-- FY Dropdown -->
                                <select class="form-select uppercase gstrate @error('financialYear.*') is-invalid @enderror"
                                    id="financialYearSelect" name="financialYear[]" aria-label="Select FY" required>
                                    @for ($i = 0; $i < 4; $i++)
                                        @php
                                            $fromYear = $currentYear - $i;
                                            $toYear = $fromYear + 1;
                                        @endphp
                                        <option value="{{ $fromYear }}-{{ $toYear }}"
                                            {{ old('financialYear.0') == "$fromYear-$toYear" ? 'selected' : '' }}>
                                            {{ $fromYear }}-{{ $toYear }}
                                        </option>
                                    @endfor
                                </select>

                                @error('financialYear.*')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-100"></div>
                            <div id="divVendolList" class="col-md-4 mb-3">
                                <label class="form-label" for="vehicleno">Client Name</label>
                                <select id="vendorid" name="vendorid"
                                    class="form-select uppercase @error('vendorid') is-invalid @enderror" required>
                                    <option value="">Select..</option>
                                   
                                </select>
                                @error('vendorid')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <a href="{{ route('accounts.vendors.create') }}" class="text-info d-block mt-1" id="toggleNewBranch">
                                    Create new client if not exist
                                </a>
                            </div>

                            @php
                                $today = date('Y-m-d');
                                $month = date('n');
                                $year = date('Y');
                                $fyStart = ($month < 4 ? $year - 1 : $year) . '-04-01';
                            @endphp

                            <div id="divBilldt" class="col-md-2 mb-3">
                                <label class="form-label" for="billdate">Bill Date</label>
                                <input type="date" id="billdate" name="billdate"
                                    class="form-control @error('billdate') is-invalid @enderror"
                                    value="{{ old('billdate') }}" required>
                                @error('billdate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-container mt-3">
                                <h5 class="record-heading"></h5>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Particular</label>
                                        <input type="text"
                                            class="form-control particular @error('particular.*') is-invalid @enderror"
                                            maxlength="100" name="particular[]" placeholder=""
                                            value="{{ old('particular.0') }}">
                                        @error('particular.*')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-2 mb-3 form-group d-none">
                                        <label class="form-label">HSN / SAC</label>
                                        <input type="text" class="form-control hsn @error('hsn.*') is-invalid @enderror"
                                            maxlength="15" name="hsn[]" placeholder="" value="{{ old('hsn.0') }}">
                                        @error('hsn.*')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-2 mb-3">
                                        <label class="form-label">Amount</label>
                                        <input type="text"
                                            class="form-control amount @error('amount.*') is-invalid @enderror"
                                            maxlength="15" name="amount[]" placeholder="" value="{{ old('amount.0') }}">
                                        @error('amount.*')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-2 mb-3">
                                        <label class="form-label">Quantity</label>
                                        <input type="text"
                                            class="form-control quantity @error('quantity.*') is-invalid @enderror"
                                            maxlength="15" name="quantity[]" placeholder=""
                                            value="{{ old('quantity.0') }}">
                                        @error('quantity.*')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-2 mb-3">
                                        <label class="form-label">Bill Amount</label>
                                        <input type="text"
                                            class="form-control billamt bg-secondary-subtle @error('billamt.*') is-invalid @enderror"
                                            maxlength="15" name="billamt[]" placeholder="" value="{{ old('billamt.0') }}">
                                        @error('billamt.*')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-2 mb-3 form-group d-none">
                                        <label class="form-label">GST Rate</label>
                                        <select
                                            class="form-select uppercase gstrate bg-secondary-subtle @error('gstrate.*') is-invalid @enderror"
                                            name="gstrate[]" aria-label="Default select example">
                                            <option value="">GST Rate</option>
                                            <option value="5" {{ old('gstrate.0') == '5' ? 'selected' : '' }}>5%
                                            </option>
                                            <option value="12" {{ old('gstrate.0') == '12' ? 'selected' : '' }}>12%
                                            </option>
                                            <option value="18" {{ old('gstrate.0') == '18' ? 'selected' : '' }}>18%
                                            </option>
                                            <option value="28" {{ old('gstrate.0') == '28' ? 'selected' : '' }}>28%
                                            </option>
                                            <option value="0" {{ old('gstrate.0') == '0' ? 'selected' : '' }}>0%
                                            </option>
                                        </select>
                                        @error('gstrate.*')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-2 mb-3 form-group d-none">
                                        <label class="form-label">CGST</label>
                                        <input type="text"
                                            class="form-control cgst bg-secondary-subtle @error('cgst.*') is-invalid @enderror"
                                            maxlength="10" name="cgst[]" placeholder="" readonly
                                            value="{{ old('cgst.0') }}">
                                        @error('cgst.*')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-2 mb-3 form-group d-none">
                                        <label class="form-label">SGST</label>
                                        <input type="text"
                                            class="form-control sgst bg-secondary-subtle @error('sgst.*') is-invalid @enderror"
                                            maxlength="10" name="sgst[]" placeholder="" readonly
                                            value="{{ old('sgst.0') }}">
                                        @error('sgst.*')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-2 mb-3 igst-container d-none">
                                        <label class="form-label">IGST</label>
                                        <input type="text"
                                            class="form-control igst bg-secondary-subtle @error('igst.*') is-invalid @enderror"
                                            maxlength="10" name="igst[]" placeholder="" readonly
                                            value="{{ old('igst.0') }}">
                                        @error('igst.*')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-2 mb-3 form-group d-none">
                                        <label class="form-label">GST Amount</label>
                                        <input type="text"
                                            class="form-control gstamt bg-secondary-subtle @error('gstamt.*') is-invalid @enderror"
                                            maxlength="10" name="gstamt[]" placeholder="" readonly
                                            value="{{ old('gstamt.0') }}">
                                        @error('gstamt.*')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-2 mb-3">
                                        <label class="form-label">Total Amount</label>
                                        <input type="text"
                                            class="form-control totalamt bg-secondary-subtle @error('totalamt.*') is-invalid @enderror"
                                            maxlength="30" name="totalamt[]" placeholder="" readonly
                                            value="{{ old('totalamt.0') }}">
                                        @error('totalamt.*')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-2 mb-3 remove-row-btn d-flex align-items-end d-none">
                                        <button type="button"
                                            class="btn btn-sm btn-outline-danger remove-row">Remove</button>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-12 my-3">
                                <button type="button" id="addMore" class="btn btn-info">Add More</button>
                            </div>


                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 ">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Image Section</h5>
                        <small class="text-muted float-end">Image Information</small>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- File Upload: Company images -->

                            <div class="d-flex flex-wrap">
                                <!-- Left side (TDS + Invoice) -->
                                <div class="col-md-6 pe-md-3">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Apply TDS</label>
                                        <select
                                            class="form-select select2 uppercase @error('tds_percent') is-invalid @enderror"
                                            name="tds_percent" id="tds-percent" required>
                                            <option value="">Select..</option>
                                        </select>
                                        @error('tds_percent')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Invoice Attachment</label>
                                        <div class="input-group">
                                            <input type="file"
                                                class="form-control @error('invoice') is-invalid @enderror"
                                                id="invoice" name="invoice" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                            <button class="btn btn-outline-danger" type="button"
                                                onclick="document.getElementById('invoice').value = ''">✕</button>
                                        </div>
                                        @error('invoice')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Right side (Account Summary) -->
                                <div class="col-md-6 ps-md-3">
                                      <div class="card shadow-sm rounded-3">
                                        <div class="card-body">
                                            <h5 class="mb-3 fw-bold text-secondary text-uppercase">Account Summary</h5>
                                            <table class="table table-bordered">
                                                <tbody>
                                                    <tr>
                                                        <th><strong>Total Quantity</strong></th>
                                                        <td class="text-end"><span id="total-quantity">0.00</span></td>
                                                    </tr>
                                                    <tr>
                                                        <th><strong>Total Bill Amount</strong></th>
                                                        <td class="text-end"><span id="total-amount">0.00</span></td>
                                                    </tr>
                                                    <tr>
                                                        <th><strong> TDS @</strong></th>
                                                        <td class="text-end"><span id="total-tds-amount">0.00</span></td>
                                                    </tr>
                                                    {{-- <tr class="table-light fw-semibold">
                                                        <th><strong>Bill Amount With GST & TDS</strong></th>
                                                        <td class="text-end text-primary fw-bold">
                                                            <span id="final-total-amount">0.00</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th><strong>GST (CGST + SGST)</strong></th>
                                                        <td class="text-end">
                                                            ₹ <span id="total-cgst-amount">0.00</span> + ₹ <span
                                                                id="total-sgst-amount">0.00</span>
                                                        </td>
                                                    </tr>
                                                    <tr class="igst-container d-none">
                                                        <th><strong>Total IGST Amount</strong></th>
                                                        <td class="text-end"><span id="total-igst-amount">0.00</span></td>
                                                    </tr> --}}
                                                    <tr>
                                                        <th><strong>Total GST Amount</strong></th>
                                                        <td class="text-end"><span id="total-gst-amount">0.00</span></td>
                                                    </tr>
                                                    <tr class="table-success fw-semibold">
                                                        <th><strong>Total Net Amount </strong></th>
                                                        <td class="text-end text-success fw-bold">
                                                            <span id="total-net-amount">0.00</span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Submit -->
        <div class="text-end mt-3">
            <button type="submit" class="btn btn-primary px-4">Save</button>
            <a href="{{ route('master.companies.index') }}" class="btn btn-secondary px-4">Cancel</a>
        </div>
    </form>


@endsection

@push('scripts')
    {{-- -------------financial year script---------------- --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const fySelect = document.getElementById("financialYearSelect");
            const billDate = document.getElementById("billdate");

            const today = new Date();
            const todayStr = today.toISOString().split('T')[0];

            const currentFYStart = new Date(today.getMonth() < 3 ? today.getFullYear() - 1 : today.getFullYear(), 3,
                1);
            const currentFYEnd = new Date(currentFYStart.getFullYear() + 1, 2, 31);

            fySelect.addEventListener("change", function() {
                const selected = this.value; // e.g. "2024-2025"
                const [startYear, endYear] = selected.split("-").map(Number);

                const minDate = `${startYear}-04-01`;
                const maxDate = (startYear === currentFYStart.getFullYear()) ? todayStr :
                    `${endYear}-03-31`;

                billDate.min = minDate;
                billDate.max = maxDate;

                // Set today's date only if it's within the range
                if (todayStr >= minDate && todayStr <= maxDate) {
                    billDate.value = todayStr;
                } else {
                    billDate.value = minDate; // fallback to FY start if today isn't in range
                }
            });

            // Trigger change on load
            fySelect.dispatchEvent(new Event('change'));
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#vendorid').select2({
                placeholder: "Search or select a vendor"
            });
        });
    </script>
    {{-- --------------------------------imageee----------------------------------- --}}
    <script>
        $(document).ready(function() {
            $('#invImage').change(function() {
                handleUserPhotoChange(this, 'img_invImage', 'pdf_invImage');
            });
        });
    </script>

    {{-- set gst amt --}}
    <script>
        $(document).ready(function() {
            // Function to calculate GST
            function calculateGST(row, stateId) {
                const billamt = parseFloat(row.find('.billamt').val()) || 0;
                const gstrate = parseFloat(row.find('.gstrate').val()) || 0;


                const gstAmount = (billamt * gstrate) / 100;
                let cgst = 0,
                    sgst = 0,
                    igst = 0;
                if (stateId === 1) {
                    // Intra-state: apply CGST and SGST
                    cgst = gstAmount / 2;
                    sgst = gstAmount / 2;
                    igst = 0;
                } else if (stateId !== 1) {
                    // Inter-state: apply IGST only
                    cgst = 0;
                    sgst = 0;
                    igst = gstAmount;
                }

                row.find('.cgst').val(cgst.toFixed(2));
                row.find('.sgst').val(sgst.toFixed(2));
                row.find('.igst').val(igst.toFixed(2));
                row.find('.gstamt').val(gstAmount.toFixed(2));
                row.find('.totalamt').val(Math.ceil((billamt + gstAmount) * 100) / 100);

            }

            // Calculate Bill Amount and trigger GST calculation
            $(document).on('input', '.amount, .quantity', function() {
                const row = $(this).closest(
                    '.form-container .row'); // Adjusted to select the correct row within the container
                const amount = parseFloat(row.find('.amount').val()) || 0;
                const quantity = parseFloat(row.find('.quantity').val()) || 1;

                const billamt = amount * quantity;
                row.find('.billamt').val(billamt.toFixed(2)); // Update Bill Amount

                const stateId = parseInt($('#vendorid').find(':selected').data('state-id')) || undefined;
                // Trigger GST calculation
                calculateGST(row, stateId);
            });


            // Delegate event for GST Rate dropdown
            $(document).on('change', '.gstrate', function() {
                const stateId = parseInt($('#vendorid').find(':selected').data('state-id')) || undefined;
                const row = $(this).closest(
                    '.form-container .row'); // Adjusted to select the correct row within the container
                calculateGST(row, stateId);
            });


        });
    </script>

    {{-- Clone add more --}}
    <script>
        $(document).ready(function() {
            var recordCount = 1; // Start with 1 since the first row is Service 1

            // Update the heading of the first form-container
            $('.form-container:first .record-heading').text('Service ' + recordCount);

            // When the "Add More" button is clicked
            $('#addMore').click(function() {
                recordCount++; // Increment the record count
                // Clone the form-container (the div containing all input fields)
                var cloned = $('.form-container:first').clone();

                // Clear the input fields and reset dropdowns in the cloned section
                cloned.find('input').val(''); // Clear all input fields
                cloned.find('select').val(''); // Reset all select dropdowns to default

                // Update the cloned row's heading to "Service X"
                cloned.find('.record-heading').text('Service ' + recordCount);

                // Make the "Remove" button visible in the cloned row
                cloned.find('.remove-row-btn').removeClass('d-none');;

                // Append the cloned form and an <hr> separator to the container
                $('#clone-container').append('<hr>').append(cloned);
            });

            // Delegate event for removing rows dynamically
            $(document).on('click', '.remove-row', function() {
                $(this).closest('.form-container').prev('hr').remove(); // Remove <hr>
                $(this).closest('.form-container').remove(); // Remove cloned row

                // Recalculate record numbers
                recordCount--; // Decrease the record count
                $('#clone-container .form-container').each(function(index) {
                    $(this).find('.record-heading').text('Service ' + (index +
                        2)); // Update for each remaining row
                });
            });
        });
    </script>

    {{-- -------------------igst--------------------------- --}}
    <script>
        $(document).ready(function() {
            $('#vendorid').change(function() {
                const stateId = $(this).find(':selected').data('state-id');
                const gstmode = $(this).find(':selected').data('gstmode');

                console.log('stateId:', stateId);
                console.log('gstmode:', gstmode);


                if (gstmode == 'GST') {
                    $('.hsn, .gstrate, .cgst, .sgst, .gstamt').closest('.form-group').removeClass('d-none');
                    if (stateId == "1") {
                        // State ID is 1: Show CGST and SGST, hide IGST
                        $('.cgst, .sgst').closest('.col-md-2').removeClass('d-none');
                        $('.igst-container').addClass('d-none');

                        // Show CGST and SGST total and hide IGST total
                        $('#total-cgst-amount').closest('h4').removeClass('d-none');
                        $('#total-sgst-amount').closest('h4').removeClass('d-none');
                        $('#total-igst-amount').closest('h4').addClass('d-none');
                    } else if (stateId != "1") {
                        // Other states: Show IGST, hide CGST and SGST
                        $('.cgst, .sgst').closest('.col-md-2').addClass('d-none');
                        $('.igst-container').removeClass('d-none');

                        // Show IGST total and hide CGST and SGST totals
                        $('#total-cgst-amount').closest('h4').addClass('d-none');
                        $('#total-sgst-amount').closest('h4').addClass('d-none');
                        $('#total-igst-amount').closest('h4').removeClass('d-none');
                    } else {
                        // When no state is selected, hide all totals
                        $('.cgst, .sgst').closest('.col-md-2').addClass('d-none');
                        $('.igst-container').addClass('d-none');

                        $('#total-cgst-amount').closest('h4').addClass('d-none');
                        $('#total-sgst-amount').closest('h4').addClass('d-none');
                        $('#total-igst-amount').closest('h4').addClass('d-none');
                    }
                } else {
                    $('.hsn, .gstrate, .cgst, .sgst, .gstamt').closest('.form-group').removeClass('d-none');
                }

            });

        });
    </script>

    <script>
        $(document).ready(function() {
            // Function to calculate total of 'amount', 'quantity', 'gstrate', and 'gstamt'
            function calculateTotal() {
                let totalAmount = 0;
                let totalQuantity = 0;
                let totalCgstAmount = 0;
                let totalSgstAmount = 0;
                let totalIgstAmount = 0;
                let totalGstAmount = 0;
                let totalNetAmount = 0;

                // Iterate over each row for calculating the GST amount
                $('.billamt').each(function(index) {
                    let amountValue = parseFloat($(this).val()) || 0; // Amount value
                    totalAmount += amountValue; // Sum of amount
                });

                // Sum the values of the .quantity fields
                $('.quantity').each(function() {
                    let quantityValue = parseInt($(this).val()) || 0;
                    totalQuantity += quantityValue;
                });
                $('.cgst').each(function() {
                    let cgstAmount = parseFloat($(this).val()) || 0;
                    totalCgstAmount += cgstAmount;
                });
                $('.sgst').each(function() {
                    let sgstAmount = parseFloat($(this).val()) || 0;
                    totalSgstAmount += sgstAmount;
                });
                $('.igst').each(function() {
                    let igstAmount = parseFloat($(this).val()) || 0;
                    totalIgstAmount += igstAmount;
                });

                // Sum the values of the GST amount fields
                $('.gstamt').each(function() {
                    let gstAmount = parseFloat($(this).val()) || 0;
                    totalGstAmount += gstAmount;
                });
                $('.totalamt').each(function() {
                    let netAmount = parseFloat($(this).val()) || 0;
                    totalNetAmount += netAmount;
                });

                // Display the totals
                $('#total-amount').text(totalAmount.toFixed(2)); // Format amount to 2 decimals
                $('#total-quantity').text(totalQuantity); // Display total quantity
                $('#total-cgst-amount').text(totalCgstAmount.toFixed(2)); // Display total GST amount
                $('#total-sgst-amount').text(totalSgstAmount.toFixed(2));
                $('#total-igst-amount').text(totalIgstAmount.toFixed(2));
                $('#total-gst-amount').text(totalGstAmount.toFixed(2)); // Display total GST amount
                $('#total-net-amount').text(totalNetAmount.toFixed(2)); // Display total GST amount
                // $('#total-net-amount').text((Math.ceil(totalNetAmount * 100) / 100).toFixed(0));

            }

            // Attach 'keyup' event listener to .amount and .quantity fields
            $(document).on('keyup', '.amount, .quantity', calculateTotal);

            // Attach 'change' event listener to .gstrate dropdowns
            $(document).on('change', '.gstrate', calculateTotal);

            // Call calculateTotal on page load (optional, if there are pre-filled values)
            calculateTotal();
        });
    </script>



    <script>
        $(document).ready(function() {

            function calculateTotal() {
                let totalBillAmt = 0;
                let totalQuantity = 0;
                let totalCgstAmount = 0;
                let totalSgstAmount = 0;
                let totalIgstAmount = 0;

                // Sum bill amounts
                $('.billamt').each(function() {
                    let amountValue = parseFloat($(this).val()) || 0;
                    totalBillAmt += amountValue;
                });

                // Sum quantities
                $('.quantity').each(function() {
                    let quantityValue = parseInt($(this).val()) || 0;
                    totalQuantity += quantityValue;
                });

                // Sum GST parts
                $('.cgst').each(function() {
                    let cgstAmount = parseFloat($(this).val()) || 0;
                    totalCgstAmount += cgstAmount;
                });

                $('.sgst').each(function() {
                    let sgstAmount = parseFloat($(this).val()) || 0;
                    totalSgstAmount += sgstAmount;
                });

                $('.igst').each(function() {
                    let igstAmount = parseFloat($(this).val()) || 0;
                    totalIgstAmount += igstAmount;
                });

                let totalGstAmount = totalCgstAmount + totalSgstAmount + totalIgstAmount;

                // Get selected TDS rate (based on entity type)
                let tdsRateIndi = parseFloat($('select[name="tds_percent"] option:selected').data('indi-tds')) || 0;
                let tdsRateNonIndi = parseFloat($('select[name="tds_percent"] option:selected').data(
                    'nonindi-tds')) || 0;

                let entity_type = $('select[name="vendorid"] option:selected').data('entity_type') || 0;

                let tdsRate = (entity_type == '1') ? tdsRateIndi : tdsRateNonIndi;

                // Calculate TDS amount on totalBillAmt
                let tdsAmount = (totalBillAmt * tdsRate) / 100;

                // Final amount after subtracting TDS
                let billAfterTds = totalBillAmt - tdsAmount;

                // Add total GST to billAfterTds
                let finalAmount = billAfterTds + totalGstAmount;

                // Display results
                $('#total-amount').text(totalBillAmt.toFixed(2));
                $('#total-quantity').text(totalQuantity);
                $('#total-cgst-amount').text(totalCgstAmount.toFixed(2));
                $('#total-sgst-amount').text(totalSgstAmount.toFixed(2));
                $('#total-igst-amount').text(totalIgstAmount.toFixed(2));
                $('#total-gst-amount').text(totalGstAmount.toFixed(2));
                $('#total-tds-amount').text(tdsAmount.toFixed(2));
                $('#final-total-amount').text(finalAmount.toFixed(2));
            }


            // Trigger calculation on changes
            $(document).on('keyup change', '.amount, .quantity, .gstrate, select[name="tds_percent"]',
                calculateTotal);

            // Initial calculation
            calculateTotal();
        });
    </script>
@endpush
