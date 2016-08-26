<?php

include_once './util/ConnectaBanco.php';
include_once './entidades/CalendarioEscolar.php';

class CalendarioEscolarDao {

    private $conexao;

    // CRIANDO O METODO DA CONEXAO
    public function tentaConexao() {
        try {
            $con = new ConnectaBanco();
            $this->conexao = $con->conectandoComBanco();
        } catch (Exception $e) {
            echo 'Exceção capturada: ', $e->getMessage(), "\n";
        }
    }

    public function geraCaledario(CalendarioEscolar $calendarioEscolar) {

        $this->tentaConexao();
        $arrayHoraIni = array();
        $arrayHoraFini = array();
        $arrayAula = array();
        $arrayCodigoTurno = array();
        $cont = 0;
        $arrayDados = array($calendarioEscolar->get_descricao(), $calendarioEscolar->get_dataDia(), $calendarioEscolar->get_codFilial(),
            $calendarioEscolar->get_status(), $calendarioEscolar->get_nomeDoDia(), $calendarioEscolar->get_diaDaSemana());


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
            (T.CODFILIAL = '$arrayDados[2]') AND
           (H.DIASEMANA = '$arrayDados[5]')";


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
                        . "VALUES ('$arrayDados[0]','$arrayDados[1]','$arrayHoraIni[$index]','$arrayHoraFini[$index]',$arrayCodigoTurno[$index],$arrayDados[2],0,'$arrayDados[3]','$arrayDados[4]')";
                $result = mssql_query($insert);
                if ($result) {
                    $cont++;
                }
            }
            return $cont;
        } else {
            return 0;
        }
    }

    public function fechaBanco() {
        mssql_close($this->conexao);
    }

}
