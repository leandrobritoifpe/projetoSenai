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
$tabelaOrigem = 'dbo.SCURSO';
$selectOrigem = "SELECT * FROM $tabelaOrigem WHERE ((CODAREA IS NOT NULL) AND (CODTIPOCURSO IS NOT NULL) "
                . "AND (IDFT IS NOT NULL) AND (IDEIXOTECNOLOGICO IS NOT NULL) AND (CODTIPOCURSO IS NOT NULL)) "
                . "AND CODCOLIGADA = 3";
$resultado = mssql_query($selectOrigem);
while ($registro = mssql_fetch_array($resultado)) {
    $arrayDados = array();
    $arrayDados[] = $registro['CODCOLIGADA'];
    $arrayDados[] = $registro['CODCURSO'];
    $arrayDados[] = $registro['CODAREA'];
    $arrayDados[] = $registro['NOME'];
    $arrayDados[] = $registro['COMPLEMENTO'];
    $arrayDados[] = $registro['CODTIPOCURSO'];
    $arrayDados[] = $registro['CODMODALIDADECURSO'];
    $arrayDados[] = $registro['MASCARATURMA'];
    $arrayDados[] = $registro['IDFT'];
    $arrayDados[] = $registro['IDEIXOTECNOLOGICO'];
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
    $selectDestino = "SELECT * FROM PHE_SCURSO WHERE CODCURSO = '$arrayAuxiliar[1]'";
    $result = mssql_query($selectDestino);
    $recmofifiedon = "";
    if (mssql_num_rows($result)) {
        while ($linha = mssql_fetch_array($result)) {
          $recmofifiedon = $linha['RECMODIFIEDON'];
        }
        if ($recmofifiedon != '' && $recmofifiedon != null && $arrayAuxiliar[10] > $recmofifiedon) {
          $update = "UPDATE PHE_SCURSO SET CODAREA = $arrayAuxiliar[2], NOME = '$arrayAuxiliar[3]', "
                    . "COMPLEMENTO = '$arrayAuxiliar[4]', CODTIPOCURSO = $arrayAuxiliar[5], CODMODALIDADECURSO = '$arrayAuxiliar[6]', "
                    . "MASCARATURMA = '$arrayAuxiliar[7]', IDFT = $arrayAuxiliar[8], IDEIXOTECNOLOGICO = $arrayAuxiliar[9], "
                  . "RECMODIFIEDON = '$arrayAuxiliar[10]', RECCREATEDON = '$arrayAuxiliar[11]' WHERE CODCURSO = '$arrayAuxiliar[1]'";
          mssql_query($update);
        }
    }
    else{
        $insert = "INSERT PHE_SCURSO  (CODCOLIGADA,CODCURSO,CODAREA,NOME,COMPLEMENTO,CODTIPOCURSO,CODMODALIDADECURSO,"
                . "MASCARATURMA,IDFT,IDEIXOTECNOLOGICO,RECMODIFIEDON,RECCREATEDON) "
                . "VALUES ($arrayAuxiliar[0],'$arrayAuxiliar[1]',$arrayAuxiliar[2],'$arrayAuxiliar[3]', "
                . "'$arrayAuxiliar[4]',$arrayAuxiliar[5],'$arrayAuxiliar[6]','$arrayAuxiliar[7]',$arrayAuxiliar[8], "
                . "$arrayAuxiliar[9],'$arrayAuxiliar[10]','$arrayAuxiliar[11]')";
        mssql_query($insert);
    }
}
mssql_close($conexaoBancoDestino);






