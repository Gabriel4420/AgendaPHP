<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Cadastro de contatos </h1>
                </div>

            </div>
        </div>
    </section>


    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-md-4">

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
                                        placeholder="Digite o nome de contato" required />
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputTelefone">Telefone</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="exampleInputTelfone" name="telefone"
                                            required
                                            data-inputmask="'mask': ['999-999-9999 [x99999]', '+099 99 99 9999[9]-9999']"
                                            data-mask>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail">E-mail</label>
                                    <input type="email" class="form-control" name="email" id="exampleInputEmail"
                                        placeholder="Digite um e-mail" required>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputFile">Foto do Contato</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="foto"
                                                id="exampleInputFile" required>
                                            <label class="custom-file-label" for="exampleInputFile">Arquivo de
                                                Imagem</label>
                                        </div>

                                    </div>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" required>
                                    <label class="form-check-label" for="exampleCheck1">Autorizo o cadastro do meu
                                        contato</label>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" name="botao" class="btn btn-primary">Cadastrar Contato</button>
                            </div>
                        </form>
                        <?php
                        include '../config/conn.php';
                        if (isset($_POST['botao'])) {
                            $nome = $_POST['nome'];
                            $telefone = $_POST['telefone'];
                            $email = $_POST['email'];
                            //$foto = $_FILES['foto'];
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
                                    move_uploaded_file($temp, $pasta . $newName)
                                ) {
                                    $qs =
                                        'INSERT INTO contato (nome,telefone,email,foto) VALUES (:nome,:telefone,:email,:foto)';
                                    try {
                                        //code...
                                        $res = $conn->prepare($qs);
                                        $res->bindParam(
                                            ':nome',
                                            $nome,
                                            PDO::PARAM_STR
                                        );
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
                                            echo '
                                            <div class="alert alert-success alert-dismissible" style="margin-top:10px;">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                            <h5><i class="icon fas fa-check"></i> Sucesso!</h5>
                                            Contato cadastrado com sucesso.
                                          </div>';
                                          header('Refresh: 3, home.php');
                                        } else {
                                            echo '
                                            <div class="alert alert-danger alert-dismissible" style="margin-top:10px;">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                            <h5><i class="icon fas fa-check"></i> Erro!</h5>
                                            Contato não cadastrado com sucesso.
                                          </div>';
                                          header('Refresh: 3, home.php');
                                        }
                                    } catch (PDOException $ex) {
                                        //throw $th;
                                        echo '<div class="alert alert-danger alert-dismissible" style="margin-top:10px;">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <h5><i class="icon fas fa-check"></i><strong>ERRO DE PDO =</strong></h5>
                                        Contato não editado com sucesso.' .
                                            $ex->getMessage() .
                                            '</div>';
                                    }
                                } else {
                                    echo '<div class="alert alert-danger alert-dismissible" style="margin-top:10px;">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <h5><i class="icon fas fa-check"></i><strong>Não foi possivel fazer o upload do arquivo </strong></h5>
                                    Contato não editado com sucesso.</div>';
                                }
                            } else {
                                echo '<div class="alert alert-danger alert-dismissible" style="margin-top:10px;">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h5><i class="icon fas fa-check"></i><strong>Formato Invalido</strong></h5>
                                Contato não editado com sucesso.</div>';
                            }
                          
                        }
                        ?>
                    </div>

                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Lista de Contatos</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 40px">#</th>
                                        <th>Nome</th>
                                        <th>Telefone</th>
                                        <th>Email</th>
                                        <th style="width: 10px">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $querySelect =
                                        'SELECT * from contato ORDER BY id DESC LIMIT 6';
                                    try {
                                        //code...
                                        $res = $conn->prepare($querySelect);
                                        $count = 1;
                                        $res->execute();
                                        $countRow = $res->rowCount();

                                        if ($countRow > 0) {
                                            while (
                                                $show = $res->FETCH(
                                                    PDO::FETCH_OBJ
                                                )
                                            ) { ?>
                                    <tr>
                                        <td><?php echo $count++; ?></td>
                                        <td><?php echo $show->nome; ?></td>
                                        <td>
                                            <?php echo $show->telefone; ?>
                                        </td>
                                        <td>
                                            <?php echo $show->email; ?>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="home.php?acao=editar&id=<?php echo $show->id; ?>" type="button"
                                                    class="btn btn-primary" title="Editar Contato">
                                                    <i class="fas fa-user-edit"></i>
                                                </a>
                                                <a href="content/del_contato.php?idDel=<?php echo $show->id; ?>"
                                                    onclick="return confirm('Deseja Realmente Remover O Contato ?')"
                                                    type=" button" class="btn btn-danger" title="Remover Contato">
                                                    <i class="fas fa-user-times"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php }
                                        } else {
                                            echo '<div class="alert alert-danger alert-dismissible" style="margin-top:10px;">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                            <h5><i class="icon fas fa-check"></i><strong>não foi possivel estabelecer uma conexao</strong></h5>
                                            Contato não editado com sucesso.</div>';
                                        }
                                    } catch (PDOException $e) {
                                   
                                        echo '<div class="alert alert-danger alert-dismissible" style="margin-top:10px;">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <h5><i class="icon fas fa-check"></i><strong>ERRO DE PDO =</strong></h5>
                                        Contato não editado com sucesso.' .
                                            $e->getMessage() .
                                            '</div>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
</div>
</section>

</div>