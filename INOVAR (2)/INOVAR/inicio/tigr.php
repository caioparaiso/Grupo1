<?php
// index.php - Página única com conteúdo sobre o curso

// Definir a variável para a página atual
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Função para carregar o conteúdo da página
function get_page_content($page) {
    switch ($page) {
        case 'home':
            return '
                <h2>Bem-vindo ao Curso de Técnico de Informática - Gestão de Redes</h2>
                <p>O curso de Técnico de Informática - Gestão de Redes forma profissionais preparados para a administração, manutenção e segurança de redes de computadores. Ao longo da formação, os alunos aprendem a implementar soluções de rede, configurar equipamentos e administrar redes locais (LAN) e redes de longa distância (WAN), além de garantir a segurança e a eficiência das redes corporativas.</p>
                
                <h3>Objetivos do curso:</h3>
                <ul>
                    <li>Desenvolver competências em redes de computadores e protocolos de comunicação.</li>
                    <li>Configurar, administrar e manter equipamentos de rede, como roteadores e switches.</li>
                    <li>Implementar e gerenciar redes seguras, com foco em proteção contra ameaças.</li>
                    <li>Planejar, projetar e executar instalações de redes em diversos ambientes.</li>
                </ul>
            ';
        case 'estudos':
            return '
                <h2>O que se aprende no curso</h2>
                <p>O curso de Técnico de Informática - Gestão de Redes oferece uma formação robusta, cobrindo uma ampla gama de tópicos, tanto em teoria quanto na prática. Os principais temas abordados incluem:</p>
                
                <h3>Conteúdos do curso:</h3>
                <ul>
                    <li><strong>Redes de Computadores:</strong> Fundamentos de redes, arquitetura de redes e protocolos de comunicação (TCP/IP, DNS, DHCP).</li>
                    <li><strong>Configuração de Equipamentos de Rede:</strong> Instalação e configuração de roteadores, switches e outros dispositivos de rede.</li>
                    <li><strong>Gestão de Redes Locais (LAN):</strong> Como configurar e gerenciar redes locais, incluindo cabeamento, Wi-Fi e dispositivos conectados.</li>
                    <li><strong>Redes de Longa Distância (WAN):</strong> Conceitos sobre redes de longa distância, conexões VPN, MPLS e outras tecnologias.</li>
                    <li><strong>Segurança de Redes:</strong> Implementação de medidas de segurança em redes, proteção contra ataques, firewalls, criptografia e autenticação.</li>
                    <li><strong>Monitoramento e Manutenção de Redes:</strong> Ferramentas de monitoramento de desempenho de rede e solução de problemas.</li>
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
    <title>Técnico de Informática - Gestão de Redes</title>
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
            <h1>Curso Técnico de Informática - Gestão de Redes</h1>
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
            <p>&copy; 2024 - Todos os direitos reservados. Curso Técnico de Informática - Gestão de Redes.</p>
        </div>
    </footer>

</body>
</html>
