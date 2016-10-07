<?php

/* ARQUVOS CadastraDiaNaoLetivo
 * OBJETIVO: SERVIR DE CONTROLE PARA O DAO
 * CRIADA: 14/08/2016
 * ULTIMA ATUALIZACAO : 06/10/2016
 * 
 * DS -> LEANDRO BRITO
 */

//IMPORTANDO CLASSE CONEXAO COM BANCO
include_once './util/ConnectaBanco.php';
//IMPORTANTO CLASSE DIA NÃO LETIVO
include_once './entidades/CalendarioProfessor.php';

class CalendarioDocenteDao {

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

    public function anoNaoExiisteNoCalendarioEscolar($ano, $codFilial) {
        //$contaLinhas = 0;
        $select = "SELECT * FROM PHE_CALENDARIO_ESCOLA WHERE CODFILIAL = $codFilial AND DATADIA LIKE '$ano%'";
        $resultado = mssql_query($select);
        if (mssql_num_rows($resultado)) {
            return false;
        } else {
            return true;
        }
    }

    public function geraCalendarioDocenteLivre(CalendarioProfessor $calendarioProfessor) {
        $userCadastrante = $calendarioProfessor->get_userCadastrante();
        $arrayDeObjetos = $this->retornaArrayDeObjetos($calendarioProfessor);
        $arrayDeCodigos = $arrayDeObjetos[0];
        $arrayDeDias = $arrayDeObjetos[1];
        $inseriuComSucesso = false;
        for ($index = 0; $index < count($arrayDeCodigos); $index++) {
          // $calendarioDoProfessor = new CalendarioProfessor();
            $calendarioDoProfessor = $arrayDeCodigos[$index];
            $dadosDoCalendario = array($calendarioDoProfessor->get_codigoDocente(),
                $calendarioDoProfessor->get_codigoFilial(),
                $calendarioDoProfessor->get_qtdHoras());
            for ($i = 0; $i < count($arrayDeDias); $i++) {
                //$listaDeDias = new CalendarioProfessor();
                $listaDeDias = $arrayDeDias[$i];
                $dias = array($listaDeDias->get_dataDia(),
                    $listaDeDias->get_diaDaSemana(),$listaDeDias->get_flagFeriado());
                for ($j = 0; $j < 12; $j++) {
                    $insert = "INSERT dbo.PHE_CALENDARIO_DOCENTE (CODIGODOCENTE,CODFILIAL,QDEHORAS,DESCRICAO,DATADIA,DIASEMANA,FNL,RECCREATEDBY,CODTURNO) "
                            ."VALUES ($dadosDoCalendario[0],$dadosDoCalendario[1],$dadosDoCalendario[2],1,'$dias[0]','$dias[1]',$dias[2],'$userCadastrante',0)";
                    $resultado = mssql_query($insert);
                    if ($resultado) {
                        $inseriuComSucesso = true;
                    }
                }
            }
        }
        return $inseriuComSucesso;
    }
    public function zeraCalendarioDocente(CalendarioProfessor $calendarioProfessor){
        try {
            $codFilial = $calendarioProfessor->get_codigoFilial();
            $codDocente = $calendarioProfessor->get_codigoDocente();
            $delete = "DELETE PHE_CALENDARIO_ESCOLA WHERE CODIGODOCENTE = $codDocente AND CODFILIAL = $codFilial";
            mssql_query($delete);
        } catch (Exception $ex) {
            
        }
    }
    public function diasAulasSubDisciplina($codFilial, $subDisc,$turma){
        $select = "SELECT * FROM PHE_CALENDARIO_TURMA WHERE CODFILIAL = $codFilial "
                . "AND CODIGO_TURMA = '$turma' AND CODIGO_SUBDISCIPLINA = '$subDisc'";
        $result = mssql_query($select);
        $dados =array();
        if (mssql_num_rows($result)) {
            while ($linha = mssql_fetch_array($result)) {
                $calendario  = new CalendarioProfessor();
                $calendario->set_horaIni($linha['HORA_INICIAL']);
                $calendario->set_horaFini($linha['HORA_FINAL']);
                $calendario->set_turma($linha['CODIGO_TURMA']);
                $calendario->set_idTurma($linha['ID']);
                $calendario->set_dataDia($linha['DATADIA']);
                $dados[] = $calendario;
            }
            return $dados;
        }
    }
    public function verificaSeDataExiste($diasDeAulaSubDisc, $codFilial, $docente, $turno) {
        $diasUteis = array();
        $diaComAula = array();
       
        for ($i = 0; $i < count($diasDeAulaSubDisc); $i++) {
            $calendario = $diasDeAulaSubDisc[$i];
            $dados = array($calendario->get_dataDia());
            $select = "SELECT * FROM PHE_CALENDARIO_TURMA WHERE DATADIA = '$dados[0]' "
                    . "AND CODFILIAL = $codFilial AND CODIGO_PROFESSOR = $docente "
                    . "AND CODIGO_TURNO = $turno";
            $resultado = mssql_query($select);
            if (!mssql_num_rows($resultado)) {
                $diasUteis[] = $diasDeAulaSubDisc[$i];
            }
            else{
                $diaComAula[] = $diasDeAulaSubDisc[$i];
            }     
        }
       
        return  $todosDias = array($diasUteis,$diaComAula);
//        $ultimoIndice = (count($diasDeAulaSubDisc) - 1);
//        $calendario = $diasDeAulaSubDisc[0];
//        $newCalendario = $diasDeAulaSubDisc[$ultimoIndice];
//        $dados = array($calendario->get_dataDia(), $newCalendario->get_dataDia());
//        if (mssql_num_rows($resultado)) {
//            return false;
//        }
//        $sql = "SELECT * FROM PHE_CALENDARIO_DOCENTE WHERE DATADIA BETWEEN '$dados[0]' AND '$dados[1]' "
//                . "AND CODFILIAL = $codFilial AND FNL = 0 AND CODIGODOCENTE = $docente "
//                . "AND CODTURNO = 0";
//        $result = mssql_query($sql);
//        if (mssql_num_rows($result)) {
//            return $this->retornaDiasDeAulaUteis($sql);
//        }
//        return false;
    }
    public function professorTemHora($docente, $codFilial, $diasDeAula) {
        try {
            $diasUteis = array();
            $diasEsgotados = array();
            for ($i = 0; $i < count($diasDeAula); $i++) {
                $dataDia = $diasDeAula[$i]->get_dataDia();
                $sql = "SELECT * FROM PHE_CALENDARIO_TURMA WHERE CODIGO_PROFESSOR = $docente "
                        . "AND CODFILIAL = $codFilial AND DATADIA = '$dataDia'";
                $result = mssql_query($sql);
                $linhas = mssql_num_rows($result);
                if ($linhas >= 8) {
                    $diasEsgotados[] = $diasDeAula[$i];
                }
                else{
                   $diasUteis[] = $diasDeAula[$i];
                }
            }
            return $todosDias = array($diasUteis,$diasEsgotados);
        } catch (Exception $ex) {
            echo 'Exceção capturada: ', $ex->getMessage(), "\n";
        }
    }

