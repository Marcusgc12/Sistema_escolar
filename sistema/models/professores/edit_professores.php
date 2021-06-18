<?php

require_once '../../includes/config.php';

$idProfessor = $_GET['id'];
$sql = "SELECT * FROM professor WHERE professor_id = ?";
$query = $pdo->prepare($sql);
$query->execute(array($idProfessor));
$data = $query->fetch(PDO::FETCH_ASSOC);

if(empty($data)) {
    $arrResponse = array('status' => false,'msg' => 'Dados não encontrados');
} else {
    $arrResponse = array('status' => true,'data' => $data);
}
echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);