<?php

include_once '../util/conexaoBancoOrigem.php';
$conexaoBancoOrigem = conexaoBancoOrigem();
$listaDeDados = array();
$i = 0;
$tabelaOrigem = 'OSUSR_U2W_MODALIDADE1';
$selectOrigem = "SELECT * FROM $tabelaOrigem";
$resultado = mssql_query($selectOrigem);
while ($registro = mssql_fetch_array($resultado)) {
    $arrayDados = array();
    $arrayDados[] = $registro['ID'];
    $arrayDados[] = $registro['CODIGO'];
    $arrayDados[] = $registro['NOME'];
    $arrayDados[] = $registro['DESCRICAO'];
    $arrayDados[] = $registro['STATUS'];
    $arrayDados[] = $registro['CARGAHORARIA'];
    $arrayDados[] = $registro['USERID'];
    $arrayDados[] = $registro['ULTALT'];
    $arrayDados[] = $registro['ORDEM'];
    $listaDeDados[$i] = $arrayDados;
    $i++;
}
mssql_close($conexaoBancoOrigem);

include_once '../util/conexaoBancoDestino.php';
$conexaoBancoDestino = conectandoComBancoDestino();
$tabelaDestino = 'PLANESCOLAR.dbo.PHE_C_MODALIDADE';
$selectDestino = "SELECT * FROM $tabelaDestino";
$result = mssql_query($selectDestino);
$inseriuComSucesso = false;

$delete = "DELETE FROM $tabelaDestino";
mssql_query($delete);
for ($index = 0; $index < count($listaDeDados); $index++) {
    $arrayCopiaDeDados = $listaDeDados[$index];
    for ($i = 0; $i < count($arrayCopiaDeDados); $i++) {
       $arrayCopiaDeDados[$i];
       $insert = "INSERT $tabelaDestino (ID,CODIGO,NOME,DESCRICAO,STATUS,CARGAHORARIA,USERID,ULTALT,ORDEM) "
               ."VALUES ($arrayCopiaDeDados[0],'$arrayCopiaDeDados[1]','$arrayCopiaDeDados[2]','$arrayCopiaDeDados[3]',$arrayCopiaDeDados[4],"
               ."$arrayCopiaDeDados[5],$arrayCopiaDeDados[6],'$arrayCopiaDeDados[7]',$arrayCopiaDeDados[8])";
       $result = mssql_query($insert);
       if($result){
           $inseriuComSucesso = true;
       }
       break;  
    }
}
mssql_close($conexaoBancoDestino);
if ($inseriuComSucesso) {
    echo "<script>window.location='index.php';alert('DADOS TRANSFERIDOS COM SUCESSO');</script>";
}
elseif (!$inseriuComSucesso) {
    echo "<script>window.location='index.php';alert('ERRO AO TRANSFERIR DADOS');</script>"; 
}




