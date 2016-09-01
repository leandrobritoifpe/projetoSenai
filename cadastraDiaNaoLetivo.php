<?php

/* ARQUVOS CadastraDiaNaoLetivo
 * OBJETIVO: SERVIR DE CONTROLE PARA O DAO
 * CRIADA: 25/08/2016
 * ULTIMA ATUALIZACAO : 01/08/2016
 * 
 * DS -> LEANDRO BRITO
 */
// IMPORTANDOO CLASE DAO E ARQUIVO GERENCIADO DE FUNCAO
include './dao/DiaNaoLetivoDao.php';
include './gerenciadorDeFuncoes.php';

// INPORTANOD CLASSE 
include_once './entidades/DiaNaoLetivo.php';
include_once './entidades/CalendarioEscolar.php';
include_once './dao/CalendarioEscolarDao.php';
//RECEBENDO PARAMENTRO

$data = $_POST['DATA'];

// CRIANOD ARRAY DE DIAS PARA COMPARA COM A VARIAVEL RECEBIDA
$diaSemana = array(0, 1, 2, 3, 4, 5, 6);
$diaSemanaNumero = date('w', strtotime($data));

$dia = $diaSemana[$diaSemanaNumero];

//INTANCIADO OBJETO DAO
$dao = new DiaNaoLetivoDao();
$dao->abreBanco();

//INSTANCIANDO OBJETO DIANOALETIVO
$diaNaoLetivo = new DiaNaoLetivo();
$diaNaoLetivo->set_descricao(2);
$diaNaoLetivo->set_data($data);
$diaNaoLetivo->set_codFilial(1);
$diaNaoLetivo->set_codTurno(1);
$diaNaoLetivo->set_horaFinal('00:00:00.0000000');
$diaNaoLetivo->set_horaInicial('00:00:00.0000000');
$diaNaoLetivo->set_diaSemana(retornaDiaDaSemana($dia));
$diaNaoLetivo->set_status('A');
$diaNaoLetivo->set_usuarioCadastrante('DARIO');

echo $numeroDaMensagem = $dao->inseriDiaNaoLetivo($diaNaoLetivo);
$mensagem = exibeMesagensParaUsuario($numeroDaMensagem);
$dao->fechaBanco();

//VERIFICANDO SE A INSERÇÃO DA DATA DEU CERTO, PARA PODE REGERAR OS DIAS LETIVOS
if ($numeroDaMensagem == 2) {
    //INSTANCIADO CALENDARIO DAO
    $daoCalendario = new CalendarioEscolarDao();
    $daoCalendario->abrirConexao();
    //RECEBENDO O RETORNO DO METODO GERAR DIA LETIVO
    $numeroDaMensagem = $daoCalendario->geraDiaLetivo(1);
    $mensagem = exibeMesagensParaUsuario($numeroDaMensagem);
    $daoCalendario->fechaBanco();
    if ($numeroDaMensagem == 6) {
        echo "<script>window.location='index.php';alert('$mensagem');</script>";
    } else {
        echo "<script>window.location='index.php';alert('DIA NAO LETIVO CADASTRADO, POREM NAO FOI POSSIVEL ATUALIZAR OS DIAS LETIVOS');</script>";
    }
} else {
    echo "<script>window.location='index.php';alert('$mensagem');</script>";
}

