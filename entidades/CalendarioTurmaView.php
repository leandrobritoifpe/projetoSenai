

<?php
/*
 * CLASSE CalendarioEscolarDao
 * OBJETIVO: REALIZAR TODA AS COMUNICAÇOES COM O BANCO DE DADOS SQL SERVER
 * CRIADA: 07/10/2016
 * ULTIMA ATUALIZACAO :14/10/2016
 * 
 * DS-> LEANDRO BRITO
 */
 include_once './util/conectaBanco.php';
class CalendarioTurmaView {
    public $codFilial;
    public $dia;
    public $mes;
    public $ano;
    public $tstamp;
    public $dtmanip;
    public $dsprimdia;
    public $linhafechada;
    public $turma;
    public $cor;
    public function geraCalendario($pmes, $pano, $codFilial,$turma,$cor) {
        $this->cor = $cor;
        $this->turma = $turma;
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
    public function verificaData($codFilial, $mes, $dia,$turma,$ano){
        $tamandoDaString = strlen($dia);
        $tamandoDaStringMes = strlen($mes);
        $select = "";
        $cont = 0;
        $status = 0;
        $corProfe = array();
        $corProfe[0] = $this->cor;
        $corProfe[2] =  0;
        include_once './util/includeBanco.php';
        
        if ($tamandoDaString != 2 && $tamandoDaStringMes != 2) {
            
             $select = "SELECT * FROM PHE_CALENDARIO_TURMA WHERE CODIGO_TURMA= '$turma' AND DATADIA LIKE '$ano-0$mes-0$dia' AND CODFILIAL = $codFilial";
             $resultado = mssql_query($select);
             while ($linha = mssql_fetch_array($resultado)) {
                $cont ++; 
                $corProfe[0] = $linha['COR_PROFESSOR'];
                $corProfe[2] += $cont;
             }
             if ($cont != 1 && $cont != 0) {
                 return $corProfe;
             }
             else{
                 return $corProfe;
             }
        }
        elseif($tamandoDaString == 2 && $tamandoDaStringMes != 2){
             $select = "SELECT * FROM PHE_CALENDARIO_TURMA WHERE DATADIA LIKE '$ano-0$mes-$dia' AND CODFILIAL = $codFilial AND CODIGO_TURMA= '$turma'";
             $resultado = mssql_query($select);
             while ($linha = mssql_fetch_array($resultado)) {
                 $cont ++; 
                $corProfe[0] = $linha['COR_PROFESSOR'];
                $corProfe[2] += $cont;
                 
             }
             if ($cont != 0 && $cont != 1) {
                 return $corProfe;
             }
             else{
                return $corProfe;
             }
        }
        elseif($tamandoDaString == 2 && $tamandoDaStringMes == 2){
              $select = "SELECT * FROM PHE_CALENDARIO_TURMA WHERE DATADIA LIKE '$ano-$mes-$dia' AND CODFILIAL = $codFilial AND CODIGO_TURMA= '$turma'";
                     
             $resultado = mssql_query($select);
              while ($linha = mssql_fetch_array($resultado)) {
                 $cont ++; 
                $corProfe[0] = $linha['COR_PROFESSOR'];
                $corProfe[2] += $cont;
                 
             }
             if ($cont != 0 && $cont != 1) {
                 return $corProfe;
             }
             else{
                 return $corProfe;
             }
             
        }
        elseif($tamandoDaString == 1 && $tamandoDaStringMes == 2){
              $select = "SELECT * FROM PHE_CALENDARIO_TURMA WHERE DATADIA LIKE '$ano-$mes-0$dia' AND CODFILIAL = $codFilial AND CODIGO_TURMA= '$turma'";
                     
             $resultado = mssql_query($select);
             while ($linha = mssql_fetch_array($resultado)) {
                 $cont ++; 
                $corProfe[0] = $linha['COR_PROFESSOR'];
                $corProfe[2] += $cont;
                 
             }
             if ($cont != 0 && $cont != 1) {
                 return $corProfe;
             }
             else{
                 return $corProfe;
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
                $recebeFuncao = $this->verificaData($this->codFilial, $this->mes, $this->dia,  $this->turma,$this->ano);
               if($recebeFuncao[2] != 0){
                   $color = $recebeFuncao[0];
                   echo "<td align='center' style='background-color:$color;'>\n";
               echo $this->dia."";
               echo "</td>\n";
               $this->proximo_dia();
               }else{
                   echo "<td align='center' style = 'color:black;'>\n";
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
