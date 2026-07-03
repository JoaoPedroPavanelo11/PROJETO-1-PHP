<?php
require_once 'conexaoDb.php';

/** @var PDO $pdo */
if (!isset($pdo) || !($pdo instanceof PDO)) {
    die('Não foi possível conectar ao banco de dados.');
}

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    header('Location: clientes.php');
    exit;
}

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telefone = trim($_POST['telefone'] ?? '');

    if ($nome === '' || $email === '' || $telefone === '') {
        $mensagem = 'Por favor, preencha todos os campos.';
    } else {
        $sql = 'UPDATE clientes SET nome = :nome, email = :email, telefone = :telefone WHERE id = :id';
        $stmt = $pdo->prepare($sql);
        try {
            $stmt->execute([
                ':nome' => $nome,
                ':email' => $email,
                ':telefone' => $telefone,
                ':id' => $id,
            ]);
            header('Location: clientes.php?msg=' . urlencode('Cliente atualizado com sucesso.'));
            exit;
        } catch (PDOException $e) {
            if ($e->getCode() === '23505') {
                $mensagem = 'Este email já está cadastrado por outro cliente.';
            } else {
                $mensagem = 'Erro ao atualizar cliente: ' . $e->getMessage();
            }
        }
    }
}

$stmt = $pdo->prepare('SELECT * FROM clientes WHERE id = :id');
$stmt->execute([':id' => $id]);
$cliente = $stmt->fetch();

if (!$cliente) {
    header('Location: clientes.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente</title>
</head>
<body>
    <h1>Editar Cliente</h1>
    <nav>
        <a href="index.php">Cadastrar</a>
        <a href="clientes.php">Ver Clientes</a>
    </nav>

    <?php if ($mensagem): ?>
        <p style="color: red;"><?= htmlspecialchars($mensagem) ?></p>
    <?php endif; ?>

    <form method="POST" action="editarCliente.php?id=<?= $cliente['id'] ?>">
        <label>Nome</label>
        <input type="text" name="nome" value="<?= htmlspecialchars($_POST['nome'] ?? $cliente['nome']) ?>" required>

        <label>Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? $cliente['email']) ?>" required>

        <label>Telefone</label>
        <input type="text" name="telefone" value="<?= htmlspecialchars($_POST['telefone'] ?? $cliente['telefone']) ?>" required>

        <button type="submit">Salvar</button>
    </form>
</body>
</html>
