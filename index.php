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

    <form method="POST" action="">
        <label>Nome</label>
        <input type="text" name="nome" required>

        <label>Email</label>
        <input type="email" name="email" required>

        <label>Telefone</label>
        <input type="text" name="telefone" required>

        <button type="submit">Cadastrar</button>
        <button type="reset">Limpar</button>
    </form>
</body>
</html>
