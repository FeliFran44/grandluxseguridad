<?php
// src/views/login.php (Refactorizado V4)

if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$error_message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login_form'])) {
    $pdo = Database::getInstance();
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = ?");
    $stmt->execute([$_POST['usuario']]);
    $user = $stmt->fetch();

    if ($user && password_verify($_POST['password'], $user['password'])) {
        $_SESSION['user_id'] = $user['id_usuario'];
        $_SESSION['user_name'] = $user['nombre_completo'];
        $_SESSION['user_role'] = $user['rol'];
        $_SESSION['user_hotel_id'] = $user['id_hotel'];
        header("Location: index.php");
        exit;
    } else {
        $error_message = "Usuario o contraseña incorrectos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema Grand LUX</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        body.login-page {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            width: 100%;
            max-width: 400px;
            text-align: center;
            animation: fadeIn 0.5s ease-out;
        }
        .login-container h1 {
            color: var(--color-texto-principal);
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }
        .login-container .subtitulo {
            margin-bottom: 2rem;
            color: var(--color-texto-secundario);
        }
        .error {
            color: #f87171;
            background-color: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            padding: 1rem;
            border-radius: var(--radio-borde);
            margin-bottom: 1.5rem;
        }
    </style>
</head>
<body class="login-page">
    <div class="login-container">
        
        <h1>Grand LUX</h1>
        <p class="subtitulo">Panel de Seguridad y Salud</p>
        
        <div class="card">
            <?php if ($error_message): ?>
                <p class="error"><?php echo $error_message; ?></p>
            <?php endif; ?>

            <form action="index.php" method="POST">
                <input type="hidden" name="login_form" value="1">
                <div class="form-group" style="text-align: left;">
                    <label for="usuario">Usuario</label>
                    <input type="text" id="usuario" name="usuario" class="form-control" required>
                </div>
                <div class="form-group" style="text-align: left;">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%;">Ingresar</button>
            </form>
        </div>

    </div>
</body>
</html>
