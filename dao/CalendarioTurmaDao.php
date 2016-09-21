<?php
/*
 * CLASSE CalendarioTurmaDao.php
 * OBJETIVO: SERVIR DE COMUNICAÇÃO COM O BANCO
 * CRIADA: 20/09/2016
 * ULTIMA ATUALIZACAO : 20/09/2016
 * 
 * DS-> LEANDRO BRITO
 */

include_once './entidades/CalendarioTurma.php';
include_once './entidades/Disciplina.php';
include_once './entidades/CalendarioEscolar.php';
class CalendarioTurmaDao {
    private $conexao;

    // CRIANDO O METODO DA CONEXAO
    public function abreBanco() {
        try {
            $con = new ConnectaBanco();
            $this->conexao = $con->conectandoComBanco();
        } catch (Exception $e) {
            echo 'Exceção capturada: ', $e->getMessage(), "\n";
        }
    }
    public function geraCalendarioTurma(CalendarioTurma $calendario) {
       try {
            $listaDisciplinas = $this->retornaObjetoTurma($calendario);
            $dadosCalendarioTurma = array($calendario->get_codFilial(),$calendario->get_codCurso(), 
                                          $calendario->get_codTurma(), $calendario->get_userCadastrante());
            $contaAula = 1;
            $contaTurma = 1;
            $periodo = "vazio";

            for ($index = 0; $index < count($listaDisciplinas); $index++) {
                $disciplina = $listaDisciplinas[$index];
                $dadosDisciplina = array("1" => $disciplina->get_codDisciplina(), 
                                         "2" => $disciplina->get_descricaoDisciplina(),
                                         "3" => $disciplina->get_horaDisciplina(),
                                         "4" => $disciplina->get_periodo(),
                                         "5" => $disciplina->get_ordemDeEnsino(),
                                         "6" => $disciplina->get_subCodigo(),
                                         "7" => $disciplina->get_subDiscOrdem(),
                                         "8" => $disciplina->get_subHora());
                if ($periodo != "vazio" && $periodo != $dadosDisciplina[4]) {
                    $contaTurma++;
                }
                $numero = (int) $dadosDisciplina[8];
                for ($i = 0; $i < $numero; $i++) {
                   $aula = $contaAula;
                   $subTurma = $dadosCalendarioTurma[2] ."_".$contaTurma;
                   $insert = "INSERT INTO PHE_CALENDARIO_TURMA ("
                            . "CODFILIAL,"
                            . "STATUS,"
                            . "CODIGO_CURSO,"
                            . "CODIGO_TURMA,"
                            . "PERIODO_CURSO,"
                            . "CODIGO_DISCIPLINA,"
                            . "DESCRICAO_DISCIPLINA,"
                            . "ORDEM_DISCIPLINA,"
                            . "CARGAHORA_DISCIPLINA,"
                            . "AULA,"
                            . "RECCREATEDBY,"
                            . "SUBCODIGOTURMA,"
                            . "CODIGO_SUBDISCIPLINA,"
                            . "SUBDISC_ORDEM,"
                            . "SUBDISC_CH,"
                            . "CODCOLIGADA) "
                            . "VALUES ($dadosCalendarioTurma[0],1,'$dadosCalendarioTurma[1]','$dadosCalendarioTurma[2]',$dadosDisciplina[4],"
                            . "'$dadosDisciplina[1]','$dadosDisciplina[2]',$dadosDisciplina[5],$dadosDisciplina[3],'$aula','$dadosCalendarioTurma[3]','$subTurma',"
                            . "'$dadosDisciplina[6]',$dadosDisciplina[7],$dadosDisciplina[8],3)";
                    mssql_query($insert);
                    $contaAula++;
                }
                $periodo = $dadosDisciplina[4];
            }
            return true;
        } catch (Exception $ex) {
            echo 'Exceção capturada: ', $ex->getMessage(), "\n";
        }
    }
    public function transfereTabelaCursoDisciplina(CalendarioTurma $calendarioTurma,$quantidade) {
        try {
            $obj = $this->retornaTabelaCursoDisciplina($calendarioTurma);
            $funcionou = false;
            $arrayDados = array(
                                "1" => $calendarioTurma->get_codFilial(),
                                "2" => $calendarioTurma->get_codCurso(),
                                "3" => $obj->get_codHab(),
                                "4" => $obj->get_codGrade(),
                                "5" => $obj->get_codPeriodo(),
                                "6" => $calendarioTurma->get_codDisciplina(),
                                "7" => $obj->get_ordemDeEnsino(),
                                "8" => $obj->get_descricaoDisciplina(),
                                "10" => $obj->get_objetivoSgrade(),
                                "11" => $obj->get_recmodifiendo(),
                                "12" => $obj->get_nomeDisciplina(),
                                "13" => $obj->get_nomeReduzido(),
                                "14" => $obj->get_complemento(),
                                "15" => $obj->get_horaDisciplina(),
                                "16" => $obj->get_objetivo(),
                                "17" => $obj->get_codTipoCurso(),
                                "21" => $obj->get_idftDisciplina(),
                                "22" => $obj->get_recmodifidonDisc(),
                                "23" => $obj->get_status()      
                    );
            $cont = 1;
            for ($index = 0; $index < $quantidade; $index++) {
                $subDescricao = $obj->get_descricaoDisciplina()."_".$cont;
                $subCod = $obj->get_codDisciplina()."_".$cont;
                $insert = "INSERT INTO PHE_CURSO_DSICIPLINA_ESCOLA (CODFILIAL,"
                       . "CODCURSO_SDISCGRADE,"
                       . "CODHABILITACAO_SDISCGRADE,"
                       . "CODGRADE_SDISCGRADE,"
                       . "CODPERIODO_SDISCGRADE,"
                       . "CODDISC_SDISCGRADE,"
                       . "POSHIST_SDISCGRADE,"
                       . "DESCRICAO_SDISCGRADE,"
                       . "OBJETIVO_SDISCGRADE,"
                       . "RECMODIFIEDON_SDISCGRADE,"
                       . "NOME_SDISCIPLINA,"
                       . "NOMEREDUZIDO_SDISCIPLINA,"
                       . "COMPLEMENTO_SDISCIPLINA,"
                       . "CH_SDISCIPLINA_SDISCIPLINA,"
                       . "OBJETIVO_SDISCIPLINA,"
                       . "CODTIPOCURSO_SDISCIPLINA,"
                       . "IDFT_SDISCIPLINA,"
                       . "RECMODIFIEDON_SDISCIPLINA,"
                       . "STATUS,"
                       . "SUBDISC_DESCRICAO,"
                       . "SUBDISC_CODDISC,"
                       . "SUBDISC_ORDEM,"
                       . "CODCOLIGADA) VALUES ($arrayDados[1],'$arrayDados[2]','$arrayDados[3]','$arrayDados[4]',$arrayDados[5],'$arrayDados[6]',$arrayDados[7],"
                       . "'$arrayDados[8]','$arrayDados[10]','$arrayDados[11]','$arrayDados[12]','$arrayDados[13]','$arrayDados[14]',$arrayDados[15],"
                       . "'$arrayDados[16]',$arrayDados[17],$arrayDados[21],'$arrayDados[22]',$arrayDados[23],'$subDescricao','$subCod',$cont,3)";
               $cont++;
               $sucesso = mssql_query($insert);
               if ($sucesso) {
                   $funcionou = true;
               }
            }
            return $funcionou;
        } catch (Exception $exc) {
            echo 'Exceção capturada: ', $exc->getMessage(), "\n";
        }
    }
    public function geraDiasCalendarioTurma(CalendarioTurma $calendario) {
        try {
            $codFilial = $calendario->get_codFilial();
            $codTurma = $calendario->get_codTurma();
            $userModify = $calendario->get_userCadastrante();
            $diasRetornados = $this->retornaCalendarioEscola($calendario);
            $idCalendarioTurma = $this->retornaIdCalendarioTurma($calendario);
            $limit = 0;
            if (count($idCalendarioTurma) >= count($diasRetornados)) {
                $limit += count($diasRetornados);
            }
            elseif(count($idCalendarioTurma) <= count($diasRetornados)){
                $limit += count($idCalendarioTurma);
            }
            for ($index = 0; $index < $limit; $index++) {
                $calendarioEscola = $diasRetornados[$index];
                $arrayDados = array($calendarioEscola->get_horaIni(), $calendarioEscola->get_horaFini(),
                                    $calendarioEscola->get_diaDaSemana(), $calendarioEscola->get_dataDia());
                $diaSemana = $calendarioEscola->get_diaDaSemana();
                $sql = "SELECT * FROM PHE_STURMA WHERE CODFILIAL = $codFilial AND CODIGOTURMA_CC = '$codTurma' AND DIASEMANA LIKE '%$diaSemana%'";
                $result = mssql_query($sql);
                if (mssql_num_rows($result)) {
                    $insert = "UPDATE dbo.PHE_CALENDARIO_TURMA SET HORA_INICIAL = '$arrayDados[0]', HORA_FINAL = '$arrayDados[1]', "
                    . "DIASEMANA = '$arrayDados[2]', DATADIA = '$arrayDados[3]', RECMODIFIEDBY = '$userModify' "
                    . "WHERE CODFILIAL = $codFilial AND CODIGO_TURMA = '$codTurma' "
                    . "AND ID = $idCalendarioTurma[$index]";
                    mssql_query($insert);
                }
            }
            return true;
        } catch (Exception $exc) {
            echo 'Exceção capturada: ', $exc->getMessage(), "\n";
        }
    }

