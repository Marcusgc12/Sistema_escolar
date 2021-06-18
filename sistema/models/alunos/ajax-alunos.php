<?php
require_once '../../includes/config.php';

if(!empty($_POST)) {
    if(empty($_POST['txtNome']) || empty($_POST['txtApelido']) || empty($_POST['idade']) || empty($_POST['txtEndereco']) || empty($_POST['celula']) || empty($_POST['telefone']) || empty($_POST['email']) || empty($_POST['dataNasc']) || empty($_POST['listStatus'])) {
        $arrResponse = array('status' => false,'msg' => 'Todos los campos son necesarios');
    } else {
        $idAluno = $_POST['idAluno'];
        $nome = $_POST['txtNome'];
        $apelido = $_POST['txtApelido'];
        $idade = $_POST['idade'];
        $endereco = $_POST['txtEndereco'];
        $celula = $_POST['celula'];
        $telefone = intval($_POST['telefone']);
        $email = $_POST['email'];
        $dataNasc = $_POST['dataNasc'];
        $status = $_POST['listStatus'];

        $sql = "SELECT * FROM alunos WHERE (celula = ? AND aluno_id != ?)";
        $query = $pdo->prepare($sql);
        $query->execute(array($celula,$idAluno));
        $request = $query->fetch(PDO::FETCH_ASSOC);

        if($request > 0) {
            $arrResponse = array('status' => false,'msg' => 'Celula ya registrada');
        } else {
            if($idAluno == 0) {
                $sql_insert = "INSERT INTO alunos (nome,apelido,idade,endereco,celula,telefone,email,data_nasc,status) VALUES (?,?,?,?,?,?,?,?,?)";
                $query_insert = $pdo->prepare($sql_insert);
                $request = $query_insert->execute(array($nome,$apelido,$idade,$endereco,$celula,$telefone,$email,$dataNasc,$status));
                $option = 1;
            } else {
                $sql_update = "UPDATE alunos SET nome = ?,apelido = ?,idade = ?,endereco = ?,celula = ?,telefone = ?,email = ?,data_nasc = ?,status = ? WHERE aluno_id = ?";
                $query_update = $pdo->prepare($sql_update);
                $request = $query_update->execute(array($nome,$apelido,$idade,$endereco,$celula,$telefone,$email,$dataNasc,$status,$idAluno));
                $option = 2;
            }
            
            if($request > 0) {
                if($option == 1) {
                    $arrResponse = array('status' => true,'msg' => 'Aluno criado corretamente');
                } else {
                    $arrResponse = array('status' => true,'msg' => 'Aluno atualizado corretamente');
                }
            } 
        }
    }
    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
}