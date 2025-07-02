<?php
// generar_hash.php

$password_original = '';
$hash_generado = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['password_a_hashear'])) {
    $password_original = $_POST['password_a_hashear'];
    
    // Usamos el algoritmo por defecto de PHP, que es el más seguro y se actualiza con el tiempo.
    $hash_generado = password_hash($password_original, PASSWORD_DEFAULT);
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Generador de Hash de Contraseñas</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 40px auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; }
        h1 { text-align: center; }
        form { display: flex; gap: 10px; margin-bottom: 20px; }
        input[type="text"] { flex-grow: 1; padding: 10px; border: 1px solid #ccc; }
        button { padding: 10px 15px; background-color: #007bff; color: white; border: none; cursor: pointer; }
        .resultado { background-color: #f0f0f0; padding: 15px; border-left: 4px solid #007bff; word-wrap: break-word; }
        .importante { background-color: #fffbe6; border-left-color: #ffc107; padding: 15px; margin-top: 20px; }
    </style>
</head>
<body>

    <h1>Generador de Hash para Contraseñas</h1>

    <form action="generar_hash.php" method="POST">
        <input type="text" name="password_a_hashear" placeholder="Escriba la contraseña aquí" required>
        <button type="submit">Generar Hash</button>
    </form>

    <?php if ($hash_generado): ?>
        <div class="resultado">
            <p><strong>Contraseña Original:</strong> <?php echo htmlspecialchars($password_original); ?></p>
            <p><strong>Hash Generado (copiar esto):</strong></p>
            <pre><code><?php echo htmlspecialchars($hash_generado); ?></code></pre>
        </div>
    <?php endif; ?>

    <div class="importante">
        <strong>Instrucciones:</strong><br>
        1. Escriba la nueva contraseña y genere el hash.<br>
        2. Copie la cadena completa del hash generado (empieza con $2y$).<br>
        3. Vaya a phpMyAdmin, a la tabla `usuarios`, y edite el usuario deseado.<br>
        4. Pegue el nuevo hash en el campo `password` y guarde los cambios.<br>
        5. Una vez solucionado, elimine este archivo (`generar_hash.php`) del servidor.
    </div>

</body>
</html>