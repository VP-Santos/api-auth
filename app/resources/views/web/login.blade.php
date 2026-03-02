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
            Email:
            <input type="email" id="user_email" placeholder="Enter your email" autocomplete="email">
        </label>
        <br>
        <label>
            Password:
            <input type="password" id="user_password" placeholder="Enter your password" autocomplete="new-password">
        </label>
        <br>
    </div>
    <button id="btn">Send</button>
    <a href="{{ route('forgotPassword.web') }}">esqueceu a senha?</a>
    <a href="{{ route('homepage') }}">retornar</a>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('btn');

            btn.addEventListener('click', function() {
                
                const data = {
                    email: document.getElementById('user_email').value,
                    password: document.getElementById('user_password').value,
                };

                
                const token = "{{ csrf_token() }}"
                const url = "{{ route('login.auth') }}";
                
                fetch(url, { 
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token
                        },
                        body: JSON.stringify(data)
                    })
                    .then(response => response.json()) 
                    .then(result => {
                        console.log('Success:', result);
                        alert(result.message || 'Registration successful');
                        // window.location.href = '/';
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });
    </script>
</body>

</html>