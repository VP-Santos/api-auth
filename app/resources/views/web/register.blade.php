@extends('layouts.app')

@section('title', 'register')

@section('style')

<style>
    .error {
        color: red;
        font-size: 12px;
        margin-top: 4px;
    }

    .input-error {
        border: 1px solid red;
    }

    input {
        display: block;
        margin-bottom: 5px;
    }

    label {
        margin-bottom: 15px;
        display: block;
    }
</style>

@endsection

@section('content')
<h1>register</h1>

<div>
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
        <select id="access_level" autocomplete="off">
            <option selected></option>
            <option value="basic">user</option>
            <option value="adm">admin</option>
        </select>
        <div class="error" id="error_access_level"></div>
    </label>
</div>

<button id="btn">Send</button>
<a href="{{ route('homepage') }}">Return</a>

@endsection

@section('script')

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const button = document.getElementById('btn');
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const REGISTER_URL = "{{ route('register.auth') }}";

        function clearErrors() {
            document.querySelectorAll('.error').forEach(el => el.innerText = '');
            document.querySelectorAll('input').forEach(el => el.classList.remove('input-error'));
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