<?php
require_once '../../includes/config.php';

// OPCION PARA PROFESOR
$sqlConsultaProfesor = "SELECT professor_id,nome,apelido FROM professor WHERE status = 1";
$queryConsultaProfesor = $pdo->prepare($sqlConsultaProfesor);
$queryConsultaProfesor->execute();
$data = $queryConsultaProfesor->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($data,JSON_UNESCAPED_UNICODE);

?>