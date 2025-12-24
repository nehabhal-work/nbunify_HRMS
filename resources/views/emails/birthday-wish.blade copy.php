<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Happy Birthday</title>
</head>
<style>
    #birthdaybackground {
        background-image: url('https://www.erp.easylifesolutions.co.in/assets/img/mail/els_birthday_bg.png');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        width: 100%;

    }
</style>

<body id="birthdaybackground">

    <div cellpadding="0" cellspacing="0" align="center">
        <tr>
            <td align="center">

                <!-- Main Container -->
                <table width="600" cellpadding="0" cellspacing="0"
                    style="background:#ffffff; border-radius:20px; overflow:hidden; margin:20px 0; ">

                    <!-- Header Image -->
                    <tr>
                        <td align="center">
                            <img src="https://www.erp.easylifesolutions.co.in/assets/img/mail/els_birthday_header.png"
                                alt="Happy Birthday" style="width:100%; display:block;">
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding:30px; font-family:Arial, sans-serif; color:#333;">

                            <p style="font-size:16px;">
                                Dear {{ $client->name ?? $client->client_name }},
                            </p>

                            <p style="font-size:16px; margin-top:15px;">
                                Wishing you a very Happy Birthday!
                            </p>

                            <p style="font-size:14px; line-height:1.6; margin-top:15px;">
                                May this special day bring you joy, happiness, and all the wonderful things you
                                deserve. Thank you for being a valued client and for trusting us with your
                                business.
                            </p>

                            <p style="font-size:14px; line-height:1.6; margin-top:15px;">
                                We hope your birthday is filled with laughter, love, and memorable moments!
                            </p>

                            <p style="margin-top:25px;">
                                Have a fantastic day!
                            </p>

                            <p style="margin-top:30px;">
                                Best Wishes,<br>
                                <strong>ELS Team</strong>
                            </p>

                        </td>


                    </tr>

                    <!-- Footer -->
                    <tr>

                        <td align="center" style="padding:20px; border-top:1px solid #1e1d1d; ">
                            <img src="https://www.erp.easylifesolutions.co.in/assets/img/branding/logo.png"
                                alt="ELS Finserv1" width="80"><br><br>

                            <!-- Social Icons -->
                            <a href="https://www.facebook.com/elsolutionsofficial?rdid=GpqaDR8vMNRExBkg&share_url=https%3A%2F%2Fwww.facebook.com%2Fshare%2F1GknSE1nS2%2F#"
                                target="_blank">
                                <img src="https://www.erp.easylifesolutions.co.in/assets/img/mail/fb.png" alt="Facebook"
                                    width="24" style="border:0;">
                            </a>

                            <a href="https://www.instagram.com/easylifesolutions.official/" target="_blank">
                                <img src="https://www.erp.easylifesolutions.co.in/assets/img/mail/instag.png"
                                    alt="Instagram" width="24" style="border:0;">
                            </a>


                            <a href="https://wa.me/918424042885" target="_blank">
                                <img src="https://www.erp.easylifesolutions.co.in/assets/img/mail/wp.png" alt="WhatsApp"
                                    width="24" style="border:0;">
                            </a>

                            <p style="font-size:12px; color:#666; ">
                                +91 98672 25059 | +91 96198 50696 | +91 91617 03666 | +91 84240 42885<br>
                                info@elsolutions.co.in | www.elsolutions.co.in
                            </p>
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </div>

</body>

</html>
