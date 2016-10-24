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
$tabelaOrigem = 'dbo.SCOMPLDISC';
$selectOrigem = "SELECT * FROM dbo.SCOMPLDISC WHERE (IDCOMPLDISC IS NOT NULL AND IDPERLET IS NOT NULL) AND CODCOLIGADA = 3";
$resultado = mssql_query($selectOrigem);
while ($registro = mssql_fetch_array($resultado)) {
    $arrayDados = array();
    $arrayDados[] = $registro['CODCOLIGADA'];
    $arrayDados[] = $registro['CODDISC'];
    $arrayDados[] = $registro['IDCOMPLDISC'];
    $arrayDados[] = $registro['DATA'];
    $arrayDados[] = $registro['TIPO'];
    $arrayDados[] = $registro['AULA'];
    $arrayDados[] = $registro['DESCRICAO'];
    $arrayDados[] = $registro['DISPONIVELALUNOS'];
    $arrayDados[] = $registro['IDPERLET'];
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
    $selectDestino = "SELECT * FROM PHE_SCOMPLDISC WHERE CODDISC = '$arrayAuxiliar[1]'";
    $result = mssql_query($selectDestino);
    $recmofifiedon = "";
    if (mssql_num_rows($result)) {
        while ($linha = mssql_fetch_array($result)) {
          $recmofifiedon = $linha['RECMODIFIEDON'];
        }
        if ($recmofifiedon != '' && $recmofifiedon != null && $arrayAuxiliar[9] > $recmofifiedon) {
        $update = "UPDATE PHE_SCOMPLDISC SET IDCOMPLDISC = $arrayAuxiliar[2], "
                    . "DATAH = '$arrayAuxiliar[3]', TIPO = '$arrayAuxiliar[4]', AULA = '$arrayAuxiliar[5]', "
                  . "DESCRICAO = '$arrayAuxiliar[6]', DISPONIVELALUNOS = '$arrayAuxiliar[7]', IDPERLET = $arrayAuxiliar[8], "
                  . "RECMODIFIEDON = '$arrayAuxiliar[9]', RECCREATEDON = '$arrayAuxiliar[10]' WHERE CODDISC = '$arrayAuxiliar[1]'";
          mssql_query($update);
        }
    }
   
    else{
        $insert = "INSERT PHE_SCOMPLDISC (CODCOLIGADA,CODDISC,IDCOMPLDISC,DATAH,TIPO,AULA,DESCRICAO,"
                . "DISPONIVELALUNOS,IDPERLET,RECMODIFIEDON,RECCREATEDON) "
                . "VALUES ($arrayAuxiliar[0],'$arrayAuxiliar[1]',$arrayAuxiliar[2],'$arrayAuxiliar[3]', "
                . "'$arrayAuxiliar[4]','$arrayAuxiliar[5]','$arrayAuxiliar[6]','$arrayAuxiliar[7]',$arrayAuxiliar[8],"
                . "'$arrayAuxiliar[9]','$arrayAuxiliar[10]')";
        mssql_query($insert);
    }
}
mssql_close($conexaoBancoDestino);









