<?php
$databaseFile = __DIR__ . '/clientes.sqlite';

$pdo = null;
$driver = null;

try {
    $availableDrivers = PDO::getAvailableDrivers();

    if (in_array('sqlite', $availableDrivers, true)) {
        $driver = 'sqlite';
        $pdo = new PDO('sqlite:' . $databaseFile, null, null, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
    } elseif (in_array('pgsql', $availableDrivers, true)) {
        $driver = 'pgsql';
        $pdo = new PDO(
            'pgsql:host=localhost;port=5432;dbname=Crud_PHP',
            'postgres',
            'jpp260208',
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]
        );
    } else {
        throw new PDOException('Nenhum driver PDO compatível está habilitado no PHP. Habilite pdo_sqlite ou pdo_pgsql.');
    }

    if ($driver === 'sqlite') {
        $pdo->exec(
            'CREATE TABLE IF NOT EXISTS clientes (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                nome TEXT NOT NULL,
                email TEXT NOT NULL UNIQUE,
                telefone TEXT NOT NULL,
                criado_em DATETIME DEFAULT CURRENT_TIMESTAMP
            )'
        );
    } else {
        $pdo->exec(
            'CREATE TABLE IF NOT EXISTS clientes (
                id SERIAL PRIMARY KEY,
                nome VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL UNIQUE,
                telefone VARCHAR(50) NOT NULL,
                criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )'
        );
    }
} catch (PDOException $e) {
    die('Erro de conexão com o banco de dados: ' . $e->getMessage());
}
?>
