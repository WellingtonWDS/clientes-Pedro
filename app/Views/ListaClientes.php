<!DOCTYPE html>
<html>

<head>
    <title>Lista de Clientes</title>

</head>

<body>

    <h2 style="text-align: center;">Clientes cadastrados</h2>

    <div style="text-align: center;">
        <form action="database" style="display: inline;">
            <input type="submit" value="Página de cadastro">
        </form>
    </div>
    <br>

    <?php if (empty($result)): ?>

    
        <p style="text-align: center;">Nenhum cliente encontrado.</p>

    <?php else: ?>
        <table style='margin: auto; border-collapse: collapse; width: 80%; text-align: center;'>
        <tr><th>Código</th><th>Nome</th><th>Email</th><th>Data de Nascimento</th></tr>
    
        <?php foreach ($result as $row): ?>
        
            <?php $data_nascimento = date('d-m-Y', strtotime($row->data_nascimento)); ?>
            
            <tr>
            <td style='border: 1px solid black;'> <?= $row->id; ?> </td>
            <td style='border: 1px solid black;'> <?= $row->nome; ?> </td>
            <td style='border: 1px solid black;'> <?= $row->email; ?> </td>
            <td style='border: 1px solid black;'> <?= $data_nascimento; ?></td>
            </tr>
    
        <?php endforeach; ?>
        </table>
    <?php endif; ?>

    <br><br>
    <div style="text-align: center;">
        <form action="enviarEmail" style="display: inline;">
            <input type="submit" value="Enviar email para os aniversariantes da semana">
        </form>
    </div>

    <?php 
        if (!empty($msg)) {
            echo "<p style='text-align: center;'> $msg </p>";
        }

        if (!empty($emailsParaParabens)) {
            echo "<p style='text-align: center;'> Um email com os parabéns foram enviados para os seguintes clientes: </p>";
            foreach ($emailsParaParabens as $email) {
                echo "<p style='text-align: center;'>" . $email . "</p>";
            }
        }
    ?>

</body>

</html>