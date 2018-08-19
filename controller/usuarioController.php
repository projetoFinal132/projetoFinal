<?php
    include_once("../model/conecta.php");
    include_once("../model/usuarioModel.php");
    include_once("../class/usuario.php");
    include_once("../class/bairro.php");
    include_once("../class/cidade.php");
    $op = $_POST["op"];
    //var_dump($_POST);
    if ($op == 1) {
        $email = /*'lala69@gmail.com'*/$_POST['email'];
        $senha = /*'123123'*/$_POST['senha'];
        $usuario = logaUsuario($conexao, $email, $senha);
        //var_dump($usuario);
        echo json_encode($usuario->getTudo());
    }
    if ($op == 'cadastro') {
        $nomeFotoPerfil = /*'nomeFotoPerfil';*/$_FILES["fotoPerfil"];
        $nome = /*'nome';*/$_POST['nome'];
        $senha = /*'senha';*/$_POST['senha'];
        $cpf = /*'cpf';*/$_POST['cpf'];
        $email = /*'email';*/$_POST['email'];
        $cidade = /*'idCidade';*/$_POST['cidade'];
        $bairro = /*'idBairro';*/$_POST['bairro'];
        $usuario = new Usuario();
        $usuario->criaUsuario($email, 1, $nome, $senha, $nomeFotoPerfil['name'], $nomeFotoPerfil['tmp_name'], $cidade, $bairro);
        var_dump($usuario);
        cadastraUsuario($conexao, $usuario);
    }



    
?>