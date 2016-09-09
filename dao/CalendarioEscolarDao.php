<?php

/*
 * CLASSE CalendarioEscolarDao
 * OBJETIVO: REALIZAR TODA AS COMUNICAÇOES COM O BANCO DE DADOS SQL SERVER
 * CRIADA: 25/08/2016
 * ULTIMA ATUALIZACAO : 08/09/2016
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
                $insert = "INSERT dbo.PHE_CALENDARIO_ESCOLA (DESCRICAO,DATADIA,HORINI,HORFIM,CODTURNO,CODFILIAL,DLETIVO,STATUS,DIASEMANA,AULA,FNL,HDLETIVO,STATUS_CT,DLETIVO_CT,HDLETIVO_CT,DESCRICAO_CT,FNL_CT,RECCREATEDBY,DESCRICAO_SS,DLETIVO_SS,FNL_SS,HDLETIVO_SS,STATUS_SS,DESCRICAO_CTSS,DLETIVO_CTSS,FNL_CTSS,HDLETIVO_CTSS,STATUS_CTSS)"
                        . "VALUES ($arrayDados[0],'$arrayDados[1]','$arrayHoraIni[$index]','$arrayHoraFini[$index]',$arrayCodigoTurno[$index],$arrayDados[2],0,'$arrayDados[3]','$arrayDados[4]','$arrayAula[$index]',0,0,1,0,0,$arrayDados[0],0,'$arrayDados[6]',$arrayDados[0],0,0,0,1,$arrayDados[0],0,0,0,1)";
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
    //FUNÇÃO QUE CRIA DIAS LETIVOS
    public function geraDiaLetivo($codFilial) {
        //VERIFICANDO SE A FUNÇÃO QUE LIMPA OS DIAS LEVITOS FUNCIONOU
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
                
                //VERIFICANDO SE A FUNÇÃO QUE CRIAR ARRAY COM OS CODIGOS DOS TURNOS DEU CERTO
                $arrayCodigoTurno = $this->retornaArrayComTodosOsTurno($codFilial);
                
                if ($arrayCodigoTurno[0] != 505) {
                    for ($index = 0; $index < count($arrayCodigoTurno); $index++) {
                        $arrayContadorTurno[$index] = 0;
                    }
                    while ($linha = mssql_fetch_array($result)) {
                        $idCalendarioEscola = $linha['ID'];
                        $diaDaSemana = $linha['DIASEMANA'];
                        for ($i = 0; $i < count($arrayCodigoTurno); $i++) {
                            if ($arrayCodigoTurno[$i] == $linha['CODTURNO'] && $dataCalendario == "vazio" && $diaDaSemana != "SAB") {
                                $dataCalendario = $linha['DATADIA'];
                                $contadorDiaLetivo += 1;
                                $arrayContadorTurno[$i] += + 1;
                                $contaUpdate+= +1;
                                $update = "UPDATE dbo.PHE_CALENDARIO_ESCOLA SET DLETIVO = $contadorDiaLetivo, HDLETIVO = $arrayContadorTurno[$i] WHERE ID = $idCalendarioEscola AND CODFILIAL = $codFilial";
                                mssql_query($update);
                                break;
                            } elseif ($arrayCodigoTurno[$i] == $linha['CODTURNO'] && $dataCalendario == $linha['DATADIA'] && $diaDaSemana != "SAB") {
                                $arrayContadorTurno[$i] += +1;
                                $contaUpdate+= +1;
                                $update = "UPDATE dbo.PHE_CALENDARIO_ESCOLA SET DLETIVO = $contadorDiaLetivo, HDLETIVO = $arrayContadorTurno[$i] WHERE ID = $idCalendarioEscola AND CODFILIAL = $codFilial";
                                mssql_query($update);
                                break;
                            } elseif ($arrayCodigoTurno[$i] == $linha['CODTURNO'] && $dataCalendario != $linha["DATADIA"] && $dataCalendario != "vazio" && $diaDaSemana != "SAB") {
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
                            $realizacao = $this->geraDiaLetivoCursosAosSabados($codFilial);
                            if($realizacao == 10){
                                $realizacao = $this->geraDiaLetivoCursosAosSabadosCt($codFilial);
                                if($realizacao == 10){
                                    return 6;
                                }
                                else{
                                    return 505;
                                }
                            }
                            else{
                                return 505;
                            }
                        } else {
                            return 505;
                        }
                    } elseif ($contaUpdate == 0) {
                        return 505;
                    }
                } elseif ($arrayCodigoTurno[0] == 505) {
                    return 505;
                }
            } else {
                return 505;
            }
        } else {
            return 505;
        }
    }
    // FUNCAO QUE ATUALIZAR O CALENDARIO COM OS FERIADOS JÁ CADASTRADOS
    public function atualizaCalendarioComFeriados(CalendarioEscolar $calendarioEscolar) {
            $codFilial = $calendarioEscolar->get_codFilial();
            $select = "SELECT * FROM PHE_DIAS_NAO_LETIVOS WHERE STATUS = 1";
            $resultado = mssql_query($select);
            if ($resultado) {
                $select = "SELECT * FROM PHE_DIAS_NAO_LETIVOS WHERE STATUS = 1";
                $resultado = mssql_query($select);
                while ($linha = mssql_fetch_array($resultado)) {
                    $descricao = $linha['DESCRICAO'];
                    $data = substr($linha['DATA'], 5, 9);
                    $update = "UPDATE dbo.PHE_CALENDARIO_ESCOLA SET DESCRICAO = $descricao, DESCRICAO_CT = $descricao, DESCRICAO_SS = $descricao,DESCRICAO_CTSS = $descricao, FNL = 1, FNL_CT = 1, "
                            . "FNL_SS = 1, FNL_CTSS = 1, STATUS = 0, STATUS_CT = 0, STATUS_SS = 0, STATUS_CTSS = 0 WHERE DATADIA LIKE '%$data' AND CODFILIAL = $codFilial";
                    $resultado = mssql_query($update);
                }
               return 0;
            } else {
               return 505;
            }
    }
    //FUNCAO QUE VERIFICA SE O FERIDADO JÁ FOI CADASTRADO
    public function existeFeriado(){
        $select = "SELECT * FROM PHE_DIAS_NAO_LETIVOS WHERE STATUS = 1";
        $resultado = mssql_query($select);
        $contador = 0;
        if ($resultado) {
            while ($row = mssql_fetch_array($resultado)) {
                $contador += +1;
            }
            if ($contador == 1 || $contador > 1) {
               return true; 
            }
            elseif($contador == 0) {
                return false;
            }
        }
    }
    //FUNÇÃO QUE CRIA DIAS LETIVOS PARA CURSO TECNICOS
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
            
            //VERIFICANDO SE A FUNÇÃO QUE CRIAR ARRAY COM OS CODIGOS DOS TURNOS DEU CERTO
            $arrayCodigoTurno = $this->retornaArrayComTodosOsTurno($codFilial);
            
            if ($arrayCodigoTurno[0] != 505) {
                for ($index = 0; $index < count($arrayCodigoTurno); $index++) {
                    $arrayContadorTurno[$index] = 0;
                }
                while ($linha = mssql_fetch_array($result)) {
                    $idCalendarioEscola = $linha['ID'];
                    $diaDaSemana = $linha['DIASEMANA'];
                    for ($i = 0; $i < count($arrayCodigoTurno); $i++) {
                        if ($arrayCodigoTurno[$i] == $linha['CODTURNO'] && $dataCalendario == "vazio" && $diaDaSemana != "SAB") {
                            $dataCalendario = $linha['DATADIA'];
                            $contadorDiaLetivo += 1;
                            $arrayContadorTurno[$i] += + 1;
                            $update = "UPDATE dbo.PHE_CALENDARIO_ESCOLA SET DLETIVO_CT = $contadorDiaLetivo, HDLETIVO_CT = $arrayContadorTurno[$i] WHERE ID = $idCalendarioEscola AND CODFILIAL = $codFilial";
                            mssql_query($update);
                            break;
                        } elseif ($arrayCodigoTurno[$i] == $linha['CODTURNO'] && $dataCalendario == $linha['DATADIA'] && $diaDaSemana != "SAB") {
                            $arrayContadorTurno[$i] += +1;
                            $update = "UPDATE dbo.PHE_CALENDARIO_ESCOLA SET DLETIVO_CT = $contadorDiaLetivo, HDLETIVO_CT = $arrayContadorTurno[$i] WHERE ID = $idCalendarioEscola AND CODFILIAL = $codFilial";
                            mssql_query($update);
                            break;
                        } elseif ($arrayCodigoTurno[$i] == $linha['CODTURNO'] && $dataCalendario != $linha["DATADIA"] && $dataCalendario != "vazio" && $diaDaSemana != "SAB") {
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
    //FUNCAO QUE GERA OS DIAS LETIVOS DO CUSROS TECNICOS AOS SABADOS
    private function geraDiaLetivoCursosAosSabados($codFilial) {

        $contadorDiaLetivo = 0;
        $idCalendarioEscola = "";
        $contador = 0;
        $arrayContadorTurno = array();
        $arrayCodigoTurno = array();
        $select = "SELECT * FROM PHE_CALENDARIO_ESCOLA WHERE FNL_SS = 0 AND STATUS_SS = 1 AND CODFILIAL = $codFilial";
        $result = mssql_query($select);
        $dataCalendario = "vazio";
        while ($row = mssql_fetch_array($result)) {
            $contador+= +1;
        }
        if ($contador != 0) {
            $select = "SELECT * FROM PHE_CALENDARIO_ESCOLA WHERE FNL_SS = 0 AND STATUS_SS = 1 AND CODFILIAL = $codFilial";
            $result = mssql_query($select);
            
            //VERIFICANDO SE A FUNÇÃO QUE CRIAR ARRAY COM OS CODIGOS DOS TURNOS DEU CERTO
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
                            $update = "UPDATE dbo.PHE_CALENDARIO_ESCOLA SET DLETIVO_SS = $contadorDiaLetivo, HDLETIVO_SS = $arrayContadorTurno[$i] WHERE ID = $idCalendarioEscola AND CODFILIAL = $codFilial";
                            mssql_query($update);
                            break;
                        } elseif ($arrayCodigoTurno[$i] == $linha['CODTURNO'] && $dataCalendario == $linha['DATADIA']) {
                            $arrayContadorTurno[$i] += +1;
                            $update = "UPDATE dbo.PHE_CALENDARIO_ESCOLA SET DLETIVO_SS = $contadorDiaLetivo, HDLETIVO_SS = $arrayContadorTurno[$i] WHERE ID = $idCalendarioEscola AND CODFILIAL = $codFilial";
                            mssql_query($update);
                            break;
                        } elseif ($arrayCodigoTurno[$i] == $linha['CODTURNO'] && $dataCalendario != $linha["DATADIA"] && $dataCalendario != "vazio") {
                            $contadorDiaLetivo += 1;
                            $arrayContadorTurno[$i] += +1;
                            $dataCalendario = $linha['DATADIA'];
                            $update = "UPDATE dbo.PHE_CALENDARIO_ESCOLA SET DLETIVO_SS = $contadorDiaLetivo, HDLETIVO_SS = $arrayContadorTurno[$i] WHERE ID = $idCalendarioEscola AND CODFILIAL = $codFilial";
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
    //FUNCAO QUE GERA OS DIAS LETIVOS DOS CURSO TECNICOS AOS SABADOS
    private function geraDiaLetivoCursosAosSabadosCt($codFilial) {

        $contadorDiaLetivo = 0;
        $idCalendarioEscola = "";
        $contador = 0;
        $arrayContadorTurno = array();
        $arrayCodigoTurno = array();
        $select = "SELECT * FROM PHE_CALENDARIO_ESCOLA WHERE FNL_CTSS = 0 AND STATUS_CTSS = 1 AND CODFILIAL = $codFilial";
        $result = mssql_query($select);
        $dataCalendario = "vazio";
        while ($row = mssql_fetch_array($result)) {
            $contador+= +1;
        }
        if ($contador != 0) {
            $select = "SELECT * FROM PHE_CALENDARIO_ESCOLA WHERE FNL_CTSS = 0 AND STATUS_CTSS = 1 AND CODFILIAL = $codFilial";
            $result = mssql_query($select);
            
            //VERIFICANDO SE A FUNÇÃO QUE CRIAR ARRAY COM OS CODIGOS DOS TURNOS DEU CERTO
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
                            $update = "UPDATE dbo.PHE_CALENDARIO_ESCOLA SET DLETIVO_CTSS = $contadorDiaLetivo, HDLETIVO_CTSS = $arrayContadorTurno[$i] WHERE ID = $idCalendarioEscola AND CODFILIAL = $codFilial";
                            mssql_query($update);
                            break;
                        } elseif ($arrayCodigoTurno[$i] == $linha['CODTURNO'] && $dataCalendario == $linha['DATADIA']) {
                            $arrayContadorTurno[$i] += +1;
                            $update = "UPDATE dbo.PHE_CALENDARIO_ESCOLA SET DLETIVO_CTSS = $contadorDiaLetivo, HDLETIVO_CTSS = $arrayContadorTurno[$i] WHERE ID = $idCalendarioEscola AND CODFILIAL = $codFilial";
                            mssql_query($update);
                            break;
                        } elseif ($arrayCodigoTurno[$i] == $linha['CODTURNO'] && $dataCalendario != $linha["DATADIA"] && $dataCalendario != "vazio") {
                            $contadorDiaLetivo += 1;
                            $arrayContadorTurno[$i] += +1;
                            $dataCalendario = $linha['DATADIA'];
                            $update = "UPDATE dbo.PHE_CALENDARIO_ESCOLA SET DLETIVO_CTSS = $contadorDiaLetivo, HDLETIVO_CTSS = $arrayContadorTurno[$i] WHERE ID = $idCalendarioEscola AND CODFILIAL = $codFilial";
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
    //METODO QUE RETORNA UM ARRY COM TODOS OS CODIGO DOS TURNOS DA ESCOLA
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
    //METODO QUE ZERA TODOS OS DIAS LETIVOS JA REGISTRADOS
    private function zeraTodosDiasLetivos($codFilial) {
        $instrucao = "UPDATE dbo.PHE_CALENDARIO_ESCOLA SET DLETIVO = 0, DLETIVO_CT = 0, HDLETIVO = 0, HDLETIVO_CT = 0, DLETIVO_SS = 0, HDLETIVO_SS = 0, DLETIVO_CTSS = 0, HDLETIVO_CTSS = 0 WHERE CODFILIAL = $codFilial";
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
