<?php
// index.php - Página única com conteúdo sobre o curso

// Definir a variável para a página atual
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Função para carregar o conteúdo da página
function get_page_content($page) {
    switch ($page) {
        case 'home':
            return '
                <h2>Bem-vindo ao Curso de Técnico de Informática - Sistemas</h2>
                <p>O curso de Técnico de Informática - Sistemas forma profissionais capazes de atuar no desenvolvimento, manutenção e suporte de sistemas informáticos. Durante a formação, os alunos aprendem a configurar redes, administrar servidores, desenvolver software e implementar soluções tecnológicas para diversos setores.</p>
                
                <h3>Objetivos do curso:</h3>
                <ul>
                    <li>Desenvolver competências em programação e desenvolvimento de software.</li>
                    <li>Gerir e administrar sistemas operacionais e servidores.</li>
                    <li>Configurar redes e equipamentos de TI.</li>
                    <li>Implementar e manter soluções de segurança em sistemas informáticos.</li>
                </ul>
            ';
        case 'estudos':
            return '
                <h2>O que se aprende no curso</h2>
                <p>O curso de Técnico de Informática - Sistemas oferece uma formação prática e teórica que cobre uma ampla gama de competências. Entre os temas abordados, destacam-se:</p>
                
                <h3>Conteúdos do curso:</h3>
                <ul>
                    <li><strong>Programação:</strong> Desenvolvimento de software utilizando diversas linguagens de programação, como Java, Python e C++.</li>
                    <li><strong>Redes de Computadores:</strong> Fundamentos de redes, protocolos de comunicação, configuração de redes locais (LAN) e redes de longa distância (WAN).</li>
                    <li><strong>Sistemas Operacionais:</strong> Instalação, configuração e administração de sistemas operacionais, como Windows, Linux e servidores.</li>
                    <li><strong>Segurança Informática:</strong> Implementação de medidas de segurança em redes, servidores e aplicações, incluindo criptografia e firewalls.</li>
                    <li><strong>Hardware:</strong> Identificação e manutenção de componentes de hardware, como processadores, memórias, e discos rígidos.</li>
                    <li><strong>Gestão de Projetos:</strong> Planejamento, execução e monitoramento de projetos tecnológicos.</li>
                </ul>
            ';
        case 'contacto':
            return '
                <h2>Contacto</h2>
                <p>Se você tiver dúvidas sobre o curso ou quiser mais informações, entre em contato conosco através dos seguintes meios:</p>
                <ul>
                    <li><strong>Horario:</strong> 8:00 - 20:00</li>
                    <li><strong>Telefone:</strong> +351 215 850 959</li>
                    <li><strong>Endereço:</strong> R. Eng. Fernando Vicente Mendes nº5A, 1600-880 Lisboa</li>
                </ul>
            ';
        default:
            return '<h2>Página não encontrada</h2>';
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Técnico de Informática - Sistemas</title>
    <style>
        /* estilos CSS embutidos para simplificar */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 80%;
            margin: 0 auto;
        }

        header {
            background-color: #007BFF;
            color: white;
            padding: 10px 0;
            text-align: center;
        }

        header h1 {
            margin: 0;
        }

        nav ul {
            list-style-type: none;
            padding: 0;
        }

        nav ul li {
            display: inline;
            margin-right: 20px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            font-size: 16px;
        }

        nav ul li a:hover {
            text-decoration: underline;
        }

        main {
            background-color: #fff;
            padding: 20px 0;
        }

        footer {
            background-color: #007BFF;
            color: white;
            padding: 10px 0;
            text-align: center;
        }

        footer p {
            margin: 0;
        }

        ul {
            list-style-type: disc;
            padding-left: 20px;
        }

        h2 {
            color: #333;
        }

        h3 {
            color: #007BFF;
        }
    </style>
</head>
<body>

    <!-- Cabeçalho -->
    <header>
        <div class="container">
            <h1>Curso Técnico de Informática - Sistemas</h1>
            <nav>
                <ul>
                    <li><a href="?page=home">Início</a></li>
                    <li><a href="?page=estudos">O que se aprende</a></li>
                    <li><a href="?page=contacto">Contacto</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Conteúdo principal -->
    <main>
        <div class="container">
            <?php echo get_page_content($page); ?>
        </div>
    </main>

    <!-- Rodapé -->
    <footer>
        <div class="container">
            <p>&copy; 2024 - Todos os direitos reservados. Curso Técnico de Informática - Sistemas.</p>
        </div>
    </footer>

</body>
</html>
