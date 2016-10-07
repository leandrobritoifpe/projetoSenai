<?php

/*
 * 
 * 
 * CRIADA: 06/10/2016
 * ULTIMA ATUALIZACAO : 07/10/2016
 * 
 * DS-> LEANDRO BRITO
 */

include './gerenciadorDeFuncoes.php';
include_once './entidades/CalendarioProfessor.php';
include_once './dao/CalendarioDocenteDao.php';

$codFilial = 1;
$subDisc = 'APP.040.0076_1';
$turma = 'APP.464.PLAN.00';
$docente = 84;
$dao = new CalendarioDocenteDao();
$dao->abreBanco();

