
<?php

abstract class Empresa {

	public $nome;
	public $cnpj;
	public $cnae;
	public $endereco;
	
	public function __construct($nome, $cnpj, $cnae, $endereco){
		
		$this->nome = $nome;
		$this->cnpj = $cnpj;
		$this->cnae = $cnae;
		$this->endereco = $endereco;
	}
}
final class NovaEmpresa extends Empresa {

	public function salvar() {

			require("conexaodb.php");
			$check = "SELECT * FROM empresas WHERE nome = '$this->nome' OR cnpj = '$this->cnpj'";
			$query_check = mysqli_query($conexao, $check);
			$num_rows_check = mysqli_num_rows($query_check);
			if ($num_rows_check != 0 ) { 
				echo "<script>alert('Já existe uma empresa com este nome ou CNPJ! Tente novamente.');history.go(-1);</script>";
				exit;
			}

			$sql = "INSERT INTO empresas (nome, cnpj, cnae, endereco) VALUES ('$this->nome', '$this->cnpj', '$this->cnae', '$this->endereco')";
			$query = mysqli_query($conexao , $sql);
			if ($query) {
				return "<script>alert('A empresa ".$this->nome." foi cadastrada com sucesso!');location.href='index.php';</script>";
			} else { 
				return 'Erro ao cadastrar a empresa: '.mysqli_error($conexao);
				exit;
			}
	}
}

final class BuscaEmpresa extends Empresa {
	public $id;

	public function __construct($id, $nome, $cnpj, $cnae, $endereco)
	{
		parent::__construct($nome, $cnpj, $cnae, $endereco);
		
		$this->id = $id;
		require("conexaodb.php");
		$sql = "SELECT * FROM empresas WHERE id = '$this->id'";
		$query = mysqli_query($conexao, $sql);
		if (!$query) { echo 'Erro na consulta SQL: '.mysqli_error($conexao);
		} else {
			$linha = mysqli_fetch_assoc( $query);
			
			$this->nome = $linha['nome'];
			$this->cnpj = $linha['cnpj'];
			$this->cnae = $linha['cnae'];
			$this->endereco = $linha['endereco'];
		}
	}
	public function buscar($nome, $cnpj){

		require("conexaodb.php");
		$this->nome = $nome;
		$this->cnpj = $cnpj;
		$sql = "SELECT * FROM empresas WHERE nome LIKE '%$this->nome%' AND cnpj LIKE '%$this->cnpj%'";
		$query = mysqli_query($conexao, $sql);
		if (!$query) {
			echo 'Erro na pesquisa: '.mysqli_error($conexao);
		} else {
			$num_rows = mysqli_num_rows($query);
			if ($num_rows == 0) {
				echo 'Nenhuma empresa encontrada!<br>';
			} else {
				$linha = mysqli_fetch_assoc($query);
			echo $num_rows.' Empresas Encontradas (Clique para detalhes)'?>
        	<hr>
            <table class="itemTitulo">
                <tr>
                    <td width="46%" align="left">
                        ID - Nome
                    </td>
                    <td width="33%">
                        CNPJ
                    </td>
                    <td width="20%">
                        CNAE
                    </td>
                </tr>
            </table>
			<?php
			$x = 0;
			do {
				$x++;
				?>
			<a href="index.php?menu=1&id=<?=$linha['id']?>" class='link' >
				<table class="tabela" cellspacing="0" rules="none">
                	<tr class="item" bgcolor="<?php if (($x%2)==1) { echo '#AAA'; } else { echo '#999';}?>">
                    	<td width="46%" align="left">
                    	    <?=$linha['id']?> - <?=$linha['nome']?>
                    	</td>
                   	 <td width="33%">
							<?=$linha['cnpj']?>
                    	</td>
                    	<td width="20%">
							<?=$linha['cnae']?>
                    	</td>
					</tr>
				</table>
			</a>
			<?php
			} while($linha = mysqli_fetch_assoc($query));
			}
			?>
			<a href="index.php?menu=2" class="link">
                <input type="button" value="Voltar" class="botao">
			</a>
			<a href="index.php" class="link">
                <input type="button" value="Início" class="botao">
			</a>
			<?php
		}
	}
}

final class AtualizaEmpresa extends Empresa {
	private $id;
	
	public function __construct($id, $nome, $cnpj, $cnae, $endereco)
	{
		parent::__construct($nome, $cnpj, $cnae, $endereco);
		$this->id = $id;
	}
	public function atualizar() {

		require("conexaodb.php");
		$sql = "UPDATE empresas SET nome = '$this->nome', cnpj = '$this->cnpj', cnae = '$this->cnae', endereco = '$this->endereco' WHERE id = '$this->id'";
		$query = mysqli_query($conexao, $sql);
		if (!$query) {
			return 'Erro ao atualizar a empresa: '.mysqli_error($conexao);
		} else { 
			return "<script>alert('A empresa ".$this->nome." foi atualizada com sucesso!');location.href='index.php';</script>";
		}
	}
	public function deletar() {

		require("conexaodb.php");
		$sql = "DELETE FROM empresas WHERE id = '$this->id'";
		$query = mysqli_query($conexao, $sql);
		if (!$query) {
			return 'Erro ao deletar a empresa: '.mysqli_error($conexao);
		} else { 
			return "<script>alert('A empresa ".$this->nome." foi deletada com sucesso!');location.href='index.php';</script>";
		}
	}
}
?>
