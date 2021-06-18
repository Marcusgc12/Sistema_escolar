<?php

require_once '../../includes/config.php';

if($_POST) {
    $idAluno = $_POST['idAluno'];

    $sql = "SELECT * FROM inscricao WHERE aluno_id = $idAluno AND statusI != 0";
    $query = $pdo->prepare($sql);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    if(empty($result)) {
        $sql_update = "DELETE FROM `alunos` WHERE `alunos`.`aluno_id` = ?";
        $query_update = $pdo->prepare($sql_update);
        $request = $query_update->execute(array($idAluno));

        if($request) {
            $arrResponse = array('status' => true,'msg' => 'Excluido corretamente');
        } else {
            $arrResponse = array('status' => false,'msg' => 'Erro ao Excluido');
        }
    } else {
        $arrResponse = array('status' => false,'msg' => 'Não se pode excluir um aluno matriculado a um curso');
    }
    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
}