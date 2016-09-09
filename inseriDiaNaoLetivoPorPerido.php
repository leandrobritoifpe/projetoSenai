<?php

/* ARQUVOS CadastraDiaNaoLetivo
 * OBJETIVO: SERVIR DE CONTROLE PARA O DAO
 * CRIADA: 31/08/2016
 * ULTIMA ATUALIZACAO : 01/08/2016
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
$resultado = $dao->inseriDiaNaoLetivoPorPerido(1, '2017-01-02', '2017-01-30', 5);
$dao->fechaBanco();

//VERIFICANDO SE DEU CERTO A INSERÇÃO DOS DIAS NÃO LETIVOS
if ($resultado == 7) {

    $daoCalendario = new CalendarioEscolarDao();
    $daoCalendario->abrirConexao();
    $numeroMensagem = $daoCalendario->geraDiaLetivo(1);
    $mensagem = exibeMesagensParaUsuario($numeroMensagem);
    $daoCalendario->fechaBanco();
    if ($numeroMensagem == 6) {
        echo "<script>window.location='index.php';alert('$mensagem');</script>";
    } else {
        echo "<script>window.location='index.php';alert('DIAS NAO LETIVOS GERADOS COM SUCESSO, POREM NAO FOI POSSIL ATUALIZAR OS DIAS LETIVOS');</script>";
    }
} else {
    $mensagem= exibeMesagensParaUsuario(505);
    echo "<script>window.location='index.php';alert('$mensagem');</script>";
}

 
