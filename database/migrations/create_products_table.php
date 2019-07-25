<?php
/** @var \App\Core\Application $app */
$app = require __DIR__ . '/../../bootstrap/app.php';

/** @var \PDO $pdo */
$pdo = db()->getPdo();
$pdo->beginTransaction();
try {
    /** @var PDOStatement $sql */
    $sql = $pdo->prepare("
        CREATE TABLE products (
            `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(100) NOT NULL,
            `cost` DOUBLE(10, 4) NOT NULL,
            `created_at` TIMESTAMP NULL DEFAULT NULL,
            `updated_at` TIMESTAMP NULL DEFAULT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB CHARSET=utf8 COLLATE=utf8_unicode_ci
    ");
    if ($sql && $sql->execute()) {
        $pdo->commit();
    } else {
        $pdo->rollBack();
    }
} catch (PDOException $e) {
    $pdo->rollBack();
}
