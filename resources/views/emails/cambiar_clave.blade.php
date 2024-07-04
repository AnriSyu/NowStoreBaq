<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperación de clave</title>
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
            background-color: #BC3475;
            color: #fff;
            text-decoration: none;
            padding: 12px 20px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        a:hover {
            background-color: #a83265;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Recuperación de cuenta</h1>
    <p>Hemos recibido una solicitud para cambiar tu clave. Si no solicitaste un cambio de clave, por favor ignora este correo.</p>
    <p>Para cambiar tu clave, haz clic en el siguiente botón:</p>
    <a href="{{ url('/cambiar_clave/' . $token) }}">Cambiar mi clave</a>
    <p>Si no puedes hacer clic en el botón, copia y pega el siguiente enlace en la barra de direcciones de tu navegador:</p>
    <p>{{ url('/cambiar_clave/' . $token) }}</p>
    <p>Este enlace caducará en 60 minutos. Si no cambias tu clave dentro de este tiempo, deberás solicitar un nuevo enlace de recuperación.</p>
    <p>¡Gracias por utilizar nuestros servicios!</p>
    <p>El equipo de NowStoreBaq</p>
</div>
</body>
</html>
