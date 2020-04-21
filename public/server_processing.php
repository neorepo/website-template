<?php

require_once '../src/Db.php';

$action = $_POST['action'] ?? '';
$user_id = $_POST['user_id'] ?? '';

switch ($action) {
    // CREATE
    case 1:
        $rows = Db::query('SELECT * FROM user; ');
        break;
    // READ
    case 2:
        $rows = Db::query('SELECT * FROM user WHERE deleted = 0; ');
        break;
    // UPDATE
    case 3:
        $rows = Db::query('SELECT * FROM user; ');
        break;
    // DELETE
    case 4:
        // Db::getInstance()->exec('PRAGMA foreign_keys = ON ;');
        $last_modified_on = date('Y-m-d H:i:s'); // NO olvidar setear la hora local con la funcion date_default_timezone_set
        Db::query('UPDATE user SET last_modified_on = ?, deleted = ? WHERE user_id = ?; ', $last_modified_on, true, $user_id);
        break;
}

print json_encode($rows, JSON_UNESCAPED_UNICODE);