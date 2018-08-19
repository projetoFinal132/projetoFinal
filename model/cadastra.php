<?php
    include("conecta.php");
        // o option vai ter como valor o id da cidade

 
function validaCPF($cpf){
        $invalidos = array('00000000000',
                            '11111111111',
                            '22222222222',
                            '33333333333',
                            '44444444444',
                            '55555555555',
                            '66666666666',
                            '77777777777',
                            '88888888888',
                            '99999999999');
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
//FIM VALIDAÇÃO CPF

    if( validaCPF($_POST['cpf']) ){

        if ($_POST['cadastro'] == 'profissional') {
            $nome = $_POST['nome'];
            $cpf = $_POST['cpf'];
            $email = $_POST['email'];
            $telefone = $_POST['telefone'];
            $descricao = $_POST['descricao'];
            $idCidade = $_POST['cidade'];
            $idBairro = $_POST['bairro'];
            $idTipoServico = $_POST['tipos-servico'];
            
            //echo $idTipoServico."<br>".$idCidade."<br>".$idBairro;
    
            $query_profissional = "INSERT INTO profissional (nome_profissional, cpf_profissional, email_profissional, telefone_profissional, descricao)
                                   VALUES ('$nome','$cpf','$email','$telefone','$descricao')";
            $resultado_profissional = mysqli_query($conexao, $query_profissional);
    
            $query_pegaUltimoId = "SELECT MAX(id_profissional) FROM profissional";
            $resultado_pegaUltimoId = mysqli_query($conexao, $query_pegaUltimoId);
            
            //pega id do profissional
            //var_dump($resultado_pegaUltimoId);
            $idProfissional = mysqli_fetch_assoc($resultado_pegaUltimoId);
            //echo "<br> id profissional".$idProfissional['MAX(id_profissional)']."<br>";
            $idProfissional = $idProfissional['MAX(id_profissional)'];
            //$idProfissional = mysqli_fetch_assoc($resultado_pegaUltimoId) ; 
            
            $query_profissional_tipo_servico = "INSERT INTO 
            profissional_tipo_servico(fk_profissional_tipo_servico_profissional, fk_profissional_tipo_servico_tipo_servico)
            VALUES ($idProfissional,$idTipoServico)";
            $resultadoProfissional_tipo_servico = mysqli_query($conexao, $query_profissional_tipo_servico);

            $query_adicionaCidadeBairro = "INSERT INTO 
                                           atendimento_profissional (fk_atendimento_profissional_profissional,fk_atendimento_profissional_cidade,fk_atendimento_profissional_bairro)
                                           VALUES ($idProfissional,$idCidade,$idBairro)";
            $resultadoAdicionaCidade = mysqli_query($conexao,$query_adicionaCidadeBairro);
    
    
                //var_dump($_FILES['arquivo']['name']);
                $extensao = strtolower(substr($_FILES['arquivo']['name'], -4));// pega extensao do arquivo
                $novo_nome = md5($_FILES['arquivo']['name']).$extensao;// o md5 evita que tenha varios nomes iguais
                $diretorio= "../upload/"; // define o local pra onde via o arquivo
                move_uploaded_file($_FILES['arquivo']['tmp_name'], $diretorio.$novo_nome);// efetua upload
                
                
                $sql_foto = "INSERT INTO foto_perfil 
                (diretorio_foto ,nome_foto, fk_id_profissional, fk_id_cliente) 
                VALUES('upload/','$novo_nome', '$idProfissional', 0)";
                $resultado_foto = mysqli_query($conexao,$sql_foto);
                
                if($resultado_profissional = 1 && $resultado_pegaUltimoId = 1 && $resultado_adicionaCidade = 1 && $resultado_foto = 1 && $resultadoProfissional_tipo_servico = 1){
                    //echo "deu bom";
                    header("location: http://localhost/sla/index.php");
                }else{
                    //echo "deu ruim";
                    header("location: http://localhost/sla/index.php");
                }
    
        }else if ($_POST['cadastro'] == 'cliente') {
            $nome = $_POST['nome'];
            $cpf = $_POST['cpf'];
            $email = $_POST['email'];
            $telefone = $_POST['telefone'];
            $idCidade = $_POST['cidade'];
            $idBairro = $_POST['bairro'];
            $senha_cliente = $_POST['senha'];
    
            $query_profissional = "INSERT INTO cliente (nome_cliente, cpf_cliente, email_cliente, senha_cliente, telefone_cliente)
                                   VALUES ('$nome','$cpf','$email', '$senha_cliente','$telefone')";
    
            $resultado_profissional = mysqli_query($conexao, $query_profissional);
            //var_dump($resultado_profissional);

            $query_pegaUltimoId = "SELECT MAX(id_cliente) FROM cliente";
            $resultado_pegaUltimoId = mysqli_query($conexao, $query_pegaUltimoId);
    
    
            var_dump($resultado_pegaUltimoId);
            $idCliente = mysqli_fetch_assoc($resultado_pegaUltimoId);
            //echo "<br> id cliente".$idCliente['MAX(id_cliente)']."<br>";
            $idCliente = $idCliente['MAX(id_cliente)'];
            //$idProfissional = mysqli_fetch_assoc($resultado_pegaUltimoId) ; 
    
            $query_adicionaCidadeBairro = "INSERT INTO 
                                           moradia_cliente (fk_moradia_cliente_cliente, fk_moradia_cliente_cidade, fk_moradia_cliente_bairro)
                                           VALUES ('$idCliente',$idCidade,'$idBairro')";
            
            $resultadoAdicionaCidade = mysqli_query($conexao, $query_adicionaCidadeBairro);
    
                var_dump($_FILES['arquivo']['name']);
                $extensao = strtolower(substr($_FILES['arquivo']['name'], -4));// pega extensao do arquivo
                $novo_nome = md5($_FILES['arquivo']['name']).$extensao;// o md5 evita que tenha varios nomes iguais
                $diretorio= "../upload/"; // define o local pra onde via o arquivo
               
                
                move_uploaded_file($_FILES['arquivo']['tmp_name'], $diretorio.$novo_nome);// efetua upload
                
                
                $sql_foto = "INSERT INTO foto_perfil 
                (diretorio_foto ,nome_foto, fk_id_profissional, fk_id_cliente) 
                VALUES('upload/','$novo_nome', 0, $idCliente)";
                
                $resultado_foto = mysqli_query($conexao,$sql_foto);
    
                if ($resultado_profissional && $resultado_pegaUltimoId && $resultadoAdicionaCidade && $resultado_foto) {
                   echo "deu bom";
                   header("location: http://localhost/sla/index.php");
                }else{
                    echo"deu ruim";
                    header("location: http://localhost/sla/index.php");
                }
                
        }

    }


?>