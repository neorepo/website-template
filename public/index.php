<?php
// display errors, warnings, and notices
ini_set("display_errors", true);
error_reporting(E_ALL);

date_default_timezone_set('AMERICA/ARGENTINA/BUENOS_AIRES');
mb_internal_encoding('UTF-8');
setlocale(LC_TIME, 'es_RA.UTF-8');

// Se debe cambiar el nombre de la sesión antes de activarla
session_name('ID');
session_start();

require_once '../src/Db.php';
require_once '../src/Flash.php';


$title = 'Bienvenido a mi Página Web';

$flashes = null;
if (Flash::hasFlashes()) {
    $flashes = Flash::getFlashes();
}

$template = '../templates/table.html';
require_once '../templates/base.html';