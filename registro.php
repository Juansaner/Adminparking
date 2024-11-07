<?php
require "./includes/config/database.php";

//Código para registro de usuario

//Conexión BD
$db = connectDatabase();

if($_SERVER['REQUEST_METHOD'] === 'POST') {
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
}
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preload" href="./css/normalized.css">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="./css/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <title>Registro</title>
</head>

<body>
    <div class="container">
        <div class="container__form">
            <form class="container__form-sign-up" method="POST"
                action="registro.php">
                <h2>Registrarse</h2>
                <span>Use su correo electrónico para registrarse</span>
                <div class="container__input container__input--mail">
                    <ion-icon name="person-outline"></ion-icon>
                    <input type="text" name="name" placeholder="Name">
                </div>
                <div class="container__input container__input--mail">
                    <ion-icon name="person-outline"></ion-icon>
                    <input type="text" name="lastname" placeholder="Last name">
                </div>
                <div class="container__input container__input--mail">
                    <ion-icon name="mail-outline"></ion-icon>
                    <input type="text" name="email" placeholder="Email">
                </div>
                <div class="container__input container__input--password">
                    <ion-icon name="lock-closed-outline"></ion-icon>
                    <input type="password" name="password" placeholder="Password">
                </div>
                <button class="container__button container__button--sign-up" type="submit">Registrarse</button>
            </form>
        </div>
        <!--.container__form -->

        <div class="container__welcome sign-up">
            <div class="container__welcome-sign-up welcome">
                <h3>¡Hola!</h3>
                <p>Registrese con sus datos personales para usar todas las funciones del sitio</p>
                <a class="container__button" href="/adminparking/inicio_sesion.php">Iniciar sesión</a>
            </div>
        </div>
    </div>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>


    <!--Notificaciones-->
    <?php if(!empty($errores)) {
        $error = implode('\n', $errores);
        echo "<script>
            swal({
                title: '¡Error!',
                text: '$error',
                icon: 'error'
            });
        </script>";
    } ?>
</body>
</html>
