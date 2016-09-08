<?php

/*  ARQUVIO gerenciadorDeFuncoes.php
 * OBJETIVO : SERVIR DE BIBLIOTECA PARA FUNCAO BÁSICAS
 * CRIADA : 25/08/2016
 * ULTIMA ATUALIZACAO 08/009/2016
 * 
 * DS-> LEANDRO BRITO ;)
 */


include_once './util/ConnectaBanco.php';

//FUNCAO QUE RETORNA DIA DA SEMANA
function retornaDiaDaSemana($diaNumericoDaSemana) {
    $array = [
        "0" => "DOM",
        "1" => "SEG",
        "2" => "TER",
        "3" => "QUA",
        "4" => "QUI",
        "5" => "SEX",
        "6" => "SAB",
    ];
    return $array[$diaNumericoDaSemana];
}

function validaSeDataExiste($ano) {
    $con = new ConnectaBanco();
    $conexao = $con->conectandoComBanco();
    $select = "SELECT * FROM PHE_CALENDARIO_ESCOLA";
    $resultado = mssql_query($select);
    $anoDoBanco = "";
    if ($resultado) {
        while ($row = mssql_fetch_array($resultado)) {
            $anoDoBanco = $row['DATADIA'];
        }
        mssql_close($conexao);
        $anoDoBanco = substr($anoDoBanco, 0, -6);
        $ano = substr($ano, 0, -6);
        if ($ano == $anoDoBanco) {
            return true;
        } else {
            return false;
        }
    } else {
        return 0;
    }
}
//FUNCAO QUE EXIBE MENSAGEM PARA USUARIO
function exibeMesagensParaUsuario($numeroMensagem) {
    $array = [
        "0" => "CALENDARIO ESCOLAR GERADO COM SUCESSO",
        "1" => "OCORREU UM ERRO AO GERAR O CALENDARIO",
        "2" => "DATA NAO LETIVA,REGISTRADA COM SUCESSO",
        "3" => "OCORREU UM ERRO AO TENTAR REGISTRO A DATA",
        "505" => "ERRO AO TENTAR SE COMUNICAR COM O BANCO, ENTRE EM CONTATO COM O ADMINISTRADOR DO SISTEMA",
        "5" => "ATENCAO! ESSE DIA 'NÃO LETIVO', JA ESTAR CADASTRADO",
        "6" => "DIAS LETIVOS GERADOS COM SUCESSO",
         "7" => "PERIDO CADASTRADO COM SUCESSO",
        "8" => "DIAS LETIVOS DO CURSO TECNICO, GERADOS COM SUCESSO",
        "9" => "A ESCOLA AINDA NAO TEM TURNOS CADASTRADOS",
        "12" => "DIA NÃO LETIVO DO TURNO SELECIONADO, CADASTRADO COM SUCESSO",
        "13" => "E IMPORTANTE QUE TODOS OS FERIADOS ESTEJAM CADASTRADOS ANTES DE GERAR O CALENDARIO, POR FAVOR CADASTRE OS FERIADOS!!",
        "14" => "DIA NAO LETIVO DELETADO COM SUCESSO",
    ];
    return $array[$numeroMensagem];
}

//FUNCAO QUE RETORNA STRIN EM MAIUSCULO
function converteStringParaMaiusculo($string) {
    return strtoupper($string);
}
