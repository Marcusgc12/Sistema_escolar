<?php

require_once '../../includes/config.php';

if($_POST) {
    $idCurso = $_POST['idCurso'];

    $sql = "SELECT * FROM inscricao WHERE curso_id = $idCurso AND statusI != 0";
    $query = $pdo->prepare($sql);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    if(empty($result)) {
        $sql_update = "DELETE FROM `curso` WHERE `curso`.`curso_id` = ?";
        $query_update = $pdo->prepare($sql_update);
        $result = $query_update->execute(array($idCurso));
        if($result) {
            $arrResponse = array('status' => true,'msg' => 'Eliminado correctamente');
        } else {
            $arrResponse = array('status' => false,'msg' => 'Error al eliminar');
        }
    } else {
        $arrResponse = array('status' => false,'msg' => 'Não se pode excluir um curso associado a uma inscrição');
    }
    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
}
