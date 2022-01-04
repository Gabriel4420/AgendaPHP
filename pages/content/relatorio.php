<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="col-12 ">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Lista de contatos</h3>
                    </div>

                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Foto</th>
                                    <th>Nome</th>
                                    <th>Telefone</th>
                                    <th>E-mail</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $querySelect =
                                        'SELECT * from contato ORDER BY id DESC';
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
                                    <td><img src="../img/<?php echo $show -> foto; ?>" alt="avatar.jpg"
                                            style="width:50px;  border-radius:100%;  ">
                                    </td>
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
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Foto</th>
                                    <th>Nome</th>
                                    <th>Telefone</th>
                                    <th>E-mail</th>
                                    <th>Ações</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <?php include '../config/conn.php'; ?>

        </div>
    </section>
</div>