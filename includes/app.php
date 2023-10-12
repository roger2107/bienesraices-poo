<?php

require 'funciones.php';
require 'config/database.php';
require __DIR__ . '/../vendor/autoload.php';

//Conectarlos a la BD
$db = conectarDB();

use App\ActiveRecord;

ActiveRecord::setDB($db);


