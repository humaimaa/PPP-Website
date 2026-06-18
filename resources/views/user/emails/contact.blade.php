<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Form Submission</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; background-color: #f4f4f4; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #059669, #047857); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
        .content { background: #ffffff; padding: 30px; border: 1px solid #e5e7eb; border-top: none; border-radius: 0 0 10px 10px; }
        .field { margin-bottom: 15px; padding: 10px; background: #f9fafb; border-left: 4px solid #059669; }
        .field-label { font-weight: bold; color: #059669; }
        .field-value { margin-top: 5px; color: #1f2937; }
        .footer { margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb; font-size: 12px; color: #6b7280; text-align: center; }
        .badge { display: inline-block; background: #059669; color: white; padding: 5px 15px; border-radius: 20px; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>PPP Unit KPK</h2>
            <p>New Contact Form Submission</p>
        </div>
        <div class="content">
            <p style="font-size: 16px; color: #1f2937;">
                <strong>A new message has been received from the contact form.</strong>
            </p>

            <div style="margin: 20px 0;">
                <div class="field">
                    <div class="field-label">📝 Name</div>
                    <div class="field-value">{{ $firstName ?? 'N/A' }} {{ $lastName ?? 'N/A' }}</div>
                </div>

                <div class="field">
                    <div class="field-label">📧 Email</div>
                    <div class="field-value">
                        <a href="mailto:{{ $email ?? 'N/A' }}" style="color: #059669; text-decoration: none;">{{ $email ?? 'N/A' }}</a>
                    </div>
                </div>

                @if(isset($phone) && $phone && $phone != 'Not provided')
                <div class="field">
                    <div class="field-label">📞 Phone</div>
                    <div class="field-value">{{ $phone }}</div>
                </div>
                @endif

                <div class="field">
                    <div class="field-label">📌 Subject</div>
                    <div class="field-value">
                        <span class="badge">{{ ucfirst($subject ?? 'N/A') }}</span>
                    </div>
                </div>

                <div class="field">
                    <div class="field-label">💬 Message</div>
                    <div class="field-value" style="background: #f3f4f6; padding: 15px; border-radius: 5px; margin-top: 5px; white-space: pre-wrap;">
                        {{ $messageContent ?? 'N/A' }}
                    </div>
                </div>
            </div>

            <div style="background: #dbeafe; padding: 15px; border-radius: 5px; margin: 20px 0;">
                <p style="margin: 0; color: #1e40af; font-size: 14px;">
                    <strong>📌 Action Required:</strong> Please respond to this inquiry within 24 hours.
                </p>
            </div>

            <hr style="border: none; border-top: 1px solid #e5e7eb; margin: 20px 0;">
            
            <div style="font-size: 13px; color: #6b7280;">
                <p><strong>Reply to:</strong> <a href="mailto:{{ $email ?? 'N/A' }}" style="color: #059669; text-decoration: none;">{{ $email ?? 'N/A' }}</a></p>
                <p><strong>Form submitted on:</strong> {{ now()->format('F j, Y') }}</p>
                <p><strong>IP Address:</strong> {{ request()->ip() }}</p>
            </div>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} PPP Unit KPK. All rights reserved.</p>
            <p>This is an automated notification from the contact form.</p>
        </div>
    </div>
</body>
</html>