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
$tabelaOrigem = 'dbo.STIPOSALA';
$selectOrigem = "SELECT * FROM $tabelaOrigem WHERE CODCOLIGADA = 3";
$resultado = mssql_query($selectOrigem);
while ($registro = mssql_fetch_array($resultado)) {
    $arrayDados = array();
    $arrayDados[] = $registro['CODCOLIGADA'];
    $arrayDados[] = $registro['CODTIPOSALA'];
    $arrayDados[] = $registro['NOME'];
    $arrayDados[] = $registro['PERMITERESERVA'];
    $arrayDados[] = $registro['RECMODIFIEDON'];
    $listaDeDados[$i] = $arrayDados;
    $i++;
}
mssql_close($conexaoBancoOrigem);

include_once '../util/conexaoBancoDestino.php';
$conexaoBancoDestino = conectandoComBancoDestino();
$tabelaDestino = 'PHE_STIPOSALA';
for ($i = 0; $i < count($listaDeDados); $i++) {
    $arrayAuxiliar = $listaDeDados[$i];
    $selectDestino = "SELECT * FROM $tabelaDestino WHERE CODTIPOSALA = $arrayAuxiliar[1]";
    $result = mssql_query($selectDestino);
    $recmofifiedon = "";
    if (mssql_num_rows($result)) {
        while ($linha = mssql_fetch_array($result)) {
          $recmofifiedon = $linha['RECMODIFIEDON'];
        }
        if ($recmofifiedon != '' && $recmofifiedon != null && $arrayAuxiliar[4] > $recmofifiedon) {
         $update = "UPDATE $tabelaDestino SET NOME = '$arrayAuxiliar[2]', "
                    . "PERMITERESERVA = '$arrayAuxiliar[3]', RECMODIFIEDON = '$arrayAuxiliar[4]' "
                 . "WHERE CODTIPOSALA = $arrayAuxiliar[1]";
          mssql_query($update);
        }
    }
    else{
       $insert = "INSERT $tabelaDestino (CODCOLIGADA,CODTIPOSALA,NOME,PERMITERESERVA,RECMODIFIEDON) "
                . "VALUES ($arrayAuxiliar[0],$arrayAuxiliar[1],'$arrayAuxiliar[2]','$arrayAuxiliar[3]', "
                . "'$arrayAuxiliar[4]')";
        mssql_query($insert);
    }
}
mssql_close($conexaoBancoDestino);






