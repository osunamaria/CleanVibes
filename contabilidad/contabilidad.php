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

    <!-- link para iconos -->
    <link rel="stylesheet" href="fontawesome-free-5.15.4-web/css/all.min.css">

    <!-- bootstrap -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">

    <!-- links css -->
    <link rel="stylesheet" href="../css/headerContabilidad.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/contabilidad.css">
    <title>Contabilidad</title>
</head>
<body>
    <div class="container">
        <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
        <a href="index.php" class="me-md-auto">
            <span class="fs-4"><img src="img/logoOriginal.png" class="img-fluid"></span>
        </a>

        <ul class="nav nav-pills mt-4">
            <li class="nav-item"><a href="index.php" class="nav-link text-secondary">Inicio</a></li>
            <li class="nav-item"><a href="publicaciones/index.html" class="nav-link text-secondary">Publicaciones</a></li>
            <li class="nav-item"><a href="reservas/index.html" class="nav-link text-secondary">Reservas</a></li>
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
                                echo "<li><a class='dropdown-item' href='#'>Publicaciones</a></li>";
                                echo "<li><a class='dropdown-item' href='#'>Instalaciones</a></li>";
                                echo "<li><a class='dropdown-item' href='#'>Contabilidad</a></li>";
                                echo "<li><a class='dropdown-item' href='#'>Estadisticas</a></li>";
                            echo "</ul>";
                        echo "</li>";
                    }
                    echo "<li class='nav-item me-md-auto'><a href='cerrarSesion.php' class='nav-link active bg-secondary rounded-pill' aria-current='page'>Cerrar sesión</a></li>";
                }else{
                    echo "<li class='nav-item me-md-auto'><a href='registro/index.php' class='nav-link active bg-secondary rounded-pill' aria-current='page'>Entrar</a></li>";
                }//Fin si
            ?>
        </ul>
        </header>
    </div>

    <article class="container">
      <form action="../php/contabilidad.php" class="row justify-content-center mb-3 bg-secondary p-2">
        <label for="cuentas" class="col-1">Cuentas: </label>
        <div class="col-9 text-start">
          <select name="cuentas" id="cuentas">
            <option value="gEvento">Gasto eventos</option>
            <option value="gInstalacion">Gasto instalaciones</option>
            <option value="gOtros">Gastos otros</option>
            <option value="iCuota">Ingresos cuotas</option>
            <option value="iReserva">Ingresos reservas</option>
            <option value="total">Total</option>
          </select>
        </div>
        <div class="col-2 text-end">
          <input type="submit" value="Buscar">
        </div>
      </form>

      <table class="table table-success table-striped">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">First</th>
            <th scope="col">Last</th>
            <th scope="col">Handle</th>
          </tr>
        </thead>
        <tbody>

        <!-- php ----------------------------- -->
        <?php 
            include "databaseManagement.inc.php";//php con metodos
            $cuentas = $_POST["cuentas"];
            function obtenerCuentas(){
                try {
                    $con = new PDO("mysql:host=" . $GLOBALS['servidor'] . ";dbname=" . $GLOBALS['baseDatos'], $GLOBALS['usuario'], $GLOBALS['pass']);
                    if($cuentas == "total"){
                        $cuentas = "*";
                    }//Fin Si
                    $sql = $con->prepare("SELECT ".$cuentas." from contabilidad;");
                    $sql->execute();
                    $miArray = [];
                    while ($row = $sql->fetch(PDO::FETCH_ASSOC)) { //Haciendo uso de PDO iremos creando el array dinámicamente
                        $miArray[] = $row; //https://www.it-swarm-es.com/es/php/rellenar-php-array-desde-while-loop/972445501/
                    }
                    $con = null;
                } catch (PDOException $e) {
                    echo $e;
                }
                return $miArray;
            }
            $listaCuentas = obtenerCuentas();
            for ($i=0;$i<sizeof($listaCuentas);$i++){
                echo "<tr>";
                echo "<td>".$listaCuentas[$i]."</td>";
                echo "</tr>";
            }//Fin Para

            ?>
        </tbody>
        </table>
    </article>

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
    <!-- Bootstrap JavaScript Libraries -->
    <script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>