
<?php
// Conexión a la base de datos
include "con_bd.php";
include "6.1-guardar_datos.php";


$sql_cliente = "SELECT nombre, apellido, numero FROM datos WHERE idUsuario = $id_cliente";
$result_cliente = $conexion->query($sql_cliente);

if ($result_cliente->num_rows > 0) {
    $cliente = $result_cliente->fetch_assoc();
} else {
    echo "No se encontraron datos del cliente.";
    exit();
}

$sql_pedidos = "SELECT nombre, cantidad, precio FROM pedido WHERE idUsuario =$id_cliente";
$result_pedidos = $conexion->query($sql_pedidos);

if ($result_pedidos->num_rows > 0) {
    $pedidos = $result_pedidos->fetch_all(MYSQLI_ASSOC);
} else {
    echo "No se encontraron pedidos para este cliente.";
    exit();
}

$conexion->close();
?>

<!DOCTYPE html>
<link rel="stylesheet" href="css/hf.css">
<header>
    
    <nav class="navbar">
      <div class="content">
        <div class="logo"><img src="img/logo delicias de amor blanco y negro.png"></div>
        <ul class="menu-list">
          <div class="icon cancel-btn"><i class="bi bi-x-lg"></i></div>
          <li><a href="index.html">
            <i class="bi bi-house"></i>Principal</a></li>
          <li><a class="uno" href="2-nosotros.html">
            <i class="bi bi-bookmark"></i>Nosotros</a></li>
          <li><a href="3.2-catalogo.html">
            <i class="bi bi-cake2"></i>Catálogo</a></li>
          <li><a href="mostrarCarrito.php">
            <i class="bi bi-cart"></i>Mi carrito</a></li>
        </ul>
        <div class="icon menu-btn"><i class="bi bi-list"></i></div>
      </div>
    </nav>
  </header>
  <div class="about"></div>
<html>
<head>
    <link rel="icon" href="img/logo delicias de amor blanco y negro.png">
    
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>

    <title>Boucher</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .voucher {
            border: 1px solid #000;
            padding: 20px;
            width: 300px;
            margin: 0 auto;
        }
        .voucher h1 {
            text-align: center;
        }
        .voucher .cliente, .voucher .productos {
            margin-bottom: 20px;
        }
        .voucher table {
            width: 100%;
            border-collapse: collapse;
        }
        .voucher table, .voucher th, .voucher td {
            border: 1px solid #000;
        }
        .voucher th, .voucher td {
            padding: 5px;
            text-align: left;
        }
        
        .pay-button {
            background-color: yellow;
            color: black;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            cursor: pointer;
            margin-top: 20px;
            width: 100%;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
            padding-top: 60px;
        }
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
            text-align: center;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        .qr-code img {
            width: 350px; /* Ajusta el tamaño según sea necesario */
    </style>
</head>

<body style="background: #fdead8;">
    
    <div class="voucher" style="background:#FFF">
        <h1>Voucher de Compra</h1>
        <div class="cliente">
            <h2>Datos del Cliente</h2>
            <p><strong>Nombre:</strong> <?php echo $cliente['nombre']; ?></p>
            <p><strong>Apellido:</strong> <?php echo $cliente['apellido']; ?></p>
            <p><strong>Teléfono:</strong> <?php echo $cliente['numero']; ?></p>
        </div>
        <div class="productos">
            <h2>Detalles del Pedido</h2>
            <table>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                </tr>
                <?php foreach ($pedidos as $pedido): ?>
                <tr>
                    <td><?php echo $pedido['nombre']; ?></td>
                    <td><?php echo $pedido['cantidad']; ?></td>
                    <td><?php echo $pedido['precio']; ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <button class="pay-button" id="payBtn">Pagar</button>
    </div>
    
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div class="qr-code">
                <h2>Puedes pagar con yape</h2>
                <br>
                <img src="img/yape.jpg" alt="QR Yape">
            </div>
        </div>
    </div>
    
     <script src="JS/modal.js"></script>
</body>


</html>