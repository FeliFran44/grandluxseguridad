<?php
// src/views/capacitaciones.php (Con Paginación)
require_once 'layout/header.php';
?>

<?php if ($_SESSION['user_role'] === 'administrador' || $_SESSION['user_role'] === 'gerente'): ?>
<div class="card">
    <h3>Registrar Nueva Capacitación</h3>
    <form action="index.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="nueva_capacitacion" value="1">
        
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
            <label for="tema">Tema de la Capacitación</label>
            <input type="text" name="tema" id="tema" required class="form-control">
        </div>

        <div class="form-group">
            <label for="instructor">Capacitación a cargo de</label>
            <input type="text" name="instructor" id="instructor" required class="form-control" placeholder="Ej: Nombre Apellido, Empresa Externa">
        </div>

        <div class="form-group">
            <label for="fecha">Fecha de Realización</label>
            <input type="date" name="fecha" id="fecha" required class="form-control">
        </div>
        <div class="form-group">
            <label for="participantes">Participantes (separados por coma)</label>
            <textarea name="participantes" id="participantes" rows="3" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label for="documentos">Materiales Adjuntos (puede seleccionar varios)</label>
            <input type="file" name="documentos[]" id="documentos" multiple class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">
            <i data-lucide="save"></i>
            <span>Guardar Capacitación</span>
        </button>
    </form>
</div>
<?php endif; ?>

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <h3>Historial de Capacitaciones</h3>
        <?php if ($_SESSION['user_role'] === 'administrador'): ?>
            <form action="index.php" method="GET" class="filter-form">
                <input type="hidden" name="page" value="capacitaciones">
                <div class="form-group" style="margin-bottom: 0;">
                    <select name="filtro_hotel" id="filtro_hotel" class="form-control" onchange="this.form.submit()">
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
                    <th>Tema</th>
                    <th>A Cargo de</th>
                    <th style="text-align: right;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($capacitaciones)): ?>
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 2rem;">No hay capacitaciones registradas para la selección actual.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($capacitaciones as $capacitacion): ?>
                        <tr>
                            <td><?php echo date('d/m/Y', strtotime($capacitacion['fecha'])); ?></td>
                            <td><?php echo htmlspecialchars($capacitacion['nombre_hotel']); ?></td>
                            <td><?php echo htmlspecialchars($capacitacion['tema']); ?></td>
                            <td><?php echo htmlspecialchars($capacitacion['instructor']); ?></td>
                            <td style="text-align: right; white-space: nowrap;">
                                <a href="index.php?page=capacitacion_detalle&id=<?php echo $capacitacion['id_capacitacion']; ?>" class="btn btn-info btn-sm">Ver (<?php echo $capacitacion['num_docs']; ?>)</a>
                                <?php if ($_SESSION['user_role'] === 'administrador' || ($_SESSION['user_role'] === 'gerente' && $_SESSION['user_hotel_id'] == $capacitacion['id_hotel'])): ?>
                                    <a href="index.php?page=capacitacion_editar&id=<?php echo $capacitacion['id_capacitacion']; ?>" class="btn btn-warning btn-sm" style="color:#0f172a;">Editar</a>
                                    <a href="index.php?action=capacitacion_eliminar&id=<?php echo $capacitacion['id_capacitacion']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de que desea eliminar esta capacitación y todos sus documentos?');">Eliminar</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- INICIO: Controles de Paginación -->
    <?php if (isset($total_paginas) && $total_paginas > 1): ?>
        <div class="pagination-container">
            <a href="?page=capacitaciones&p=<?php echo max(1, $pagina_actual - 1); ?>&filtro_hotel=<?php echo $filtro_hotel_actual; ?>" class="btn btn-secondary btn-sm <?php if($pagina_actual <= 1){ echo 'disabled'; } ?>">&laquo; Anterior</a>
            
            <span>Página <?php echo $pagina_actual; ?> de <?php echo $total_paginas; ?></span>
            
            <a href="?page=capacitaciones&p=<?php echo min($total_paginas, $pagina_actual + 1); ?>&filtro_hotel=<?php echo $filtro_hotel_actual; ?>" class="btn btn-secondary btn-sm <?php if($pagina_actual >= $total_paginas){ echo 'disabled'; } ?>">Siguiente &raquo;</a>
        </div>
    <?php endif; ?>
    <!-- FIN: Controles de Paginación -->

</div>

<style>
.pagination-container { display: flex; justify-content: space-between; align-items: center; padding-top: 1.5rem; margin-top: 1.5rem; border-top: 1px solid var(--color-borde); }
.pagination-container .btn.disabled { pointer-events: none; opacity: 0.5; }
</style>

<?php
require_once 'layout/footer.php';
?>
