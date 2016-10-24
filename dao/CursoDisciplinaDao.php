<?php

/*
 *
 * OBJETIVO: SERVIR DE CONTROLE PARA O DAO
 * CRIADA: 18/10/2016
 * ULTIMA ATUALIZACAO : 18/10/2016
 * 
 * DS -> LEANDRO BRITO
 */

/**
 * Description of CursoDisciplinaDao
 *
 * @author leandro.brito
 */
require_once './util/ConnectaBanco.php';
require_once './entidades/Disciplina.php';
class CursoDisciplinaDao {
   private $conexao;
   public function abreBanco() {
        try {
            $con = new ConnectaBanco();
            $this->conexao = $con->conectandoComBanco();
        } catch (Exception $e) {
            echo 'Exceção capturada: ', $e->getMessage(), "\n";
        }
    }
    public function inseriOrdemDisciplina(CursoDisciplina $disciplina) {
        try {
            $codFilial = $disciplina->get_codFilial();
            $codCurso = $disciplina->get_codCurso();
            $codDisciplina = $disciplina->get_codDisciplina();
            $ordemDisc = $disciplina->get_ordemDeEnsino();
            
            $update = "UPDATE PHE_CURSO_DSICIPLINA_ESCOLA SET POSHIST_SDISCGRADE = $ordemDisc "
                    . "WHERE CODFILIAL = $codFilial AND CODCURSO_SDISCGRADE = '$codCurso' "
                    . "AND CODDISC_SDISCGRADE = '$codDisciplina'";
            $result = mssql_query($update);
            if ($result) {
                return true;
            }
            return false;
        } catch (Exception $e) {
            echo 'Exceção capturada: ', $e->getMessage(), "\n";
        }
    }
    public function retornaDisciplinasEspecificas(CursoDisciplina $disciplina) {
        try {
            $codFilial = $disciplina->get_codFilial();
            $codCurso = $disciplina->get_codCurso();
            $codDisciplina = $disciplina->get_codDisciplina();
            $ordem = $disciplina->get_ordemDeEnsino();
            $sql = "SELECT DISTINCT POSHIST_SDISCGRADE,CODDISC_SDISCGRADE FROM PHE_CURSO_DSICIPLINA_ESCOLA WHERE CODFILIAL = $codFilial "
                    . "AND CODCURSO_SDISCGRADE = '$codCurso' AND POSHIST_SDISCGRADE >= $ordem"
                    . "AND CODDISC_SDISCGRADE <> '$codDisciplina' ORDER BY POSHIST_SDISCGRADE";
            $result = mssql_query($sql);
            $listaCodDisciplina = array();
            if (mssql_num_rows($result)) {
                while ($linha = mssql_fetch_array($result)) {
                    $listaCodDisciplina[] = $linha['CODDISC_SDISCGRADE'];
                }
            }
            return $listaCodDisciplina;
        } catch (Exception $e) {
            echo 'Exceção capturada: ', $e->getMessage(), "\n";
        }
    }
    public function atualizaOrdemDisciplina(CursoDisciplina $disciplina) {
        try {
            $codDisciplina = $disciplina->get_codDisciplina();
            $codFilial = $disciplina->get_codFilial();
            $codCurso = $disciplina->get_codCurso();
            $ordemDisciplina = $disciplina->get_ordemDeEnsino();
            $update = "UPDATE PHE_CURSO_DSICIPLINA_ESCOLA SET POSHIST_SDISCGRADE = $ordemDisciplina "
                    . "WHERE CODFILIAL = $codFilial AND CODCURSO_SDISCGRADE = '$codCurso' "
                    . "AND CODDISC_SDISCGRADE = '$codDisciplina'";
            mssql_query($update);
            return true;
        } catch (Exception $e) {
            echo 'Exceção capturada: ', $e->getMessage(), "\n";
        }
    }

}
