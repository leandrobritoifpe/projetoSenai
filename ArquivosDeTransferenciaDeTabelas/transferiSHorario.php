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
$tabelaOrigem = 'dbo.SHORARIO';
$selectOrigem = "SELECT * FROM $tabelaOrigem WHERE (DIASEMANA IS NOT NULL) AND CODCOLIGADA = 3";
$resultado = mssql_query($selectOrigem);
while ($registro = mssql_fetch_array($resultado)) {
    $arrayDados = array();
    $arrayDados[] = $registro['CODHOR'];
    $arrayDados[] = $registro['CODCOLIGADA'];
    $arrayDados[] = $registro['CODTURNO'];
    $arrayDados[] = $registro['DIASEMANA'];
    $arrayDados[] = $registro['HORAINICIAL'];
    $arrayDados[] = $registro['HORAFINAL'];
    $arrayDados[] = $registro['AULA'];
     $arrayDados[] = $registro['RECMODIFIEDON'];
    $listaDeDados[$i] = $arrayDados;
    $i++;
}
mssql_close($conexaoBancoOrigem);

include_once '../util/conexaoBancoDestino.php';
$conexaoBancoDestino = conectandoComBancoDestino();
$tabelaDestino = 'PHE_SHORARIO';
for ($i = 0; $i < count($listaDeDados); $i++) {
    $arrayAuxiliar = $listaDeDados[$i];
    $selectDestino = "SELECT * FROM $tabelaDestino WHERE CODHOR = $arrayAuxiliar[0]";
    $result = mssql_query($selectDestino);
    $recmofifiedon = "";
    if (mssql_num_rows($result)) {
        while ($linha = mssql_fetch_array($result)) {
          $recmofifiedon = $linha['RECMODIFIEDON'];
        }
        if ($recmofifiedon != '' && $recmofifiedon != null && $arrayAuxiliar[7] > $recmofifiedon) {
         $update = "UPDATE $tabelaDestino SET CODTURNO = $arrayAuxiliar[2], "
                    . "DIASEMANA = $arrayAuxiliar[3], HORAINICIAL = '$arrayAuxiliar[4]', "
                  . "HORAFINAL = '$arrayAuxiliar[5]', AULA = '$arrayAuxiliar[6]', RECMODIFIEDON = '$arrayAuxiliar[7]'"
                 . "WHERE CODHOR = $arrayAuxiliar[0]";
          mssql_query($update);
        }
    }
    else{
       $insert = "INSERT $tabelaDestino (CODHOR,CODCOLIGADA,CODTURNO,DIASEMANA,HORAINICIAL,HORAFINAL,AULA,RECMODIFIEDON) "
                . "VALUES ($arrayAuxiliar[0],$arrayAuxiliar[1],$arrayAuxiliar[2],$arrayAuxiliar[3], "
                . "'$arrayAuxiliar[4]','$arrayAuxiliar[5]','$arrayAuxiliar[6]','$arrayAuxiliar[7]')";
        mssql_query($insert);
    }
}
mssql_close($conexaoBancoDestino);








