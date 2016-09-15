<?php

/* ARQUVOS CadastraDiaNaoLetivo
 * OBJETIVO: SERVIR DE CONTROLE PARA O DAO
 * CRIADA: 31/08/2016
 * ULTIMA ATUALIZACAO : 14/09/2016
 * 
 * DS -> LEANDRO BRITO */

include './dao/DiaNaoLetivoDao.php';
include './gerenciadorDeFuncoes.php';

// INPORTANOD CLASSE 
include_once './entidades/DiaNaoLetivo.php';
include_once './entidades/CalendarioEscolar.php';
include_once './dao/CalendarioEscolarDao.php';
include_once './entidades/DiaNaoLetivo.php';

$dao = new DiaNaoLetivoDao();
$dao->abreBanco();

//INSTANCIADO OBJETO
$diaNaoLetivo = new DiaNaoLetivo();
$diaNaoLetivo->set_codFilial(1);
$diaNaoLetivo->set_codTurno(1);
$diaNaoLetivo->set_dataInicial('2017-01-01');
$diaNaoLetivo->set_dataFinal('2017-01-03');
$diaNaoLetivo->set_descricao(7);

$inseriu = $dao->inseriDiaNaoLetivoPorTurno($diaNaoLetivo);
$dao->fechaBanco();
if($inseriu){
    $daoCalendario = new CalendarioEscolarDao();
    $daoCalendario->abrirConexao();
    $gerouDiaLetivo = $daoCalendario->geraTodosDiaLetivo(1);
    $daoCalendario->fechaBanco();
    if($gerouDiaLetivo){
        $mensagem = exibeMesagensParaUsuario(12);
        echo "<script>window.location='index.php';alert('$mensagem, E DIAS LETIVOS ATUALIZADOS COM SUCESSO');</script>";
    }
    else{
        echo "<script>window.location='index.php';alert('DATA NAO LETIVA GRAVADA COM SUCESSO, POREM NAO FOI POSSIVEL ATUALIZAR OS DIAS LETIVOS');</script>";
    }
}else{
    $mensagem= exibeMesagensParaUsuario(505);
    echo "<script>window.location='index.php';alert('$mensagem');</script>";
}
