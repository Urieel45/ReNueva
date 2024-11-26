<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace de Productos</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <nav class="navbar">
        <div class="nav-logo">Marketplace</div>
        <div class="nav-links">
            <a href="index.php" class="active">Inicio</a>
            <a href="acceso.php">Acceso</a>
            <a href="contacto.php">Contacto</a>
        </div>
    </nav>

    <main>
        <section class="section">
            <h1>Productos Disponibles</h1>
            <div class="pets-grid">
                <?php
                // Conexión a la base de datos
                $link = mysqli_connect("localhost", "root", "", "SistemaVenta");
                
                if (!$link) {
                    die("Conexión fallida: " . mysqli_connect_error());
                }
                
                // Consulta para obtener todos los productos
                $consulta = "SELECT p.*, u.nombre AS nombre_vendedor 
                             FROM Producto p
                             JOIN Usuario u ON p.id_usuario = u.id_usuario";
                $resultado = mysqli_query($link, $consulta);
                
                // Ciclo para mostrar cada producto en una card
                while ($producto = mysqli_fetch_array($resultado)) {
                    $id = $producto['id_producto'];
                    $nombre = $producto['nombre'];
                    $descripcion = $producto['descripcion'];
                    $precio = $producto['precio'];
                    $estado = $producto['estado'];
                    $categoria = $producto['categoria'];
                    $imagen = $producto['imagenes'];
                    $vendedor = $producto['nombre_vendedor'];
                
                    // Mostrar card con detalles del producto
                    echo "
                    <div class='pet-card'>
                        <a href='producto.php?id_producto=$id' class='pet-link'>
                            <img src='img/$imagen' alt='$nombre' class='pet-image'>
                            <div class='pet-info'>
                                <h3>$nombre</h3>
                                <p class='pet-details'>Precio: \$" . number_format($precio, 2) . "</p>
                                <button class='btn'>Ver más detalles</button>
                            </div>
                        </a>
                    </div>";
                }
                
                // Cerrar conexión
                mysqli_close($link);
                ?>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Marketplace. Todos los derechos reservados.</p>
    </footer>
</body>
</html>