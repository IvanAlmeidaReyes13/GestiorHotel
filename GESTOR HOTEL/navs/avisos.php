<div id="loggin" class="container-fluid h-100 my-5  rounded">
    <div class="row justify-content-center align-items-center ">
        <h1>Añadir nuevo aviso</h1>
    </div>
    <!--formulario para añadir los datos del nuevo aviso a dejar-->
    <form action="index.php" method="POST" id="formAviso">
        <div class="row justify-content-center align-items-center h-100">
            <div class="col ">
                <h7><strong><u>Mensaje del aviso</u></strong></h7>
            </div>
            <div class="col">
            <textarea name="mensaje" rows="3" cols="20" maxlength="255" minlength="10">Escribe aquí tu mensaje</textarea>
            </div>
        </div>
        <div class="row justify-content-top align-items-top my-3">
            <div class="col ">
                <h7><strong><u>Fecha de vencimiento del aviso</u></strong></h7>
            </div>
            <div class="col">
                <!--la fecha de hoy como minimo por que no se pueden dejar mensajes en el pasado(no valdrian de nada)-->
                <input type="date" name="fechaVencimiento" value="<?php echo date("Y-m-d"); ?>" min="<?php echo date("Y-m-d"); ?>">
            </div>
        </div>
        <div class="row justify-content-center align-items-center h-100 my-3 pb-5">
            <div class="col ">
            <button class="col btn btn-secondary btn-sm float-right">Enviar</button>
            </div>
            
        </div>
        <input type="hidden" name="opcionesMenu" value="avisos">
    </form>

</div>


<?php
//si no hay mensaje ninguno no se entrara para evitar entradas vacias
if(!empty($_POST['mensaje'])){
require_once("src/bbdd.php");
$bbdd1= new bbdd();
echo $bbdd1->insertarAvisos($_POST['mensaje'],$_POST['fechaVencimiento'],$_SESSION['usuario']);
}
?>