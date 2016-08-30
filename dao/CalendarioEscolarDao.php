<?php
/*
 * CLASSE CalendarioEscolarDao
 * OBJETIVO: REALIZAR TODA AS COMUNICAÇOES COM O BANCO DE DADOS SQL SERVER
 * CRIADA: 25/08/2016
 * ULTIMA ATUALIZACAO : 26/08/2016
 * 
 * DS-> LEANDRO BRITO
 */


// IMPORTANDO A CLASS QUE TEM A CONEXAO COM BANCO DE DADOS
include_once './util/ConnectaBanco.php';
//IMPORTANDO A CLASSE DA ENTIDADE
include_once './entidades/CalendarioEscolar.php';

class CalendarioEscolarDao {

    private $conexao;

    // CRIANDO O METODO DA CONEXAO
    public function abrirConexao() {
        try {
            $con = new ConnectaBanco();
            $this->conexao = $con->conectandoComBanco();
        } catch (Exception $e) {
            echo 'Exceção capturada: ', $e->getMessage(), "\n";
        }
    }
    
    // FUNCAO QUE GERA CALENDARIO
    public function geraCaledario(CalendarioEscolar $calendarioEscolar) {

        $arrayHoraIni = array();
        $arrayHoraFini = array();
        $arrayAula = array();
        $arrayCodigoTurno = array();
        $cont = 0;
        
        //ARRAY DE OBJETOS CALENDARIOESCOLAR
        $arrayDados = array($calendarioEscolar->get_descricao(), $calendarioEscolar->get_dataDia(), $calendarioEscolar->get_codFilial(),
            $calendarioEscolar->get_status(), $calendarioEscolar->get_nomeDoDia(), $calendarioEscolar->get_diaDaSemana());

        //SELECT PARA TRAZER DADOS
        $sql = "SELECT
            H.CODHOR,
            H.CODTURNO,
            H.DIASEMANA,
            H.HORAINICIAL,
            H.HORAFINAL,
            H.AULA,
            T.CODFILIAL,
            T.CODTURNO
            
        FROM
                dbo.PHE_SHORARIO H INNER JOIN dbo.PHE_STURNO T ON H.CODTURNO = T.CODTURNO
                WHERE 
            (T.CODFILIAL = '$arrayDados[2]') AND
           (H.DIASEMANA = '$arrayDados[5]')";

        // EXECUTANDO O SELECT
        $result = mssql_query($sql);
        if ($result) {
            while ($linha = mssql_fetch_array($result)) {
                $arrayHoraIni[] = $linha['HORAINICIAL'];
                $arrayHoraFini[] = $linha['HORAFINAL'];
                $arrayAula[] = $linha['AULA'];
                $arrayCodigoTurno[] = $linha['CODTURNO'];
            }
            for ($index = 0; $index < count($arrayCodigoTurno); $index++) {
                
                //INSERT NO BANCO DE DADOS SQL
               $insert = "INSERT dbo.PHE_CALENDARIO_ESCOLA (DESCRICAO,DATADIA,HORINI,HORFIM,CODTURNO,CODFILIAL,DLETIVO,STATUS,DIASEMANA,AULA,FNL,HDLETIVO)"
                        . "VALUES ('$arrayDados[0]','$arrayDados[1]','$arrayHoraIni[$index]','$arrayHoraFini[$index]',$arrayCodigoTurno[$index],$arrayDados[2],0,'$arrayDados[3]','$arrayDados[4]','$arrayAula[$index]',0,0)";
               $result = mssql_query($insert);
                if ($result) {
                    $cont++;
                }
            }
            return $cont;
        } else {
            return 0;
        }
    }
    //FUNCAO QUE FECHA BANCO
    public function fechaBanco() {
        mssql_close($this->conexao);
    }

}
