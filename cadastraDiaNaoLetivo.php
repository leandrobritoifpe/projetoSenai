<?php
   include './dao/DiaNaoLetivoDao.php';
   include './gerenciadorDeFuncoes.php';
   
   
   include_once './entidades/DiaNaoLetivo.php';
   $descricao = converteStringParaMaiusculo($_POST['DESCRICAO']);
   $data = $_POST['DATA'];

   $diaSemana = array(0, 1, 2, 3, 4, 5, 6);
   $diaSemanaNumero = date('w', strtotime($data));
   $dia = $diaSemana[$diaSemanaNumero];
  
   $dao = new DiaNaoLetivoDao();
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
  
   
  
 
