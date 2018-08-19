<?php
    include_once("../class/profissional.php");
    include_once("../class/portifolio.php");
    include_once("../class/bairro.php");
    include_once("../class/cidade.php");
    include_once("../class/servico.php");
    include_once("../class/portifolio.php");
    include_once("conecta.php");
    mysqli_set_charset($conexao, 'utf8');
    function validaCPF($cpf){// isso precisa ser um helper depois
            $invalidos = array('00000000000','11111111111','22222222222','33333333333','44444444444','55555555555','66666666666','77777777777','88888888888','99999999999');
        if (in_array($cpf, $invalidos))
        return false;
        
        $cpf = preg_replace('/[^0-9]/', '', (string) $cpf);
        // Valida tamanho
        if (strlen($cpf) != 11)
            return false;
        // Calcula e confere primeiro dígito verificador
        for ($i = 0, $j = 10, $soma = 0; $i < 9; $i++, $j--)
            $soma += $cpf{$i} * $j;
        $resto = $soma % 11;
        if ($cpf{9} != ($resto < 2 ? 0 : 11 - $resto))
            return false;
        // Calcula e confere segundo dígito verificador
        for ($i = 0, $j = 11, $soma = 0; $i < 10; $i++, $j--)
            $soma += $cpf{$i} * $j;
        $resto = $soma % 11;
        return $cpf{10} == ($resto < 2 ? 0 : 11 - $resto);
    }

    function moveFoto($tmp, $nome){
        //echo $nome."nome ake<br>";
        //echo $tmp."diretorio<br>";
        $extensao = strtolower(substr($nome, -4));// pega extensao do arquivo
        $novo_nome = md5($nome.date("h:i:sa")).$extensao;// o md5 evita que tenha varios nomes iguais
        $diretorio= "../upload/"; // define o local pra onde via o arquivo
        //echo $novo_nome." nome foi<br>";
       if (move_uploaded_file($tmp, $diretorio.$novo_nome)) {// efetua upload
            //echo "moveu";
           return $novo_nome;
       }else{
        //echo "falsiene <br>";
           return false;
       }
    }
    //{$profissional->getSenhaUsuario()}
    function cadastraProfissional($conexao, $profissional){// LEMBRAR DE QUANDO PASSAR A FOTO DO PORTIFOLIO PASSAR NOME CERTIN 
        // IGUAL A AQUI https://www.youtube.com/watch?v=TsYwqnS5cCM
        //var_dump($profissional);
        //echo $profissional->getDiretorioFotoPerfil().$profissional->getNomeFotoPerfil()."<br>";
        $profissional->setNomeFotoPerfil(moveFoto($profissional->getDiretorioFotoPerfil(), $profissional->getNomeFotoPerfil()));
        //echo "<br>get foto<br>".$profissional->getNomeFotoPerfil();
        
        $query_usuario = "INSERT INTO usuario(email_usuario, tipo_usuario, nome_usuario, senha_usuario, diretorio_foto_perfil, nome_foto_perfil)
        VALUES ('{$profissional->getEmailUsuario()}', 2,'{$profissional->getNomeUsuario()}','123123','upload/','{$profissional->getNomeFotoPerfil()}')";
        $resultado_usuario = mysqli_query($conexao, $query_usuario);

        $query_profissional = "INSERT INTO profissional(fk_profissional_usuario, cpf_profissional, descricao_profissional, telefone_profissional) 
        VALUES('{$profissional->getEmailUsuario()}','{$profissional->getCpf()}','{$profissional->getDescricao()}','{$profissional->getTelefone()}')";
        $resultado_profissional = mysqli_query($conexao, $query_profissional);

        $query_profissional_tipo_servico = "INSERT INTO profissional_tipo_servico(fk_profissional_tipo_servico_usuario, fk_profissional_tipo_servico_tipo_servico) VALUES ('{$profissional->getEmailUsuario()}',{$profissional->getTipoServico()})";
        $resultadoProfissional_tipo_servico = mysqli_query($conexao, $query_profissional_tipo_servico);
        //echo $profissional->getCidade();
        $query_adicionaCidade = "INSERT INTO atendimento_profissional_cidade(fk_atendimento_profissional_usuario, fk_atendimento_profissional_cidade)
        VALUES ('{$profissional->getEmailUsuario()}',{$profissional->getidCidade()})";
        $resultadoAdicionaCidade = mysqli_query($conexao,$query_adicionaCidade);
 
        $query_adicionaBairro = "INSERT INTO atendimento_profissional_bairro(fk_atendimento_profissional_usuario, fk_atendimento_profissional_bairro, atendimento_profissional_bairro_cidade)
        VALUES ('{$profissional->getEmailUsuario()}',{$profissional->getIdBairro()}, {$profissional->getidCidade()})";
        $resultadoAdicionaBairro = mysqli_query($conexao,$query_adicionaBairro);
        
        $teste = $profissional->getPortifolio();
        //var_dump($teste);
        for ($i=0; $i<count($teste); $i++) {
                $novoNome = moveFoto($teste[$i]->diretorioFoto, $teste[$i]->nomeFoto);
                $query_portifolio = "INSERT INTO img_portifolio(fk_img_portifolio_usuario, diretorio_foto, nome_foto) 
                VALUES('{$profissional->getEmailUsuario()}', 'upload/', '$novoNome');";
                $resultadoPortifolio = mysqli_query($conexao,$query_portifolio);
            
        }
        
        if($resultado_profissional = 1 && $resultado_adicionaCidade = 1 && $resultado_foto = 1 && $resultadoProfissional_tipo_servico = 1){
            //echo "deu bom";
            return true;
        }else{
            //echo "deu ruim";
            return false;
        }

    }

    function buscaProfissional($conexao, $email){

        $profissional = new Profissional();

        $queryPegaProfissional = "SELECT usuario.email_usuario, usuario.nome_usuario, usuario.diretorio_foto_perfil, usuario.nome_foto_perfil, usuario.senha_usuario, 
            profissional.cpf_profissional, profissional.descricao_profissional, profissional.telefone_profissional
            FROM usuario, profissional
            WHERE usuario.email_usuario = '{$email}'
            GROUP BY usuario.email_usuario";
        $resultadoPegaProfissional = mysqli_fetch_assoc(mysqli_query($conexao, $queryPegaProfissional));

        //var_dump($resultadoPegaProfissional);

        $queryPegaPortifolioProfissional = "SELECT img_portifolio.diretorio_foto, img_portifolio.nome_foto
                                            FROM img_portifolio
                                            WHERE fk_img_portifolio_usuario = '{$email}'";
        $resultadoPegaPortifolioProfissional = mysqli_query($conexao, $queryPegaPortifolioProfissional);
        
        $portifolio = array();
        while ($img = mysqli_fetch_assoc($resultadoPegaPortifolioProfissional)){
            $imgPortifolio = new ImgPortifolio();
            $imgPortifolio->setDiretorioFoto($img["diretorio_foto"]);
            $imgPortifolio->setNomeFoto($img["nome_foto"]);
            array_push($portifolio, $imgPortifolio);
        }

        $queryPegaCidadeProfissional = "SELECT cidade.* 
            FROM cidade, atendimento_profissional_cidade
            WHERE atendimento_profissional_cidade.fk_atendimento_profissional_usuario = '{$email}' AND
            atendimento_profissional_cidade.fk_atendimento_profissional_cidade = cidade.id_cidade";
        $resultadoPegaCidadeProfissional = mysqli_query($conexao, $queryPegaCidadeProfissional);
        //acumulador de cidades e bairros dentro da cidade
        $cidades = array();
        while ($cidade1 = mysqli_fetch_assoc($resultadoPegaCidadeProfissional)){
            $cidade = new Cidade();
            //acumulador de barriros
            $queryPegaBairroProfissional = "SELECT bairro.id_bairro, bairro.nome_bairro, bairro.fk_bairro_cidade FROM  bairro, atendimento_profissional_bairro, cidade WHERE atendimento_profissional_bairro.fk_atendimento_profissional_usuario = '{$email}' AND atendimento_profissional_bairro.atendimento_profissional_bairro_cidade = {$cidade1["id_cidade"]} AND atendimento_profissional_bairro.fk_atendimento_profissional_bairro = bairro.id_bairro";
            $resultadoPegaBairroProfissional = mysqli_query($conexao, $queryPegaBairroProfissional);
            $bairros = array();
            while ($bairro1 = mysqli_fetch_assoc($resultadoPegaBairroProfissional)){
                //var_dump($bairro1);
                $bairro = new Bairro();
                $bairro->criaBairro($bairro1["id_bairro"], $bairro1["nome_bairro"], $bairro1["fk_bairro_cidade"]);
                array_push($bairros, $bairro);
            }

            $cidade->criaCidade($cidade1["id_cidade"], $bairros, $cidade1["nome_cidade"]);
            array_push($cidades, $cidade);
            //var_dump($cidade->getBairros());
        }
        
        $queryPegaServicoProfissional = "SELECT tipo_servico.* 
            FROM tipo_servico, profissional_tipo_servico, usuario
            WHERE profissional_tipo_servico.fk_profissional_tipo_servico_usuario = usuario.email_usuario AND
            profissional_tipo_servico.fk_profissional_tipo_servico_tipo_servico = tipo_servico.id_servico
            group by tipo_servico.id_servico";
        $resultadoPegaServicoProfissional = mysqli_query($conexao, $queryPegaServicoProfissional);

        $servicos = array();
        while ($servico1 = mysqli_fetch_assoc($resultadoPegaServicoProfissional)){
            //var_dump($bairro1);
            $servico = new Servico();
            $servico->criaServico($servico1["id_servico"], $servico1["nome_servico"]);
            array_push($servicos, $servico);
        }
        //var_dump($servicos);
        //var_dump($cidades);
        $profissional->criaProfissional($resultadoPegaProfissional["cpf_profissional"], $resultadoPegaProfissional["descricao_profissional"], $servicos, $resultadoPegaProfissional["telefone_profissional"], $portifolio, $resultadoPegaProfissional["email_usuario"], 2, $resultadoPegaProfissional["nome_usuario"], $resultadoPegaProfissional["senha_usuario"],$resultadoPegaProfissional["nome_foto_perfil"], $resultadoPegaProfissional["diretorio_foto_perfil"], $cidades);
        

        return $profissional;
    }
    function alteraFotoPortifolio($conexao, $novoNome, $nomeAntigo, $emailUsuario){
        $queryAlteraFoto = "UPDATE img_portifolio SET nome_foto = '{$novoNome}' WHERE fk_img_portifolio_usuario = '{$emailUsuario}' AND nome_foto = '{$nomeAntigo}'";
        $resultado = mysqli_query($conexao, $queryAlteraFoto);
        if ($resultado == 1) {echo 1;}else{ echo 2;}
    }
    function deletaFotoPortifolio($conexao, $nomeFoto, $emailUsuario){
        $queryDeletaFoto = "DELETE FROM img_portifolio WHERE nome_foto = '{$nomeFoto}' AND fk_img_portifolio_usuario = '{$emailUsuario}'";
        $resultado = mysqli_query($conexao, $queryDeletaFoto);
        if ($resultado == 1) {echo 1;}else{ echo 2;}
    }

    if ($_POST['op'] == 1) {
        $email = $_POST["email"];
       $profissional = buscaProfissional($conexao, $email);
       //var_dump($profissional);
       $profissionalSemSenha = $profissional->getTudo();
       unset($profissionalSemSenha["senha"]);
       echo json_encode($profissionalSemSenha);
    }else if($_POST['op'] == 2){
        $email = $_POST["email"];
        $profissional = buscaProfissional($conexao, $email);
        //var_dump($profissional);
        echo json_encode($profissional->getTelefone());
    }else if($_POST['op'] == 3){ //altera foto do profissional
        //var_dump($_POST);
        //var_dump($_FILES["novaImg"]);
        $caminho = '../upload/';
        $novoNome = moveFoto($_FILES["novaImg"]["tmp_name"], $_FILES["novaImg"]["name"]);
        $nomeFoto = $_POST["nomeFoto"];
        $emailUsuario = $_POST["emailUsuario"];
        alteraFotoPortifolio($conexao, $novoNome, $nomeFoto, $emailUsuario);
        unlink($caminho.$nomeFoto);
    }else if($_POST['op'] == 4){
        $nomeFoto = $_POST["nomeFoto"];
        $emailUsuario = $_POST["emailUsuario"];
        $caminho = '../upload/';
        deletaFotoPortifolio($conexao, $nomeFoto, $emailUsuario);
        unlink($caminho.$nomeFoto);
    }else if($_POST['op'] == 5){ // adiciona fotos da profissional
        //var_dump($_POST);
        //var_dump($_FILES);
        $arquivos = $_FILES;
        //var_dump($arquivoss);
        $portifolio = array();
        $email = $_POST["emailCliente"];
        foreach ($arquivos as $arquivo) {
            $imgPortiolio = new ImgPortifolio();
            $imgPortiolio->criaPortifolio($arquivo['tmp_name'], $arquivo['name']);
            array_push($portifolio, $imgPortiolio);
        }
        foreach ($portifolio as $foto) {
            $query = "INSERT INTO img_portifolio (fk_img_portifolio_usuario, diretorio_foto, nome_foto) VALUES('{$email}','upload/','{$foto->getNomeFoto()}')";
            $resultado = mysqli_query($conexao, $query);
        }
        //var_dump($portifolio);
        
    }else if($_POST['op'] == 6){
        var_dump($_POST);
        $comentario = $_POST['comentarioCliente'];
        $rdcheked = $_POST['rdcheked'];
        $emailProfissional = $_POST['emailProfissional'];
        $emailCliente = $_POST['emailCliente'];
        $query = "INSERT INTO avaliacao(estrela, comentario, fk_avaliacao_usuario, fk_avaliacao_profissional) VALUES({$rdcheked},'{$comentario}','{$emailCliente}','{$emailProfissional}')";
        $resultado = mysqli_query($conexao, $query);
        echo $resultado;
    }
    
?>