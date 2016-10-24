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
$tabelaOrigem = 'dbo.SPREDIO';
$selectOrigem = "SELECT * FROM $tabelaOrigem WHERE ((CODFILIAL IS NOT NULL) AND (CODCOLIGADA IS NOT NULL)) "
        . "AND CODCOLIGADA = 3";
$resultado = mssql_query($selectOrigem);
while ($registro = mssql_fetch_array($resultado)) {
    $arrayDados = array();
    $arrayDados[] = $registro['CODCOLIGADA'];
    $arrayDados[] = $registro['CODFILIAL'];
    $arrayDados[] = $registro['CODPREDIO'];
    $arrayDados[] = $registro['NOME'];
    $arrayDados[] = $registro['TELEFONE'];
    $arrayDados[] = $registro['DDD'];
    $arrayDados[] = $registro['FAX'];
    $arrayDados[] = $registro['CONTATO'];
    $arrayDados[] = $registro['EMAIL'];
    $arrayDados[] = $registro['CODCAMPUS'];
    $arrayDados[] = $registro['RECMODIFIEDON'];
    $listaDeDados[$i] = $arrayDados;
    $i++;
}
mssql_close($conexaoBancoOrigem);

include_once '../util/conexaoBancoDestino.php';
$conexaoBancoDestino = conectandoComBancoDestino();
$tabelaDestino = 'PHE_SPREDIO';
for ($i = 0; $i < count($listaDeDados); $i++) {
    $arrayAuxiliar = $listaDeDados[$i];
    $selectDestino = "SELECT * FROM $tabelaDestino WHERE CODFILIAL = $arrayAuxiliar[1] AND CODPREDIO = '$arrayAuxiliar[2]' ";
    $result = mssql_query($selectDestino);
    $recmofifiedon = "";
    if (mssql_num_rows($result)) {
        while ($linha = mssql_fetch_array($result)) {
          $recmofifiedon = $linha['RECMODIFIEDON'];
        }
        if ($recmofifiedon != '' && $recmofifiedon != null && $arrayAuxiliar[10] > $recmofifiedon) {
         $update = "UPDATE $tabelaDestino SET NOME = '$arrayAuxiliar[3]', "
                    . "TELEFONE = '$arrayAuxiliar[4]', DDD = '$arrayAuxiliar[5]', FAX = '$arrayAuxiliar[6]', "
                    . "CONTATO = '$arrayAuxiliar[7]', EMAIL = '$arrayAuxiliar[8]', CODCAMPUS = '$arrayAuxiliar[9]', "
                  . "RECMODIFIEDON = '$arrayAuxiliar[10]' "
                 . "WHERE CODFILIAL = $arrayAuxiliar[1] AND CODPREDIO = '$arrayAuxiliar[2]'";
          mssql_query($update);
        }
    }
    else{
       $insert = "INSERT $tabelaDestino (CODCOLIGADA,CODFILIAL,CODPREDIO,NOME,TELEFONE,DDD,FAX,"
                . "CONTATO,EMAIL,CODCAMPUS,RECMODIFIEDON) "
                . "VALUES ($arrayAuxiliar[0],$arrayAuxiliar[1],'$arrayAuxiliar[2]','$arrayAuxiliar[3]', "
                . "'$arrayAuxiliar[4]','$arrayAuxiliar[5]','$arrayAuxiliar[6]','$arrayAuxiliar[7]',"
                . "'$arrayAuxiliar[8]','$arrayAuxiliar[9]','$arrayAuxiliar[10]')";
        mssql_query($insert);
    }
}
mssql_close($conexaoBancoDestino);








