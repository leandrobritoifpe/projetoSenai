<?php

/* // 15/09/2016
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.ddd
 */

/*IMPORTANTE
 * 
 * VARIAVEIS PARA SUBSTITUIR PELAS DO SCRIPCASE
 * 
 * - $_POST['DESCRICAO'];
 * - NUMERO 1 (DENTRO DE COD FILIAL)
 *  -  _POST['DATAINI]
 *-    _POST[DATAFIN]
 * -   $DATAINICAL
 *-  $DATAFINAL
 */ 



//IMPORTANOD CLASSES E ARQUIVOS
    include './gerenciadorDeFuncoes.php';
    include_once './entidades/CalendarioEscolar.php';
    include_once './dao/CalendarioEscolarDao.php';
    
    // INSTANCIANDO OBJETO DAO E CRIANDO
    $dao = new CalendarioEscolarDao();
    $dao->abrirConexao();
    
    //INSTANCIANDO VARIAVEL CALENDARIO
    $calendarioEscolar = new CalendarioEscolar();
    $calendarioEscolar->set_descricao(converteStringParaMaiusculo($_POST['DESCRICAO']));
    $calendarioEscolar->set_codFilial(1);
    $calendarioEscolar->set_status('A');
    
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
                //$dao->fechaBanco();
                break;
            case "TER":
                $calendarioEscolar->set_diaDaSemana(3);
                $calendarioEscolar->set_nomeDoDia($diaSemana);
                $calendarioEscolar->set_dataDia($dataConvertidaForamatoAmericano);
                $cont += $dao->geraCaledario($calendarioEscolar);
                //$dao->fechaBanco();
                break;
            case "QUA":
                $calendarioEscolar->set_diaDaSemana(4);
                $calendarioEscolar->set_nomeDoDia($diaSemana);
                $calendarioEscolar->set_dataDia($dataConvertidaForamatoAmericano);
                $cont += $dao->geraCaledario($calendarioEscolar);
                //$dao->fechaBanco();
                break;
            case "QUI":
                $calendarioEscolar->set_diaDaSemana(5);
                $calendarioEscolar->set_nomeDoDia($diaSemana);
                $calendarioEscolar->set_dataDia($dataConvertidaForamatoAmericano);
                $cont += $dao->geraCaledario($calendarioEscolar);
                //$dao->fechaBanco();
                break;
            case "SEX":
                $calendarioEscolar->set_diaDaSemana(6);
                $calendarioEscolar->set_nomeDoDia($diaSemana);
                $calendarioEscolar->set_dataDia($dataConvertidaForamatoAmericano);
                $cont += $dao->geraCaledario($calendarioEscolar);
                //$dao->fechaBanco();
                break;
            case "SAB":
                $calendarioEscolar->set_diaDaSemana(7);
                $calendarioEscolar->set_nomeDoDia($diaSemana);
                $calendarioEscolar->set_dataDia($dataConvertidaForamatoAmericano);
                $cont += $dao->geraCaledario($calendarioEscolar);
               // $dao->fechaBanco();
                break;
            default:
                break;
        }
    }
    $dao->fechaBanco();
    if ($cont != 0) {
        $mensagem = exibeMesagensParaUsuario(0);
      echo "<script>window.location='index.php';alert('$mensagem');</script>";
    }
        
    else{
      $mensagem = exibeMesagensParaUsuario(1);
       echo "<script>window.location='index.php';alert('$mensagem');</script>";
}