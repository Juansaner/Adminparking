<?php
//Función para conectar a la bd
 function connectDatabase() : mysqli {
    $db = mysqli_connect('localhost', 'root', 'root', 'parqueadero');

    if(!$db) {
        echo "Error en la conexión";
        exit;
    } 

    return $db;
 }
?>