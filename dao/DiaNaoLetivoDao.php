<?php
/*
 * CLASSE DiaNaoLetivoDao
 * OJETIVO : RESPOSAVEL POR TODA A COMUNICACAO COM O BANCO DE DADOS
 * CRIADA : 25/08/2016
 * ULTIMA ATUALIZACAO : 14/09/2016
 * 
 * DS -> LEANDRO BRITO ;)
 */



//IMPORTANDO CLASSE CONEXAO COM BANCO
include_once './util/ConnectaBanco.php';
//IMPORTANTO CLASSE DIA NÃO LETIVO
include_once './entidades/DiaNaoLetivo.php';
include_once './entidades/CalendarioTurma.php';

class DiaNaoLetivoDao {

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
    public function insertDiaNaoLetivoProfessor(CalendarioProfessor $docente) {
        try {
            $data = $docente->get_dataDia();
            $codFilial = $docente->get_codigoFilial();
            $codDocente = $docente->get_codigoDocente();
            $descricao = $docente->get_descricao();
            $userCadastrante = $docente->get_userCadastrante();
            $codInativo = $codDocente.'_INAT';
            $sql = "INSERT INTO PHE_CALENDARIO_DOCENTE (CODFILIAL,DATADIA,CODIGODOCENTE,RECCREATEDBY,CODDESCRICAO,STATUS) "
                    . "VALUES ($codFilial,'$data',$codDocente,'$userCadastrante',$descricao,1)";
            $update = "UPDATE PHE_CALENDARIO_TURMA SET FNLD = '$codInativo', CODIGO_PROFESSOR = 0 WHERE CODFILIAL = $codFilial "
                    . "AND DATADIA = '$data' AND CODIGO_PROFESSOR = $codDocente";
            $result = mssql_query($sql);
            $resultUpdate = mssql_query($update);
            if ($result && $resultUpdate) {
                return true;
            }
            return false;
        } catch (Exception $ex) {
            echo 'Exceção capturada: ', $ex->getMessage(), "\n";
        }
    }
    public function removeDiaNaoLetivoProfessor(CalendarioProfessor $docente) {
        try {
            $data = $docente->get_dataDia();
            $codFilial = $docente->get_codigoFilial();
            $codDocente = $docente->get_codigoDocente();
            $codInativo = $codDocente.'_INAT';
            $delete = "DELETE FROM PHE_CALENDARIO_DOCENTE WHERE CODFILIAL = $codFilial "
                    . "AND CODIGODOCENTE = $codDocente AND DATADIA = '$data'";
            $update = "UPDATE PHE_CALENDARIO_TURMA SET CODIGO_PROFESSOR = $codDocente, FNLD = 0 "
                    . "WHERE FNLD = '$codInativo' AND CODFILIAL = $codFilial AND DATADIA = '$data'";
            $resutl = mssql_query($delete);
            $resultUpdate = mssql_query($update);
            if ($resultUpdate && $resutl) {
                return true;
            }
            return false;
        } catch (Exception $exc) {
            echo 'Exceção capturada: ', $exc->getMessage(), "\n";
        }
    }
    public function inseriDiaNaoLetivoTurma(DiaNaoLetivo $diaNaoLetivo, $codigoTurma) {
        try {
            $atributos = array("1" => $diaNaoLetivo->get_codFilial(),
                "2" => $diaNaoLetivo->get_dataInicial(),
                "3" => $diaNaoLetivo->get_dataFinal());
            $selec = "SELECT DISTINCT DATADIA, ID FROM PHE_CALENDARIO_TURMA WHERE CODIGO_TURMA = '$codigoTurma' "
                    . "AND DATADIA BETWEEN '$atributos[2]' AND '$atributos[3]' AND CODFILIAL = $atributos[1] "
                    . "ORDER BY DATADIA";
            $result = mssql_query($selec);
            $listaCalendarioTurma = array();
            $ultimoId = "";
            if (mssql_num_rows($result)) {
                while ($linha = mssql_fetch_array($result)) {
                    $calendario = new CalendarioTurma();
                    $calendario->set_dataInicial($linha['DATADIA']);
                    $calendario->set_id($linha['ID']);
                    $listaCalendarioTurma[] = $calendario;
                    $ultimoId = $linha['ID'];
                }
                $lista[0] = $listaCalendarioTurma;
                $lista[1] = $this->retornaCalendarioTurma($ultimoId, $codigoTurma, $atributos[1]);
                return $lista;
            }
        } catch (Exception $ex) {
            echo 'Exceção capturada: ', $e->getMessage(), "\n";
        }
    }

