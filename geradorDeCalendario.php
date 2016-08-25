<?php

if (isset($_POST['DATAFIN'])) {
    //include_once './util/conectaBanco.php';
    include './gerenciadorDeFuncoes.php';
    //conectaComBanco();
    //include_once './util/ConnectaBanco.php';
    //$con = new ConnectaBanco();
    //$conexao = $con->conectandoComBanco();
    include_once './entidades/CalendarioEscolar.php';
    include_once './dao/CalendarioEscolarDao.php';
    $dao = new CalendarioEscolarDao();
    $calendarioEscolar = new CalendarioEscolar();
    $calendarioEscolar->set_descricao(converteStringParaMaiusculo($_POST['DESCRICAO']));
    //$calendarioEscolar->set_dataInicial($_POST['DATAINI']);
   // $calendarioEscolar->set_dataFinal($_POST['DATAFIN']);
    $calendarioEscolar->set_codFilial(1);
    $calendarioEscolar->set_status('A');
    $dataInicial = $_POST['DATAINI'];
    $dataFinal = $_POST['DATAFIN'];
   
    
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
                $calendarioEscolar->set_diaDaSemana(2);
                $calendarioEscolar->set_nomeDoDia($diaSemana);
                $dao->geraCaledario($calendarioEscolar);
                //insereHorario(2, $dataConvertidaForamatoAmericano, $diaSemana, $codFilial, $descricao);
                break;
            case "TER":
                $calendarioEscolar->set_diaDaSemana(3);
                $calendarioEscolar->set_nomeDoDia($diaSemana);
                $calendarioEscolar->set_dataDia($dataConvertidaForamatoAmericano);
                $dao->geraCaledario($calendarioEscolar);
                //insereHorario(3, $dataConvertidaForamatoAmericano, $diaSemana, $codFilial, $descricao);
                break;
            case "QUA":
                $calendarioEscolar->set_diaDaSemana(4);
                $calendarioEscolar->set_nomeDoDia($diaSemana);
                $calendarioEscolar->set_dataDia($dataConvertidaForamatoAmericano);
                $dao->geraCaledario($calendarioEscolar);
               // insereHorario(4, $dataConvertidaForamatoAmericano, $diaSemana, $codFilial, $descricao);
                break;
            case "QUI":
                $calendarioEscolar->set_diaDaSemana(5);
                $calendarioEscolar->set_nomeDoDia($diaSemana);
                $calendarioEscolar->set_dataDia($dataConvertidaForamatoAmericano);
                $dao->geraCaledario($calendarioEscolar);
                //insereHorario(5, $dataConvertidaForamatoAmericano, $diaSemana, $codFilial, $descricao);
                break;
            case "SEX":
                $calendarioEscolar->set_diaDaSemana(6);
                $calendarioEscolar->set_nomeDoDia($diaSemana);
                $calendarioEscolar->set_dataDia($dataConvertidaForamatoAmericano);
                $dao->geraCaledario($calendarioEscolar);
                //insereHorario(6, $dataConvertidaForamatoAmericano, $diaSemana, $codFilial, $descricao);
                break;
            case "SAB":
                $calendarioEscolar->set_diaDaSemana(7);
                $calendarioEscolar->set_nomeDoDia($diaSemana);
                $dao->geraCaledario($calendarioEscolar);
                //insereHorario(7, $dataConvertidaForamatoAmericano, $diaSemana, $codFilial, $descricao);
                break;
            default:
                break;
        }
    }
    $con->fecharConexaoComBanco();
    //echo "<script>window.location='index.php';alert('CALENDARIO GERADO COM SUCESSO');</script>";
}
