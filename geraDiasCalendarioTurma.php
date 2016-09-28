<?php
/*
 * CLASSE CalendarioEscolarDao
 * OBJETIVO: SERVIR DE CONTROLE
 * CRIADA: 21/09/2016
 * ULTIMA ATUALIZACAO : 21/09/2016
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
$codTurma = 'TEC.063.PLAN.2';
$codTurno = 1;
$dataInicial = '2017-01-03';
$userCadastrante = 'DARIO';
$diasRecesso = 2;

$calendarioTurma = new CalendarioTurma();
$calendarioTurma->set_codCurso($codCurso);
$calendarioTurma->set_codFilial($codFilial);
$calendarioTurma->set_codTurma($codTurma);
$calendarioTurma->set_codTurno($codTurno);
$calendarioTurma->set_dataInicial($dataInicial);
$calendarioTurma->set_diasRecesso($diasRecesso);
$calendarioTurma->set_userCadastrante($userCadastrante);

$geroucomSucesso = $dao->geraDiasCalendarioTurma($calendarioTurma);
//$sucesso = $dao->geraProximoDia($calendarioTurma);
$dao->fechaBanco();

if($geroucomSucesso && $sucesso){
 // echo "<script>window.location='index.php';alert('CALENDARIO DA TURMA ATUALIZADO COM SUCESSO');</script>";
    echo "atualizou os dados com sucessso";
}
else{
  //echo "<script>window.location='index.php';alert('OCORREU UM ERRO AO TENTAR ATUALIZAR O CALENDARIO');</script>";
    echo "deu merda";
}

