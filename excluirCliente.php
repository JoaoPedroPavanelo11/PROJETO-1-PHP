<?php
require_once 'conexaoDb.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($id) {
    $stmt = $pdo->prepare('DELETE FROM clientes WHERE id = :id');
    $stmt->execute([':id' => $id]);
}

header('Location: clientes.php?msg=' . urlencode('Cliente excluído com sucesso.'));
exit;
