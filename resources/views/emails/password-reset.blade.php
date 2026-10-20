<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password Notification</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #f4f4f7;
            color: #51545e;
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }

        .wrapper {
            width: 100%;
            background-color: #f4f4f7;
            padding: 30px 0;
        }

        .content {
            max-width: 570px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            padding: 40px;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
        }

        .header h1 {
            color: #22252a;
            font-size: 20px;
            font-weight: 700;
            margin: 0;
        }

        .button-wrapper {
            text-align: center;
            margin: 30px 0;
        }

        .button {
            display: inline-block;
            background-color: #1a1a1a;
            color: #ffffff !important;
            padding: 12px 28px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            font-size: 15px;
        }

        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eaeaec;
            font-size: 12px;
            color: #a8aaaf;
            text-align: center;
        }

        .break-word {
            word-break: break-all;
            color: #1a1a1a;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="content">
            <div class="header">
                <h1>{{ config('app.name', 'Spark') }}</h1>
            </div>

            <p>Hello {{ $user->name ?? 'there' }},</p>

            <p>You are receiving this email because we received a password reset request for your account.</p>

            <div class="button-wrapper">
                <a href="{{ $resetUrl }}" class="button" target="_blank" rel="noopener noreferrer">Reset Password</a>
            </div>

            <p>This password reset link will expire in <strong>60 minutes</strong>.</p>

            <p>If you did not request a password reset, no further action is required and your account remains secure.
            </p>

            <p>Regards,<br>{{ config('app.name', 'Spark') }} Team</p>

            <div class="footer">
                <p>If you're having trouble clicking the "Reset Password" button, copy and paste the URL below into your
                    web browser:</p>
                <p><a href="{{ $resetUrl }}" class="break-word">{{ $resetUrl }}</a></p>
            </div>
        </div>
    </div>
</body>

</html>
