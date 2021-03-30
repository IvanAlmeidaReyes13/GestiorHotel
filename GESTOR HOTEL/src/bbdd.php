
<?PHP

class bbdd
{
    const HOST = "localhost";
    const US = "root";
    const PW = "";
    const BBDD = "gestionjalula";

    var $conexion;

    function __construct()
    {
        $this->conexion = new mysqli();
        $this->conexion->connect(self::HOST, self::US, self::PW, self::BBDD);
    }
    //confirma que el nombre y la clave pasadas como parametro se corresponden con un registro de la bbdd,
    //de ser asi los guarda en la sesion el nombre y el tipo de usuario y se confirma que se ha logeado
    public function loggin($nombre, $clave)
    {
        $salida = false;
        if (mysqli_connect_errno()) {
            echo "no conectado";
        } else {
            $consulta = "SELECT nombre,clave, tipo from usuarios where nombre like '$nombre'";
            $resultado = $this->conexion->query($consulta);

            while ($row = $resultado->fetch_row()) {
                $datos[] = $row;
            }
            if ((empty($datos) || $datos[0][1] != $clave)) {
                $datos = false;
            } else {
                $_SESSION['loggedin'] = true;
                foreach ($datos as $value) {
                    $_SESSION['usuario'] = $value[0];
                    $_SESSION['tipo'] = $value[2];
                }
                $salida = true;
            }
        }

        return $salida;
    }

//funcion que recibe una habitacion y la nota que se le quiere actualizar para informar de errores o problemas para la habitacion
    public function editarNotas($codigoHabitacion, $nota)
    {
        if (mysqli_connect_errno()) {
            echo "no conectado";
        } else {
            $consulta = "UPDATE `hotel` SET `notas`='$nota' WHERE codigoHabitacion like '$codigoHabitacion'";
            $resultado = $this->conexion->query($consulta);

            if (!$resultado) {

                $transaccion = "<div id='loggin' class='container-fluid h-100 my-5  rounded'>Error en la actualizacion, revisa los datos</div>";
            } else {
                $transaccion = "<div id='loggin' class='container-fluid h-100 my-5  rounded'>Datos actualizado con exito</div>";
            }
        }
        return $transaccion;
    }
    
 //Devuelve los registros de los que la fecha de salida prevista es hoy
    public function informeRegistros()
    {
        $date = date("Y-m-d");

        if (mysqli_connect_errno()) {
            echo "no conectado";
        } else {
            $consulta = "SELECT * from registros where fechaSalida like '$date'";
            $resultado = $this->conexion->query($consulta);

            while ($row = $resultado->fetch_row()) {
                $datos[] = $row;
            }
            if (empty($datos)) {
                $datos = "";
            }
        }


        return $datos;
    }
    
    //recoge y devuleve de la bbdd los avisos y borra los que son anteriores a ayer
    public function recogerAvisos()
    {

        $ayer = fechaAyer(); //Para dejar en los avisos hasta que acabe el dia completo


        if (mysqli_connect_errno()) {
            echo "no conectado";
        } else {
            $consulta = "SELECT * from avisos ";
            $resultado = $this->conexion->query($consulta);

            while ($row = $resultado->fetch_row()) {
                $datos[] = $row;
            }
            if (empty($datos)) {
                $datos = "No hay avisos";
            } else {
                foreach ($datos as $value) {
                    if ($value[2] <= $ayer) { //borra todos los que son anteriores a la fecha de ayer por si has pasado un par de dias sin utilizar el programa
                        $consulta = "DELETE FROM `avisos` WHERE nota like '$value[0]'";
                        $resultado = $this->conexion->query($consulta);
                        foreach ($value as $item) {
                            unset($item);
                        }
                    }
                }
            }
        }
        return $datos;
    }



    //permite añadir avisos a la bbdd segun sean pasados sus parametros por un formualario, asigna a la fecha la fecha de hoy, de lo contrario, avisa del error
    public function insertarAvisos($aviso, $fechaVencimiento, $usuario)
    {
        $hoy = date('Y-m-d');

        if (mysqli_connect_errno()) {
            echo "no conectado";
        } else {
            $consulta = "INSERT INTO avisos(nota, fecha, fechaVencimiento,usuario) VALUES ('$aviso','$hoy','$fechaVencimiento','$usuario') ";
            $resultado = $this->conexion->query($consulta);

            if (!$resultado) {

                $transaccion = "<div id='loggin' class='container-fluid h-100 my-5  rounded'>Error en la inserccion, revisa los datos</div>";
            } else {
                $transaccion = "<div id='loggin' class='container-fluid h-100 my-5  rounded'>Aviso guardado con exito</div>";
            }
        }

        return $transaccion;
    }



