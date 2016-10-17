<?php

/*
 * 
 * 
 * CRIADA: 05/10/2016
 * ULTIMA ATUALIZACAO : 14/10/2016
 * 
 * DS-> LEANDRO BRITO
 */

include './gerenciadorDeFuncoes.php';
include_once './entidades/CalendarioProfessor.php';
include_once './dao/CalendarioDocenteDao.php';

$codFilial = 1;
$subDisc = 'APP.020.0107_1';
$turma = 'P.1-APP.632.XXX';
$turno = 4;
$docente = 84;

$dao = new CalendarioDocenteDao();
$dao->abreBanco();
$cor = $dao->retornaCorDocente($codFilial, $docente);
$dadosCalendarioTurma = $dao->diasAulasSubDisciplina($codFilial, $subDisc, $turma);
$diasLetivoProfessor = $dao->diasLivreProfessor($dadosCalendarioTurma, $codFilial, $docente);
$arrayDiasUteis = $dao->verificaSeDataExiste($diasLetivoProfessor, $codFilial, $docente, $turno);
$diasDeAula = $arrayDiasUteis[0];
$dias = $dao->professorTemHora($docente, $codFilial, $diasDeAula);
$diasLivre = $dias[0];
count($diasLivre);
if (count($diasLivre) != 0) {
    $gerouComSucesso = $dao->inseriProfessorTurma($diasDeAula, $docente, $cor);
    $dao->fechaBanco();
    if ($gerouComSucesso) {
       // echo "<script>window.location='index.php';alert('PROFESSOR INSERIDO NA TURMAS, E SEUS DIAS DIAS DE AULAS ATUALIZADOS COM SUCESSO');</script>";
        echo "deu certo";
    } else {
        //echo "<script>window.location='index.php';alert('NAO FOI POSSIVEL ATUALIZAR O CALENDARIO DO PROFESSOR, POR FAVOR CONTACTE O ADM DO SISTEMA');</script>";
        echo "deu errado";
    }
} else {
    //echo "<script>window.location='index.php';alert('CALENDARIO DO PROFESSOR NÃO GERADO! PROFESSOR JÁ ESTAR OCUPADADO NOS DIAS DESSA DISCIPLINA');</script>";
    echo "prof ocupado";
}
