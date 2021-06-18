<?php

require_once '../../includes/config.php';

if(!empty($_POST)) {
    if(empty($_POST['txtNome']) || empty($_POST['txtApelido']) || empty($_POST['txtEndereco']) || empty($_POST['celula']) || empty($_POST['telefone']) || empty($_POST['email']) || empty($_POST['nivelEst']) || empty($_POST['listStatus'])) {
        $arrResponse = array('status' => false,'msg' => 'Todos los campos son necesarios');
    } else {
        $idProfessor = $_POST['idProfessor'];
        $nome = $_POST['txtNome'];
        $apelido = $_POST['txtApelido'];
        $endereco = $_POST['txtEndereco'];
        $celula = $_POST['celula'];
        $telefone = $_POST['telefone'];
        $email = $_POST['email'];
        $nivelEst = $_POST['nivelEst'];
        $status = $_POST['listStatus'];

        $sql = "SELECT * FROM professor WHERE (celula = ? AND professor_id != ?)";
        $query = $pdo->prepare($sql);
        $query->execute(array($celula,$idProfessor));
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if($result > 0) {
            $arrResponse = array('status' => false,'msg' => 'Celula já registrado');
        } else {
            if($idProfessor == 0) {
                $sql_insert = "INSERT INTO professor (nome,apelido,endereco,celula,telefone,email,nivel_est,status) VALUES (?,?,?,?,?,?,?,?)";
                $query_insert = $pdo->prepare($sql_insert);
                $request = $query_insert->execute(array($nome,$apelido,$endereco,$celula,$telefone,$email,$nivelEst,$status));
                $option = 1;
            } else {
                $sql_update = "UPDATE professor SET nome = ?,apelido = ?,endereco = ?,celula = ?,telefone = ?,email = ?,nivel_est = ?,status = ? WHERE professor_id = ?";
                $query_update = $pdo->prepare($sql_update);
                $request = $query_update->execute(array($nome,$apelido,$endereco,$celula,$telefone,$email,$nivelEst,$status,$idProfessor));
                $option = 2;
            }
            
            if($request > 0) {
                if($option == 1) {
                   $arrResponse = array('status' => true,'msg' => 'Professor criado corretamente'); 
                } else {
                   $arrResponse = array('status' => true,'msg' => 'Professor atualizado corretamente');
                }
            } 
        }
    }
    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
}