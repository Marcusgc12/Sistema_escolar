<?php

require_once '../../includes/config.php';

// EXTRAER USUARIOS

    $sql = "SELECT u.user_id,u.nome,u.usuario,r.rol_id,r.nome_rol,u.status FROM usuarios as u INNER JOIN rol as r ON u.rol = r.rol_id WHERE u.status != 0";
    $query = $pdo->prepare($sql);
    $query->execute();
    //$row = $query->rowCount();

        $data = $query->fetchAll(PDO::FETCH_ASSOC);

        for($i = 0;$i < count($data);$i++) {
            if($data[$i]['status']==1) {
                $data[$i]['status'] = '<span class="badge badge-success">Ativo</span>';
            } else {
                $data[$i]['status'] = '<span class="badge badge-danger">Inativo</span>';
            }

            $data[$i]['options'] = '<div class="text-center">
                <button class="btn btn-primary btn-sm btnEditUser" rl="'.$data[$i]['user_id'].'" title="Editar"><i class="fas fa-pencil-alt"></i></button>
                <button class="btn btn-danger btn-sm btnDelUser" rl="'.$data[$i]['user_id'].'" title="Excluir"><i class="fas fa-trash-alt"></i></button>                   
                                       </div>';
        }
    
    echo json_encode($data,JSON_UNESCAPED_UNICODE);
    die();
