<?php

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    print 'Procesar formulario';

    if (count($errors) == 0) {
        print 'Insertar en la base de datos y re direccionar.';
    }
}

$title = 'Nuevo usuario';
$template = '../templates/usuarios/register.html';
require_once '../templates/base.html';