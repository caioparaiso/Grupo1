<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quem Somos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .hero {
            background: url('https://source.unsplash.com/1920x1080/?education,team') no-repeat center center/cover;
            height: 50vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
        }
        .hero h1 {
            font-size: 3.5rem;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.7);
        }
        .hero p {
            font-size: 1.5rem;
            text-shadow: 1px 1px 6px rgba(0, 0, 0, 0.5);
        }
        .about-section {
            padding: 50px 20px;
            background-color: white;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            margin: -50px auto 30px;
            border-radius: 15px;
            max-width: 900px;
        }
        .about-section h2 {
            color: #007bff;
            margin-bottom: 20px;
            text-align: center;
        }
        .about-section p {
            font-size: 1.1rem;
            line-height: 1.8;
            text-align: justify;
            margin-bottom: 20px;
        }
        .team-section {
            padding: 30px 20px;
            text-align: center;
            background-color: #f8f9fa;
        }
        .team-section h2 {
            margin-bottom: 30px;
            color: #007bff;
        }
        .team-member {
            margin-bottom: 30px;
        }
        .team-member img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            margin-bottom: 15px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        .team-member h4 {
            margin-bottom: 5px;
            font-size: 1.2rem;
            color: #333;
        }
        .team-member p {
            font-size: 0.9rem;
            color: #666;
        }
    </style>
</head>
<body>

    <!-- Hero Section -->
    <div class="hero">
        <div>
            <h1>Quem Somos</h1>
            <p>Conheça a nossa história, valores e missão</p>
        </div>
    </div>

    <!-- About Section -->
    <div class="about-section">
        <h2>Sobre Nós</h2>
        <p>
            Fundada com a missão de proporcionar educação de qualidade e transformar vidas, a Escola ITA é mais do que uma instituição de ensino; é uma comunidade de aprendizado, inovação e crescimento. Ao longo dos anos, temos nos dedicado a oferecer uma experiência educacional completa, combinando tradição com as mais modernas abordagens pedagógicas.
        </p>
        <p>
            Nosso compromisso é com o sucesso dos nossos alunos. Trabalhamos diariamente para criar um ambiente acolhedor, onde cada estudante possa alcançar seu máximo potencial. Estamos localizados em uma região estratégica, com fácil acesso e infraestrutura moderna, pronta para atender às demandas do século XXI.
        </p>
    </div>

    <!-- Team Section -->
    <div class="team-section">
        <h2>Direção</h2>
        <div class="row justify-content-center">
            <div class="col-md-3 team-member">
                <img src="../img/direcao.png" alt="Diretora">
                <h4>Silvia Areias</h4>
                <p>Diretora do ITA</p>
            </div>
            <div class="col-md-3 team-member">
                <img src="../img/direcao.png" alt="Coordenadora">
                <h4>Diana Saraiva</h4>
                <p>Diretora da AS</p>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