    public function inseriProfessorTurma($codFilial, $codTurma, $diasDeAula, $docente, $turno) {
        try {
            $gerouComSucesso = false;
            $id = 0;
            for ($i = 0; $i < count($diasDeAula); $i++) {
                $calendario = $diasDeAula[$i];
                $dados = array("1" => $calendario->get_dataDia(),
                    "2" => $calendario->get_horaIni(),
                    "3" => $calendario->get_horaFini(),
                    "4" => $calendario->get_turma(),
                    "5" => $calendario->get_idTurma()
                );
                //$id = $this->idDiaDeAula($calendario->get_dataDia(), $codFilial, $docente,$id);
                /* $update = "UPDATE PHE_CALENDARIO_DOCENTE SET HORINI = '$dados[2]', HORFIM = '$dados[3]', "
                  . "CODIGO_TURMA = '$codTurma', CODTURNO = $turno, IDTURMA = $dados[5] "
                  . "WHERE ID = $id"; */
                $updateCalendarioTurma = "UPDATE PHE_CALENDARIO_TURMA SET CODIGO_PROFESSOR = $docente "
                        . "WHERE ID = $dados[5]";
//               /$result = mssql_query($update);
                $resultado = mssql_query($updateCalendarioTurma);
                if ($resultado) {
                    $gerouComSucesso = true;
                }
            }
            return $gerouComSucesso;
        } catch (Exception $ex) {
            echo 'Exceção capturada: ', $ex->getMessage(), "\n";
        }
    }

    public function retiraProfessorTurma($codFilial,$docente,$turma,$subdisc){
        try {
            $atualizouComSucesso = false;
            $ids = $this->idAulaSubDisciplinaProfessor($codFilial, $docente, $turma, $subdisc);
            for ($i = 0; $i < count($ids); $i++) {
                $update = "UPDATE PHE_CALENDARIO_DOCENTE SET HORINI = '', HORFIM = '', "
                        . "IDTURMA = 0, CODIGO_TURMA = '', CODTURNO = 0 WHERE CODFILIAL = $codFilial "
                        . "AND CODIGODOCENTE = $docente AND IDTURMA = $ids[$i]";
                $result = mssql_query($update);
                
                if ($update) {
                    $atualizouComSucesso = true;
                }
            }
            $updateTurma = "UPDATE PHE_CALENDARIO_TURMA SET CODIGO_PROFESSOR = 0 "
                        . "WHERE CODFILIAL = $codFilial AND CODIGO_PROFESSOR = $docente "
                        . "AND CODIGO_SUBDISCIPLINA = '$subdisc' AND CODIGO_TURMA = '$turma'";
            $result = mssql_query($updateTurma);
            return $atualizouComSucesso;
        } catch (Exception $ex) {
            echo 'Exceção capturada: ', $ex->getMessage(), "\n";
        }
    }

