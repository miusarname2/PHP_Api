<?php
require 'flight/Flight.php';

// Conexion base de datos
Flight::register('db', 'PDO', array('mysql:host=localhost:49674;dbname=api','root',''));

//Retorna toda la data de la DB
Flight::route('GET /', function () {
    
    $sentence=Flight::db()->prepare("SELECT * FROM `estudiantes`");
    $sentence->execute();
    $datos=$sentence->fetchAll();

    Flight::json($datos);

});





Flight::start();
