<?php

if (isset($_POST['DATAFIN'])) {
    include './gerenciadorDeFuncoes.php';
 $servidor = "52.34.253.148";
$usuario = "pe";
$banco = "DBSystemSec";
$senha = "!@#123qwe";
//NÃ£o Alterar abaixo:
$conmssql = mssql_connect($servidor,$usuario,$senha);
$db = mssql_select_db($banco, $conmssql);
if ($conmssql && $db){
echo "Parabens!! A conexÃ£o ao banco de dados ocorreu normalmente!";
} else {
echo "Nao foi possivel conectar ao banco MSSQL";
}
   $dataInicial = $_POST['DATAINI'];
   $dataFinal = $_POST['DATAFIN'];
   
   //$horaPulo = 0;
   //$horaAnterior = 0;
    for ($i = strtotime($dataInicial); $i <= strtotime($dataFinal); $i = $i + 86400) {
        //echo "teste";
      $i;
      
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
                insereHorario(2,$datai2);
                break;
            case "Ter":
                insereHorario(3,$datai2);
                break;
            case "Qua":
                insereHorario(4,$datai2);
                break;
            case "Qui":
                insereHorario(5,$datai2);
                break;
            case "Sex":
                insereHorario(6,$datai2);
                break;
            case "Sab":
                insereHorario(7,$datai2);
                break;
            default:
                break;
        }
    }

}
