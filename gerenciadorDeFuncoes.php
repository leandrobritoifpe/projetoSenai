<?php

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
