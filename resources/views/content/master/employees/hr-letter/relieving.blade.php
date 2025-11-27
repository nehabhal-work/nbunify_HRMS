<div class="container mt-4 mb-4">
    <div class="p-4 border rounded">
        <div class="text-end">
            <p>Date: {{ date('d-m-Y') }}</p>
        </div>

        <h4 class="text-center fw-bold text-decoration-underline mb-4">RELIEVING LETTER</h4>

        <p>To,</p>
        <p><strong>{{ $employee->name }}</strong><br>
            {{ $employee->res_address ?? '' }}</p>

        <p>Dear <strong>{{ $employee->name }}</strong>,</p>

        <p>
            This is to certify that you were employed with
            <strong>{{ $company->name }}</strong> as
            <strong>{{ $employee->designation->name ?? '' }}</strong> from
            <strong>{{ $employee->joining_date }}</strong> to
            <strong>{{ $employee->relieving_date }}</strong>.
        </p>

        <p>
            Your resignation has been accepted and you are relieved from your duties effective
            <strong>{{ $employee->relieving_date }}</strong>.
        </p>

        <p>We wish you all the best in your future endeavors.</p>

        <div class="mt-5">
            <p><strong>For {{ $company->name }}</strong></p><br><br>
            <p>Authorized Signatory</p>
        </div>
    </div>
</div>
