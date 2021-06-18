<?php

require_once '../../includes/config.php';

if($_POST) {
    $idInscripcion = $_POST['idInscricao'];

        $sql_update = "DELETE FROM `inscricao` WHERE `inscricao`.`inscricao_id` = ?";
        $query_update = $pdo->prepare($sql_update);
        $result = $query_update->execute(array($idInscripcion));
        if($result) {
            $arrResponse = array('status' => true,'msg' => 'Excluido corretamente');
        } else {
            $arrResponse = array('status' => false,'msg' => 'Erro ao excluir');
        }
    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
}