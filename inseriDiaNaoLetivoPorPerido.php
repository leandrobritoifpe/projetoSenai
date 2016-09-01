<?php

include './dao/DiaNaoLetivoDao.php';
 include './gerenciadorDeFuncoes.php';
   
 // INPORTANOD CLASSE 
 include_once './entidades/DiaNaoLetivo.php';
 include_once './entidades/CalendarioEscolar.php';
include_once './dao/CalendarioEscolarDao.php';
 
 $dao = new DiaNaoLetivoDao();
 $dao->abreBanco();
 $resultado = $dao->inseriDiaNaoLetivoPorPerido(1, '2017-01-02', '2017-01-30', 5);
 $dao->fechaBanco();
 if ($resultado == 7) {
     
    $daoCalendario = new CalendarioEscolarDao;
    $daoCalendario->abrirConexao();
    $numeroMensagem = $daoCalendario->geraDiaLetivo(1);
    $mensagem = exibeMesagensParaUsuario($numeroMensagem);
    $daoCalendario->fechaBanco();
    if($numeroMensagem == 6){
         echo "<script>window.location='index.php';alert('$mensagem');</script>";
    }
    else{
         echo "<script>window.location='index.php';alert('DIAS NAO LETIVOS GERADOS COM SUCESSO, POREM NAO FOI POSSIL ATUALIZAR OS DIAS LETIVOS');</script>";
    }
}
else{
    echo "<script>window.location='index.php';alert('$mensagem');</script>";
}

 
