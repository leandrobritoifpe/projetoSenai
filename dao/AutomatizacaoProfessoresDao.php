<?php

/*
 * OBJETIVO: SERVIR DE CONTROLE PARA O DAO
 * CRIADA: 14/10/2016
 * ULTIMA ATUALIZACAO : 14/10/2016
 * 
 * DS -> LEANDRO BRITO
 */
include_once './entidades/CalendarioTurma.php';
class AutomatizacaoProfessoresDao {
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
    public function turmaComMaiorCH($codFilial,$turno) {
        try {
            $sql = "SELECT * FROM PHE_STURMA WHERE CODFILIAL = $codFilial "
                    . "AND CODTURNO = $turno AND TP = 0 ORDER BY CH_TOTAL DESC";
            $result = mssql_query($sql);
            $codTurmas = array();
            if (mssql_num_rows($result)) {
                while ($linha = mssql_fetch_array($result)) {
                    $codTurmas[] = $linha['CODIGOTURMA_CC'];
                }
                return $codTurmas;
            }
            return false;
        } catch (Exception $exc) {
            echo 'Exceção capturada: ', $exc->getMessage(), "\n";
        }
    }
    public function disciplinaTurma($codFilial, $turma,$turno) {
        try {
            $sql = "SELECT DISTINCT CODIGO_SUBDISCIPLINA, ORDEM_DISCIPLINA FROM PHE_CALENDARIO_TURMA "
                    . "WHERE CODFILIAL = $codFilial AND CODIGO_TURMA = '$turma' "
                    . "AND CODIGO_TURNO = $turno ORDER BY ORDEM_DISCIPLINA";
            $result = mssql_query($sql);
            $codigosSubdisc = array();
            if (mssql_num_rows($result)) {
                while ($linha = mssql_fetch_array($result)) {
                    $codigosSubdisc[] = $linha['CODIGO_SUBDISCIPLINA'];
                }
                return $codigosSubdisc;
            }
        } catch (Exception $exc) {
            echo 'Exceção capturada: ', $exc->getMessage(), "\n";
        }
    }
    public function horasProfessor($codFilial, $docente){
        try {
            $sql = "SELECT * FROM PHE_CALENDARIO_TURMA WHERE CODFILIAL = $codFilial "
                    . "AND CODIGO_PROFESSOR = $docente";
            $result = mssql_query($sql);
            return mssql_num_rows($result);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        }
    public function professoresComMaiorEspertises($codFilial, $subDisciplina,$turno) {
        try {
            $sql = "SELECT * FROM PHE_EXPERTISES E "
                    . "INNER JOIN PHE_TURNO_DOCENTE TD ON E.CODPESSOA = TD.CODPESSOA "
                    . "WHERE E.CODIGO_SUBDISC = '$subDisciplina' AND E.CODFILIAL = $codFilial AND TD.CODTURNO = $turno ORDER BY E.ESCALA";
            $result = mssql_query($sql);
            $professoresExpertises = array();
            if (mssql_num_rows($result)) {
                while ($linha = mssql_fetch_array($result)) {
                  $expertises = new ProfessorExpertises($linha['ID'], $linha['CODIGO_DISCIPLNA'], $linha['CODIGO_SUBDISC'], $linha['CODPESSOA'], $linha['ESCALA']);
                  $professoresExpertises[] = $expertises;
                }
                return $professoresExpertises;
            }
            return false;
        } catch (Exception $exc) {
            echo 'Exceção capturada: ', $exc->getMessage(), "\n";
        }
    }
    public function fechaBanco() {
        mssql_close($this->conexao);
    }
}
