<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Input</title>
    <!-- Laravel gera o token via Blade -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <div>
        <label>
            Name:
            <input type="text" id="full_name" placeholder="Enter your name" autocomplete="off">
        </label>
        <br>
        <label>
            Username:
            <input type="text" id="login_user" placeholder="Enter your username" autocomplete="new-username">
        </label>
        <br>
        <label>
            Email:
            <input type="email" id="user_email" placeholder="Enter your email" autocomplete="email">
        </label>
        <br>
        <label>
            Password:
            <input type="password" id="user_password" placeholder="Enter your password" autocomplete="new-password">
        </label>
        <br>
        <label>
            Access Level:
            <input type="text" id="access_level" placeholder="Enter access level" autocomplete="off">
        </label>
    </div>
    <button id="send_register">Send</button>
    <a href="{{ route('forgotPassword.web') }}">esqueceu a senha?</a>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const button = document.getElementById('send_register');

            button.addEventListener('click', function() {
                // Captura os valores
                const data = {
                    name: document.getElementById('full_name').value,
                    user_name: document.getElementById('login_user').value,
                    email: document.getElementById('user_email').value,
                    password: document.getElementById('user_password').value,
                    access_level: document.getElementById('access_level').value
                };

                // Pega o token CSRF
                const token = "{{ csrf_token() }}"
                const url = "{{ route('register.auth') }}";
                // Envia via fetch para a rota Laravel
                fetch(url, { // ou a rota que você criou
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token
                        },
                        body: JSON.stringify(data)
                    })
                    .then(response => response.json()) // Laravel normalmente retorna JSON
                    .then(result => {
                        console.log('Success:', result);
                        alert(result.message || 'Registration successful');
                        window.location.href = '/';
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });
    </script>
</body>

</html>