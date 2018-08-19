<?php
    $status = session_status();
    if($status == PHP_SESSION_NONE){
        //There is no active session
        session_start();
    }
    include("conecta.php");
    mysqli_set_charset($conexao,'utf8');
    $op = $_POST['op'];
    $resultado;
    // 1= pega prifissionais e pronto se op for 2 é pra pegar portifolio para o cliente, 3 para pegar por serviço
    // se for 10 é pra montar a pag com as informações da cliente
    // se for 5 é uma busca com nome e serv vazios || se for 6 é nome vazio || se for 7 é serviço vazio || se for 8 é pq ta tudo preenchido
    if ($op == 1) {
        $query = "SELECT tipo_servico.* ,usuario.email_usuario, usuario.nome_usuario, usuario.diretorio_foto_perfil, usuario.nome_foto_perfil, 
        profissional.cpf_profissional, profissional.descricao_profissional, profissional.telefone_profissional,
        cidade.id_cidade, cidade.nome_cidade, bairro.id_bairro, bairro.nome_bairro
        FROM usuario, profissional, tipo_servico, profissional_tipo_servico, cidade, bairro, atendimento_profissional_cidade, atendimento_profissional_bairro
        WHERE fk_profissional_usuario = usuario.email_usuario AND usuario.email_usuario = usuario.email_usuario AND 
        atendimento_profissional_bairro.fk_atendimento_profissional_usuario = usuario.email_usuario AND
        atendimento_profissional_cidade.fk_atendimento_profissional_usuario = usuario.email_usuario AND
        bairro.id_bairro = atendimento_profissional_bairro.fk_atendimento_profissional_bairro AND
        cidade.id_cidade = atendimento_profissional_cidade.fk_atendimento_profissional_cidade AND
        tipo_servico.id_servico = profissional_tipo_servico.fk_profissional_tipo_servico_tipo_servico AND
        profissional_tipo_servico.fk_profissional_tipo_servico_usuario = usuario.email_usuario
        GROUP BY usuario.email_usuario";
        $resultado = mysqli_query($conexao, $query);
        $profissionais = array();
        while ($profissional = mysqli_fetch_assoc($resultado)) {
            array_push($profissionais,$profissional);
        }
        //var_dump($profissionais);
        echo json_encode($profissionais);
    }else if($op == 2){
        $idProfissional = $_POST['idProfissionalProtifolio'];
        $query = "SELECT * FROM img_portifolio
        WHERE fk_img_portifolio_usuario = '{$idProfissional}'";
         $resultado = mysqli_query($conexao, $query);
         $portifolio = array();
         while ($foto = mysqli_fetch_assoc($resultado)) {
             array_push($portifolio,$foto);
         }
         //var_dump($portifolio);
         echo json_encode($portifolio);
    }else if($op == 5){
        $idCidade = json_decode($_POST["idCidade"]);
        $idBairro = json_decode($_POST["idBairro"]);

        $query_filtro = "SELECT tipo_servico.* ,usuario.email_usuario, usuario.nome_usuario, usuario.diretorio_foto_perfil, usuario.nome_foto_perfil, 
        profissional.cpf_profissional, profissional.descricao_profissional, profissional.telefone_profissional,
        cidade.id_cidade, cidade.nome_cidade, bairro.id_bairro, bairro.nome_bairro
        FROM usuario, profissional, tipo_servico, profissional_tipo_servico, cidade, bairro, atendimento_profissional_cidade, atendimento_profissional_bairro
        WHERE fk_profissional_usuario = usuario.email_usuario AND usuario.email_usuario = usuario.email_usuario AND 
        atendimento_profissional_bairro.fk_atendimento_profissional_usuario = usuario.email_usuario AND
        atendimento_profissional_cidade.fk_atendimento_profissional_usuario = usuario.email_usuario AND
        $idBairro = atendimento_profissional_bairro.fk_atendimento_profissional_bairro AND
        $idCidade = atendimento_profissional_cidade.fk_atendimento_profissional_cidade AND
        $idBairro = bairro.id_bairro AND
        $idCidade = cidade.id_cidade AND
        tipo_servico.id_servico = profissional_tipo_servico.fk_profissional_tipo_servico_tipo_servico AND
        profissional_tipo_servico.fk_profissional_tipo_servico_usuario = usuario.email_usuario
        GROUP BY email_usuario";

        $resultado_filtro = mysqli_query($conexao, $query_filtro);
        $profissionais = array();
        while ($profissional = mysqli_fetch_assoc($resultado_filtro)) {
            array_push($profissionais, $profissional);
        }
        //var_dump($profissionais);
        echo json_encode($profissionais);
    }else if($op == 6){
        $idCidade = json_decode($_POST["idCidade"]);
        $idBairro = json_decode($_POST["idBairro"]);
        $idServico = json_decode($_POST["idServico"]);

        $query_filtro = "SELECT tipo_servico.* ,usuario.email_usuario, usuario.nome_usuario, usuario.diretorio_foto_perfil, usuario.nome_foto_perfil, 
        profissional.cpf_profissional, profissional.descricao_profissional, profissional.telefone_profissional,
        cidade.id_cidade, cidade.nome_cidade, bairro.id_bairro, bairro.nome_bairro
        FROM usuario, profissional, tipo_servico, profissional_tipo_servico, cidade, bairro, atendimento_profissional_cidade, atendimento_profissional_bairro
        WHERE fk_profissional_usuario = usuario.email_usuario AND usuario.email_usuario = usuario.email_usuario AND 
        atendimento_profissional_bairro.fk_atendimento_profissional_usuario = usuario.email_usuario AND
        atendimento_profissional_cidade.fk_atendimento_profissional_usuario = usuario.email_usuario AND
        $idBairro = atendimento_profissional_bairro.fk_atendimento_profissional_bairro AND
        $idCidade = atendimento_profissional_cidade.fk_atendimento_profissional_cidade AND
        $idBairro = bairro.id_bairro AND
        $idCidade = cidade.id_cidade AND
        $idServico  = profissional_tipo_servico.fk_profissional_tipo_servico_tipo_servico AND
        tipo_servico.id_servico = $idServico AND
        profissional_tipo_servico.fk_profissional_tipo_servico_usuario = usuario.email_usuario
        GROUP BY email_usuario";

        $resultado_filtro = mysqli_query($conexao, $query_filtro);
        $profissionais = array();
        while ($profissional = mysqli_fetch_assoc($resultado_filtro)) {
            array_push($profissionais, $profissional);
        }
        //var_dump($profissionais);
        echo json_encode($profissionais);
    }else if($op == 7){
        $idCidade = json_decode($_POST["idCidade"]);
        $idBairro = json_decode($_POST["idBairro"]);
        $nomeProfissional = $_POST["nomeProfissional"];

        $query_filtro = "SELECT tipo_servico.* ,usuario.email_usuario, usuario.nome_usuario, usuario.diretorio_foto_perfil, usuario.nome_foto_perfil, 
        profissional.cpf_profissional, profissional.descricao_profissional, profissional.telefone_profissional,
        cidade.id_cidade, cidade.nome_cidade, bairro.id_bairro, bairro.nome_bairro
        FROM usuario, profissional, tipo_servico, profissional_tipo_servico, cidade, bairro, atendimento_profissional_cidade, atendimento_profissional_bairro
        WHERE fk_profissional_usuario = usuario.email_usuario AND usuario.email_usuario = usuario.email_usuario AND 
        atendimento_profissional_bairro.fk_atendimento_profissional_usuario = usuario.email_usuario AND
        atendimento_profissional_cidade.fk_atendimento_profissional_usuario = usuario.email_usuario AND
        $idBairro = atendimento_profissional_bairro.fk_atendimento_profissional_bairro AND
        $idCidade = atendimento_profissional_cidade.fk_atendimento_profissional_cidade AND
        $idBairro = bairro.id_bairro AND
        $idCidade = cidade.id_cidade AND
        usuario.nome_usuario = '{$nomeProfissional}' AND
        tipo_servico.id_servico = profissional_tipo_servico.fk_profissional_tipo_servico_tipo_servico AND
        profissional_tipo_servico.fk_profissional_tipo_servico_usuario = usuario.email_usuario
        GROUP BY email_usuario";

        $resultado_filtro = mysqli_query($conexao, $query_filtro);
        $profissionais = array();
        while ($profissional = mysqli_fetch_assoc($resultado_filtro)) {
            array_push($profissionais, $profissional);
        }
        //var_dump($profissionais);
        echo json_encode($profissionais);
    }else if($op == 8){
        $idCidade = json_decode($_POST["idCidade"]);
        $idBairro = json_decode($_POST["idBairro"]);
        $nomeProfissional = $_POST["nomeProfissional"];
        $idServico = json_decode($_POST["idServico"]);
        
        $query_filtro = "SELECT tipo_servico.* ,usuario.email_usuario, usuario.nome_usuario, usuario.diretorio_foto_perfil, usuario.nome_foto_perfil, 
        profissional.cpf_profissional, profissional.descricao_profissional, profissional.telefone_profissional,
        cidade.id_cidade, cidade.nome_cidade, bairro.id_bairro, bairro.nome_bairro
        FROM usuario, profissional, tipo_servico, profissional_tipo_servico, cidade, bairro, atendimento_profissional_cidade, atendimento_profissional_bairro
        WHERE fk_profissional_usuario = usuario.email_usuario AND usuario.email_usuario = usuario.email_usuario AND 
        atendimento_profissional_bairro.fk_atendimento_profissional_usuario = usuario.email_usuario AND
        atendimento_profissional_cidade.fk_atendimento_profissional_usuario = usuario.email_usuario AND
        $idBairro = atendimento_profissional_bairro.fk_atendimento_profissional_bairro AND
        $idCidade = atendimento_profissional_cidade.fk_atendimento_profissional_cidade AND
        $idBairro = bairro.id_bairro AND
        $idCidade = cidade.id_cidade AND
        usuario.nome_usuario = '{$nomeProfissional}' AND
        tipo_servico.id_servico = $idServico AND
        profissional_tipo_servico.fk_profissional_tipo_servico_usuario = usuario.email_usuario
        GROUP BY email_usuario";

        $resultado_filtro = mysqli_query($conexao, $query_filtro);
        $profissionais = array();
        while ($profissional = mysqli_fetch_assoc($resultado_filtro)) {
            array_push($profissionais, $profissional);
        }
        //var_dump($profissionais);
        echo json_encode($profissionais);
    }else if($op == 10){
        $email = $_POST["email"];
        //var_dump($email);
        $query = "SELECT * FROM usuario
        WHERE email_usuario = '{$email}'";
        $resultado = mysqli_fetch_assoc(mysqli_query($conexao, $query));
        //var_dump($resultado);
        //$resultado = $resultado[0];
        echo json_encode($resultado);
    }
    //   select nome_servico from tipo_servico, profissional_tipo_servico, profissional where profissional.id_profissional = profissional_tipo_servico.fk_profissional_tipo_servico_profissional AND profissional_tipo_servico.fk_profissional_tipo_servico_tipo_servico = tipo_servico.id_tipo_servico;
?> 
