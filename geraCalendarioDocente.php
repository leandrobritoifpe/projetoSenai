<?php

/* ARQUVOS CadastraDiaNaoLetivo
 * OBJETIVO: SERVIR DE CONTROLE PARA O DAO
 * CRIADA: 14/08/2016
 * ULTIMA ATUALIZACAO : 05/10/2016
 * 
 * DS -> LEANDRO BRITO
 */

include './gerenciadorDeFuncoes.php';
include_once './entidades/CalendarioProfessor.php';
include_once './dao/CalendarioDocenteDao.php';


$dao = new CalendarioDocenteDao();
$dao->abreBanco();
if ($dao->anoNaoExiisteNoCalendarioEscolar('2017', 1)) {
    $dao->fechaBanco();
    echo "<script>window.location='index.php';alert('NÃO EXISTE CALENDARIO ESCOLAR COM ESSE ANO');</script>";
} else {
    $calendarioProfessor = new CalendarioProfessor();
    $calendarioProfessor->set_codigoFilial(1);
    $calendarioProfessor->set_codigoDocente(83);
    $calendarioProfessor->set_userCadastrante('DARIO');
    $calendarioProfessor->set_ano('2017');
    $gerouComSucesso = $dao->geraCalendarioDocenteLivre($calendarioProfessor);
    $dao->fechaBanco();
    if ($gerouComSucesso) {
        echo "<script>window.location='index.php';alert('CALARIO DO DOCENTE GERADO COM SUCESSO');</script>";
        
    } else {
        echo "<script>window.location='index.php';alert('NAO FOI POSSIVEL GERAR O CALENDARIO DO DOCENTE');</script>";
       
    }
}

