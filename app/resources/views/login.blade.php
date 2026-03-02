<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        /* Corrige inputs que vazam o card */
        * {
            box-sizing: border-box;
        }

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
            max-width: 480px;
            width: 100%;
            background-color: #ffffff;
            border-radius: 16px;
            padding: 40px 30px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }

        h1.title {
            margin: 0 0 12px;
            font-size: 24px;
            color: #0f172a;
            text-align: center;
        }

        p.description {
            margin: 0 0 28px;
            font-size: 15px;
            color: #64748b;
            line-height: 1.6;
            text-align: center;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 14px 16px;
            margin-bottom: 16px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 15px;
        }

        .button {
            display: inline-block;
            width: 100%;
            padding: 14px 28px;
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
            text-align: center;
        }

        .link {
            color: #2563eb;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="card">
            <h1 class="title">Welcome Back 👋</h1>
            <p class="description">Log in with your email and password.</p>

            <form>
                <input type="email" placeholder="Email" required>
                <input type="password" placeholder="Password" required>
                <button type="submit" class="button">Log In</button>
            </form>

            <p class="note">
                Forgot your password? <a href="reset.html" class="link">Reset here</a>
            </p>
            <p class="note">
                Don't have an account? <a href="signup.html" class="link">Sign Up</a>
            </p>
        </div>
    </div>
</body>

</html>