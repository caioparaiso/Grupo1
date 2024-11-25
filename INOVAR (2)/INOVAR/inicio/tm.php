<?php
// index.php - Página única com conteúdo sobre o curso

// Definir a variável para a página atual
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Função para carregar o conteúdo da página
function get_page_content($page) {
    switch ($page) {
        case 'home':
            return '
                <h2>Bem-vindo ao Curso de Técnico de Multimédia</h2>
                <p>O curso de Técnico de Multimédia prepara os alunos para trabalhar com diversas tecnologias relacionadas à produção e gestão de conteúdos multimédia. Durante o curso, os alunos aprendem a criar e manipular imagens, vídeos, áudio e animações, utilizando ferramentas profissionais de edição e produção multimédia.</p>
                
                <h3>Objetivos do curso:</h3>
                <ul>
                    <li>Desenvolver competências na criação e edição de conteúdo multimédia (imagem, vídeo, áudio, animação).</li>
                    <li>Trabalhar com softwares especializados em edição e animação digital.</li>
                    <li>Aplicar técnicas de design gráfico e edição de vídeo em ambientes profissionais.</li>
                    <li>Desenvolver projetos de multimédia com foco em interatividade e usabilidade.</li>
                    <li>Compreender os aspectos da produção audiovisual, desde a concepção até a pós-produção.</li>
                </ul>
            ';
        case 'estudos':
            return '
                <h2>O que se aprende no curso</h2>
                <p>O curso de Técnico de Multimédia oferece uma formação completa nas principais áreas da produção multimédia, com foco em técnicas de criação e edição de conteúdo digital. Os principais temas abordados incluem:</p>
                
                <h3>Conteúdos do curso:</h3>
                <ul>
                    <li><strong>Produção de Imagem Digital:</strong> Edição de imagens, design gráfico, fotografia digital e manipulação de imagens com softwares como Adobe Photoshop.</li>
                    <li><strong>Produção de Vídeo:</strong> Edição e montagem de vídeos, utilização de softwares como Adobe Premiere e After Effects, efeitos visuais e técnicas de color grading.</li>
                    <li><strong>Design de Áudio:</strong> Criação e edição de áudio digital, gravação e mixagem de som, utilizando ferramentas como Audacity e Adobe Audition.</li>
                    <li><strong>Criação de Animações:</strong> Técnicas de animação 2D e 3D, criação de animações digitais, softwares como Adobe Animate e Blender.</li>
                    <li><strong>Interatividade e Web Design:</strong> Criação de interfaces interativas, animações para web, design de sites e aplicativos usando HTML, CSS, JavaScript e outras ferramentas de desenvolvimento web.</li>
                    <li><strong>Multimédia para Mídias Digitais:</strong> Produção de conteúdo multimédia voltado para a web, redes sociais, vídeos de YouTube e outras plataformas digitais.</li>
                </ul>
            ';
        case 'contacto':
            return '
                <h2>Contacto</h2>
                <p>Se você tiver dúvidas sobre o curso ou quiser mais informações, entre em contato conosco através dos seguintes meios:</p>
                <ul>
                    <li><strong>Email:</strong> info@escola.com</li>
                    <li><strong>Telefone:</strong> +351 123 456 789</li>
                    <li><strong>Endereço:</strong> Rua das Escolas, 123, Cidade, País</li>
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
    <title>Técnico de Multimédia</title>
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
            background-color: #28a745;
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
            background-color: #28a745;
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
            color: #28a745;
        }
    </style>
</head>
<body>

    <!-- Cabeçalho -->
    <header>
        <div class="container">
            <h1>Curso Técnico de Multimédia</h1>
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
            <p>&copy; 2024 - Todos os direitos reservados. Curso Técnico de Multimédia.</p>
        </div>
    </footer>

</body>
</html>
