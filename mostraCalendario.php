<?php
/*
 * CLASSE CalendarioEscolarDao
 * OBJETIVO: REALIZAR TODA AS COMUNICAÇOES COM O BANCO DE DADOS SQL SERVER
 * CRIADA: 05/09/2016
 * ULTIMA ATUALIZACAO : 15/09/2016
 * 
 * DS-> LEANDRO BRITO
 */
    include_once './entidades/Calendario.php';
    include_once './util/conectaBanco.php';
    $con = conectandoComBanco();
    $codFilial = 1;
    $codDocente = 1;
   $sql = "SELECT * FROM PHE_CALENDARIO_ESCOLA WHERE CODFILIAL = $codFilial";
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
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th style="background-color:red; color: red;">VERMELHO</th>
                                        <th>FERIADO</th>
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
                    <div class="col-md-3 col-sm-4 col-xs-6">
                        <div>
                            <div>JANEIRO</div>
                            <?php
                               $janiero = new Calendario();
                               $janiero->geraCalendario(1, $ano,$codFilial,$codDocente);
                               //echo $ano;
                            ?>
                        </div>
                    </div>
                    
                     <div class="col-md-3 col-sm-4 col-xs-6">
                        <div>FERVEREIRO</div>
                        <?php
                            $fervereiro = new Calendario();
                            $fervereiro->geraCalendario(2, $ano, $codFilial,$codDocente);
                        ?>
                    </div>
                    <div class="col-md-3 col-sm-4 col-xs-6">
                       <div>MARÇO</div>
                        <?php
                            $marco = new Calendario();
                            $marco->geraCalendario(3, $ano, $codFilial,$codDocente);
                        ?>
                   </div>
                    <div class="col-md-3 col-sm-4 col-xs-6">
                       <div>ABRIL</div>
			<?php
                            $abril = new Calendario();
                            $abril->geraCalendario(4, $ano, $codFilial,$codDocente);
                        ?>
                    </div> 
                </div>
                <br></br>
                <div class="row">  
                    <div class="col-md-3 col-sm-4 col-xs-6">
                        <div>MAIO</div>
			<?php
                            $maio = new Calendario();
                            $maio->geraCalendario(5, $ano, $codFilial,$codDocente)
                        ?>
                    </div>
                    <div class="col-md-3 col-sm-4 col-xs-6">
			<div>JUNHO</div>
                        <?php
                           $junho = new Calendario();
                           $junho->geraCalendario(6, $ano, $codFilial,$codDocente)
                        ?>
                    </div>
                    <div class="col-md-3 col-sm-4 col-xs-6">
			<div>JULHO</div>
                        <?php
                          $julho = new Calendario();
                          $julho->geraCalendario(7, $ano, $codFilial,$codDocente)
                        ?>
                    </div>
                    <div class="col-md-3 col-sm-4 col-xs-6">
			<div>AGOSTO</div>
                        <?php
                          $agosto = new Calendario();
                          $agosto->geraCalendario(8, $ano, $codFilial,$codDocente);
                        ?>
                    </div> 
                </div>
                <br></br>
                <div class="row">                        
                    <div class="col-md-3 col-sm-4 col-xs-6">
			<div>SETEMBRO</div>
                        <?php
                          $setembro = new Calendario();
                          $setembro->geraCalendario(9, $ano, $codFilial,$codDocente)
                        ?>
                    </div> 
                    <div class="col-md-3 col-sm-4 col-xs-6">
			<div>OUTUBRO</div>
                        <?php
                          $outubro = new Calendario();
                          $outubro->geraCalendario(10, $ano, $codFilial,$codDocente)
                        ?>
                    </div>
                    <div class="col-md-3 col-sm-4 col-xs-6">
                        <div>NOVEMBRO</div>
                            <div>
                                <?php
                                  $novembro = new Calendario();
                                  $novembro->geraCalendario(11, $ano, $codFilial,$codDocente)
                                ?>
                            </div>
                    </div> 
                    <div class="col-md-3 col-sm-4 col-xs-6">
			<div>DEZEMBRO</div>
                        <?php
                           $dezembro = new Calendario();
                           $dezembro->geraCalendario(12, $ano, $codFilial,$codDocente)
                        ?>
                    </div> 
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-4 col-xs-6">
			<div>DATAS DE FERIADOS ESCOLARES</div>
                        <div>
                            <?php
                                $selectFeriados = "select d.DATA,e.DESCRICAO "
                                        . "from PHE_DIAS_NAO_LETIVOS d "
                                        . "left join PHE_DESCRICAO_CALENDARIO_ESCOLA e "
                                        . "on d.DESCRICAO = e.ID "
                                        . "where d.DESCRICAO = e.ID";
                                $resultado = mssql_query($selectFeriados);
                                $contador = 0;
                           ?>
                             <table class="table">
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
                </div>
           </div>
        </div>
        <?php
                        mssql_close($con);
        ?>
    </body>
</html>

