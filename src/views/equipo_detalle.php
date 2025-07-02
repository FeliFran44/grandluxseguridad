<?php
// src/views/equipo_detalle.php (Con Historial de Mantenimiento)
require_once 'layout/header.php';
?>

<div class="card">
    <h3><?php echo htmlspecialchars($equipo['tipo_equipo']); ?> <span style="color: var(--color-texto-secundario); font-weight: 500;">- <?php echo htmlspecialchars($equipo['marca']); ?></span></h3>
    <table class="table">
        <tr><td style="width: 25%; font-weight: 600; color: var(--color-texto-secundario);">Hotel:</td><td><?php echo htmlspecialchars($equipo['nombre_hotel']); ?></td></tr>
        <tr><td style="font-weight: 600; color: var(--color-texto-secundario);">Ubicación Exacta:</td><td><?php echo htmlspecialchars($equipo['ubicacion']); ?></td></tr>
        <tr><td style="font-weight: 600; color: var(--color-texto-secundario);">Fecha de Compra:</td><td><?php echo $equipo['fecha_compra'] ? date('d/m/Y', strtotime($equipo['fecha_compra'])) : 'No registrada'; ?></td></tr>
        <tr><td style="font-weight: 600; color: var(--color-texto-secundario);">Último Mantenimiento:</td><td><?php echo $equipo['fecha_ultimo_mantenimiento'] ? date('d/m/Y', strtotime($equipo['fecha_ultimo_mantenimiento'])) : 'No registrada'; ?></td></tr>
        <tr><td style="font-weight: 600; color: var(--color-texto-secundario);">Próximo Mantenimiento:</td><td><?php echo $equipo['fecha_proximo_mantenimiento'] ? date('d/m/Y', strtotime($equipo['fecha_proximo_mantenimiento'])) : 'No registrada'; ?></td></tr>
    </table>
</div>

<div class="card">
    <h3>Historial de Mantenimientos Realizados</h3>
    <?php if (empty($historial)): ?>
        <p>No hay registros de mantenimiento para este equipo.</p>
    <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Fecha Realizado</th>
                    <th>Descripción</th>
                    <th>Registrado por</th>
                    <th>Prueba</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($historial as $item): ?>
                <tr>
                    <td><?php echo date('d/m/Y', strtotime($item['fecha_mantenimiento'])); ?></td>
                    <td><?php echo htmlspecialchars($item['descripcion']); ?></td>
                    <td><?php echo htmlspecialchars($item['nombre_completo']); ?></td>
                    <td>
                        <a href="uploads/mantenimientos/<?php echo htmlspecialchars($item['ruta_archivo_prueba']); ?>" target="_blank" class="btn btn-info btn-sm">
                            Ver Foto
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<div style="margin-top: 2rem;">
    <a href="index.php?page=equipamientos" class="btn btn-secondary">&larr; Volver al listado</a>
</div>


<?php
require_once 'layout/footer.php';
?>
