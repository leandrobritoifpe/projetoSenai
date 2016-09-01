<?php
/*
 * CLASSE DiaNaoLetivoDao
 * OJETIVO : RESPOSAVEL POR TODA A COMUNICACAO COM O BANCO DE DADOS
 * CRIADA : 25/08/2016
 * ULTIMA ATUALIZACAO : 31/08/2016
 * 
 * DS -> LEANDRO BRITO ;)
 */



//IMPORTANDO CLASSE CONEXAO COM BANCO
include_once './util/ConnectaBanco.php';
//IMPORTANTO CLASSE DIA NÃO LETIVO
include_once './entidades/DiaNaoLetivo.php';

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

    //FUNCAO QUE INSERI DADOS NO BANCO
    public function inseriDiaNaoLetivo(DiaNaoLetivo $diaNaoLetivo) {
        //ARRAY COM TODOS OS DADOS DO OBJETO DIANAOLETIVO
        $arrayDados = array(
            $diaNaoLetivo->get_descricao(), $diaNaoLetivo->get_data(), $diaNaoLetivo->get_horaInicial(), $diaNaoLetivo->get_horaFinal(),
            $diaNaoLetivo->get_codTurno(), $diaNaoLetivo->get_codFilial(), $diaNaoLetivo->get_status(), $diaNaoLetivo->get_diaSemana(),$diaNaoLetivo->get_usuarioCadastrante()
        );
        // SELECT NO BANCO SQL 
        $meDia = $rest = substr($diaNaoLetivo->get_data(), 5, 9);
        if ($this->verificaSeDataExiste($meDia, $arrayDados[5]) == 1) {
            return 5;
        } 
        elseif($this->verificaSeDataExiste($meDia,$arrayDados[5]) == 0){
            // INSERT NO BANCO SQL 
            $select = "INSERT dbo.PHE_DIAS_NAO_LETIVOS (DESCRICAO,DATA,HORINI,HORFIM,CODTURNO,CODFILIAL,CODLETIVO,STATUS,DIASEMANA,RECCREATEDBY)"
                    . "VALUES ($arrayDados[0],'$arrayDados[1]','$arrayDados[2]','$arrayDados[3]',$arrayDados[4],$arrayDados[5],0,'$arrayDados[6]','$arrayDados[7]','$arrayDados[8]')";
            $sucesso = mssql_query($select);
            if ($sucesso) {
                
                $mesDia = $rest = substr($diaNaoLetivo->get_data(), 5, 9);
                //UPDATE NO BANCO SQL SERVER
                $update = "UPDATE dbo.PHE_CALENDARIO_ESCOLA SET STATUS = 0, FNL = 1, FNL_CT = 1, DESCRICAO = $arrayDados[0], STATUS_CT = 0, DESCRICAO_CT = $arrayDados[0] WHERE DATADIA LIKE '%$mesDia' AND CODFILIAL = $arrayDados[5]";
                $sucesso = mssql_query($update);
                if ($sucesso) {
                    return 2;
                } else {
                    return 3;
                }
            } else {
                return 505;
            }
        }
    }
    public function inseriPeridoNaoLetivo($dataInicial, $dataFinal, $descricao, $codFilial){
       $update = "UPDATE dbo.PHE_CALENDARIO_ESCOLA SET DESCRICAO_CT = $descricao, STATUS_CT  = 0, DLETIVO_CT = 0, HDLETIVO_CT = 0, FNL_CT = 1 WHERE DATADIA BETWEEN '$dataInicial' AND '$dataFinal' AND CODFILIAL = $codFilial";
       $result = mssql_query($update);
       if ($result) {
            return 7;
        }
        else{
            return 505;
        }
    }
    //FUNCAO QUE FECHA BANCO
    public function fechaBanco() {
        mssql_close($this->conexao);
    }
    public function inseriDiaNaoLetivoPorPerido($codFilial,$dataInicial, $dataFinal,$descricao){
        $update = "UPDATE dbo.PHE_CALENDARIO_ESCOLA SET STATUS = 0, FNL = 1, STATUS_CT = 0, FNL_CT = 1, DESCRICAO = $descricao, DESCRICAO_CT = $descricao WHERE DATADIA BETWEEN '$dataInicial' AND '$dataFinal' AND CODFILIAL = $codFilial";
        $restult = mssql_query($update);
        if ($restult) {
            return 7;
        }
        else{
            return 505;
        }
    }
    
    // FUNCAO QUE VERIFICA SE DATA DO DIA NOA LETIVO JA EXISTE
    private function verificaSeDataExiste($data, $codFilial) {
        $contador = 0;
        $sql = mssql_query("SELECT * FROM PHE_DIAS_NAO_LETIVOS WHERE DATA LIKE '%$data' AND CODFILIAL = $codFilial");
        if ($sql) {
            while ($row = mssql_fetch_array($sql)) {
                $contador ++;
            }
            if ($contador != 0) {
                return 1;
            } else {
                return 0;
            }
        } else {
            return 505;
        }
    }

}
