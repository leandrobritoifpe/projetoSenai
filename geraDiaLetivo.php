<?php

/*
 * 
 * OJETIVO : servir de controle
 * CRIADA : 25/08/2016
 * ULTIMA ATUALIZACAO : 29/09/2016
 * 
 * DS -> LEANDRO BRITO ;)
 */

include_once './entidades/CalendarioEscolar.php';
include_once './dao/CalendarioEscolarDao.php';
include './gerenciadorDeFuncoes.php';
$data = '2017-09-07';
$ano = substr($data,0,5);
$dao = new CalendarioEscolarDao();
$dao->abrirConexao();
echo $mensagem = exibeMesagensParaUsuario($dao->geraDiaLetivo(1,$ano));
$dao->fechaBanco();
//echo "<script>window.location='index.php';alert('$mensagem');</script>";


