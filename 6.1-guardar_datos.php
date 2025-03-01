<?php
// Conexión a la base de datos

include "con_bd.php";


 //obtenemos el último registro de la tabla pedido
 $sql_ultimo_pedido = "SELECT * FROM pedido ORDER BY idPedido DESC LIMIT 1";
$result_ultimo_pedido = $conexion->query($sql_ultimo_pedido);

if ($result_ultimo_pedido->num_rows > 0) {
    $ultimo_pedido = $result_ultimo_pedido->fetch_assoc();
    $id_pedido = $ultimo_pedido['IdPedido'];
    $nombre_producto = $ultimo_pedido['nombre'];
    $cantidad = $ultimo_pedido['cantidad'];
    $precio = $ultimo_pedido['precio'];
    $id_cliente = $ultimo_pedido['idUsuario'];

     //obtenemos el último registro de la tabla datos
     $sql_ultimo_cliente = "SELECT * FROM datos WHERE idUsuario = $id_cliente";
    $result_ultimo_cliente = $conexion->query($sql_ultimo_cliente);

    if ($result_ultimo_cliente->num_rows > 0) {
        $ultimo_cliente = $result_ultimo_cliente->fetch_assoc();
        $nombre_cliente = $ultimo_cliente['nombre'];
        $apellido_cliente = $ultimo_cliente['apellido'];
        $telefono_cliente = $ultimo_cliente['numero'];

        // Calculamos el total de la compra
        $total_compra = $precio * $cantidad;

        // Insertamos los datos en la tabla detalle_pedido
        $sql_insert = "INSERT INTO detalle_pedido (idPedido, nombreProducto, Cantidad, Precio, idUsuario, Nombre_Usuario, Apellido_Usuario, Telefono, Total_compra) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql_insert);
        $stmt->bind_param("isidisssd", $id_pedido, $nombre_producto, $cantidad, $precio, $id_cliente, $nombre_cliente, $apellido_cliente, $telefono_cliente, $total_compra);
        
        if ($stmt->execute()) {
            echo "Datos guardados correctamente.";
        } else {
            echo "Error al guardar los datos: " . $conexion->error;
        }

        $stmt->close();
    } else {
        echo "No se encontraron datos del cliente.";
    }
} else {
    echo "No se encontraron registros en la tabla pedidos.";
}

//$conexion->close();
?>
