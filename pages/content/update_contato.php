<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Editar contato </h1>
                </div>

            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <?php
            include '../config/conn.php';
            if (!isset($_GET['id'])) {
                header('Location: home.php');
                exit();
            }
            $id = filter_input(INPUT_GET, 'id', FILTER_DEFAULT);
            $querySelect = 'SELECT * FROM contato where id =:id';

            try {
                $result = $conn->prepare($querySelect);
                $result->bindParam(':id', $id, PDO::PARAM_INT);
                $result->execute();

                $count = $result->rowCount();

                if ($count > 0) {
                    while ($show = $result->FETCH(PDO::FETCH_OBJ)) {
                        $id_contato = $show->id;
                        $nome_contato = $show->nome;
                        $telefone_contato = $show->telefone;
                        $email_contato = $show->email;
                        $foto_contato = $show->foto;
                    }
                } else {
                    echo '<div class="alert alert-danger">Não há dados com o ID informado </div>';
                }
            } catch (PDOException $e) {
                //throw $th;
                echo '<div class="alert alert-danger">Erro de PDO :</div>' .
                    $e->getMessage();
            }
            ?>
            <div class="row">
                <!-- left column -->
                <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"></h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" action="" method="post" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputName">Nome</label>
                                    <input type="text" class="form-control" name="nome" id="exampleInputName"
                                        value="<?php echo $nome_contato; ?>" required />
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputTelefone">Telefone</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="exampleInputTelfone" name="telefone"
                                            required value="<?php echo $telefone_contato; ?>"
                                            data-inputmask="'mask': ['999-999-9999 [x99999]', '+099 99 99 9999[9]-9999']"
                                            data-mask>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail">E-mail</label>
                                    <input type="email" class="form-control" name="email" id="exampleInputEmail"
                                        value="<?php echo $email_contato; ?>" required>
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
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" name="upContato" class="btn btn-primary">Salvar
                                    Contato</button>
                            </div>
                        </form>
                        <?php if (isset($_POST['upContato'])) {
                            $nome = $_POST['nome'];
                            $telefone = $_POST['telefone'];
                            $email = $_POST['email'];
                            //$foto = $_FILES['foto'];
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
                                        Contato não editado com sucesso.
                                      </div>';
                                    }
                                } else {
                                    echo '<div class="alert alert-danger alert-dismissible" style="margin-top:10px;">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <h5><i class="icon fas fa-check"></i><strong>Formato Invalido</strong></h5>
                                    Contato não editado com sucesso.
                                  </div>';
                                }
                            } else {
                                $newName = $foto_contato;
                            }
                            $qs =
                                'UPDATE contato SET nome=:nome,telefone=:telefone,email=:email,foto=:foto WHERE id=:id';
                            try {
                                //code...
                                $res = $conn->prepare($qs);
                                $res->bindParam(':id', $id, PDO::PARAM_INT);
                                $res->bindParam(':nome', $nome, PDO::PARAM_STR);
                                $res->bindParam(
                                    ':telefone',
                                    $telefone,
                                    PDO::PARAM_STR
                                );
                                $res->bindParam(
                                    ':email',
                                    $email,
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
                            <div class="alert alert-success alert-dismissible" style="margin-top:10px;">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-check"></i> Sucesso!</h5>
                            Contato editado com sucesso.
                          </div>
                            </div>';
                                    header('Refresh: 3, home.php');
                                } else {
                                    echo '<div class="container">
                            <div class="alert alert-danger alert-dismissible" style="margin-top:10px;">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-check"></i> Erro!</h5>
                            Contato não editado com sucesso.
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
                            /*  echo $nome. "<br>"; 
                                echo $telefone. "<br>"; 
                                echo $email. "<br>"; 
                                var_dump($_FILES['foto']); */
                        } ?>
                    </div>
                    <!-- /.card -->

                    <!-- /.card-body -->
                </div>
                <div class=" col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title text-center">
                                Dados do <?php echo $nome_contato; ?>
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0 text-center">
                            <img src="../img/<?php echo $foto_contato; ?>" alt="avatar.jpg"
                                style="width:200px; border-radius:100%; margin-bottom:20px; margin-top:20px;">
                            <h1><?php echo $nome_contato; ?></h1>
                            <strong><?php echo $telefone_contato; ?></strong>
                            <p><?php echo $email_contato; ?></p>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.card -->
        </div>
        <!--/.col (right) -->
</div>
<!-- /.row -->
</div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>