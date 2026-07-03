<?php
require_once 'conexaoDb.php';

$mensagem = $_GET['msg'] ?? '';
$clientes = $pdo->query('SELECT * FROM clientes ORDER BY id DESC')->fetchAll();
?>

<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes Cadastrados</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background: #f4f4f4; }
        a { margin-right: 8px; }
    </style>
</head>
<body>
    <h1>Clientes Cadastrados</h1>

    <nav>
        <a href="index.php">Cadastrar</a>
        <a href="clientes.php">Atualizar Lista</a>
    </nav>

    <?php if ($mensagem): ?>
        <p style="color: green;"><?= htmlspecialchars($mensagem) ?></p>
    <?php endif; ?>

    <?php if (count($clientes) === 0): ?>
        <p>Nenhum cliente cadastrado.</p>
    <?php else: ?>
        <table>
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Telefone</th>
                <th>Ações</th>
            </tr>
            <?php foreach ($clientes as $cliente): ?>
                <tr>
                    <td><?= htmlspecialchars($cliente['nome']) ?></td>
                    <td><?= htmlspecialchars($cliente['email']) ?></td>
                    <td><?= htmlspecialchars($cliente['telefone']) ?></td>
                    <td>
                        <a href="editarCliente.php?id=<?= $cliente['id'] ?>">Editar</a>
                        <a href="excluirCliente.php?id=<?= $cliente['id'] ?>" onclick="return confirm('Deseja realmente excluir este cliente?');">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</body>
</html>
