<?php
/** @var \App\Core\Application $app */
$app = require __DIR__ . '/../../bootstrap/app.php';

/** @var \PDO $pdo */
$pdo = db()->getPdo();
$pdo->beginTransaction();
try {
    /** @var PDOStatement $sql */
    $sql = $pdo->prepare("CREATE DATABASE mvc_example CHARACTER SET utf8 COLLATE utf8_general_ci");
    if ($sql && $sql->execute()) {
        $pdo->commit();
    } else {
        $pdo->rollBack();
    }
} catch (PDOException $e) {
    $pdo->rollBack();
}
