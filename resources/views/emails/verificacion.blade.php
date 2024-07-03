<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificación de correo electrónico</title>
    <style>
        /* Estilos generales */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
            margin: 0;
            text-align: center;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
        }
        p {
            color: #666;
            font-size: 18px;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        a {
            display: inline-block;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            padding: 12px 20px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>¡Bienvenido a NowStoreBaq!</h1>
    <p>Gracias por registrarte en nuestro sitio. Antes de comenzar, necesitamos verificar tu dirección de correo electrónico.</p>
    <p>Por favor, haz clic en el siguiente botón para verificar tu correo electrónico:</p>
    <a href="{{ url('/verificar/' . $token) }}">Verificar correo electrónico</a>
    <p>Si no puedes hacer clic en el botón, copia y pega el siguiente enlace en la barra de direcciones de tu navegador:</p>
    <p>{{ url('/verificar/' . $token) }}</p>
    <p>Este enlace de verificación caducará en 24 horas. Si no verificas tu correo electrónico dentro de este tiempo, deberás registrarte nuevamente.</p>
    <p>¡Gracias por unirte a nosotros!</p>
    <p>El equipo de NowStoreBaq</p>
</div>
</body>
</html>
