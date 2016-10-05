<?php
/*
 * CLASSE CalendarioEscolarDao
 * OBJETIVO: SERVIR DE CONTROLE
 * CRIADA: 21/09/2016
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
$codTurno = 1;
$dataInicial = '2016-03-05';
$userCadastrante = 'DARIO';
$diasRecesso = 0;

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

if($geroucomSucesso){
 // echo "<script>window.location='index.php';alert('CALENDARIO DA TURMA ATUALIZADO COM SUCESSO');</script>";
    echo "atualizou os dados com sucessso";
}
else{
  //echo "<script>window.location='index.php';alert('OCORREU UM ERRO AO TENTAR ATUALIZAR O CALENDARIO');</script>";
    echo "deu merda";
}

