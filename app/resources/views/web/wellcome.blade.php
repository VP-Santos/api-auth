@extends('layouts.app')

@section('title', 'Bem vindo')
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

    .button {
        display: inline-block;
        padding: 14px 28px;
        background-color: #2563eb;
        color: #ffffff;
        text-decoration: none;
        font-size: 15px;
        font-weight: 600;
        border-radius: 8px;
        margin: 8px;
        transition: 0.3s;
    }

    .button:hover {
        background-color: #1d4ed8;
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
    <h1>Bem-vindo! 👋</h1>
    <h3>Este projeto visa mostrar meu conhecimento com Laravel e PHP.</h3>

    <a href="{{ route('register.web') }}" class="button">Registrar</a>
    <a href="{{ route('login.web') }}" class="button">Login</a>

    <p class="footer">© {{ date('Y') }} • Todos os direitos reservados</p>
</div>
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function(){

    });
</script>
@endsection