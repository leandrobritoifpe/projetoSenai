<?php


/*
 * 
 * OBJETIVO: REALIZAR TODA AS COMUNICAÇOES COM O BANCO DE DADOS SQL SERVER
 * CRIADA: 15/09/2016
 * ULTIMA ATUALIZACAO : 05/10/2016
 * 
 * DS-> LEANDRO BRITO
 */

include './gerenciadorDeFuncoes.php';
include_once './entidades/CalendarioTurma.php';
include_once './dao/CalendarioTurmaDao.php';

$dao = new CalendarioTurmaDao();
$dao->abreBanco();

$codCurso = 'APP.464';
$codFilial = 1;
$codTurma = 'APP.46401';
$userCadastrante = 'DARIO';
$turno = 1;

$calendarioTurma = new CalendarioTurma();
$calendarioTurma->set_codCurso($codCurso);
$calendarioTurma->set_codFilial($codFilial);
$calendarioTurma->set_codTurma($codTurma);
$calendarioTurma->set_userCadastrante($userCadastrante);
$calendarioTurma->set_codTurno($turno);
$gerouClendario = $dao->geraCalendarioTurma($calendarioTurma);
$dao->fechaBanco();

if($gerouClendario){
   echo "<script>window.location='index.php';alert('CALENDARIO DA TURMA GERADO COM SUCESSO');</script>";
   
}
else{
  echo "<script>window.location='index.php';alert('OCORREU UM ERRO AO TENTAR GERAR O CALENDARIO');</script>"; 
    //ECHO "ERRO";
}
