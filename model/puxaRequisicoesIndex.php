<?php
include("conecta.php");
    // se escolha for 1 será servicos 
    // se escolha for 2 será cidade
    // se escolha for 3 será bairro
    $escolha = json_decode($_POST["escolha"]);

   
    if ($escolha == 1) {
        mysqli_set_charset($conexao,'utf8');
        // echo"entrei em servico";
         $query = "SELECT * FROM tipo_servico";
                     
         $tipoServicos = array();
         $resultado = mysqli_query($conexao, $query);

         while ($servico = mysqli_fetch_assoc($resultado)) {
             array_push($tipoServicos,$servico);
         }
        // var_dump($tipoServicos);
         echo json_encode($tipoServicos);
    }else if($escolha == 2){

        mysqli_set_charset($conexao,'utf8');
        // echo"entrei em cidade";
         $query_cidade = "SELECT * FROM cidade";
                     
         $cidades = array();
         $resultado_cidade = mysqli_query($conexao, $query_cidade);
    
         while ($cidade = mysqli_fetch_assoc($resultado_cidade)) {
             array_push($cidades,$cidade);
         }
         //var_dump($cidades);
         echo json_encode($cidades);

    }else if($escolha == 3){

        $idCidade = json_decode($_POST["idCidade"]);
        mysqli_set_charset($conexao,'utf8');
        // echo"entrei em bairro";
         $query_bairro = "SELECT id_bairro, nome_bairro FROM bairro WHERE $idCidade = fk_bairro_cidade";
                     
         $bairros = array();
         $resultado_bairro = mysqli_query($conexao, $query_bairro);
    
         while ($bairro = mysqli_fetch_assoc($resultado_bairro)) {
             array_push($bairros,$bairro);
         }
         //var_dump($bairros);
         echo json_encode($bairros);

    }
           
            
     
   // mysql_close($conexao);
?>