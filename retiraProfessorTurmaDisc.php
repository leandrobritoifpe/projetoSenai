<?php

/*
 * 
 * 
 * CRIADA: 05/10/2016
 * ULTIMA ATUALIZACAO : 07/10/2016
 * 
 * DS-> LEANDRO BRITO
 */


include './gerenciadorDeFuncoes.php';
include_once './entidades/CalendarioProfessor.php';
include_once './dao/CalendarioDocenteDao.php';

$codFilial = 1;
$docente = 84;
$turma = 'APP.464.PLAN.00';
$subdisc = 'APP.040.0076_1';

$dao = new CalendarioDocenteDao();
$dao->abreBanco();
$retirouComSucesso = $dao->retiraProfessorTurma($codFilial, $docente, $turma, $subdisc);
if ($retirouComSucesso) {
    echo "<script>window.location='index.php';alert('PROFESSOR REITIRADO DA TURMA COM SUCESSO');</script>";
    //echo "atualizou";
}
else{
    echo "<script>window.location='index.php';alert('OCORREU UM ERRO AO TENTAR ATUALIZAR A TURMA, POR FAVOR ENTRE EM CONTATO COM O ADM DO SISTEMA');</script>";
    //echo "não atualizou";
}