<?php
// By RL System - www.rlsystem.com.brs15/09/2016
class ContasReceberDAO
{
	// M�todo que realiza um insert, ele pede como par�metro um objeto do tipo ContasReceber
	public function InsertContasReceber(ContasReceber $ContasReceber)
	{
		// Declaramos a vari�vel $con como global, se n�o o php estaria criando ela novamente, lembrando que ela
		// � um objeto do tipo MySQLI, que foi instanciada no arquivo de Conexao.php.
		global $con;
		
		/*
		 * Estamos preparando um comando SQL, onde estaremos utilizando par�metros, utilizando a nosso objeto $con
		 * e chamando o m�todo que realiza esse procedimento no caso prepare
		*/
		$SQL = $con->prepare("INSERT INTO contasreceber (documento_contasreceber, valor_contasreceber, cliente_contasreceber, status_contasreceber, vencimento_contasreceber) VALUES (?, ?, ?, ?, ?)") or die ($mysqli->error);
		/* Estamos informado as vari�veis que v�o conter os valores dos par�metros
		 * Veja que temos "sdiss" ou seja indicando que o primeiro � string, segundo double, terceiro inteiro e os dois �ltimos string tamb�m
		 * Veja mais informa��es sobre o bind param em http://br2.php.net/manual/pt_BR/mysqli-stmt.bind-param.php
		*/
		$SQL->bind_param("sdiss", $P1, $P2, $P3, $P4, $P5);
		
		/* Aqui informando os valores, veja que estaremos recuperando eles pelos nas propriedades
		 * E por isso temos que informar no m�todo um objeto do tipo ContasReceber, j� que essas propriedades
		 * Ficam naquela classe.
		*/
		$P1 = $ContasReceber->getDocumento_contasreceber();
		$P2 = $ContasReceber->getValor_contasreceber();
		$P3 = $ContasReceber->getCliente_contasreceber();
		$P4 = $ContasReceber->getStatus_contasreceber();
		$P5 = $ContasReceber->getVencimento_contasreceber();
		
		// Simplesmente executo esse nosso comando.
		$SQL->execute();
		
		/* Verifica o n�mero de linhas que ocorreu, sendo maior que 0, o registro foi executado com sucesso
		 * Com isso esse m�todo retorna TRUE
		*/
		if ($SQL->affected_rows > 0)
			return true;
	}
	
	// Segue a mesma id�ia dos outros m�todos, claro com outro comando SQL, de acordo com que o m�todo faz.
	public function ShowContasReceber(ContasReceber $ContasReceber)
	{
		global $con;
		
		// Se a propriedade ID estiver vazia ele entra no IF e busca todos os registros
		if ($ContasReceber->getId_contasreceber() == null)
		{
			$SQL = $con->query("SELECT * FROM contasreceber");
			
			return $SQL;
		}
		/* Nesse caso ele retornando false no if, ele entra nesse bloco
		 * A Id�ia aqui, � que vamos utilizar o mesmo m�todo para exibir todos registros,
		 * ou quando precisarmos exibir somente um registro no caso de uma edi��o do mesmo, vamos passar para ele o ID da linha que estaremos precisando.
		*/
		else 
		{
			$SQL = $con->query("SELECT * FROM contasreceber WHERE id_contasreceber = '".$ContasReceber->getId_contasreceber()."'");
			
			// Recupero a linha de registro
			$rs = $SQL->fetch_array();
			
			// Seto as propriedades com seus respectivo valores.
			$ContasReceber->setId_contasreceber($rs["id_contasreceber"]);
			$ContasReceber->setDocumento_contasreceber($rs["documento_contasreceber"]);
			$ContasReceber->setCliente_contasreceber($rs["cliente_contasreceber"]);
			$ContasReceber->setValor_contasreceber($rs["valor_contasreceber"]);
			$ContasReceber->setVencimento_contasreceber($rs["vencimento_contasreceber"]);
			$ContasReceber->setStatus_contasreceber($rs["status_contasreceber"]);
			
		}	
	}
	
	/* Segue a mesma id�ia dos outros m�todos, mas aqui ele vai nos gerar
	 * uma select list de clientes que temos no banco de dados
	*/
	public function ShowClientes(ContasReceber $ContasReceber)
	{
		global $con;
		
		$SQL = $con->query("SELECT * FROM clientes");
		
		/*
		 * Com esse if estamos verificando se temos valor na propriedade id de contasreceber
		 * n�o tendo ele entra no if ele criar um array(uma lista) de itens para nosso select list.
		*/
		if ($ContasReceber->getId_contasreceber() == null)
		{
			while($registros = $SQL->fetch_array())
			{
				$selectList[] = "<option value='".$registros["id_cliente"]."'>".$registros["nome_cliente"]."</option>";
			}	
		} 
		else 
		{
			/* Bom se ele verificou que ela n�o � nula, ent�o temos valores
			 * Criamos uma vari�vel $id que recebe o valor que definimos na chamada do objeto			*/
			$id = $ContasReceber->getCliente_contasreceber();
			
			while($registros = $SQL->fetch_array())
			{
				/* 
				 * Temos o mesmo c�digo de cima, mais com uma condi��o ($registros["id_cliente"] == $id ? 'selected=""' : '')
				 * Se id que est� sendo trazido igual a vari�vel id que o definirmos acrescenta um �selected�
				 * Para quem j� conhece o select list sabe que com isso ele j� deixa o mesmo selecionado.
				 * Claro isso acontecer� na hora de editarmos um registro, caso contr�rio n�o teria sentido.
				*/
				$selectList[] = "<option ".($registros["id_cliente"] == $id ? 'selected=""' : '')." value='".$registros["id_cliente"]."'>".$registros["nome_cliente"]."</option>";
			}	
		}
			// Retorna uma lista de op��es de uma select list.
			return $selectList;
	}
	
	// Segue a mesma id�ia dos outros m�todos, claro com outra SQL, de acordo com que o m�todo faz.
	public function DeleteContasReceber(ContasReceber $ContasReceber)
	{
		global $con;
		$SQL = $con->prepare("DELETE FROM contasreceber WHERE id_contasreceber = ?");
		$SQL->bind_param("i", $P1);
		$P1 = $ContasReceber->getId_contasreceber();;
		$SQL->execute();
		
		if($SQL->affected_rows > 0)
			return true;
	}
	
	// Segue a mesma id�ia dos outros m�todos, claro com outra SQL, de acordo com que o m�todo faz.
	public function UpdateContasReceber(ContasReceber $ContasReceber)
	{
		global $con;
		$SQL = $con->prepare("UPDATE contasreceber SET documento_contasreceber = ?, valor_contasreceber = ?, cliente_contasreceber = ?, status_contasreceber = ?,  vencimento_contasreceber = ? WHERE id_contasreceber = ?");
		$SQL->bind_param("sdissi", $P1, $P2, $P3, $P4, $P5, $P6);
		
		$P1 = $ContasReceber->getDocumento_contasreceber();
		$P2 = $ContasReceber->getValor_contasreceber();
		$P3 = $ContasReceber->getCliente_contasreceber();
		$P4 = $ContasReceber->getStatus_contasreceber();
		$P5 = $ContasReceber->getVencimento_contasreceber();
		$P6 = $ContasReceber->getId_contasreceber();
		
		$SQL->execute();
		
		if($SQL->affected_rows > 0)
			return true;
	}
}
?>