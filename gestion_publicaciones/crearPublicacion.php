<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- linkear con fuente belleza -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Belleza&display=swap" rel="stylesheet">

    <!-- links css -->
    <link rel="stylesheet" href="../css/headers.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/publicaciones.css">
    <link rel="stylesheet" href="../css/formPublicacion.css">


    <!-- link para iconos -->
    <link rel="stylesheet" href="../fontawesome-free-5.15.4-web/css/all.min.css">

    <!-- bootstrap -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <title>Crear Noticia</title>
</head>

<body>

    <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
            <a href="../index.php" class="me-md-auto">
                <span class="fs-4"><img src="../img/logoOriginal.png" class="img-fluid"></span>
            </a>

            <ul class="nav nav-pills mt-4">
                <li class="nav-item"><a href="../index.php" class="nav-link text-secondary">Inicio</a></li>
                <li class="nav-item"><a href="../publicaciones/index.php" class="nav-link text-secondary">Publicaciones</a></li>
                <li class="nav-item"><a href="../reservas/index.php" class="nav-link text-secondary">Reservas</a></li>
                <?php
                // Continuar la sesión
                session_start();

                if(isset($_SESSION['sesion_iniciada']) == true ){
                    $tipo = session_id();
                    if($tipo=="presidente" || $tipo=="administrador"){
                        echo "<li class='nav-item dropdown'>";
                            echo "<a class='nav-link dropdown-toggle text-secondary' href='#' id='navbarDropdown' role='button' data-bs-toggle='dropdown' aria-expanded='false'>";
                                echo "Gestiones";
                            echo "</a>";
                            echo "<ul class='dropdown-menu' aria-labelledby='navbarDropdown'>";
                                echo "<li><a class='dropdown-item' href='#'>Usuarios</a></li>";
                                echo "<li><a class='dropdown-item' href='../gestion_publicaciones/index.php'>Publicaciones</a></li>";
                                echo "<li><a class='dropdown-item' href='../instalaciones/index.php'>Instalaciones</a></li>";
                                echo "<li><a class='dropdown-item' href='#'>Contabilidad</a></li>";
                                echo "<li><a class='dropdown-item' href='#'>Estadisticas</a></li>";
                            echo "</ul>";
                        echo "</li>";
                    }
                    echo "<li class='nav-item me-md-auto'><a href='../cerrarSesion.php' class='nav-link active bg-secondary rounded-pill' aria-current='page'>Cerrar sesión</a></li>";
                }else{
                    echo "<li class='nav-item me-md-auto'><a href='../registro/index.php' class='nav-link active bg-secondary rounded-pill' aria-current='page'>Entrar</a></li>";
                }//Fin si
            ?>
            </ul>
    </header>

    <?php include "metodos.php";

        error_log(0);

    $confirmacion = '';
    $error=false;//Control de errores
    $errores="";
    //Variables obtenidas por metodo post del formulario
    //isset para controlar errores
        
        $titulo = $_POST['titulo'];
        $publicacion = isset($_POST['publicacion']);
        $tipo = isset($_POST['tipo']);
        $contenido = $_POST['contenido'];
        $fecha = $_POST['fecha'];

        //El HTML no lo controlaremos con required, para que así nos puedan meter valores vacios, ademas le daremos type text a todos para que puedan fallar y controlarlo aqui.
        if($publicacion==""){
            $errores .= "<li>Necesitamos saber si es una noticia o evento</li>";
            $error=true;
        }else{
            $publicacion =$_POST['publicacion'];
        }

        if($titulo==""){
            $errores .= "<li>Para definir la publicacion necesitamo un titulo</li>";
            $error=true;
        }

        if($tipo==""){
            $errores .= "<li>Es obligatorio definir la privacidad de la publicacion</li>";
            $error=true;
        }else{
            $tipo = $_POST['tipo'];
        }

        if($contenido==""){
            $errores .= "<li>Es necesaria una breve descripcion de la publicacion</li>";
            $error=true;
        }

        if($fecha==""){
            $errores .= "<li>Defina la fecha</li>";
            $error=true;
        }


        if (!$error) {
            $confirmacion = "Estos son los datos introducidos: <br>";
            $confirmacion .= "<li>Titulo: $titulo</li>";
            $confirmacion .= "<li>Tipo: $tipo</li>";
            $confirmacion .= "<li>Publicacion: $publicacion</li>";
            $confirmacion .= "<li>Contenido: $contenido</li>";
            insertarPublicacion($titulo, $publicacion, $tipo, $contenido, $fecha);
        }else{
            $confirmacion = "No se han podido realizar la inserción";
            $confirmacion .= $errores;

        }

    ?>
    <p><?php print($confirmacion); ?></p>   
    <a href="form.php">[ Insertar otra publicacion ]</a>
    <a href="index.php">[ Volver ]</a>
    <footer class="d-flex flex-wrap justify-content-center align-items-center py-3 mt-4 border-top">
        <div class="col-md-4 d-flex align-items-center">
            <a href="../index.php" class="mb-3 me-2 mb-md-0 text-muted text-decoration-none lh-1">
                <img src="../img/logoNaranja.png" alt="logo">
            </a>
            <span class="text-muted">&copy; 2021 Company, Inc</span>
        </div>

        <ul class="nav col-md-4 justify-content-end list-unstyled d-flex fs-1">
            <li class="m-5"><i class="fab fa-instagram"></i></li>
            <li class="m-5"><i class="fab fa-twitter"></i></li>
            <li class="m-5"><i class="fab fa-facebook-square"></i></li>
        </ul>
    </footer>
    <script src="../js/bootstrap.bundle.min"></script>
</body>
</html>