<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../app/Core/Database.php';
/** @var PDO $pdo */
$pdo = \Core\Database::getInstance();
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
