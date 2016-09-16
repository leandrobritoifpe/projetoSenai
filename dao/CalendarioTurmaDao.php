<?php
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
                    $disciplina->get_periodo(), $disciplina->get_ordemDeEnsino());
                if ($periodo != "vazio" && $periodo != $dadosDisciplina[3]) {
                    $contaTurma++;
                }
                $numero = (int) $dadosDisciplina[2];
                for ($i = 0; $i < $numero; $i++) {
                    $aula = 'AULA0' . $contaAula;
                    $subTurma = $dadosCalendarioTurma[2] . $contaTurma;
                    $insert = "INSERT INTO PHE_CALENDAR_TURMA (CODFILIAL,STATUS,CODIGO_TURMA,PERIODO_TURMA,CODIGO_CURSO,CODIGO_DISCIPLINA,"
                            . "DESCRICAO_DISCIPLINA,ORDEM_DISCIPLINA,CARGAHORA_DISCIPLINA,AULA,USERCADASTRANTE,SUBCODIGOTURMA) "
                            . "VALUES ($dadosCalendarioTurma[1],1,'$dadosCalendarioTurma[2]',$dadosDisciplina[3],'$dadosCalendarioTurma[0]',"
                            . "'$dadosDisciplina[0]','$dadosDisciplina[1]',$dadosDisciplina[4],$dadosDisciplina[2],'$aula','$dadosCalendarioTurma[3]','$subTurma')";
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

    private function retornaObjetoTurma(CalendarioTurma $calendario){
        try{
            //echo "1";
            $codCurso = $calendario->get_codCurso();
            //$codFilial = $calendario->get_codFilial();
            $select = "SELECT * FROM PHE_CURSO_DSICIPLINA P WHERE P.CODCURSO_SDISCGRADE = '$codCurso' AND STATUS = 1 ORDER BY P.POSHIST_SDISCGRADE";
            $query = mssql_query($select);
            $listaDeDisciplina = array();
            while ($linha = mssql_fetch_array($query)) {
                //echo "30";
                $disciplina = new Disciplina();
                $disciplina->set_codDisciplina($linha['CODDISC_SDISCGRADE']);
                $disciplina->set_descricaoDisciplina($linha['DESCRICAO_SDISCGRADE']);
                $disciplina->set_horaDisciplina($linha['CH_SDISCIPLINA_SDISCIPLINA']);
                $disciplina->set_periodo($linha['CODPERIODO_SDISCGRADE']);
                $disciplina->set_ordemDeEnsino($linha['POSHIST_SDISCGRADE']);
                $listaDeDisciplina[] = $disciplina;
            }
            return $listaDeDisciplina;
        } catch (Exception $ex) {
               echo 'Exceção capturada: ', $ex->getMessage(), "\n";
        }
    }
    public function fechaBanco() {
        mssql_close($this->conexao);
    }
}
