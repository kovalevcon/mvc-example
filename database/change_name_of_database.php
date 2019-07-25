<?php
$fileName = __DIR__ . '/../.env';
file_put_contents($fileName, str_replace("mysql", "mvc_example", file_get_contents($fileName)));
