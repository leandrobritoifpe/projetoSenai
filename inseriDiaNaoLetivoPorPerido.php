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

//INSTANCIANDO OBJETO
$dao = new DiaNaoLetivoDao();
$dao->abreBanco();
$inseriu = $dao->inseriDiaNaoLetivoPorPerido(1, '2017-02-24', '2017-02-28', 5);
$dao->fechaBanco();

//VERIFICANDO SE DEU CERTO A INSERÇÃO DOS DIAS NÃO LETIVOS
if ($inseriu) {
    $daoCalendario = new CalendarioEscolarDao();
    $daoCalendario->abrirConexao();
    $gerouDiaLetivo = $daoCalendario->geraTodosDiaLetivo(1);
    $daoCalendario->fechaBanco();
    if ($gerouDiaLetivo) {
        $mensagem = exibeMesagensParaUsuario(7);
        echo "<script>window.location='index.php';alert('$mensagem');</script>";
    } else {
        echo "<script>window.location='index.php';alert('DIAS NAO LETIVOS GERADOS COM SUCESSO, POREM NAO FOI POSSIL ATUALIZAR OS DIAS LETIVOS');</script>";
    }
} else {
    $mensagem= exibeMesagensParaUsuario(505);
    echo "<script>window.location='index.php';alert('$mensagem');</script>";
}

 
