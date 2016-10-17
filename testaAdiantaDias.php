<?php

/*
 * CLASSE CalendarioEscolarDao
 * OBJETIVO: SERVIR DE CONTROLE
 * CRIADA: 21/09/2016
 * ULTIMA ATUALIZACAO : 14/09/2016
 * 
 * DS-> LEANDRO BRITO
 */
include './gerenciadorDeFuncoes.php';
include_once './entidades/CalendarioTurma.php';
include_once './dao/CalendarioTurmaDao.php';

$dao = new CalendarioTurmaDao();
$dao->abreBanco();

$codCurso = 'TEC.042';
$codFilial = 1;
$codTurma = 'TEC.042.PLAN.';

$calendarioTurma = new CalendarioTurma();
$calendarioTurma->set_codCurso($codCurso);
$calendarioTurma->set_codFilial($codFilial);
$calendarioTurma->set_codTurma($codTurma);
$dao->retornaCalendarioAdiantado($calendarioTurma);

