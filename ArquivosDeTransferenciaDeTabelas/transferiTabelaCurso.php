<?php
// 15/09/2016
include_once '../util/conexaoBancoOrigem.php';
$conexaoBancoOrigem = conexaoBancoOrigem();
$listaDeDados = array();
$i = 0;
$tabelaOrigem = 'OSUSR_U2W_CURSO1';
echo $selectOrigem = "SELECT CAST(OBJETIVO AS TEXT) AS OBJETIVO FROM OSUSR_U2W_CURSO1;";
$resultado = mssql_query($selectOrigem);
while ($registro = mssql_fetch_array($resultado)) {
    $arrayDados = array();
    $arrayDados[] = $registro['ID'];
    $arrayDados[] = $registro['CODIGO'];
    $arrayDados[] = $registro['TITULO'];
    $arrayDados[] = $registro['ORDEM'];
    $arrayDados[] = $registro['MODALIDADE'];
    $arrayDados[] = $registro['EIXOTECNOLOGICOID'];
    $arrayDados[] = $registro['AREAID'];
    $arrayDados[] = $registro['CBO'];
    $arrayDados[] = $registro['OBJETIVO'];
    $arrayDados[] = $registro['POSSIBILIDADEATUACAO'];
    $arrayDados[] = $registro['CONFORMIDADE'];
    $arrayDados[] = $registro['OBSERVACOES'];
    $arrayDados[] = $registro['CARGAHORARIA'];
    $arrayDados[] = $registro['TITULOBLOCOID_1'];
    $arrayDados[] = $registro['TITULOBLOCOID_2'];
    $arrayDados[] = $registro['TITULOBLOCOID_3'];
    $arrayDados[] = $registro['TITULOBLOCOID_4'];
    $arrayDados[] = $registro['TITULOBLOCOID_5'];
    $arrayDados[] = $registro['VALID'];
    $arrayDados[] = $registro['ULTALT'];
    $arrayDados[] = $registro['STATUS'];
    $arrayDados[] = $registro['DATAINICIO'];
    $arrayDados[] = $registro['DATAFIM'];
    $arrayDados[] = $registro['ESTRATEGIADEV'];
    $arrayDados[] = $registro['CLASSECURSO'];
    $arrayDados[] = $registro['QTDALUNOSTURMA'];
    $arrayDados[] = $registro['CODSGE'];
    $listaDeDados[$i] = $arrayDados;
    $i++;
}
mssql_close($conexaoBancoOrigem);

include_once '../util/conexaoBancoDestino.php';
$conexaoBancoDestino = conectandoComBancoDestino();
$tabelaDestino = 'PLANESCOLAR.dbo.PHE_C_CURSO';
$selectDestino = "SELECT * FROM $tabelaDestino";
$result = mssql_query($selectDestino);
$inseriuComSucesso = false;

$delete = "DELETE FROM $tabelaDestino";
mssql_query($delete);
for ($index = 0; $index < count($listaDeDados); $index++) {
    //$arrayCopiaDeDados = array();
    $arrayCopiaDeDados = $listaDeDados[$index];
    for ($i = 0; $i < count($arrayCopiaDeDados); $i++) {
       $arrayCopiaDeDados[$i];
       ECHO $insert = "INSERT $tabelaDestino (ID,CODIGO,TITULO,ORDEM,MODALIDADEID,EIXOTECNOLOGICOID,AREAID,CBO,"
               ."OBJETIVO,POSSIBILIDADEATUACAO,CONFORMIDADE,OBSERVACOES,CARGAHORARIA,TITULOBLOCOID_1,TITULOBLOCOID_2,"
               ."TITULOBLOCOID_3,TITULOBLOCOID_4,TITULOBLOCOID_5,VALID,ULTALT,STATUS,DATAINICIO,DATAFIM,ESTRATEGIADEV,"
               ."CLASSECURSO,QTDALUNOSTURMA,CODSGE) "
               ."VALUES ($arrayCopiaDeDados[0],'$arrayCopiaDeDados[1]','$arrayCopiaDeDados[2]','$arrayCopiaDeDados[3]',$arrayCopiaDeDados[4],"
               ."$arrayCopiaDeDados[5],$arrayCopiaDeDados[6],'$arrayCopiaDeDados[7]','$arrayCopiaDeDados[8]','$arrayCopiaDeDados[9]',"
               ."'$arrayCopiaDeDados[10]','$arrayCopiaDeDados[11]',$arrayCopiaDeDados[12],$arrayCopiaDeDados[13],$arrayCopiaDeDados[14],"
               ."$arrayCopiaDeDados[15],$arrayCopiaDeDados[16],$arrayCopiaDeDados[17],'$arrayCopiaDeDados[18]',$arrayCopiaDeDados[19],"
               ."'$arrayCopiaDeDados[20],'$arrayCopiaDeDados[21]',$arrayCopiaDeDados[22],$arrayCopiaDeDados[23],$arrayCopiaDeDados[24],"
               ."$arrayCopiaDeDados[25],'$arrayCopiaDeDados[26]')";
       $result = mssql_query($insert);
       if($result){
           $inseriuComSucesso = true;
       }
       break;  
    }
}
mssql_close($conexaoBancoDestino);
if ($inseriuComSucesso) {
    //echo "<script>window.location='index.php';alert('DADOS TRANSFERIDOS COM SUCESSO');</script>";
    ECHO "1";
}
elseif (!$inseriuComSucesso) {
    //echo "<script>window.location='index.php';alert('ERRO AO TRANSFERIR DADOS');</script>";
    ECHO "0";
}