    //permite hacer un update de la infromacion que se tiene de los huesped, de haber algun error se notifica con un mensaje, por lo contrario, se avisa del exito de la actualizacion
    public function actualizarHuespedes($codigoHuesped, $nombre, $apellidos, $dni, $email, $telefono, $notas)
    {
        if (mysqli_connect_errno()) {
            echo "no conectado";
        } else {
            $consulta = "UPDATE `huespedes` SET `nombre`='$nombre',`apellidos`='$apellidos',`dni`='$dni',`email`='$email',`telefono`='$telefono',`notas`='$notas' WHERE codigoHuesped like '$codigoHuesped'";
            $resultado = $this->conexion->query($consulta);

            if (!$resultado) {

                $transaccion = "<div id='loggin' class='container-fluid h-100 my-5  rounded'>Error en la actualizacion, revisa los datos</div>";
            } else {
                $transaccion = "<div id='loggin' class='container-fluid h-100 my-5  rounded'>Datos actualizado con exito</div>";
            }
        }
        return $transaccion;
    }



    //busca y devuelve la informaicon de un huesped segun su codigo de huesped 
    public function buscarCodigo($codigoHuesped)
    {
        if (mysqli_connect_errno()) {
            echo "no conectado";
        } else {
            $consulta = "SELECT * from huespedes where codigoHuesped like '$codigoHuesped'";
            $resultado = $this->conexion->query($consulta);

            while ($row = $resultado->fetch_row()) {
                $datos[] = $row;
            }
            if (empty($datos)) {
                $datos = "";
            }
        }

        return $datos;
    }



    //busca y devuelve la informacion de un huesped segun su dni
    public function buscarHuesped($dni)
    {
        if (mysqli_connect_errno()) {
            echo "no conectado";
        } else {
            $consulta = "SELECT * from huespedes where dni like '$dni'";
            $resultado = $this->conexion->query($consulta);

            while ($row = $resultado->fetch_row()) {
                $datos[] = $row;
            }
            if (empty($datos)) {
                $datos = "";
            }
        }

        return $datos;
    }



    //inserta en la bbdd los datos de un registro y actualiza la situacion de la habitacion seleccionada añadiendo el codigo del huesped de haber algun error se notifica con un mensaje, por lo contrario, se avisa del exito de la actualizacion
    public function insetarRegistro($fechaEntrada, $codigoHuesped, $codigoHabitacion,$fechaSalida)
    {
        $transaccion = "";
        if (mysqli_connect_errno()) {
            echo "no conectado";
        } else {
            $consulta = " INSERT INTO `registros` (`codigoRegistro`, `fecha`, `codigoHuesped`, `codigoHabitacion`,`fechaSalida`) VALUES ('0', '$fechaEntrada', '$codigoHuesped', '$codigoHabitacion','$fechaSalida') ";
            $resultado = $this->conexion->query($consulta);
            if (!$resultado) {

                $transaccion .= "<div id='loggin' class='container-fluid h-100 my-5  rounded'>Error en la inserccion, revise los datos</div>";
            } else {
                $transaccion .= "<div id='loggin' class='container-fluid h-100 my-5  rounded'>Registro guardado con exito</div>";
            }
            $consulta = "UPDATE `hotel` SET `codigoHuesped`='$codigoHuesped' WHERE codigoHabitacion like $codigoHabitacion";
            $resultado = $this->conexion->query($consulta);
            if (!$resultado) {

                $transaccion .= ".<br> <div id='loggin' class='container-fluid h-100 my-5  rounded'>Error en asignacion de la habitacion, revise el proceso</div>";
            } else {
                $transaccion .= ". <br><div id='loggin' class='container-fluid h-100 my-5  rounded'>Asignacion de habitacion guardado con exito</div>";
            }
        }
        return $transaccion;
    }



    //inserta en la bbdd los datos de un huesped  de haber algun error se notifica con un mensaje, por lo contrario, se avisa del exito de la actualizacion
    public function insetarHuesped($nombre, $apellidos, $dni, $email, $telefono, $notas)
    {
        if (mysqli_connect_errno()) {
            echo "no conectado";
        } else {
            $consulta = "INSERT INTO `huespedes` (`codigoHuesped`, `nombre`, `apellidos`, `dni`, `email`, `telefono`, `notas`) VALUES (0, '$nombre', '$apellidos', '$dni', '$email', $telefono, '$notas')";
            $resultado = $this->conexion->query($consulta);

            if (!$resultado) {

                $transaccion = "<div id='loggin' class='container-fluid h-100 my-5  rounded'>Error en la inserccion, revisa los datos(puede que el cliente ya tenga ficha)</div>";
            } else {
                $transaccion = "<div id='loggin' class='container-fluid h-100 my-5  rounded'>Huésped guardado con exito</div>";
            }
        }
        return $transaccion;
    }



