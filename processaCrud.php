<?php
    require("classes.php");
    if (isset($_POST['id']) && $_POST['id'] == 0) {
        $empresa = new NovaEmpresa($_POST['nome'], $_POST['cnpj'], $_POST['cnae'], $_POST['endereco']);
        echo $empresa->salvar();
    } elseif (isset($_POST['id'])) {
        $empresa = new AtualizaEmpresa($_POST['id'], $_POST['nome'], $_POST['cnpj'], $_POST['cnae'], $_POST['endereco']);
        if (isset($_POST['deletar']) && $_POST['deletar'] == true) {
            echo $empresa->deletar();
        } else {
            echo $empresa->atualizar();
        }
    }

?>