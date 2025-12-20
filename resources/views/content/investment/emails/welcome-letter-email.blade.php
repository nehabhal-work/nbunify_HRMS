<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Investment Welcome Letter</title>


</head>

<body>

    <p>Dear {{ $investment->firstClient->name }},</p>

    <p>
        Greetings from {{ $company->name }}.
        Please find attached your investment confirmation letter for your records.
    </p>

    <p>
        If you have any questions, feel free to contact us.
    </p>

    <p>
        Warm Regards,<br>
        {{ $company->name }}
    </p>


</body>

</html>
