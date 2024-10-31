<?php
require "../../includes/config/database.php";

$db = connectDatabase();

//Captura los datos
$name = mysqli_real_escape_string($db, htmlspecialchars($_POST['name']));
$lastname = mysqli_real_escape_string($db, preg_replace("/[^a-zA-ZáéíóúÁÉÍÓÚüÜñÑ\s]/", "", htmlspecialchars($_POST['lastname'])));
$email = mysqli_real_escape_string($db, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
$password = $_POST['password'];
//Hashea la password
$passwordHash = password_hash($password, PASSWORD_DEFAULT);

//Arreglo que almacena errores
$errores = [];

//Arreglo mensajes de error
if(!$name){
    $errores[] = "El nombre es obligatorio";
}

if(!$lastname){
    $errores[] = "El apellido es obligatorio";
}

if(!$email){
    $errores[] = "El email es obligatorio";
}

if(!$password){
    $errores[] = "La contraseña es obligatoria";
}

if(empty($errores)){
    //Insertar base de datos
    $query = "INSERT INTO usuarios (name, lastname, email, password) VALUES ('$name', '$lastname', '$email', '$passwordHash')";

    //Almacena en la base de datos
    $result = mysqli_query($db, $query);

    if($result){
        echo "Insertado correctamente";
    }
}

?>