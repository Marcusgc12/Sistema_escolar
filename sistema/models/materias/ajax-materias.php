<?php

require_once '../../includes/config.php';

if(!empty($_POST)) {
    if(empty($_POST['txtNome']) || empty($_POST['listStatus'])) {
        $arrResponse = array('status' => false,'msg' => 'Todos os campos são necesarios');
    } else {
        $idMateria = $_POST['idMateria'];
        $nome = $_POST['txtNome'];
        $status = $_POST['listStatus'];

        $sql = "SELECT * FROM materia WHERE (nome_materia = ? AND materia_id != ? AND status != 0)";
        $query = $pdo->prepare($sql);
        $query->execute(array($nome,$idMateria));
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if($result > 0) {
            $arrResponse = array('status' => false,'msg' => 'Materia já registrada');
        } else {
            if($idMateria == 0) {
                $sql_insert = "INSERT INTO materia (nome_materia,status) VALUES (?,?)";
                $query_insert = $pdo->prepare($sql_insert);
                $request = $query_insert->execute(array($nome,$status));
                $option = 1;
            } else {
                $sql_update = "UPDATE materia SET nome_materia = ?,status = ? WHERE materia_id = ?";
                $query_update = $pdo->prepare($sql_update);
                $request = $query_update->execute(array($nome,$status,$idMateria));
                $option = 2;
            }
            
            if($request > 0) {
                if($option == 1) {
                    $arrResponse = array('status' => true,'msg' => 'Materia criada corretamente');
                } else {
                    $arrResponse = array('status' => true,'msg' => 'Materia atualizada corretamente');
                }
                
            }
        }
    }
    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
}