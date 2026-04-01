<div class="container mt-4 mb-4">
    <div class="p-4 border rounded">
        <div class="text-end">
            <p>Date: {{ date('d-m-Y') }}</p>
        </div>

        <h4 class="text-center fw-bold text-decoration-underline mb-4">EXPERIENCE LETTER</h4>

        <p>To whom it may concern,</p>

        <p>
            This is to certify that <strong>{{ $employee->name }}</strong> worked with
            <strong>{{ $company->name }}</strong> as
            <strong>{{ $employee->designation->name ?? '' }}</strong> from
            <strong>{{ $employee->joining_date }}</strong> to
            <strong>{{ $employee->relieving_date }}</strong>.
        </p>

        <p>
            During their tenure, the employee displayed professionalism, dedication, and a positive attitude.
        </p>

        <p>We wish them success in their future career.</p>

        <div class="mt-5">
            <p><strong>For {{ $company->name }}</strong></p><br><br>
            <p>Authorized Signatory</p>
        </div>
    </div>
</div>
