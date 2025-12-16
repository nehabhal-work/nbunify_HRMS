<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Happy New Year!</title>
</head>

<body
    style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">

    <!-- Header -->
    <div
        style="text-align: center;
                background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
                color: white;
                padding: 30px;
                border-radius: 10px;
                margin-bottom: 20px;">
        <h1 style="margin: 0; font-size: 2.5em;">
            🎉 Happy New Year! 🎆
        </h1>
    </div>

    <!-- Body -->
    <div style="background: #f9f9f9; padding: 20px; border-radius: 10px;">

        <p style="font-size: 1.2em; margin-bottom: 20px;">
            Dear,
            {{-- Dear {{ $client->name ?? $client->client_name }}, --}}
        </p>

        <p style="font-size: 1.1em; margin-bottom: 20px;">
            Warm greetings and best wishes for a joyful and prosperous New Year! ✨
        </p>

        <p style="margin-bottom: 20px;">
            As we step into a new year, we would like to thank you for your continued trust
            and support. It has been a pleasure serving you, and we truly value our association.
        </p>

        <p style="margin-bottom: 20px;">
            May the coming year bring you good health, success, happiness, and new opportunities.
            We look forward to continuing our journey together in the year ahead.
        </p>

        <div style="text-align: center; margin: 30px 0;">
            <p style="font-size: 1.3em; color: #2a5298; font-weight: bold;">
                🌟 Wishing You a Bright & Successful Year Ahead 🌟
            </p>
        </div>

        <p style="margin-top: 30px;">
            Best regards,<br>
            <strong>The Team</strong>
        </p>

    </div>

</body>

</html>
