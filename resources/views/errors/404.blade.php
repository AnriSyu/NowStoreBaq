<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
            color: #333;
            font-family: Arial, sans-serif;
        }
        .error-container {
            text-align: center;
        }
        .error-container h1 {
            font-size: 3em;
        }
        .error-container p {
            margin: 20px 0;
        }
        .error-container a {
            color: #007bff;
            text-decoration: none;
        }
        .error-container a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="error-container">
    <h1>404</h1>
    <p>Oops! La página que estás buscando no pudo ser encontrada.</p>
    <a href="{{ url('/') }}">Volver a la página principal</a>
</div>
</body>
</html>
