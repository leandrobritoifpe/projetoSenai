<?php

function conectandoComBancoDestino() {
    $servidor2 = "192.168.201.244";
    $usuario2 = "usrplanescolar";
    $banco2 = "PLANESCOLAR";
    $senha2 = "plan@senai";
//NÃ£o Alterar abaixo:
    $conmssql2 = mssql_connect($servidor2, $usuario2, $senha2);
    $db2 = mssql_select_db($banco2, $conmssql2);
    $cont2 = 0;
    if ($conmssql2 && $db2) {
        $cont2 += 1;
    }
    if ($cont2 == 0) {
        echo "<script>window.location='index.php';alert('ERRO AO SE CONNECTAR COM O BANCO');</script>";
    }

    return $conmssql2;
}
