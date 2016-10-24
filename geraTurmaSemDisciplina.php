<?php

/* 
 * CRIADA : 21/10/2016
 * ATUALIZADA : 21/10/2016
 */

//include './gerenciadorDeFuncoes.php';
require_once './entidades/CalendarioTurma.php';
require_once './dao/CalendarioTurmaDao.php';

$dao = new CalendarioTurmaDao();
$dao->abreBanco();

$codCurso = 'APT.003';
$codFilial = 1;
$codTurma = 'APT.003_TESTE';
$userCadastrante = 'DARIO';
$turno = 1;

$calendarioTurma = new CalendarioTurma();
$calendarioTurma->set_codCurso($codCurso);
$calendarioTurma->set_codFilial($codFilial);
$calendarioTurma->set_codTurma($codTurma);
$calendarioTurma->set_userCadastrante($userCadastrante);
$calendarioTurma->set_codTurno($turno);
$gerouClendario = $dao->geraCalendarioTurmaSemDisciplina($calendarioTurma);
$dao->fechaBanco();