<div class="container mt-4 mb-4">
    <div class="p-4 border rounded">
        <div class="text-end">
            <p>Date: {{ date('d-m-Y') }}</p>
        </div>

        <h4 class="text-center fw-bold text-decoration-underline mb-4">SALARY INCREMENT LETTER</h4>

        <p>To,</p>
        <p><strong>{{ $employee->name }}</strong><br>
            {{ $employee->res_address ?? '' }}</p>

        <p>Dear <strong>{{ $employee->name }}</strong>,</p>

        <p>
            We are pleased to inform you that based on your performance, your salary has been revised.
        </p>

        <p>
            Your new monthly salary will be
            <strong>INR {{ number_format($employee->incremented_salary, 2) }}</strong>
            effective from <strong>{{ $employee->increment_date }}</strong>.
        </p>

        <p>
            We appreciate your hard work and expect your continued dedication to the organization.
        </p>

        <div class="mt-5">
            <p><strong>For {{ $company->name }}</strong></p><br><br>
            <p>Authorized Signatory</p>
        </div>
    </div>
</div>
