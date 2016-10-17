<?php

/*
 * CLASSE CalendarioEscolarDao
 * OBJETIVO: SERVIR DE CONTROLE
 * CRIADA: 13/10/2016
 * ULTIMA ATUALIZACAO : 14/10/2016
 * 
 * DS-> LEANDRO BRITO
 */
include './gerenciadorDeFuncoes.php';
include_once './entidades/CalendarioTurma.php';
include_once './dao/CalendarioTurmaDao.php';
include_once './entidades/CalendarioProfessor.php';
include_once './dao/CalendarioDocenteDao.php';

$codDisciplina1 = 'TEC.060.0001';
$codDisciplina2 = 'TEC.120.0001';
$codFilial = 1;
$codTurma = 'P.1-TEC.007.XXX';
$turno = 1;

$dao = new CalendarioTurmaDao();
$dao->abreBanco();
$professores = $dao->mudaOrdemDisciplina($codFilial, $codDisciplina1, $codDisciplina2, $codTurma);
//$professorDisciplina1 = $professores[0];
//$professorDisciplina2 = $professores[1];
$dao->atualizarDias($codFilial, $codDisciplina1, $codDisciplina2, $codTurma);
$dao->fechaBanco();


//$turma = $codTurma;


for ($i = 0; $i < count($professores); $i++) {
    $professorDisciplina = $professores[$i];
    $docente = $professorDisciplina[0];
    $subDisc = $professorDisciplina[2];
    $daoDocente = new CalendarioDocenteDao();
    $daoDocente->abreBanco();
    //$cor = $daoDocente->retornaCorDocente($codFilial, $docente);
    $daoDocente->zeraProfessorDisciplina($codFilial, $docente, $subDisc, $codTurma);
    $cor = $professorDisciplina[1];
    $dadosCalendarioTurma = $daoDocente->diasAulasSubDisciplina($codFilial, $subDisc, $codTurma);
    $diasLetivoProfessor = $daoDocente->diasLivreProfessor($dadosCalendarioTurma, $codFilial, $docente);
    $arrayDiasUteis = $daoDocente->verificaSeDataExiste($diasLetivoProfessor, $codFilial, $docente, $turno);
    $diasDeAula = $arrayDiasUteis[0];
    $dias = $daoDocente->professorTemHora($docente, $codFilial, $diasDeAula);
    $diasLivre = $dias[0];
    count($diasLivre);
    if (count($diasLivre) != 0) {
        $gerouComSucesso = $daoDocente->inseriProfessorTurma($diasDeAula, $docente, $cor);
        $daoDocente->fechaBanco();
        if ($gerouComSucesso) {
            // echo "<script>window.location='index.php';alert('PROFESSOR INSERIDO NA TURMAS, E SEUS DIAS DIAS DE AULAS ATUALIZADOS COM SUCESSO');</script>";
            echo "TROCA DE DISCIPLINA EFETUADA COM SUCESSO E PROFESSORES TAMBÉM ATUALIZADOS";
        } else {
            //echo "<script>window.location='index.php';alert('NAO FOI POSSIVEL ATUALIZAR O CALENDARIO DO PROFESSOR, POR FAVOR CONTACTE O ADM DO SISTEMA');</script>";
            echo "OCORREU UM ERRO INESPERADO POR FAVOR CONTACTE O ADM DO SISTEMA";
        }
    } else {
        //echo "<script>window.location='index.php';alert('CALENDARIO DO PROFESSOR NÃO GERADO! PROFESSOR JÁ ESTAR OCUPADADO NOS DIAS DESSA DISCIPLINA');</script>";
        echo "TROCA DE DISCIPLINA EFETUADA COM SUCESSO, POREM O PROFESSOR ESTAR OCUPADO NAS NOVAS DATAS DE AULA DESTA DISCIPLINA";
    }
}

