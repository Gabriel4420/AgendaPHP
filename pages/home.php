<?php include_once '../includes/header.php';
if (isset($_GET['acao'])) {
    $acao = $_GET['acao'];
    if ($acao == 'bemvindo') {
        include_once '../pages/content/cadastro_contato.php';
    } elseif ($acao == 'editar') {
        include_once '../pages/content/update_contato.php';
    } elseif ($acao == 'perfil') {
        include_once '../pages/content/update_perfil.php';
    }elseif ($acao == 'relatorio') {
        include_once '../pages/content/relatorio.php';
    }
} else {
    include_once '../pages/content/cadastro_contato.php';
}
include_once '../includes/footer.php';