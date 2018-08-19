<?php
    //session_destroy();
    $status = session_status();
    if($status == PHP_SESSION_NONE){
        //There is no active session
        session_start();
    }
    mysqli_set_charset($conexao,'utf8');

    include_once("../class/usuario.php");
    include_once("../class/bairro.php");
    include_once("../class/cidade.php");

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

    function logaUsuario($conexao, $email, $senha){
        // ususario 1 é cliente 2 é funcionario
        
        $query_usuario = "SELECT * FROM usuario WHERE '{$senha}' = senha_usuario AND '{$email}' = email_usuario";
        $resultado_usuario = mysqli_fetch_assoc(mysqli_query($conexao, $query_usuario));
        
       

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
            $usuario = new Usuario();
            $usuario->criaUsuario($resultado_usuario["email_usuario"], $resultado_usuario["tipo_usuario"], $resultado_usuario["nome_usuario"], $resultado_usuario["senha_usuario"], $resultado_usuario["nome_foto_perfil"], $resultado_usuario["diretorio_foto_perfil"], $cidades, $cidade->getBairros());
            
            return $usuario;
    }

    function cadastraUsuario($conexao, $usuario){// LEMBRAR DE QUANDO PASSAR A FOTO DO PORTIFOLIO PASSAR NOME CERTIN 
        // IGUAL A AQUI https://www.youtube.com/watch?v=TsYwqnS5cCM
        //var_dump($profissional);
        //echo $profissional->getDiretorioFotoPerfil().$profissional->getNomeFotoPerfil()."<br>";
        $usuario->setNomeFotoPerfil(moveFoto($usuario->getDiretorioFotoPerfil(), $usuario->getNomeFotoPerfil()));
        //echo "<br>get foto<br>".$profissional->getNomeFotoPerfil();

        $query_usuario = "INSERT INTO usuario(email_usuario, tipo_usuario, nome_usuario, senha_usuario, diretorio_foto_perfil, nome_foto_perfil)
        VALUES ('{$usuario->getEmailUsuario()}', 1,'{$usuario->getNomeUsuario()}','{$usuario->getSenhaUsuario()}','upload/','{$usuario->getNomeFotoPerfil()}')";
        $resultado_usuario = mysqli_query($conexao, $query_usuario);

        $query_adicionaCidade = "INSERT INTO atendimento_profissional_cidade(fk_atendimento_profissional_usuario, fk_atendimento_profissional_cidade)
        VALUES ('{$usuario->getEmailUsuario()}',{$usuario->getCidade()})";
        $resultadoAdicionaCidade = mysqli_query($conexao,$query_adicionaCidade);

        $query_adicionaBairro = "INSERT INTO atendimento_profissional_bairro(fk_atendimento_profissional_usuario, fk_atendimento_profissional_bairro, atendimento_profissional_bairro_cidade)
        VALUES ('{$usuario->getEmailUsuario()}',{$usuario->getBairro()}, {$usuario->getCidade()})";
        $resultadoAdicionaBairro = mysqli_query($conexao,$query_adicionaBairro);

        if($resultado_usuario == 1 && $resultadoAdicionaCidade == 1){
            //echo "deu bom";
            return true;
        }else{
            //echo "deu ruim";
            return false;
        }

    }
?>