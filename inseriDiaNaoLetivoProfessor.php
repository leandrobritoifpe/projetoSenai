<?php

/*
  CRIADA: 10/10/2016
 *  ULTIMA ATUALIZACAO : 14/10/2016
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

$data = '2016-10-04';
$dataFinal = '2016-10-15';
$inseriuComSucesso = false;
do {
    $codDocente = 84;
    $codFilial = 1;
    $userCadastrante = 'dario';
    $descricao = 1;
    $docente = new CalendarioProfessor();
    $docente->set_dataDia($data);
    $docente->set_codigoFilial($codFilial);
    $docente->set_codigoDocente($codDocente);
    $docente->set_userCadastrante($userCadastrante);
    $docente->set_descricao($descricao);
    $dao = new DiaNaoLetivoDao();
    $dao->abreBanco();
    $inseriuComSucesso = $dao->insertDiaNaoLetivoProfessor($docente);
    $dao->fechaBanco();
    $data = date('Y-m-d', strtotime("+1 days", strtotime($data)));
} while ($data <= $dataFinal);
if ($inseriuComSucesso) {
    echo "<script>window.location='index.php';alert('DIA NAO LETIVO PARA O PROFESSOR, INSERIDO COM SUCESSO, MAS !!!!! ATENCAO !!!!! TODAS AS TURMAS QUE TIVER AULA COM ESTE PROFESSOR NESTA DATA, FICARAM COM AULA VAGA');</script>";
    //echo "deu certo";
} else {
    echo "<script>window.location='index.php';alert('OCORREU UM ERRO INESPERADO AO TENTAR REMOVER DIA NAO LETIVO');</script>";
    //echo "deu errado";
}

