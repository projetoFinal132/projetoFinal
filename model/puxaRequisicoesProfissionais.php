<?php $status = session_status();
    if($status == PHP_SESSION_NONE){
        //There is no active session
        session_start();
    }
    include("conecta.php");
    mysqli_set_charset($conexao,'utf8');
    $resultado;
    $op = $_POST['op'];
    if($op == 10){
        $idProfissional = $_SESSION['profissional']['id_profissional'];
        $query = "SELECT * FROM profissional, atendimento_profissional, foto_perfil 
        WHERE fk_atendimento_profissional_profissional = $idProfissional 
        AND fk_id_profissional = $idProfissional 
        AND id_profissional = $idProfissional";
        $resultado = mysqli_fetch_assoc(mysqli_query($conexao, $query));
        //var_dump($resultado);
        echo json_encode($resultado);
    }

?>