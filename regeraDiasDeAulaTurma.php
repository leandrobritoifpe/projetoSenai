<?php
 /* OBJETIVO: SERVIR DE CONTROLE PARA O DAO
 * CRIADA: 29/09/2016
 * ULTIMA ATUALIZACAO : 29/09/2016 */

include './gerenciadorDeFuncoes.php';
include_once './entidades/CalendarioTurma.php';
include_once './dao/CalendarioTurmaDao.php';

$dao = new CalendarioTurmaDao();
$dao->abreBanco();

$codCurso = 'TEC.063';
$codFilial = 1;
$codTurma = 'TEC.063.PLAN.';
$codTurno = 3;
$dataInicial = '2017-05-09';
$userCadastrante = 'DARIO';
$diasRecesso = 5;

$dadosDaTurma = $dao->retornDadosTurma($codFilial, $codTurma);

$calendarioTurma = new CalendarioTurma();
$calendarioTurma->set_codCurso($dadosDaTurma["CODCURSO"]);
$calendarioTurma->set_codFilial($codFilial);
$calendarioTurma->set_codTurma($dadosDaTurma["CODTURMA"]);
$calendarioTurma->set_codTurno($dadosDaTurma["CODTURNO"]);
$calendarioTurma->set_dataInicial($dataInicial);
$calendarioTurma->set_diasRecesso($dadosDaTurma["RECESSO"]);
//$calendarioTurma->set_aula($aula);
$calendarioTurma->set_userCadastrante($userCadastrante);

$geroucomSucesso = $dao->regeraDiasDeAulaTurma($calendarioTurma);
$dao->fechaBanco();

if($geroucomSucesso){
  //echo "<script>window.location='index.php';alert('CALENDARIO DA TURMA ATUALIZADO COM SUCESSO');</script>";
    echo "atualizou os dados com sucessso";
}
else{
  //echo "<script>window.location='index.php';alert('OCORREU UM ERRO AO TENTAR ATUALIZAR O CALENDARIO');</script>";
    echo "deu merda";
}