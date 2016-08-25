<?php

if (isset($_POST['DATAFIN'])) {
    include_once './util/conectaBanco.php';
    include './gerenciadorDeFuncoes.php';
    conectaComBanco();
    
    $dataInicial = $_POST['DATAINI'];
    $dataFinal = $_POST['DATAFIN'];
    $descricao = $_POST['DESCRICAO'];
    $codFilial = 1;
    for ($i = strtotime($dataInicial); $i <= strtotime($dataFinal); $i = $i + 86400) {
        $i;

        $datai = date("d-m-Y", $i);
        $dataConvertidaForamatoAmericano = date("Y-m-d", $i);

        $diaSemana = array(0, 1, 2, 3, 4, 5, 6);

        $diaSemanaNumero = date('w', strtotime($dataConvertidaForamatoAmericano));
        $dia = $diaSemana[$diaSemanaNumero];

        switch ($dia) {
            case"0": $diaSemana = "DOM";
                break;
            case"1": $diaSemana = "SEG";
                break;
            case"2": $diaSemana = "TER";
                break;
            case"3": $diaSemana = "QUA";
                break;
            case"4": $diaSemana = "QUI";
                break;
            case"5": $diaSemana = "SEX";
                break;
            case"6": $diaSemana = "SAB";
                break;
        }


        switch ($diaSemana) {
            case "SEG":
                insereHorario(2, $dataConvertidaForamatoAmericano, $diaSemana,$codFilial,$descricao);
                break;
            case "TER":
                insereHorario(3, $dataConvertidaForamatoAmericano, $diaSemana, $codFilial,$descricao);
                break;
            case "QUA":
                insereHorario(4, $dataConvertidaForamatoAmericano, $diaSemana, $codFilial,$descricao);
                break;
            case "QUI":
                insereHorario(5, $dataConvertidaForamatoAmericano, $diaSemana, $codFilial,$descricao);
                break;
            case "SEX":
                insereHorario(6, $dataConvertidaForamatoAmericano, $diaSemana, $codFilial,$descricao);
                break;
            case "SAB":
                insereHorario(7, $dataConvertidaForamatoAmericano, $diaSemana, $codFilial,$descricao);
                break;
            default:
                break;
        }
    }
   //echo "<script>window.location='index.php';alert('CALENDARIO GERADO COM SUCESSO');</script>";
}
