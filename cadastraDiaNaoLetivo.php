<?php

/* ARQUVOS CadastraDiaNaoLetivo
 * OBJETIVO: SERVIR DE CONTROLE PARA O DAO
 * CRIADA: 25/08/2016
 * ULTIMA ATUALIZACAO : 08/09/2016
 * 
 * DS -> LEANDRO BRITO
 */
// IMPORTANDOO CLASE DAO E ARQUIVO GERENCIADO DE FUNCAO
include './dao/DiaNaoLetivoDao.php';
include './gerenciadorDeFuncoes.php';

// INPORTANOD CLASSE 
include_once './entidades/DiaNaoLetivo.php';
include_once './entidades/CalendarioEscolar.php';
include_once './dao/CalendarioEscolarDao.php';
//RECEBENDO PARAMENTRO

$data = '2017-09-07';

// CRIANOD ARRAY DE DIAS PARA COMPARA COM A VARIAVEL RECEBIDA
//$diaSemana = array(0, 1, 2, 3, 4, 5, 6);
//$diaSemanaNumero = date('w', strtotime($data));
//
//$dia = $diaSemana[$diaSemanaNumero];

//INTANCIADO OBJETO DAO
$dao = new DiaNaoLetivoDao();
$dao->abreBanco();

//INSTANCIANDO OBJETO DIANOALETIVO
$diaNaoLetivo = new DiaNaoLetivo();
$diaNaoLetivo->set_descricao(2);
$diaNaoLetivo->set_data($data);
$diaNaoLetivo->set_status(1);
$diaNaoLetivo->set_usuarioCadastrante('DARIO');

$numeroDaMensagem = $dao->inseriDiaNaoLetivo($diaNaoLetivo);
$mensagem = exibeMesagensParaUsuario($numeroDaMensagem);
$dao->fechaBanco();

//VERIFICANDO SE A INSERÇÃO DA DATA DEU CERTO, PARA PODE REGERAR OS DIAS LETIVOS
 echo "<script>window.location='index.php';alert('$mensagem');</script>";


