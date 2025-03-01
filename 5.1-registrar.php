<?php
ob_start();

//inicia la sesion al comienzo del archivo

// Importación del archivo de conexión
include 'con_bd.php';

// Verificación de la conexión
if ($conexion) {
    // echo "Conexión establecida correctamente";
}

// Procesamiento del formulario
if (isset($_POST['register'])) {
    
    // Verificación de campos enviados
    if (strlen($_POST['name']) >= 1 && strlen($_POST['apellido']) >= 1 && strlen($_POST['number']) >= 1) {
        
        // Recolección de datos del formulario
        $name = trim($_POST['name']);
        $apellido = trim($_POST['apellido']);
        $number = trim($_POST['number']);

        // Fecha de registro
        $fechareg = date("Y-m-d"); // Formato de fecha para MySQL
        
        // Consulta para insertar en la tabla datos
        $consulta = "INSERT INTO datos (nombre, apellido, numero, fecha_reg) 
                    VALUES ('$name', '$apellido', '$number', '$fechareg')";
        
        // Ejecución de la consulta
        $resultado = mysqli_query($conexion, $consulta);

        // Verificación de la ejecución de la consulta
        if ($resultado) {
            // Obtener el ID del usuario insertado
            $idUsuario = mysqli_insert_id($conexion);

            // Guardar el ID del usuario en la sesión
            $_SESSION['idUsuario'] = $idUsuario;
            
            $idUsuario = $_SESSION['idUsuario'];

            // Consulta para actualizar la tabla pedidos
            $consulta_actualizar = "UPDATE pedido SET idUsuario = ? WHERE idUsuario IS NULL OR idUsuario = 0";
            $stmt_actualizar = mysqli_prepare($conexion, $consulta_actualizar);
            mysqli_stmt_bind_param($stmt_actualizar, 'i', $idUsuario);
            $resultado_actualizar = mysqli_stmt_execute($stmt_actualizar);

            // Verificación de la ejecución de la consulta para pedidos
            if ($resultado_actualizar) {
                echo '<h3 class="ok">Te has inscrito de manera correcta</h3>';
                echo '<button class="btn btn-warning btn-block" type="button" onclick="window.location.href=\'6-voucher.php\'">Siguiente</button>';
            } else {
                echo '<h3 class="bad">Error al guardar el pedido</h3>';
            }
        } else {
            echo '<h3 class="bad">Error al registrar los datos</h3>';
        }
    } else {
        echo '<h3 class="bad">Completa todos los campos</h3>';
    }
}
ob_end_flush();
?>


