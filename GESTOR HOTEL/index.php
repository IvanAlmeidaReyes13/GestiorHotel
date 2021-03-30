<?php

session_start();
/*
unset($_POST['usuario']);

unset($_POST['clave']);         //ACTUALIZAR DOC OCN EL CAMPO DE LA BBDD DE FECHA VENCIMIENTO DE LOS AVISOS

session_destroy();
*/
require_once("src/bbdd.php");

$bbdd = new bbdd();

require_once("src/app.php");

$app = new app();



?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jalula Hotel</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="estilos/estilos.css" >
    <link href="https://fonts.googleapis.com/css?family=Kaushan+Script&display=swap" rel="stylesheet"> 
    

</head>

<body scroll="no">

    <div class="container-fluid">
        <p id="titulo" class="mt-5 ">
            Jalula Hotel
        </p>

        <?php

        if((!empty($_POST['opcionesMenu']))&&($_POST['opcionesMenu']=="cerrar")){
            unset($_SESSION['usuario']);

            unset($_SESSION['tipo']);         

            session_destroy();
            $app->impresionLoggin();
        }else{
        
        if (!isset($_SESSION['loggedin'])) {
            if (!isset($_POST['usuario'])) {
                $app->impresionLoggin();
            
            }else{
                if(!$bbdd->loggin($_POST['usuario'],$_POST['clave'])){
                    unset($_POST['usuario']);
                    $app->impresionLoggin();
                }else{
                    include_once("navs/hall.php");
                }
                    
                }
            }else{
                include_once("navs/hall.php");
            }
        
        }
        ?>




    </div>
    
</div>



<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>



</body>

</html>