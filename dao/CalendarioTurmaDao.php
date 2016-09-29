<?php
/*
 * CLASSE CalendarioTurmaDao.php
 * OBJETIVO: SERVIR DE COMUNICAÇÃO COM O BANCO
 * CRIADA: 20/09/2016
 * ULTIMA ATUALIZACAO : 29/09/2016
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
    public function geraCalendarioSemDividirDisciplina(CalendarioTurma $calendarioTurma){
        try{
            
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
                $subDescricao = $obj->get_nomeDisciplina()."_".$cont;
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
            $dadosArray = array( "1" => $calendario->get_codFilial(),
                                 "2" => $calendario->get_codCurso(),
                                 "3" => $calendario->get_codTurma(),
                                 "4" => $calendario->get_dataInicial(),
                                 "5" => $calendario->get_codTurno(),
                                 "6" => $calendario->get_userCadastrante(),
                                 "7" => $calendario->get_diasRecesso()
                                );
            $data = $dadosArray[4];
            $periodosCurso = $this->retornaPeriodos($calendario);
            for ($i = 0; $i < count($periodosCurso); $i++) {
                $diasDeAulaId = $this->retornaDiasDeAulaDoPeriodo($calendario, $periodosCurso[$i]);
                $diasCalendario = $this->retornaObjetoCalendarioEscola($calendario,$data);
                $limit = $this->retoraMenorArray($diasDeAulaId, $diasCalendario);
                
               
                for ($j = 0; $j < $limit; $j++) {
                    $calendarioEscola = $diasCalendario[$j];
                    $dados = array("1" => $calendarioEscola->get_dataDia(),
                               "2" => $calendarioEscola->get_diaDaSemana(),
                               "3" => $calendarioEscola->get_horaIni(),
                               "4" => $calendarioEscola->get_horaFini());
                   $update = "UPDATE PHE_CALENDARIO_TURMA  SET DATADIA = '$dados[1]', DIASEMANA = '$dados[2]', HORA_INICIAL = '$dados[3]', "
                            . "HORA_FINAL = '$dados[4]' WHERE CODFILIAL = $dadosArray[1] AND CODIGO_CURSO = '$dadosArray[2]' "
                            . "AND CODIGO_TURMA = '$dadosArray[3]' AND PERIODO_CURSO = $periodosCurso[$i] AND ID = $diasDeAulaId[$j]";
                   mssql_query($update);
                }
                if (count($diasCalendario) > count($diasDeAulaId)) {
                    $dataId = $this->retornaUltimoDiaDeAulaDoPerido($calendario, $periodosCurso[$i]);
                    $dataNova = date('Y-m-d', strtotime("+$dadosArray[7] days",strtotime($dataId[1])));
                    $ano  = substr($dadosArray[4],0,4);
                    $dataFinalCalendario = $ano.'-12-31';
                    if ($dataNova > $dataFinalCalendario) {
                        break;
                    }
                    elseif($dataNova < $dataFinalCalendario){
                       $data = $dataNova; 
                    }
                }
                elseif(count($diasCalendario) < count($diasDeAulaId)){
                    break;
                }
            }
            return true;
        } catch (Exception $exc) {
            echo 'Exceção capturada: ', $exc->getMessage(), "\n";
        }
    }
    public function geraDiasTurmaApartirDaAula(CalendarioTurma $calendario){
        try {
            $realizouComSucesso = false;
            $dadosArray = array( "1" => $calendario->get_codFilial(),
                                 "2" => $calendario->get_codCurso(),
                                 "3" => $calendario->get_codTurma(),
                                 "4" => $calendario->get_dataInicial(),
                                 "5" => $calendario->get_codTurno(),
                                 "6" => $calendario->get_userCadastrante(),
                                 "7" => $calendario->get_diasRecesso(),
                                 "8" => $calendario->get_aula()
                                );
            $dadosAula = $this->retornaIdDaAula($calendario);
            $data = $dadosArray[4];
            $periodosCurso = $this->retornaPeriodoSucessor($calendario,$dadosAula[1]);
            for ($i = 0; $i < count($periodosCurso); $i++) {
                $diasDeAulaId = $this->retornaArrayDeAulasDoPeriodo($calendario, $periodosCurso[$i],$dadosAula[0]);
                $diasCalendario = $this->retornaObjetoCalendarioEscola($calendario,$data);
                $limit = $this->retoraMenorArray($diasDeAulaId, $diasCalendario);
               
                for ($j = 0; $j < $limit; $j++) {
                    $calendarioEscola = $diasCalendario[$j];
                    $dados = array("1" => $calendarioEscola->get_dataDia(),
                               "2" => $calendarioEscola->get_diaDaSemana(),
                               "3" => $calendarioEscola->get_horaIni(),
                               "4" => $calendarioEscola->get_horaFini());
                     $update = "UPDATE PHE_CALENDARIO_TURMA  SET DATADIA = '$dados[1]', DIASEMANA = '$dados[2]', HORA_INICIAL = '$dados[3]', "
                            . "HORA_FINAL = '$dados[4]' WHERE CODFILIAL = $dadosArray[1] AND CODIGO_CURSO = '$dadosArray[2]' "
                            . "AND CODIGO_TURMA = '$dadosArray[3]' AND PERIODO_CURSO = $periodosCurso[$i] AND ID = $diasDeAulaId[$j]";
                   $result  = mssql_query($update);
                   if ($result) {
                       $realizouComSucesso = true;
                   }
                }
                if (count($diasCalendario) > count($diasDeAulaId)) {
                    $dataId = $this->retornaUltimoDiaDeAulaDoPerido($calendario, $periodosCurso[$i]);
                    
                    $dadosAula[0] = $dataId[0] + 1;
                    $dataNova = date('Y-m-d', strtotime("+$dadosArray[7] days",strtotime($dataId[1])));
                    $ano  = substr($dadosArray[4],0,4);
                    $dataFinalCalendario = $ano.'-12-31';
                    if ($dataNova > $dataFinalCalendario) {
                        break;
                    }
                    elseif($dataNova < $dataFinalCalendario){
                      $data = $dataNova; 
                      
                    }
                }
                elseif(count($diasCalendario) < count($diasDeAulaId)){
                    break;
                }
            }
            return $realizouComSucesso;
        } catch (Exception $ex) {
           echo 'Exceção capturada: ', $ex->getMessage(), "\n";
        }
    }
    public function retornDadosTurma($codFilial,$codTurma){
        $sql = "SELECT * FROM PHE_STURMA WHERE CODFILIAL = $codFilial AND CODIGOTURMA_CC = '$codTurma'";
        $result = mssql_query($sql);
        $dadosTurma = "";
        if (mssql_num_rows($result)) {
            while ($linha = mssql_fetch_array($result)) {
                $dadosTurma = array("CODTURMA" => $linha['CODIGOTURMA_CC'],
                                    "CODCURSO" => $linha['CODIGOCURSO_CC'],
                                    "RECESSO" => $linha['RECESSO_ENTRE_MODULO_CC'],
                                    "CODTURNO" => $linha['CODTURNO']);
            }
            return $dadosTurma;
        }
    }

    public function regeraDiasDeAulaTurma(CalendarioTurma $calendario){
        try {
            $realizouComSucesso = false;
            $dadosArray = array( "1" => $calendario->get_codFilial(),
                                 "2" => $calendario->get_codCurso(),
                                 "3" => $calendario->get_codTurma(),
                                 "4" => $calendario->get_dataInicial(),
                                 "5" => $calendario->get_codTurno(),
                                 "6" => $calendario->get_userCadastrante(),
                                 "7" => $calendario->get_diasRecesso()
                                );
            $dadosAula = $this->retornaIdDaAulaPorData($calendario);
            $data = $dadosArray[4];
            $periodosCurso = $this->retornaPeriodoSucessor($calendario,$dadosAula[1]);
            for ($i = 0; $i < count($periodosCurso); $i++) {
                $diasDeAulaId = $this->retornaArrayDeAulasDoPeriodo($calendario, $periodosCurso[$i],$dadosAula[0]);
                
                $diasCalendario = $this->retornaObjetoCalendarioEscola($calendario,$data);
                $limit = $this->retoraMenorArray($diasDeAulaId, $diasCalendario);
               
                for ($j = 0; $j < $limit; $j++) {
                    $calendarioEscola = $diasCalendario[$j];
                    $dados = array("1" => $calendarioEscola->get_dataDia(),
                               "2" => $calendarioEscola->get_diaDaSemana(),
                               "3" => $calendarioEscola->get_horaIni(),
                               "4" => $calendarioEscola->get_horaFini());
                    $update = "UPDATE PHE_CALENDARIO_TURMA  SET DATADIA = '$dados[1]', DIASEMANA = '$dados[2]', HORA_INICIAL = '$dados[3]', "
                            . "HORA_FINAL = '$dados[4]' WHERE CODFILIAL = $dadosArray[1] AND CODIGO_CURSO = '$dadosArray[2]' "
                            . "AND CODIGO_TURMA = '$dadosArray[3]' AND PERIODO_CURSO = $periodosCurso[$i] AND ID = $diasDeAulaId[$j]";
                    $result  = mssql_query($update);
                   if ($result) {
                       $realizouComSucesso = true;
                   }
                }
                if (count($diasCalendario) > count($diasDeAulaId)) {
                    $dataId = $this->retornaUltimoDiaDeAulaDoPerido($calendario, $periodosCurso[$i]);
                    
                    $dadosAula[0] = $dataId[0] + 1;
                    $dataNova = date('Y-m-d', strtotime("+$dadosArray[7] days",strtotime($dataId[1])));
                    $ano  = substr($dadosArray[4],0,4);
                    $dataFinalCalendario = $ano.'-12-31';
                    if ($dataNova > $dataFinalCalendario) {
                        break;
                    }
                    elseif($dataNova < $dataFinalCalendario){
                      $data = $dataNova; 
                      
                    }
                }
                elseif(count($diasCalendario) < count($diasDeAulaId)){
                    break;
                }
            }
            return $realizouComSucesso;
        } catch (Exception $ex) {
           echo 'Exceção capturada: ', $ex->getMessage(), "\n";
        }
    }
    /*public function geraProximoDia(CalendarioTurma $calendario) {
        try {
            $gerouComSucesso = false;
            $codFilial = $calendario->get_codFilial();
            $codCurso = $calendario->get_codCurso();
            $codTurma = $calendario->get_codTurma();
            $sql = "SELECT DISTINCT DATADIA, DIASEMANA FROM PHE_CALENDARIO_TURMA WHERE CODFILIAL = $codFilial AND CODIGO_CURSO = '$codCurso' "
                    . "AND CODIGO_TURMA = '$codTurma' AND DATADIA <> '' ORDER BY DATADIA";
            $result = mssql_query($sql);
            $dataDiaArray = array();
            $diaSemanaArray = array();
            if (mssql_num_rows($result)) {
                while ($linha = mssql_fetch_array($result)) {
                    $dataDiaArray[] = $linha['DATADIA'];
                    $diaSemanaArray[] = $linha['DIASEMANA'];
                }
                for ($index = 1; $index < count($dataDiaArray); $index++) {
                    $dataAnterior = $dataDiaArray[$index - 1];
                    $update = "UPDATE PHE_CALENDARIO_TURMA SET PROX_DATADIA = '$dataDiaArray[$index]', PROX_DIASEMANA = '$diaSemanaArray[$index]' "
                            . "WHERE CODFILIAL = $codFilial AND CODIGO_CURSO = '$codCurso' AND CODIGO_TURMA = '$codTurma' "
                            . "AND DATADIA = '$dataAnterior'";
                    
                    $result = mssql_query($update);
                    if ($result) {
                        $gerouComSucesso = true;
                    }
                }
            }
            return $gerouComSucesso;
        } catch (Exception $ex) {
            echo 'Exceção capturada: ', $ex->getMessage(), "\n";
        }
    }*/
