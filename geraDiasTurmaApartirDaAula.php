<?php

/*
 * 
 * OBJETIVO: SERVIR DE CONTROLE
 * CRIADA: 27/09/2016
 * ULTIMA ATUALIZACAO : 29/09/2016
 * 
 * DS-> LEANDRO BRITO
 */

include './gerenciadorDeFuncoes.php';
include_once './entidades/CalendarioTurma.php';
include_once './dao/CalendarioTurmaDao.php';

$dao = new CalendarioTurmaDao();
$dao->abreBanco();

$codCurso = 'TEC.063';
$codFilial = 1;
$codTurma = 'TEC.063.PLAN.';
$codTurno = 1;
$dataInicial = '2017-01-31';
$aula = 30;
$userCadastrante = 'DARIO';
$diasRecesso = 5;

$calendarioTurma = new CalendarioTurma();
$calendarioTurma->set_codCurso($codCurso);
$calendarioTurma->set_codFilial($codFilial);
$calendarioTurma->set_codTurma($codTurma);
$calendarioTurma->set_codTurno($codTurno);
$calendarioTurma->set_dataInicial($dataInicial);
$calendarioTurma->set_diasRecesso($diasRecesso);
$calendarioTurma->set_aula($aula);
$calendarioTurma->set_userCadastrante($userCadastrante);

$geroucomSucesso = $dao->geraDiasTurmaApartirDaAula($calendarioTurma);
$dao->fechaBanco();

if($geroucomSucesso){
  //echo "<script>window.location='index.php';alert('CALENDARIO DA TURMA ATUALIZADO COM SUCESSO');</script>";
    echo "atualizou os dados com sucessso";
}
else{
  //echo "<script>window.location='index.php';alert('OCORREU UM ERRO AO TENTAR ATUALIZAR O CALENDARIO');</script>";
    echo "deu merda";
}