<?php

require_once '../../includes/config.php';

if(!empty($_POST)) {
    if(empty($_POST['listMateria']) || empty($_POST['listProfessor']) || empty($_POST['listStatus'])) {
        $arrResponse = array('status' => false,'msg' => 'Todos os campos são necesarios');
    } else {
        $idCurso = $_POST['idCurso'];
        $materia = $_POST['listMateria'];
        $professor = $_POST['listProfessor'];
        $status = $_POST['listStatus'];

        // CONSULTA PARA INSERTAR
        $sql = "SELECT * FROM curso WHERE materia_id = ? AND professor_id = ? AND statusC != 0";
        $query = $pdo->prepare($sql);
        $query->execute(array($materia,$professor));
        $resultInsert = $query->fetch(PDO::FETCH_ASSOC);
        
        // CONSULTA PARA ACTUALIZAR
        $sql2 = "SELECT * FROM curso WHERE materia_id = ? AND professor_id = ? AND statusC != 0 AND curso_id != ?";
        $query2 = $pdo->prepare($sql2);
        $query2->execute(array($materia,$professor,$idCurso));
        $resultUpdate = $query2->fetch(PDO::FETCH_ASSOC);

        if($resultInsert > 0) {
            $arrResponse = array('status' => false,'msg' => 'A materia e o professor já existem, selecione outro');
        } else {
            if($idCurso == 0) {
                $sql_insert = "INSERT INTO curso (materia_id,professor_id,statusC) VALUES (?,?,?)";
                $query_insert = $pdo->prepare($sql_insert);
                $request = $query_insert->execute(array($materia,$professor,$status));
                if($request) {
                    $arrResponse = array('status' => true,'msg' => 'Curso criado corretamente'); 
                }
            }  
        }
        if($resultUpdate > 0) {
            $arrResponse = array('status' => false,'msg' => 'A materia e o professor já existem, selecione outro');
        } else {
            if($idCurso > 0) {
                $sql_update = "UPDATE curso SET materia_id = ?,professor_id = ?,statusC = ? WHERE curso_id = ?";
                $query_update = $pdo->prepare($sql_update);
                $request2 = $query_update->execute(array($materia,$professor,$status,$idCurso));
                if($request2) {
                    $arrResponse = array('status' => true,'msg' => 'Curso atualizado corretamente');
                }
             }
        }
    }
    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
}