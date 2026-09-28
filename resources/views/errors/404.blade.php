<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f8f9fa;
        }
        .error-page {
            text-align: center;
            color: #333;
        }
        .error-page h1 {
            font-size: 8rem;
            margin-bottom: 1rem;
            font-weight: bold;
            color: #ff6b6b;
        }
        .error-page h2 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }
        .error-page p {
            font-size: 1rem;
            margin-bottom: 2rem;
        }
        .btn-home {
            padding: 0.75rem 2rem;
            background-color: #ff6b6b;
            color: white;
            border: none;
            border-radius: 50px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .btn-home:hover {
            background-color: #d9534f;
        }
    </style>
</head>
<body>

<div class="error-page">
    <h1>404</h1>
    <h2>Oops! Page Not Found</h2>
    <p>Sorry, the page you are looking for does not exist or has been moved.</p>
    <a href="{{ url('/') }}" class="btn-home">Go Back Home</a>
</div>

</body>
</html>
