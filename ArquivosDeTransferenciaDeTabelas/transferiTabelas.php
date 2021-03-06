<?php
/*
 * DATA DE CRIAÇÃO 20/10/2016
 * ULTIMA ATUALIZAÇÃO : 20/10/2016
 * 
 */
include_once '../util/conexaoBancoOrigem.php';
$conexaoBancoOrigem = conexaoBancoOrigem();
$listaDeDados = array();
$i = 0;
$tabelaOrigem = 'dbo.GFILIAL';
$selectOrigem = "SELECT * FROM $tabelaOrigem WHERE CODCOLIGADA = 3";
$resultado = mssql_query($selectOrigem);
while ($registro = mssql_fetch_array($resultado)) {
    $arrayDados = array();
    $arrayDados[] = $registro['CODCOLIGADA'];
    $arrayDados[] = $registro['CODFILIAL'];
    $arrayDados[] = $registro['CGC'];
    $arrayDados[] = $registro['NOMEFANTASIA'];
    $arrayDados[] = $registro['NOME'];
    $arrayDados[] = $registro['RECMODIFIEDON'];
    $listaDeDados[$i] = $arrayDados;
    $i++;
}
mssql_close($conexaoBancoOrigem);

include_once '../util/conexaoBancoDestino.php';
$conexaoBancoDestino = conectandoComBancoDestino();
for ($i = 0; $i < count($listaDeDados); $i++) {
    $arrayAuxiliar = $listaDeDados[$i];
    $selectDestino = "SELECT * FROM PHE_GFILIAL WHERE CODCOLIGADA = $arrayAuxiliar[0] "
            . "AND CODFILIAL = $arrayAuxiliar[1]";
    $result = mssql_query($selectDestino);
    $recmofifiedon = "";
    if (mssql_num_rows($result)) {
        while ($linha = mssql_fetch_array($result)) {
          $recmofifiedon = $linha['RECMODIFIEDON'];
        }
        if ($recmofifiedon != '' && $recmofifiedon != null && $arrayAuxiliar[5] > $recmofifiedon) {
          $update = "UPDATE PHE_GFILIAL SET NOME = '$arrayAuxiliar[4]', NOMEFANTASIA = '$arrayAuxiliar[3]', "
                    . "CGC = '$arrayAuxiliar[2]', RECMODIFIEDON = '$arrayAuxiliar[5]' "
                    . "WHERE CODCOLIGADA = $arrayAuxiliar[0] AND CODFILIAL = $arrayAuxiliar[1]";
          mssql_query($update);
        }
    }
    else{
        $insert = "INSERT dbo.PHE_GFILIAL (CODCOLIGADA,CODFILIAL,CGC,NOMEFANTASIA,NOME,RECMODIFIEDON) "
                . "VALUES ($arrayAuxiliar[0],$arrayAuxiliar[1],'$arrayAuxiliar[2]','$arrayAuxiliar[3]', "
                . "'$arrayAuxiliar[4]','$arrayAuxiliar[5]')";
        mssql_query($insert);
    }
}
mssql_close($conexaoBancoDestino);

    

