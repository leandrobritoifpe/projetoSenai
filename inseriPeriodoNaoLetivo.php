<?php

/* ARQUVOS CadastraDiaNaoLetivo
 * OBJETIVO: SERVIR DE CONTROLE PARA O DAO
 * CRIADA: 31/08/2016
 * ULTIMA ATUALIZACAO : 01/08/2016
 * 
 * DS -> LEANDRO BRITO */

include './dao/DiaNaoLetivoDao.php';
include './gerenciadorDeFuncoes.php';

// INPORTANOD CLASSE 
include_once './entidades/DiaNaoLetivo.php';
include_once './entidades/CalendarioEscolar.php';
include_once './dao/CalendarioEscolarDao.php';

$dao = new DiaNaoLetivoDao();
$dao->abreBanco();
$dataInicial = '2017-01-02';
$dataFinal = '2017-01-15';
$numeroDaMensagem = $dao->inseriPeridoNaoLetivo($dataInicial, $dataFinal, 3, 1);
$mensagem = exibeMesagensParaUsuario($numeroDaMensagem);
$dao->fechaBanco();
if ($numeroDaMensagem == 7) {
    $daoCalendario = new CalendarioEscolarDao();
    $daoCalendario->abrirConexao();
    $numeroDaMensagem = $daoCalendario->geraDiaLetivo(1);
    $mensagem = exibeMesagensParaUsuario($numeroDaMensagem);
    $daoCalendario->fechaBanco();
    if ($numeroDaMensagem == 6) {
        echo "<script>window.location='index.php';alert('$mensagem');</script>";
    } else {
        echo "<script>window.location='index.php';alert('DIA NAO LETIVO CADASTRADO, POREM NAO FOI POSSIVEL ATUALIZAR OS DIAS LETIVOS');</script>";
    }
} else {
    echo "<script>window.location='index.php';alert('$mensagem');</script>";
}
