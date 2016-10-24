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
$tabelaOrigem = 'dbo.SPROFESSOR';
$selectOrigem = "SELECT * FROM $tabelaOrigem WHERE CODCOLIGADA = 3";
$resultado = mssql_query($selectOrigem);
while ($registro = mssql_fetch_array($resultado)) {
    $arrayDados = array();
    $arrayDados[] = $registro['CODCOLIGADA'];
    $arrayDados[] = $registro['CHAPA'];
    $arrayDados[] = $registro['CODPROF'];
    $arrayDados[] = $registro['CODPESSOA'];
    $arrayDados[] = $registro['RECMODIFIEDON'];    
    $listaDeDados[$i] = $arrayDados;
    $i++;
}
mssql_close($conexaoBancoOrigem);

include_once '../util/conexaoBancoDestino.php';
$conexaoBancoDestino = conectandoComBancoDestino();
$tabelaDestino = 'PHE_SPROFESSOR';
for ($i = 0; $i < count($listaDeDados); $i++) {
    $arrayAuxiliar = $listaDeDados[$i];
    $selectDestino = "SELECT * FROM $tabelaDestino WHERE CODPROF = '$arrayAuxiliar[2]'";
    $result = mssql_query($selectDestino);
    $recmofifiedon = "";
    if (mssql_num_rows($result)) {
        while ($linha = mssql_fetch_array($result)) {
          $recmofifiedon = $linha['RECMODIFIEDON'];
        }
        if ($recmofifiedon != '' && $recmofifiedon != null && $arrayAuxiliar[4] > $recmofifiedon) {
         $update = "UPDATE $tabelaDestino SET CHAPA = '$arrayAuxiliar[1]', "
                    . "CODPESSOA = $arrayAuxiliar[3],RECMODIFIEDON = '$arrayAuxiliar[4]'"
                 . "WHERE CODPROF = '$arrayAuxiliar[2]'";
          mssql_query($update);
        }
    }
    else{
       $insert = "INSERT $tabelaDestino (CODCOLIGADA,CHAPA,CODPROF,CODPESSOA,RECMODIFIEDON) "
                . "VALUES ($arrayAuxiliar[0],'$arrayAuxiliar[1]','$arrayAuxiliar[2]',$arrayAuxiliar[3],'$arrayAuxiliar[4]')";
        mssql_query($insert);
    }
}
mssql_close($conexaoBancoDestino);








