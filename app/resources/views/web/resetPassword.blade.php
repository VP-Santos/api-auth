@extends('layouts.app')

@section('title', 'Reset Password')

@section('style')
<style>
    body {
        background: linear-gradient(135deg, #0f172a, #1e293b);
        font-family: 'Segoe UI', Arial, Helvetica, sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .card {
        background-color: #ffffff;
        border-radius: 16px;
        padding: 40px 30px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        width: 100%;
        max-width: 480px;
        text-align: center;
    }

    h1 {
        margin-bottom: 16px;
        font-size: 24px;
        color: #0f172a;
    }

    label {
        display: block;
        margin-bottom: 16px;
        text-align: left;
        font-weight: 500;
        color: #0f172a;
    }

    input {
        width: 100%;
        padding: 10px 12px;
        margin-top: 4px;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        font-size: 14px;
        box-sizing: border-box;
    }

    .input-error {
        border: 1px solid red;
    }

    .error {
        color: red;
        font-size: 12px;
        margin-top: 4px;
    }

    .button {
        display: inline-block;
        width: 100%;
        padding: 14px 0;
        background-color: #2563eb;
        color: #ffffff;
        font-size: 15px;
        font-weight: 600;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        transition: 0.3s;
        margin-bottom: 10px;
    }

    .button:hover {
        background-color: #1d4ed8;
    }

    .links {
        margin-top: 12px;
        font-size: 13px;
        display: flex;
        justify-content: space-between;
    }

    .links a {
        color: #2563eb;
        text-decoration: none;
    }

    .links a:hover {
        text-decoration: underline;
    }
</style>
@endsection

@section('content')
<div class="card">
    <h1>Reset Password 🔒</h1>

    <label>
        New Password:
        <input type="password" id="new_password" placeholder="Enter your new password" autocomplete="new-password">
        <div class="error" id="error_new_password"></div>
    </label>

    <label>
        Confirm Password:
        <input type="password" id="confirm_password" placeholder="Confirm your password" autocomplete="new-password">
        <div class="error" id="error_confirm_password"></div>
    </label>

    <button id="btn" class="button">Send</button>

    <div class="links">
        <a href="{{ route('forgotPassword.web') }}">Forgot Password?</a>
        <a href="{{ route('homepage') }}">Return</a>
    </div>
</div>
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const button = document.getElementById('btn');
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const RESET_URL = "{{ route('reset.auth') }}"; // Ajuste para sua rota de reset

    function clearErrors() {
        document.querySelectorAll('.error').forEach(el => el.innerText = '');
        document.querySelectorAll('input').forEach(el => el.classList.remove('input-error'));
    }

    button.addEventListener('click', function() {
        clearErrors();

        const data = {
            password: document.getElementById('new_password').value,
            confirm_password: document.getElementById('confirm_password').value,
        };

        fetch(RESET_URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify(data)
        })
        .then(async response => {
            const result = await response.json();

            if (response.status === 422) {
                const fieldMap = {
                    password: 'new_password',
                    confirm_password: 'confirm_password'
                };

                Object.keys(result.message || {}).forEach(field => {
                    const inputId = fieldMap[field];
                    const input = document.getElementById(inputId);
                    const errorDiv = document.getElementById('error_' + field);

                    if (errorDiv) errorDiv.innerText = result.message[field][0];
                    if (input) input.classList.add('input-error');
                });

                return null;
            }

            if (!response.ok) {
                throw new Error(result.message || 'Erro inesperado');
            }

            return result;
        })
        .then(result => {
            if (result) {
                Swal.fire({
                    title: 'Sucesso!',
                    text: result.message,
                    icon: 'success'
                });
            }
        })
        .catch(error => {
            if (error.message !== 'Validation error') {
                Swal.fire({
                    title: 'Erro!',
                    text: error.message,
                    icon: 'error'
                });
            }
        });
    });
});
</script>
@endsection@extends('layouts.app')

@section('title', 'Reset Password')

@section('style')
<style>
    body {
        background: linear-gradient(135deg, #0f172a, #1e293b);
        font-family: 'Segoe UI', Arial, Helvetica, sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .card {
        background-color: #ffffff;
        border-radius: 16px;
        padding: 40px 30px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        width: 100%;
        max-width: 480px;
        text-align: center;
    }

    h1 {
        margin-bottom: 16px;
        font-size: 24px;
        color: #0f172a;
    }

    label {
        display: block;
        margin-bottom: 16px;
        text-align: left;
        font-weight: 500;
        color: #0f172a;
    }

    input {
        width: 100%;
        padding: 10px 12px;
        margin-top: 4px;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        font-size: 14px;
        box-sizing: border-box;
    }

    .input-error {
        border: 1px solid red;
    }

    .error {
        color: red;
        font-size: 12px;
        margin-top: 4px;
    }

    .button {
        display: inline-block;
        width: 100%;
        padding: 14px 0;
        background-color: #2563eb;
        color: #ffffff;
        font-size: 15px;
        font-weight: 600;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        transition: 0.3s;
        margin-bottom: 10px;
    }

    .button:hover {
        background-color: #1d4ed8;
    }

    .links {
        margin-top: 12px;
        font-size: 13px;
        display: flex;
        justify-content: space-between;
    }

    .links a {
        color: #2563eb;
        text-decoration: none;
    }

    .links a:hover {
        text-decoration: underline;
    }
</style>
@endsection

@section('content')
<div class="card">
    <h1>Reset Password 🔒</h1>

    <label>
        New Password:
        <input type="password" id="new_password" placeholder="Enter your new password" autocomplete="new-password">
        <div class="error" id="error_new_password"></div>
    </label>

    <label>
        Confirm Password:
        <input type="password" id="confirm_password" placeholder="Confirm your password" autocomplete="new-password">
        <div class="error" id="error_confirm_password"></div>
    </label>

    <button id="btn" class="button">Send</button>

    <div class="links">
        <a href="{{ route('forgotPassword.web') }}">Forgot Password?</a>
        <a href="{{ route('homepage') }}">Return</a>
    </div>
</div>
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const button = document.getElementById('btn');
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const RESET_URL = "{{ route('reset.auth') }}"; // Ajuste para sua rota de reset

    function clearErrors() {
        document.querySelectorAll('.error').forEach(el => el.innerText = '');
        document.querySelectorAll('input').forEach(el => el.classList.remove('input-error'));
    }

    button.addEventListener('click', function() {
        clearErrors();

        const data = {
            password: document.getElementById('new_password').value,
            confirm_password: document.getElementById('confirm_password').value,
        };

        fetch(RESET_URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify(data)
        })
        .then(async response => {
            const result = await response.json();

            if (response.status === 422) {
                const fieldMap = {
                    password: 'new_password',
                    confirm_password: 'confirm_password'
                };

                Object.keys(result.message || {}).forEach(field => {
                    const inputId = fieldMap[field];
                    const input = document.getElementById(inputId);
                    const errorDiv = document.getElementById('error_' + field);

                    if (errorDiv) errorDiv.innerText = result.message[field][0];
                    if (input) input.classList.add('input-error');
                });

                return null;
            }

            if (!response.ok) {
                throw new Error(result.message || 'Erro inesperado');
            }

            return result;
        })
        .then(result => {
            if (result) {
                Swal.fire({
                    title: 'Sucesso!',
                    text: result.message,
                    icon: 'success'
                });
            }
        })
        .catch(error => {
            if (error.message !== 'Validation error') {
                Swal.fire({
                    title: 'Erro!',
                    text: error.message,
                    icon: 'error'
                });
            }
        });
    });
});
</script>
@endsection