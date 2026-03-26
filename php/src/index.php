<?php
// Configuración de la conexión
$host     = 'db';
$db       = 'prueba_db';
$user     = 'usuario_web';
$password = 'user12345';

$conn = new mysqli($host, $user, $password, $db);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['nombre']) && !empty($_POST['email'])) {
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $email  = $conn->real_escape_string($_POST['email']);
    $sql = "INSERT INTO usuarios (nombre, email) VALUES ('$nombre', '$email')";
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php?success=1");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Docker PHP Pro | Jorge Alejandro</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --bg: #f8fafc;
            --card: #ffffff;
            --text: #1e293b;
        }

        body { 
            font-family: 'Inter', sans-serif; 
            background-color: var(--bg); 
            color: var(--text);
            margin: 0;
            display: flex;
            justify-content: center;
            padding: 40px 20px;
        }

        .main-card { 
            background: var(--card); 
            padding: 32px; 
            border-radius: 16px; 
            box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1); 
            max-width: 500px; 
            width: 100%; 
        }

        h1 { font-weight: 600; font-size: 1.5rem; margin-bottom: 24px; text-align: center; color: var(--primary); }
        
        .form-group { margin-bottom: 16px; }
        label { display: block; font-size: 0.875rem; font-weight: 500; margin-bottom: 6px; }
        
        input { 
            width: 100%; 
            padding: 10px; 
            border: 1px solid #e2e8f0; 
            border-radius: 8px; 
            box-sizing: border-box;
            transition: border-color 0.2s;
        }

        input:focus { outline: none; border-color: var(--primary); ring: 2px var(--primary); }

        button { 
            background: var(--primary); 
            color: white; 
            border: none; 
            padding: 12px; 
            width: 100%; 
            cursor: pointer; 
            border-radius: 8px; 
            font-weight: 600; 
            transition: background 0.2s;
            margin-top: 8px;
        }

        button:hover { background: var(--primary-hover); }

        .alert { 
            background: #f0fdf4; 
            color: #166534; 
            padding: 12px; 
            border-radius: 8px; 
            font-size: 0.875rem; 
            margin-bottom: 20px; 
            text-align: center;
            border: 1px solid #bbf7d0;
        }

        table { width: 100%; margin-top: 30px; border-collapse: separate; border-spacing: 0; }
        th { text-align: left; font-size: 0.75rem; text-transform: uppercase; color: #64748b; padding: 12px 8px; border-bottom: 2px solid #f1f5f9; }
        td { padding: 12px 8px; border-bottom: 1px solid #f1f5f9; font-size: 0.935rem; }
        tr:last-child td { border-bottom: none; }
        
        .badge { background: #e0e7ff; color: #4338ca; padding: 2px 8px; border-radius: 12px; font-size: 0.75rem; font-weight: 600; }
    </style>
</head>
<body>

<div class="main-card">
    <h1>🚀 Sistema de Registro <span style="font-weight:300">Docker</span></h1>
    
    <?php if(isset($_GET['success'])): ?>
        <div class="alert">✨ ¡Usuario guardado correctamente!</div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label>Nombre Completo</label>
            <input type="text" name="nombre" placeholder="Ej. Jorge Alejandro" required>
        </div>
        
        <div class="form-group">
            <label>Email Institucional</label>
            <input type="email" name="email" placeholder="alx@ejemplo.com" required>
        </div>
        
        <button type="submit">Guardar Registro</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>Usuario</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = $conn->query("SELECT nombre, email FROM usuarios ORDER BY id DESC");
            if ($result && $result->num_rows > 0):
                while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td>
                            <strong><?php echo htmlspecialchars($row['nombre']); ?></strong><br>
                            <span style="font-size: 0.75rem; color: #94a3b8;"><?php echo htmlspecialchars($row['email']); ?></span>
                        </td>
                        <td><span class="badge">Activo</span></td>
                    </tr>
                <?php endwhile;
            else: ?>
                <tr><td colspan="2" style="text-align:center; color:#94a3b8;">Sin registros</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
<?php $conn->close(); ?>
