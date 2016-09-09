

<?php
/*
 * CLASSE CalendarioEscolarDao
 * OBJETIVO: REALIZAR TODA AS COMUNICAÇOES COM O BANCO DE DADOS SQL SERVER
 * CRIADA: 05/09/2016
 * ULTIMA ATUALIZACAO : 05/09/2016
 * 
 * DS-> LEANDRO BRITO
 */
 include_once './util/conectaBanco.php';
class Calendario {
    public $codFilial;
    public $dia;
    public $mes;
    public $ano;
    public $tstamp;
    public $dtmanip;
    public $dsprimdia;
    public $linhafechada;
    public $turno;
    
    public function geraCalendario($pmes, $pano, $codFilial,$turno) {
        $this->turno = $turno;
        $this->codFilial = $codFilial;
        $this->linhafechada = true;
        $this->dia = 1;
        $this->mes = $pmes;
        $this->ano = $pano;
        $this->calcula_tstamp();
        $this->data_manipulavel();
        $this->primeiro_dia_mes();
        $this->exibe_calendario();
    }
    public function verificaData($codFilial, $mes, $dia,$turno){
        $tamandoDaString = strlen($dia);
        $tamandoDaStringMes = strlen($mes);
        $mes;
        $select = "";
        $cont = 0;
        
        $servidor = "52.34.253.148";
        $usuario = "pe";
        $banco = "DBSystemSec";
        $senha = "!@#123qwe";
//NÃ£o Alterar abaixo:
        $conmssql = mssql_connect($servidor, $usuario, $senha);
        $db = mssql_select_db($banco, $conmssql);
        $cont = 0;
        if ($conmssql && $db) {
            $cont += 1;
        }
        if ($cont == 0) {
            echo "<script>window.location='index.php';alert('ERRO AO SE CONNECTAR COM O BANCO');</script>";
        }
        if ($tamandoDaString != 2 && $tamandoDaStringMes != 2) {
             $select = "SELECT * FROM PHE_CALENDARIO_ESCOLA WHERE FNL = 1 AND DATADIA LIKE '%0$mes-0$dia' AND CODFILIAL = $codFilial AND CODTURNO = $turno";
             $resultado = mssql_query($select);
             while ($linha = mssql_fetch_array($resultado)) {
                 $cont ++;
             }
             if ($cont != 1 && $cont != 0) {
                 return 1;
             }
             else{
                 return 0;
             }
        }
        elseif($tamandoDaString == 2 && $tamandoDaStringMes != 2){
             $select = "SELECT DATADIA FROM PHE_CALENDARIO_ESCOLA WHERE FNL = 1 AND DATADIA LIKE '%0$mes-$dia' AND CODFILIAL = $codFilial AND CODTURNO = $turno";
             $resultado = mssql_query($select);
             while ($linha = mssql_fetch_array($resultado)) {
                 $cont ++;
             }
             if ($cont != 0 && $cont != 1) {
                 return 1;
             }
             else{
                 return 0;
             }
        }
        elseif($tamandoDaString == 2 && $tamandoDaStringMes == 2){
             $select = "SELECT DATADIA FROM PHE_CALENDARIO_ESCOLA WHERE FNL = 1 AND DATADIA LIKE '%$mes-$dia' AND CODFILIAL = $codFilial AND CODTURNO = $turno";
             $resultado = mssql_query($select);
             while ($linha = mssql_fetch_array($resultado)) {
                 $cont ++;
             }
             if ($cont != 0 && $cont != 1) {
                 return 1;
             }
             else{
                 return 0;
             }
        }
       
    }
    public function calcula_tstamp() {
        $this->tstamp = mktime(0, 0, 0, $this->mes, $this->dia, $this->ano);
    }

    public function data_manipulavel() {
        $this->dtmanip = getdate($this->tstamp);
    }

    public function primeiro_dia_mes() {
        $this->dsprimdia = $this->dtmanip["wday"];
    }

    public function proximo_dia() {
        $this->dia++;
        $this->calcula_tstamp();
    }

  public function exibe_calendario() {
         $larg = 100.0/7.0;
         echo "<table border='1' width='100%' cellpadding='0' cellspacing='0' align='center' bordercolor='#333333'>\n";
         echo "<tr class='titulotabela'>\n";
         echo "<td align='center' width='".$larg."%'>Dom</td>\n";         
         echo "<td align='center' width='".$larg."%'>Seg</td>\n";
         echo "<td align='center' width='".$larg."%'>Ter</td>\n";         
         echo "<td align='center' width='".$larg."%'>Qua</td>\n";
         echo "<td align='center' width='".$larg."%'>Qui</td>\n";         
         echo "<td align='center' width='".$larg."%'>Sex</td>\n";
         echo "<td align='center' width='".$larg."%'>Sab</td>\n";         
         echo "</tr>\n";
         
         $ccol = 0;
         $casa = 0;
         while( checkdate( $this->mes, $this->dia, $this->ano ) ) {
            if ( $this->linhafechada ) {
               echo "<tr>\n";
               $this->linhafechada = false;
            }
            if ( $casa < $this->dsprimdia ) {
               echo "<td> </td>\n";
            } else {
               $recebeFuncao = $this->verificaData($this->codFilial, $this->mes, $this->dia,  $this->turno);
               if($recebeFuncao == 1){
                   echo "<td align='center' style='color:red;'>\n";
               echo $this->dia."";
               echo "</td>\n";
               $this->proximo_dia();
               }else{
                   echo "<td align='center' style = 'color:blue;'>\n";
                   echo $this->dia."\n";
               echo "</td>\n";
               $this->proximo_dia();
               }
               
            }
            $ccol++;
            $ccol = $ccol % 7;
            $casa++;
            if ( ( $casa % 7 ) == 0 ) {
               echo "</tr>\n";
               $this->linhafecha = true;
            }
         }
         while( $ccol != 0 ) {
            $ccol++;
            $ccol = $ccol % 7;
            echo "<td> </td>\n";
         }
         echo "</tr>\n";
         
         echo "</table>\n";
      }

}

?>
