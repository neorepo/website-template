<?php

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    print 'Procesar formulario';

    if (count($errors) == 0) {
        print 'Verificar credenciales en la base de datos.';
    }
}

$title = 'Ingresar';
$template = '../templates/usuarios/login.html';
require_once '../templates/base.html';
