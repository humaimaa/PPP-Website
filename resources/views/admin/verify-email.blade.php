<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email - PPP Department KPK</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; background-color: #f4f4f4; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #059669, #047857); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
        .content { background: #ffffff; padding: 30px; border: 1px solid #e5e7eb; border-top: none; border-radius: 0 0 10px 10px; }
        .button { display: inline-block; background: #059669; color: white; padding: 12px 30px; text-decoration: none; border-radius: 5px; margin: 20px 0; font-weight: bold; }
        .button:hover { background: #047857; }
        .footer { margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb; font-size: 12px; color: #6b7280; text-align: center; }
        .warning { background: #fef3c7; padding: 10px; border-radius: 5px; margin: 20px 0; font-size: 13px; color: #92400e; }
        .info { background: #dbeafe; padding: 10px; border-radius: 5px; margin: 20px 0; font-size: 13px; color: #1e40af; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>PPP Department KPK</h2>
            <p>Email Verification Required</p>
        </div>
        <div class="content">
            <h3>Hello {{ $name }}!</h3>
            <p>Thank you for registering with PPP Department KPK. Please verify your email address to access your account.</p>
            
            <div style="text-align: center;">
                <a href="{{ $verificationUrl }}" class="button">Verify Email Address</a>
            </div>
            
            <div class="warning">
                <strong>⚠️ Important:</strong> This verification link will expire in 60 minutes.
            </div>
            
            <div class="info">
                <strong>💡 Need help?</strong> If the button doesn't work, copy and paste the link below into your browser.
            </div>
            
            <p style="margin-top: 20px; font-size: 12px;">If the button doesn't work, copy and paste this link into your browser:</p>
            <p style="background: #f3f4f6; padding: 10px; border-radius: 5px; word-break: break-all; font-size: 11px; color: #374151;">
                {{ $verificationUrl }}
            </p>
            
            <p style="margin-top: 20px;">If you did not create an account, no further action is required.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} PPP Department KPK. All rights reserved.</p>
            <p>This is an automated message, please do not reply.</p>
            <p>If you have any questions, please contact support.</p>
        </div>
    </div>
</body>
</html>