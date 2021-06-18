<?php

require_once '../../includes/config.php';

if($_POST) {
    $idUser = $_POST['idUser'];
    $sql = "DELETE FROM `usuarios` WHERE `usuarios`.`user_id` = ?";
    $query = $pdo->prepare($sql);
    $result = $query->execute(array($idUser));
    if($result) {
        $arrResponse = array('status' => true,'msg' => 'Usuario excluido');
    } else {
        $arrResponse = array('status' => false,'msg' => 'Problema ao excluir');
    }
    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
}