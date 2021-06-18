<?php

require_once '../../includes/config.php';

if($_POST) {
    $idProfessor = $_POST['idProfessor'];

    $sql_professor = "SELECT * FROM curso WHERE professor_id = $idProfessor AND statusC != 0";
    $query_professor = $pdo->prepare($sql_professor);
    $query_professor->execute();
    $result_professor = $query_professor->fetchAll(PDO::FETCH_ASSOC);

    if(empty($result_professor)) {
        $sql = "DELETE FROM `professor` WHERE `professor`.`professor_id` = ?";
        $query = $pdo->prepare($sql);
        $result = $query->execute(array($idProfessor));

        if($result) {
            $arrResponse = array('status' => true,'msg' => 'Excluido corretamente');
        } else {
            $arrResponse = array('status' => false,'msg' => 'Erro ao excluir');
        }
    } else {
        $arrResponse = array('status' => false,'msg' => 'Não pode excluir um professor associado a um curso');
    }

    
    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
}