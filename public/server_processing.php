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

$first_name = ucwords(strtolower($first_name));
$last_name = ucwords(strtolower($last_name));

$password = password_hash($password, PASSWORD_DEFAULT);

// Para evitar el error de la funcion json_encode
$rows = [];
$last_modified_on = $created_on = date('Y-m-d H:i:s');
$deleted = 0;

// CRUD
switch ($action) {
    // CREATE
    case 1:
        $q = 'INSERT INTO user (username, first_name, last_name, gender, password, status, created_on, last_modified_on, deleted)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $res = Db::query($q, $username, $first_name, $last_name, $gender, $password, $status, $created_on, $last_modified_on, $deleted);

        // Selecciona el último registro insertado no hace falata la condicion WHERE deleted = 0
        // $rows = Db::query('SELECT * FROM user ORDER BY user_id DESC LIMIT 1');
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
        $q = 'UPDATE user SET first_name = ?, last_name = ?, gender = ?, password = ?, status = ?, last_modified_on = ?, deleted = ? WHERE user_id = ?';
        $res = Db::query($q, $first_name, $last_name, $gender, $password, $status, $last_modified_on, $deleted, $user_id);
        break;
    // DELETE
    case 4:
        // Db::getInstance()->exec('PRAGMA foreign_keys = ON ;'); No hace falta esta línea por que no estoy eliminando registros
        $deleted = 1;
        $res = Db::query('UPDATE user SET last_modified_on = ?, deleted = ? WHERE user_id = ?; ', $last_modified_on, $deleted, $user_id);
        break;
}

// Array
$message = [
    'success' => true,
    'success_message' => '<p>Sus datos han sido eliminados exitosamente de la base de datos.<\/p>'
];

// Retorna un string codificado a formato JSON
print json_encode($rows, JSON_UNESCAPED_UNICODE);
exit;

// Ejm: String resultante despues de pasar por la función json_encode
$message_encode = '{"success":true,"success_message":"<p>Sus datos han sido eliminados exitosamente de la base de datos.<\/p>"}';

/**
 * EN JAVASCRIPT
 * var stringJSON = '{"success":true,"success_message":"<p>Sus datos han sido eliminados exitosamente de la base de datos.<\/p>"}';
 * var data = JSON.parse(stringJSON);
 * document.getElementById("demo").innerHTML = data.success; // true
 */
