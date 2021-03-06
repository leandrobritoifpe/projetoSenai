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
$tabelaOrigem = 'dbo.SEIXOTECNOLOGICO';
$selectOrigem = "SELECT * FROM $tabelaOrigem";
$resultado = mssql_query($selectOrigem);
while ($registro = mssql_fetch_array($resultado)) {
    $arrayDados = array();
    $arrayDados[] = $registro['IDEIXOTECNOLOGICO'];
    $arrayDados[] = $registro['CODEIXOTECNOLOGICO'];
    $arrayDados[] = $registro['NOME'];
    $arrayDados[] = $registro['DESCRICAO'];
    $arrayDados[] = $registro['RECMODIFIEDON'];
    $listaDeDados[$i] = $arrayDados;
    $i++;
}
mssql_close($conexaoBancoOrigem);

include_once '../util/conexaoBancoDestino.php';
$conexaoBancoDestino = conectandoComBancoDestino();
$tabelaDestino = 'PHE_SEIXOTECNOLOGICO';
for ($i = 0; $i < count($listaDeDados); $i++) {
    $arrayAuxiliar = $listaDeDados[$i];
    $selectDestino = "SELECT * FROM $tabelaDestino WHERE IDEIXOTECNOLOGICO = $arrayAuxiliar[0]";
    $result = mssql_query($selectDestino);
    $recmofifiedon = "";
    if (mssql_num_rows($result)) {
        while ($linha = mssql_fetch_array($result)) {
          $recmofifiedon = $linha['RECMODIFIEDON'];
        }
        if ($recmofifiedon != '' && $recmofifiedon != null && $arrayAuxiliar[4] > $recmofifiedon) {
         $update = "UPDATE $tabelaDestino SET CODEIXOTECNOLOGICO = '$arrayAuxiliar[1]', "
                    . "NOME = '$arrayAuxiliar[2]', DESCRICAO = '$arrayAuxiliar[3]', "
                  . "RECMODIFIEDON = '$arrayAuxiliar[4]'"
                 . "WHERE IDEIXOTECNOLOGICO = $arrayAuxiliar[0]";
          mssql_query($update);
        }
    }
    else{
       $insert = "INSERT $tabelaDestino (IDEIXOTECNOLOGICO,CODEIXOTECNOLOGICO,NOME,DESCRICAO,RECMODIFIEDON) "
                . "VALUES ($arrayAuxiliar[0],'$arrayAuxiliar[1]','$arrayAuxiliar[2]','$arrayAuxiliar[3]','$arrayAuxiliar[4]')";
        mssql_query($insert);
    }
}
mssql_close($conexaoBancoDestino);


