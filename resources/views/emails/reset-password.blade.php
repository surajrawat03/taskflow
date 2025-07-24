<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reset Your Password</title>
</head>
<body style="font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 0;">
    <table width="100%" bgcolor="#f4f4f4" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td align="center" style="padding: 40px 0;">
                <table width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0" style="max-width: 600px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                    <tr>
                        <td align="center" style="padding: 40px 30px 20px 30px;">
                            <h2 style="color: #4f46e5; margin-bottom: 10px;">Reset Your Password</h2>
                            <p style="color: #333; font-size: 16px; margin-bottom: 30px;">You are receiving this email because we received a password reset request for your account.</p>
                            <a href="{{route('password-reset', $token)}}" style="display: inline-block; padding: 12px 30px; background-color: #4f46e5; color: #fff; border-radius: 4px; text-decoration: none; font-weight: bold; margin-bottom: 20px;">Reset Password</a>
                            <p style="color: #888; font-size: 13px; margin-top: 40px;">If you did not request a password reset, no further action is required.</p>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding: 20px 30px 40px 30px; color: #aaa; font-size: 12px;">
                            &copy; {{ date('Y') }} TaskMaster. All rights reserved.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
