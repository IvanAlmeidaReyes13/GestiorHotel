<?php
require_once("src/bbdd.php");
$bbdd1 = new bbdd();
$enviar = $_POST['enviar'] ?? false;
$enviarEntrada = $_POST['enviarEntrada'] ?? false;
//si no se ha enviado la informacion para comprobar no se entra a insertar el registro
if ($enviarEntrada) {
    echo $bbdd1->insetarRegistro($_POST['fechaEntrada'], $_POST['huesped'], $_POST['codigoHabitacion'],$_POST['fechaSalida']);
    ?>
    <form action="index.php" method="$_POST">
        <input type="hidden" name="opcionesMenu" value="altas">
        
    </form>
    <?php
} else {
    if ($enviar) {
        //buscamos la informacion de si el huesped ya tiene una ficha en el hotel
        $huesped = $bbdd1->buscarHuesped($_POST['dni']);
        if ($huesped != "") {
?>
            <div class="row">

                <div id="loggin" class="container-fluid h-100 my-5  rounded">
                    <div class="row justify-content-center align-items-center ">
                        <h1>Datos de Huésped</h1>
                    </div>
<!--se proporciona la informacion del huesped para confirmar que los datos son correctos y que no hay errores en el registro del huesped-->
                    <div class="row justify-content-top align-items-top my-3">
                        <div class="col ">
                            <h7><strong><u>Codigo Huésped</u></strong></h7>
                        </div>
                        <div class="col">
                            <?php echo $huesped[0][0][0] ?>
                        </div>
                    </div>

                    <div class="row justify-content-top align-items-top my-3">
                        <div class="col ">
                            <h7><strong><u>Nombre</u></strong></h7>
                        </div>
                        <div class="col">
                            <?php echo $huesped[0][1] ?>
                        </div>
                    </div>
                    <div class="row justify-content-top align-items-top my-3">
                        <div class="col ">
                            <h7><strong><u>Apellidos</u></strong></h7>
                        </div>
                        <div class="col">
                            <?php echo $huesped[0][2] ?>
                        </div>
                    </div>
                    <div class="row justify-content-center align-items-center h-100 my-3 pb-5">
                        <div class="col ">
                            <h7><strong><u>DNI/NIE</u></strong></h7>
                        </div>
                        <div class="col">
                            <?php echo $huesped[0][3] ?>
                        </div>
                    </div>
                    <div class="row justify-content-center align-items-center h-100 my-3 pb-5">
                        <div class="col ">
                            <h7><strong><u>Email</u></strong></h7>
                        </div>
                        <div class="col">
                            <?php echo $huesped[0][4] ?>
                        </div>
                    </div>
                    <div class="row justify-content-center align-items-center h-100 my-3 pb-5">
                        <div class="col ">
                            <h7><strong><u>Teléfono</u></strong></h7>
                        </div>
                        <div class="col">
                            <?php echo $huesped[0][5] ?>
                        </div>
                    </div>
                    <div class="row justify-content-center align-items-center h-100 my-3 pb-5">
                        <div class="col ">
                            <h7><strong><u>Notas </u></strong></h7>
                        </div>
                        <div class="col">
                            <?php echo $huesped[0][6] ?>
                        </div>
                    </div>
                </div>

                <div id="loggin" class="container-fluid h-100 my-5  rounded">
                    <div class="row justify-content-center align-items-center ">
                        <h1>Registro de entrada</h1>
                    </div>
                    <div class="row  justify-content-center align-items-center">
                    <h6>De no especificar código de habitación se asignara una automáticamente</h6>
                    </div>

                    <form action="index.php" method="POST" id="formAviso">
                        <div class="row justify-content-top align-items-top my-3">
                            <div class="col ">
                                <h7><strong><u>Fecha de entrada</u></strong></h7>
                            </div>
                            <div class="col">
                                <!--por defecto da la fecha de entrada como hoy ya que será lo habitual-->
                                <input type="date" require name="fechaEntrada" value="<?php echo date("Y-m-d"); ?>" min="<?php echo date("Y-m-d"); ?>">
                            </div>
                        </div>
                        <div class="row justify-content-top align-items-top my-3">
                            <div class="col ">
                                <h7><strong><u>Código habitación</u></strong></h7>
                            </div>
                            <div class="col">
                                <input type="number" value="<?php echo $bbdd1->informeHabitaciones()[0][0] ?>" name="codigoHabitacion">
                                <!--asigna la primer habitacion que esta vacia y no tiene notas(por si fuesen notas de desperfectos)-->
                            </div>
                        </div>
                        <div class="row justify-content-top align-items-top my-3">
                            <div class="col ">
                                <h7><strong><u>Fecha prevista de salida</u></strong></h7>
                            </div>
                            <div class="col">
                                <input type="date" require min="<?php echo date("Y-m-d"); ?>" name="fechaSalida">
                                <!--asigna la primer habitacion que esta vacia y no tiene notas(por si fuesen notas de desperfectos)-->
                            </div>
                        </div>

                        <div class="row justify-content-center align-items-center h-100 my-3 pb-5">
                            <div class="col ">
                                <button class="col btn btn-secondary btn-sm float-right" name="enviarEntrada" value="true">Enviar</button>
                            </div>
                        </div>
                        <input type="hidden" name="huesped" value="<?php echo $huesped[0][0][0] ?>">
                        <input type="hidden" name="opcionesMenu" value="altas">
                    </form>
                </div>

            </div>

        <?php
        } else {
            echo "<div id='loggin' class='container-fluid h-100 my-5  rounded'>Ningún huésped corresponde con la información facilitada. <br> Registre al nuevo huésped antes del resgistro.</div>";
        }
    } else {
        ?>
        <!--formulario para registrar comporbar la ficha del huesped-->
        <div id="loggin" class="container-fluid h-100 my-5  rounded">
            <div class="row justify-content-center align-items-center ">
                <h1>Huésped a dar de alta</h1>
            </div>
            <form action="index.php" method="POST" id="formAviso">
                <div class="row justify-content-top align-items-top my-3">
                    <div class="col ">
                        <h7><strong><u>DNI/NIE</u></strong></h7>
                    </div>
                    <div class="col">
                        <input type="text" name="dni">
                    </div>
                </div>
                <div class="row justify-content-center align-items-center h-100 my-3 pb-5">
                    <div class="col ">
                        <button class="col btn btn-secondary btn-sm float-right" name="enviar" value="true">Enviar</button>
                    </div>

                </div>
                <input type="hidden" name="opcionesMenu" value="altas">
            </form>
        </div>
<?php
    }
}
?>