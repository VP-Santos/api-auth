<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Código de verificação</title>
</head>

<body style="margin:0; padding:0; background-color:#f4f6f8; font-family:Arial, Helvetica, sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f6f8; padding:40px 0;">
        <tr>
            <td align="center">
                <table width="100%" max-width="480" cellpadding="0" cellspacing="0"
                    style="background-color:#ffffff; border-radius:8px; padding:32px; box-shadow:0 4px 12px rgba(0,0,0,0.08);">
                    <tr>
                        <td align="center">
                            <h1 style="margin:0 0 12px; font-size:22px; color:#111827;">
                                Verificação em duas etapas
                            </h1>

                            <p style="margin:0 0 24px; font-size:16px; color:#4b5563; line-height:1.5;">
                                Use o código abaixo para concluir seu login com segurança.
                            </p>

                            <div style="margin:0 auto 24px; padding:16px 24px; background-color:#f9fafb;
                                        border:1px dashed #d1d5db; border-radius:8px;
                                        font-size:28px; font-weight:bold; letter-spacing:6px; color:#111827;">
                                {{ $twoFactor }}
                            </div>

                            <p style="margin:0 0 8px; font-size:14px; color:#6b7280;">
                                Este código expira em alguns minutos.
                            </p>

                            <p style="margin:24px 0 0; font-size:14px; color:#6b7280; line-height:1.5;">
                                Se você não solicitou este código, ignore este e-mail ou
                                recomendamos alterar sua senha.
                            </p>
                        </td>
                    </tr>
                </table>

                <p style="margin-top:16px; font-size:12px; color:#9ca3af;">
                    © {{ date('Y') }} • Segurança em primeiro lugar
                </p>
            </td>
        </tr>
    </table>
</body>

</html>