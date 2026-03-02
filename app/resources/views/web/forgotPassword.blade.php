<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>forgot password</h1>
    <label for="email">seu email</label>
    <input type="email" name="email">
    <button id="btn"></button>
    <a href="{{ route('login.web') }}">Back</a>
</body>
    <script>
        document.addEventListener('DOMContentLoaded', function(){
            const btn = document.getElementById('btn');

            btn.addEventListener('click', function(){
                
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
                        window.location.href = '/';
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        })
    </script>
</html>