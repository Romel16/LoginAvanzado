<?php
/* TODO: Definicion de la clase usuario que extiende la conexion a la BD */
class usuarioModels extends Conectar{

    private $key = "MesaDePartesAnderCode";
    private $cipher = "aes-256-cbc";



    public function login(){
        $conectar = parent::conexion();
        parent::set_names();
        if(isset($_POST["enviar"])){
            $correo = $_POST["usuarioCorreo"];
            $pass = $_POST["usuarioPassword"];
            if(empty($correo) and empty($pass)){
                header("Location:".conectar::ruta()."index.php?m=2");
                exit();
            }else{
                $sql="SELECT * FROM usuario WHERE usuarioCorreo = ?";
                $sql=$conectar->prepare($sql);
                $sql->bindValue(1,$correo);
                $sql->execute();
                $resultado=$sql->fetch();
                if($resultado){
                    $textoCifrado = $resultado["usuarioPassword"];

                    $iv_dec = substr(base64_decode($textoCifrado), 0, openssl_cipher_iv_length($this->cipher));
                    $cifradoSinIV = substr(base64_decode($textoCifrado), openssl_cipher_iv_length($this->cipher));
                    $textoDecifrado = openssl_decrypt($cifradoSinIV, $this->cipher, $this->key, OPENSSL_RAW_DATA, $iv_dec);

                    if($textoDecifrado==$pass){
                        if(is_array($resultado) and count($resultado)>0){
                            $_SESSION["usuarioId"] = $resultado["usuarioId"];
                            $_SESSION["usuarioNombreApellido"] = $resultado["usuarioNombreApellido"];
                            $_SESSION["usuarioCorreo"] = $resultado["usuarioCorreo"];
                            header("Location:".Conectar::ruta()."view/home");
                            exit();
                        }
                    }else{
                        header("Location:".Conectar::ruta()."index.php?m=3");
                        exit();
                    }
                }else{
                    header("Location:".Conectar::ruta()."index.php?m=1");
                    exit();
                }
            }

        }

    }


    /* TODO: Metodo para el registro de un nuevo usuario */
    public function register_user($user_nomape,$user_correo,$user_pass,$user_img,$user_estado){

        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->cipher));
        $cifrado = openssl_encrypt($user_pass, $this->cipher, $this->key, OPENSSL_RAW_DATA, $iv);
        $textoCifrado = base64_encode($iv . $cifrado);


        /* TODO: Obtener la conexion a la base de datos utilizando el método de la clase padre */
        $conectar = parent::conexion();
        /* TODO: Estable el juego de carateres a UTF - 8 utilizando el metodo de la clase padre */
        parent::set_names();
      /*   TODO: Consulta para insertar un nuevo usuario en la Bd de la tabla usuario */
        $sql = "INSERT INTO usuario
                (usuarioNombreApellido, usuarioCorreo, usuarioPassword, usuarioEstado)
                values (?,?,?,?)";
            /* TODO: Prepara la consulta SQL */
        $sql = $conectar->prepare($sql);
        /* TODO: Vincula los valores a los parametros de la ;consulta */
        $sql->bindValue(1,$user_nomape);
        $sql->bindValue(2,$user_correo);
        $sql->bindValue(3,$textoCifrado);
  /*       $sql->bindValue(4,$user_img); */
        $sql->bindValue(4,$user_estado);
        /* TODO: Ejecuta la conuslta SQL */
        $sql->execute();

        $sql1 = "select last_insert_id() as 'usu_id";
        $sql1 = $conectar->prepare($sql1);
        return $sql->fetchAll(); 
    }

    public function get_user_correo($user_correo){
         /* TODO: Obtener la conexion a la base de datos utilizando el método de la clase padre */
         $conectar = parent::conexion();
         /* TODO: Estable el juego de carateres a UTF - 8 utilizando el metodo de la clase padre */
         parent::set_names();
       /*   TODO: Consulta para insertar un nuevo usuario en la Bd de la tabla usuario */
         $sql = "select * from usuario where usuarioCorreo = ?";
             /* TODO: Prepara la consulta SQL */
         $sql = $conectar->prepare($sql);
         /* TODO: Vincula los valores a los parametros de la ;consulta */
         $sql->bindValue(1,$user_correo);
         /* TODO: Ejecuta la conuslta SQL */
         $sql->execute();
         return $sql->fetchAll();
    }
    public function get_user_id($user_id){
         /* TODO: Obtener la conexion a la base de datos utilizando el método de la clase padre */
         $conectar = parent::conexion();
         /* TODO: Estable el juego de carateres a UTF - 8 utilizando el metodo de la clase padre */
         parent::set_names();
       /*   TODO: Consulta para insertar un nuevo usuario en la Bd de la tabla usuario */
         $sql = "select * from usuario where usuarioId = ?";
             /* TODO: Prepara la consulta SQL */
         $sql = $conectar->prepare($sql);
         /* TODO: Vincula los valores a los parametros de la ;consulta */
         $sql->bindValue(1,$user_id);
         /* TODO: Ejecuta la conuslta SQL */
         $sql->execute();
         return $sql->fetchAll();
    }

    public function activar_usuario($usu_id){

        $iv_dec = substr(base64_decode($usu_id), 0, openssl_cipher_iv_length($this->cipher));
        $cifradoSinIV = substr(base64_decode($usu_id), openssl_cipher_iv_length($this->cipher));
        $textoDecifrado = openssl_decrypt($cifradoSinIV, $this->cipher, $this->key, OPENSSL_RAW_DATA, $iv_dec);

        /* TODO: Obtener la conexión a la base de datos utilizando el método de la clase padre */
        $conectar = parent::conexion();
        /* TODO: Establecer el juego de caracteres a UTF-8 utilizando el método de la clase padre */
        parent::set_names();
        /* TODO: Consulta SQL para insertar un nuevo usuario en la tabla tm_usuario */
        $sql="UPDATE usuario
                SET
                    usuarioEstado=1,
                    usuarioFechaActivacion = NOW()
                WHERE
                    usuarioId = ?";
        /* TODO:Preparar la consulta SQL */
        $sql=$conectar->prepare($sql);
        /* TODO: Vincular los valores a los parámetros de la consulta */
        $sql->bindValue(1,$textoDecifrado); 
        /* TODO: Ejecutar la consulta SQL */
        $sql->execute();
    }

    public function recuperar_usuario($usu_correo,$usu_pass){

        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->cipher));
        $cifrado = openssl_encrypt($usu_pass, $this->cipher, $this->key, OPENSSL_RAW_DATA, $iv);
        $textoCifrado = base64_encode($iv . $cifrado);

        /* TODO: Obtener la conexión a la base de datos utilizando el método de la clase padre */
        $conectar = parent::conexion(); 
        /* TODO: Establecer el juego de caracteres a UTF-8 utilizando el método de la clase padre */
        parent::set_names();
        /* TODO: Consulta SQL para insertar un nuevo usuario en la tabla tm_usuario */
        $sql="UPDATE usuario
            SET
            usuarioPassword = ?
            WHERE
            usuarioCorreo = ?";
        /* TODO:Preparar la consulta SQL */
        $sql=$conectar->prepare($sql);
        /* TODO: Vincular los valores a los parámetros de la consulta */
        $sql->bindValue(1,$textoCifrado);
        $sql->bindValue(2,$usu_correo);
        /* TODO: Ejecutar la consulta SQL */
        $sql->execute();
    }


}