    private function retornaIdCalendarioTurma(CalendarioTurma $calendario) {
        $codFilial = $calendario->get_codFilial();
        $codTurma = $calendario->get_codTurma();
        $select = "SELECT * FROM PHE_CALENDARIO_TURMA T WHERE CODFILIAL = $codFilial AND CODIGO_TURMA = '$codTurma' ORDER BY T.ORDEM_DISCIPLINA";
        $resultado = mssql_query($select);
        $listadeIds = array();
        while ($linha = mssql_fetch_array($resultado)) {
            $listadeIds[] = $linha['ID'];
        }
        return $listadeIds;
    }

    private function retornaObjetoTurma(CalendarioTurma $calendario) {
        try {
            $codCurso = $calendario->get_codCurso();
            $select = "SELECT * FROM PHE_CURSO_DSICIPLINA_ESCOLA P WHERE P.CODCURSO_SDISCGRADE = '$codCurso' AND STATUS = 1 ORDER BY P.POSHIST_SDISCGRADE";
            $query = mssql_query($select);
            $listaDeDisciplina = array();
            while ($linha = mssql_fetch_array($query)) {
                $disciplina = new CursoDisciplina();
                $disciplina->set_codDisciplina($linha['CODDISC_SDISCGRADE']);
                $disciplina->set_descricaoDisciplina($linha['DESCRICAO_SDISCGRADE']);
                $disciplina->set_horaDisciplina($linha['CH_SDISCIPLINA_SDISCIPLINA']);
                $disciplina->set_periodo($linha['CODPERIODO_SDISCGRADE']);
                $disciplina->set_ordemDeEnsino($linha['POSHIST_SDISCGRADE']);
                $disciplina->set_subCodigo($linha['SUBDISC_CODDISC']);
                $disciplina->set_subDiscOrdem($linha['SUBDISC_ORDEM']);
                $disciplina->set_subHora($linha['SUBDISC_CH']);
                $listaDeDisciplina[] = $disciplina;
            }
            return $listaDeDisciplina;
        } catch (Exception $ex) {
            echo 'Exceção capturada: ', $ex->getMessage(), "\n";
        }
    }

