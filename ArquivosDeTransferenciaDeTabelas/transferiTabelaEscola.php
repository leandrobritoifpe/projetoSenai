<?php
// 15/09/2016
include_once '../util/conexaoBancoOrigem.php';
$conexaoBancoOrigem = conexaoBancoOrigem();
$listaDeDados = array();
$i = 0;
$tabelaOrigem = 'OSUSR_U2W_ESCOLA1';
$selectOrigem = "SELECT * FROM $tabelaOrigem";
$resultado = mssql_query($selectOrigem);
while ($registro = mssql_fetch_array($resultado)) {
    $arrayDados = array();
    $arrayDados[] = $registro['ID'];
    $arrayDados[] = $registro['NOME'];
    $arrayDados[] = $registro['STATUS'];
    $arrayDados[] = $registro['CNPJ'];
    $listaDeDados[$i] = $arrayDados;
    $i++;
}
mssql_close($conexaoBancoOrigem);

include_once '../util/conexaoBancoDestino.php';
$conexaoBancoDestino = conectandoComBancoDestino();
$tabelaDestino = 'PLANESCOLAR.dbo.PHE_C_ESCOLA';
$selectDestino = "SELECT * FROM $tabelaDestino";
$result = mssql_query($selectDestino);
echo $inseriuComSucesso = false;

$delete = "DELETE FROM $tabelaDestino";
mssql_query($delete);
for ($index = 0; $index < count($listaDeDados); $index++) {
    //$arrayCopiaDeDados = array();
    $arrayCopiaDeDados = $listaDeDados[$index];
    for ($i = 0; $i < count($arrayCopiaDeDados); $i++) {
       $arrayCopiaDeDados[$i];
       $insert = "INSERT $tabelaDestino (ID,NOME,STATUS,CNPJ) VALUES ($arrayCopiaDeDados[0],'$arrayCopiaDeDados[1]',$arrayCopiaDeDados[2],'$arrayCopiaDeDados[3]')";
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
