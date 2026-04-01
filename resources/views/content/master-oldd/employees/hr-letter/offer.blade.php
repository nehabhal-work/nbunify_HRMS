<div class="container mt-4 mb-4">
    <div class="p-4 border rounded">
        <div class="text-end">
            <p>Date: {{ date('d-m-Y') }}</p>
        </div>

        <h4 class="text-center fw-bold text-decoration-underline mb-4">OFFER LETTER</h4>

        <p>To,</p>
        <p><strong>{{ $candidate->name }}</strong><br>
            {{ $candidate->address ?? '' }}</p>

        <p>Dear <strong>{{ $candidate->name }}</strong>,</p>

        <p>
            We are pleased to offer you the position of
            <strong>{{ $candidate->designation ?? '_________' }}</strong> at
            <strong>{{ $company->name }}</strong>.
        </p>

        <p>Your tentative joining date will be <strong>{{ $candidate->joining_date ?? '________' }}</strong>.</p>

        <p>Your annual CTC will be <strong>INR {{ number_format($candidate->ctc, 2) }}</strong>.</p>

        <p>
            This offer is subject to successful verification of your documents and background checks.
        </p>

        <p>Kindly confirm your acceptance by replying to this letter.</p>

        <div class="mt-5">
            <p><strong>For {{ $company->name }}</strong></p><br><br>
            <p>Authorized Signatory</p>
        </div>
    </div>
</div>
