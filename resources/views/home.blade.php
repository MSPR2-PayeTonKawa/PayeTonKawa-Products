<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PTK Products API</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            background: white;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 500px;
            width: 90%;
        }
        .logo {
            font-size: 3em;
            margin-bottom: 20px;
        }
        h1 {
            color: #333;
            margin-bottom: 10px;
            font-size: 2.5em;
        }
        .subtitle {
            color: #666;
            font-size: 1.2em;
            margin-bottom: 30px;
        }
        .features {
            text-align: left;
            margin: 30px 0;
        }
        .feature {
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        .feature:last-child {
            border-bottom: none;
        }
        .status {
            background: #FF6B6B;
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
            display: inline-block;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">📦</div>
        <h1>PTK Products</h1>
        <p class="subtitle">API de Gestion des Produits</p>

        <div class="features">
            <div class="feature">✅ Catalogue de produits</div>
            <div class="feature">✅ Gestion des stocks</div>
            <div class="feature">✅ Prix et promotions</div>
            <div class="feature">✅ Catégories et filtres</div>
        </div>

        <div class="status">🟢 Service Actif</div>

        <p style="margin-top: 30px; color: #888; font-size: 0.9em;">
            PayeTonKawa - Microservice Architecture
        </p>
    </div>
</body>
</html>