    private function idAulaSubDisciplinaProfessor($codFilial,$docente,$turma,$subdisc){
        try {
            $sql = "SELECT * FROM PHE_CALENDARIO_TURMA WHERE CODFILIAL = $codFilial "
                    . "AND CODIGO_PROFESSOR = $docente AND CODIGO_TURMA = '$turma' "
                    . "AND CODIGO_SUBDISCIPLINA = '$subdisc'";
            $result = mssql_query($sql);
            $idTurma = array();
            if (mssql_num_rows($result)) {
                while ($linha = mssql_fetch_array($result)) {
                    $idTurma[] = $linha['ID'];
                }
                return $idTurma;
            }
        } catch (Exception $ex) {
            echo 'Exceção capturada: ', $e->getMessage(), "\n";
        }
    }
    /*
    private function idDiaDeAula($data,$codFilial,$docente,$id){
       $sql = "SELECT TOP 1 * FROM PHE_CALENDARIO_DOCENTE WHERE DATADIA >= '$data' "
                . "AND CODFILIAL = $codFilial AND CODIGODOCENTE = $docente AND FNL = 0 "
                . "AND ID > $id AND CODTURNO = 0";
        $result = mssql_query($sql);
        //$id = '';
        if (mssql_num_rows($result)) {
            while ($linha = mssql_fetch_array($result)) {
               return $linha['ID'];
            }
            
        }
    }*/
    private function retornaDiasDeAulaUteis($sql){
        $result = mssql_query($sql);
        $dados =  array();
        if (mssql_num_rows($result)) {
            while ($linha = mssql_fetch_array($result)) {
                $calendario  = new CalendarioProfessor();
                $calendario->set_horaIni($linha['HORA_INICIAL']);
                $calendario->set_horaFini($linha['HORA_FINAL']);
                $calendario->set_turma($linha['CODIGO_TURMA']);
                $calendario->set_idTurma($linha['ID']);
                $calendario->set_dataDia($linha['DATADIA']);
                $dados[] = $calendario;
            }
            return $dados;
        }
    }
    private function retornaArrayDeObjetos(CalendarioProfessor $calendario) {
        $codigoFilial = $calendario->get_codigoFilial();
        $codigoDocente = $calendario->get_codigoDocente();
        $ano = $calendario->get_ano();
        $select = "SELECT * FROM PHE_SPROFESSOR WHERE CODFILIAL = $codigoFilial AND CODPESSOA = $codigoDocente";
        $resultado = mssql_query($select);
        $listaDeCalendarioDocente = array();
        $listaDeDias = array();
        $arrayDeObjetos = array();
        $i = 0;
        while ($linha = mssql_fetch_array($resultado)) {
            $calendarioDocente = new CalendarioProfessor();
            $calendarioDocente->set_codigoDocente($linha['CODPESSOA']);
            $calendarioDocente->set_codigoFilial($linha['CODFILIAL']);
            $calendarioDocente->set_qtdHoras($linha['QDEHORAS']);
            $listaDeCalendarioDocente[$i] = $calendarioDocente;
            $i++;
        }
        $contador = 0;
        $sql = "SELECT DISTINCT DATADIA,DIASEMANA,FNL FROM PHE_CALENDARIO_ESCOLA WHERE CODFILIAL = $codigoFilial AND DATADIA LIKE '$ano%' ORDER BY DATADIA";
        $result = mssql_query($sql);
        while ($registros = mssql_fetch_array($result)) {
            $calendarioProfessor = new CalendarioProfessor();
            $calendarioProfessor->set_dataDia($registros['DATADIA']);
            $calendarioProfessor->set_diaDaSemana($registros['DIASEMANA']);
            $calendarioProfessor->set_flagFeriado($registros['FNL']);
            $listaDeDias[$contador] = $calendarioProfessor;
            $contador++;
        }
        $arrayDeObjetos[0] = $listaDeCalendarioDocente;
        $arrayDeObjetos[1] = $listaDeDias;
        return $arrayDeObjetos;
    }

    public function fechaBanco() {
        mssql_close($this->conexao);
    }

}
