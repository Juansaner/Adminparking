<?php
require "../../includes/config/database.php";

$db = connectDatabase();

//Captura los datos
$name = mysqli_real_escape_string($db, htmlspecialchars($_POST['name']));
$lastname = mysqli_real_escape_string($db, preg_replace("/[^a-zA-ZáéíóúÁÉÍÓÚüÜñÑ\s]/", "", htmlspecialchars($_POST['lastname'])));
$email = mysqli_real_escape_string($db, filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
$password = $_POST['password'];
//Hashea la password
password_hash($password, PASSWORD_DEFAULT);

// Mostrar los valores sanitizados para verificar que están bien
echo "Nombre sanitizado: " . $name . "<br>";
echo "Apellido sanitizado: " . $lastname . "<br>";
echo "Email sanitizado: " . $email . "<br>";

exit;

//Insertar base de datos
$query = "INSERT INTO usuarios (name, lastname, email, password) VALUES ('$name', '$lastname', '$email', '$password')";

//Almacena en la base de datos
$result = mysqli_query($db, $query);

if($result){
    echo "Insertado correctamente";
}



?>