<?php
// Configuración de la conexión
$host     = 'db';
$db       = 'prueba_db';
$user     = 'usuario_web';
$password = 'user12345';

// 1. Crear la conexión
$conn = new mysqli($host, $user, $password, $db);

// Verificar conexión
if ($conn->connect_error) {
    die("Falló la conexión: " . $conn->connect_error);
}

// 2. Procesar el formulario SOLO cuando el usuario hace clic en "Guardar"
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['nombre']) && !empty($_POST['email'])) {
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $email  = $conn->real_escape_string($_POST['email']);

    $sql = "INSERT INTO usuarios (nombre, email) VALUES ('$nombre', '$email')";

    if ($conn->query($sql) === TRUE) {
        // Redirigir a la misma página para limpiar el POST y evitar duplicados al refrescar
        header("Location: index.php?success=1");
        exit();
    } else {
        echo "<p style='color:red;'>Error al guardar: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Docker PHP + MySQL</title>
    <style>
        body { font-family: sans-serif; margin: 40px; background-color: #f4f4f4; }
        .container { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); max-width: 600px; margin: auto; }
        input { display: block; margin-bottom: 10px; padding: 8px; width: 95%; }
        button { background: #28a745; color: white; border: none; padding: 10px; width: 100%; cursor: pointer; border-radius: 4px; font-weight: bold; }
        table { width: 100%; margin-top: 20px; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #eee; }
        .alert { color: green; font-weight: bold; margin-bottom: 15px; }
    </style>
</head>
<body>

<div class="container">
    <h1>📝 Registro de Usuarios</h1>
    
    <?php if(isset($_GET['success'])): ?>
        <p class="alert">✅ ¡Registro guardado exitosamente!</p>
    <?php endif; ?>

    <form method="POST">
        <label>Nombre Completo:</label>
        <input type="text" name="nombre" required>
        
        <label>Correo Electrónico:</label>
        <input type="email" name="email" required>
        
        <button type="submit">Guardar en Base de Datos</button>
    </form>

    <hr>

    <h3>📋 Usuarios Registrados</h3>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = $conn->query("SELECT nombre, email FROM usuarios ORDER BY id DESC");
            if ($result && $result->num_rows > 0):
                while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                    </tr>
                <?php endwhile;
            else: ?>
                <tr><td colspan="2">No hay registros en la base de datos.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
<?php $conn->close(); ?>
