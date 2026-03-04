@extends('layouts.app')

@section('title', 'Register')

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

    input, select {
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
        justify-content: flex-end;
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
    <h1>Register 👋</h1>

    <label>
        Name:
        <input type="text" id="full_name" autocomplete="off">
        <div class="error" id="error_name"></div>
    </label>

    <label>
        Username:
        <input type="text" id="login_user" autocomplete="new-username">
        <div class="error" id="error_user_name"></div>
    </label>

    <label>
        Email:
        <input type="email" id="user_email" autocomplete="email">
        <div class="error" id="error_email"></div>
    </label>

    <label>
        Password:
        <input type="password" id="user_password" autocomplete="new-password">
        <div class="error" id="error_password"></div>
    </label>

    <label>
        Access Level:
        <select id="access_level">
            <option selected></option>
            <option value="basic">User</option>
            <option value="adm">Admin</option>
        </select>
        <div class="error" id="error_access_level"></div>
    </label>

    <button id="btn" class="button">Enviar</button>

    <div class="links">
        <a href="{{ route('homepage') }}">Return</a>
    </div>
</div>
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const button = document.getElementById('btn');
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const REGISTER_URL = "{{ route('register.auth') }}";

    function clearErrors() {
        document.querySelectorAll('.error').forEach(el => el.innerText = '');
        document.querySelectorAll('input, select').forEach(el => el.classList.remove('input-error'));
    }

    button.addEventListener('click', function() {
        clearErrors();

        const data = {
            name: document.getElementById('full_name').value,
            user_name: document.getElementById('login_user').value,
            email: document.getElementById('user_email').value,
            password: document.getElementById('user_password').value,
            access_level: document.getElementById('access_level').value
        };

        fetch(REGISTER_URL, {
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
                    name: 'full_name',
                    user_name: 'login_user',
                    email: 'user_email',
                    password: 'user_password',
                    access_level: 'access_level'
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