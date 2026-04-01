<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Appointment Letter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-size: 14px;
            line-height: 1.7;
        }

        .letter-box {
            background: #fff;
            padding: 40px;
            border: 1px solid #bfbfbf;
            border-radius: 8px;
        }

        .header-title {
            font-size: 22px;
            font-weight: 600;
            text-align: center;
            text-decoration: underline;
            margin-bottom: 30px;
        }

        .signature-box {
            margin-top: 50px;
        }
    </style>
</head>

<body>
    <div class="container mt-5 mb-5">
        <div class="letter-box">

            <div class="text-end">
                <p>Date: {{ date('d-m-Y') }}</p>
            </div>

            <p>
                To,<br>
                <strong>{{ $employee->name }}</strong><br>
                {{ $employee->res_address ?? '' }}<br>
                {{ $employee->res_city ?? '' }} {{ $employee->res_pincode ?? '' }}<br>
            </p>

            <h4 class="header-title">APPOINTMENT LETTER</h4>

            <p>Dear <strong>{{ $employee->name }}</strong>,</p>

            <p>
                We are pleased to appoint you as
                <strong>{{ $employee->designation->name ?? '__________' }}</strong>
                in our organization <strong>{{ $company->name ?? 'Company Name' }}</strong>.
            </p>

            <p>Your appointment will be effective from <strong>{{ $employee->joining_date ?? '__________' }}</strong>.
            </p>

            <p>Your employment terms are as follows:</p>

            <ol>
                <li><strong>Position :</strong> {{ $employee->designation->name ?? '__________' }}</li>
                <li><strong>Department :</strong> {{ $employee->department->name ?? '__________' }}</li>
                <li><strong>Location :</strong> {{ $company->address ?? '__________' }}</li>
                <li><strong>Salary :</strong> INR {{ number_format($employee->basic_salary, 2) }} per month</li>
                <li><strong>Probation Period :</strong> {{ $employee->probation_date ?? '__________' }} months</li>
                <li><strong>Working Hours :</strong> As per company policy</li>
                <li><strong>Leave Policy :</strong> As per company rules</li>
            </ol>

            <p>
                You are expected to maintain the highest standards of professionalism, confidentiality, and integrity.
                The company reserves the right to modify your job responsibilities based on business requirements.
            </p>

            <p>
                If you agree to the terms and conditions mentioned above, kindly sign and return a copy of this
                appointment letter.
            </p>

            <p>We welcome you to the organization and look forward to a mutually beneficial association.</p>

            <div class="row signature-box">
                <div class="col-md-6">
                    <p><strong>For {{ $company->name ?? 'Company Name' }}</strong></p>
                    <br><br>
                    <p>Authorized Signatory</p>
                </div>

                <div class="col-md-6 text-end">
                    <p><strong>Employee Signature</strong></p>
                    <br><br>
                    <p>________________________</p>
                </div>
            </div>

        </div>
    </div>



</body>

</html>
