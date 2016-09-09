<?php

/*
 * CLASSE DiaNaoLetivoDao
 * OJETIVO : RESPOSAVEL POR TODA A COMUNICACAO COM O BANCO DE DADOS
 * CRIADA : 25/08/2016
 * ULTIMA ATUALIZACAO : 30/08/2016
 * 
 * DS -> LEANDRO BRITO ;)
 */

include_once './entidades/CalendarioEscolar.php';
include_once './dao/CalendarioEscolarDao.php';
include './gerenciadorDeFuncoes.php';

$dao = new CalendarioEscolarDao();
$dao->abrirConexao();
echo $mensagem = exibeMesagensParaUsuario($dao->geraDiaLetivo(1));
$dao->fechaBanco();
//echo "<script>window.location='index.php';alert('$mensagem');</script>";


