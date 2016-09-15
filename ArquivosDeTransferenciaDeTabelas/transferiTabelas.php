<?php

include_once '../util/conexaoBancoOrigem.php';
$conexaoBancoOrigem = conexaoBancoOrigem();
$listaDeDados = array();
$i = 0;
$tabelaOrigem = 'OSUSR_U2W_ESCOLA1';
echo $selectOrigem = "SELECT * FROM $tabelaOrigem";
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

$selectDestino = "SELECT * FROM PHE_DESCRICAO_CALENDARIO_ESCOLA2";
$result = mssql_query($selectDestino);
$contador = 0;
while ($row = mssql_fetch_array($result)) {
    $contador += +1;
}
$contador;
if ($contador != 0) {
    for ($index = 0; $index < count($listaDeDados); $index++) {
        $arrayTeste = $listaDeDados[$index];
        $selectDestino = "SELECT * FROM PHE_DESCRICAO_CALENDARIO_ESCOLA2 WHERE ID = $arrayTeste[0]";
        $result = mssql_query($selectDestino);
        $cont = 0;
        $reccreatedon = "";
        while ($linha = mssql_fetch_array($result)) {
            $cont += +1;
            if ($cont != 0) {
                $reccreatedon = $linha['RECCREATEDON'];
            }
        }
        if ($reccreatedon != null && $reccreatedon != "" && $reccreatedon < $arrayTeste[5]) {
            $update = "UPDATE dbo.PHE_DESCRICAO_CALENDARIO_ESCOLA2 SET DESCRICAO = '$arrayTeste[1]', STATUS = '$arrayTeste[2]', RECCREATEDBY = '$arrayTeste[3]', RECCREATEDON = '$arrayTeste[4]', RECMODIFIEDBY = '$arrayTeste[5]',"
                    . " RECMODIFIEDON = '$arrayTeste[6]', TIPO = $arrayTeste[7] WHERE ID = $arrayTeste[0]";
        } elseif ($reccreatedon == null || $reccreatedon == "") {
            $insert = "INSERT dbo.PHE_DESCRICAO_CALENDARIO_ESCOLA2 (DESCRICAO,STATUS,RECCREATEDBY,RECCREATEDON,RECMODIFIEDBY,RECMODIFIEDON,TIPO,ID)"
                    . " VALUES ('$arrayTeste[1]','$arrayTeste[2]','$arrayTeste[3]','$arrayTeste[4]','$arrayDados[5]','$arrayTeste[6]','$arrayTeste[7]',$arrayTeste[0])";
            mssql_query($insert);
        }
    }
    mssql_close($conexaoBancoDestino);
} else {
    for ($index = 0; $index < count($listaDeDados); $index++) {
        //$arrayTeste = array();
        $arrayTeste = $listaDeDados[$index];

        $insert = "INSERT dbo.PHE_DESCRICAO_CALENDARIO_ESCOLA2 (DESCRICAO,STATUS,RECCREATEDBY,RECCREATEDON,RECMODIFIEDBY,RECMODIFIEDON,TIPO,ID)"
                . " VALUES ('$arrayTeste[1]','$arrayTeste[2]','$arrayTeste[3]','$arrayTeste[4]','$arrayDados[5]','$arrayTeste[6]','$arrayTeste[7]',$arrayTeste[0])";
        $resultado = mssql_query($insert);
        mssql_close($conexaoBancoDestino);
    }
}
    

