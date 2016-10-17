<?php
/*
 * 
 * OJETIVO : SERVIR DE CONTROLLER 
 * CRIADA : 23/09/2016
 * ULTIMA ATUALIZACAO : 14/10/2016
 * 
 * DS -> LEANDRO BRITO ;)
 */
include './gerenciadorDeFuncoes.php';
include_once './entidades/CalendarioTurma.php';
include_once './dao/CalendarioTurmaDao.php';

$dao = new CalendarioTurmaDao();
$dao->abreBanco();
$codFilial = 1;
$codCurso = "TEC.063";
$calendarioTurma = new CalendarioTurma();
$calendarioTurma->set_codCurso($codCurso);
$calendarioTurma->set_codFilial($codFilial);
$listaIdDisciplina = $dao->retornaListaIdDisciplina($codCurso);
$cont = 0;
for ($index = 0; $index < count($listaIdDisciplina); $index++) {
    $objetoTurma = $listaIdDisciplina[$index];
    $calendarioTurma->set_codDisciplina($objetoTurma->get_codDisciplina());
    $dao->transfereTabelaCursoDisciplina($calendarioTurma, 1);
    $dao->inseriCargaHoraDisciplina($objetoTurma->get_ch(), $codFilial, $objetoTurma->get_codDisciplina()); 
    $cont++;
}
$dao->fechaBanco();
if ($cont == count($listaIdDisciplina)) {
    echo "<script>window.location='index.php';alert('CURSO E DISCIPLINAS TRANSFEIDOS COM SUCESSO');</script>";
}else{
     echo "<script>window.location='index.php';alert('OCORREU UM ERRO AO TENTAR TRANSFERIOS O CURSO E SUAS DISCIPLINAS');</script>";
}
