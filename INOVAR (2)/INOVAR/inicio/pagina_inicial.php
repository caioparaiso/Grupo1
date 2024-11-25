<!DOCTYPE html>
<html lang="pt">
<head>
    <title>Página Inicial da Escola</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .navbar {
            background-color: #007bff;
            padding: 1rem;
        }
        .navbar-brand, .nav-link {
            color: #ffffff;
        }
        .nav-link:hover {
            color: #e0e0e0;
        }
        .container {
            padding: 0;
        }
        .dropdown:hover .dropdown-menu {
            display: block;
        }
        .logo-container {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            background-color: white;
            border-radius: 5px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }
        .logo-container img {
            height: 70px; /* Aumente para o tamanho desejado */
            width: auto;  /* Mantém a proporção */
            margin-bottom: 2px;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <div class="logo-container">
            <a href="pagina_inicial.php">
                <img src="../img/logo.png" alt="Logo ITA" />
            </a>
        </div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <!-- Item Cursos com Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="pagina_inicial_cursos.php" id="navbarCursos" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Cursos
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarCursos">
                        <li><a class="dropdown-item" href="tis.php">TIS</a></li>
                        <li><a class="dropdown-item" href="tigr.php">TIGR</a></li>
                        <li><a class="dropdown-item" href="tm.php">TM</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="localizacao.php">Localização</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="quem_somos.php">Quem Somos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Escola</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index_alunos.php">Alunos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="candidatura.php">Candidatar-se</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
