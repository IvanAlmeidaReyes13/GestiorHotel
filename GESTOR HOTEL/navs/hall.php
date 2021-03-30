<?php
require_once("src/app.php");
avisarSalidas();
$app = new app();
//el menu siempre se imprimira ya que ademas del hall aqui se gestiona la navegacion  de la app, como en el hotel, desde el hall se llega a todas partes
$app->impresionMenu();

$opcionesMenu = $_POST['opcionesMenu'] ?? "";
$app->navegar($opcionesMenu);
if ($_POST['opcionesMenu'] == "hall") { //si la navegacion es el hall se imprime directamente su pantalla, por lo contrario se ira a la pagina que corresponda y no entrara aqui

?>
    <!--impresion de la tabla de los avisos-->
    <div id="avisos" class="container-fluid h-100 my-5  rounded">
        <div class="row justify-content-center align-items-center ">
            <h1>Avisos</h1>
        </div>
        <div class="row justify-content-center align-items-center h-100">
            <div class="col"></div>
            <div class="col ">
                <h7><strong><u>Mensaje</u></strong></h7>
            </div>
            <div class="col">
                <h7><strong><u>Fecha</u></strong></h7>
            </div>
            <div class="col">
                <h7><strong><u>Usuario</u></strong></h7>
            </div>
            <div class="col"></div>
        </div>
        <?php echo datosAvisos() ?>
    </div>
<?php
}
//funcion para recoger los datos de los avisos de la bbdd con su funcion e imprimirlos en el orden correcto 
function datosAvisos()
{
    $avisos = "";
    require_once('src/bbdd.php');
    $bbdd2 = new bbdd();
    $datos = $bbdd2->recogerAvisos();
    if (is_array($datos)) {
        foreach ($datos as $value) {
            if($value[3]=="SISTEMA"){
                $color="alert alert-warning";
            }else{
                $color="";
            }
            $avisos .= '
                  <div class="row justify-content-center align-items-center-'.$color.' h-100 py-2">
                      <div class = "col"></div>
                     <div class="col ">' . $value[0];
            $avisos .= '</div>
                     <div class="col">' . $value[1] . '</div>
                     <div class="col">' . $value[3] . '</div>
                      <div class = "col"></div>
                   </div>';
        }
    } else {
        $avisos = $datos;
    }
    return $avisos;
}

function avisarSalidas()
{
    require_once('src/bbdd.php');
    $bbdd2 = new bbdd();
    $datos = $bbdd2->informeRegistros();
    $date = date("Y-m-d");
    $avisos = $bbdd2->recogerAvisos();
    if (is_array($datos)) {

        foreach ($datos as $value) {
            $pintado = false;
            $mensaje = "Salida prevista para hoy del huesped " . $value[2] . " de la habitacion " . $value[3];
            if (is_array($avisos)) {

                for($i = 0;$i<=count($avisos) && $pintado==false && !empty($avisos[$i]);$i++) {
                    
                    if ($avisos[$i][0] == $mensaje) {
                        $pintado = true;
                    }else{
                        $pintado=false;
                    }  
                }
                if ($pintado == false) {
                    $bbdd2->insertarAvisos($mensaje, $date, "SISTEMA");
                }

            } else {
                $bbdd2->insertarAvisos($mensaje, $date, "SISTEMA");
            }
        }
    }
}


?>