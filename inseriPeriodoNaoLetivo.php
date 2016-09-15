<?php

/* ARQUVOS CadastraDiaNaoLetivo
 * OBJETIVO: SERVIR DE CONTROLE PARA O DAO
 * CRIADA: 31/08/2016
 * ULTIMA ATUALIZACAO : 14/09/2016
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
$dataInicial = '2017-03-01';
$dataFinal = '2017-03-31';
$inseriu = $dao->inseriPeridoNaoLetivo($dataInicial, $dataFinal, 3, 1);
$dao->fechaBanco();
if ($inseriu) {
    $daoCalendario = new CalendarioEscolarDao();
    $daoCalendario->abrirConexao();
    $gerouDiaLetivo = $daoCalendario->geraTodosDiaLetivo(1);
    $daoCalendario->fechaBanco();
    if ($gerouDiaLetivo) {
        echo "<script>window.location='index.php';alert('PERIDO LETIVO REGISTRADO COM SUCESSO, E DIAS LETIVOS ATUALIZADOS');</script>";
    } else {
        echo "<script>window.location='index.php';alert('DIA NAO LETIVO CADASTRADO, POREM NAO FOI POSSIVEL ATUALIZAR OS DIAS LETIVOS');</script>";
    }
} else {
    echo "<script>window.location='index.php';alert('OCORREU UM ERRO AO TENTAR REALIZAR ESSA OPERACAO, ENTRE EM CONTATO COM O ADM DO SISTEMA');</script>";
}
