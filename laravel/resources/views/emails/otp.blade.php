<!DOCTYPE html>
<html>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e1e1e1; border-radius: 10px;">
        <h2 style="color: #2563eb; text-align: center;">Campus Mart Verification</h2>
        <p>Hello student,</p>
        <p>Thank you for joining Campus Mart. Use the 6-digit code below to verify your account:</p>
        
        <div style="text-align: center; margin: 30px 0;">
            <span style="font-size: 32px; font-weight: bold; letter-spacing: 8px; color: #1e40af; background: #f3f4f6; padding: 15px 30px; border-radius: 5px;">
                {{ $otp }}
            </span>
        </div>
        
        <p>This code is valid for 15 minutes. Please do not share this code with anyone.</p>
        <p style="font-size: 12px; color: #777; margin-top: 40px; border-top: 1px solid #eee; padding-top: 10px;">
            This is an automated message from the Campus Mart System.
        </p>
    </div>
</body>
</html>