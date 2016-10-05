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
$subDisc = 'APP.040.0076_1';
$turma = 'APP.464.PLAN.00';
$turno = 1;
$docente = 84;
$dao = new CalendarioDocenteDao();
$dao->abreBanco();
$dadosCalendarioTurma =  $dao->diasAulasSubDisciplina($codFilial, $subDisc, $turma);


$dataExiste = $dao->verificaSeDataExiste($dadosCalendarioTurma,$codFilial,$docente);
$dao->fechaBanco();

if ($dataExiste) {
    $gerouComSucesso = $dao->inseriProfessorTurma($codFilial, $turma, $dadosCalendarioTurma, $docente, $turno);
    if ($gerouComSucesso) {
        echo "<script>window.location='index.php';alert('PROFESSOR INSERIDO NA TURMAS, E SEUS DIAS DIAS DE AULAS ATUALIZADOS COM SUCESSO');</script>";
    }
    else{
        echo "<script>window.location='index.php';alert('NAO FOI POSSIVEL ATUALIZAR O CALENDARIO DO PROFESSOR, POR FAVOR CONTACTE O ADM DO SISTEMA');</script>";
    }
}
else{
   echo "<script>window.location='index.php';alert('CALENDARIO DO PROFESSOR NÃO GERADO OU PROFESSOR JÁ OCUPADO NESTA DATA E NESTE TURNO');</script>";
}
