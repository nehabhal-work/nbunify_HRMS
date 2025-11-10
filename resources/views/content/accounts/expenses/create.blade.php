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
        <span class="text-muted fw-light">Accounts /</span> <a href="{{ route('accounts.purchases.index') }}">Puchases</a>
    </h4>


    <form action="{{ route('accounts.purchases.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('post')
        <div class="row align-items-stretch">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Purchase Information</h5>
                        <small class="text-muted float-end">Purchase Basic Details</small>
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
                            <div class="col-md-4">
                                <label class="form-label">Paid To: Employee Name</label>
                                <select name="employee_id" class="form-select @error('employee_id') is-invalid @enderror"
                                    required>
                                    <option value="">Select Employee</option>
                                    @foreach ($resultEmp ?? [] as $emp)
                                        <option value="{{ $emp->id }}">{{ $emp->name ?? 'N/A' }}</option>
                                    @endforeach
                                    <option value="0">Other</option>
                                </select>
                                @error('employee_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mt-2 d-none mb-3" id="otherEmployeeDiv">
                                <label>Enter Other Employee Name</label>
                                <input type="text" name="other_employee_name"
                                    class="form-control @error('other_employee_name') is-invalid @enderror"
                                    placeholder="Enter name">
                                @error('other_employee_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div id="divBilldt" class="col-md-2 mb-3">
                                <label class="form-label" for="voucherdate">Voucher Date</label>
                                <input type="date" class="form-control @error('voucherdate') is-invalid @enderror"
                                    id="voucherdate" name="voucherdate" value="{{ old('voucherdate') }}" required />
                                @error('voucherdate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-container mt-3">
                                <h5 class="record-heading"></h5>
                                <div class="row">

                                    <div class="col-md-3">
                                        <label class="form-label">Category:</label>
                                        <select class="form-select expcategory @error('expcategory.*') is-invalid @enderror"
                                            name="expcategory[]" required>
                                            <option value="">Select</option>
                                            <option>Advertising</option>
                                            <option>Cake</option>
                                            <option>Courier Charges</option>
                                            <option>Electricity Bill</option>
                                            <option>Gifting</option>
                                            <option>Housekeeping</option>
                                            <option>Internet Charges</option>
                                            <option>Marketing Charges</option>
                                            <option>Miscellaneous</option>
                                            <option>Office Exp</option>
                                            <option>Petrol Expenses</option>
                                            <option>Printing and Stationery</option>
                                            <option>Repair and Maintenance</option>
                                            <option>Travelling Exp</option>
                                            <option>Telephone Exp</option>
                                            <option>Snacks</option>
                                            <option>Lunch</option>
                                            <option>Dinner</option>
                                            <option>Drinks</option>
                                            <option>Staff Welfare</option>
                                            <option>Tea</option>
                                            <option>Water Exp</option>
                                            <option value="Other">Other</option>
                                        </select>
                                        @error('expcategory.*')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div id="divNewCategory" class="col-md-3 d-none">
                                        <label class="form-label">New category:</label>
                                        <input type="text"
                                            class="form-control @error('categoryNew.*') is-invalid @enderror"
                                            name="categoryNew[]" />
                                        @error('categoryNew.*')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Particular</label>
                                        <input type="text"
                                            class="form-control particular @error('particular.*') is-invalid @enderror"
                                            maxlength="100" name="particular[]" placeholder="" />
                                        @error('particular.*')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-2 mb-3 form-group">
                                        <label class="form-label">HSN / SAC</label>
                                        <input type="text" class="form-control hsn @error('hsn.*') is-invalid @enderror"
                                            maxlength="15" name="hsn[]" placeholder="" />
                                        @error('hsn.*')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-2 mb-3">
                                        <label class="form-label">Amount</label>
                                        <input type="text"
                                            class="form-control amount onlydigit @error('amount.*') is-invalid @enderror"
                                            maxlength="15" name="amount[]" placeholder="" />
                                        @error('amount.*')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-2 mb-3">
                                        <label class="form-label">Quantity</label>
                                        <input type="text"
                                            class="form-control quantity onlydigit @error('quantity.*') is-invalid @enderror"
                                            maxlength="15" name="quantity[]" placeholder="" />
                                        @error('quantity.*')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-2 mb-3">
                                        <label class="form-label">Bill Amount</label>
                                        <input type="text"
                                            class="form-control billamt onlydigit bg-secondary-subtle @error('billamt.*') is-invalid @enderror"
                                            maxlength="15" name="billamt[]" placeholder="" />
                                        @error('billamt.*')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-2 mb-3 form-group">
                                        <label class="form-label">GST Rate</label>
                                        <select
                                            class="form-select gstrate bg-secondary-subtle @error('gstrate.*') is-invalid @enderror"
                                            name="gstrate[]">
                                            <option value="">GST Rate</option>
                                            <option value="5">5%</option>
                                            <option value="12">12%</option>
                                            <option value="18">18%</option>
                                            <option value="28">28%</option>
                                            <option value="0">0%</option>
                                        </select>
                                        @error('gstrate.*')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-2 mb-3 form-group">
                                        <label class="form-label">CGST</label>
                                        <input type="text"
                                            class="form-control cgst bg-secondary-subtle @error('cgst.*') is-invalid @enderror"
                                            maxlength="10" name="cgst[]" placeholder="" readonly />
                                        @error('cgst.*')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-2 mb-3 form-group">
                                        <label class="form-label">SGST</label>
                                        <input type="text"
                                            class="form-control sgst bg-secondary-subtle @error('sgst.*') is-invalid @enderror"
                                            maxlength="10" name="sgst[]" placeholder="" readonly />
                                        @error('sgst.*')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-2 mb-3 igst-container">
                                        <label class="form-label">IGST</label>
                                        <input type="text"
                                            class="form-control igst bg-secondary-subtle @error('igst.*') is-invalid @enderror"
                                            maxlength="10" name="igst[]" placeholder="" readonly />
                                        @error('igst.*')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-2 mb-3 form-group">
                                        <label class="form-label">GST Amount</label>
                                        <input type="text"
                                            class="form-control gstamt bg-secondary-subtle @error('gstamt.*') is-invalid @enderror"
                                            maxlength="10" name="gstamt[]" placeholder="" readonly />
                                        @error('gstamt.*')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-2 mb-3">
                                        <label class="form-label">Total Amount</label>
                                        <input type="text"
                                            class="form-control totalamt bg-secondary-subtle @error('totalamt.*') is-invalid @enderror"
                                            maxlength="30" name="totalamt[]" placeholder="" readonly />
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
                                    <div class="card shadow-sm rounded-3 h-100">
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
                                                        <th><strong>TDS @</strong></th>
                                                        <td class="text-end"><span id="total-tds-amount">0.00</span></td>
                                                    </tr>

                                                    <tr>
                                                        <th><strong>Total GST Amount</strong></th>
                                                        <td class="text-end"><span id="total-gst-amount">0.00</span></td>
                                                    </tr>

                                                    <tr class="table-success fw-semibold">
                                                        <th><strong>Total Net AMt</strong></th>
                                                        <td class="text-end text-primary fw-bold">
                                                            <span id="final-total-amount">0.00</span>
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
    <script>
        $(document).ready(function() {
            $('#vendorid').select2({
                placeholder: "Search or select a vendor"
            });
        });
    </script>

    <script>
        $('select[name="employee_id"]').on('change', function() {
            if ($(this).val() === '0') {
                $('#otherEmployeeDiv').removeClass('d-none');
            } else {
                $('#otherEmployeeDiv').addClass('d-none');
            }
        });
    </script>
    <script>
        const defaultImg = "{{ asset('/assets/img/pngwing.png') }}";

        $(document).ready(function() {
            $('#invImage').change(function() {
                handleUserPhotoChange(this, 'img_invImage', 'pdf_invImage', 'removeFileBtn1');
            });
        });

        function handleUserPhotoChange(input, imgid, pdfid, removeBtnId) {
            if (input.files && input.files[0]) {
                const file = input.files[0];
                const reader = new FileReader();
                const fileType = file.type;

                const maxSize = 5 * 1024 * 1024; // 5MB
                if (file.size > maxSize) {
                    alert('File size exceeds 5MB');
                    input.value = '';
                    return;
                }

                if (fileType === 'application/pdf') {
                    reader.onload = function(e) {
                        $('#' + imgid).hide();
                        $('#' + pdfid).show();
                        $('#' + removeBtnId).show();

                        const pdfData = e.target.result;
                        const loadingTask = pdfjsLib.getDocument({
                            data: pdfData
                        });

                        loadingTask.promise.then(function(pdf) {
                            pdf.getPage(1).then(function(page) {
                                const scale = 1.5;
                                const viewport = page.getViewport({
                                    scale
                                });

                                const canvas = document.getElementById(pdfid);
                                const context = canvas.getContext('2d');
                                canvas.height = viewport.height;
                                canvas.width = viewport.width;

                                const renderContext = {
                                    canvasContext: context,
                                    viewport: viewport
                                };
                                page.render(renderContext);
                            });
                        });
                    };
                    reader.readAsArrayBuffer(file);
                } else {
                    // Image handling
                    reader.onload = function(e) {
                        $('#' + pdfid).hide();
                        $('#' + imgid).attr('src', e.target.result).show();
                        $('#' + removeBtnId).show();
                    };
                    reader.readAsDataURL(file);
                }
            }
        }

        function removeFile(imgid, pdfid, removeInputId, removeBtnId, inputId) {
            if (confirm('Are you sure you want to delete this file?')) {
                $('#' + imgid).attr('src', defaultImg).show();
                $('#' + pdfid).hide();
                $('#' + removeBtnId).hide();
                $('#' + inputId).val('');
                $('#' + removeInputId).val('1');
            }
        }
    </script>
    <script>
        $(document).ready(function() {
            // Function to calculate GST
            function calculateGST(row) {
                const billamt = parseFloat(row.find('.billamt').val()) || 0;
                const gstrate = parseFloat(row.find('.gstrate').val()) || 0;
                let stateId = 1;

                const gstAmount = (billamt * gstrate) / 100;
                let cgst = 0,
                    sgst = 0,
                    igst = 0;
                if (stateId === 1) {
                    // Intra-state: apply CGST and SGST
                    cgst = gstAmount / 2;
                    sgst = gstAmount / 2;
                    igst = 0;
                } else if (stateId !== undefined) {
                    // Inter-state: apply IGST only
                    cgst = 0;
                    sgst = 0;
                    igst = gstAmount;
                }

                row.find('.cgst').val(cgst.toFixed(2));
                row.find('.sgst').val(sgst.toFixed(2));
                row.find('.igst').val(igst.toFixed(2));
                row.find('.gstamt').val(gstAmount.toFixed(2));
                row.find('.totalamt').val((billamt + gstAmount).toFixed(2));
            }

            // Function to update summary
            function updateSummary() {
                let totalQty = 0;
                let totalAmt = 0;
                let totalGst = 0;

                $('.form-container .row').each(function() {
                    const qty = parseFloat($(this).find('.quantity').val()) || 0;
                    const billamt = parseFloat($(this).find('.billamt').val()) || 0;
                    const gstamt = parseFloat($(this).find('.gstamt').val()) || 0;

                    totalQty += qty;
                    totalAmt += billamt;
                    totalGst += gstamt;
                });

                const tdsPercent = parseFloat($('#tds-percent option:selected').data('indi-tds')) || 0;
                const tdsAmt = (totalAmt * tdsPercent) / 100;
                const netAmt = totalAmt - tdsAmt + totalGst;

                // Update summary DOM
                $('#total-quantity').text(totalQty.toFixed(2));
                $('#total-amount').text(totalAmt.toFixed(2));
                $('#total-tds-amount').text(tdsAmt.toFixed(2));
                $('#total-gst-amount').text(totalGst.toFixed(2));
                $('#final-total-amount, #total-net-amount').text(netAmt.toFixed(2));
            }

            // On amount or quantity input
            $(document).on('input', '.amount, .quantity', function() {
                const row = $(this).closest('.form-container .row');
                const amount = parseFloat(row.find('.amount').val()) || 0;
                const quantity = parseFloat(row.find('.quantity').val()) || 1;

                const billamt = amount * quantity;
                row.find('.billamt').val(billamt.toFixed(2));

                calculateGST(row);
                updateSummary();
            });

            // On GST rate change
            $(document).on('change', '.gstrate', function() {
                const row = $(this).closest('.form-container .row');
                calculateGST(row);
                updateSummary();
            });

            // On TDS selection change
            $('#tds-percent').on('change', function() {
                updateSummary();
            });

            // Initial run
            updateSummary();
        });
    </script>
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
    <script>
        $(document).ready(function() {
            $('#vendorid').change(function() {
                const stateId = $(this).find(':selected').data('state-id');
                const gstmode = $(this).find(':selected').data('gstmode');

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
                    $('.hsn, .gstrate, .cgst, .sgst, .gstamt').closest('.form-group').addClass('d-none');
                }
            });
        });
    </script>
    <script>
        $(document).on('change', '.expcategory', function() {
            const selected = $(this).val();
            const newCategoryDiv = $(this).closest('.row').find('#divNewCategory');

            if (selected === 'Other') {
                newCategoryDiv.removeClass('d-none').addClass('d-block');
            } else {
                newCategoryDiv.removeClass('d-block').addClass('d-none');
            }
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
