<?php
require_once 'conexaoDb.php';

/** @var PDO $pdo */
if (!isset($pdo) || !($pdo instanceof PDO)) {
    die('Não foi possível conectar ao banco de dados.');
}

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
    <link rel="stylesheet" href="styleIndex.css">
    <title>Sistema de Clientes</title>
</head>
<body>
    <div class="page">
        <div class="card">
            <h1>Sistema de Clientes</h1>
            <nav class="nav-links">
                <a class="nav-link active" href="index.php">Cadastrar</a>
                <a class="nav-link" href="clientes.php">Ver Clientes</a>
            </nav>

            <?php if ($mensagem): ?>
                <p class="message"><?= htmlspecialchars($mensagem) ?></p>
            <?php endif; ?>

            <form method="POST" action="">
                <label for="nome">Nome</label>
                <input id="nome" type="text" name="nome" value="<?= htmlspecialchars($_POST['nome'] ?? '') ?>" required>

                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>

                <label for="telefone">Telefone</label>
                <input id="telefone" type="text" name="telefone" value="<?= htmlspecialchars($_POST['telefone'] ?? '') ?>" required>

                <div class="actions">
                    <button type="submit">Cadastrar</button>
                    <button type="reset" class="secondary">Limpar</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
