<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Localização</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }
        .container {
            margin-top: 50px;
            padding: 30px;
            text-align: center;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            margin-bottom: 20px;
            color: #007bff;
            font-weight: bold;
            font-size: 2.5rem;
        }
        p {
            font-size: 18px;
            line-height: 1.6;
            margin-bottom: 30px;
            color: #555;
        }
        .images-row {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 20px;
        }
        .images-row img {
            max-width: 48%;
            height: auto;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .map-button a {
            padding: 12px 30px;
            font-size: 16px;
            color: #ffffff;
            background: #4287f5;
            border-radius: 5px;
            text-decoration: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: background 0.3s ease, transform 0.2s ease;
        }
        .map-button a:hover {
            background: #4287f5;
            transform: translateY(-3px);
        }
        footer {
            margin-top: 50px;
            padding: 20px 0;
            background: #007bff;
            color: white;
            text-align: center;
        }
        footer a {
            color: #fff;
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Localização da Escola ITA</h1>
    <p>
        A Escola ITA está situada em uma localização estratégica, de fácil acesso tanto para transporte público quanto para quem vem de carro. 
        Estamos a poucos minutos da estação de metrô central, e o trajeto é simples e direto.
    </p>
    <p>
        Veja abaixo o mapa do percurso recomendado para chegar até a escola a partir das principais linhas de metrô:
    </p>

    <!-- Imagens lado a lado -->
    <div class="images-row">
        <img src="../img/caminho_metro.png" alt="Mapa do Caminho de Metrô">
        <img src="../img/google_maps.png" alt="Google Maps">
    </div>

    <!-- Botão para o Google Maps -->
    <div class="map-button">
        <a href="https://www.google.com/maps/dir/?api=1&destination=R.+Eng.+Fernando+Vicente+Mendes+5A,+1600-880+Lisboa&travelmode=driving" 
           target="_blank" 
           rel="noopener noreferrer">
            Ver Rota no Google Maps
        </a>
    </div>
</div>  
<footer>
    <p>© 2024 Escola ITA. Todos os direitos reservados. <a href="#">Política de Privacidade</a></p>
</footer>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
