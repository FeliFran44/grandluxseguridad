<?php
// src/views/equipamientos.php (Con Paginación)
require_once 'layout/header.php';
?>

<?php if ($_SESSION['user_role'] === 'administrador' || $_SESSION['user_role'] === 'gerente'): ?>
<div class="card">
    <h3>Registrar Nuevo Equipo</h3>
    <form action="index.php" method="POST">
        <input type="hidden" name="nuevo_equipo" value="1">
        
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
            <label for="tipo_equipo">Tipo de Equipo (Ej: Extintor, Detector de Humo)</label>
            <input type="text" name="tipo_equipo" id="tipo_equipo" required class="form-control">
        </div>
        <div class="form-group">
            <label for="marca">Marca / Modelo</label>
            <input type="text" name="marca" id="marca" class="form-control">
        </div>
        <div class="form-group">
            <label for="ubicacion">Ubicación Exacta</label>
            <input type="text" name="ubicacion" id="ubicacion" required class="form-control">
        </div>
        <div class="form-group">
            <label for="fecha_compra">Fecha de Compra</label>
            <input type="date" name="fecha_compra" id="fecha_compra" class="form-control">
        </div>
        <div class="form-group">
            <label for="fecha_ultimo_mantenimiento">Último Mantenimiento</label>
            <input type="date" name="fecha_ultimo_mantenimiento" id="fecha_ultimo_mantenimiento" class="form-control">
        </div>
        <div class="form-group">
            <label for="fecha_proximo_mantenimiento">Próximo Mantenimiento</label>
            <input type="date" name="fecha_proximo_mantenimiento" id="fecha_proximo_mantenimiento" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">
            <i data-lucide="save"></i>
            <span>Guardar Equipo</span>
        </button>
    </form>
</div>
<?php endif; ?>

<div class="card">
    <h3>Inventario de Equipos</h3>
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <h4>Equipos Registrados</h4>
        <?php if ($_SESSION['user_role'] === 'administrador'): ?>
            <form action="index.php" method="GET">
                <input type="hidden" name="page" value="equipamientos">
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
                    <th>Hotel</th><th>Tipo</th><th>Ubicación</th><th>Próx. Mant.</th><th style="text-align: right;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($equipos)): ?>
                    <tr><td colspan="5" style="text-align: center; padding: 2rem;">No hay equipos registrados.</td></tr>
                <?php else: ?>
                    <?php foreach ($equipos as $equipo): ?>
                        <tr <?php if ($equipo['en_alerta']) echo 'style="background-color: rgba(244, 63, 94, 0.1);"'; ?>>
                            <td><?php echo htmlspecialchars($equipo['nombre_hotel']); ?></td>
                            <td><strong><?php echo htmlspecialchars($equipo['tipo_equipo']); ?></strong><br><small style="color: var(--color-texto-secundario);"><?php echo htmlspecialchars($equipo['marca']); ?></small></td>
                            <td><?php echo htmlspecialchars($equipo['ubicacion']); ?></td>
                            <td><?php echo $equipo['fecha_proximo_mantenimiento'] ? date('d/m/Y', strtotime($equipo['fecha_proximo_mantenimiento'])) : '<span style="color: var(--color-texto-secundario);">N/A</span>'; ?></td>
                            <td style="text-align: right; white-space: nowrap;">
                                <a href="index.php?page=equipo_detalle&id=<?php echo $equipo['id_equipo']; ?>" class="btn btn-info btn-sm">Ver</a>
                                <?php $esAdmin = $_SESSION['user_role'] === 'administrador'; $esGerenteDelHotel = $_SESSION['user_role'] === 'gerente' && $_SESSION['user_hotel_id'] == $equipo['id_hotel']; $puedeEditar = $esAdmin || ($esGerenteDelHotel && $equipo['en_alerta']); ?>
                                <?php if ($puedeEditar): ?>
                                    <a href="index.php?page=equipo_editar&id=<?php echo $equipo['id_equipo']; ?>" class="btn btn-warning btn-sm" style="color:#0f172a;"><?php echo $esAdmin ? 'Editar' : 'Registrar Mant.'; ?></a>
                                <?php endif; ?>
                                <?php if ($esAdmin || $esGerenteDelHotel): ?>
                                    <a href="index.php?action=equipo_eliminar&id=<?php echo $equipo['id_equipo']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro?');">Eliminar</a>
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
            <a href="?page=equipamientos&p=<?php echo max(1, $pagina_actual - 1); ?>&filtro_hotel=<?php echo $filtro_hotel_actual; ?>" class="btn btn-secondary btn-sm <?php if($pagina_actual <= 1){ echo 'disabled'; } ?>">&laquo; Anterior</a>
            <span>Página <?php echo $pagina_actual; ?> de <?php echo $total_paginas; ?></span>
            <a href="?page=equipamientos&p=<?php echo min($total_paginas, $pagina_actual + 1); ?>&filtro_hotel=<?php echo $filtro_hotel_actual; ?>" class="btn btn-secondary btn-sm <?php if($pagina_actual >= $total_paginas){ echo 'disabled'; } ?>">Siguiente &raquo;</a>
        </div>
    <?php endif; ?>
</div>
<?php require_once 'layout/footer.php'; ?>
