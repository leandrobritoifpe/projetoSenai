<?php

include_once 'conectaBanco.php';
$conexao1 = conectandoComBanco();
$listaDeDados = array();
$i = 0;

$select = "SELECT * FROM PHE_DESCRICAO_CALENDARIO_ESCOLA";
$resultado = mssql_query($select);
while ($registro = mssql_fetch_array($resultado)) {
    $arrayDados = array();
    $arrayDados[] = $registro['ID'];
    $arrayDados[] = $registro['DESCRICAO'];
    $arrayDados[] = $registro['STATUS'];
    $arrayDados[] = $registro['RECCREATEDBY'];
    $arrayDados[] = $registro['RECCREATEDON'];
    $arrayDados[] = $registro['RECMODIFIEDBY'];
    $arrayDados[] = $registro['RECMODIFIEDON'];
    $arrayDados[] = $registro['TIPO'];

    $listaDeDados[$i] = $arrayDados;
    $i++;
}
mssql_close($conexao1);

include_once 'conexaoBancoDois.php';
$conexao2 = conectandoComBanco2();

$selec2 = "SELECT * FROM PHE_DESCRICAO_CALENDARIO_ESCOLA2";
$result = mssql_query($selec2);
$contador = 0;
while ($row = mssql_fetch_array($result)) {
    $contador += +1;
}
$contador;
if ($contador != 0) {
    for ($index = 0; $index < count($listaDeDados); $index++) {
        $arrayTeste = $listaDeDados[$index];
        $selec2 = "SELECT * FROM PHE_DESCRICAO_CALENDARIO_ESCOLA2 WHERE ID = $arrayTeste[0]";
        $result = mssql_query($selec2);
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
    mssql_close($conexao2);
} else {
    for ($index = 0; $index < count($listaDeDados); $index++) {
        //$arrayTeste = array();
        $arrayTeste = $listaDeDados[$index];

        $insert = "INSERT dbo.PHE_DESCRICAO_CALENDARIO_ESCOLA2 (DESCRICAO,STATUS,RECCREATEDBY,RECCREATEDON,RECMODIFIEDBY,RECMODIFIEDON,TIPO,ID)"
                . " VALUES ('$arrayTeste[1]','$arrayTeste[2]','$arrayTeste[3]','$arrayTeste[4]','$arrayDados[5]','$arrayTeste[6]','$arrayTeste[7]',$arrayTeste[0])";
        $resultado = mssql_query($insert);
        mssql_close($conexao2);
    }
}
    

