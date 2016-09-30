<?php

include './dao/DiaNaoLetivoDao.php';
include './gerenciadorDeFuncoes.php';

// INPORTANOD CLASSE 
include_once './entidades/DiaNaoLetivo.php';
include_once './entidades/CalendarioTurma.php';
include_once './dao/CalendarioTurmaDao.php';

$codigoTurma = '';
$codFilial = 1;
$dataInicial = '2017-10-10';
$dataFinal = '2017-10-15';

$diaoNaoLeitvo = new DiaNaoLetivo();
$diaoNaoLeitvo->set_codFilial($codFilial);
$diaoNaoLeitvo->set_dataInicial($dataInicial);
$diaoNaoLeitvo->set_dataFinal($dataFinal);

$diaNaoLetivoDao = new DiaNaoLetivoDao();
$lsitaCalendarioTurma = $diaNaoLetivoDao->inseriDiaNaoLetivoTurma($diaoNaoLeitvo, $codigoTurma);

$calendarioTurma = new CalendarioTurmaDao();