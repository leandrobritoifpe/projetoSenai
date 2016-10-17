<?php

/*
    CRIADA: 10/10/2016
 *  ULTIMA ATUALIZACAO : 14/09/2016
 * 
 * DS-> LEANDRO BRITO
 * 
 */
include_once './dao/DiaNaoLetivoDao.php';
include './gerenciadorDeFuncoes.php';

// INPORTANOD CLASSE 
include_once './entidades/DiaNaoLetivo.php';
include_once './entidades/CalendarioProfessor.php';
//include_once './dao/CalendarioTurmaDao.php';

$data = '2016-10-';
$codDocente = 84;
$codFilial = 1;
$docente = new CalendarioProfessor();
$docente->set_dataDia($data);
$docente->set_codigoFilial($codFilial);
$docente->set_codigoDocente($codDocente);
$dao = new DiaNaoLetivoDao();
$dao->abreBanco();
$inseriuComSucesso = $dao->removeDiaNaoLetivoProfessor($docente);
$dao->fechaBanco();
if ($inseriuComSucesso) {
    echo "<script>window.location='index.php';alert('DIA NAO LETIVO REMOVIDO COM SUCESSO');</script>";
}
else{
    echo "<script>window.location='index.php';alert('OCORREU UM ERRO INESPERADO AO TENTAR INSERIO O DIA NAO LETIVO PARA O PROFESSOR DESEJADO');</script>";
}