<!DOCTYPE html>
<html>
<head>
    <title>Cadastro de Clientes</title>
</head>
<body>

<h2 style="text-align: center;">Cadastro de Clientes</h2>

<div style="text-align: center;">
    <form method="post" action="cadastrarCliente">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" required>
        <br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
        <br><br>

        <label for="data_nascimento">Data de Nascimento:</label>
        <input type="date" name="data_nascimento" id="data_nascimento" required>
        <br><br>

        <input type="submit" value="Salvar">
    </form>

    <?php 
        if (!empty($msg)) {
            echo "<p style='text-align: center;'> $msg </p>";
        }
    ?>
    
    <hr />
    
    <form action="listaClientes" style="display: inline;">
        <input type="submit" value="Nossos Clientes">
    </form>
</div>

</body>
</html>
