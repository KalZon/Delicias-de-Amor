<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Registrar usuarios</title>
    <link rel="stylesheet" href="css/5-Datos.css"/>
    <link rel="stylesheet" href="css/hf.css">
     <link rel="icon" href="img/logo delicias de amor blanco y negro.png">
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
          <li><a href="4-mostrarCarrito.php">
            <i class="bi bi-cart"></i>Mi carrito</a></li>
        </ul>
        <div class="icon menu-btn"><i class="bi bi-list"></i></div>
      </div>
    </nav>
</header>
<div class="about"></div>
  <body>
    <script src="JS/menu.js"></script>
    <form  method="POST">
    <h1>Registrar Datos</h1>
    <!-- //creamos input para el formulario donde se almacenaran los datos del usuario -->
    <input type="text" name="name" placeholder="Nombre">
    <input type="text" name="apellido" placeholder="Apellido">
    <input type="number" name="number" placeholder="Número telefónico">

    <input type="submit" name="register"> 
    </form>
  </body>
<?php
include("5.1-registrar.php");
?>
<br><br><br><br>
</html>

