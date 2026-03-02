<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Input</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

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
</head>

<body>

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
        <input type="text" id="access_level" autocomplete="off">
        <div class="error" id="error_access_level"></div>
    </label>
</div>

<button id="send_register">Send</button>
<a href="{{ route('homepage') }}">Return</a>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const button = document.getElementById('send_register');
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const url = "{{ route('register.auth') }}";

    function clearErrors() {
        document.querySelectorAll('.error').forEach(el => el.innerText = '');
        document.querySelectorAll('input').forEach(el => el.classList.remove('input-error'));
    }

    button.addEventListener('click', function () {

        clearErrors();

        const data = {
            name: document.getElementById('full_name').value,
            user_name: document.getElementById('login_user').value,
            email: document.getElementById('user_email').value,
            password: document.getElementById('user_password').value,
            access_level: document.getElementById('access_level').value
        };

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify(data)
        })
        .then(async response => {

            const result = await response.json();

            if (!response.ok) {
                
                if (result.message && typeof result.message === 'object') {

                    const fieldMap = {
                        name: 'full_name',
                        user_name: 'login_user',
                        email: 'user_email',
                        password: 'user_password',
                        access_level: 'access_level'
                    };

                    Object.keys(result.message).forEach(field => {

                        const inputId = fieldMap[field];
                        const input = document.getElementById(inputId);
                        const errorDiv = document.getElementById('error_' + field);

                        if (errorDiv) {
                            errorDiv.innerText = result.message[field][0];
                        }

                        if (input) {
                            input.classList.add('input-error');
                        }
                    });
                }

                throw new Error('Validation error');
            }

            return result;
        })
        .then(result => {
            alert('Registration successful!');
            console.log(result);
        })
        .catch(error => {
            console.error(error.message);
        });

    });

});
</script>

</body>
</html>