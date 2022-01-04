<!DOCTYPE html>
<html lang="pt_br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>New Agenda 2.0 | Cadastro</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">


    <link rel="stylesheet" href="./plugins/fontawesome-free/css/all.min.css">

    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <link rel="stylesheet" href="./plugins/icheck-bootstrap/icheck-bootstrap.min.css">

    <link rel="stylesheet" href="./dist/css/adminlte.min.css">

    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="./cad_user.php"><b>Cadastro New Agenda</b> 2.0</a>
        </div>

        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Insira seus dados abaixo</p>

                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="exampleInputFile">Selecione uma foto de perfil</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="foto" id="exampleInputFile" required>
                                <label class="custom-file-label" for="exampleInputFile">Selecione uma
                                    Imagem</label>
                            </div>

                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" name="nome" class="form-control" placeholder="Digite seu nome">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-pencil"></span>
                            </div>
                        </div>
                    </div>
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
                        <div class="col-12" style="margin-bottom: 20px;">
                            <button type="submit" name="botao" class="btn btn-primary btn-block"> Finalizar
                                Cadastro</button>
                        </div>
                    </div>
                </form>
                <?php
                include 'config/conn.php';
                if (isset($_POST['botao'])) {
                    $nome = $_POST['nome'];
                    $email = $_POST['email'];
                    $senha = base64_encode($_POST['senha']);

                    $formatP = ['png', 'jpg', 'jpeg', 'JPG', 'gif'];
                    $extensao = pathinfo(
                        $_FILES['foto']['name'],
                        PATHINFO_EXTENSION
                    );
                    if (in_array($extensao, $formatP)) {
                        $pasta = '../img/';
                        $temp = $_FILES['foto']['tmp_name'];
                        $newName = uniqid() . ".$extensao";

                        if (move_uploaded_file($temp, $pasta . $newName)) {
                            $qs =
                                'INSERT INTO user (foto,username,email,password) VALUES (:foto,:nome,:email,:senha)';
                            try {
                                $res = $conn->prepare($qs);
                                $res->bindParam(':nome', $nome, PDO::PARAM_STR);

                                $res->bindParam(
                                    ':email',
                                    $email,
                                    PDO::PARAM_STR
                                );
                                $res->bindParam(
                                    ':senha',
                                    $senha,
                                    PDO::PARAM_STR
                                );
                                $res->bindParam(
                                    ':foto',
                                    $newName,
                                    PDO::PARAM_STR
                                );
                                $res->execute();
                                $count = $res->rowCount();

                                if ($count > 0) {
                                    echo '<div class="container">
                                            <div class="alert alert-success alert-dismissible">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                            <h5><i class="icon fas fa-check"></i> Sucesso!</h5>
                                            Contato cadastrado com sucesso.
                                          </div>
                                            </div>';
                                } else {
                                    echo '<div class="container">
                                            <div class="alert alert-danger alert-dismissible">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                            <h5><i class="icon fas fa-check"></i> Erro!</h5>
                                            Contato não cadastrado com sucesso.
                                          </div>
                                            </div>';
                                }
                            } catch (PDOException $ex) {
                                //throw $th;
                                echo '<strong>ERRO DE PDO =</strong>' .
                                    $ex->getMessage();
                            }
                        } else {
                            echo '<strong>Não foi possivel fazer o upload do arquivo </strong>';
                        }
                    } else {
                        echo '<strong>Formato Invalido</strong>';
                    }
                }
                ?>


                <p class="mb-0">
                    <a href="index.php" class="text-center">Voltar ao login</a>
                </p>
            </div>

        </div>
    </div>



    <script src="./plugins/jquery/jquery.min.js"></script>

    <script src="./plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="./dist/js/adminlte.min.js"></script>

</body>

</html>