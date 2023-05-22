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

//Envio de informacion a la DB
Flight::route('POST /', function () {
    //Declaramos los nombre con nombres de columnas en este caso fueron "Name" y "surname"
    $Name=(Flight::request()->data->Name);
    $surname=(Flight::request()->data->surname);
    
    //Introducimos la instruccion SQL para agregar a la tabla
    $sql="INSERT INTO `estudiantes` (Name, surname) VALUES (?,?);";
    $sentence=Flight::db()->prepare($sql);
    //Pasamos como parametro a la DB los valores a insertar
    $sentence->bindParam(1,$Name);
    $sentence->bindParam(2,$surname);

    //Se ejecuta la funcion de envio
    $sentence->execute();

    //y si todo salio bien se mostrara este mensaje
    Flight::json(["Alumno Agregado con Exito"]);

});

//Borrado de fila de la DB
Flight::route('DELETE /', function () {
    //Toma id del JSON pasado
    $id=(Flight::request()->data->id);

    //Instrucción SQL
    $sql="DELETE FROM `estudiantes` WHERE id=?";
    $sentence=Flight::db()->prepare($sql);
    //Pasamos como parametro a la DB los valores de la id a eliminar
    $sentence->bindParam(1,$id);
    //Se ejecuta la funcion de envio
    $sentence->execute();

    //MSJ a usuario
    Flight::json(["Alumno $id borrado con exito"]);

});

//Se crea el metodo de modificacion de la base de datos
Flight::route('PUT /', function () {

    //Pasamos los parametros
    $id=(Flight::request()->data->id);
    $Name=(Flight::request()->data->Name);
    $surname=(Flight::request()->data->surname);

    //Instrucción SQL
    $sql="UPDATE `estudiantes` SET Name=?, surname=? WHERE id = ?;";
    $sentence=Flight::db()->prepare($sql);
    //Pasamos como parametro a la DB los valores a modificar
    $sentence->bindParam(3,$id);
    $sentence->bindParam(1,$Name);
    $sentence->bindParam(2,$surname);

    //Se ejecuta la funcion de envio
    $sentence->execute();

    Flight::jsonp(["Alumno $id modificado con exito..."]);


});

Flight::route('GET /@id', function ($id) {
    
    $sentence=Flight::db()->prepare("SELECT * FROM `estudiantes` WHERE `id`=?");
    $sentence->bindParam(1,$id);
    $sentence->execute();
    $datos=$sentence->fetchAll();

    Flight::json($datos);

});



Flight::start();
