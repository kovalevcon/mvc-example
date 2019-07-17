<?php
$fileName = __DIR__ . '/../config/db.php';
file_put_contents($fileName, str_replace("'mysql'", "'mvc_example'", file_get_contents($fileName)));
