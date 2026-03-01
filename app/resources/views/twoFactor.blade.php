<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Two-Factor Verification</title>
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
            font-size: 22px;
            color: #0f172a;
            text-align: center;
        }

        .description {
            margin: 0 0 24px;
            font-size: 15px;
            color: #64748b;
            line-height: 1.6;
            text-align: center;
        }

        .code-box {
            margin: 0 auto 24px;
            padding: 16px 24px;
            background-color: #f9fafb;
            border: 1px dashed #d1d5db;
            border-radius: 8px;
            font-size: 28px;
            font-weight: bold;
            letter-spacing: 6px;
            color: #0f172a;
            text-align: center;
            width: fit-content;
        }

        .note {
            margin: 0 0 8px;
            font-size: 13px;
            color: #94a3b8;
            text-align: center;
        }

        .extra-note {
            margin: 24px 0 0;
            font-size: 13px;
            color: #94a3b8;
            line-height: 1.6;
            text-align: center;
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

                            <h1 class="title">Two-Factor Verification</h1>

                            <p class="description">
                                Use the code below to complete your secure login.
                            </p>

                            <div class="code-box">
                                {{ $twoFactor }}
                            </div>

                            <p class="note">
                                This code will expire in a few minutes.
                            </p>

                            <p class="extra-note">
                                If you did not request this code, you can safely ignore this email or we recommend changing your password.
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