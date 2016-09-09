<?php
/*
 * CLASSE CalendarioEscolarDao
 * OBJETIVO: REALIZAR TODA AS COMUNICAÇOES COM O BANCO DE DADOS SQL SERVER
 * CRIADA: 08/09/2016
 * ULTIMA ATUALIZACAO : 08/09/2016
 * 
 * DS-> LEANDRO BRITO
 */
include './dao/DiaNaoLetivoDao.php';
include './gerenciadorDeFuncoes.php';

// INPORTANOD CLASSE 
include_once './entidades/DiaNaoLetivo.php';
include_once './entidades/CalendarioEscolar.php';
include_once './dao/CalendarioEscolarDao.php';

$dao = new DiaNaoLetivoDao();
$dao->abreBanco();
$numeroDaMensagem = $dao->deletaDiaNaoLetivo(3,1);
$mensagem = exibeMesagensParaUsuario($numeroDaMensagem);
$dao->fechaBanco();
if ($numeroDaMensagem == 14) {
    $daoCalendario =  new CalendarioEscolarDao();
    $daoCalendario->abrirConexao();
    $resultado = $daoCalendario->geraDiaLetivo(1);
    $daoCalendario->fechaBanco();
    if ($resultado == 6) {
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



