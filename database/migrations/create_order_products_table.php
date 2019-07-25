<?php
/** @var \App\Core\Application $app */
$app = require __DIR__ . '/../../bootstrap/app.php';

/** @var \PDO $pdo */
$pdo = db()->getPdo();
$pdo->beginTransaction();
try {
    /** @var PDOStatement $sql */
    $sql = $pdo->prepare("
        CREATE TABLE order_products (
            `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            `order_id` BIGINT UNSIGNED NOT NULL,
            `product_id` BIGINT UNSIGNED NOT NULL,
            `created_at` TIMESTAMP NULL DEFAULT NULL,
            PRIMARY KEY (`id`),
            FOREIGN KEY fk_order_id(`order_id`)
            REFERENCES orders(`id`),
            FOREIGN KEY fk_product_id(`product_id`)
            REFERENCES products(`id`)
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
