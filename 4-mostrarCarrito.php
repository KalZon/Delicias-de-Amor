<?php session_start();

    include 'con_bd.php';



    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['id']) && isset($_POST['nombre']) && isset($_POST['precio']) && isset($_POST['cantidad'])) {
            // Obtener los datos del producto enviado desde el formulario
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $precio = $_POST['precio'];
            $cantidad = $_POST['cantidad'];

            $producto = array(
                'ID' => $id,
                'NOMBRE' => $nombre,
                'CANTIDAD' => $cantidad,
                'PRECIO' => $precio
            );

            if (!isset($_SESSION['CARRITO'])) {
                $_SESSION['CARRITO'] = array();
                $_SESSION['idUsuario'] = 1; // Inicializar el ID de usuario en 1         
            }

            array_push($_SESSION['CARRITO'], $producto);

            echo "<script>alert('Producto añadido al carrito'); window.location.href='4-mostrarCarrito.php';</script>";
            exit();
        } elseif (isset($_POST['eliminar_indice'])) {
            $indice = $_POST['eliminar_indice'];
            if (isset($_SESSION['CARRITO'][$indice])) {
                unset($_SESSION['CARRITO'][$indice]);
                $_SESSION['CARRITO'] = array_values($_SESSION['CARRITO']);
            }
        } elseif (isset($_POST['action']) && $_POST['action'] == 'borrar_todo') {
            unset($_SESSION['CARRITO']);
        } elseif (isset($_POST['action']) && $_POST['action'] == 'guardar_pedido') {

            // INSERTAR DATOS
            if (isset($_SESSION['CARRITO']) && !empty($_SESSION['CARRITO'])) {
                // Obtener el ID de usuario de la sesión

                foreach ($_SESSION['CARRITO'] as $producto) {
                    //$_SESSION['idUsuario'] = $idUsuario;                
                    $nombre = $producto['NOMBRE'];
                    $cantidad = $producto['CANTIDAD'];
                    $precio = $producto['PRECIO'];
                    // Fecha de registro
                    $fechareg = date("Y-m-d H:i:s"); // Formato de fecha y hora para MySQL                   
                    // Consulta preparada para insertar el pedido en la base de datos
                    $consulta = "INSERT INTO pedido (nombre, cantidad, precio, idUsuario, fecha_reg) VALUES (?, ?, ?, ?, ?)";
                    $stmt = mysqli_prepare($conexion, $consulta);
                    mysqli_stmt_bind_param($stmt, 'sidis', $nombre, $cantidad, $precio, $idUsuario, $fechareg);
                    $resultado = mysqli_stmt_execute($stmt);
            
                    if (!$resultado) {
                        die("Error al insertar el pedido: " . mysqli_error($conexion));
                    }
                }
                // Respuesta para AJAX
                echo json_encode(['status' => 'success', 'message' => '¡Pedido guardado exitosamente!']);
                exit();
            } else {
                echo json_encode(['status' => 'error', 'message' => 'El carrito está vacío']);
                exit();
            }
        }
    }
    ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito</title>
    <link rel="stylesheet" href="css/4-Carrito.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="img/logo delicias de amor blanco y negro.png">
    <style>
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .buttons {
            display: flex;
            justify-content: center;
            gap: 10px; /* Espacio entre botones */
        }

        /* *para deshabilitar el boton*/
        .btn.disabled {
            background-color: #ccc; /* Color de fondo plomo */
            cursor: not-allowed; /* Cambia el cursor a no permitido */
        }
        .btn:hover {
            background-color: #ccc; /* Color de fondo verde más oscuro al pasar el mouse */
        }
    </style>

</head>
<header>
    <nav class="navbar">
      <div class="content">
        <div class="logo"><img src="img/logo delicias de amor blanco y negro.png"></div>
        <ul class="menu-list">
          <div class="icon cancel-btn"><i class="bi bi-x-lg"></i></div>
          <li><a href="index.html">
            <i class="bi bi-house"></i>Principal</a></li>
          <li><a href="2-nosotros.html">
            <i class="bi bi-bookmark"></i>Nosotros</a></li>
          <li><a href="3.2-catalogo.html">
            <i class="bi bi-cake2"></i>Catálogo</a></li>
          <li><a class="uno" href="4-mostrarCarrito.php">
            <i class="bi bi-cart"></i>Mi carrito</a></li>
        </ul>
        <div class="icon menu-btn"><i class="bi bi-list"></i></div>
      </div>
    </nav>
</header>

<body>
    <br>
    <div class="container">
    <h3>Lista del carrito</h3><br>
    <?php if (!empty($_SESSION['CARRITO'])) { ?>
    <table class="table table-light table-bordered">
        <thead>
            <tr>
                <th width="40%">Nombre</th>
                <th width="15%" class="text-center">Cantidad</th>
                <th width="20%" class="text-center">Precio S/.</th>
                <th width="20%" class="text-center">Total S/.</th>
                <th width="5%">--</th>
            </tr>
        </thead>
        <tbody>
            <?php $total = 0; ?>
            <?php foreach ($_SESSION['CARRITO'] as $indice => $producto) { ?>
                <tr>
                    <td><?php echo $producto['NOMBRE']; ?></td>
                    <td class="text-center"><?php echo $producto['CANTIDAD']; ?></td>
                    <td class="text-center"><?php echo $producto['PRECIO']; ?></td>
                    <td class="text-center"><?php echo number_format($producto['CANTIDAD'] * $producto['PRECIO'], 2); ?></td>
                    <td>
                        <form action="4-mostrarCarrito.php" method="post">
                            <input type="hidden" name="eliminar_indice" value="<?php echo $indice; ?>">
                            <button class="btn btn-borrar" type="submit"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                <?php $total += $producto['CANTIDAD'] * $producto['PRECIO']; ?>
            <?php } ?>
        </tbody>
    </table>
    <br>
    <h3>Total: S/.<?php echo number_format($total, 2); ?></h3>
    <br>
    <!-- Botones centrados horizontalmente -->
    <div class="buttons">
        <form action="4-mostrarCarrito.php" method="post" id="borrarTodoForm">
            <input type="hidden" name="action" value="borrar_todo">
            <button class="btn btn-danger" type="submit" id="borrarTodoBtn">Borrar Todo</button>
        </form>

        <button class="btn btn-success" id="guardarPedido">Guardar Pedido</button>
    </div>
    <br>

    <button class="btn btn-warning btn-block" type="submit" onclick="window.location.href='5-Datos.php'" id="siguienteBtn">Siguiente</button>
    <br>
<?php } else { ?>
    <div class="alert alert-success" role="alert">
        No hay productos en el carrito
    </div>
<?php } ?>
    <script src="JS/menu.js"></script>
    <script>
        document.getElementById('guardarPedido').addEventListener('click', function() {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "4-mostrarCarrito.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.status === 'success') {
                        alert(response.message);
                        document.getElementById('guardarPedido').disabled = true;
                        document.getElementById('guardarPedido').classList.add('disabled');
                        document.getElementById('borrarTodoBtn').disabled = true;
                        document.getElementById('borrarTodoBtn').classList.add('disabled');
                        document.getElementById('siguienteBtn').disabled = false;
                    } else {
                        alert(response.message);
                    }
                }
            };
            xhr.send("action=guardar_pedido");
        });
    </script>
    </div>
</body>
</html>