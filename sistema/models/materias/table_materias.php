<?php

require_once '../../includes/config.php';

$sql = "SELECT * FROM materia WHERE status != 0";
$query = $pdo->prepare($sql);
$query->execute();
$data = $query->fetchAll(PDO::FETCH_ASSOC);

for($i = 0;$i < count($data);$i++) {
    if($data[$i]['status'] == 1) {
        $data[$i]['status'] = '<span class="badge badge-success">Activo</span>';
    } else {
        $data[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
    }

    $data[$i]['options'] = '
            <button class="btn btn-primary btn-sm btnEditMateria" rl="'.$data[$i]['materia_id'].'" title="Editar"><i class="fas fa-pencil-alt"></i></button>
            <button class="btn btn-danger btn-sm btnDelMateria" rl="'.$data[$i]['materia_id'].'" title="Exlcui"><i class="fas fa-trash-alt"></i></button>
                    ';
}
echo json_encode($data,JSON_UNESCAPED_UNICODE);
die();