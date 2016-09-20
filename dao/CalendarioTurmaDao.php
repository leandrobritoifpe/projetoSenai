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
            $dadosCalendarioTurma = array($calendario->get_codCurso(), $calendario->get_codFilial(), $calendario->get_codTurma(), $calendario->get_userCadastrante());
            $contaAula = 1;
            $contaTurma = 0;
            $periodo = "vazio";

            for ($index = 0; $index < count($listaDisciplinas); $index++) {
                $disciplina = $listaDisciplinas[$index];
                $dadosDisciplina = array($disciplina->get_codDisciplina(), $disciplina->get_descricaoDisciplina(), $disciplina->get_horaDisciplina(),
                    $disciplina->get_periodo(), $disciplina->get_ordemDeEnsino(),$disciplina->get_subCodigo());
                if ($periodo != "vazio" && $periodo != $dadosDisciplina[3]) {
                    $contaTurma++;
                }
                $numero = (int) $dadosDisciplina[2];
                for ($i = 0; $i < $numero; $i++) {
                    $aula = $contaAula;
                    $subTurma = $dadosCalendarioTurma[2] . $contaTurma;
                    $insert = "INSERT INTO PHE_CALENDARIO_TURMA (CODFILIAL,STATUS,CODIGO_CURSO,PERIODO_CURSO,CODIGO_CURSO,CODIGO_DISCIPLINA,"
                            . "DESCRICAO_DISCIPLINA,ORDEM_DISCIPLINA,CARGAHORA_DISCIPLINA,AULA,USERCADASTRANTE,SUBCODIGOTURMA,CODIGO_SUBDISCIPLINA,) "
                            . "VALUES ($dadosCalendarioTurma[1],1,'$dadosCalendarioTurma[2]',$dadosDisciplina[3],'$dadosCalendarioTurma[0]',"
                            . "'$dadosDisciplina[0]','$dadosDisciplina[1]',$dadosDisciplina[4],$dadosDisciplina[2],'$aula','$dadosCalendarioTurma[3]','$subTurma','$dadosCalendarioTurma[5]')";
                    mssql_query($insert);
                    $contaAula++;
                }
                $periodo = $dadosDisciplina[3];
            }
            return true;
        } catch (Exception $ex) {
            echo 'Exceção capturada: ', $ex->getMessage(), "\n";
        }
    }
    public function transfereTabelaCursoDisciplina(CalendarioTurma $calendarioTurma,$quantidade) {
        try {
            $obj = $this->retornaTabelaCursoDisciplina($calendarioTurma);
            if($obj->get_ch() == null || $obj->get_ch() == 0 || $obj->get_ch() == ''){
                $obj->set_ch(0);
            }
            $arrayDados = array(
                                "1" => $calendarioTurma->get_codFilial(),
                                "2" => $calendarioTurma->get_codCurso(),
                                "3" => $obj->get_codHab(),
                                "4" => $obj->get_codGrade(),
                                "5" => $obj->get_codPeriodo(),
                                "6" => $calendarioTurma->get_codDisciplina(),
                                "7" => $obj->get_ordemDeEnsino(),
                                "8" => $obj->get_descricaoDisciplina(),
                                "9" => $obj->get_ch(),
                                "10" => $obj->get_objetivoSgrade(),
                                "11" => $obj->get_recmodifiendo(),
                                "12" => $obj->get_nomeDisciplina(),
                                "13" => $obj->get_nomeReduzido(),
                                "14" => $obj->get_complemento(),
                                "15" => $obj->get_horaDisciplina(),
                                "16" => $obj->get_objetivo(),
                                "17" => $obj->get_codTipoCurso(),
                                "18" => $obj->get_cargaHorariaTeorica(),
                                "19" => $obj->get_cargaHorariaPratica(),
                                "20" => $obj->get_chLaboratorio(),
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
                       . "CH_SDISCGRADE,"
                       . "OBJETIVO_SDISCGRADE,"
                       . "RECMODIFIEDON_SDISCGRADE,"
                       . "NOME_SDISCIPLINA,"
                       . "NOMEREDUZIDO_SDISCIPLINA,"
                       . "COMPLEMENTO_SDISCIPLINA,"
                       . "CH_SDISCIPLINA_SDISCIPLINA,"
                       . "OBJETIVO_SDISCIPLINA,"
                       . "CODTIPOCURSO_SDISCIPLINA,"
                       . "CHTEORICA_SDISCIPLINA,"
                       . "CHPRATICA_SDISCIPLINA,"
                       . "CHLABORATORIAL_SDISCIPLINA,"
                       . "IDFT_SDISCIPLINA,"
                       . "RECMODIFIEDON_SDISCIPLINA,"
                       . "STATUS,"
                       . "SUBDISC_DESCRICAO,"
                       . "SUBDISC_CODDISC,"
                       . "SUBDISC_ORDEM,"
                       . "CODCOLIGADA) VALUES ($arrayDados[1],'$arrayDados[2]','$arrayDados[3]','$arrayDados[4]',$arrayDados[5],'$arrayDados[6]',$arrayDados[7],"
                       . "'$arrayDados[8]',$arrayDados[9],'$arrayDados[10]','$arrayDados[11]','$arrayDados[12]','$arrayDados[13]','$arrayDados[14]',$arrayDados[15],"
                       . "'$arrayDados[16]',$arrayDados[17],$arrayDados[18],$arrayDados[19],$arrayDados[20],$arrayDados[21],'$arrayDados[22]',$arrayDados[23],'$subDescricao','$subCod',$cont,3)";
               $cont++;
               mssql_query($insert);
            }
            return true;
        } catch (Exception $exc) {
            echo 'Exceção capturada: ', $exc->getMessage(), "\n";
        }
    }

    private function retornaObjetoTurma(CalendarioTurma $calendario) {
        try {
            $codCurso = $calendario->get_codCurso();
            $select = "SELECT * FROM PHE_CURSO_DSICIPLINA_ESCOLA P WHERE P.CODCURSO_SDISCGRADE = '$codCurso' AND STATUS = 1 ORDER BY P.POSHIST_SDISCGRADE";
            $query = mssql_query($select);
            $listaDeDisciplina = array();
            while ($linha = mssql_fetch_array($query)) {
                //echo "30";
                $disciplina = new CursoDisciplina();
                $disciplina->set_codDisciplina($linha['CODDISC_SDISCGRADE']);
                $disciplina->set_descricaoDisciplina($linha['DESCRICAO_SDISCGRADE']);
                $disciplina->set_horaDisciplina($linha['CH_SDISCIPLINA_SDISCIPLINA']);
                $disciplina->set_periodo($linha['CODPERIODO_SDISCGRADE']);
                $disciplina->set_ordemDeEnsino($linha['POSHIST_SDISCGRADE']);
                $disciplina->set_subCodigo($linha['SUBDISC_CODDISC']);
                $listaDeDisciplina[] = $disciplina;
            }
            return $listaDeDisciplina;
        } catch (Exception $ex) {
            echo 'Exceção capturada: ', $ex->getMessage(), "\n";
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
                $objetoDisciplina->set_ch($linha['CH_SDISCGRADE']);
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