    //devuelve las habitaciones que no estan ocupadas ni tienen niguna nota
    public function informeHabitaciones()
    {

        if (mysqli_connect_errno()) {
            echo "no conectado";
        } else {
            $consulta = "SELECT * from hotel where codigoHuesped IS NULL AND notas IS NULL ";
            $resultado = $this->conexion->query($consulta);

            while ($row = $resultado->fetch_row()) {
                $datos[] = $row;
            }
            if (empty($datos)) {
                $datos = "";
            }
        }


        return $datos;
    }



    //premite registrar la salida de los huespedes, actualiza la habitacion a vacia y en los registros guarda la fecha en la que salio el huesped de haber algun error se notifica con un mensaje, por lo contrario, se avisa del exito de la actualizacion
    public function salidaHuesped($dni)
    {

        if (mysqli_connect_errno()) {
            echo "no conectado";
        } else {
            $datos = $this->buscarHuesped($dni);
            $hoy = date('Y-m-d');
            if ($datos != "") {
                $huesped = $datos[0][0];
                $consulta = "UPDATE `hotel` SET `codigoHuesped`= NULL  where codigoHuesped like '$huesped'";
                $resultado = $this->conexion->query($consulta);

                if (!$resultado) {

                    $transaccion = "<div id='loggin' class='container-fluid h-100 my-5  rounded'>Error en la salida, revisa los datos</div>";
                } else {
                    $transaccion = "<div id='loggin' class='container-fluid h-100 my-5  rounded'>Huésped dado de baja con exito</div>";

                    $consulta = "UPDATE `registros` SET `fechaSalida`= '$hoy'   where codigoHuesped like '$huesped' AND fechaSalida is NULL";
                    $resultado = $this->conexion->query($consulta);
                }
            } else {
                $transaccion = "<div id='loggin' class='container-fluid h-100 my-5  rounded'>Problema al encontrar al huesped, revise el DNI/NIE</div>";
            }
            if (isset($_SESSION['autorizacion'])) {
                unset($_SESSION['autorizacion']);
            }
        }
        return $transaccion;
    }



    //permite dar una autorizacion si el usuario proporcionado y la clave coinciden con el de un usuario de tipo admin de la bbdd
    public function autorizar($nombre, $clave)
    {

        $salida = false;
        if (mysqli_connect_errno()) {
            echo "no conectado";
        } else {
            $consulta = "SELECT nombre,clave, tipo from usuarios where nombre like '$nombre'";
            $resultado = $this->conexion->query($consulta);

            while ($row = $resultado->fetch_row()) {
                $datos[] = $row;
            }
            if ((empty($datos) || $datos[0][1] != $clave)) {
                $datos = false;
            } else {
                if ($datos[0][2] != "admin") {
                } else {
                    $_SESSION['autorizacion'] = true;
                    $salida = true;
                }
            }
        }

        return $salida;
    }



    //devuelve la informacion del usuario o usuarios que coincidan con los parametros dados, estos parametros son utilizados para la busqueda dando prioridad al dni(sera una busqueda exacta) de haber algun error se notifica con un mensaje, por lo contrario, se avisa del exito de la actualizacion
    public function busquedaHuesped($apellidos, $dni)
    {

        if (mysqli_connect_errno()) {
            echo "no conectado";
        } else {
            $consulta = "";
            if ($dni != "") {
                $consulta = "SELECT * FROM HUESPEDES WHERE dni like '$dni'";
            } else {
                $consulta = "SELECT * FROM HUESPEDES WHERE apellidos like '$apellidos'";
            }
            $resultado = $this->conexion->query($consulta);

            while ($row = $resultado->fetch_row()) {
                $datos[] = $row;
            }
            if (empty($datos)) {
                $datos = "";
            }
        }


        return $datos;
    }


    public function buscarHabitacion($codigoHabitacion = "todo")
    {
        if (mysqli_connect_errno()) {
            echo "no conectado";
        } else {
            if ($codigoHabitacion == "todo") {
                $consulta = "SELECT * from hotel ";
            } else {
                $consulta = "SELECT * from hotel where codigoHabitacion like '$codigoHabitacion'";
            }

            $resultado = $this->conexion->query($consulta);

            while ($row = $resultado->fetch_row()) {
                $datos[] = $row;
            }
            if (empty($datos)) {
                $datos = "";
            }
        }

        return $datos;
    }
}




//devuelve la fecha de ayer
function fechaAyer()
{
    $date = date("Y-m-d");
    $ayer = date("Y-m-d", strtotime("-1 day", strtotime($date)));
    return $ayer;
}
