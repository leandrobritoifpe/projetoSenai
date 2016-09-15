<?php

/* ARQUVOS CadastraDiaNaoLetivo
 * OBJETIVO: SERVIR DE CONTROLE PARA O DAO
 * CRIADA: 14/08/2016
 * ULTIMA ATUALIZACAO : 15/09/2016
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
                    $insert = "INSERT dbo.PHE_CALENDARIO_DOCENTE (CODIGODOCENTE,CODFILIAL,QDEHORAS,DESCRICAO,DATADIA,DIASEMANA,FNL,RECCREATEDBY) "
                            ."VALUES ($dadosDoCalendario[0],$dadosDoCalendario[1],$dadosDoCalendario[2],1,'$dias[0]','$dias[1]',$dias[2],'$userCadastrante')";
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
    private function retornaArrayDeObjetos(CalendarioProfessor $calendario) {
        $codigoFilial = $calendario->get_codigoFilial();
        $codigoDocente = $calendario->get_codigoDocente();
        $ano = $calendario->get_ano();
        $select = "SELECT * FROM PHE_SPROFESSOR WHERE CODFILIAL = $codigoFilial AND CODIGO = $codigoDocente";
        $resultado = mssql_query($select);
        $listaDeCalendarioDocente = array();
        $listaDeDias = array();
        $arrayDeObjetos = array();
        $i = 0;
        while ($linha = mssql_fetch_array($resultado)) {
            $calendarioDocente = new CalendarioProfessor();
            $calendarioDocente->set_codigoDocente($linha['CODIGO']);
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
