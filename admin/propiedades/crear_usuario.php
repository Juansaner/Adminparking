<?php
require "../../includes/config/database.php";

$db = connectDatabase();

//Captura los datos
$name = $_POST['name'];
$lastname = $_POST['lastname'];
$email = $_POST['email'];
$password = $_POST['password'];

//Insertar base de datos
$query = "INSERT INTO usuarios (name, lastname, email, password) VALUES ('$name', '$lastname', '$email', '$password')";

//Almacena en la base de datos
$result = mysqli_query($db, $query);

if($result){
    echo "Insertado correctamente";
}



?>