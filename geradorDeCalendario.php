<?php

/*
 * ARQUVIO geradorDeCalendario
 * OBNJETIVO: SERVIR DE CONTROLE PARA DAO
 * CRIADO : 25/08/2016
 * ULTIMA ATUALIZACAO : 15/09/2016
 * 
 * DS-> LEANDRO BRITO
 */


if (isset($_POST['DATAFIN'])) {
    //IMPORTANOD CLASSES E ARQUIVOS
    include './gerenciadorDeFuncoes.php';
    include_once './entidades/CalendarioEscolar.php';
    include_once './dao/CalendarioEscolarDao.php';

    // INSTANCIANDO OBJETO DAO E CRIANDO
    $dao = new CalendarioEscolarDao();
    $dao->abrirConexao();
    if ($dao->existeFeriado()) {
        //INSTANCIANDO VARIAVEL CALENDARIO
        $calendarioEscolar = new CalendarioEscolar();
        $calendarioEscolar->set_descricao(1);
        $calendarioEscolar->set_codFilial(1);
        $calendarioEscolar->set_status(1);
        $calendarioEscolar->set_usuarioCadastrante('DARIO');

        $dataInicial = $_POST['DATAINI'];
        $dataFinal = $_POST['DATAFIN'];


        $cont = 0;

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
                    $calendarioEscolar->set_dataDia($dataConvertidaForamatoAmericano);
                    $cont += $dao->geraCaledario($calendarioEscolar);
                    break;
                case "TER":
                    $calendarioEscolar->set_diaDaSemana(3);
                    $calendarioEscolar->set_nomeDoDia($diaSemana);
                    $calendarioEscolar->set_dataDia($dataConvertidaForamatoAmericano);
                    $cont += $dao->geraCaledario($calendarioEscolar);
                    break;
                case "QUA":
                    $calendarioEscolar->set_diaDaSemana(4);
                    $calendarioEscolar->set_nomeDoDia($diaSemana);
                    $calendarioEscolar->set_dataDia($dataConvertidaForamatoAmericano);
                    $cont += $dao->geraCaledario($calendarioEscolar);
                    break;
                case "QUI":
                    $calendarioEscolar->set_diaDaSemana(5);
                    $calendarioEscolar->set_nomeDoDia($diaSemana);
                    $calendarioEscolar->set_dataDia($dataConvertidaForamatoAmericano);
                    $cont += $dao->geraCaledario($calendarioEscolar);
                    break;
                case "SEX":
                    $calendarioEscolar->set_diaDaSemana(6);
                    $calendarioEscolar->set_nomeDoDia($diaSemana);
                    $calendarioEscolar->set_dataDia($dataConvertidaForamatoAmericano);
                    $cont += $dao->geraCaledario($calendarioEscolar);
                    break;
                case "SAB":
                    $calendarioEscolar->set_diaDaSemana(7);
                    $calendarioEscolar->set_nomeDoDia($diaSemana);
                    $calendarioEscolar->set_dataDia($dataConvertidaForamatoAmericano);
                    $cont += $dao->geraCaledario($calendarioEscolar);
                    break;
                default:
                    break;
            }
        }

        $atualizouCalendarioComFeriados = $dao->atualizaCalendarioComFeriados($calendarioEscolar);

        if ($cont == 0 && $atualizouCalendarioComFeriados == 0) {
            if ($dao->geraTodosDiaLetivo(1)) {
                $dao->fechaBanco();
                $mensagem = exibeMesagensParaUsuario(0);
                echo "<script>window.location='index.php';alert('$mensagem');</script>";
            } else {
                echo "<script>window.location='index.php';alert('CALENDARIO GERADO COM SUCESSO, POREM NAO FOI POSSIVEL GERAR OS DIAS LETIVOS');</script>";
            }
        } elseif ($cont != 0 && $atualizouCalendarioComFeriados == 505) {
            $mensagem = exibeMesagensParaUsuario(505);
            $dao->fechaBanco();
            echo "<script>window.location='index.php';alert('$mensagem');</script>";
        } else {
            $mensagem = exibeMesagensParaUsuario(1);
            $dao->fechaBanco();
            echo "<script>window.location='index.php';alert('$mensagem');</script>";
        }
    } elseif (!$dao->existeFeriado()) {
        $dao->fechaBanco();
        $mensagem = exibeMesagensParaUsuario(13);
        echo "<script>window.location='index.php';alert('$mensagem');</script>";
    }
}

