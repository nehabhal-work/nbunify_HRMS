<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Happy Birthday!</title>
</head>

<body style="margin:0; padding:0; background-color:#f2f2f2;">

    <!-- BODY BACKGROUND -->
    <table width="100%" cellpadding="0" cellspacing="0"
        style="
        background-image:url('http://127.0.0.1:8000/assets/img/email/els_birthday_bg.png');
        background-repeat:no-repeat;
        background-size:cover;
        background-position:center;
        padding:40px 0;
    ">
        <tr>
            <td align="center">

                <!-- MAIN CONTAINER -->
                <table width="600" cellpadding="0" cellspacing="0"
                    style="background:#ffffffcc; border-radius:12px; overflow:hidden;">

                    <!-- HEADER IMAGE -->
                    <tr>
                        <td>
                            <img src="http://127.0.0.1:8000/assets/img/email/els_birthday_header.png"
                                alt="Happy Birthday" style="width:100%; display:block;">
                        </td>
                    </tr>

                    <!-- CONTENT -->
                    <tr>
                        <td style="padding:30px; font-family:Arial, sans-serif; color:#333; line-height:1.6;">
                            <p style="font-size:18px; margin:0 0 15px;">
                                Dear {{ $clients->name }},
                            </p>

                            <p style="font-size:16px; margin:0 0 15px;">
                                Wishing you a very Happy Birthday! 🎉
                            </p>

                            <p style="margin:0 0 15px;">
                                May this special day bring you joy, happiness, and all the wonderful things you deserve.
                                Thank you for being a valued client and for trusting us with your business.
                            </p>

                            <p style="margin:0;">
                                Have a fantastic day filled with smiles and celebration! 🎂
                            </p>
                        </td>
                    </tr>

                    <!-- FOOTER IMAGE -->
                    <tr>
                        <td>
                            <img src="http://127.0.0.1:8000/assets/img/branding/logo.png" alt="Birthday Wishes"
                                style="width:100%; display:block;">
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>
