<?php
/*
 * CLASSE CalendarioEscolarDao
 * OBJETIVO: REALIZAR TODA AS COMUNICAÇOES COM O BANCO DE DADOS SQL SERVER
 * CRIADA: 14/09/2016
 * ULTIMA ATUALIZACAO : 15/09/2016
 * 
 * DS-> LEANDRO BRITO
 */
    include_once './entidades/CalendarioCtSegSab.php';
    include_once './util/conectaBanco.php';
    include './gerenciadorDeFuncoes.php';
    $con = conectandoComBanco();
    $codFilial = 1;
    $codDocente = 1;
   $sql = "SELECT TOP 1 DATADIA
            FROM PHE_CALENDARIO_ESCOLA
            WHERE CODFILIAL = $codFilial
            AND CODTURNO = $codDocente
            ORDER BY DATADIA DESC";
    $result = mssql_query($sql);
    $ano = "";
    $cont =0;
    if (mssql_num_rows($result)) {
        while ($linha = mssql_fetch_array($result)) {
            $ano = substr($linha['DATADIA'],0,-6);
            $cont ++;
        }
        if ($cont == 0) {
             echo "<script>window.location='index.php';alert('NAO HA NENHUM CALENDARIO CADASTRADO');</script>";
        }
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
            <title>CALENDARIO SEGUNDA A SÁBADO CURSOS TÉNICOS</title>
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
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.8/css/jquery.dataTables.css">
  
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
                    <div class="col-md-3 col-sm-4 col-xs-6">
                        <div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>CALENDARIO SEGUNDA A SÁBADO CT</th>
                                    </tr>
                                    <tr>
                                        <th style="background-color:red; color: red;">VERMELHO</th>
                                        <th>DIAS SEM AULAS</th>
                                    </tr>
                                    <tr>
                                        <th style="background-color: blue; color:blue;">AZUL</th>
                                        <th>DIAS NORMAIS</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
               </div>
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
                               $janiero = new CalendarioCtSegSab();
                               $janiero->geraCalendario($index, $ano,$codFilial,$codDocente);
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
                               $janiero = new CalendarioCtSegSab();
                               $janiero->geraCalendario($index, $ano,$codFilial,$codDocente);
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
                               $janiero = new CalendarioCtSegSab();
                               $janiero->geraCalendario($index, $ano,$codFilial,$codDocente);
                            ?>
                        </div>
                    </div>
                    <?php
                        }
                    ?>
                </div>
               <br></br>
                <div class="row">
                    <div class="col-md-3 col-sm-4 col-xs-6">
			<div>DATAS DE FERIADOS ESCOLARES</div>
                        <div>
                            <?php
                                $selectFeriados = "select d.DATA,e.DESCRICAO "
                                        . "from PHE_DIAS_NAO_LETIVOS d "
                                        . "left join PHE_DESCRICAO_CALENDARIO_ESCOLA e "
                                        . "on d.DESCRICAO = e.ID "
                                        . "where d.DESCRICAO = e.ID AND (d.TIPO = 0 OR d.TIPO = $codFilial )";
                                $resultado = mssql_query($selectFeriados);
                                $contador = 0;
                           ?>
                            <table class="table" id="tabela3">
                                <thead>
                                    <tr>
                                        <th>DATA</th>
                                        <th>DESCRICAO</th>
                                    </tr>
                                </thead>
                            <?php
                                
                                    while ($linha = mssql_fetch_array($resultado)) {
                                        $dataFormatoBR = date('d/m/Y', strtotime($linha['DATA']));
                                        $diaMes = substr($dataFormatoBR,0,5);
                            ?>
                                <tr>
                                    <td><?php echo $diaMes;?></td>
                                    <td><?php echo $linha['DESCRICAO'];?></td>
                                </tr>
                            
                            <?php
                                    }
                                
                            ?>
                                 </table>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4 col-xs-6">
                        <div>OUTROS DIAS SEM AULAS</div>
                        <div>
                            <?php
                                $selectFeriados = "select DISTINCT d.DATADIA,e.DESCRICAO
                                                    from PHE_CALENDARIO_ESCOLA d
                                                    left join PHE_DESCRICAO_CALENDARIO_ESCOLA e 
                                                    on d.DESCRICAO_CTSS = e.ID
                                                    where d.DESCRICAO_CT = e.ID
                                                    AND d.DESCRICAO_CTSS <> 1
                                                    AND d.DESCRICAO_CTSS <> 6
                                                    AND CODTURNO = $codFilial
                                                    ORDER BY DATADIA";
                                $retorno = mssql_query($selectFeriados);
                                $conta = 0;
                           ?>
                            <table class="table" id="tabela2">
                                <thead>
                                    <tr>
                                        <th>DATA</th>
                                        <th>DESCRICAO</th>
                                    </tr>
                                </thead>
                            <?php
                                
                                    while ($linha = mssql_fetch_array($retorno)) {
                                        $dataFormatoBR = date('d/m/Y', strtotime($linha['DATADIA']));
                                        $diaMes = substr($dataFormatoBR,0,5);
                            ?>
                                <tr>
                                    <td><?php echo $diaMes;?></td>
                                    <td><?php echo $linha['DESCRICAO'];?></td>
                                </tr>
                            
                            <?php
                                    }
                                
                            ?>
                                 </table>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4 col-xs-6">
                        <div>DIAS DE RECESSO</div>
                        <div>
                            <?php
                                $selectFeriados = "select DISTINCT d.DATADIA,e.DESCRICAO
                                                    from PHE_CALENDARIO_ESCOLA d
                                                    left join PHE_DESCRICAO_CALENDARIO_ESCOLA e 
                                                    on d.DESCRICAO_CT = e.ID
                                                    where d.DESCRICAO_CT = e.ID
                                                    AND d.DESCRICAO_CT = 6
                                                    AND CODTURNO = $codFilial
                                                    ORDER BY DATADIA";
                                $retorno = mssql_query($selectFeriados);
                                $conta = 0;
                           ?>
                            <table class="table" id="tabela">
                                <thead>
                                    <tr>
                                        <th>DATA</th>
                                        <th>DESCRICAO</th>
                                    </tr>
                                </thead>
                            <?php
                                
                                    while ($linha = mssql_fetch_array($retorno)) {
                                        $dataFormatoBR = date('d/m/Y', strtotime($linha['DATADIA']));
                                        $diaMes = substr($dataFormatoBR,0,5);
                                        
                            ?>
                                <tr>
                                    <td><?php echo $diaMes;?></td>
                                    <td><?php echo $linha['DESCRICAO'];?></td>
                                </tr>
                            
                            <?php
                                    }
                                
                            ?>
                                 </table>
                        </div>
                    </div>
                </div>
           </div>
        </div>
        <?php
            mssql_close($con);
        ?>
    </body>
</html>




