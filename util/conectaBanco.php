<?php

function conectandoComBanco() {
    $servidor = "192.168.201.244";
    $usuario = "usrplanescolar";
    $banco = "PLANESCOLAR";
    $senha = "plan@senai";
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
