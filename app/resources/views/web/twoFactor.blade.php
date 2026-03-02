<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Two-Factor Authentication</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #0f172a, #1e293b);
            font-family: 'Segoe UI', Arial, Helvetica, sans-serif;
        }

        .wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .card {
            max-width: 400px;
            width: 100%;
            background-color: #ffffff;
            border-radius: 16px;
            padding: 40px 30px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        h1.title {
            margin: 0 0 12px;
            font-size: 24px;
            color: #0f172a;
        }

        p.description {
            margin: 0 0 28px;
            font-size: 15px;
            color: #64748b;
            line-height: 1.6;
        }

        input[type="text"] {
            width: 60px;
            padding: 14px 0;
            margin: 0 6px;
            text-align: center;
            font-size: 18px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
        }

        .button {
            display: inline-block;
            width: 100%;
            padding: 14px 28px;
            margin-top: 24px;
            background-color: #2563eb;
            color: #ffffff;
            text-decoration: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            text-align: center;
            transition: 0.3s;
            border: none;
            cursor: pointer;
        }

        .button:hover {
            background-color: #1d4ed8;
        }

        .note {
            margin-top: 16px;
            font-size: 13px;
            color: #94a3b8;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="card">
            <h1 class="title">Two-Factor Verification 🔒</h1>
            <p class="description">Enter the 6-digit code sent to your email or authenticator app.</p>

            <form>
                <div>
                    <input type="text" maxlength="1" required>
                    <input type="text" maxlength="1" required>
                    <input type="text" maxlength="1" required>
                    <input type="text" maxlength="1" required>
                    <input type="text" maxlength="1" required>
                    <input type="text" maxlength="1" required>
                </div>
                <button type="submit" class="button">Verify</button>
            </form>

            <p class="note">Didn't receive the code? <a href="#" style="color:#2563eb;">Resend</a></p>
        </div>
    </div>
</body>

</html>