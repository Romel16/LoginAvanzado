<?php
require '../include/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once("../config/conexion.php");
require_once("../models/usuarioModels.php");

class emailModels extends PHPMailer
{
    /*Correo que se utilizara, se debe de configurar en el hosting previamente */
    protected $gCorreo = '';

    /*Se crea la contraseña en el hosting y se coloca aqui */
    protected $gContrasena = '';

    /*colocar una llave que previamente se configuro*/
    private $key = "";
    private $cipher = "aes-256-cbc";


    public function registrar($usu_id)
    {

        $conexion = new Conectar;
        $usuario = new usuarioModels();
        $datos = $usuario->get_user_id($usu_id);

        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->cipher));
        $cifrado = openssl_encrypt($usu_id, $this->cipher, $this->key, OPENSSL_RAW_DATA, $iv);
        $textoCifrado = base64_encode($iv . $cifrado);

        $this->IsSMTP();
        $this->Host = '';
        $this->Port = 465; //Aqui el puerto
        $this->SMTPAuth = true;
        $this->SMTPSecure = 'TLS';

        $this->Username = $this->gCorreo;
        $this->Password = $this->gContrasena;
        $this->setFrom($this->gCorreo, "Registro en Mesa de Partes");

        $this->CharSet = 'UTF8';
        $this->addAddress($datos[0]["usuarioCorreo"]);
        $this->IsHTML(true);
        $this->Subject = "Mesa de Partes";

        $url = $conexion->ruta() . "../view/confirmar?id=" . $usu_id;  

        $cuerpo = file_get_contents("../assets/email/registrar.html");
        $cuerpo = str_replace("xlinkcorreourl",$conexion->ruta() . "../view/confirmar/?id=",$cuerpo);


        $this->Body = $cuerpo;
        $this->AltBody = strip_tags("Confirmar Registro");
 
        try {
            $this->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function recuperar($usu_correo){

        $conexion = new Conectar();

        $usuario = new usuarioModels();
        $datos = $usuario -> get_user_correo($usu_correo);

        $this->IsSMTP();
        $this->Host = '';
        $this->Port = 465; //Aqui el puerto
        $this->SMTPAuth = true;
        $this->SMTPSecure = 'tls';

        $this->Username = $this->gCorreo;
        $this->Password = $this->gContrasena;
        $this->setFrom($this->gCorreo,"Recuperar Contraseña Mesa de Partes AnderCode");

        $this->CharSet = 'UTF8';
        $this->addAddress($datos[0]["usuarioCorreo"]);
        $this->IsHTML(true);
        $this->Subject = "Mesa de Partes";

        $url = $conexion->ruta();
        //TODO: Generar la cadena alfanumérica
        $xpassusu = $this->generarXPassUsu();

        $usuario -> recuperar_usuario($usu_correo,$xpassusu);

        $cuerpo = file_get_contents("../assets/email/recuperar.html");
        $cuerpo = str_replace("xpassusu",$xpassusu,$cuerpo);
        $cuerpo = str_replace("xlinksistema",$url,$cuerpo);

        $this->Body = $cuerpo;
        $this->AltBody = strip_tags("Recupera Contraseña");

        try{
            $this->send();
            return true;
        }catch(Exception $e){
            return false;
        }
    }

    private function generarXPassUsu() {
        $parteAlfanumerica = substr(md5(rand()), 0, 3);
        $parteNumerica = str_pad(rand(0,999),3,'0',STR_PAD_LEFT);
        $resultado = $parteAlfanumerica . $parteNumerica;
        return substr($resultado,0,6);
    }

}
