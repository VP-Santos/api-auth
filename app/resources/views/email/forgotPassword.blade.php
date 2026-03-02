<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Password Reset</title>
    <link rel="stylesheet" href="email.css">
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
        }

        .title {
            margin: 0 0 12px;
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
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            transition: 0.3s;
        }

        .button:hover {
            background-color: #1d4ed8;
        }

        .note {
            margin: 30px 0 0;
            font-size: 13px;
            color: #94a3b8;
            line-height: 1.6;
        }

        .expiry {
            margin: 16px 0 0;
            font-size: 12px;
            color: #cbd5e1;
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
                        <td align="center">

                            <h1 class="title">
                                Reset Your Password 🔐
                            </h1>

                            <p class="description">
                                We received a request to reset your password.
                                Click the button below to create a new one.
                            </p>

                            <a href="{{ $link }}" class="button">
                                Reset Password
                            </a>

                            <p class="note">
                                If you did not request a password reset,
                                you can safely ignore this email.
                            </p>

                            <p class="expiry">
                                For security reasons, this link may expire.
                            </p>

                        </td>
                    </tr>
                </table>

                <p class="footer">
                    © {{ date('Y') }} • Security first
                </p>

            </td>
        </tr>
    </table>

</body>

</html>