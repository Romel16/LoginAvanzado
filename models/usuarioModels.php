<?php
/* TODO: Definicion de la clase usuario que extiende la conexion a la BD */
class usuarioModels extends Conectar{
    /* TODO: Metodo para el registro de un nuevo usuario */
    public function register_user($user_nomape, $user_correo, $user_pass){
        /* TODO: Obtener la conexion a la base de datos utilizando el método de la clase padre */
        $conectar = parent::conexion();
        /* TODO: Estable el juego de carateres a UTF - 8 utilizando el metodo de la clase padre */
        parent::set_names();
      /*   TODO: Consulta para insertar un nuevo usuario en la Bd de la tabla usuario */
        $sql = "INSERT INTO usuario
                (usuarioNombreApellido, usuarioCorreo, usuarioPassword)
                values (?, ?, ?)";
            /* TODO: Prepara la consulta SQL */
        $sql = $conectar->prepare($sql);
        /* TODO: Vincula los valores a los parametros de la consulta */
        $sql->bindValue(1,$user_nomape);
        $sql->bindValue(2,$user_correo);
        $sql->bindValue(3,$user_pass);
        /* TODO: Ejecuta la conuslta SQL */
        $sql->execute();
    }
}