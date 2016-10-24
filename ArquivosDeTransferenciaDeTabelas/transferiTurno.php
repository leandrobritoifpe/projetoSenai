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
$tabelaOrigem = 'dbo.STURNO';
$selectOrigem = "SELECT * FROM $tabelaOrigem WHERE IDFT IS NOT NULL AND CODCOLIGADA = 3";
$resultado = mssql_query($selectOrigem);
while ($registro = mssql_fetch_array($resultado)) {
    $arrayDados = array();
    $arrayDados[] = $registro['CODTURNO'];
    $arrayDados[] = $registro['CODCOLIGADA'];
    $arrayDados[] = $registro['CODFILIAL'];
    $arrayDados[] = $registro['NOME'];
    $arrayDados[] = $registro['HORINI'];
    $arrayDados[] = $registro['HORFIM'];
    $arrayDados[] = $registro['TIPO'];
    $arrayDados[] = $registro['CODTIPOCURSO'];
    $arrayDados[] = $registro['RECMODIFIEDON'];
    $listaDeDados[$i] = $arrayDados;
    $i++;
}
mssql_close($conexaoBancoOrigem);

include_once '../util/conexaoBancoDestino.php';
$conexaoBancoDestino = conectandoComBancoDestino();
$tabelaDestino = 'PHE_STURNO';
for ($i = 0; $i < count($listaDeDados); $i++) {
    $arrayAuxiliar = $listaDeDados[$i];
    $selectDestino = "SELECT * FROM $tabelaDestino WHERE CODTURNO = $arrayAuxiliar[0] AND CODFILIAL = $arrayAuxiliar[2]";
    $result = mssql_query($selectDestino);
    $recmofifiedon = "";
    if (mssql_num_rows($result)) {
        while ($linha = mssql_fetch_array($result)) {
          $recmofifiedon = $linha['RECMODIFIEDON'];
        }
        if ($recmofifiedon != '' && $recmofifiedon != null && $arrayAuxiliar[8] > $recmofifiedon) {
         $update = "UPDATE $tabelaDestino SET NOME = '$arrayAuxiliar[3]', "
                    . "HORINI = '$arrayAuxiliar[4]', HORFIM = '$arrayAuxiliar[5]', TIPO = '$arrayAuxiliar[6]', "
                    . "CODTIPOCURSO = $arrayAuxiliar[7], RECMODIFIEDON = '$arrayAuxiliar[8]' "
                  . "WHERE CODTURNO = $arrayAuxiliar[0] AND CODFILIAL = $arrayAuxiliar[2]";
          mssql_query($update);
        }
    }
    else{
        $insert = "INSERT $tabelaDestino (CODTURNO,CODCOLIGADA,CODFILIAL,NOME,HORINI,HORFIM,TIPO,"
                . "CODTIPOCURSO,RECMODIFIEDON) "
                . "VALUES ($arrayAuxiliar[0],$arrayAuxiliar[1],$arrayAuxiliar[2],'$arrayAuxiliar[3]', "
                . "'$arrayAuxiliar[4]','$arrayAuxiliar[5]','$arrayAuxiliar[6]',$arrayAuxiliar[7],"
                . "'$arrayAuxiliar[8]')";
        mssql_query($insert);
    }
}
mssql_close($conexaoBancoDestino);






