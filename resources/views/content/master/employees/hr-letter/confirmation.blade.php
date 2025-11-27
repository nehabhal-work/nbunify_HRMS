<div class="container mt-4 mb-4">
    <div class="p-4 border rounded">
        <div class="text-end">
            <p>Date: {{ date('d-m-Y') }}</p>
        </div>

        <h4 class="text-center fw-bold text-decoration-underline mb-4">CONFIRMATION LETTER</h4>

        <p>To,</p>
        <p><strong>{{ $employee->name }}</strong><br>
            {{ $employee->res_address ?? '' }}</p>

        <p>Dear <strong>{{ $employee->name }}</strong>,</p>

        <p>
            We are glad to inform you that your services have been confirmed with
            <strong>{{ $company->name }}</strong> effective from
            <strong>{{ $employee->confirmation_date }}</strong>.
        </p>

        <p>Your designation remains <strong>{{ $employee->designation->name ?? '' }}</strong>.</p>

        <p>We appreciate your contribution and expect your continued commitment.</p>

        <div class="mt-5">
            <p><strong>For {{ $company->name }}</strong></p><br><br>
            <p>Authorized Signatory</p>
        </div>
    </div>
</div>
