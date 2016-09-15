<?php

/* // 15/09/2016
 * VARIAVEIS PARA SUBSTITUIR
 * 
 * $_POST['DESCRICAO'],
 * $_POSTA ['DATA'],dd
 * 
 */

include './dao/DiaNaoLetivoDao.php';
   include './gerenciadorDeFuncoes.php';
   
   // INPORTANOD CLASSE 
   include_once './entidades/DiaNaoLetivo.php';
   
   //RECEBENDO PARAMENTRO
   $descricao = converteStringParaMaiusculo($_POST['DESCRICAO']);
   $data = $_POST['DATA'];
   
   // CRIANOD ARRAY DE DIAS PARA COMPARA COM A VARIAVEL RECEBIDA
   $diaSemana = array(0, 1, 2, 3, 4, 5, 6);
   $diaSemanaNumero = date('w', strtotime($data));
   
   $dia = $diaSemana[$diaSemanaNumero];
   
   //INTANCIADO OBJETO DAO
   $dao = new DiaNaoLetivoDao();
   $dao->abreBanco();
   
   //INSTANCIANDO OBJETO DIANOALETIVO
   $diaNaoLetivo = new DiaNaoLetivo();
   $diaNaoLetivo->set_descricao($descricao);
   $diaNaoLetivo->set_data($data);
   $diaNaoLetivo->set_codFilial(1);
   $diaNaoLetivo->set_codTurno(1);
   $diaNaoLetivo->set_horaFinal('00:00:00.0000000');
   $diaNaoLetivo->set_horaInicial('00:00:00.0000000');
   $diaNaoLetivo->set_diaSemana(retornaDiaDaSemana($dia));
   $diaNaoLetivo->set_status('A');
   
   $numeroDaMensagem = $dao->inseriDiaNaoLetivo($diaNaoLetivo);
   $mensagem = exibeMesagensParaUsuario($numeroDaMensagem);
   $dao->fechaBanco();
   
   echo "<script>window.location='diasNaoLetivos.php';alert('$mensagem');</script>";