<?php

include_once './util/ConnectaBanco.php';

function insereHorario($diaDaSemana, $data, $nomeDiaSemana, $codFilial, $descricao) {
    // CRIO E DIGO QUE O ARRAY ESTAR VAZIO
    $arrayHoraIni = array();
    $arrayHoraFini = array();
    $arrayAula = array();
    $arrayCodigoTurno = array();

    // INSTRUÇÃO SQL
    $sql = "SELECT
            H.CODHOR,
            H.CODTURNO,
            H.DIASEMANA,
            H.HORAINICIAL,
            H.HORAFINAL,
            H.AULA,
            T.CODFILIAL,
            T.CODTURNO
            
        FROM
                dbo.PHE_SHORARIO H INNER JOIN dbo.PHE_STURNO T ON H.CODTURNO = T.CODTURNO
                WHERE 
            (T.CODFILIAL = '$codFilial') AND
           (H.DIASEMANA = '$diaDaSemana')";

    $result = mssql_query($sql);
    if ($result) {
        while ($linha = mssql_fetch_array($result)) {
            $arrayHoraIni[] = $linha['HORAINICIAL'];
            $arrayHoraFini[] = $linha['HORAFINAL'];
            $arrayAula[] = $linha['AULA'];
            $arrayCodigoTurno[] = $linha['CODTURNO'];
        }
        for ($index = 0; $index < count($arrayCodigoTurno); $index++) {
            $insert = "INSERT dbo.PHE_CALENDARIO_ESCOLA (DESCRICAO,DATADIA,HORINI,HORFIM,CODTURNO,CODFILIAL,CODLETIVO,STATUS,DIASEMANA)"
                    . "VALUES ('$descricao','$data','$arrayHoraIni[$index]','$arrayHoraFini[$index]',$arrayCodigoTurno[$index],$codFilial,0,'A','$nomeDiaSemana')";
            $result = mssql_query($insert);
        }
    }
}

function retornaDiaDaSemana($diaNumericoDaSemana) {
    $array = [
        "0" => "DOM",
        "1" => "SEG",
        "2" => "TER",
        "3" => "QUA",
        "4" => "QUI",
        "5" => "SEX",
        "6" => "SAB",
    ];
    return $array[$diaNumericoDaSemana];
}

function validaSeDataExiste($ano) {
    $con = new ConnectaBanco();
    $conexao = $con->conectandoComBanco();
    $select = "SELECT * FROM PHE_CALENDARIO_ESCOLA";
    $resultado = mssql_query($select);
    $anoDoBanco = "";
    if ($resultado) {
        while ($row = mssql_fetch_array($resultado)) {
            $anoDoBanco = $row['DATADIA'];
        }
        mssql_close($conexao);
        $anoDoBanco = substr($anoDoBanco, 0, -6);
        $ano = substr($ano, 0, -6);
        if ($ano == $anoDoBanco) {
            return true;
        } else {
            return false;
        }
    } else {
        return 0;
    }
}

function exibeMesagensParaUsuario($numeroMensagem) {
    $array = [
        "0" => "CALENDARIO ESCOLAR GERADO COM SUCESSO",
        "1" => "OCORREU UM ERRO AO GERAR O CALENDARIO",
        "2" => "DATA NAO LETIVA,REGISTRADA COM SUCESSO",
        "3" => "OCORREU UM ERRO AO TENTAR REGISTRO A DATA",
        "505" => "ERRO AO TENTAR SE COMUNICAR COM O BANCO",
        "5" => "SEX",
        "6" => "SAB",
    ];
    return $array[$numeroMensagem];
}

function converteStringParaMaiusculo($string) {
    return strtoupper($string);
}
