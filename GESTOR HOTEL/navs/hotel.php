<?php
include_once("src/bbdd.php");
$bbdd1 = new bbdd();
$enviar = $_POST['enviar'] ?? false;
$editarNotas=$_POST['editarNotas'] ?? ""; //si esto esta vacio no se entra a editar las notas
if(!empty($_POST['editarNotas'])){
echo $bbdd1->editarNotas($editarNotas,$_POST['nota']);
}else{
if ($enviar == false) {
?>
    <div id="loggin" class="container-fluid h-100 my-5  rounded">
        <div class="row justify-content-center align-items-center ">
            <h1>¿Que desea hacer?</h1>
        </div>
        <form action="index.php" method="POST" id="formAviso">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col ">
                    <button type="submit" name="enviar" value="todas" class="col btn btn-secondary btn-sm float-right">Ver todas las habitaciones</button>
                </div>
                <div class="col">
                    <button type="submit" name="enviar" value="buscar" class="col btn btn-secondary btn-sm float-right">Buscar habitacion</button>
                </div>
            </div>
            <input type="hidden" name="opcionesMenu" value="hotel">
        </form>
    </div>

    <?php

} else {



    if ($enviar == "todas") {
        $habitaciones = $bbdd1->buscarHabitacion();
        mostrarHabitaciones($habitaciones,"todas");

    } else {

        if (!empty($_POST['buscarHabitacion'])) {
            $habitaciones = $bbdd1->buscarHabitacion($_POST['codHabitacion']);
            mostrarHabitaciones($habitaciones,"buscar");
            
    
    
                
            

        } else {


        ?>
            <!--formulario para buscar la habitacion-->
            <div id="loggin" class="container-fluid h-100 my-5  rounded">
                <div class="row justify-content-center align-items-center ">
                    <h1>Buscar habitacion</h1>
                </div>
                <form action="index.php" method="POST" id="formAviso">
                    <div class="row justify-content-top align-items-top my-3">
                        <div class="col ">
                            <h7><strong><u>Codigo habitacion</u></strong></h7>
                        </div>
                        <div class="col">
                            <input type="text" name="codHabitacion">
                        </div>
                    </div>
                    <div class="row justify-content-center align-items-center h-100 my-3 pb-5">
                        <div class="col ">
                            <button class="col btn btn-secondary btn-sm float-right" name="buscarHabitacion" value="true">Buscar</button>
                        </div>

                    </div>
                    <input type="hidden" name="opcionesMenu" value="hotel">
                    <input type="hidden" name="enviar" value="buscar">
                </form>
            </div>
<?php

        }
    }
}
}
//funcion que muestra las habitaciones pedidas(todas o una en particular), tambien muestra el formulario de actualizacion de las notas
function mostrarHabitaciones($habitaciones,$estado){
    if ($habitaciones == "") {
        echo "<div id='loggin' class='container-fluid h-100 my-5  rounded'>Ninguna coincidencia</div>";
    } else {


        foreach ($habitaciones as $item) {
?>

            <div id="loggin" class="container-fluid h-100 my-5  rounded">
                <div class="row justify-content-center align-items-center ">
                    <h1>Datos de habitacion nº <?php echo $item[0] ?> </h1>
                </div>
                <div class="row justify-content-top align-items-top my-3">
                    <div class="col ">
                        <h7><strong><u>Huesped</u></strong></h7>
                    </div>
                    <div class="col">
                        <?php if (empty($item[1])) {
                            echo "Vacia";
                        } else {
                            echo $item[1];
                        } ?>
                    </div>
                </div>
                <div class="row justify-content-top align-items-top my-3">
                    <div class="col ">
                        <h7><strong><u>Notas</u></strong></h7>
                    </div>
                    <form action="index.php" method="POST">
                    <div class="col">
                        <?php if (empty($item[2])) {
                            $nota= "";
                        } else {
                            $nota= $item[2];
                        } ?>
                         <textarea name="nota" rows="3" cols="20" maxlength="255" minlength="10"><?php echo $nota ?></textarea>
                    </div>
                    </div>
                <div class="row justify-content-top align-items-top my-3">
                    <div class="col ">
                            <button class="col btn btn-secondary btn-sm float-right" name="editarNotas" value="<?php echo $item[0]?>">Editar</button>
                            <input type="hidden" name="enviar" value="<?php echo $estado ?>">
                            <input type="hidden" name="opcionesMenu" value="hotel">
                        </div>
                    </form>
                </div>
            </div>
            <?php
        }
    }
}