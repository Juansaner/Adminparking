<?php
require "./includes/config/database.php";

//Importar db
$db = connectDatabase();

//Arreglo que almacena errores
$errores = [];

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($db, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
    $password = mysqli_real_escape_string($db, $_POST['password']);

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
                $errores[] = "La contraseña es incorrecta";
            }
        } else {
            $errores[] = "Usuario no encontrado";
        }
        
    }
}
?>

<!--Formularios inicio de sesión y registro -->
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preload" href="./css/normalized.css">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="./css/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <title>Login</title>
  </head>
  <body>
    <div class="container">
        <div class="container__form">
            <form class="container__form-sign-in" method="POST" action="inicio_sesion.php">
                <h2>Iniciar sesión</h2>
                <span>Use su correo y contraseña</span>
                <div class="container__input container__input--mail">
                    <ion-icon name="mail-outline"></ion-icon>
                    <input type="text" name="email" placeholder="Email">
                </div>
                <div class="container__input container__input--password">
                    <ion-icon name="lock-closed-outline"></ion-icon>
                    <input type="password" name="password" placeholder="Password">
                </div>
                <a href="#">¿Olvidaste tu contraseña?</a>
                <button class="container__button container__button--sign-in" type="submit">Iniciar sesión</button>
            </form>
        </div> <!--.container__form -->

        <div class="container__welcome sign-in">
            <div class="container__welcome-sign-in welcome">
                <h3>¡Bienvenido!</h3>
                <p>Ingrese sus datos personales para usar todas las funciones del sitio</p>
                <a class="container__button" href='/adminparking/registro.php'>Registrarse</a>
            </div>
        </div> <!--.container__welcome -->

    </div> <!--.container -->
    <!-- <script src="script.js"></script> -->
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
