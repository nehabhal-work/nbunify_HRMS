<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Happy Birthday!</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="text-align: center; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px; border-radius: 10px; margin-bottom: 20px;">
        <h1 style="margin: 0; font-size: 2.5em;">🎉 Happy Birthday! 🎂</h1>
    </div>
    
    <div style="background: #f9f9f9; padding: 20px; border-radius: 10px;">
        <p style="font-size: 1.2em; margin-bottom: 20px;">
            Dear {{ $client->name ?? $client->client_name }},
        </p>
        
        <p style="font-size: 1.1em; margin-bottom: 20px;">
            Wishing you a very Happy Birthday! 🎈
        </p>
        
        <p style="margin-bottom: 20px;">
            May this special day bring you joy, happiness, and all the wonderful things you deserve. 
            Thank you for being a valued client and for trusting us with your business.
        </p>
        
        <p style="margin-bottom: 20px;">
            We hope your birthday is filled with laughter, love, and memorable moments!
        </p>
        
        <div style="text-align: center; margin: 30px 0;">
            <p style="font-size: 1.3em; color: #667eea; font-weight: bold;">
                🎊 Have a fantastic day! 🎊
            </p>
        </div>
        
        <p style="margin-top: 30px;">
            Best wishes,<br>
            <strong>The Team</strong>
        </p>
    </div>
</body>
</html>