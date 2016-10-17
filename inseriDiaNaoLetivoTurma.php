<?php
/*
    CRIADA: 20/09/2016
 *  ULTIMA ATUALIZACAO : 14/10/2016
 * 
 * DS-> LEANDRO BRITO
 * 
 */
include './dao/DiaNaoLetivoDao.php';
include './gerenciadorDeFuncoes.php';

// INPORTANOD CLASSE 
include_once './entidades/DiaNaoLetivo.php';
include_once './entidades/CalendarioTurma.php';
include_once './dao/CalendarioTurmaDao.php';

$codigoTurma = 'APP.558.P.1.XX';
$codFilial = 1;
$dataInicial = '2016-10-04';
$dataFinal = '2016-10-06';
$userCadastrante = "DARIO";

$diaoNaoLeitvo = new DiaNaoLetivo();
$diaoNaoLeitvo->set_codFilial($codFilial);
$diaoNaoLeitvo->set_dataInicial($dataInicial);
$diaoNaoLeitvo->set_dataFinal($dataFinal);

$diaNaoLetivoDao = new DiaNaoLetivoDao();
$diaNaoLetivoDao->abreBanco();
$listaDeDados= $diaNaoLetivoDao->inseriDiaNaoLetivoTurma($diaoNaoLeitvo, $codigoTurma);
$diaNaoLetivoDao->fechaBanco();

$listaDeCalendario = $listaDeDados[0];
for ($i = 0; $i < 1; $i++) {
    $calendario = $listaDeCalendario[$i];
    $idDiaNulo = $calendario->get_id();
}
$idDiaNulo;
$calendarioTurma = $listaDeDados[1];
$dao = new CalendarioTurmaDao();
$dao->abreBanco();

$dadosDaTurma = $dao->retornDadosTurma($codFilial, $codigoTurma);

$calendarioTurma->set_codCurso($dadosDaTurma["CODCURSO"]);
$calendarioTurma->set_codFilial($codFilial);
$calendarioTurma->set_codTurma($dadosDaTurma["CODTURMA"]);
$calendarioTurma->set_codTurno($dadosDaTurma["CODTURNO"]);
$calendarioTurma->set_diasRecesso($dadosDaTurma["RECESSO"]);
$calendarioTurma->set_userCadastrante($userCadastrante);

$ultimoDiaDeAula = $dao->adiantaDiasDeAula($calendarioTurma, $idDiaNulo);


if ($ultimoDiaDeAula != '') {
    $calendarioTurma->set_dataInicial($ultimoDiaDeAula);
    $regerouDiasDeAula = $dao->regeraDiasDeAulaTurma($calendarioTurma);
    $dao->fechaBanco();
    if ($regerouDiasDeAula) {
        //echo "<script>window.location='index.php';alert('ATENCAO!!! POR CAUSA DESSE IMPREVISTO, ALGUNS PROFESSORES ENTRARAM EM CHOQUE DE HORÁRIOS, POR FAVOR VERIFIQUE OS HORÁRIOS DOS PROFESSORES');</script>";
        echo "deu certo";
    }
    else{
      // echo "<script>window.location='index.php';alert('OCORREU UM ERRO AO TENTAR ATUALIZAR O CALENDARIO DA TURMA');</script>";
        echo "deu errado";
    }
}
else{
   // echo "<script>window.location='index.php';alert('ERRO AO TENTAR ATUALIZAR O CALENDARIO DA TURMA, VERIFIQUE SE EXISTE UM CALENDARIO ESOCLAR COM A DATA PASSADA');</script>";
    echo "nao existe";
}



