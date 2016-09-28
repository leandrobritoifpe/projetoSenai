<?php
//$str = 'seg-TERC-QUARTA-';
//$array = (explode('-', $str, -1));
//for ($index = 0; $index < count($array); $index++) {
//    echo $array[$index];
//}
//echo $teste;

include './gerenciadorDeFuncoes.php';
include_once './entidades/CalendarioTurma.php';
include_once './dao/CalendarioTurmaDao.php';

$dao = new CalendarioTurmaDao();
$dao->abreBanco();

$codCurso = 'TEC.063';
$codFilial = 1;
$codTurma = 'TEC.063.PLAN.';
$codTurno = 1;
$dataInicial = '2017-01-02';
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

//$geroucomSucesso = $dao->geraDiasCalendarioTurma($calendarioTurma);
$sucesso = $dao->geraProximoDia($calendarioTurma);
$dao->fechaBanco();

if($sucesso){
  //echo "<script>window.location='index.php';alert('CALENDARIO DA TURMA ATUALIZADO COM SUCESSO');</script>";
    echo "atualizou os dados com sucessso";
}
else{
  //echo "<script>window.location='index.php';alert('OCORREU UM ERRO AO TENTAR ATUALIZAR O CALENDARIO');</script>";
    echo "deu merda";
}


/*
$data = "2014-10-04"; 
echo date('Y-m-d', strtotime("+20 days",strtotime($data)));
 * */
 
?>