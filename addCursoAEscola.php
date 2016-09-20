<?php
/*
 * CLASSE CalendarioEscolarDao
 * OBJETIVO: SERVIR DE CONTROLE
 * CRIADA: 20/09/2016
 * ULTIMA ATUALIZACAO : 20/09/2016
 * 
 * DS-> LEANDRO BRITO
 */
include './gerenciadorDeFuncoes.php';
include_once './entidades/CalendarioTurma.php';
include_once './dao/CalendarioTurmaDao.php';


$codFilial = 1;
$codCurso = "TEC.034";
$codDisciplina = "TEC.076.0001";
$quantidade = 3;
$dao = new CalendarioTurmaDao();
$dao->abreBanco();
$calendarioTurma = new CalendarioTurma();
$calendarioTurma->set_codFilial($codFilial);
$calendarioTurma->set_codCurso($codCurso);
$calendarioTurma->set_codDisciplina($codDisciplina);
$gerouComSucesso = $dao->transfereTabelaCursoDisciplina($calendarioTurma, $quantidade);
if ($gerouComSucesso) {
    echo "<script>window.location='index.php';alert('CUSOS E DISCIPLINA IMPORTADO COM SUCESSO');</script>";
}
else{
   echo "<script>window.location='index.php';alert('OCORREU UM ERRO INESPERADO AO TENTAR IMPORTAR O CURSO');</script>"; 
}
