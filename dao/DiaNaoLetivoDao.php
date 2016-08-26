<?php
//IMPORTANDO CLASSE CONEXAO COM BANCO
include_once './util/ConnectaBanco.php';
//IMPORTANTO CLASSE DIA NÃO LETIVO
include_once './entidades/DiaNaoLetivo.php';

class DiaNaoLetivoDao {
    
    private $conexao;

    // CRIANDO O METODO DA CONEXAO
    public function tentaConexao() {
        try {
            $con = new ConnectaBanco();
            $this->conexao = $con->conectandoComBanco();
        } catch (Exception $e) {
            echo 'Exceção capturada: ', $e->getMessage(), "\n";
        }
    }
    //FUNCAO QUE INSERI DADOS NO BANCO
    public function inseriDiaNaoLetivo(DiaNaoLetivo $diaNaoLetivo) {
      
        $this->tentaConexao();
        $arrayDados = array(
            $diaNaoLetivo->get_descricao(), $diaNaoLetivo->get_data(), $diaNaoLetivo->get_horaInicial(), $diaNaoLetivo->get_horaFinal(),
            $diaNaoLetivo->get_codTurno(), $diaNaoLetivo->get_codFilial(), $diaNaoLetivo->get_status(), $diaNaoLetivo->get_diaSemana()
        );
        // SELECT NO BANCO SQL SERVER
        $select = "INSERT dbo.PHE_DIAS_NAO_LETIVOS (DESCRICAO,DATA,HORINI,HORFIM,CODTURNO,CODFILIAL,CODLETIVO,STATUS,DIASEMANA)"
                . "VALUES ('$arrayDados[0]','$arrayDados[1]','$arrayDados[2]','$arrayDados[3]',$arrayDados[4],$arrayDados[5],0,'$arrayDados[6]','$arrayDados[7]')";
        $sucesso = mssql_query($select);
        
        if ($sucesso) {
            $mesDia = $rest = substr($diaNaoLetivo->get_data(), 5, 9);
            //UPDATE NO BANCO SQL SERVER
            $update = "UPDATE dbo.PHE_CALENDARIO_ESCOLA SET STATUS = 'I', DESCRICAO = '$arrayDados[0]' WHERE DATADIA LIKE '%$mesDia';";
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
    public function fechaBanco(){
        mssql_close($this->conexao);
    }

}
