<?php
// src/views/accidentes.php (Paginación Final y Limpia)
require_once 'layout/header.php';
?>

<?php if ($_SESSION['user_role'] === 'administrador' || $_SESSION['user_role'] === 'gerente'): ?>
<div class="card">
    <h3>Registrar Nuevo Evento</h3>
    <form action="index.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="nuevo_accidente" value="1">
        <div class="form-group">
            <label for="tipo_evento">Tipo de Evento (ej: Accidente, Incidente)</label>
            <input type="text" name="tipo_evento" id="tipo_evento" required class="form-control">
        </div>
        <?php if ($_SESSION['user_role'] === 'administrador'): ?>
        <div class="form-group">
            <label for="id_hotel">Hotel</label>
            <select name="id_hotel" id="id_hotel" required class="form-control">
                <?php foreach ($hoteles as $hotel): ?>
                    <option value="<?php echo $hotel['id_hotel']; ?>"><?php echo htmlspecialchars($hotel['nombre']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <?php endif; ?>
        <div class="form-group">
            <label for="fecha">Fecha y Hora del Evento</label>
            <input type="datetime-local" name="fecha" id="fecha" required class="form-control">
        </div>
        <div class="form-group">
            <label for="area">Área / Ubicación del Evento</label>
            <input type="text" name="area" id="area" required class="form-control">
        </div>
        <div class="form-group">
            <label for="afectados">Personas Afectadas / Involucradas</label>
            <textarea name="afectados" id="afectados" rows="3" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label for="causa">Causa Raíz del Evento</label>
            <textarea name="causa" id="causa" rows="4" class="form-control"></textarea>
        </div>
         <div class="form-group">
            <label for="medidas_tomadas">Medidas Tomadas / Acciones Correctivas</label>
            <textarea name="medidas_tomadas" id="medidas_tomadas" rows="4" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label for="documentos">Documentos o Imágenes Asociadas (puede seleccionar varios)</label>
            <input type="file" name="documentos[]" id="documentos" multiple class="form-control">
        </div>
        <button type="submit" class="btn btn-danger"><i data-lucide="save"></i><span>Registrar Evento</span></button>
    </form>
</div>
<?php endif; ?>

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <h3>Historial de Eventos</h3>
        <?php if ($_SESSION['user_role'] === 'administrador'): ?>
            <form action="index.php" method="GET">
                <input type="hidden" name="page" value="accidentes">
                <div class="form-group" style="margin-bottom: 0;">
                    <select name="filtro_hotel" class="form-control" onchange="this.form.submit()">
                        <option value="todos">Ver Todos los Hoteles</option>
                        <?php foreach ($hoteles as $hotel): ?>
                            <option value="<?php echo $hotel['id_hotel']; ?>" <?php echo (isset($filtro_hotel_actual) && $filtro_hotel_actual == $hotel['id_hotel']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($hotel['nombre']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </form>
        <?php endif; ?>
    </div>
    
    <hr style="margin-top: 1.5rem; border-color: var(--color-borde);">

    <div style="overflow-x: auto;">
        <table class="table">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Hotel</th>
                    <th>Tipo</th>
                    <th>Área</th>
                    <th style="text-align: right;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($accidentes)): ?>
                    <tr><td colspan="5" style="text-align: center; padding: 2rem;">No hay eventos registrados para la selección actual.</td></tr>
                <?php else: ?>
                    <?php foreach ($accidentes as $accidente): ?>
                        <tr>
                            <td><?php echo date('d/m/Y H:i', strtotime($accidente['fecha'])); ?></td>
                            <td><?php echo htmlspecialchars($accidente['nombre_hotel']); ?></td>
                            <td><?php echo htmlspecialchars($accidente['tipo_evento']); ?></td>
                            <td><?php echo htmlspecialchars($accidente['area']); ?></td>
                            <td style="text-align: right; white-space: nowrap;">
                                <a href="index.php?page=accidente_detalle&id=<?php echo $accidente['id_accidente']; ?>" class="btn btn-info btn-sm">Ver (<?php echo $accidente['num_docs']; ?>)</a>
                                <?php if ($_SESSION['user_role'] === 'administrador' || ($_SESSION['user_role'] === 'gerente' && $_SESSION['user_hotel_id'] == $accidente['id_hotel'])): ?>
                                    <a href="index.php?page=accidente_editar&id=<?php echo $accidente['id_accidente']; ?>" class="btn btn-warning btn-sm" style="color:#0f172a">Editar</a>
                                    <a href="index.php?action=accidente_eliminar&id=<?php echo $accidente['id_accidente']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de que desea eliminar este evento y todos sus documentos?');">Eliminar</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if (isset($total_paginas) && $total_paginas > 1): ?>
        <div class="pagination-container">
            <a href="?page=accidentes&p=<?php echo max(1, $pagina_actual - 1); ?>&filtro_hotel=<?php echo $filtro_hotel_actual; ?>" class="btn btn-secondary btn-sm <?php if($pagina_actual <= 1){ echo 'disabled'; } ?>">&laquo; Anterior</a>
            <span>Página <?php echo $pagina_actual; ?> de <?php echo $total_paginas; ?></span>
            <a href="?page=accidentes&p=<?php echo min($total_paginas, $pagina_actual + 1); ?>&filtro_hotel=<?php echo $filtro_hotel_actual; ?>" class="btn btn-secondary btn-sm <?php if($pagina_actual >= $total_paginas){ echo 'disabled'; } ?>">Siguiente &raquo;</a>
        </div>
    <?php endif; ?>
</div>

<?php require_once 'layout/footer.php'; ?>
