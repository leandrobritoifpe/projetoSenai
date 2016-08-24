<?php
$servidor = "52.34.253.148";
$usuario = "pe";
$banco = "DBSystemSec";
$senha = "!@#123qwe";
//NÃ£o Alterar abaixo:
$conmssql = mssql_connect($servidor,$usuario,$senha);
$db = mssql_select_db($banco, $conmssql);
if ($conmssql && $db){
echo "Parabens!! A conexÃ£o ao banco de dados ocorreu normalmente!";
} else {
echo "Nao foi possivel conectar ao banco MSSQL";
}
mssql_close ();