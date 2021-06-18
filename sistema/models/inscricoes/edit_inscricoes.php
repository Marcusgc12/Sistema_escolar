<?php

require_once '../../includes/config.php';

if(!empty($_GET)) {
    $idInscricao = $_GET['id'];
    //$sql = "SELECT * FROM inscricao WHERE inscricao_id = ?";
    $sql = "SELECT * FROM inscricao as i INNER JOIN alunos as a ON i.aluno_id = a.aluno_id INNER JOIN curso as c ON i.curso_id = c.curso_id INNER JOIN materia as m ON c.materia_id = m.materia_id INNER JOIN turno as t ON i.turno_id = t.turno_id WHERE i.inscricao_id = ?";
    $query = $pdo->prepare($sql);
    $query->execute(array($idInscricao));
    $data = $query->fetch(PDO::FETCH_ASSOC);
    if(empty($data)) {
        $arrResponse = array('status' => false,'msg' => 'Dados não encontrados');
    } else {
        $arrResponse = array('status' => true,'data' => $data);
    }
    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
}