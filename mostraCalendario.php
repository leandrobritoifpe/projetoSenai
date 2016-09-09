<?php
/*
 * CLASSE CalendarioEscolarDao
 * OBJETIVO: REALIZAR TODA AS COMUNICAÇOES COM O BANCO DE DADOS SQL SERVER
 * CRIADA: 05/09/2016
 * ULTIMA ATUALIZACAO : 08/09/2016
 * 
 * DS-> LEANDRO BRITO
 */
    include_once './entidades/Calendario.php';
    include_once './util/conectaBanco.php';
    $con = conectandoComBanco();
    $codFilial = 1;
    $sql = "SELECT * FROM PHE_CALENDARIO_ESCOLA
            WHERE CODFILIAL = $codFilial
            ORDER BY DATADIA
            OFFSET 0 ROWS FETCH NEXT 1 ROWS ONLY";
    $resultado = mssql_query($sql);
    $ano = "";
    $cont =0;
    if ($resultado) {
        while ($linha = mssql_fetch_array($resultado)) {
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
            <title>teste</title>
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
    </head>
    <body>
        <div class="main clearfix">
            <br></br>
           <div class="container">
                <div class="row">
                    <div class="col-md-3 col-sm-4 col-xs-6">
                        <div>
                            <div>JANEIRO</div>
                            <?php
                               $janiero = new Calendario();
                               $janiero->geraCalendario(01, $ano,$codFilial,1);
                               //echo $ano;
                            ?>
                        </div>
                    </div>
                    
                     <div class="col-md-3 col-sm-4 col-xs-6">
                        <div>FERVEREIRO</div>
                        <?php
                            $fervereiro = new Calendario();
                            $fervereiro->geraCalendario(02, $ano, $codFilial,1);
                        ?>
                    </div>
                    <div class="col-md-3 col-sm-4 col-xs-6">
                       <div>MARÇO</div>
                        <?php
                            $marco = new Calendario();
                            $marco->geraCalendario(03, $ano, $codFilial,1);
                        ?>
                   </div>
                    <div class="col-md-3 col-sm-4 col-xs-6">
                       <div>ABRIL</div>
			<?php
                            $abril = new Calendario();
                            $abril->geraCalendario(04, $ano, $codFilial,1);
                        ?>
                    </div> 
                </div>
                <br></br>
                <div class="row">  
                    <div class="col-md-3 col-sm-4 col-xs-6">
                        <div>MAIO</div>
			<?php
                            $maio = new Calendario();
                            $maio->geraCalendario(5, $ano, $codFilial,1)
                        ?>
                    </div>
                    <div class="col-md-3 col-sm-4 col-xs-6">
			<div>JUNHO</div>
                        <?php
                           $junho = new Calendario();
                           $junho->geraCalendario(6, $ano, $codFilial,1)
                        ?>
                    </div>
                    <div class="col-md-3 col-sm-4 col-xs-6">
			<div>JULHO</div>
                        <?php
                          $julho = new Calendario();
                          $julho->geraCalendario(7, $ano, $codFilial,1)
                        ?>
                    </div>
                    <div class="col-md-3 col-sm-4 col-xs-6">
			<div>AGOSTO</div>
                        <?php
                          $agosto = new Calendario();
                          $agosto->geraCalendario(8, $ano, $codFilial,1);
                        ?>
                    </div> 
                </div>
                <br></br>
                <div class="row">                        
                    <div class="col-md-3 col-sm-4 col-xs-6">
			<div>SETEMBRO</div>
                        <?php
                          $setembro = new Calendario();
                          $setembro->geraCalendario(9, $ano, $codFilial,1)
                        ?>
                    </div> 
                    <div class="col-md-3 col-sm-4 col-xs-6">
			<div>OUTUBRO</div>
                        <?php
                          $outubro = new Calendario();
                          $outubro->geraCalendario(10, $ano, $codFilial,1)
                        ?>
                    </div>
                    <div class="col-md-3 col-sm-4 col-xs-6">
                        <div>NOVEMBRO</div>
                            <div>
                                <?php
                                  $novembro = new Calendario();
                                  $novembro->geraCalendario(11, $ano, $codFilial,1)
                                ?>
                            </div>
                    </div> 
                    <div class="col-md-3 col-sm-4 col-xs-6">
			<div>DEZEMBRO</div>
                        <?php
                           $dezembro = new Calendario();
                           $dezembro->geraCalendario(12, $ano, $codFilial,1)
                        ?>
                    </div> 
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-4 col-xs-6">
			<div>DATAS DE FERIADOS ESCOLARES</div>
                        <div>
                            <?php
                                $selectFeriados = "SELECT * FROM PHE_DIAS_NAO_LETIVOS WHERE CODFILIAL = $codFilial";
                                $resultado = mssql_query($selectFeriados);
                                $contador = 0;
                                if ($resultado) {
                                    while ($linha = mssql_fetch_array($resultado)) {
                            ?>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>DATA</th>
                                        <th>DESCRICAO</th>
                                    </tr>
                                </thead>
                                <tr>
                                    <td><?php echo $linha['DATA'];?></td>
                                    <td><?php echo $linha['DESCRICAO'];?></td>
                                </tr>
                            </table>
                            <?php
                                    }
                                }
                            ?>
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

