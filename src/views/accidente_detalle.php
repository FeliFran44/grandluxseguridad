<?php
// src/views/accidente_detalle.php (Responsive Final)
require_once 'layout/header.php';
?>

<div class="card">
    <h3>Información General</h3>
    <table class="table">
        <tr>
            <td style="width: 25%; font-weight: 600; color: var(--color-texto-secundario);">Hotel:</td>
            <td><?php echo htmlspecialchars($accidente['nombre_hotel']); ?></td>
        </tr>
        <tr>
            <td style="font-weight: 600; color: var(--color-texto-secundario);">Fecha y Hora:</td>
            <td><?php echo date('d/m/Y H:i:s', strtotime($accidente['fecha'])); ?></td>
        </tr>
        <tr>
            <td style="font-weight: 600; color: var(--color-texto-secundario);">Tipo de Evento:</td>
            <td><?php echo htmlspecialchars($accidente['tipo_evento']); ?></td>
        </tr>
        <tr>
            <td style="font-weight: 600; color: var(--color-texto-secundario);">Área:</td>
            <td><?php echo htmlspecialchars($accidente['area']); ?></td>
        </tr>
    </table>
</div>

<div class="card">
    <h3>Descripción y Medidas</h3>
    <h4>Personas Afectadas / Involucradas:</h4>
    <p class="comment-content" style="white-space: pre-wrap;"><?php echo nl2br(htmlspecialchars($accidente['afectados'])); ?></p>
    <hr style="border-color: var(--color-borde); margin: 2rem 0;">
    <h4>Causa Raíz del Evento:</h4>
    <p class="comment-content" style="white-space: pre-wrap;"><?php echo nl2br(htmlspecialchars($accidente['causa'])); ?></p>
    <hr style="border-color: var(--color-borde); margin: 2rem 0;">
    <h4>Medidas Tomadas / Acciones Correctivas:</h4>
    <p class="comment-content" style="white-space: pre-wrap;"><?php echo nl2br(htmlspecialchars($accidente['medidas_tomadas'])); ?></p>
</div>

<div class="card">
    <h3>Documentos Adjuntos</h3>
    <?php if (empty($documentos)): ?>
        <p>No hay documentos adjuntos para este evento.</p>
    <?php else: ?>
        <ul style="list-style: none; padding-left: 0;">
            <?php foreach ($documentos as $doc): ?>
                <li style="margin-bottom: 10px;">
                    <a href="uploads/accidentes/<?php echo htmlspecialchars($doc['ruta_archivo']); ?>" target="_blank" class="btn btn-info btn-sm">
                        <i data-lucide="file-down"></i>
                        <span><?php echo htmlspecialchars($doc['ruta_archivo']); ?></span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>

<div style="margin-top: 2rem;">
    <a href="index.php?page=accidentes" class="btn btn-secondary">&larr; Volver al listado</a>
</div>

<?php
require_once 'layout/footer.php';
?>