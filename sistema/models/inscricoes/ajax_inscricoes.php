<?php

require_once '../../includes/config.php';

if(!empty($_POST)) {
    if(empty($_POST['listAluno']) || empty($_POST['listCurso']) || empty($_POST['listTurno']) || empty($_POST['listStatus'])) {
        $arrResponse = array('status' => false,'msg' => 'Todos os campos são necessarios');
    } else {
        $idInscricao = $_POST['idInscricao'];
        $aluno = $_POST['listAluno'];
        $curso = $_POST['listCurso'];
        $turno = $_POST['listTurno'];
        $status = $_POST['listStatus'];

        // CONSULTA PARA INSERTAR
        $sql = "SELECT * FROM inscricao WHERE aluno_id = ? AND curso_id = ? AND turno_id = ? AND statusI != 0";
        $query = $pdo->prepare($sql);
        $query->execute(array($aluno,$curso,$turno));
        $resultInsert = $query->fetch(PDO::FETCH_ASSOC);
        
        // CONSULTA PARA ACTUALIZAR
        $sql2 = "SELECT * FROM inscricao WHERE aluno_id = ? AND curso_id = ? AND turno_id = ? AND statusI != 0 AND inscricao_id != ?";
        $query2 = $pdo->prepare($sql2);
        $query2->execute(array($aluno,$curso,$turno,$idInscricao));
        $resultUpdate = $query2->fetch(PDO::FETCH_ASSOC);

        if($resultInsert > 0) {
            $arrResponse = array('status' => false,'msg' => 'o aluno já tem o curso e turno atribuído, selecione outro');
        } else {
            if($idInscricao == 0) {
                $sql_insert = "INSERT INTO inscricao (aluno_id,curso_id,turno_id,statusI) VALUES (?,?,?,?)";
                $query_insert = $pdo->prepare($sql_insert);
                $request = $query_insert->execute(array($aluno,$curso,$turno,$status));
                if($request) {
                    $arrResponse = array('status' => true,'msg' => 'Inscricao criada corretamente'); 
                }
            }  
        }
        if($resultUpdate > 0) {
            $arrResponse = array('status' => false,'msg' => 'o aluno já tem o curso e turno atribuído, selecione outro');
        } else {
            if($idInscricao > 0) {
                $sql_update = "UPDATE inscricao SET aluno_id = ?,curso_id = ?,turno_id = ?,statusI = ? WHERE inscricao_id = ?";
                $query_update = $pdo->prepare($sql_update);
                $request2 = $query_update->execute(array($aluno,$curso,$turno,$status,$idInscricao));
                if($request2) {
                    $arrResponse = array('status' => true,'msg' => 'Inscricão atualizada corretamente');
                }
             }
        }
    }
    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
}