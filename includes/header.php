<!DOCTYPE html>
<html lang="pt_br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Agenda</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <link rel="shortcut icon" href="https://cdn-icons-png.flaticon.com/512/562/562152.png">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="../plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="../plugins/summernote/summernote-bs4.css">
    <link rel="stylesheet" href="../dist/css/style.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- DataTables -->
    <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../lugins/datatables-responsive/css/responsive.bootstrap4.min.css">
</head>
<?php
ob_start();
session_start();
if (!isset($_SESSION['loginUser']) && !isset($_SESSION['senhaUser'])) {
    echo '<div class="alert alert-danger alert-dismissible" >
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h5><i class="icon fas fa-check"></i> Fatal Error</h5>
        Permission Denied!
        </div>';
    header('Refresh: 4, ../index.php');
    exit();
}
include_once 'out.php';
?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <?php
        
        include_once '../config/conn.php';

        $userLogged = $_SESSION['loginUser'];
        $passwordUser = base64_encode($_SESSION['senhaUser']);
      
        $qsu = 'SELECT * FROM user WHERE email=:email_user AND password=:senha_user';

        try {
            //code...
            $res = $conn->prepare($qsu);
     
            $res->bindParam(':email_user', $userLogged, PDO::PARAM_STR);
            $res->bindParam(':senha_user', $passwordUser, PDO::PARAM_STR);
            $res->execute();

           

            $count = $res->rowCount();

            if ($count > 0) {
                while ($show = $res->fetch(PDO::FETCH_OBJ)) {
                    
                  /* $id_user = $show->id; */  
                    $foto_user = $show->foto;
                    $nome_user = $show->username;
                    $email_user = $show->email;
                    $senha_user = $show->password;
                }
            } else {
                echo '<div class="alert alert-danger"><strong>Error!</strong> Não há dados de perfil</div>';
                echo $qsu;
            }
        } catch (PDOException $e) {
            //throw $th;
            echo 'erro de login'.$e->getMessage();
        }
        ?>
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>

            </ul>




            <ul class="navbar-nav ml-auto">


                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#" title="Perfil & Saida">
                        <i class="fas fa-user-circle"></i>

                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

                        <div class="dropdown-divider"></div>
                        <a href="home.php?acao=perfil" class="dropdown-item">
                            <i class="fas fa-user-edit mr-2"></i> Alterar Perfil

                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="?sair" class="dropdown-item">
                            <i class="fas fa-sign-out-alt mr-2"></i> Sair

                        </a>

                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li>
            </ul>
        </nav>



        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="home.php?acao=bemvindo" class="brand-link">
                <i class="far fa-address-book mr-2" size="9px"></i>
                <span class="brand-text font-weight-light">Sistema Agenda Online</span>
            </a>



            <div class="sidebar">

                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="../../img/<?php echo $foto_user; ?>" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="home.php?acao=perfil" class="d-block">
                            <?php echo $nome_user; ?>

                        </a>
                    </div>
                </div>


                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">

                        <li class="nav-item">
                            <a href="home.php?acao=bemvindo" class="nav-link active ">
                                <i class="nav-icon fas fa-address-book"></i>
                                <p>
                                    Adicionar Contatos

                                </p>
                            </a>

                        </li>
                        <li class="nav-item">
                            <a href="home.php?acao=relatorio" class="nav-link">
                                <i class="nav-icon fas fa-chart-pie"></i>
                                <p>Todos os contatos</p>
                            </a>
                        </li>

                    </ul>
                </nav>

            </div>

        </aside>