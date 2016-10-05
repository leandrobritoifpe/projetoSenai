<?php

/*
 * 
 * 
 * CRIADA: 05/10/2016
 * ULTIMA ATUALIZACAO : 05/10/2016
 * 
 * DS-> LEANDRO BRITO
 */


include './gerenciadorDeFuncoes.php';
include_once './entidades/CalendarioProfessor.php';
include_once './dao/CalendarioDocenteDao.php';

$codFilial = 1;
$docente = 84;
$turma = '';
$subdisc = '';

$dao = new CalendarioDocenteDao();
$dao->abreBanco();
$retirouComSucesso = $dao->retiraProfessorTurma($codFilial, $docente, $turma, $subdisc);
if ($retirouComSucesso) {
    echo "atualizou";
}
else{
    echo "não atualizou";
}