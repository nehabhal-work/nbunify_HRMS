<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Merry Christmas!</title>
</head>
<style>
    #birthdaybackground {
        background-image: url('https://www.erp.easylifesolutions.co.in/assets/img/mail/ELS_christmas_BG.png');
        /* background image */
        background-size: cover;
        /* fills the area */
        background-position: center;
        /* stays centered */
        background-repeat: no-repeat;
        /* no tiling */
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
                            <img src="https://www.erp.easylifesolutions.co.in/assets/img/mail/ELS_christmas_Header.png"
                                alt="Christmas" style="width:100%; display:block;">
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding:30px; font-family:Arial, sans-serif; color:#333;">

                            <p style="font-size:16px;">
                                Dear {{ $client->name ?? $client->client_name }},
                            </p>

                            <p style="font-size:16px; margin-top:15px;">
                                Merry Christmas! 🎅
                            </p>

                            <p style="font-size:14px; line-height:1.6; margin-top:15px;">
                                We’re sending you our warmest wishes for a holiday season filled with peace and
                                prosperity. Thank you for the trust you’ve placed in us; it’s a joy to be part of your
                                financial story! 📈
                            </p>

                            <p style="font-size:14px; line-height:1.6; margin-top:15px;">
                                We hope your holidays are full of happy moments and big smiles. Have a fantastic festive
                                season! 🎁🥂 </p>

                            <p style="margin-top:25px;">
                                Cheers,
                            </p>

                            <p style="margin-top:30px;">
                                The
                                <strong>ELS </strong>Team
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

                            <p style="font-size:12px; color:#666; margin-top:15px;">
                                +91 98672 25059 | +91 96198 50696 | +91 98922 76058 | +91 84240 42885<br>
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
