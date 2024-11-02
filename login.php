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
                echo "El password es incorrecto";
            }
        } else {
            $errores[] = "Usuario no encontrado";
        }
        
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
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="./css/style.css" />
    <title>Login</title>
  </head>
  <body>
    <div class="container">
        <div class="container__form">
            <form class="container__form-sign-in" method="POST" action="login.php">
                <h2>Iniciar sesión</h2>
                <span>Use su correo y contraseña</span>
                <?php foreach($errores as $error): ?>
                    <div class="alerta error"><?php echo $error; ?></div>
                <?php endforeach ?>
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
        
        <div class="container__form">
            <form class="container__form-sign-up" method="POST" action="/adminparking/admin/propiedades/crear_usuario.php">
                <h2>Registrarse</h2>
                <span>Use su correo electrónico para registrarse</span>
                <?php foreach($errores as $error): ?>
                    <div class="alerta error"><?php echo $error; ?></div>
                <?php endforeach ?>
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
        </div> <!--.container__form -->

        <div class="container__welcome">
            <div class="container__welcome-sign-up welcome">
                <h3>¡Bienvenido!</h3>
                <p>Ingrese sus datos personales para usar todas las funciones del sitio</p>
                <button class="container__button" id="btn-sign-up">Registrarse</button>
            </div>
            <div class="container__welcome-sign-in welcome">
                <h3>¡Hola!</h3>
                <p>Registrese con sus datos personales para usar todas las funciones del sitio</p>
                <button class="container__button" id="btn-sign-in">Iniciar sesión</button>
            </div>
        </div>

    </div> <!--.container -->
    <script src="script.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
  </body>
</html>
