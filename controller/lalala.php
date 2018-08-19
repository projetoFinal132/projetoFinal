
if ($_POST['op'] == 'cadastro') {
        $nomeFotoPerfil = /*'nomeFotoPerfil';*/$_FILES["fotoPerfil"];
        $nome = /*'nome';*/$_POST['nome'];
        $senha = /*'senha';*/$_POST['senha'];
        $cpf = /*'cpf';*/$_POST['cpf'];
        $email = /*'email';*/$_POST['email'];
        $telefone = /*'telefone';*/$_POST['telefone'];
        $descricao = /*'descricao';*/$_POST['descricao'];
        $idCidade = /*'idCidade';*/$_POST['cidade'];
        $idBairro = /*'idBairro';*/$_POST['bairro'];
        $idTipoServico = /*'idTipoServico';*/$_POST['tipos-servico'];
        $arquivos = /*'arquivos';*/isset($_FILES["fotosPortifolio"]) ? $_FILES["fotosPortifolio"] : false;

        echo $_POST['nome']." nome <br>";
        echo $_POST['senha']." senha <br>";
        echo $_POST['tipos-servico']." serv <br>";
        echo $_POST['cidade']." cidade <br>";
        echo $_POST['bairro']." bairro <br>";
        echo "as"."<br>";

        if($arquivos && $nomeFotoPerfil &&  $nome && $senha && $cpf && $email && $telefone && $descricao && $idCidade && $idBairro && $idTipoServico) {
            $profissional = new Profissional();
            $portifolio = array();
            $cidade = new Cidade();
            $cidade->criaCidade($idCidade, $idBairro);

            if ($arquivos){
                for($i=0; $i<count($arquivos['name']); $i++){
                    $imgPortiolio = new ImgPortifolio();
                    $imgPortiolio->criaPortifolio($arquivos['tmp_name'][$i], $arquivos['name'][$i]);
                    array_push($portifolio, $imgPortiolio);
                }
            }
            
        
        // criaProfissional($cpfProfissional, $descricaoProfissional, $tipoServico, $telefoneProfissional, $portifolio, $emailUsuario, $tipoUsuario, $nomeUsuario, $senhaUsuario, $nomeFotoPerfil, $diretorioFotoPerfil, $cidade, $bairro)
            $profissional->criaProfissional($cpf, $descricao, $idTipoServico, $telefone, $portifolio, $email, 2, $nome, $senha, $nomeFotoPerfil['name'], $nomeFotoPerfil['tmp_name'], $cidade);
            
        }
         //echo "ake ".$profissional->getCpf();
        echo "teste função op gg".$cidade->getBairros();
        var_dump($cidade);
        var_dump($profissional); 
        //cadastraProfissional($conexao, $profissional);
    }