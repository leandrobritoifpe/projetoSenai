<?php
 include './dao/DiaNaoLetivoDao.php';
 include './gerenciadorDeFuncoes.php';
   
 // INPORTANOD CLASSE 
 include_once './entidades/DiaNaoLetivo.php';
 
$dao = new DiaNaoLetivoDao();
$dao->abreBanco();
$dataInicial = '2017-01-02';
$dataFinal = '2017-01-15';
$mensagem = exibeMesagensParaUsuario($dao->inseriPeridoNaoLetivo($dataInicial, $dataFinal, 3,1));
$dao->fechaBanco();
echo "<script>window.location='index.php';alert('$mensagem');</script>";