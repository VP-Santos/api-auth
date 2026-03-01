<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        /* Reset & base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #0f172a, #1e293b);
        }

        /* Card */
        .card {
            width: 100%;
            max-width: 420px;
            background: #ffffff;
            padding: 40px 30px;
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }

        /* Title & subtitle */
        h2 {
            text-align: center;
            margin-bottom: 8px;
            color: #0f172a;
        }

        .subtitle {
            text-align: center;
            margin-bottom: 25px;
            font-size: 14px;
            color: #64748b;
        }

        /* Form */
        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-size: 14px;
            color: #334155;
        }

        input {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #cbd5e1;
            outline: none;
            transition: 0.3s;
            font-size: 14px;
        }

        input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.2);
        }

        /* Button */
        .btn {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            background: #2563eb;
            color: white;
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 10px;
        }

        .btn:hover {
            background: #1d4ed8;
        }

        /* Footer */
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #94a3b8;
        }
    </style>
</head>

<body>
    <div class="card">
        <h2>Reset Password</h2>
        <p class="subtitle">Enter your new password below.</p>

        <form method="POST" action="/reset-password">
            <!-- Hidden token -->
            <input type="hidden" name="token" id="token">

            <div class="form-group">
                <label for="password">New Password</label>
                <input name="password" id="password" type="password" required>
            </div>

            <div class="form-group">
                <label for="confirm">Confirm New Password</label>
                <input name="confirm" id="confirm" type="password" required>
            </div>

            <button type="submit" class="btn">
                Save New Password
            </button>
        </form>

        <div class="footer">
            © {{ date('Y') }} • Safety first
        </div>
    </div>

    <script>
        // Capture token from URL
        const params = new URLSearchParams(window.location.search);
        const token = params.get("token");

        if (token) {
            document.getElementById("token").value = token;
        }
    </script>
</body>

</html>