<?php
/*
 * CLASSE CalendarioEscolarDao
 * OBJETIVO: REALIZAR TODA AS COMUNICAÇOES COM O BANCO DE DADOS SQL SERVER
 * CRIADA: 08/09/2016
 * ULTIMA ATUALIZACAO : 29/09/2016
 * 
 * DS-> LEANDRO BRITO
 */
include './dao/DiaNaoLetivoDao.php';
include './gerenciadorDeFuncoes.php';
$data = '2017-09-07';
$ano = substr($data,0,5);
// INPORTANOD CLASSE 
include_once './entidades/DiaNaoLetivo.php';
include_once './entidades/CalendarioEscolar.php';
include_once './dao/CalendarioEscolarDao.php';

$dao = new DiaNaoLetivoDao();
$dao->abreBanco();
$funcionou = $dao->deletaDiaNaoLetivo(1,1);
$dao->fechaBanco();
if ($funcionou) {
    $mensagem = exibeMesagensParaUsuario(14);
    $daoCalendario =  new CalendarioEscolarDao();
    $daoCalendario->abrirConexao();
    $gerouDiasLetivos = $daoCalendario->geraTodosDiaLetivo(1,$ano);
    $daoCalendario->fechaBanco();
    if ($gerouDiasLetivos) {
        echo "<script>window.location='index.php';alert('$mensagem');</script>";
    }
    else{
        echo "<script>window.location='index.php';alert('DIAS NAO LETIVO EXCLUIDO, POREM NAO CONSEGUIMOS ATUALIZAR OS DIAS LETIVOS');</script>";
    }
}
else{
    $mensagem = exibeMesagensParaUsuario(505);
    echo "<script>window.location='index.php';alert('$mensagem');</script>";
}



