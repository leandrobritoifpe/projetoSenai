<?php
include './dao/DiaNaoLetivoDao.php';
include './gerenciadorDeFuncoes.php';

// INPORTANOD CLASSE 
include_once './entidades/DiaNaoLetivo.php';
include_once './entidades/CalendarioEscolar.php';
include_once './dao/CalendarioEscolarDao.php';
include_once './entidades/DiaNaoLetivo.php';

$dao = new DiaNaoLetivoDao();
$dao->abreBanco();

$diaNaoLetivo = new DiaNaoLetivo();
$diaNaoLetivo->set_codFilial($VcodFilial);
$diaNaoLetivo->set_codTurno($VcodTurno);
$diaNaoLetivo->set_dataInicial($dataInicial);
$diaNaoLetivo->set_dataFinal($dataFinal);
$diaNaoLetivo->set_descricao($Vdescricao);

$numeroDaMensagem = $dao->inseriDiaNaoLetivoPorTurno($diaNaoLetivo);
$dao->fechaBanco();
if($numeroDaMensagem == 12){
    $daoCalendario = new CalendarioEscolarDao();
    $daoCalendario->abrirConexao();
    $numeroDaMensagem = $daoCalendario->geraDiaLetivo($codFilial);
    $daoCalendario->fechaBanco();
    if($numeroDaMensagem == 6){
        $mensagem = exibeMesagensParaUsuario($numeroMensagem);
        echo "<script>window.location='index.php';alert('$mensagem, E DIAS LETIVOS ATUALIZADOS COM SUCESSO');</script>";
    }
    else{
        echo "<script>window.location='index.php';alert('DATA NAO LETIVA GRAVADA COM SUCESSO, POREM NAO FOI POSSIVEL ATUALIZAR OS DIAS LETIVOS');</script>";
    }
}else{
    $mensagem= exibeMesagensParaUsuario(505);
    echo "<script>window.location='index.php';alert('$mensagem');</script>";
}
