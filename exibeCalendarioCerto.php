<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Calendário</title>
    </head>
    <body>
        <?php
            $servidor = "52.34.253.148";
            $usuario = "pe";
            $banco = "DBSystemSec";
            $senha = "!@#123qwe";
            $conmssql = mssql_connect($servidor, $usuario, $senha);
            $db = mssql_select_db($banco, $conmssql);
            $cont = 0;
            if ($conmssql && $db) {
                $cont += 1;
            }
            if ($cont == 0) {
                echo "nao sei progrmar";
            }
        
            $codFilial = 1;
            $arrayIdCalendario = array();
            $arrayDataDiaCalendario = array();
            $arrayDescricao = array();
            $arrayFlagFnl = array();
            $arrayMesAno = array();
            $mes = 0;
            $sql = "SELECT * FROM PHE_CALENDARIO_ESCOLA WHERE CODFILIAL = $codFilial";
            $resultado = mssql_query($sql);
            
            if ($resultado) {
            while ($linha = mssql_fetch_array($resultado)) {
                $arrayIdCalendario[] = $linha['ID'];
                $arrayDataDiaCalendario[] = $linha['DATADIA'];
                $arrayDescricao = $linha['DESCRICAO'];
                $arrayFlagFnl = $linha['FNL'];
            }
            $sql = "SELECT * FROM PHE_CALENDARIO_ESCOLA WHERE CODFILIAL = $codFilial";
            $result = mssql_query($sql);
            while ($linha = mssql_fetch_array($result)) {
                $mes += +1;
                $ano = substr($arrayDataDiaCalendario[0], 0, -6);
                if ($mes == 1) {
                    $dias = 31;
                    $nome = "Janeiro";
        ?>
        <div>
            JANIERO
            <table width="210" border="1" cellspacing="1" cellpadding="1">
                <tr>
                   <td width="30"><center>D</center></td>
                   <td width=30><center>S</center></td>
                   <td width=30><center>T</center></td>
                   <td width=30><center>Q</center></td>
                   <td width=30><center>Q</center></td>
                   <td width=30><center>S</center></td>
                   <td width=30><center>S</center></td>
                </tr>
                <tr>
                    <?php
                        for ($i = 1; $i <= $dias; $i++) {
                            $diadasemana = date("w", mktime(0, 0, 0, $mes, $i, $ano));
                            $cont = 0;
                            if ($i == 1) {
                                while ($cont < $diadasemana) {
                                    echo "<td></td>";
                                    $cont++;
                                }
                            }
                    ?>
                    <td width=30><center><?php echo $i;?></center></td>
                    <?php
                        if ($diadasemana == 6) {
                    ?>
                       </tr>
                       <tr>
                    <?php
                        }
                    ?>
                </tr>
            </table>
        </div>
        <?php
             }
            }
            elseif($mes == 2) {
                    $dias = 31;
                   // $nome = "Janeiro";
        ?>
        <div>
            FEVEREIRO
            <table width="210" border="1" cellspacing="1" cellpadding="1">
                <tr>
                   <td width=30><center>D</center></td>
                   <td width=30><center>S</center></td>
                   <td width=30><center>T</center></td>
                   <td width=30><center>Q</center></td>
                   <td width=30><center>Q</center></td>
                   <td width=30><center>S</center></td>
                   <td width=30><center>S</center></td>
                </tr>
                <tr>
                    <?php
                        for ($i = 1; $i <= $dias; $i++) {
                            $diadasemana = date("w", mktime(0, 0, 0, $mes, $i, $ano));
                            $cont = 0;
                            if ($i == 1) {
                                while ($cont < $diadasemana) {
                                    echo "<td></td>";
                                    $cont++;
                                }
                            }
                    ?>
                    <td width=30><center><?php echo $i;?></center></td>
                    <?php
                        if ($diadasemana == 6) {
                    ?>
                       </tr>
                       <tr>
                    <?php
                        }
                    ?>
                </tr>
            </table>
        </div>
        <?php
               }
            }
            elseif($mes == 3) {
                    $dias = 31;
                   // $nome = "Janeiro";
        ?>
        <div>
            MARÇO
            <table width="210" border="1" cellspacing="1" cellpadding="1">
                <tr>
                   <td width=30><center>D</center></td>
                   <td width=30><center>S</center></td>
                   <td width=30><center>T</center></td>
                   <td width=30><center>Q</center></td>
                   <td width=30><center>Q</center></td>
                   <td width=30><center>S</center></td>
                   <td width=30><center>S</center></td>
                </tr>
                <tr>
                    <?php
                        for ($i = 1; $i <= $dias; $i++) {
                            $diadasemana = date("w", mktime(0, 0, 0, $mes, $i, $ano));
                            $cont = 0;
                            if ($i == 1) {
                                while ($cont < $diadasemana) {
                                    echo "<td></td>";
                                    $cont++;
                                }
                            }
                    ?>
                    <td width=30><center><?php echo $i;?></center></td>
                    <?php
                        if ($diadasemana == 6) {
                    ?>
                       </tr>
                       <tr>
                    <?php
                        }
                    ?>
                </tr>
            </table>
        </div>
        <?php
            }
            
          }
          elseif($mes == 4) {
                    $dias = 31;
                    //$nome = "Janeiro";
        ?>
        <div>
            ABRIL
            <table width="210" border="1" cellspacing="1" cellpadding="1">
                <tr>
                   <td width=30><center>D</center></td>
                   <td width=30><center>S</center></td>
                   <td width=30><center>T</center></td>
                   <td width=30><center>Q</center></td>
                   <td width=30><center>Q</center></td>
                   <td width=30><center>S</center></td>
                   <td width=30><center>S</center></td>
                </tr>
                <tr>
                    <?php
                        for ($i = 1; $i <= $dias; $i++) {
                            $diadasemana = date("w", mktime(0, 0, 0, $mes, $i, $ano));
                            $cont = 0;
                            if ($i == 1) {
                                while ($cont < $diadasemana) {
                                    echo "<td></td>";
                                    $cont++;
                                }
                            }
                    ?>
                    <td width=30><center><?php echo $i;?></center></td>
                    <?php
                        if ($diadasemana == 6) {
                    ?>
                       </tr>
                       <tr>
                    <?php
                        }
                    ?>
                </tr>
            </table>
        </div>
        <?php
            }
            
          }
          elseif($mes == 5) {
                    $dias = 31;
                   // $nome = "Janeiro";
        ?>
        <div>
            MAIO
            <table width="210" border="1" cellspacing="1" cellpadding="1">
                <tr>
                   <td width=30><center>D</center></td>
                   <td width=30><center>S</center></td>
                   <td width=30><center>T</center></td>
                   <td width=30><center>Q</center></td>
                   <td width=30><center>Q</center></td>
                   <td width=30><center>S</center></td>
                   <td width=30><center>S</center></td>
                </tr>
                <tr>
                    <?php
                        for ($i = 1; $i <= $dias; $i++) {
                            $diadasemana = date("w", mktime(0, 0, 0, $mes, $i, $ano));
                            $cont = 0;
                            if ($i == 1) {
                                while ($cont < $diadasemana) {
                                    echo "<td></td>";
                                    $cont++;
                                }
                            }
                    ?>
                    <td width=30><center><?php echo $i;?></center></td>
                    <?php
                        if ($diadasemana == 6) {
                    ?>
                       </tr>
                       <tr>
                    <?php
                        }
                    ?>
                </tr>
            </table>
        </div>
         <?php
            }
            
          }
          elseif($mes == 6) {
                    $dias = 31;
                   // $nome = "Janeiro";
        ?>
        <div>
            JUNHO
            <table width="210" border="1" cellspacing="1" cellpadding="1">
                <tr>
                   <td width=30><center>D</center></td>
                   <td width=30><center>S</center></td>
                   <td width=30><center>T</center></td>
                   <td width=30><center>Q</center></td>
                   <td width=30><center>Q</center></td>
                   <td width=30><center>S</center></td>
                   <td width=30><center>S</center></td>
                </tr>
                <tr>
                    <?php
                        for ($i = 1; $i <= $dias; $i++) {
                            $diadasemana = date("w", mktime(0, 0, 0, $mes, $i, $ano));
                            $cont = 0;
                            if ($i == 1) {
                                while ($cont < $diadasemana) {
                                    echo "<td></td>";
                                    $cont++;
                                }
                            }
                    ?>
                    <td width=30><center><?php echo $i;?></center></td>
                    <?php
                        if ($diadasemana == 6) {
                    ?>
                       </tr>
                       <tr>
                    <?php
                        }
                    ?>
                </tr>
            </table>
        </div>
         <?php
            }
            
          }
          elseif($mes == 7) {
                    $dias = 31;
                   // $nome = "Janeiro";
        ?>
        <div>
            JULHO
            <table width="210" border="1" cellspacing="1" cellpadding="1">
                <tr>
                   <td width=30><center>D</center></td>
                   <td width=30><center>S</center></td>
                   <td width=30><center>T</center></td>
                   <td width=30><center>Q</center></td>
                   <td width=30><center>Q</center></td>
                   <td width=30><center>S</center></td>
                   <td width=30><center>S</center></td>
                </tr>
                <tr>
                    <?php
                        for ($i = 1; $i <= $dias; $i++) {
                            $diadasemana = date("w", mktime(0, 0, 0, $mes, $i, $ano));
                            $cont = 0;
                            if ($i == 1) {
                                while ($cont < $diadasemana) {
                                    echo "<td></td>";
                                    $cont++;
                                }
                            }
                    ?>
                    <td width=30><center><?php echo $i;?></center></td>
                    <?php
                        if ($diadasemana == 6) {
                    ?>
                       </tr>
                       <tr>
                    <?php
                        }
                    ?>
                </tr>
            </table>
        </div>
        <?php
            }
            
          }
          elseif($mes == 8) {
                    $dias = 31;
                   // $nome = "Janeiro";
        ?>
        <div>
            AGOSTO
            <table width="210" border="1" cellspacing="1" cellpadding="1">
                <tr>
                   <td width=30><center>D</center></td>
                   <td width=30><center>S</center></td>
                   <td width=30><center>T</center></td>
                   <td width=30><center>Q</center></td>
                   <td width=30><center>Q</center></td>
                   <td width=30><center>S</center></td>
                   <td width=30><center>S</center></td>
                </tr>
                <tr>
                    <?php
                        for ($i = 1; $i <= $dias; $i++) {
                            $diadasemana = date("w", mktime(0, 0, 0, $mes, $i, $ano));
                            $cont = 0;
                            if ($i == 1) {
                                while ($cont < $diadasemana) {
                                    echo "<td></td>";
                                    $cont++;
                                }
                            }
                    ?>
                    <td width=30><center><?php echo $i;?></center></td>
                    <?php
                        if ($diadasemana == 6) {
                    ?>
                       </tr>
                       <tr>
                    <?php
                        }
                    ?>
                </tr>
            </table>
        </div>
        <?php
            }
            
          }
          elseif($mes == 9) {
                    $dias = 31;
                   // $nome = "Janeiro";
        ?>
        <div>
            SETEMBRO
            <table width="210" border="1" cellspacing="1" cellpadding="1">
                <tr>
                   <td width=30><center>D</center></td>
                   <td width=30><center>S</center></td>
                   <td width=30><center>T</center></td>
                   <td width=30><center>Q</center></td>
                   <td width=30><center>Q</center></td>
                   <td width=30><center>S</center></td>
                   <td width=30><center>S</center></td>
                </tr>
                <tr>
                    <?php
                        for ($i = 1; $i <= $dias; $i++) {
                            $diadasemana = date("w", mktime(0, 0, 0, $mes, $i, $ano));
                            $cont = 0;
                            if ($i == 1) {
                                while ($cont < $diadasemana) {
                                    echo "<td></td>";
                                    $cont++;
                                }
                            }
                    ?>
                    <td width=30><center><?php echo $i;?></center></td>
                    <?php
                        if ($diadasemana == 6) {
                    ?>
                       </tr>
                       <tr>
                    <?php
                        }
                    ?>
                </tr>
            </table>
        </div>
        <?php
            }
            
          }
          elseif($mes == 10) {
                    $dias = 31;
                   // $nome = "Janeiro";
        ?>
        <div>
            OUTUBRO
            <table width="210" border="1" cellspacing="1" cellpadding="1">
                <tr>
                   <td width=30><center>D</center></td>
                   <td width=30><center>S</center></td>
                   <td width=30><center>T</center></td>
                   <td width=30><center>Q</center></td>
                   <td width=30><center>Q</center></td>
                   <td width=30><center>S</center></td>
                   <td width=30><center>S</center></td>
                </tr>
                <tr>
                    <?php
                        for ($i = 1; $i <= $dias; $i++) {
                            $diadasemana = date("w", mktime(0, 0, 0, $mes, $i, $ano));
                            $cont = 0;
                            if ($i == 1) {
                                while ($cont < $diadasemana) {
                                    echo "<td></td>";
                                    $cont++;
                                }
                            }
                    ?>
                    <td width=30><center><?php echo $i;?></center></td>
                    <?php
                        if ($diadasemana == 6) {
                    ?>
                       </tr>
                       <tr>
                    <?php
                        }
                    ?>
                </tr>
            </table>
        </div>
         <?php
            }
            
          }
          elseif($mes == 11) {
                    $dias = 31;
                   // $nome = "Janeiro";
        ?>
         <div>
            NOVEMBRO
            <table width="210" border="1" cellspacing="1" cellpadding="1">
                <tr>
                   <td width=30><center>D</center></td>
                   <td width=30><center>S</center></td>
                   <td width=30><center>T</center></td>
                   <td width=30><center>Q</center></td>
                   <td width=30><center>Q</center></td>
                   <td width=30><center>S</center></td>
                   <td width=30><center>S</center></td>
                </tr>
                <tr>
                    <?php
                        for ($i = 1; $i <= $dias; $i++) {
                            $diadasemana = date("w", mktime(0, 0, 0, $mes, $i, $ano));
                            $cont = 0;
                            if ($i == 1) {
                                while ($cont < $diadasemana) {
                                    echo "<td></td>";
                                    $cont++;
                                }
                            }
                    ?>
                    <td width=30><center><?php echo $i;?></center></td>
                    <?php
                        if ($diadasemana == 6) {
                    ?>
                       </tr>
                       <tr>
                    <?php
                        }
                    ?>
                </tr>
            </table>
        </div>
        <?php
            }
            
          }
          elseif($mes == 12) {
                    $dias = 31;
                   // $nome = "Janeiro";
        ?>
        <div>
            DEZEMBRO
            <table width="100" border="1" cellspacing="1" cellpadding="1">
                <tr>
                   <td width="30"><center>D</center></td>
                   <td width="30"><center>S</center></td>
                   <td width="30"><center>T</center></td>
                   <td width="30"><center>Q</center></td>
                   <td width="30"><center>Q</center></td>
                   <td width="30"><center>S</center></td>
                   <td width="30"><center>S</center></td>
                </tr>
                <tr>
                    <?php
                        for ($i = 1; $i <= $dias; $i++) {
                            $diadasemana = date("w", mktime(0, 0, 0, $mes, $i, $ano));
                            $cont = 0;
                            if ($i == 1) {
                                while ($cont < $diadasemana) {
                                    echo "<td></td>";
                                    $cont++;
                                }
                            }
                    ?>
                    <td width="30"><center><?php echo $i;?></center></td>
                    <?php
                        if ($diadasemana == 6) {
                    ?>
                       </tr>
                       <tr>
                    <?php
                        }
                    ?>
                </tr>
            </table>
        </div>
         <?php
            }
            
          }
            }
            }
        ?>
    </body>
</html>