<?php

include './dao/DiaNaoLetivoDao.php';
 include './gerenciadorDeFuncoes.php';
   
 // INPORTANOD CLASSE 
 include_once './entidades/DiaNaoLetivo.php';
 include_once './entidades/CalendarioEscolar.php';
include_once './dao/CalendarioEscolarDao.php';
 
 $dao = new DiaNaoLetivoDao();
 $dao->abreBanco();
 $resultado = $dao->inseriDiaNaoLetivoPorPerido(1, '2017-01-02', '2017-01-04', 4);
 $dao->fechaBanco();
 echo "<br>";
 if ($resultado == 7) {
     
    $daoCalendario = new CalendarioEscolarDao;
    $dao->abreBanco();
    echo $msg = exibeMesagensParaUsuario($daoCalendario->geraDiaLetivo(1));
    $daoCalendario->fechaBanco();
}
else{
    echo $msg = exibeMesagensParaUsuario(7);
}

 
