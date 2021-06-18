<?php

require_once '../../includes/config.php';

if($_POST) {
    $idMateria = $_POST['idMateria'];

    $sql_materia = "SELECT * FROM curso WHERE materia_id = $idMateria AND statusC != 0";
    $query_materia = $pdo->prepare($sql_materia);
    $query_materia->execute();
    $result_materia = $query_materia->fetchAll(PDO::FETCH_ASSOC);

    if(empty($result_materia)) {
        $sql = "DELETE FROM `materia` WHERE `materia`.`materia_id` = ?";
        $query = $pdo->prepare($sql);
        $result = $query->execute(array($idMateria));

        if($result) {
            $arrResponse = array('status' => true,'msg' => '');
        } else {
            $arrResponse = array('status' => false,'msg' => 'Error ao exlcui');
        }
    } else {
        $arrResponse = array('status' => false,'msg' => 'Não se pode exlcui uma materia associada a um curso');
    }    
    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
}
