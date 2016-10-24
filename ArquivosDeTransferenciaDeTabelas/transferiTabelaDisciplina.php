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
$tabelaOrigem = 'dbo.SDISCIPLINA';
$selectOrigem = "SELECT * FROM $tabelaOrigem WHERE CH IS NOT NULL AND CODCOLIGADA = 3";
$resultado = mssql_query($selectOrigem);
while ($registro = mssql_fetch_array($resultado)) {
    $arrayDados = array();
    $arrayDados[] = $registro['CODCOLIGADA'];
    $arrayDados[] = $registro['CODDISC'];
    $arrayDados[] = $registro['NOME'];
    $arrayDados[] = $registro['COMPLEMENTO'];
    $arrayDados[] = $registro['CH'];
    $arrayDados[] = $registro['RECMODIFIEDON'];
    $arrayDados[] = $registro['RECCREATEDON'];
    $listaDeDados[$i] = $arrayDados;
    $i++;
}
mssql_close($conexaoBancoOrigem);

include_once '../util/conexaoBancoDestino.php';
$conexaoBancoDestino = conectandoComBancoDestino();
for ($i = 0; $i < count($listaDeDados); $i++) {
    $arrayAuxiliar = $listaDeDados[$i];
    $selectDestino = "SELECT * FROM PHE_SDISCIPLINA WHERE CODDISC = '$arrayAuxiliar[1]'";
    $result = mssql_query($selectDestino);
    $recmofifiedon = "";
    if (mssql_num_rows($result)) {
        while ($linha = mssql_fetch_array($result)) {
          $recmofifiedon = $linha['RECMODIFIEDON'];
        }
        if ($recmofifiedon != '' && $recmofifiedon != null && $arrayAuxiliar[5] > $recmofifiedon) {
          $update = "UPDATE PHE_SDISCIPLINA SET NOME = '$arrayAuxiliar[2]', "
                    . "COMPLEMENTO = '$arrayAuxiliar[3]', CH = $arrayAuxiliar[4], "
                  . "RECMODIFIEDON = '$arrayAuxiliar[5]', RECCREATEDON = '$arrayAuxiliar[6]' WHERE CODDISC = '$arrayAuxiliar[1]'";
          mssql_query($update);
        }
    }
    else{
        $insert = "INSERT PHE_SDISCIPLINA (CODCOLIGADA,CODDISC,NOME,COMPLEMENTO,CH,RECMODIFIEDON,RECCREATEDON) "
                . "VALUES ($arrayAuxiliar[0],'$arrayAuxiliar[1]','$arrayAuxiliar[2]','$arrayAuxiliar[3]', "
                . "'$arrayAuxiliar[4]','$arrayAuxiliar[5]','$arrayAuxiliar[6]')";
        mssql_query($insert);
    }
}
mssql_close($conexaoBancoDestino);








