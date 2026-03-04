@extends('layouts.app')

@section('title', 'Email Verification')

@section('style')
<style>
body {
    margin: 0;
    padding: 0;
    background: linear-gradient(135deg, #0f172a, #1e293b);
    font-family: 'Segoe UI', Arial, Helvetica, sans-serif;
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
    text-align: center;
}

h1 {
    margin: 0 0 16px;
    font-size: 24px;
    color: #0f172a;
}

h3 {
    margin: 0 0 28px;
    font-size: 15px;
    color: #64748b;
    line-height: 1.6;
}

/* Loader */
.loader {
    margin: 20px auto;
    border: 4px solid #e2e8f0;
    border-top: 4px solid #2563eb;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    100% { transform: rotate(360deg); }
}

.footer {
    margin-top: 32px;
    font-size: 12px;
    color: #cbd5e1;
    text-align: center;
}
</style>
@endsection

@section('content')
<div class="card">
    <h1>Verifying your email...</h1>
    <h3 id="status">Please wait while we validate your information.</h3>

    <div class="loader"></div>

    <p class="footer">© {{ date('Y') }} • All rights reserved</p>
</div>
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', async function () {
    const token = new URLSearchParams(window.location.search).get('token');
    const VERIFY_URL = "{{ route('verify.auth') }}";
    const status = document.getElementById('status');

    if (!token) {
        status.innerText = "Invalid token.";
        return;
    }

    try {
        const response = await fetch(VERIFY_URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ token })
        });

        const data = await response.json();
        
        if(!data.success){
            throw Error(data.message);
        }
        
        localStorage.setItem('auth_token', data.token);

        status.innerText = data.message;

        // setTimeout(() => {
        //     window.location.href = '/';
        // }, 800);

    } catch (e) {
        status.innerText = e.message || "An error occurred while verifying your email.";
    }
});
</script>
@endsection