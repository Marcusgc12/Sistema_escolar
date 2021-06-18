<?php

require_once '../../includes/config.php';

$sqlAlumno = "SELECT aluno_id,nome,apelido,status FROM alunos WHERE status = 1";
$queryAlumno = $pdo->prepare($sqlAlumno);
$queryAlumno->execute();
$data = $queryAlumno->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($data,JSON_UNESCAPED_UNICODE);