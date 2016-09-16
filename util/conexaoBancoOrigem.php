<?php
function conexaoBancoOrigem() {
    $servidor = "192.168.3.33";
    $usuario = "dario.rego";
    $banco = "OUTSYSTEMS";
    $senha = "dario@sql";
//NÃ£o Alterar abaixo:
    $conmssql = mssql_connect($servidor, $usuario, $senha);
    $db = mssql_select_db($banco, $conmssql);
    $cont = 0;
    if ($conmssql && $db) {
        $cont += 1;
    }
    if ($cont == 0) {
        echo "<script>window.location='index.php';alert('ERRO AO SE CONNECTAR COM O BANCO');</script>";
    }

    return $conmssql;
}
