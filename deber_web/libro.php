<?php
    $conex = mysqli_connect("127.0.0.1", "root", "root11", "test1");

    if (!$conex) {
        echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
        echo "errno de depuración: " . mysqli_connect_errno() . PHP_EOL;
        echo "error de depuración: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }
    
    $accion="Agregar";
    $titulo = "";
    $autor = "";
    $fechaPublicacion = "";
    $precio = "";
    $paginas = "";
    $codigoLibro = "";
    if(isset($_POST["accion"])){
        if(isset($_POST["titulo"]) && $_POST["accion"] == "Agregar"){
            $stmt = $conex->prepare("INSERT INTO libro (titulo, autor, fecha_publicacion,precio,paginas) VALUES (?,?,?,?,?)");
            $stmt->bind_param('sssdd', $titulo,$autor,$fechaPublicacion,$precio,$paginas);
            $titulo = $_POST["titulo"];
            $autor = $_POST["autor"];
            $fechaPublicacion = $_POST["fecha_publicacion"];
            $precio = $_POST["precio"];
            $paginas = $_POST["paginas"];
            $stmt->execute();
            $stmt->close();
            $titulo = "";
            $autor = "";
            $fechaPublicacion = "";
            $precio = "";
            $paginas = "";
            $codigoLibro = "";
            $accion="Agregar";
        }elseif(isset($_POST["titulo"]) && $_POST["accion"] == "Modificar"){
            $stmt = $conex->prepare("UPDATE libro SET titulo = ?, autor = ?, fecha_publicacion = ?, precio = ?, paginas = ? WHERE codigo = ?");
            $stmt->bind_param('sssddi', $titulo,$autor,$fechaPublicacion,$precio,$paginas,$codigoLibro);
            $titulo = $_POST["titulo"];
            $autor = $_POST["autor"];
            $fechaPublicacion = $_POST["fecha_publicacion"];
            $precio = $_POST["precio"];
            $paginas = $_POST["paginas"];
            $codigoLibro = $_POST["codigoLibro"];
            $stmt->execute();
            $stmt->close();
            $titulo = "";
            $autor = "";
            $fechaPublicacion = "";
            $precio = "";
            $paginas = "";
            $codigoLibro = "";
            $accion="Agregar";
        }
    }elseif(isset($_POST["eliCodigo"])){
        $stmt = $conex->prepare("DELETE FROM libro WHERE codigo = ?");
        $stmt->bind_param('i',$codigoLibro);
        $codigoLibro = $_POST["eliCodigo"];
        $stmt->execute();
        $stmt->close();
        $codigoLibro = "";
    }

    if(isset($_GET["update"])){
        $sql = "SELECT * FROM libro WHERE codigo=".$_GET["update"];
        $result = $conex->query($sql);
        if ($result->num_rows > 0) {
            $row1= $result->fetch_assoc();
            $codigoLibro=$row1["codigo"];
            $titulo = $row1["titulo"];
            $autor = $row1["autor"];
            $fechaPublicacion = $row1["fecha_publicacion"];
            $precio = $row1["precio"];
            $paginas = $row1["paginas"];
        }
        $accion="Modificar";
    }

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Libro</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="./plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="./dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
            <!-- BORRE EL SEARCH AQUI  -->
        </nav>

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <p class="brand-link">
                <span class="brand-text font-weight-light" style="color:white;">Desarrollo WEB </span>
            </p>
            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="./dist/img/carnet.jpg" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <p class="d-block" style="color:white;">Santiago Vivas</p>
                    </div>
                </div>
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                        <li class="nav-item has-treeview">
                            <a href="" class="nav-link active">
                                <i class="nav-icon fas fa-edit"></i>
                                <p>Libro</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            <!-- /.sidebar -->
        </aside>

        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid" style="text-align: center;">
                    <div class="row mb-1">
                        <div class="col-sm-10">
                            <h1>Gestión Libros</h1>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            
            <div class="container-fluid">
            <div class="container">
            <form METHOD="POST" action="./libro.php" id="form" name="form">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Listado de libros</h3>
                            </div>
                            <div class="card-body table-responsive p-0" style="height: 300px;">
                                <table class="table table-head-fixed text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>Código</th>
                                            <th>Título</th>
                                            <th>Autor</th>
                                            <th>Fecha Publicación</th>
                                            <th>Precio</th>
                                            <th>Páginas</th>
                                            <th>Elimin</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT * FROM libro";
                                        $result = $conex->query($sql);
                                        if ($result->num_rows > 0) {
                                        // output data of each row
                                        while($row = $result->fetch_assoc()) {
                                        ?>
                                        <tr>
                                            <td><a href="./libro.php?update=<?php echo $row["codigo"]?>">
                                                    <?php echo $row["codigo"]?> </a></td>
                                            <td><?php echo $row["titulo"]?></td>
                                            <td><?php echo $row["autor"]?></td>
                                            <td><?php echo $row["fecha_publicacion"]?></td>
                                            <td><?php echo $row["precio"]?></td>
                                            <td><?php echo $row["paginas"]?></td>
                                            <td><input type="radio" name="eliCodigo"
                                                    value="<?php echo $row["codigo"]?>"></td>
                                        </tr>
                                        <?php 
                                        }
                                        ?>

                                        <?php 
                                        }else{
                                        ?>
                                        <tr>
                                            <td colspan="4"> No hay datos</td>
                                        </tr>
                                        <?php }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group card-header">
                                <input type="button" name="eliminar" class="btn btn-block btn-primary float-right" style="padding-bottom: 4px; width:75px;" 
                                value="Eliminar" onclick="eliminarLibro();">
                            </div>
                            
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mx-auto">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Nuevo Libro</h3>
                            </div>
                            <input type="hidden" name="codigoLibro" value="<?php echo $codigoLibro?>">

                            <div class="card-body">
                                <div class="form-group">
                                    <label for="titulo">Título</label>
                                    <input type="text" class="form-control" id="titulo"
                                        placeholder="Ingresar Título" name="titulo"
                                        value="<?php echo $titulo?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="autor">Autor</label>
                                    <input type="text" class="form-control" id="autor"
                                        placeholder="Ingresar Autor" name="autor"
                                        value="<?php echo $autor?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="fecha_publicacion">Fecha de Publicación</label>
                                    <input type="date" class="form-control" name="fecha_publicacion"
                                        id="fecha_publicacion" value="<?php echo $fechaPublicacion?>"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="precio">Precio</label>
                                    <input type="number" class="form-control" id="precio" min=0 step="any"
                                        placeholder="Ingresar Precio" name="precio"
                                        value="<?php echo $precio?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="paginas">Número de Páginas</label>
                                    <input type="number" class="form-control" id="paginas" min=0
                                        placeholder="Ingresar número de páginas" name="paginas"
                                        value="<?php echo $paginas?>" required>
                                </div>
                            </div>

                            <input type="submit" class="btn btn-primary btn-block" name="accion" value="<?php echo $accion;?>">

                        </div>
                    </div>
                </div>   
            </form>
            </div>
            </div>

        </div>
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    </div>
    <!-- jQuery -->
    <script src="./plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="./plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery UI -->
    <script src="./plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- AdminLTE App -->
    <script src="./dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="./dist/js/demo.js"></script>

    <!-- Page specific script -->
    <?php
    mysqli_close($conex);
    ?>
    <script>
        function eliminarLibro() {
            document.getElementById("form").submit();
        }
    </script>
</body>
</html>
