<?php

require_once '../src/Db.php';
$rows = Db::query('SELECT * FROM Track; ');
print json_encode($rows, JSON_UNESCAPED_UNICODE);