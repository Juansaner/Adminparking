<?php
require "../includes/funciones.php";

$auth = estaAutenticado();
//Redirige si no se tiene acceso
if(!$auth){
    header('Location: ../login.html');
}
?>