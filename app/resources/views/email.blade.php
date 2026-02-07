<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Verifique seu e-mail</title>
</head>

<body style="margin:0; padding:0; background-color:#f4f6f8; font-family:Arial, Helvetica, sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f6f8; padding:40px 0;">
        <tr>
            <td align="center">
                <table width="100%" max-width="480" cellpadding="0" cellspacing="0" style="background-color:#ffffff; border-radius:8px; padding:32px; box-shadow:0 4px 12px rgba(0,0,0,0.08);">
                    <tr>
                        <td align="center">
                            <h1 style="margin:0 0 16px; font-size:24px; color:#111827;">
                                Bem-vindo 👋
                            </h1>
                            <p style="margin:0 0 24px; font-size:16px; color:#4b5563; line-height:1.5;">
                                Falta só um passo para ativar sua conta.<br>
                                Clique no botão abaixo para confirmar seu e-mail.
                            </p>

                            <a href="{{ $verificationLink }}"
                                style="display:inline-block; padding:14px 28px; background-color:#2563eb; color:#ffffff; text-decoration:none; font-size:16px; font-weight:bold; border-radius:6px;">
                                Verificar e-mail
                            </a>

                            <p style="margin:32px 0 0; font-size:14px; color:#6b7280; line-height:1.5;">
                                Se você não criou uma conta, pode ignorar este e-mail com segurança.
                            </p>
                        </td>
                    </tr>
                </table>

                <p style="margin-top:16px; font-size:12px; color:#9ca3af;">
                    © {{ date('Y') }} • Todos os direitos reservados
                </p>
            </td>
        </tr>
    </table>
</body>

</html>