private function retornaIdDaAulaPorData(CalendarioTurma $calendario){
        $codFilial = $calendario->get_codFilial();
        $codCurso = $calendario->get_codCurso();
        $codTurma = $calendario->get_codTurma();
        $data = $calendario->get_dataInicial();
        $sql = "SELECT TOP 1 * FROM PHE_CALENDARIO_TURMA WHERE CODFILIAL = $codFilial AND CODIGO_CURSO = '$codCurso' "
                . "AND CODIGO_TURMA = '$codTurma' AND DATADIA >= '$data'";
        $result = mssql_query($sql);
        $registro = array();
        if (mssql_num_rows($result)) {
            while ($linha = mssql_fetch_array($result)) {
               $registro[0] = $linha['ID'];
               $registro[1] = $linha['PERIODO_CURSO'];
               return $registro;
            }
        }
    }
    private function retornaIdDaAula(CalendarioTurma $calendario){
        $codFilial = $calendario->get_codFilial();
        $codCurso = $calendario->get_codCurso();
        $codTurma = $calendario->get_codTurma();
        $aula = $calendario->get_aula();
        $sql = "SELECT * FROM PHE_CALENDARIO_TURMA WHERE CODFILIAL = $codFilial AND CODIGO_CURSO = '$codCurso' "
                . "AND CODIGO_TURMA = '$codTurma' AND AULA = $aula";
        $result = mssql_query($sql);
        $registro = array();
        if (mssql_num_rows($result)) {
            while ($linha = mssql_fetch_array($result)) {
               $registro[0] = $linha['ID'];
               $registro[1] = $linha['PERIODO_CURSO'];
               return $registro;
            }
        }
    }
    private function retornaArrayDeAulasDoPeriodo(CalendarioTurma $calendario, $periodo,$id){
        $codFilial = $calendario->get_codFilial();
        $codCurso = $calendario->get_codCurso();
        $codTurma = $calendario->get_codTurma();
       
        $diasDeAulaId = array();
        $sql = "SELECT * FROM PHE_CALENDARIO_TURMA T WHERE T.CODFILIAL = $codFilial AND T.CODIGO_CURSO = '$codCurso' "
                . "AND T.PERIODO_CURSO = $periodo  AND T.CODIGO_TURMA = '$codTurma' AND ID >= $id ORDER BY T.ORDEM_DISCIPLINA";
        $result = mssql_query($sql);
        if (mssql_num_rows($result)) {
            while ($linha = mssql_fetch_array($result)) {
                $diasDeAulaId[] = $linha['ID'];
            }
            return $diasDeAulaId;
        }
    }
    private function retornaPeriodoSucessor(CalendarioTurma $calendario, $periodo){
        $codFilial = $calendario->get_codFilial();
        $codCurso = $calendario->get_codCurso();
        $selectPeriodo = "SELECT DISTINCT D.CODPERIODO_SDISCGRADE FROM PHE_CURSO_DSICIPLINA_ESCOLA D "
                . "WHERE D.CODFILIAL = $codFilial AND D.CODCURSO_SDISCGRADE = '$codCurso' AND D.CODPERIODO_SDISCGRADE >= $periodo ORDER BY D.CODPERIODO_SDISCGRADE";
        $result = mssql_query($selectPeriodo);
        $listaDePeriodos = array();
        if (mssql_num_rows($result)) {
            while ($linha = mssql_fetch_array($result)) {
                $listaDePeriodos[] = $linha['CODPERIODO_SDISCGRADE'];
            }
            return $listaDePeriodos;
        }
    }
    private function retornaUltimoDiaDeAulaDoPerido(CalendarioTurma $calendario,$periodo){
        $codFilial = $calendario->get_codFilial();
        $codCurso = $calendario->get_codCurso();
        $codTurma = $calendario->get_codTurma();
        $sql = "SELECT TOP 1 * FROM PHE_CALENDARIO_TURMA T  WHERE T.CODFILIAL = $codFilial AND T.CODIGO_CURSO = '$codCurso' "
                . "AND T.PERIODO_CURSO = $periodo AND T.CODIGO_TURMA = '$codTurma' ORDER BY T.ID DESC ";
        $result = mssql_query($sql);
        $ultimoId = 0;
        $ultimaData = "";
        if (mssql_num_rows($result)) {
            while ($linha = mssql_fetch_array($result)) {
                $ultimoId = $linha['ID'];
                $ultimaData = $linha['DATADIA'];
            }
            $dataId = array ($ultimoId,$ultimaData);
            return $dataId;
        }
    }
    private function retoraMenorArray($array1,$array2){
        if (count($array1) <= count($array2)) {
            return count($array1);
        }
        elseif(count($array1 >= count ($array2))){
            return count($array2);
        }
    }
    private function retornaPeriodos(CalendarioTurma $calendarioTurma){
        $codFilial = $calendarioTurma->get_codFilial();
        $codCurso = $calendarioTurma->get_codCurso();
        $selectPeriodo = "SELECT DISTINCT D.CODPERIODO_SDISCGRADE FROM PHE_CURSO_DSICIPLINA_ESCOLA D "
                . "WHERE D.CODFILIAL = $codFilial AND D.CODCURSO_SDISCGRADE = '$codCurso' ORDER BY D.CODPERIODO_SDISCGRADE";
        $result = mssql_query($selectPeriodo);
        $listaDePeriodos = array();
        if (mssql_num_rows($result)) {
            while ($linha = mssql_fetch_array($result)) {
                $listaDePeriodos[] = $linha['CODPERIODO_SDISCGRADE'];
            }
            return $listaDePeriodos;
        }
        
    }
    
    private function retornaDiasDeAulaDoPeriodo(CalendarioTurma $calendario,$periodo){
        $codFilial = $calendario->get_codFilial();
        $codCurso = $calendario->get_codCurso();
        $codTurma = $calendario->get_codTurma();
        $diasDeAulaId = array();
        $sql = "SELECT * FROM PHE_CALENDARIO_TURMA T WHERE T.CODFILIAL = $codFilial AND T.CODIGO_CURSO = '$codCurso' "
                . "AND T.PERIODO_CURSO = $periodo  AND T.CODIGO_TURMA = '$codTurma' ORDER BY T.ORDEM_DISCIPLINA";
        $result = mssql_query($sql);
        if (mssql_num_rows($result)) {
            while ($linha = mssql_fetch_array($result)) {
                $diasDeAulaId[] = $linha['ID'];
            }
            return $diasDeAulaId;
        }
    }
    private function retornaSqlEspecifico(CalendarioTurma $calendario,$data) {
        $codTurno = $calendario->get_codTurno();
        $codFilial = $calendario->get_codFilial();
        //$codTurno = $calendario->get_codTurno();
        //$data = $calendario->get_dataInicial();
        $campo = $this->retornaTipoCalendario($calendario);
        $listaDeDiasSemana = $this->retornaDiasDeAula($calendario);
        $quantidade = count($listaDeDiasSemana);
        $select = "";
        switch ($quantidade) {
            case 1:
               
                $select = "SELECT * FROM PHE_CALENDARIO_ESCOLA WHERE CODFILIAL = $codFilial AND CODTURNO = $codTurno "
                    . "AND $campo[0] = 0 AND $campo[1] = 1 AND DATADIA >= '$data' AND DIASEMANA = '$listaDeDiasSemana[0]' ORDER BY DATADIA";
                break;
            case 2:
                
                $select = "SELECT * FROM PHE_CALENDARIO_ESCOLA WHERE CODFILIAL = $codFilial AND CODTURNO = $codTurno "
                    . "AND $campo[0] = 0 AND $campo[1] = 1 AND DATADIA >= '$data' AND (DIASEMANA = '$listaDeDiasSemana[0]' OR DIASEMANA = '$listaDeDiasSemana[1]')";
                break;
            case 3:
                
                $select = "SELECT * FROM PHE_CALENDARIO_ESCOLA WHERE CODFILIAL = $codFilial AND CODTURNO = $codTurno "
                    . "AND $campo[0] = 0 AND $campo[1] = 1 AND DATADIA >= '$data' AND (DIASEMANA = '$listaDeDiasSemana[0]' OR DIASEMANA = '$listaDeDiasSemana[1]' "
                    . "OR DIASEMANA = '$listaDeDiasSemana[2]') ORDER BY DATADIA";
                break;
            case 4:
                
                $select = "SELECT * FROM PHE_CALENDARIO_ESCOLA WHERE CODFILIAL = $codFilial AND CODTURNO = $codTurno "
                    . "AND $campo[0] = 0 AND $campo[1] = 1 AND DATADIA >= '$data' AND (DIASEMANA = '$listaDeDiasSemana[0]' OR DIASEMANA = '$listaDeDiasSemana[1]' "
                    . "OR DIASEMANA = '$listaDeDiasSemana[2]' OR DIASEMANA = '$listaDeDiasSemana[3]') ORDER BY DATADIA";
                break;
             case 5:
              
                $select = "SELECT * FROM PHE_CALENDARIO_ESCOLA WHERE CODFILIAL = $codFilial AND CODTURNO = $codTurno "
                    . "AND $campo[0] = 0 AND $campo[1] = 1 AND DATADIA >= '$data' AND (DIASEMANA = '$listaDeDiasSemana[0]' OR DIASEMANA = '$listaDeDiasSemana[1]' "
                    . "OR DIASEMANA = '$listaDeDiasSemana[2]' OR DIASEMANA = '$listaDeDiasSemana[3]' OR DIASEMANA = '$listaDeDiasSemana[4]') ORDER BY DATADIA";
                break;
            case 6:
                
                $select = "SELECT * FROM PHE_CALENDARIO_ESCOLA WHERE CODFILIAL = $codFilial AND CODTURNO = $codTurno "
                    . "AND $campo[0] = 0 AND $campo[1] = 1 AND DATADIA >= '$data' AND (DIASEMANA = '$listaDeDiasSemana[0]' OR DIASEMANA = '$listaDeDiasSemana[1]' "
                    . "OR DIASEMANA = '$listaDeDiasSemana[2]' OR DIASEMANA = '$listaDeDiasSemana[3]' OR DIASEMANA = '$listaDeDiasSemana[4]' OR DIASEMANA = '$listaDeDiasSemana[5]') ORDER BY DATADIA";
                break;
        }
        return $select;     
   }
    private function retornaObjetoCalendarioEscola(CalendarioTurma $calendario,$data){
        $sql = $this->retornaSqlEspecifico($calendario,$data);
        $result = mssql_query($sql);
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
                return $tipoCalendar = array("FNL_SS","STATUS_SS",0);
            case 4:
                return $tipoCalendar = array("FNL_CTSS","STATUS_CTSS",0);
        }
    }
    public function inseriCargaHoraDisciplina($cargaHora,$codFilial,$disciplina){
        try {
            $update = "UPDATE PHE_CURSO_DSICIPLINA_ESCOLA SET SUBDISC_CH = $cargaHora WHERE CODFILIAL = $codFilial AND CODDISC_SDISCGRADE = '$disciplina'";
            $result = mssql_query($update);
            if ($result) {
                return true;
            }else{
                return false;
            }
        } catch (Exception $ex) {
            echo 'Exceção capturada: ', $ex->getMessage(), "\n";
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
    public function retornaListaIdDisciplina($codCurso){
        try {
            $select = "SELECT * FROM PHE_CURSO_DSICIPLINA CD "
                    . "WHERE CD.CODCURSO_SDISCGRADE = '$codCurso'";
            $result = mssql_query($select);
            $listaIdDisciplina = array();
            while ($linha = mssql_fetch_array($result)) {
                $calendario = new CursoDisciplina();
                $calendario->set_codDisciplina($linha['CODDISC_SDISCGRADE']);
                $calendario->set_ch($linha['CH_SDISCIPLINA_SDISCIPLINA']);
                $listaIdDisciplina[] = $calendario;
            }
            return $listaIdDisciplina;
        } catch (Exception $ex) {
            echo 'Exceção capturada: ', $ex->getMessage(), "\n";
        }
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
    private function retornaDiasDeAula(CalendarioTurma $calendarioTurma){
        $codTurma = $calendarioTurma->get_codTurma();
        $codFilial = $calendarioTurma->get_codFilial();
        $select  = "SELECT * FROM PHE_STURMA WHERE CODFILIAL = $codFilial AND CODIGOTURMA_CC = '$codTurma'";
        $result = mssql_query($select);
        while ($linha = mssql_fetch_array($result)) {
            $diasDeaula = $linha['DIASEMANA'];
        }
        $arrayDeDias = $array = (explode('-', $diasDeaula, -1));
        return $arrayDeDias;
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
