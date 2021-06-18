<?php
require_once '../../includes/config.php';


$sqlConsultaMateria = "SELECT materia_id,nome_materia FROM materia WHERE status = 1";
$queryConsultaMateria = $pdo->prepare($sqlConsultaMateria);
$queryConsultaMateria->execute();
$data = $queryConsultaMateria->fetchAll(PDO::FETCH_ASSOC);


echo json_encode($data,JSON_UNESCAPED_UNICODE);

?>