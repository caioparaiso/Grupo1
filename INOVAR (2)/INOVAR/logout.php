<?php
session_start();

// Destruir a sessão
session_destroy();

// Redirecionar para a página de login
header("Location: ./inicio/pagina_inicial.php");
exit();
