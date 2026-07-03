<?php
require_once 'conexaoDb.php';

$mensagem = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telefone = trim($_POST['telefone'] ?? '');

    if ($nome === '' || $email === '' || $telefone === '') {
        $mensagem = 'Por favor, preencha todos os campos.';
    } else {
        $sql = 'INSERT INTO clientes (nome, email, telefone) VALUES (:nome, :email, :telefone)';
        $stmt = $pdo->prepare($sql);
        try {
            $stmt->execute([
                ':nome' => $nome,
                ':email' => $email,
                ':telefone' => $telefone,
            ]);
            $mensagem = 'Cliente cadastrado com sucesso!';
        } catch (PDOException $e) {
            if ($e->getCode() === '23505') {
                $mensagem = 'Este email já está cadastrado.';
            } else {
                $mensagem = 'Erro ao cadastrar cliente: ' . $e->getMessage();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Clientes</title>
</head>
<body>
    <h1>Sistema de Clientes</h1>
    <nav>
        <a href="index.php">Cadastrar</a>
        <a href="clientes.php">Ver Clientes</a>
    </nav>

    <?php if ($mensagem): ?>
        <p style="color: green;"><?= htmlspecialchars($mensagem) ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label>Nome</label>
        <input type="text" name="nome" value="<?= htmlspecialchars($_POST['nome'] ?? '') ?>" required>

        <label>Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>

        <label>Telefone</label>
        <input type="text" name="telefone" value="<?= htmlspecialchars($_POST['telefone'] ?? '') ?>" required>

        <button type="submit">Cadastrar</button>
        <button type="reset">Limpar</button>
    </form>
</body>
</html>
