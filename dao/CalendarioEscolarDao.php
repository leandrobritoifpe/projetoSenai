<?php

/*
 * CLASSE CalendarioEscolarDao
 * OBJETIVO: REALIZAR TODA AS COMUNICAÇOES COM O BANCO DE DADOS SQL SERVER
 * CRIADA: 25/08/2016
 * ULTIMA ATUALIZACAO : 30/08/2016
 * 
 * DS-> LEANDRO BRITO
 */


// IMPORTANDO A CLASS QUE TEM A CONEXAO COM BANCO DE DADOS
include_once './util/ConnectaBanco.php';
//IMPORTANDO A CLASSE DA ENTIDADE
include_once './entidades/CalendarioEscolar.php';

class CalendarioEscolarDao {

    private $conexao;

    // CRIANDO O METODO DA CONEXAO
    public function abrirConexao() {
        try {
            $con = new ConnectaBanco();
            $this->conexao = $con->conectandoComBanco();
        } catch (Exception $e) {
            echo 'Exceção capturada: ', $e->getMessage(), "\n";
        }
    }

    // FUNCAO QUE GERA CALENDARIO
    public function geraCaledario(CalendarioEscolar $calendarioEscolar) {

        $arrayHoraIni = array();
        $arrayHoraFini = array();
        $arrayAula = array();
        $arrayCodigoTurno = array();
        $cont = 0;

        //ARRAY DE OBJETOS CALENDARIOESCOLAR
        $arrayDados = array($calendarioEscolar->get_descricao(), $calendarioEscolar->get_dataDia(), $calendarioEscolar->get_codFilial(),
            $calendarioEscolar->get_status(), $calendarioEscolar->get_nomeDoDia(), $calendarioEscolar->get_diaDaSemana(),$calendarioEscolar->get_usuarioCadastrante());

        //SELECT PARA TRAZER DADOS
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

        // EXECUTANDO O SELECT
        $result = mssql_query($sql);
        if ($result) {
            while ($linha = mssql_fetch_array($result)) {
                $arrayHoraIni[] = $linha['HORAINICIAL'];
                $arrayHoraFini[] = $linha['HORAFINAL'];
                $arrayAula[] = $linha['AULA'];
                $arrayCodigoTurno[] = $linha['CODTURNO'];
            }
            for ($index = 0; $index < count($arrayCodigoTurno); $index++) {

                //INSERT NO BANCO DE DADOS SQL
                $insert = "INSERT dbo.PHE_CALENDARIO_ESCOLA (DESCRICAO,DATADIA,HORINI,HORFIM,CODTURNO,CODFILIAL,DLETIVO,STATUS,DIASEMANA,AULA,FNL,HDLETIVO,STATUS_CT,DLETIVO_CT,HDLETIVO_CT,DESCRICAO_CT,FNL_CT,RECCREATEDBY)"
                        . "VALUES ($arrayDados[0],'$arrayDados[1]','$arrayHoraIni[$index]','$arrayHoraFini[$index]',$arrayCodigoTurno[$index],$arrayDados[2],0,'$arrayDados[3]','$arrayDados[4]','$arrayAula[$index]',0,0,1,0,0,$arrayDados[0],0,'$arrayDados[6]')";
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

    public function geraDiaLetivo($codFilial) {

        if ($this->zeraTodosDiasLetivos($codFilial) == true) {
            $contadorDiaLetivo = 0;
            $idCalendarioEscola = "";
            $contador = 0;
            $contaUpdate = 0;
            $arrayContadorTurno = array();
            $arrayCodigoTurno = array();
            $select = "SELECT * FROM PHE_CALENDARIO_ESCOLA WHERE FNL = 0 AND STATUS = 1 AND CODFILIAL = $codFilial";
            $result = mssql_query($select);
            $dataCalendario = "vazio";
            while ($row = mssql_fetch_array($result)) {
                $contador+= +1;
            }
            if ($contador != 0) {
                $select = "SELECT * FROM PHE_CALENDARIO_ESCOLA WHERE FNL = 0 AND STATUS = 1 AND CODFILIAL = $codFilial";
                $result = mssql_query($select);
                $arrayCodigoTurno = $this->retornaArrayComTodosOsTurno($codFilial);
                if ($arrayCodigoTurno[0] != 505) {
                    for ($index = 0; $index < count($arrayCodigoTurno); $index++) {
                        $arrayContadorTurno[$index] = 0;
                    }
                    while ($linha = mssql_fetch_array($result)) {
                        $idCalendarioEscola = $linha['ID'];
                        for ($i = 0; $i < count($arrayCodigoTurno); $i++) {
                            if ($arrayCodigoTurno[$i] == $linha['CODTURNO'] && $dataCalendario == "vazio") {
                                $dataCalendario = $linha['DATADIA'];
                                $contadorDiaLetivo += 1;
                                $arrayContadorTurno[$i] += + 1;
                                $contaUpdate+= +1;
                                $update = "UPDATE dbo.PHE_CALENDARIO_ESCOLA SET DLETIVO = $contadorDiaLetivo, HDLETIVO = $arrayContadorTurno[$i] WHERE ID = $idCalendarioEscola AND CODFILIAL = $codFilial";
                                mssql_query($update);
                                break;
                            } elseif ($arrayCodigoTurno[$i] == $linha['CODTURNO'] && $dataCalendario == $linha['DATADIA']) {
                                $arrayContadorTurno[$i] += +1;
                                $contaUpdate+= +1;
                                $update = "UPDATE dbo.PHE_CALENDARIO_ESCOLA SET DLETIVO = $contadorDiaLetivo, HDLETIVO = $arrayContadorTurno[$i] WHERE ID = $idCalendarioEscola AND CODFILIAL = $codFilial";
                                mssql_query($update);
                                break;
                            } elseif ($arrayCodigoTurno[$i] == $linha['CODTURNO'] && $dataCalendario != $linha["DATADIA"] && $dataCalendario != "vazio") {
                                $contadorDiaLetivo += 1;
                                $arrayContadorTurno[$i] += +1;
                                $contaUpdate+= +1;
                                $dataCalendario = $linha['DATADIA'];
                                $update = "UPDATE dbo.PHE_CALENDARIO_ESCOLA SET DLETIVO = $contadorDiaLetivo, HDLETIVO = $arrayContadorTurno[$i] WHERE ID = $idCalendarioEscola AND CODFILIAL = $codFilial";
                                mssql_query($update);
                                break;
                            }
                        }
                    }
                    if ($contaUpdate != 0) {
                        $realizacao = $this->geraDiaLetivoCursoTecnico($codFilial);
                        if ($realizacao == 10) {
                            return 6;
                        } else {
                            return 505;
                        }
                    } elseif ($contaUpdate == 0) {
                        return 505;
                    }
                } elseif ($arrayCodigoTurno[0] == 505) {
                    return 9;
                }
            } else {
                return 505;
            }
        } else {
            return 505;
        }
    }

    private function geraDiaLetivoCursoTecnico($codFilial) {

        $contadorDiaLetivo = 0;
        $idCalendarioEscola = "";
        $contador = 0;
        $arrayContadorTurno = array();
        $arrayCodigoTurno = array();
        $select = "SELECT * FROM PHE_CALENDARIO_ESCOLA WHERE FNL_CT = 0 AND STATUS_CT = 1 AND CODFILIAL = $codFilial";
        $result = mssql_query($select);
        $dataCalendario = "vazio";
        while ($row = mssql_fetch_array($result)) {
            $contador+= +1;
        }
        if ($contador != 0) {
            $select = "SELECT * FROM PHE_CALENDARIO_ESCOLA WHERE FNL_CT = 0 AND STATUS_CT = 1 AND CODFILIAL = $codFilial";
            $result = mssql_query($select);
            $arrayCodigoTurno = $this->retornaArrayComTodosOsTurno($codFilial);
            if ($arrayCodigoTurno[0] != 505) {
                for ($index = 0; $index < count($arrayCodigoTurno); $index++) {
                    $arrayContadorTurno[$index] = 0;
                }
                while ($linha = mssql_fetch_array($result)) {
                    $idCalendarioEscola = $linha['ID'];
                    for ($i = 0; $i < count($arrayCodigoTurno); $i++) {
                        if ($arrayCodigoTurno[$i] == $linha['CODTURNO'] && $dataCalendario == "vazio") {
                            $dataCalendario = $linha['DATADIA'];
                            $contadorDiaLetivo += 1;
                            $arrayContadorTurno[$i] += + 1;
                            $update = "UPDATE dbo.PHE_CALENDARIO_ESCOLA SET DLETIVO_CT = $contadorDiaLetivo, HDLETIVO_CT = $arrayContadorTurno[$i] WHERE ID = $idCalendarioEscola AND CODFILIAL = $codFilial";
                            mssql_query($update);
                            break;
                        } elseif ($arrayCodigoTurno[$i] == $linha['CODTURNO'] && $dataCalendario == $linha['DATADIA']) {
                            $arrayContadorTurno[$i] += +1;
                            $update = "UPDATE dbo.PHE_CALENDARIO_ESCOLA SET DLETIVO_CT = $contadorDiaLetivo, HDLETIVO_CT = $arrayContadorTurno[$i] WHERE ID = $idCalendarioEscola AND CODFILIAL = $codFilial";
                            mssql_query($update);
                            break;
                        } elseif ($arrayCodigoTurno[$i] == $linha['CODTURNO'] && $dataCalendario != $linha["DATADIA"] && $dataCalendario != "vazio") {
                            $contadorDiaLetivo += 1;
                            $arrayContadorTurno[$i] += +1;
                            $dataCalendario = $linha['DATADIA'];
                            $update = "UPDATE dbo.PHE_CALENDARIO_ESCOLA SET DLETIVO_CT = $contadorDiaLetivo, HDLETIVO_CT = $arrayContadorTurno[$i] WHERE ID = $idCalendarioEscola AND CODFILIAL = $codFilial";
                            mssql_query($update);
                            break;
                        }
                    }
                }
                return 10;
            } elseif ($arrayCodigoTurno[0] == 505) {
                return 9;
            }
        } else {
            return 505;
        }
    }

    private function retornaArrayComTodosOsTurno($codFilial) {
        $sql = "SELECT CODTURNO FROM PHE_STURNO WHERE CODFILIAL = $codFilial";
        $result = mssql_query($sql);
        $contador = 0;
        $arrayCodigoTuno = array();
        if ($result) {
            while ($row = mssql_fetch_array($result)) {
                $contador += +1;
            }
            if ($contador != 0) {
                $sql = "SELECT CODTURNO FROM PHE_STURNO WHERE CODFILIAL = $codFilial";
                $result = mssql_query($sql);
                while ($linha = mssql_fetch_array($result)) {
                    $arrayCodigoTuno[] = $linha['CODTURNO'];
                }
                return $arrayCodigoTuno;
            }
        } else {
            return $arrayCodigoTuno[0] = 505;
        }
    }

    private function zeraTodosDiasLetivos($codFilial) {
        $instrucao = "UPDATE dbo.PHE_CALENDARIO_ESCOLA SET DLETIVO = 0, DLETIVO_CT = 0, HDLETIVO = 0, HDLETIVO_CT = 0 WHERE CODFILIAL = $codFilial";
        $resultado = mssql_query($instrucao);
        if ($resultado) {
            return true;
        } else {
            return false;
        }
    }

    //FUNCAO QUE FECHA BANCO
    public function fechaBanco() {
        mssql_close($this->conexao);
    }

}
