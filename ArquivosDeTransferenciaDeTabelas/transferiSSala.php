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
$tabelaOrigem = 'dbo.SSALA';
$selectOrigem = "SELECT * FROM $tabelaOrigem WHERE ((CODTIPOSALA IS NOT NULL) AND (CAPACIDADE IS NOT NULL) "
        . "AND (CAPACIDADEMAXIMA IS NOT NULL) AND (CAPACIDADEPROVA IS NOT NULL)) "
        . "AND CODCOLIGADA = 3";
$resultado = mssql_query($selectOrigem);
while ($registro = mssql_fetch_array($resultado)) {
    $arrayDados = array();
    $arrayDados[] = $registro['CODCOLIGADA'];
    $arrayDados[] = $registro['CODFILIAL'];
    $arrayDados[] = $registro['CODPREDIO'];
    $arrayDados[] = $registro['CODSALA'];
    $arrayDados[] = $registro['CODTIPOSALA'];
    $arrayDados[] = $registro['DESCRICAO'];
    $arrayDados[] = $registro['CAPACIDADE'];
    $arrayDados[] = $registro['CAPACIDADEMAXIMA'];
    $arrayDados[] = $registro['CAPACIDADEPROVA'];
    $arrayDados[] = $registro['ANDAR'];
    $arrayDados[] = $registro['CODBLOCO'];
    $arrayDados[] = $registro['DISPONIVEL'];
    $arrayDados[] = $registro['RECMODIFIEDON'];
    $listaDeDados[$i] = $arrayDados;
    $i++;
}
mssql_close($conexaoBancoOrigem);

include_once '../util/conexaoBancoDestino.php';
$conexaoBancoDestino = conectandoComBancoDestino();
$tabelaDestino = 'PHE_SSALA';
for ($i = 0; $i < count($listaDeDados); $i++) {
    $arrayAuxiliar = $listaDeDados[$i];
    $selectDestino = "SELECT * FROM $tabelaDestino WHERE CODFILIAL = $arrayAuxiliar[1] AND CODPREDIO = '$arrayAuxiliar[2]' "
            . "AND CODSALA = '$arrayAuxiliar[3]'";
    $result = mssql_query($selectDestino);
    $recmofifiedon = "";
    if (mssql_num_rows($result)) {
        while ($linha = mssql_fetch_array($result)) {
          $recmofifiedon = $linha['RECMODIFIEDON'];
        }
        if ($recmofifiedon != '' && $recmofifiedon != null && $arrayAuxiliar[12] > $recmofifiedon) {
         $update = "UPDATE $tabelaDestino SET CODTIPOSALA = $arrayAuxiliar[4], "
                    . "DESCRICAO = '$arrayAuxiliar[5]', CAPACIDADE = $arrayAuxiliar[6], CAPACIDADEMAXIMA = $arrayAuxiliar[7], "
                    . "CAPACIDADEPROVA = $arrayAuxiliar[8], ANDAR = '$arrayAuxiliar[9]', CODBLOCO = '$arrayAuxiliar[10]', "
                  . "DISPONIVEL = '$arrayAuxiliar[11]', RECMODIFIEDON = '$arrayAuxiliar[12]' "
                 . "WHERE CODFILIAL = $arrayAuxiliar[1] AND CODPREDIO = '$arrayAuxiliar[2]' AND CODSALA = '$arrayAuxiliar[3]'";
          mssql_query($update);
        }
    }
    else{
       $insert = "INSERT $tabelaDestino (CODCOLIGADA,CODFILIAL,CODPREDIO,CODSALA,CODTIPOSALA,DESCRICAO,CAPACIDADE,"
                . "CAPACIDADEMAXIMA,CAPACIDADEPROVA,ANDAR,CODBLOCO,DISPONIVEL,RECMODIFIEDON) "
                . "VALUES ($arrayAuxiliar[0],$arrayAuxiliar[1],'$arrayAuxiliar[2]','$arrayAuxiliar[3]', "
                . "$arrayAuxiliar[4],'$arrayAuxiliar[5]',$arrayAuxiliar[6],$arrayAuxiliar[7],"
                . "$arrayAuxiliar[8],'$arrayAuxiliar[9]','$arrayAuxiliar[10]','$arrayAuxiliar[11]','$arrayAuxiliar[12]')";
        mssql_query($insert);
    }
}
mssql_close($conexaoBancoDestino);






