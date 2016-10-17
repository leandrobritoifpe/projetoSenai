<?php

/*
 * 
 * CRIADA: 07/10/2016
 * ULTIMA ATUALIZACAO : 14/10/2016
 * 
 * DS-> LEANDRO BRITO
 */
    include_once './entidades/CalendarioTurmaView.php';
    include_once './util/conectaBanco.php';
    include './gerenciadorDeFuncoes.php';
    $con = conectandoComBanco();
    $codFilial = 1;
    //$codDocente = 84;
    $ano = 2016;
    $turma = 'P.1-APP.464.XXX';
    $cor = '#AB7A7A';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
            <title>MOSTRA CALENDARIO DOCENTE</title>
        <meta charset="UTF-8" />
            <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/> 
            <meta name="viewport" content="width=device-width, initial-scale=1.0"/> 
            <meta name="description" content="Responsive Retina-Friendly Menu with different, size-dependent layouts" />
            <meta name="keywords" content="responsive menu, retina-ready, icon font, media queries, css3, transition, mobile" />
            <meta name="author" content="Codrops" />
            <link rel="shortcut icon" href="../favicon.ico"/> 
            <link rel="stylesheet" type="text/css" href="css/default.css" />
            <link rel="stylesheet" type="text/css" href="css/component.css" />
            <script src="js/modernizr.custom.js"></script>
            <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen" />
            <script type="text/javascript" src="js_file/jquery-2.1.4.js"></script>
            <script src="bootstrap/js/bootstrap.min.js"></script>
            <!-- DataTables CSS -->
            <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.8/css/jquery.dataTables.css" />
  
            <!-- jQuery -->
            <script type="text/javascript" charset="utf8" src="//code.jquery.com/jquery-1.10.2.min.js"></script>

            <!-- DataTables -->
            <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.8/js/jquery.dataTables.js"></script>
            <script type="text/javascript" src="js_file/teste.js"></script>
    </head>
    <body>
        <div class="main clearfix">
            <br></br>
           <div class="container">
               <div class="row">
                    <?php
                        for ($index = 1; $index < 5; $index++) {
                     ?>
                    <div class="col-md-3 col-sm-4 col-xs-6">
                        <div>
                            <div>
                                <?php
                                    echo retornaNomeDoMes($index);
                                ?>
                            </div>
                            <?php
                               $janiero = new CalendarioTurmaView();
                               $janiero->geraCalendario($index, $ano,$codFilial,$turma,$cor);
                            ?>
                        </div>
                    </div>
                    <?php
                        }
                    ?>
                </div>
               <br></br>
                <div class="row">
                    <?php
                        for ($index = 5; $index < 9; $index++) {
                   
                    ?>
                    <div class="col-md-3 col-sm-4 col-xs-6">
                        <div>
                            <div>
                                <?php
                                    echo retornaNomeDoMes($index);
                                ?>
                            </div>
                            <?php
                               $janiero = new CalendarioTurmaView();
                               $janiero->geraCalendario($index, $ano,$codFilial,$turma,$cor);
                            ?>
                        </div>
                    </div>
                    <?php
                        }
                    ?>
                </div>
               <br></br>
                <div class="row">
                    <?php
                        for ($index = 9; $index < 13; $index++) {
                   
                    ?>
                    <div class="col-md-3 col-sm-4 col-xs-6">
                        <div>
                            <div>
                                <?php
                                    echo retornaNomeDoMes($index);
                                ?>
                            </div>
                            <?php
                               $janiero = new CalendarioTurmaView();
                               $janiero->geraCalendario($index, $ano,$codFilial,$turma,$cor);
                            ?>
                        </div>
                    </div>
                    <?php
                        }
                    ?>
                </div>
           </div>
        </div>
        <br /><br /> <br />
        <div class="container">
            <div class="row">
                    <div class="col-md-3 col-sm-4 col-xs-6">
                        <div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th style="background-color:<?php echo $cor;?>; color: <?php echo $cor;?>;">VERMELHO</th>
                                        <th>AULAS DO PROFESSOR</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
               </div>
			<div>TURMA E DISCIPLINA DO PROFESSOR</div>
                        <div>
                            <?php
                                $select = "SELECT T.CODIGO_TURMA AS TURMA, C.NOME,T.DESCRICAO_DISCIPLINA, P.NOME AS PROFESSOR,MIN(T.DATADIA) AS DATA_INICIO, MAX(T.DATADIA) AS DATA_TERMINO 
                                           FROM PHE_CALENDARIO_TURMA T 
                                           inner join PHE_SPROFESSOR P ON T.CODIGO_PROFESSOR = P.CODPESSOA 
                                           INNER JOIN PHE_SCURSO C ON T.CODIGO_CURSO = C.CODCURSO
                                           WHERE CODIGO_TURMA = '$turma'
                                           GROUP BY T.CODIGO_SUBDISCIPLINA, T.CODIGO_CURSO, T.CODIGO_PROFESSOR, P.NOME, T.DESCRICAO_DISCIPLINA, T.CODIGO_TURMA, C.NOME";
                                
                                $resultado = mssql_query($select);
                                $contador = 0;
                           ?>
                            <table class="table" id="tabela" border="1">
                                <thead>
                                    <tr style="background-color: <?php echo $cor;?>">
                                        <th>TURMA</th>
                                        <th>CURSO</th>
                                        <th style="width: 20%;">DISCIPLINA</th>
                                        <th style="width: 20%;">PROFESSOR</th>
                                        <th style="width: 5%;">DATA INICIO</th>
                                        <th style="width: 5%;">DATA TERMINIO</th>
                                    </tr>
                                </thead>
                            <?php
                                
                                    while ($linha = mssql_fetch_array($resultado)) {
                                        $dataInicioFormatoBR = date('d/m/Y', strtotime($linha['DATA_INICIO']));
                                        $dataTerminoFormatoBR = date('d/m/Y', strtotime($linha['DATA_TERMINO']));
                                        //$diaMes = substr($dataFormatoBR,0,5);
                            ?>
                                <tr>
                                    <td><?php echo $linha['TURMA'];?></td>
                                    <td><?php echo utf8_encode($linha['NOME']);?></td>
                                    <td><?php echo utf8_encode($linha['DESCRICAO_DISCIPLINA']);?></td>
                                    <td><?php echo utf8_encode($linha['PROFESSOR']);?></td>
                                    <td><?php echo $dataInicioFormatoBR;?></td>
                                    <td><?php echo $dataTerminoFormatoBR;?></td>
                                </tr>
                            
                            <?php
                                    }
                                
                            ?>
                            </table>
                        </div>
                    </div> 
        <?php
             mssql_close($con);
        ?>
    </body>
</html>





