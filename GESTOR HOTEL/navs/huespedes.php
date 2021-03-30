<?php

$enviar = $_POST['enviar'] ?? false;
if ($enviar == false) {
?>
    <div id="loggin" class="container-fluid h-100 my-5  rounded">
        <div class="row justify-content-center align-items-center ">
            <h1>¿Que desea hacer?</h1>
        </div>
        <form action="index.php" method="POST" id="formAviso">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col ">
                    <button type="submit" name="enviar" value="registrar" class="col btn btn-secondary btn-sm float-right">Registrar huésped</button>
                </div>
                <div class="col">
                    <button type="submit" name="enviar" value="buscar" class="col btn btn-secondary btn-sm float-right">Buscar huésped</button>
                </div>
            </div>
            <input type="hidden" name="opcionesMenu" value="huespedes">
        </form>
    </div>

    <?php

} else {



    if ($enviar == "registrar") {
    ?>
<!--formulario para registrar el nuevo huesped-->
        <div id="loggin" class="container-fluid h-100 my-5  rounded">
            <div class="row justify-content-center align-items-center ">
                <h1>Registrar nuevo huésped</h1>
            </div>
            <form action="index.php" method="POST" id="formAviso">
                <div class="row justify-content-center align-items-center h-100">
                    <div class="col ">
                        <h7><strong><u>Nombre</u></strong></h7>
                    </div>
                    <div class="col">
                        <input type="text" require name="nombre">
                    </div>
                </div>
                <div class="row justify-content-top align-items-top my-3">
                    <div class="col ">
                        <h7><strong><u>Apellidos</u></strong></h7>
                    </div>
                    <div class="col">
                        <input type="text" require name="apellidos">
                    </div>
                </div>
                <div class="row justify-content-top align-items-top my-3">
                    <div class="col ">
                        <h7><strong><u>DNI/NIE</u></strong></h7>
                    </div>
                    <div class="col">
                        <input type="text" require name="dni">
                    </div>
                </div>
                <div class="row justify-content-top align-items-top my-3">
                    <div class="col ">
                        <h7><strong><u>Email</u></strong></h7>
                    </div>
                    <div class="col">
                        <input type="mail" require name="email">
                    </div>
                </div>
                <div class="row justify-content-top align-items-top my-3">
                    <div class="col ">
                        <h7><strong><u>Teléfono</u></strong></h7>
                    </div>
                    <div class="col">
                        <input type="number" require name="telefono" minlenght="8" maxlength="10">
                    </div>
                </div>
                <div class="row justify-content-top align-items-top my-3">
                    <div class="col ">
                        <h7><strong><u>Notas</u></strong></h7>
                    </div>
                    <div class="col">
                        <textarea name="notas" rows="3" cols="20" maxlength="255" minlength="10"></textarea>
                    </div>
                </div>
                <div class="row justify-content-center align-items-center h-100 my-3 pb-5">
                    <div class="col ">
                        <button class="col btn btn-secondary btn-sm float-right">Enviar</button>
                    </div>

                </div>
                <input type="hidden" name="enviar" value="registrar">
                <input type="hidden" name="opcionesMenu" value="huespedes">
            </form>

        </div>
        <?php





//si el dni esta vacio no se hace nada mas ( es esencial para el registro)
        if (!empty($_POST['dni'])) {
            require_once("src/bbdd.php");
            $bbdd1 = new bbdd();
            $notas = $_POST['notas'] ?? "";
            echo $bbdd1->insetarHuesped($_POST['nombre'], $_POST['apellidos'], $_POST['dni'], $_POST['email'], $_POST['telefono'], $notas);
        }
    } else if ($enviar == "buscar") {




//solamente los usuarios de tipo admin podran entrar a ver la informacion proporcionada por los huespedes(evita problemas de privacidad)

        if ($_SESSION['tipo'] != "admin") {
            echo "<div id='loggin' class='container-fluid h-100 my-5  rounded'>Los usuarios de tipo estandar no pueden acceder a la información de los clientes</div>";
        } else {
            if (!empty($_POST['actualizarCampos'])) {
                require_once("src/bbdd.php");
                $bbdd1 = new bbdd();
                echo $bbdd1->actualizarHuespedes($_POST['codigoHuesped'], $_POST['nombre'], $_POST['apellidos'], $_POST['dni'], $_POST['email'], $_POST['telefono'], $_POST['notas']);
            } else {




// si no se ha enviado la peticion para editar algun campo no se entra, de hacerlo se buscara la informacion por el parametro codigoHuesped
                if (!empty($_POST["editarCampos"])) {
                    require_once("src/bbdd.php");
                    $bbdd1 = new bbdd();
                    $editar = $bbdd1->buscarCodigo($_POST['editarCampos']);

        ?>

                    <div id="loggin" class="container-fluid h-100 my-5  rounded">
                        <div class="row justify-content-center align-items-center ">
                            <h1>Actualizar huésped</h1>
                        </div>
                        <form action="index.php" method="POST" id="formAviso">
                            <div class="row justify-content-center align-items-center h-100">
                                <div class="col ">
                                    <h7><strong><u>Nombre</u></strong></h7>
                                </div>
                                <div class="col">
                                <!--Los valores por defecto seran los que ya tiene el usuario para no tener que rellenar un formulario para cada una o tener que rellenarlo entero de nuevo-->
                                    <input type="text" required value="<?php echo $editar[0][1] ?>" name="nombre">
                                </div>
                            </div>
                            <div class="row justify-content-top align-items-top my-3">
                                <div class="col ">
                                    <h7><strong><u>Apellidos</u></strong></h7>
                                </div>
                                <div class="col">
                                    <input type="text" required value="<?php echo $editar[0][2] ?>" name="apellidos">
                                </div>
                            </div>
                            <div class="row justify-content-top align-items-top my-3">
                                <div class="col ">
                                    <h7><strong><u>DNI/NIE</u></strong></h7>
                                </div>
                                <div class="col">
                                    <input type="text" required value="<?php echo $editar[0][3] ?>" name="dni">
                                </div>
                            </div>
                            <div class="row justify-content-top align-items-top my-3">
                                <div class="col ">
                                    <h7><strong><u>Email</u></strong></h7>
                                </div>
                                <div class="col">
                                    <input type="mail" required value="<?php echo $editar[0][4] ?>" name="email">
                                </div>
                            </div>
                            <div class="row justify-content-top align-items-top my-3">
                                <div class="col ">
                                    <h7><strong><u>Teléfono</u></strong></h7>
                                </div>
                                <div class="col">
                                    <input type="number" required value="<?php echo $editar[0][5] ?>" name="telefono" minlenght="8" maxlength="10">
                                </div>
                            </div>
                            <div class="row justify-content-top align-items-top my-3">
                                <div class="col ">
                                    <h7><strong><u>Notas</u></strong></h7>
                                </div>
                                <div class="col">
                                    <textarea name="notas" rows="3" cols="20" maxlength="255" minlength="10"><?php echo $editar[0][6] ?></textarea>
                                </div>
                            </div>
                            <div class="row justify-content-center align-items-center h-100 my-3 pb-5">
                                <div class="col ">
                                    <button type="submit" name="actualizarCampos" required value="true" class="col btn btn-secondary btn-sm float-right">Actualizar campos</button>
                                </div>

                            </div>
                            <input type="hidden" name="enviar" value="buscar">
                            <input type="hidden" name="opcionesMenu" value="huespedes">
                            <input type="hidden" name="codigoHuesped" value="<?php echo $editar[0][0][0] ?>">

                        </form>

                    </div>
                <?php

                }




//si no se indica que el registro de busqueda se ha mandado no se muestra nada mas
                $enviarBusqueda = $_POST['enviarBusqueda'] ?? false;
                if ($enviarBusqueda) {
                    require_once("src/bbdd.php");
                    $bbdd1 = new bbdd();
                    $huesped = "";
                    $huesped = $bbdd1->busquedaHuesped($_POST['apellidos'], $_POST['dni']);
                }




                //si aun no se ha buscado ningun huesped se muestra formulario para proporcionar la informacion
                if (empty($huesped)) {
                ?>

                    <div id="loggin" class="container-fluid h-100 my-5  rounded">
                        <div class="row justify-content-center align-items-center ">
                            <h3>Introduce los datos de los que dispongas para buscar un registro</h3>
                        </div>
                        <form action="index.php" method="POST" id="formAviso">
                            <div class="row justify-content-center align-items-center h-100">
                                <div class="row justify-content-top align-items-top my-3">
                                    <div class="col ">
                                        <h7><strong><u>Apellidos</u></strong></h7>
                                    </div>
                                    <div class="col">
                                        <input type="text" value="" name="apellidos">
                                    </div>
                                </div>
                                <div class="row justify-content-top align-items-top my-3">
                                    <div class="col ">
                                        <h7><strong><u>DNI/NIE</u></strong></h7>
                                    </div>
                                    <div class="col">
                                        <input type="text" value="" name="dni">
                                    </div>
                                </div>
                                <div class="row justify-content-center align-items-center h-100 my-3 pb-5">
                                    <div class="col ">
                                        <button type="submit" name="enviarBusqueda" value="true" class="col btn btn-secondary btn-sm float-right">Enviar</button>
                                    </div>
                                </div>
                                <input type="hidden" name="enviar" value="buscar">
                                <input type="hidden" name="opcionesMenu" value="huespedes">
                        </form>
                    </div>

                    <?php
                } else {




//recorremos todos los valores de los huespedes que consiguieron concordar con laa busqueda
                    foreach ($huesped as $value) {
                    ?>
                        <div id="loggin" class="container-fluid h-100 my-5  rounded">
                            <div class="row justify-content-center align-items-center ">
                                <h1>Datos de Huésped</h1>
                            </div>

                            <div class="row justify-content-top align-items-top my-3">
                                <div class="col ">
                                    <h7><strong><u>Codigo Huésped</u></strong></h7>
                                </div>
                                <div class="col">
                                    <?php echo $value[0][0] ?>
                                </div>
                            </div>

                            <div class="row justify-content-top align-items-top my-3">
                                <div class="col ">
                                    <h7><strong><u>Nombre</u></strong></h7>
                                </div>
                                <div class="col">
                                    <?php echo $value[1] ?>
                                </div>
                            </div>
                            <div class="row justify-content-top align-items-top my-3">
                                <div class="col ">
                                    <h7><strong><u>Apellidos</u></strong></h7>
                                </div>
                                <div class="col">
                                    <?php echo $value[2] ?>
                                </div>
                            </div>
                            <div class="row justify-content-center align-items-center h-100 my-3 pb-5">
                                <div class="col ">
                                    <h7><strong><u>DNI/NIE</u></strong></h7>
                                </div>
                                <div class="col">
                                    <?php echo $value[3] ?>
                                </div>
                            </div>
                            <div class="row justify-content-center align-items-center h-100 my-3 pb-5">
                                <div class="col ">
                                    <h7><strong><u>Email</u></strong></h7>
                                </div>
                                <div class="col">
                                    <?php echo $value[4] ?>
                                </div>
                            </div>
                            <div class="row justify-content-center align-items-center h-100 my-3 pb-5">
                                <div class="col ">
                                    <h7><strong><u>Telefono</u></strong></h7>
                                </div>
                                <div class="col">
                                    <?php echo $value[5] ?>
                                </div>
                            </div>
                            <div class="row justify-content-center align-items-center h-100 my-3 pb-5">
                                <div class="col ">
                                    <h7><strong><u>Notas </u></strong></h7>
                                </div>
                                <div class="col">
                                    <?php echo $value[6] ?>
                                </div>
                            </div>
                            <div class="row justify-content-center align-items-center h-100 my-3 pb-5">
                                <div class="col ">
                                    <form action="index.php" method="POST">
                                        <button type="submit" name="editarCampos" value="<?php echo $value[0][0] ?>" class="col btn btn-secondary btn-sm float-right">Editar huésped</button>
                                        <input type="hidden" name="enviar" value="buscar">
                                        <input type="hidden" name="opcionesMenu" value="huespedes">
                                    </form>
                                </div>
                            </div>
                        </div>


<?php
                    }
                }
            }
        }
    }
}

?>