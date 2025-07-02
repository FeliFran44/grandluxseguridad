<?php
// src/views/bitacora.php (La Sala de Control)
require_once 'layout/header.php';
?>

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <h3>Filtrar Actividad</h3>
        <form action="index.php" method="GET" class="filter-form">
            <input type="hidden" name="page" value="bitacora">
            <div class="form-group" style="margin-bottom: 0;">
                <label for="filtro_usuario" class="sr-only">Filtrar por usuario</label>
                <select name="filtro_usuario" id="filtro_usuario" class="form-control" onchange="this.form.submit()">
                    <option value="todos">Ver actividad de Todos</option>
                    <?php foreach ($usuarios_filtrables as $usuario): ?>
                        <option value="<?php echo $usuario['id_usuario']; ?>" <?php echo ($filtro_usuario_actual == $usuario['id_usuario']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($usuario['nombre_completo']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <h3>Registro de Actividad del Sistema</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Fecha y Hora</th>
                <th>Usuario</th>
                <th>Acción Realizada</th>
                <th>Descripción / Detalles</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($bitacora)): ?>
                <tr>
                    <td colspan="4" style="text-align: center; padding: 2rem;">No hay actividad registrada para la selección actual.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($bitacora as $entrada): ?>
                    <tr>
                        <td style="white-space: nowrap;"><?php echo date('d/m/Y H:i:s', strtotime($entrada['fecha_hora'])); ?></td>
                        <td><strong><?php echo htmlspecialchars($entrada['nombre_completo']); ?></strong></td>
                        <td><span class="action-badge"><?php echo htmlspecialchars($entrada['accion']); ?></span></td>
                        <td><?php echo htmlspecialchars($entrada['descripcion']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Estilo simple para las "insignias" de acción -->
<style>
    .action-badge {
        background-color: var(--color-borde);
        color: var(--color-texto-principal);
        padding: 0.25rem 0.6rem;
        border-radius: 0.5rem;
        font-size: 0.8rem;
        font-weight: 500;
    }
</style>

<?php require_once 'layout/footer.php'; ?>
