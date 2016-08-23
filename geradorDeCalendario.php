<?php

if (isset($_POST['DATAFIN'])) {
 $servidor = "52.34.253.148";
$usuario = "pe";
$banco = "DBSystemSec";
$senha = "!@#123qwe";
//NÃ£o Alterar abaixo:
$conmssql = mssql_connect($servidor.":1433",$usuario,$senha);
$db = mssql_select_db($banco, $conmssql);
if ($conmssql && $db){
echo "Parabens!! A conexÃ£o ao banco de dados ocorreu normalmente!";
} else {
echo "Nao foi possivel conectar ao banco MSSQL";
}

 

    
   echo $dataInicial = $_POST['DATAINI'];
   echo $dataFinal = $_POST['DATAFIN'];
   
   
   echo "teste2";
   
   
   $arrayHoraIni = array();
   $arrayHoraFini = array();
   $arrayAula = array();
   $arrayCodigoTurno = array();

   //$horaPulo = 0;
   //$horaAnterior = 0;
    for ($i = strtotime($dataInicial); $i <= strtotime($dataFinal); $i = $i + 86400) {
        //echo "teste";
      $i;
        echo "teste";
      $datai = date("d-m-Y", $i);
      $datai2 = date("Y-m-d", $i);

        
       $diaSemana = array(0, 1, 2, 3, 4, 5, 6);

       $diaSemanaNumero = date('w', strtotime($datai2));
        $ds = $diaSemana[$diaSemanaNumero];

        switch ($ds) {
            case"0": $diaSemana = "Dom";
                break;
            case"1": $diaSemana = "Seg";
                break;
            case"2": $diaSemana = "Ter";
                break;
            case"3": $diaSemana = "Qua";
                break;
            case"4": $diaSemana = "Qui";
                break;
            case"5": $diaSemana = "Sex";
                break;
            case"6": $diaSemana = "Sab";
                break;
        }


        switch ($diaSemana) {
            case "Seg":
               echo $sql = "select * from PHE_SHORARIO h where h.CODTURNO = 1 and h.DIASEMANA = 2;";
                $result = mysql_query($sql);
                if ($result) {
                    while ($linha = mysql_fetch_array($result)) {
                        $arrayHoraIni[] = $linha['HORINI'];
                        $arrayHoraFini[] = $linha['HORFIM'];
                        $arrayAula[] = $linha['AULA'];
                        $arrayCodigoTurno[] = $linha['CODTURNO'];
                    }
                    for ($index = 0; $index < count($arrayCodigoTurno);$index++) {
                    echo   $sql = "INSERT INTO PHE_CALENDARIO_ESCOLA (DATA,HORINI,HORFIM,THORAAULA,CODTURNO,CODFILIAL,CODLETIVO,STATUS,DIASSEMANA) "
                               . "VALUES ('$datai2',$arrayHoraIni[$index]','$arrayHoraFini[$index]','01:00:00.0000000')','$arrayCodigoTurno[$index]',3,1,'A','SEGUNDA')";
                    }   
                   
                }
                break;

            default:
                break;
        }
    }
}

