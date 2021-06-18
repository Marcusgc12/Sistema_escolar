<?php

require_once '../../includes/config.php';

$sql = "SELECT * FROM inscricao as i INNER JOIN alunos as a ON i.aluno_id = a.aluno_id INNER JOIN curso as c ON i.curso_id = c.curso_id INNER JOIN materia as m ON c.materia_id = m.materia_id INNER JOIN turno as t ON i.turno_id = t.turno_id WHERE i.statusI != 0";
$query = $pdo->prepare($sql);
$query->execute();
$data = $query->fetchAll(PDO::FETCH_ASSOC);

for($i = 0;$i < count($data);$i++) {
    if($data[$i]['statusI'] == 1) {
        $data[$i]['statusI'] = '<span class="badge badge-success">Ativo</span>';
    } else {
        $data[$i]['statusI'] = '<span class="badge badge-danger">Inativo</span>';
    }

    $data[$i]['options'] = '<div class="text-center">
            <button class="btn btn-primary btn-sm btnEditInscricao" rl="'.$data[$i]['inscricao_id'].'" title="Editar"><i class="fas fa-pencil-alt"></i></button>
            <button class="btn btn-danger btn-sm btnDelInscricao" rl="'.$data[$i]['inscricao_id'].'" title="Excluir"><i class="fas fa-trash-alt"></i></button>                   
                           </div>';
}
echo json_encode($data,JSON_UNESCAPED_UNICODE);
die();