    private function retornaCalendarioEscola(CalendarioTurma $calendario){
        $codTurno = $calendario->get_codTurno();
        $codFilial = $calendario->get_codFilial();
        $campo = $this->retornaTipoCalendario($calendario);
        $select = "";
        if ($campo[2] == 1) {
            $select = "SELECT * FROM PHE_CALENDARIO_ESCOLA WHERE CODFILIAL = $codFilial AND CODTURNO = $codTurno AND $campo[0] = 0 AND $campo[1] = 1 AND DIASEMANA <> 'SAB'";
        }
        else{
            $select = "SELECT * FROM PHE_CALENDARIO_ESCOLA WHERE CODFILIAL = $codFilial AND CODTURNO = $codTurno AND $campo[0] = 0 AND $campo[1] = 1";
        }
        $result = mssql_query($select);
        $registrosCalendarioEscola = array();
        while ($linha = mssql_fetch_array($result)) {
            $calendarioEscola = new CalendarioEscolar();
            $calendarioEscola->set_horaIni($linha['HORINI']);
            $calendarioEscola->set_horaFini($linha['HORFIM']);
            $calendarioEscola->set_dataDia($linha['DATADIA']);
            $calendarioEscola->set_diaDaSemana($linha['DIASEMANA']);
            $registrosCalendarioEscola[] = $calendarioEscola;
        }
        return $registrosCalendarioEscola;
    }
    private function retornaTipoCalendario(CalendarioTurma $calendarTurma){
        $codFilial = $calendarTurma->get_codFilial();
        $codTurma = $calendarTurma->get_codTurma();
       
        $select = "SELECT * FROM PHE_STURMA WHERE CODFILIAL = $codFilial AND CODIGOTURMA_CC = '$codTurma'";
        $result = mssql_query($select);
        $tipoCalendario = "";
        while ($linha = mssql_fetch_array($result)) {
            $tipoCalendario = $linha['CALENDARIO_CC'];
        }
        switch ($tipoCalendario) {
            case 1:
                return $tipoCalendar = array("FNL","STATUS",1);
            case 2:
                return $tipoCalendar = array("FNL_CT","STATUS_CT",1);
            case 3:
                return $tipoCalendar = array("FNL_SS,STATUS_SS",0);
            case 4:
                return $tipoCalendar = array("FNL_CTSS,STATUS_CTSS",0);
        }
    }
    private function retornaTabelaCursoDisciplina(CalendarioTurma $calendario) {
        try {
            $codCurso = $calendario->get_codCurso();
            $codDisciplina = $calendario->get_codDisciplina();
            $sql = "SELECT * FROM PHE_CURSO_DSICIPLINA WHERE CODCURSO_SDISCGRADE = '$codCurso' AND CODDISC_SDISCGRADE = '$codDisciplina'";
            $result = mssql_query($sql);
           // $listaDeRegistros = array();
            while ($linha = mssql_fetch_array($result)) {
                $objetoDisciplina = new CursoDisciplina();
                $objetoDisciplina->set_codDisciplina($linha['CODDISC_SDISCGRADE']);
                $objetoDisciplina->set_descricaoDisciplina($linha['DESCRICAO_SDISCGRADE']);
                $objetoDisciplina->set_horaDisciplina($linha['CH_SDISCIPLINA_SDISCIPLINA']);
                $objetoDisciplina->set_codPeriodo($linha['CODPERIODO_SDISCGRADE']);
                $objetoDisciplina->set_ordemDeEnsino($linha['POSHIST_SDISCGRADE']);
                $objetoDisciplina->set_cargaHorariaPratica($linha['CHPRATICA_SDISCIPLINA']);
                $objetoDisciplina->set_cargaHorariaTeorica($linha['CHTEORICA_SDISCIPLINA']);
                $objetoDisciplina->set_chLaboratorio($linha['CHLABORATORIAL_SDISCIPLINA']);
                $objetoDisciplina->set_codGrade($linha['CODGRADE_SDISCGRADE']);
                $objetoDisciplina->set_codHab($linha['CODHABILITACAO_SDISCGRADE']);
                $objetoDisciplina->set_codTipoCurso($linha['CODTIPOCURSO_SDISCIPLINA']);
                $objetoDisciplina->set_complemento($linha['COMPLEMENTO_SDISCIPLINA']);
                $objetoDisciplina->set_idftDisciplina($linha['IDFT_SDISCIPLINA']);
                $objetoDisciplina->set_nomeDisciplina($linha['NOME_SDISCIPLINA']);
                $objetoDisciplina->set_nomeReduzido($linha['NOMEREDUZIDO_SDISCIPLINA']);
                $objetoDisciplina->set_objetivo($linha['OBJETIVO_SDISCIPLINA']);
                $objetoDisciplina->set_recmodifidonDisc($linha['RECMODIFIEDON_SDISCIPLINA']);
                $objetoDisciplina->set_recmodifiendo($linha['RECMODIFIEDON_SDISCGRADE']);
                $objetoDisciplina->set_status($linha['STATUS']);
                $objetoDisciplina->set_codCurso($linha['CODCURSO_SDISCGRADE']);
                $objetoDisciplina->set_objetivoSgrade($linha['OBJETIVO_SDISCGRADE']);
               // $objetoDisciplina->set_ch($linha['CH_SDISCGRADE']);
                return $objetoDisciplina;
            }  
        } catch (Exception $ex) {
            echo 'Exceção capturada: ', $ex->getMessage(), "\n";
        }
    }

    public function fechaBanco() {
        mssql_close($this->conexao);
    }
}
