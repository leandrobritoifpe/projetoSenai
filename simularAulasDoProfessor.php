<?php

//CRIADA: 05/10/2016
 // ULTIMA ATUALIZACAO : 07/10/2016

$codigoDocente =84;
$codFilial = 1;
$turma = 'APP.632.P.1.XX';
$subDisc = 'APP.020.0107_1';
$turno = 4;
if (isset($codigoDocente) && isset($turma) && isset($subDisc) && isset($turno)) {
    include './gerenciadorDeFuncoes.php';
    include_once './entidades/CalendarioProfessor.php';
    include_once './dao/CalendarioDocenteDao.php';
    //echo 'entrou';
    $dao = new CalendarioDocenteDao();
    $dao->abreBanco();
    $dadosCalendarioTurma = $dao->diasAulasSubDisciplina($codFilial, $subDisc, $turma);
    $arrayDiasUteis = $dao->verificaSeDataExiste($dadosCalendarioTurma, $codFilial, $codigoDocente, $turno);
    
    $dias = $arrayDiasUteis[0];
    $diasOcupado = $arrayDiasUteis[1];
    
    $arrayDias = $dao->professorTemHora($codigoDocente, $codFilial, $dias);
    $diasLivre = $arrayDias[0];
    $diasEsgotados = $arrayDias[1];
    //echo count($arrayDiasUteis[1]);
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
        <div class="container">
            <div align="center"> DIAS DA DISCIPLINA QUE PODE DAR AULA</div>
            <BR /> <BR /> <BR />
            <div>
                <table class="table" id="tabela" border="1">
                    <thead>
                        <tr style="background-color: #58ACFA">
                            <th>TURMA</th>
                            <th>DISCIPLINA</th>
                            <th>DATA</th>
                            <th>HORA INICIAL</th>
                            <th>HORA FINAL</th>
                        </tr>
                    </thead>
                    <?php
                        for ($i = 0; $i < count($diasLivre); $i++) {
                            $id = $diasLivre[$i]->get_idTurma();
                           $sql = "SELECT * FROM PHE_CALENDARIO_TURMA WHERE ID = $id";
                            $result = mssql_query($sql);
                            while ($linha = mssql_fetch_array($result)) {
                                $dataFormatoBR = date('d/m/Y', strtotime($linha['DATADIA']));
                    ?>
                    <tr>
                        <td><?php echo $linha['CODIGO_TURMA']; ?></td>
                        <td><?php echo utf8_encode($linha['DESCRICAO_DISCIPLINA']); ?></td>
                        <td><?php echo $dataFormatoBR; ?></td>
                        <td><?php echo substr($linha['HORA_INICIAL'],0,8); ?></td>
                        <td><?php echo substr($linha['HORA_FINAL'],0,8); ?></td>
                    </tr>
                    <?php
                            }
                        }
                    ?>
                </table>
            </div>
        </div>
        <BR /> <BR /> <BR />
        <div class="container">
            <div align="center"> DIAS NÃO LIVRES</div>
            <BR /> <BR /> <BR />
            <div align="center">
                <table class="table" id="tabela2" border="1">
                    <thead>
                        <tr style="background-color: #58ACFA">
                            <th>TURMA</th>
                            <th>DISCIPLINA</th>
                            <th>DATA</th>
                            <th>HORA INICIAL</th>
                            <th>HORA FINAL</th>
                        </tr>
                    </thead>
                    <?php
                        for ($i = 0; $i < count($diasOcupado); $i++) {
                            $id = $diasOcupado[$i]->get_idTurma();
                            $sql = "SELECT * FROM PHE_CALENDARIO_TURMA WHERE ID = $id";
                            $result = mssql_query($sql);
                            while ($linha = mssql_fetch_array($result)) {
                                $dataFormatoBR = date('d/m/Y', strtotime($linha['DATADIA']));
                    ?>
                    <tr>
                        <td><?php echo $linha['CODIGO_TURMA']; ?></td>
                        <td><?php echo utf8_encode($linha['DESCRICAO_DISCIPLINA']); ?></td>
                        <td><?php echo $dataFormatoBR; ?></td>
                        <td><?php echo substr($linha['HORA_INICIAL'],0,8); ?></td>
                        <td><?php echo substr($linha['HORA_FINAL'],0,8); ?></td>
                    </tr>
                    <?php
                            }
                        }
                        $dao->fechaBanco();
                    ?>
                </table>
            </div>
        </div>
        <div class="container">
            <div align="center"> DIAS ESGOTADOS</div>
            <BR /> <BR /> <BR />
            <div align="center">
                <table class="table" id="tabela3" border="1">
                    <thead>
                        <tr style="background-color: #58ACFA">
                            <th>TURMA</th>
                            <th>DISCIPLINA</th>
                            <th>DATA</th>
                            <th>HORA INICIAL</th>
                            <th>HORA FINAL</th>
                        </tr>
                    </thead>
                    <?php
                        for ($i = 0; $i < count($diasEsgotados); $i++) {
                            $id = $diasEsgotados[$i]->get_idTurma();
                            $sql = "SELECT * FROM PHE_CALENDARIO_TURMA WHERE ID = $id";
                            $result = mssql_query($sql);
                            while ($linha = mssql_fetch_array($result)) {
                                $dataFormatoBR = date('d/m/Y', strtotime($linha['DATADIA']));
                    ?>
                    <tr>
                        <td><?php echo $linha['CODIGO_TURMA']; ?></td>
                        <td><?php echo utf8_encode($linha['DESCRICAO_DISCIPLINA']); ?></td>
                        <td><?php echo $dataFormatoBR; ?></td>
                        <td><?php echo substr($linha['HORA_INICIAL'],0,8); ?></td>
                        <td><?php echo substr($linha['HORA_FINAL'],0,8); ?></td>
                    </tr>
                    <?php
                            }
                        }
                        $dao->fechaBanco();
                    ?>
                </table>
            </div>
        </div>
    </body>
</html>
<?php
}
else{
    echo "<script>window.location='index.php';alert('PREECHA OS DADOS COM ATENÇÃO, POIS FALTOU ALGUMS VALORES A SEREM PREEHCIDOS');</script>";
}
?>