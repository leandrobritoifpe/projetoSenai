<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Calendário</title>
    </head>
    <?php
    $servidor = "52.34.253.148";
        $usuario = "pe";
        $banco = "DBSystemSec";
        $senha = "!@#123qwe";
//NÃ£o Alterar abaixo:
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
            //$arrayMesAno[] = substr($linha['DATADIA'], 5, 9);
        }
        $sql = "SELECT * FROM PHE_CALENDARIO_ESCOLA WHERE CODFILIAL = $codFilial";
        $result = mssql_query($sql);
        while ($linha = mssql_fetch_array($result)) {
            //$mes = substr($linha['DATADIA'], 5, -3);
            //for ($i = 0; $i < count($arrayIdCalendario); $i++) {
               $mes += +1;
                    // ""2016-05-30
                    //$contador += 1;
                    //echo "deu merda";
                    $ano = substr($arrayDataDiaCalendario[0], 0, -6);
                    if ($mes == 1) {
                        $dias = 31;
                        $nome = "Janeiro";
                        //echo $nome . " de " . $ano;
                       // echo "<br>";
                    ?>
    <div>janiero
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
                        <?php
                        echo "<tr>";
                        for ($i = 1; $i <= $dias; $i++) {
                            $diadasemana = date("w", mktime(0, 0, 0, $mes, $i, $ano));
                            $cont = 0;
                            if ($i == 1) {
                                while ($cont < $diadasemana) {
                                    echo "<td></td>";
                                    $cont++;
                                }
                            }
                            echo "<td width=30><center>";
                            echo $i;
                            echo "</center></td>";
                            if ($diadasemana == 6) {
                                echo "</tr>";
                                echo "<tr>";
                            }
                        }
                        echo "</tr>";
                        echo"</table>";
                        echo "</div>";
                    }
                    elseif($mes == 2) {
                        $dias = 28;
                        $nome = "Fevereiro";
                          //echo $nome . " de " . $ano;
                    ?>
                        <div>fevereiro
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
                        <?php
                        echo "<tr>";
                        for ($i = 1; $i <= $dias; $i++) {
                            $diadasemana = date("w", mktime(0, 0, 0, $mes, $i, $ano));
                            $cont = 0;
                            if ($i == 1) {
                                while ($cont < $diadasemana) {
                                    echo "<td></td>";
                                    $cont++;
                                }
                            }
                            echo "<td width=30><center>";
                            echo $i;
                            echo "</center></td>";
                            if ($diadasemana == 6) {
                                echo "</tr>";
                                echo "<tr>";
                            }
                        }
                        echo "</tr>";
                        echo"</table>";
                        echo "<div>";
                    }
                    elseif($mes == 3) {
                        $dias = 31;
                        $nome = "Março";
                          echo $nome . " de " . $ano;
                    ?>
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
                        <?php
                        echo "<tr>";
                        for ($i = 1; $i <= $dias; $i++) {
                            $diadasemana = date("w", mktime(0, 0, 0, $mes, $i, $ano));
                            $cont = 0;
                            if ($i == 1) {
                                while ($cont < $diadasemana) {
                                    echo "<td></td>";
                                    $cont++;
                                }
                            }
                            echo "<td width=30><center>";
                            echo $i;
                            echo "</center></td>";
                            if ($diadasemana == 6) {
                                echo "</tr>";
                                echo "<tr>";
                            }
                        }
                        echo "</tr>";
                    }
                    elseif($mes == 4) {
                        $dias = 30;
                        $nome = "Abril";
                          echo $nome . " de " . $ano;
                    ?>
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
                        <?php
                        echo "<tr>";
                        for ($i = 1; $i <= $dias; $i++) {
                            $diadasemana = date("w", mktime(0, 0, 0, $mes, $i, $ano));
                            $cont = 0;
                            if ($i == 1) {
                                while ($cont < $diadasemana) {
                                    echo "<td></td>";
                                    $cont++;
                                }
                            }
                            echo "<td width=30><center>";
                            echo $i;
                            echo "</center></td>";
                            if ($diadasemana == 6) {
                                echo "</tr>";
                                echo "<tr>";
                            }
                        }
                        echo "</tr>";
                    }
                    elseif($mes == 5) {
                        $dias = 31;
                        $nome = "Maio";
                          echo $nome . " de " . $ano;
                    ?>
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
                        <?php
                        echo "<tr>";
                        for ($i = 1; $i <= $dias; $i++) {
                            $diadasemana = date("w", mktime(0, 0, 0, $mes, $i, $ano));
                            $cont = 0;
                            if ($i == 1) {
                                while ($cont < $diadasemana) {
                                    echo "<td></td>";
                                    $cont++;
                                }
                            }
                            echo "<td width=30><center>";
                            echo $i;
                            echo "</center></td>";
                            if ($diadasemana == 6) {
                                echo "</tr>";
                                echo "<tr>";
                            }
                        }
                        echo "</tr>";
                    }
                    elseif($mes == 6) {
                        $dias = 30;
                        $nome = "Junho";
                          echo $nome . " de " . $ano;
                    ?>
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
                        <?php
                        echo "<tr>";
                        for ($i = 1; $i <= $dias; $i++) {
                            $diadasemana = date("w", mktime(0, 0, 0, $mes, $i, $ano));
                            $cont = 0;
                            if ($i == 1) {
                                while ($cont < $diadasemana) {
                                    echo "<td></td>";
                                    $cont++;
                                }
                            }
                            echo "<td width=30><center>";
                            echo $i;
                            echo "</center></td>";
                            if ($diadasemana == 6) {
                                echo "</tr>";
                                echo "<tr>";
                            }
                        }
                        echo "</tr>";
                    }
                    elseif($mes == 7) {
                        $dias = 31;
                        $nome = "Julho";
                          echo $nome . " de " . $ano;
                    ?>
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
                        <?php
                        echo "<tr>";
                        for ($i = 1; $i <= $dias; $i++) {
                            $diadasemana = date("w", mktime(0, 0, 0, $mes, $i, $ano));
                            $cont = 0;
                            if ($i == 1) {
                                while ($cont < $diadasemana) {
                                    echo "<td></td>";
                                    $cont++;
                                }
                            }
                            echo "<td width=30><center>";
                            echo $i;
                            echo "</center></td>";
                            if ($diadasemana == 6) {
                                echo "</tr>";
                                echo "<tr>";
                            }
                        }
                        echo "</tr>";
                    }
                    elseif($mes == 8) {
                        $dias = 31;
                        $nome = "Agosto";
                          echo $nome . " de " . $ano;
                    ?>
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
                        <?php
                        echo "<tr>";
                        for ($i = 1; $i <= $dias; $i++) {
                            $diadasemana = date("w", mktime(0, 0, 0, $mes, $i, $ano));
                            $cont = 0;
                            if ($i == 1) {
                                while ($cont < $diadasemana) {
                                    echo "<td></td>";
                                    $cont++;
                                }
                            }
                            echo "<td width=30><center>";
                            echo $i;
                            echo "</center></td>";
                            if ($diadasemana == 6) {
                                echo "</tr>";
                                echo "<tr>";
                            }
                        }
                        echo "</tr>";
                    }
                    elseif($mes == 9) {
                        $dias = 30;
                        $nome = "Setembro";
                          echo $nome . " de " . $ano;
                    ?>
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
                        <?php
                        echo "<tr>";
                        for ($i = 1; $i <= $dias; $i++) {
                            $diadasemana = date("w", mktime(0, 0, 0, $mes, $i, $ano));
                            $cont = 0;
                            if ($i == 1) {
                                while ($cont < $diadasemana) {
                                    echo "<td></td>";
                                    $cont++;
                                }
                            }
                            echo "<td width=30><center>";
                            echo $i;
                            echo "</center></td>";
                            if ($diadasemana == 6) {
                                echo "</tr>";
                                echo "<tr>";
                            }
                        }
                        echo "</tr>";
                    }
                    elseif($mes == 10) {
                        $dias = 31;
                        $nome = "Outubro";
                          echo $nome . " de " . $ano;
                    ?>
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
                        <?php
                        echo "<tr>";
                        for ($i = 1; $i <= $dias; $i++) {
                            $diadasemana = date("w", mktime(0, 0, 0, $mes, $i, $ano));
                            $cont = 0;
                            if ($i == 1) {
                                while ($cont < $diadasemana) {
                                    echo "<td></td>";
                                    $cont++;
                                }
                            }
                            echo "<td width=30><center>";
                            echo $i;
                            echo "</center></td>";
                            if ($diadasemana == 6) {
                                echo "</tr>";
                                echo "<tr>";
                            }
                        }
                        echo "</tr>";
                    }
                    elseif($mes == 11) {
                        $dias = 30;
                        $nome = "Novembro";
                          echo $nome . " de " . $ano;
                    ?>
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
                        <?php
                        echo "<tr>";
                        for ($i = 1; $i <= $dias; $i++) {
                            $diadasemana = date("w", mktime(0, 0, 0, $mes, $i, $ano));
                            $cont = 0;
                            if ($i == 1) {
                                while ($cont < $diadasemana) {
                                    echo "<td></td>";
                                    $cont++;
                                }
                            }
                            echo "<td width=30><center>";
                            echo $i;
                            echo "</center></td>";
                            if ($diadasemana == 6) {
                                echo "</tr>";
                                echo "<tr>";
                            }
                        }
                        echo "</tr>";
                    }
                    elseif($mes == 12) {
                        $dias = 31;
                        $nome = "Dezembro";
                          echo $nome . " de " . $ano;
                    ?>
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
                        <?php
                        echo "<tr>";
                        for ($i = 1; $i <= $dias; $i++) {
                            $diadasemana = date("w", mktime(0, 0, 0, $mes, $i, $ano));
                            $cont = 0;
                            if ($i == 1) {
                                while ($cont < $diadasemana) {
                                    echo "<td></td>";
                                    $cont++;
                                }
                            }
                            echo "<td width=30><center>";
                            echo $i;
                            echo "</center></td>";
                            if ($diadasemana == 6) {
                                echo "</tr>";
                                echo "<tr>";
                            }
                        }
                        echo "</tr>";
                    }

            }
        }
        else {
            echo "deu bosta";
        }
        ?>
    </table>
    <body>
    </body>
</html>