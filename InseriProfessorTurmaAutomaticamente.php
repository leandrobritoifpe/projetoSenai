<?php

/*
 * CRIADA: 14/10/2016
 * ULTIMA ATUALIZACAO : 14/10/2016
 * 
 * DS-> LEANDRO BRITO
 */

include_once './entidades/CalendarioProfessor.php';
include_once './dao/CalendarioDocenteDao.php';
include_once './dao/AutomatizacaoProfessoresDao.php';
include_once './dao/CalendarioTurmaDao.php';
include_once './entidades/ProfessorExpertises.php';

$codFilial = 1;
$turno = 1;
$autoDao = new AutomatizacaoProfessoresDao();
$autoDao->abreBanco();
$turmas = $autoDao->turmaComMaiorCH($codFilial, $turno);
if ($turmas != false) {
    $professoresOcupados = array();
    $professoresInseridos = array();

    for ($i = 0; $i < count($turmas); $i++) {
        $subDisciplinasTurma = $autoDao->disciplinaTurma($codFilial, $turmas[$i], $turno);
        for ($j = 0; $j < count($subDisciplinasTurma); $j++) {
            $professoresComEspertises = $autoDao->professoresComMaiorEspertises($codFilial, $subDisciplinasTurma[$j]);
            if ($professoresComEspertises != false) {
                $melhorProfessor = 0;
                $dadosProfessorApropriado = array();
                for ($index = 0; $index < count($professoresComEspertises); $index++) {

                    $docente = $professoresComEspertises[$index]->get_codProfessor();
                    $subDisc = $subDisciplinasTurma[$j];
                    $turma = $turmas[$i];

                    $dao = new CalendarioDocenteDao();
                    $cor = $dao->retornaCorDocente($codFilial, $docente);
                    $dadosCalendarioTurma = $dao->diasAulasSubDisciplina($codFilial, $subDisc, $turma);
                    $diasLetivoProfessor = $dao->diasLivreProfessor($dadosCalendarioTurma, $codFilial, $docente);
                    $arrayDiasUteis = $dao->verificaSeDataExiste($diasLetivoProfessor, $codFilial, $docente, $turno);
                    $diasDeAula = $arrayDiasUteis[0];
                    if (count($diasDeAula) != 0) {
                        $dias = $dao->professorTemHora($docente, $codFilial, $diasDeAula);
                        $diasLivre = $dias[0];
                        count($diasLivre);
                        if (count($diasLivre) != 0) {
                            $numeroDeUpdate = $dao->inseriProfessorTurmaContando($diasDeAula, $docente, $cor);
                            if ($melhorProfessor < $numeroDeUpdate) {
                                $dadosProfessorApropriado[0] = $docente;
                                $dadosProfessorApropriado[1] = $subDisc;
                                $dadosProfessorApropriado[2] = $turma;
                            }
                        }
                        $professoresOcupados[] = new ProfessorExpertises(0, 0, $subDisc, $docente, 0);
                    }
                }
                if (count($dadosProfessorApropriado) != 0) {
                    //$professoresInseridos[] = new ProfessorExpertises(0, 0, $subDisc, $docente, 0);
                    $dao = new CalendarioDocenteDao();
                    $cor = $dao->retornaCorDocente($codFilial, $dadosProfessorApropriado[0]);
                    $dadosCalendarioTurma = $dao->diasAulasSubDisciplina($codFilial, $dadosProfessorApropriado[1], $dadosProfessorApropriado[2]);
                    $diasLetivoProfessor = $dao->diasLivreProfessor($dadosCalendarioTurma, $codFilial, $dadosProfessorApropriado[0]);
                    $arrayDiasUteis = $dao->verificaSeDataExiste($diasLetivoProfessor, $codFilial, $dadosProfessorApropriado[0], $turno);
                    $diasDeAula = $arrayDiasUteis[0];
                    if (count($diasDeAula) != 0) {
                        $dias = $dao->professorTemHora($dadosProfessorApropriado[0], $codFilial, $diasDeAula);
                        $diasLivre = $dias[0];
                        count($diasLivre);
                        if (count($diasLivre) != 0) {
                            $dao->inseriProfessorTurma($diasDeAula, $dadosProfessorApropriado[0], $cor);
                            $professoresInseridos = new ProfessorExpertises(0, 0, $dadosProfessorApropriado[1], $dadosProfessorApropriado[0], 0);
                            $dao->atualizaFlagTp($codFilial, $dadosProfessorApropriado[2]);
                        }
                    }
                }
            }
        }
    }
}
$autoDao->fechaBanco();


