<?php
function abrirConexao() {
	
	$con = @mysql_connect("52.34.253.148", "pe", "!@#123qwe");
        //@mysql_connect("52.34.253.148", "pe", "!@#123qwe");
	
	if (!$con) {
		die ("Erro ao abrir a conexao com o MySQL: " . mysql_error ());
	}
	
	mysql_select_db ("DBSystemSec", $con);
	
	return $con;
}
?>