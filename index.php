<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="estilo.css"/> 
<title>Desafio devRamper</title>
</head>
<body>
    <div class="conteudo">
        <span class="titulo">
            Desafio devRamper
        </span>
        <br>
       
        <?php
            
            require_once("conexaodb.php");
            require_once("classes.php");
            $sql = "SELECT * FROM empresas ORDER BY id ASC";
            $query = mysqli_query($conexao, $sql);
            if (!$query) {

                echo 'Erro na query: '.mysql_error();
                exit;

            } else {

            $num_rows = mysqli_num_rows($query);
            $linha = mysqli_fetch_assoc($query);

            }
            $x = 0;
?>
<?php if (!isset($_GET['menu']) || $_GET['menu'] == ''){ ?>
    <a href="index.php?menu=1&id=0" class="link"><input type="button" value="Adicionar" class="botao"></a>
    <a href="index.php?menu=2" class="link"><input type="button" value="Pesquisar" class="botao"></a>
    <br>
    <span class="subTitulo">
            <?=$num_rows?> Empresas Cadastradas (Clique para detalhes)
    </span>
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
    <table class="tabela" cellspacing="0" rules="none">
<?php
            do {
                $x++;
                ?>
                    <tr bgcolor="<?php if (($x%2)==1) { echo '#AAA'; } else { echo '#999';}?>" class="item" onclick="location.href = 'index.php?menu=1&id=<?=$linha['id']?>'">
                        <td width="46%" align="left">
                            <?php echo $linha['id'].' - '.$linha['nome']?>
                        </td>
                        <td width="33%">
                            <?=$linha['cnpj']?>
                        </td>
                        <td width="20%">
                            <?=$linha['cnae']?>
                        </td>
                    </tr>
                <?php
            } while($linha = mysqli_fetch_assoc($query));
        ?>
        </table>
        <?php } //fecha condicional da página inicial



if (isset($_GET['menu']) && $_GET['menu'] == 1){
    
    $empresa = new BuscaEmpresa($_GET['id'],'','','','');
    ?>
        <form action="processaCrud.php" class="formCadastro" method="post" id="formCadastro">
            
            <table class="tabelaCadastro" cellspacing="0">
                <tr class="subTitulo" >
                    <td colspan="2">
                    <?php if ($_GET['id'] == 0) { echo 'Cadastro de Empresas'; } else { echo 'Editando '.$empresa->nome; } ?>
                    </td>
                </tr>
                <tr>
                    <td align="right" width="50px">Nome: </td>
                    <td><input type="text" value="<?php echo $empresa->nome; ?>" class="inputCadastro" name="nome" maxlength="100" style="border-top-left-radius: 1vw;border-top-right-radius: 1vw;border-bottom:none" required></td>
                </tr>
                <tr>
                    <td align="right">CNPJ: </td>
                    <td><input type="text" value="<?php echo $empresa->cnpj; ?>" class="inputCadastro" name="cnpj" maxlength="18" pattern="[0-9]{2}[\.]?[0-9]{3}[\.]?[0-9]{3}[\.]?[\/]?[0-9]{4}[-]?[0-9]{2}" style="border-bottom:none" required></td>
                </tr>
                <tr>
                    <td align="right">CNAE Principal: </td>
                    <td><input type="text" value="<?php echo $empresa->cnae; ?>" class="inputCadastro" name="cnae" maxlength="9" required></td>
                </tr>
                <tr>
                    <td align="right">Endereço: </td>
                    <td><input type="text" value="<?php echo $empresa->endereco; ?>" class="inputCadastro" name="endereco" maxlength="255" style="border-bottom-left-radius: 1vw;border-bottom-right-radius: 1vw;border-top:none" required></td>
                </tr>
            </table>
            <input type="button" value="Voltar" class="botao" onclick="history.go(-1);">
            <input type="hidden" value="<?php echo $empresa->id; ?>" name="id">
            <input type="hidden" value="" name="deletar" id="deletar">
            <input type="submit" value="<?php if ($_GET['id'] == 0) { echo 'Cadastrar'; } else { echo 'Atualizar'; } ?>" class="botao">
            <?php if ($_GET['id'] != 0) { ?><input type="button" value="Deletar" class="botao" onclick="confirmaDelete()"><?php } ?>
        </form>
        <script>
            function confirmaDelete(){
                var temp = confirm('Deseja realmente deletar a empresa <?=$empresa->nome?>?');
                if (temp == true) {
                    document.getElementById('deletar').value = true;
                    document.getElementById('formCadastro').submit();
                }
            }
        </script>
        <?php
        } //fecha condicional do crud

if (isset($_GET['menu']) && $_GET['menu'] == 2){
?>
    <span class="subTitulo">Pesquisa de Empresa</span>
    <form action="index.php?menu=3" method="post" class="formPesquisa">
        <table class="tabelaPesquisa"  cellspacing="0">
            <tr>
                <td align="right" width="50%">
                Por nome: 
                </td>
                <td>
                <input type="text" class="inputPesquisa" name="nome" style="border-bottom:none;border-top-left-radius: 1vw;border-top-right-radius: 1vw;">
                </td>
            </tr>
            <tr>
                <td align="right">
                Por CNPJ: 
                </td>
                <td>
                <input type="text" class="inputPesquisa" name="cnpj" style="border-bottom-left-radius: 1vw;border-bottom-right-radius: 1vw;">
                </td>
            </tr>
        </table>
    <a href="index.php" class="link">
        <input type="button" value="Voltar" class="botao">
    </a>
    <input type="hidden" value="true" name="pesquisa">
    <input type="submit" value="Pesquisar" class="botao">
    </form>
<?php
} //fecha condicional de pesquisa


if (isset($_GET['menu']) && $_GET['menu'] == 3){
    if (isset($_POST['pesquisa']) && $_POST['pesquisa'] == true ){
        $empresa = new BuscaEmpresa('',$_POST['nome'], $_POST['cnpj'],'','');
        $empresa->buscar($_POST['nome'], $_POST['cnpj']);
    }
} //fecha condicional do resultado da pesquisa
        ?>
    </div><!-- Fecha a DIV conteúdo -->
</body>
</html>
