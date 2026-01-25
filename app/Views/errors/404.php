<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= _('404 - Page Not Found') ?></title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f8f9fa; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; }
        .container { text-align: center; }
        h1 { font-size: 8rem; margin: 0; color: #dee2e6; }
        p { font-size: 1.5rem; color: #6c757d; margin-top: -20px; }
        .btn { display: inline-block; margin-top: 20px; padding: 10px 25px; background: #007bff; color: white; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>404</h1>
        <p><?= _('Sorry, the page you are looking for was not found.') ?></p>
        <a href="/" class="btn"><?= _('Back to Home') ?></a>
    </div>
</body>
</html>