<?php

require_once("src/bbdd.php");
$bbdd1 = new bbdd();
require_once("src/app.php");
$app = new app();
//si no hay autorizacion ni tampoco se es de tipo admin se imprimira un loggin para la autorizacion
if (!isset($_SESSION['autorizacion']) && $_SESSION['tipo']!="admin") {
    if (!isset($_POST['usuario'])) {
        $app->impresionLoggin("bajas");
    
    }else{
        //si no se da la verificacion de que es un usuario que puede autorizar la entrada se volvera a imrpimir el fomrulario de loggin de la autorizacion
        if(!$bbdd1->autorizar($_POST['usuario'],$_POST['clave'])){
            unset($_POST['usuario']);
            $app->impresionLoggin("bajas");
        }else{
            //si todo es correcto se propondra el formulario de la baja
            darBaja();
        }
            
        }
    }else{
        darBaja();
    }


function darBaja()
{
    require_once("src/bbdd.php");
    $bbdd1 = new bbdd();
    $enviar = $_POST['enviar'] ?? false;
    
        if ($enviar) {

            echo $bbdd1->salidaHuesped($_POST['dni']);
        } else {
    echo '<div id="loggin" class="container-fluid h-100 my-5  rounded">
         <div class="row justify-content-center align-items-center ">
             <h1>Huésped a dar de baja</h1>
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
             <input type="hidden" name="opcionesMenu" value="bajas">
         </form>
     </div>';
        }
}