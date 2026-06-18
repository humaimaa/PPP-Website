<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You for Contacting PPP Unit KP</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; background-color: #f4f4f4; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #059669, #047857); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
        .content { background: #ffffff; padding: 30px; border: 1px solid #e5e7eb; border-top: none; border-radius: 0 0 10px 10px; }
        .info-box { background: #f0fdf4; padding: 20px; border-radius: 5px; border-left: 4px solid #059669; margin: 20px 0; }
        .footer { margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb; font-size: 12px; color: #6b7280; text-align: center; }
        .button { display: inline-block; background: #059669; color: white; padding: 12px 30px; text-decoration: none; border-radius: 5px; margin: 10px 0; font-weight: bold; }
        .button:hover { background: #047857; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>PPP Unit KPK</h2>
            <p>Thank You for Contacting Us</p>
        </div>
        <div class="content">
            <h3>Dear {{ $firstName ?? 'Valued' }} {{ $lastName ?? 'Visitor' }},</h3>
            
            <p>Thank you for reaching out to the Public-Private Partnership Unit, Khyber Pakhtunkhwa.</p>
            
            <div class="info-box">
                <p style="margin: 0; color: #065f46;">
                    <strong>✅ We have received your message</strong><br>
                    Our team will review your inquiry and get back to you within <strong>1-2 business days</strong>.
                </p>
            </div>

            <div style="margin: 20px 0; padding: 20px; background: #f9fafb; border-radius: 5px;">
                <h4 style="margin-top: 0; color: #059669;">📋 What to expect next:</h4>
                <ul style="color: #374151;">
                    <li>Our team will review your inquiry</li>
                    <li>You will receive a response within 1-2 business days</li>
                    <li>For urgent matters, please call us directly at +92 333 9391457</li>
                </ul>
            </div>

            <div style="text-align: center; margin: 20px 0;">
                <a href="{{ url('/') }}" class="button">Visit Our Website</a>
            </div>

            <div style="background: #dbeafe; padding: 15px; border-radius: 5px; margin: 20px 0;">
                <p style="margin: 0; color: #1e40af; font-size: 14px;">
                    <strong>📌 Quick Links:</strong><br>
                    <a href="{{ url('/projects') }}" style="color: #059669; text-decoration: none;">Our Projects</a> | 
                    <a href="{{ url('/about') }}" style="color: #059669; text-decoration: none;">About Us</a> | 
                    <a href="{{ url('/contact') }}" style="color: #059669; text-decoration: none;">Contact Us</a>
                </p>
            </div>

            <hr style="border: none; border-top: 1px solid #e5e7eb; margin: 20px 0;">
            
            <p style="font-size: 14px; color: #6b7280;">
                If you have any immediate questions, please don't hesitate to contact us at:<br>
                📧 <a href="mailto:chief.ppp@pndkp.gov.pk" style="color: #059669; text-decoration: none;">chief.ppp@pndkp.gov.pk</a><br>
                📞 +92 333 9391457
            </p>

            <p style="font-size: 14px; color: #6b7280; margin-top: 20px;">
                We appreciate your interest in PPP Unit KP!
            </p>

            <p style="font-size: 14px; color: #1f2937; margin-top: 20px;">
                Warm regards,<br>
                <strong style="color: #059669;">PPP Unit Khyber Pakhtunkhwa</strong><br>
                <span style="font-size: 12px; color: #6b7280;">Public-Private Partnership Unit</span>
            </p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} PPP Unit KPK. All rights reserved.</p>
            <p>This is an automated response, please do not reply directly to this email.</p>
            <p>If you have any questions, please contact us at chief.ppp@pndkp.gov.pk</p>
        </div>
    </div>
</body>
</html>