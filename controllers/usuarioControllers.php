<?php
    /* TODO: Utiliza los archivos de configuracion de la conexion y de la clase usuarioModels */
    require_once("../config/conexion.php");
    require_once("../models/usuarioModels.php");
    /* TODO: Crea una instancia de la clase usuarioModels */
    $usuario = new usuarioModels();

     /* TODO: Utiliza la estructura switch para determinar la operacion a realizar segun el valor de $_GET["op"] */
     switch ($_GET["op"]) {
        /* TODO: Si la operacion es registrar */
        case "register":
            /* TODO: Llama al metodo register_user de la instancia $usuario  con los datos del formulario */
           $usuario->register_user($_POST["usuarioNombreApellido"],$_POST["usuarioCorreo"],$_POST["usuarioPassword"]); 
            break;
        
    }

