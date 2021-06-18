<?php

require_once '../../includes/config.php';

$sql = "SELECT * FROM curso as c INNER JOIN materia as m ON c.materia_id = m.materia_id INNER JOIN professor as p ON c.professor_id = p.professor_id WHERE p.status != 0 AND m.status != 0 AND c.statusC != 0";
$query = $pdo->prepare($sql);
$query->execute();

$data = $query->fetchAll(PDO::FETCH_ASSOC);

for($i = 0;$i < count($data);$i++) {
    if($data[$i]['statusC'] == 1) {
        $data[$i]['statusC'] = '<span class="badge badge-success">Ativo</span>';
    } else {
        $data[$i]['statusC'] = '<span class="badge badge-danger">Inativo</span>';
    }

    $data[$i]['options'] = '<div class="text-center">
        <button class="btn btn-primary btn-sm btnEditCurso" rl="'.$data[$i]['curso_id'].'" title="Editar"><i class="fas fa-pencil-alt"></i></button>
        <button class="btn btn-danger btn-sm btnDelCurso" rl="'.$data[$i]['curso_id'].'" title="Excluir"><i class="fas fa-trash-alt"></i></button>                   
                               </div>';
}

echo json_encode($data,JSON_UNESCAPED_UNICODE);
die();
