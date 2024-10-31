<?php
require "./includes/config/database.php";

//Importar db
$db = connectDatabase();

$email = mysqli_real_escape_string($db, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
$password = mysqli_real_escape_string($db, $_POST['password']);

//Arreglo que almacena errores
$errores = [];

//Validaciones de los input
if(!$email){
    $errores[] = "El email es obligatorio";
}

if(!$password){
    $errores[] = "La contraseña es obligatoria";
}

if(empty($errores)) {

    $query = "SELECT * FROM usuarios WHERE email = '$email'";
    $resultado = mysqli_query($db, $query);

    if($resultado->num_rows) {
        //Revisar si el password es correcto
        $usuario = mysqli_fetch_assoc($resultado);
        $auth = password_verify($password, $usuario['password']);

        if($auth) {
            //El usuario está autenticado
            session_start();
            //Llenar el arreglo de la sesión
            $_SESSION['usuario'] = $usuario['email'];
            $_SESSION['login'] = true;

            header("Location: ./admin/index.php");
        } else {
            echo "El password es incorrecto";
        }
    } else {
        $errores[] = "Usuario no encontrado";
    }
    
}

?>