    private function retornaCalendarioTurma($id, $codigoTurma, $codFilial) {
        $select = "SELECT TOP 1 * FROM PHE_CALENDARIO_TURMA WHERE CODFILIAL = $codFilial AND CODIGO_TURMA = '$codigoTurma' "
                . "AND ID > $id";
        $resulado = mssql_query($select);
        while ($registro = mssql_fetch_array($resulado)) {
            $calendarioTurma = new CalendarioTurma();
            $calendarioTurma->set_dataInicial($registro['DATADIA']);
            $calendarioTurma->set_codCurso($registro['CODIGO_CURSO']);
            $calendarioTurma->set_codTurma($registro['CODIGO_TURMA']);
            $calendarioTurma->set_id($registro['ID']);
            return $calendarioTurma;
        }
        ;
    }

    //FUNCAO QUE INSERI DADOS NO BANCO
    public function inseriDiaNaoLetivo(DiaNaoLetivo $diaNaoLetivo) {
        //ARRAY COM TODOS OS DADOS DO OBJETO DIANAOLETIVO
        $arrayDados = array(
            $diaNaoLetivo->get_descricao(), $diaNaoLetivo->get_data(),
            $diaNaoLetivo->get_status(),$diaNaoLetivo->get_usuarioCadastrante(),$diaNaoLetivo->get_tipo()
        );
        // SELECT NO BANCO SQL 
      $meDia = $rest = substr($diaNaoLetivo->get_data(), 5, 9);
        if (!$this->verificaSeDataExiste($meDia,$diaNaoLetivo->get_codFilial())) {
            $select = "INSERT dbo.PHE_DIAS_NAO_LETIVOS (DESCRICAO,DATADIA,STATUS,RECCREATEDBY,TIPO)"
                    . "VALUES ($arrayDados[0],'$arrayDados[1]',$arrayDados[2],'$arrayDados[3]',$arrayDados[4])";
            $sucesso = mssql_query($select);
            if ($sucesso) {
               return 2;
            } else {
                return 505;
            }
        } 
        elseif($this->verificaSeDataExiste($meDia,$diaNaoLetivo->get_codFilial())){
            return 5;
        }
    }
    //METODO QUE INSERI PERIODO NÃO LETIVO, SOMENTE PARA CURSO TECNICOS
    public function inseriPeridoNaoLetivo($dataInicial, $dataFinal, $descricao, $codFilial){
       $update = "UPDATE dbo.PHE_CALENDARIO_ESCOLA SET DESCRICAO_CT = $descricao, DESCRICAO_CTSS = $descricao, STATUS_CT  = 0, DLETIVO_CT = 0, HDLETIVO_CT = 0, FNL_CT = 1, STATUS_CTSS = 0, DLETIVO_CTSS = 0, HDLETIVO_CTSS = 0, FNL_CTSS = 1 WHERE DATADIA BETWEEN '$dataInicial' AND '$dataFinal' AND CODFILIAL = $codFilial";
       $result = mssql_query($update);
       if ($result) {
            return true;
        }
        else{
            return false;
        }
    }
    //FUNCAO QUE FECHA BANCO
    public function fechaBanco() {
        mssql_close($this->conexao);
    }
    // METODO QUE INSERI PERIDO NAO LETIVO PARA TODA ESCOLA
    public function inseriDiaNaoLetivoPorPerido($codFilial,$dataInicial, $dataFinal,$descricao){
        $update = "UPDATE dbo.PHE_CALENDARIO_ESCOLA SET STATUS = 0, FNL = 1, STATUS_CT = 0, FNL_CT = 1, DESCRICAO = $descricao, DESCRICAO_CT = $descricao, STATUS_SS = 0, FNL_SS = 1, DESCRICAO_SS = $descricao, STATUS_CTSS = 0, FNL_CTSS = 1, DESCRICAO_CTSS = $descricao WHERE DATADIA BETWEEN '$dataInicial' AND '$dataFinal' AND CODFILIAL = $codFilial";
        $restult = mssql_query($update);
        if ($restult) {
            return true;
        }
        else{
            return false;
        }
    }
    //METODO QUE INSERI DIA LETIVO POR TURNO, PARA TODA A ESCOLA
    public function inseriDiaNaoLetivoPorTurno(DiaNaoLetivo $diaNaoLetivo){
        $arrayDados = array(
            $diaNaoLetivo->get_codFilial(),$diaNaoLetivo->get_codTurno(),$diaNaoLetivo->get_dataInicial(),
            $diaNaoLetivo->get_dataFinal(),$diaNaoLetivo->get_descricao()
        );
        $update = "UPDATE dbo.PHE_CALENDARIO_ESCOLA SET DESCRICAO = $arrayDados[4],DESCRICAO_CT = $arrayDados[4], STATUS = 0,STATUS_CT = 0, FNL = 1, FNL_CT = 1, STATUS_SS = 0, FNL_SS = 1, STATUS_CTSS = 0, FNL_CTSS = 1 WHERE DATADIA BETWEEN '$arrayDados[2]' AND '$arrayDados[3]' AND CODTURNO = $arrayDados[1] AND CODFILIAL = $arrayDados[0]";
        $result = mssql_query($update);
        if($result){
            return true;
        }
        else{
            return false;
        }
    }
    public function calendarioExite($codFilial){
        $select = "SELECT * FROM PHE_CALENDARIO_ESCOLA WHERE CODFILIAL = $codFilial";
        $result = mssql_query($select);
        if(mssql_num_rows($result)){
            return 1;
        }
        else{
            return 0;
        }
    }
    //FUNCAO QUE DELETA DIA LETIVO
    public function deletaDiaNaoLetivo($id, $codFilial){
        $select = "SELECT * FROM PHE_DIAS_NAO_LETIVOS WHERE STATUS = 1 AND ID = $id";
        $resultado = mssql_query($select);
        $diaMes = "";
        if (mssql_num_rows($resultado)) {
            while ($linha = mssql_fetch_array($resultado)) {
                $diaMes = substr($linha['DATADIA'], 5, 9);
            }
            if ($this->atualizaCalendarioAposDeleteFeriado($diaMes,$codFilial)) {
                $delete = "DELETE FROM PHE_DIAS_NAO_LETIVOS WHERE ID = $id";
                $resultado = mssql_query($delete);
                return true;
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
    }
    private function atualizaCalendarioAposDeleteFeriado($diaMes, $codFilial){
        $update = "UPDATE dbo.PHE_CALENDARIO_ESCOLA SET DESCRICAO = 1, DESCRICAO_CT = 1, DESCRICAO_SS = 1, DESCRICAO_CTSS = 1, FNL = 0, FNL_CT =0, FNL_SS = 0, FNL_CTSS = 0,"
                . " STATUS = 1, STATUS_CT = 1, STATUS_SS = 1, STATUS_CTSS = 1 WHERE DATADIA LIKE '%$diaMes' AND CODFILIAL = $codFilial";
        $resultado = mssql_query($update);
        if ($resultado) {
            return true;
        }
        else{
            return false;
        }
    }
    // FUNCAO QUE VERIFICA SE DATA DO DIA NOA LETIVO JA EXISTE
    private function verificaSeDataExiste($data, $codFilial) {
        //$contador = 0;
       $sql = "SELECT * FROM PHE_DIAS_NAO_LETIVOS WHERE DATA LIKE '%-$data' AND (TIPO = $codFilial OR TIPO = 0)";
       $result = mssql_query($sql);
        if (mssql_num_rows($result)) {
            return true;
        } else {
           return false;
        }
    }

}
