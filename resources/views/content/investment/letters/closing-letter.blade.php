@extends('layouts.master-layout')
@section('title', 'Investment')
@section('title', 'Investment-create')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row invoice-preview">
            <!-- Invoice -->
            <div class="col-xl-9 col-md-8 col-12 mb-md-0 mb-4">
                <div class="card invoice-preview-card">
                    <div class="card-body">
                        <div class="container">

                            <p class="text-end">
                                <strong>Date:</strong>
                                {{ \Carbon\Carbon::parse($investment->approved3_on)->format('d F Y') }}
                            </p>

                            <p>
                                <strong>To,</strong><br>
                                {{ $investment->firstClient->name }}<br>
                                {{ $investment->firstClient->res_address }}<br>
                                {{ $investment->firstClient->res_city }},
                                {{ $investment->firstClient->res_state }},
                                {{ $investment->firstClient->res_country }}
                            </p>

                            <p><strong>Subject: Confirmation of Business Loan Closure</strong></p>

                            <p>Dear {{ $investment->firstClient->name }},</p>

                            <p style="text-align: justify;">
                                This is to formally confirm that the business loan amounting to
                                <strong>Rs. {{ number_format($investment->investment_amount, 2) }}</strong>,
                                which was provided by you on
                                <strong>{{ \Carbon\Carbon::parse($investment->investment_date)->format('d F Y') }}</strong>,
                                has been fully repaid and settled.
                            </p>

                            <p style="text-align: justify;">
                                As of
                                <strong>{{ \Carbon\Carbon::parse($investment->maturity_date)->format('d F Y') }}</strong>,
                                the entire outstanding amount, including the applicable principal and accrued interest,
                                has been paid in full. Accordingly, the loan account stands closed with no outstanding
                                balance or liability.
                            </p>

                            <h4 class="mt-4">Closure Details</h4>

                            <table border="1" cellpadding="10" width="100%" style="border-collapse: collapse;">
                                <tr>
                                    <td width="40%"><strong>Loan Amount</strong></td>
                                    <td>Rs. {{ number_format($investment->investment_amount, 2) }}</td>
                                </tr>

                                <tr>
                                    <td><strong>Total Interest Paid</strong></td>
                                    <td>Rs. {{ number_format($investment->paid_interest_amount, 2) }}</td>
                                </tr>

                                <tr>
                                    <td><strong>Total Amount Repaid</strong></td>
                                    <td>
                                        Rs.
                                        {{ number_format($investment->investment_amount + $investment->paid_interest_amount, 2) }}
                                    </td>
                                </tr>

                                <tr>
                                    <td><strong>Final Payment Mode</strong></td>
                                    <td>
                                        {{ strtoupper($investment->investmentInputBank[0]->instrument_type) }}
                                        (Ref No: {{ $investment->investmentInputBank[0]->client_reference_no }})
                                    </td>
                                </tr>

                                <tr>
                                    <td><strong>Date of Final Settlement</strong></td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($investment->maturity_date)->format('d F Y') }}
                                    </td>
                                </tr>

                                <tr>
                                    <td><strong>Investment Code</strong></td>
                                    <td>{{ $investment->investment_code }}</td>
                                </tr>
                            </table>

                            <br>

                            <p style="text-align: justify;">
                                We hereby confirm that there are no further dues, claims, or obligations pending
                                in relation to the above-mentioned loan. The account has been successfully closed.
                            </p>

                            <p style="text-align: justify;">
                                We sincerely appreciate your trust and financial support, which has been valuable
                                to our business operations.
                            </p>

                            <p>
                                Please retain this letter for your records.
                            </p>

                            <br><br>

                            <p>
                                Yours sincerely,<br><br>

                                <strong>{{ $company->authorized_signatory ?? 'Authorized Signatory' }}</strong><br>
                                {{ $company->name }}<br>
                                {{ $company->phone ?? '' }}
                            </p>

                        </div>
                    </div>
                </div>
            </div>
            <!-- /Invoice -->

            <!-- Invoice Actions -->
            <div class="col-xl-3 col-md-4 col-12 invoice-actions">
                <div class="card">
                    <div class="card-body">
                        <button class="btn btn-primary d-grid w-100 mb-3" data-bs-toggle="offcanvas"
                            data-bs-target="#sendInvoiceOffcanvas">
                            <span class="d-flex align-items-center justify-content-center text-nowrap"><i
                                    class="bx bx-paper-plane bx-xs me-1"></i>Send Invoice</span>
                        </button>
                        <button class="btn btn-label-secondary d-grid w-100 mb-3">Download</button>
                        <a class="btn btn-label-secondary d-grid w-100 mb-3" target="_blank"
                            href="./app-invoice-print.html">
                            Print
                        </a>

                    </div>
                </div>
            </div>
            <!-- /Invoice Actions -->
        </div>

        <!-- Offcanvas -->
        <!-- Send Invoice Sidebar -->
        <div class="offcanvas offcanvas-end" id="sendInvoiceOffcanvas" aria-hidden="true">
            <div class="offcanvas-header mb-3">
                <h5 class="offcanvas-title">Send Invoice</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body flex-grow-1">
                <form>
                    <div class="mb-3">
                        <label for="invoice-from" class="form-label">From</label>
                        <input type="text" class="form-control" id="invoice-from" value="shelbyComapny@email.com"
                            placeholder="company@email.com" />
                    </div>
                    <div class="mb-3">
                        <label for="invoice-to" class="form-label">To</label>
                        <input type="text" class="form-control" id="invoice-to" value="qConsolidated@email.com"
                            placeholder="company@email.com" />
                    </div>
                    <div class="mb-3">
                        <label for="invoice-subject" class="form-label">Subject</label>
                        <input type="text" class="form-control" id="invoice-subject"
                            value="Invoice of purchased Admin Templates" placeholder="Invoice regarding goods" />
                    </div>
                    <div class="mb-3">
                        <label for="invoice-message" class="form-label">Message</label>
                        <textarea class="form-control" name="invoice-message" id="invoice-message" cols="3" rows="8">
                            Dear Queen Consolidated,
                                    Thank you for your business, always a pleasure to work with you!
                                    We have generated a new invoice in the amount of $95.59
                                    We would appreciate payment of this invoice by 05/11/2021
                        </textarea
                      >
                    </div>
                    <div class="mb-4">
                      <span class="badge bg-label-primary">
                        <i class="bx bx-link bx-xs"></i>
                        <span class="align-middle">Invoice Attached</span>
                      </span>
                    </div>
                    <div class="mb-3 d-flex flex-wrap">
                      <button type="button" class="btn btn-primary me-3" data-bs-dismiss="offcanvas">Send</button>
                      <button type="button" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancel</button>
                    </div>
                  </form>
                </div>
              </div>
              <!-- /Send Invoice Sidebar -->

              <!-- Add Payment Sidebar -->
              <div class="offcanvas offcanvas-end" id="addPaymentOffcanvas" aria-hidden="true">
                <div class="offcanvas-header mb-3">
                  <h5 class="offcanvas-title">Add Payment</h5>
                  <button
                    type="button"
                    class="btn-close text-reset"
                    data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
                </div>
                <div class="offcanvas-body flex-grow-1">
                  <div class="d-flex justify-content-between bg-lighter p-2 mb-3">
                    <p class="mb-0">Invoice Balance:</p>
                    <p class="fw-medium mb-0">$5000.00</p>
                  </div>
                  <form>
                    <div class="mb-3">
                      <label class="form-label" for="invoiceAmount">Payment Amount</label>
                      <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input
                          type="text"
                          id="invoiceAmount"
                          name="invoiceAmount"
                          class="form-control invoice-amount"
                          placeholder="100" />
                      </div>
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="payment-date">Payment Date</label>
                      <input id="payment-date" class="form-control invoice-date" type="text" />
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="payment-method">Payment Method</label>
                      <select class="form-select" id="payment-method">
                        <option value="" selected disabled>Select payment method</option>
                        <option value="Cash">Cash</option>
                        <option value="Bank Transfer">Bank Transfer</option>
                        <option value="Debit Card">Debit Card</option>
                        <option value="Credit Card">Credit Card</option>
                        <option value="Paypal">Paypal</option>
                      </select>
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="payment-note">Internal Payment Note</label>
                      <textarea class="form-control" id="payment-note" rows="2"></textarea>
                    </div>
                    <div class="mb-3 d-flex flex-wrap">
                        <button type="button" class="btn btn-primary me-3" data-bs-dismiss="offcanvas">Send</button>
                        <button type="button" class="btn btn-label-secondary"
                            data-bs-dismiss="offcanvas">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /Add Payment Sidebar -->

        <!-- /Offcanvas -->
    </div>
@endsection
