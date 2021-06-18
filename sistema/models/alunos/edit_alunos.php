<?php
require_once '../../includes/config.php';

if($_GET) {
    $idAluno = $_GET['id'];
    $sql = "SELECT * FROM alunos WHERE aluno_id = ?";
    $query = $pdo->prepare($sql);
    $query->execute(array($idAluno));
    $data = $query->fetch(PDO::FETCH_ASSOC);

    if(empty($data)) {
        $arrResponse = array('status' => false, 'msg' => 'Dados não encontrados');
    } else {
        $arrResponse = array('status' => true, 'data' => $data);
    }
    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
}
