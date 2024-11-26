<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Producto</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <nav class="navbar">
        <div class="nav-logo">Marketplace</div>
        <div class="nav-links">
            <a href="index.php">Inicio</a>
            <a href="acceso.php">Acceso</a>
            <a href="contacto.php">Contacto</a>
        </div>
    </nav>

    <main>
        <section class="section">
            <?php
            $link = mysqli_connect("localhost", "root", "", "SistemaVenta");

            if (!$link) {
                die("Conexión fallida: " . mysqli_connect_error());
            }

            $id_producto = $_GET['id_producto'];

            // Obtener los detalles del producto con información del vendedor
            $consulta = "SELECT p.*, u.nombre AS nombre_vendedor, u.correo AS email_vendedor 
                         FROM Producto p
                         JOIN Usuario u ON p.id_usuario = u.id_usuario 
                         WHERE p.id_producto = $id_producto";
            $resultado_producto = mysqli_query($link, $consulta);

            if ($producto = mysqli_fetch_array($resultado_producto)) {
                $nombre = $producto['nombre'];
                $descripcion = $producto['descripcion'];
                $precio = $producto['precio'];
                $estado = $producto['estado'];
                $categoria = $producto['categoria'];
                $imagen = $producto['imagenes'];
                $defectos = $producto['defectos'];
                $fecha_publicacion = $producto['fecha_publicacion'];
                $nombre_vendedor = $producto['nombre_vendedor'];
                $email_vendedor = $producto['email_vendedor'];

                // Verificar si el producto ya ha sido vendido
                $consulta_transaccion = "SELECT * FROM Transaccion WHERE id_producto = $id_producto";
                $resultado_transaccion = mysqli_query($link, $consulta_transaccion);

                echo "<div class='pet-detail-container'>";
                echo "<div class='pet-detail-image'>";
                echo "<img src='img/$imagen' alt='$nombre'>";
                echo "</div>";
                
                echo "<div class='pet-detail-info'>";
                echo "<h1>$nombre</h1>";
                echo "<div class='pet-info-grid'>";
                
                echo "<div class='info-item'>";
                echo "<span class='info-label'>Descripción</span>";
                echo "<span class='info-value'>$descripcion</span>";
                echo "</div>";
                
                echo "<div class='info-item'>";
                echo "<span class='info-label'>Precio</span>";
                echo "<span class='info-value'>$" . number_format($precio, 2) . "</span>";
                echo "</div>";
                
                echo "<div class='info-item'>";
                echo "<span class='info-label'>Estado</span>";
                echo "<span class='info-value'>$estado</span>";
                echo "</div>";
                
                echo "<div class='info-item'>";
                echo "<span class='info-label'>Categoría</span>";
                echo "<span class='info-value'>$categoria</span>";
                echo "</div>";
                
                if ($defectos) {
                    echo "<div class='info-item'>";
                    echo "<span class='info-label'>Defectos</span>";
                    echo "<span class='info-value'>$defectos</span>";
                    echo "</div>";
                }
                
                echo "<div class='info-item'>";
                echo "<span class='info-label'>Fecha de Publicación</span>";
                echo "<span class='info-value'>$fecha_publicacion</span>";
                echo "</div>";
                
                echo "<div class='info-item'>";
                echo "<span class='info-label'>Vendedor</span>";
                echo "<span class='info-value'>$nombre_vendedor</span>";
                echo "</div>";
                
                echo "<div class='adoption-status'>";
                if (mysqli_num_rows($resultado_transaccion) > 0) {
                    // Producto ya vendido
                    echo "<div class='status adopted'>";
                    echo "<span class='status-label'>Estado</span>";
                    echo "<span class='status-value'>Vendido</span>";
                    echo "</div>";
                } else {
                    // Producto disponible
                    echo "<div class='status available'>";
                    echo "<span class='status-label'>Estado</span>";
                    echo "<span class='status-value'>Disponible</span>";
                    echo "</div>";
                    echo "<a href='comprar.php?id_producto=$id_producto' class='btn btn-adopt'>Comprar</a>";
                }
                echo "</div>"; // Cierre de adoption-status
                
                echo "</div>"; // Cierre de pet-info-grid
                echo "</div>"; // Cierre de pet-detail-info
                echo "</div>"; // Cierre de pet-detail-container
            } else {
                echo "<div class='error-message'>";
                echo "<h2>Producto no encontrado</h2>";
                echo "<p>No se encontraron detalles para este producto.</p>";
                echo "<a href='index.php' class='btn'>Volver al inicio</a>";
                echo "</div>";
            }
            mysqli_close($link);
            ?>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Marketplace. Todos los derechos reservados.</p>
    </footer>
</body>
</html>