<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Investment Payout Confirmation</title>
</head>

<body style="margin:0; padding:0; background:#f4f6f9; font-family: Arial, Helvetica, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f6f9; padding:30px 0;">
        <tr>
            <td align="center">

                <table width="650" cellpadding="0" cellspacing="0"
                    style="background:#ffffff; border-radius:8px; overflow:hidden; border:1px solid #e5e7eb;">

                    <!-- Header -->
                    <tr>
                        <td style="background:#0d6efd; padding:20px 30px; color:#ffffff;">
                            <h2 style="margin:0; font-size:20px;">
                                Investment Payout Confirmation
                            </h2>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:30px; color:#333333;">

                            <p style="margin-top:0;">
                                Dear
                                <strong>{{ $schedule->investment->firstClient->name ?? 'Valued Investor' }}</strong>,
                            </p>

                            <p>
                                We are pleased to inform you that the scheduled payout for your investment
                                has been <strong>successfully processed</strong>.
                            </p>

                            <!-- Investment Details -->
                            <table width="100%" cellpadding="8" cellspacing="0"
                                style="border-collapse:collapse; margin:20px 0; font-size:14px;">
                                <tr style="background:#f1f5f9;">
                                    <td colspan="2"><strong>Investment Details</strong></td>
                                </tr>
                                <tr>
                                    <td width="40%">Investment ID</td>
                                    <td><strong>#{{ $schedule->investment->id }}</strong></td>
                                </tr>
                                <tr>
                                    <td>Payout Schedule ID</td>
                                    <td>#{{ $schedule->id }}</td>
                                </tr>
                                <tr>
                                    <td>Scheduled Payout Date</td>
                                    <td>{{ \Carbon\Carbon::parse($schedule->sch_payout_date)->format('d M Y') }}</td>
                                </tr>
                                <tr>
                                    <td>Actual Payout Date</td>
                                    <td>
                                        {{ $schedule->actual_payout_date ? \Carbon\Carbon::parse($schedule->actual_payout_date)->format('d M Y') : '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Amount Paid</td>
                                    <td><strong>₹ {{ number_format($schedule->actual_payout_amount, 2) }}</strong></td>
                                </tr>
                                <tr>
                                    <td>UTR / Reference No</td>
                                    <td>{{ $schedule->utr_no ?? '-' }}</td>
                                </tr>
                            </table>

                            <!-- Bank Info -->
                            <table width="100%" cellpadding="8" cellspacing="0"
                                style="border-collapse:collapse; margin:20px 0; font-size:14px;">
                                <tr style="background:#f1f5f9;">
                                    <td colspan="2"><strong>Bank Details</strong></td>
                                </tr>
                                <tr>
                                    <td width="40%">Credited To Bank</td>
                                    <td>{{ $schedule->toClientBank->bank_name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td>Account Number</td>
                                    <td>{{ $schedule->toClientBank->account_number ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td>Branch</td>
                                    <td>{{ $schedule->toClientBank->branch_name ?? '-' }}</td>
                                </tr>
                            </table>

                            @if ($schedule->remarks)
                                <p>
                                    <strong>Remarks:</strong><br>
                                    {{ $schedule->remarks }}
                                </p>
                            @endif

                            <p style="margin-top:25px;">
                                If you have any questions regarding this payout or require further assistance,
                                please feel free to contact our support team.
                            </p>

                            <p>
                                Thank you for your continued trust and association with us.
                            </p>

                            <p style="margin-bottom:0;">
                                Warm regards,<br>
                                <strong>Eeasy Life Solutions</strong><br>
                                Investment & Wealth Management Team
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background:#f8fafc; padding:15px 30px; font-size:12px; color:#6b7280;">
                            <p style="margin:0;">
                                This is a system-generated email. Please do not reply directly to this message.
                            </p>
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>
