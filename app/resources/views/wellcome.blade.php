<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        /* Reset & Base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #0f172a, #1e293b);
            color: #ffffff;
        }

        /* Container */
        .container {
            width: 100%;
            max-width: 960px;
            padding: 40px 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        /* Card */
        .card {
            background-color: #ffffff;
            color: #0f172a;
            padding: 60px 40px;
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            max-width: 600px;
            width: 100%;
        }

        h1 {
            font-size: 36px;
            margin-bottom: 16px;
        }

        p.subtitle {
            font-size: 18px;
            color: #64748b;
            margin-bottom: 36px;
            line-height: 1.6;
        }

        /* Buttons */
        .btn {
            display: inline-block;
            padding: 14px 32px;
            background-color: #2563eb;
            color: #ffffff;
            text-decoration: none;
            font-size: 16px;
            font-weight: 600;
            border-radius: 8px;
            margin: 0 8px;
            transition: 0.3s;
        }

        .btn:hover {
            background-color: #1d4ed8;
        }

        /* Footer */
        .footer {
            margin-top: 40px;
            font-size: 12px;
            color: #94a3b8;
        }

        /* Responsive */
        @media (max-width: 640px) {
            .card {
                padding: 40px 20px;
            }

            h1 {
                font-size: 28px;
            }

            p.subtitle {
                font-size: 16px;
            }

            .btn {
                padding: 12px 24px;
                font-size: 15px;
                margin: 8px 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h1>Welcome to Our Platform 👋</h1>
            <p class="subtitle">
                We’re thrilled to have you here! Start exploring features, setting up your profile, and making the most out of our platform.
            </p>

            <div>
                <a href="/dashboard" class="btn">Get Started</a>
                <a href="/learn-more" class="btn">Learn More</a>
            </div>
        </div>

        <div class="footer">
            © {{ date('Y') }} • Safety first
        </div>
    </div>
</body>
</html>