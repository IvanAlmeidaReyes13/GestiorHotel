<?php

class app
{

    //las funciones basicas de la pp
    //impresion del loggin(que valdra para las autorizaciones tambien)
    public function impresionLoggin($pantalla = "hall")
    {
        switch ($pantalla) {
            case "bajas":
                $titulo = "Autorización";
                break;
            default:
                $titulo = "Registro";
        }
        echo '<div id="loggin" class="container-fluid h-100 my-5  rounded">
        <div class="row justify-content-center align-items-center ">
        <h1>' . $titulo . '</h1>
       </div>
            <br>
                <div class="row justify-content-center align-items-center h-100">
                    <div class="col ">
                        <form action="index.php" method="POST">
                            <div class="form-group">
                                <input type="text" required="required" class="form-control" placeholder="NOMBRE" name="usuario"/><BR>
                                <input type="password" required="required" class="form-control" placeholder="CONTRASEÑA" name="clave" />
                            </div>
                            <div class="form-group">
                                <div class="container">
                                    <div class="row">
                                        <div class="col"><button class="col btn btn-secondary btn-sm float-right">Entrar</button></div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="opcionesMenu" value="' . $pantalla . '"/>
                        </form>
                    </div>
                </div>
            </div>';
    }
    //impresion del menu que siempre estara presente
    public function impresionMenu()
    {
        echo ' <nav class="navbar navbar-expand-lg navbar-light bg-light ">
        <div class="collapse navbar-collapse justify-content-center align-items-center" id="navbarNav">
            <form method="post" action="index.php">
                <ul class="navbar-nav">
                     <li class="nav-item active">
                        <button class="btn btn-light" type="submit" value="hall" name="opcionesMenu">HALL</button>
                    </li>
                    <li class="nav-item active">
                        <button class="btn btn-light" type="submit" value="altas" name="opcionesMenu">ALTAS</button>
                    </li>
                    <li class="nav-item">
                        <button class="btn btn-light" type="submit" value="bajas" name="opcionesMenu">BAJAS</button>
                    </li>
                    <li class="nav-item">
                        <button class="btn btn-light" type="submit" value="huespedes" name="opcionesMenu">HUESPEDES</button>
                    </li>
                    <li class="nav-item ">
                        <button class="btn btn-light" type="submit" value="hotel" name="opcionesMenu">HOTEL</button>
                    </li>
                    <li class="nav-item mr-5">
                        <button class="btn btn-light" type="submit" value="avisos" name="opcionesMenu">AÑADIR AVISO</button>
                    </li>
                    
                    <li class="nav-item">
                    <button class="btn btn-outline-danger btn-sm" type="submit" value="cerrar" name="opcionesMenu">CERRAR SESIÓN</button>
                    </li>
                    
                </ul>
            </form>
        </div>
    </nav>';
    }
    //menu de navegacion que segun las peticiones dara una pagina u otra, por defecto ira al hall.
    public function navegar($opcionesMenu)
    {
        switch ($opcionesMenu) {
            case "altas":
                include_once("navs/altas.php");
                break;

            case "bajas":
                include_once("navs/bajas.php");
                break;

            case "huespedes":
                include_once("navs/huespedes.php");
                break;

            case "avisos":
                include_once("navs/avisos.php");
                break;

            case "hall":
                include_once("navs/hall.php");
                break;

            case "hotel":
                include_once("navs/hotel.php");
                break;

            default:
                $_POST['opcionesMenu'] = "hall";
                include_once("navs/hall.php");
        }
    }
}
