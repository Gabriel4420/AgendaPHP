<?php

include '../../config/conn.php';

if (isset($_GET['idDel'])) {
    $id_contato = $_GET['idDel'];
    $queryDel = 'DELETE from contato WHERE id =:id_contato';

    try {
        //code...
        $res = $conn->prepare($queryDel);
        $res->bindValue(':id_contato', $id_contato, PDO::PARAM_INT);
        $res->execute();

        $count = $res->rowCount();

        if ($count > 0) {
            header('Location: ../home.php');
        } else {
            header('Location: ../home.php');
        }
    } catch (PDOException $e) {
        //throw $th;
        echo '<div class="alert alert-danger alert-dismissible" style="margin-top:10px;">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h5><i class="icon fas fa-check"></i><strong>erro ao deletar >> </strong></h5>
        Contato não editado com sucesso.
      ' .
            $e->getMessage() .
            '</div>';
    }
}