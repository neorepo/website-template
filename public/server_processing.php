<?php

date_default_timezone_set('AMERICA/ARGENTINA/BUENOS_AIRES');

require_once '../src/Db.php';

$action = $_POST['action'] ?? '';
$user_id = $_POST['user_id'] ?? '';

$username = $_POST['username'] ?? '';
$first_name = $_POST['first_name'] ?? '';
$last_name = $_POST['last_name'] ?? '';
$gender = $_POST['gender'] ?? '';
$password = $_POST['password'] ?? '';
$status =  $_POST['status'] ?? '';

switch ($action) {
    // CREATE
    case 1:
        $last_modified_on = $created_on = date('Y-m-d H:i:s');
        $deleted = 0;
        $q = 'INSERT INTO user (username, first_name, last_name, gender, password, status, created_on, last_modified_on, deleted)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $password = password_hash($password, PASSWORD_DEFAULT);
        Db::query($q, $username, $first_name, $last_name, $gender, $password, $status, $created_on, $last_modified_on, $deleted);

        $rows = Db::query('SELECT * FROM user ORDER BY user_id DESC LIMIT 1');
        break;
    // READ
    case 2:
        $rows = Db::query('SELECT * FROM user WHERE deleted = 0; ');
        foreach($rows as &$row){
            $row['first_name'] = ucwords($row['first_name']);
            $row['last_name'] = ucwords($row['last_name']);
        }
        break;
    // UPDATE
    case 3:
        $rows = Db::query('');
        break;
    // DELETE
    case 4:
        // Db::getInstance()->exec('PRAGMA foreign_keys = ON ;');
        $last_modified_on = date('Y-m-d H:i:s'); // NO olvidar setear la hora local con la funcion date_default_timezone_set
        Db::query('UPDATE user SET last_modified_on = ?, deleted = ? WHERE user_id = ?; ', $last_modified_on, true, $user_id);
        break;
}

print json_encode($rows, JSON_UNESCAPED_UNICODE);