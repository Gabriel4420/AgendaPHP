<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Editar perfil </h1>
                </div>

            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <?php include '../config/conn.php'; ?>
            <div class="row">

                <div class="col-md-6">

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"></h3>
                        </div>

                        <form role="form" action="" method="post" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputName">Nome</label>
                                    <input type="text" class="form-control" name="nome" id="exampleInputName"
                                        value="<?php echo $nome_user; ?>" required />
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail">E-mail</label>
                                    <input type="email" class="form-control" name="email" id="exampleInputEmail"
                                        value="<?php echo $email_user; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword">Senha</label>
                                    <input type="password" class="form-control" name="senha" id="exampleInputPassword"
                                        value="<?php echo base64_decode(
                                            $senha_user
                                        ); ?>" required>
                                </div>


                                <div class="form-group">
                                    <label for="exampleInputFile">Foto do Contato</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="foto"
                                                id="exampleInputFile">
                                            <label class="custom-file-label" for="exampleInputFile">Arquivo de
                                                Imagem</label>
                                        </div>

                                    </div>
                                </div>

                            </div>


                            <div class="card-footer">
                                <button type="submit" name="upPerfil" class="btn btn-primary">Salvar
                                    Perfil</button>
                            </div>
                        </form>
                        <?php if (isset($_POST['upPerfil'])) {
                            $nome_user = $_POST['nome'];
                            $email_user = $_POST['email'];
                            $senha_user = base64_encode($_POST['senha']);
                          
                            if (!empty($_FILES['foto']['name'])) {
                                $formatP = ['png', 'jpg', 'jpeg', 'JPG', 'gif'];
                                $extensao = pathinfo(
                                    $_FILES['foto']['name'],
                                    PATHINFO_EXTENSION
                                );
                                if (in_array($extensao, $formatP)) {
                                    $pasta = '../img/';
                                    $temp = $_FILES['foto']['tmp_name'];
                                    $newName = uniqid() . ".$extensao";

                                    if (
                                        move_uploaded_file(
                                            $temp,
                                            $pasta . $newName
                                        )
                                    ) {
                                    } else {
                                        echo '<div class="alert alert-danger alert-dismissible" style="margin-top:10px;">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <h5><i class="icon fas fa-check"></i><strong>Não foi possivel fazer o upload do arquivo </strong></h5>
                                        Perfil não editado com sucesso.
                                      </div>';
                                    }
                                } else {
                                    echo '<div class="alert alert-danger alert-dismissible" style="margin-top:10px;">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <h5><i class="icon fas fa-check"></i><strong>Formato Invalido</strong></h5>
                                    Perfil não editado com sucesso.
                                  </div>';
                                }
                            } else {
                                $newName = $foto_user;
                            }
                            $qs =
                                'UPDATE user SET foto=:foto_user, username=:nome_user,email=:email_user,password=:senha_user WHERE id=:id';
                            try {
                                //code...
                                $res = $conn->prepare($qs);

                                $res->bindParam(
                                    ':id',
                                    $id_user,
                                    PDO::PARAM_INT
                                );
                                $res->bindParam(
                                    ':nome_user',
                                    $nome_user,
                                    PDO::PARAM_STR
                                );
                                $res->bindParam(
                                    ':senha_user',
                                    $senha_user,
                                    PDO::PARAM_STR
                                );
                                $res->bindParam(
                                    ':email_user',
                                    $email_user,
                                    PDO::PARAM_STR
                                );
                                $res->bindParam(
                                    ':foto_user',
                                    $newName,
                                    PDO::PARAM_STR
                                );

                                $res->execute();
                                $count = $res->rowCount();

                                if ($count > 0) {
                                    echo '<div class="container">
                            <div class="alert alert-success alert-dismissible" style="margin-top:10px;">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-check"></i> Sucesso!</h5>
                            Perfil editado com sucesso.
                          </div>
                            </div>';
                                    header('Refresh: 4, ?sair');
                                } else {
                                    echo '<div class="container">
                            <div class="alert alert-danger alert-dismissible" style="margin-top:10px;">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-check"></i> Erro!</h5>
                            Perfil não editado com sucesso.
                          </div>
                            </div>';
                                }
                            } catch (PDOException $ex) {
                                //throw $th;
                                echo '<div class="alert alert-danger alert-dismissible" style="margin-top:10px;">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h5><i class="icon fas fa-check"></i> Erro de PDO!</h5>  
                              ' .
                                    $ex->getMessage() .
                                    '</div>';
                            }
                        } ?>
                    </div>
                </div>
                <div class=" col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title text-center">
                                Dados do usuário
                            </h3>
                        </div>

                        <div class="card-body p-0 text-center">
                            <img src="../../img/<?php echo $foto_user; ?>" alt="avatar"
                                style="width:200px; border-radius:100%; margin-bottom:20px; margin-top:20px;">
                            <h1><?php echo $nome_user; ?></h1>
                            <strong><?php echo $email_user; ?></strong>
                        </div>

                    </div>

                </div>

            </div>

        </div>
    </section>
</div>