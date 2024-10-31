<?php

//Función para verificar si está autenticado el usuario
    function estaAutenticado() : bool {
        session_start();
        $auth = $_SESSION['login'];

        if($auth){
            return true;
        }
        return false;
    };

?>