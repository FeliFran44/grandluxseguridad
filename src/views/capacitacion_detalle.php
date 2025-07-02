<?php
// src/views/capacitacion_detalle.php (Responsive Final)
require_once 'layout/header.php';
?>

<div class="card">
    <h3><?php echo htmlspecialchars($capacitacion['tema']); ?></h3>
    <table class="table">
        <tr>
            <td style="width: 25%; font-weight: 600; color: var(--color-texto-secundario);">Hotel:</td>
            <td><?php echo htmlspecialchars($capacitacion['nombre_hotel']); ?></td>
        </tr>
        <tr>
            <td style="font-weight: 600; color: var(--color-texto-secundario);">Fecha:</td>
            <td><?php echo date('d/m/Y', strtotime($capacitacion['fecha'])); ?></td>
        </tr>
        <tr>
            <td style="font-weight: 600; color: var(--color-texto-secundario);">A Cargo de:</td>
            <td><?php echo htmlspecialchars($capacitacion['instructor']); ?></td>
        </tr>
    </table>
</div>

<div class="card">
    <h3>Listado de Participantes</h3>
    <p class="comment-content" style="white-space: pre-wrap;"><?php echo nl2br(htmlspecialchars($capacitacion['participantes'])); ?></p>
</div>

<div class="card">
    <h3>Materiales Adjuntos</h3>
    <?php if (empty($documentos)): ?>
        <p>No hay documentos adjuntos para esta capacitación.</p>
    <?php else: ?>
        <ul style="list-style: none; padding-left: 0;">
            <?php foreach ($documentos as $doc): ?>
                <li style="margin-bottom: 10px;">
                    <a href="uploads/capacitaciones/<?php echo htmlspecialchars($doc['ruta_archivo']); ?>" target="_blank" class="btn btn-info btn-sm">
                        <i data-lucide="file-down"></i>
                        <span><?php echo htmlspecialchars($doc['ruta_archivo']); ?></span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>

<div style="margin-top: 2rem;">
    <a href="index.php?page=capacitaciones" class="btn btn-secondary">&larr; Volver al listado</a>
</div>

<?php
require_once 'layout/footer.php';
?>
