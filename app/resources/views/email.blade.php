<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify Your Email</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #0f172a, #1e293b);
            font-family: 'Segoe UI', Arial, Helvetica, sans-serif;
        }

        .wrapper {
            width: 100%;
            padding: 40px 20px;
        }

        .card {
            max-width: 480px;
            width: 100%;
            background-color: #ffffff;
            border-radius: 16px;
            padding: 40px 30px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .title {
            margin: 0 0 16px;
            font-size: 24px;
            color: #0f172a;
        }

        .description {
            margin: 0 0 28px;
            font-size: 15px;
            color: #64748b;
            line-height: 1.6;
        }

        .button {
            display: inline-block;
            padding: 14px 28px;
            background-color: #2563eb;
            color: #ffffff;
            text-decoration: none;
            font-size: 15px;
            font-weight: 600;
            border-radius: 8px;
            transition: 0.3s;
        }

        .button:hover {
            background-color: #1d4ed8;
        }

        .note {
            margin: 32px 0 0;
            font-size: 13px;
            color: #94a3b8;
            line-height: 1.6;
        }

        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #cbd5e1;
            text-align: center;
        }
    </style>
</head>

<body>
    <table class="wrapper">
        <tr>
            <td align="center">

                <table class="card">
                    <tr>
                        <td>

                            <h1 class="title">Welcome 👋</h1>

                            <p class="description">
                                Just one more step to activate your account.<br>
                                Click the button below to verify your email.
                            </p>

                            <a href="{{ $verificationLink }}" class="button">
                                Verify Email
                            </a>

                            <p class="note">
                                If you did not create an account, you can safely ignore this email.
                            </p>

                        </td>
                    </tr>
                </table>

                <p class="footer">
                    © {{ date('Y') }} • All rights reserved
                </p>

            </td>
        </tr>
    </table>
</body>
</html>