<?php

require_once '../../includes/config.php';

$sqlCurso = "SELECT * FROM curso as c INNER JOIN materia as m ON c.materia_id = m.materia_id INNER JOIN professor as p ON c.professor_id = p.professor_id WHERE c.statusC = 1";
$queryCurso = $pdo->prepare($sqlCurso);
$queryCurso->execute();
$data = $queryCurso->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($data,JSON_UNESCAPED_UNICODE);