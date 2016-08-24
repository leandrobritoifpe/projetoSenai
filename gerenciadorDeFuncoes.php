<?php
function insereHorario($diaDaSemana,$data) {
    $arrayHoraIni = array();
    $arrayHoraFini = array();
    $arrayAula = array();
    $arrayCodigoTurno = array();
    $sql = "SELECT * FROM PHE_SHORARIO H WHERE H.DIASEMANA = $diaDaSemana
            ORDER BY H.DIASEMANA
            OFFSET 0 ROWS FETCH NEXT 20 ROWS ONLY";
    $result = mssql_query($sql);
    if ($result) {
        while ($linha = mssql_fetch_array($result)) {
            $arrayHoraIni[] = $linha['HORAINICIAL'];
            $arrayHoraFini[] = $linha['HORAFINAL'];
            $arrayAula[] = $linha['AULA'];
            $arrayCodigoTurno[] = $linha['CODTURNO'];
        }
        for ($index = 0; $index < count($arrayCodigoTurno); $index++) {
             $insert = "INSERT dbo.PHE_CALENDARIO_ESCOLA (DATA,HORINI,HORFIM,THORAAULA,CODTURNO,CODFILIAL,CODLETIVO,STATUS,DIASEMANA)"
            . "VALUES ('$data','$arrayHoraIni[$index]','$arrayHoraFini[$index]','01:00:00.0000000',$arrayCodigoTurno[$index],3,1,'A','SEGUNDA')";
            $result = mssql_query($insert);
        }
        echo "deu certo";
    }
}
