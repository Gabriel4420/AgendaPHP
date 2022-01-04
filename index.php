<?php ob_start();
session_start();
if (isset($_SESSION['loginUser']) && isset($_SESSION['senhaUser'])) {
    header('Location: pages/home.php');
}
?>
<!DOCTYPE html>
<html lang="pt_br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>New Agenda 2.0 | Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="./plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="./plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="./dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="index.php"><b>New Agenda</b> 2.0</a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Entre com email e senha</p>

                <form action="" method="post">
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Digite seu e-mail">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="senha" class="form-control" placeholder="Digite sua senha">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <!-- /.col -->
                        <div class="col-12">
                            <button type="submit" name="login" class="btn btn-primary btn-block"><i
                                    class="fas fa-sign-in-alt"></i> Acessar agenda</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
                <?php
                include_once './config/conn.php';
                if (isset($_POST['login'])) {
                    $login = filter_input(INPUT_POST, 'email', FILTER_DEFAULT);
                    $senha = base64_encode(
                        filter_input(INPUT_POST, 'senha', FILTER_DEFAULT)
                    );
                    $qs =
                        'SELECT * FROM user WHERE email =:email AND password =:senha';
                    try {
                        //code...
                        $result = $conn->prepare($qs);
                        $result->bindParam(':email', $login, PDO::PARAM_STR);
                        $result->bindParam(':senha', $senha, PDO::PARAM_STR);
                        $result->execute();
                        $verify = $result->rowCount();
                        if ($verify > 0) {
                            $login = $_POST['email'];
                            $senha = $_POST['senha'];
                            //sessão
                            $_SESSION['loginUser'] = $login;
                            $_SESSION['senhaUser'] = $senha;
                            echo '<div class="alert alert-success alert-dismissible" style="margin-top:10px;"><button type="button" class="close" data-dismiss="alert">x</button><strong>Logado com sucesso</strong> Você será redirecionado para sua agenda em instantes, aguarde :)</div>';
                            header('Refresh: 4, pages/home.php?acao=bemvindo');
                        } else {
                            echo '
                            <div class="alert alert-danger alert-dismissible" style="margin-top:10px;">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-check"></i> Erro!</h5>
                            email ou senha invalidos!
                            </div>
                            
                            ';
                            header('Refresh: 3, index.php');
                        }
                    } catch (\PDOException $th) {
                        echo '<div class="alert alert-danger alert-dismissible" style="margin-top:10px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h5><i class="icon fas fa-check"></i> <strong>Erro de Login do PDO:</strong></h5>' .
                            $th->getMessage() .
                            '</div>';
                    }
                }
                ?>

                <p class="mb-0" style="margin-top:15px;">
                    <a href="cad_user.php" class="text-center">Não é cadastrado ?<b> Cadastre-se </b> </a>
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="./plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="./plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="./dist/js/adminlte.min.js"></script>

</body>

</html>