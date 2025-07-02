<?php
// src/views/capacitacion_editar.php (Responsive Final)
require_once 'layout/header.php';
?>

<div class="card">
    <h3>Datos de la Capacitación</h3>
    <form action="index.php" method="POST">
        <input type="hidden" name="editar_capacitacion" value="1">
        <input type="hidden" name="id_capacitacion" value="<?php echo $capacitacion['id_capacitacion']; ?>">
        
        <?php if ($_SESSION['user_role'] === 'administrador'): ?>
        <div class="form-group">
            <label for="id_hotel">Hotel</label>
            <select name="id_hotel" id="id_hotel" required class="form-control">
                <?php foreach ($hoteles as $hotel): ?>
                    <option value="<?php echo $hotel['id_hotel']; ?>" <?php echo ($hotel['id_hotel'] == $capacitacion['id_hotel']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($hotel['nombre']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <?php endif; ?>

        <div class="form-group">
            <label for="tema">Tema de la Capacitación</label>
            <input type="text" name="tema" id="tema" required value="<?php echo htmlspecialchars($capacitacion['tema']); ?>" class="form-control">
        </div>
        <div class="form-group">
            <label for="instructor">Capacitación a cargo de</label>
            <input type="text" name="instructor" id="instructor" required class="form-control" value="<?php echo htmlspecialchars($capacitacion['instructor']); ?>">
        </div>
        <div class="form-group">
            <label for="fecha">Fecha de Realización</label>
            <input type="date" name="fecha" id="fecha" required value="<?php echo htmlspecialchars($capacitacion['fecha']); ?>" class="form-control">
        </div>
        <div class="form-group">
            <label for="participantes">Participantes</label>
            <textarea name="participantes" id="participantes" rows="3" class="form-control"><?php echo htmlspecialchars($capacitacion['participantes']); ?></textarea>
        </div>
        
        <button type="submit" class="btn btn-success"><i data-lucide="check-circle"></i><span>Guardar Cambios</span></button>
        <a href="index.php?page=capacitaciones" class="btn btn-secondary" style="margin-left: 10px;"><span>Cancelar</span></a>
    </form>
</div>
    
<div class="card">
    <h3>Gestionar Documentos Adjuntos</h3>
    <?php if (empty($documentos)): ?>
        <p>No hay documentos adjuntos para esta capacitación.</p>
    <?php else: ?>
        <table class="table">
            <?php foreach ($documentos as $doc): ?>
                <tr>
                    <td>
                        <a href="uploads/capacitaciones/<?php echo htmlspecialchars($doc['ruta_archivo']); ?>" target="_blank">
                           <i data-lucide="file-text" style="vertical-align: middle; margin-right: 8px;"></i><?php echo htmlspecialchars($doc['ruta_archivo']); ?>
                        </a>
                    </td>
                    <td style="text-align: right;">
                        <a href="index.php?action=documento_capacitacion_eliminar&id_doc=<?php echo $doc['id_documento']; ?>&id_capacitacion=<?php echo $capacitacion['id_capacitacion']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de que desea eliminar este documento?');">
                           <i data-lucide="trash-2"></i> <span>Eliminar</span>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    
    <h4 style="margin-top: 2rem;">Añadir Nuevos Documentos</h4>
    <form action="index.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="agregar_documentos_capacitacion" value="1">
        <input type="hidden" name="id_capacitacion" value="<?php echo $capacitacion['id_capacitacion']; ?>">
        <div class="form-group">
            <input type="file" name="documentos[]" multiple required class="form-control">
        </div>
        <button type="submit" class="btn btn-primary"><i data-lucide="upload"></i><span>Subir Archivos</span></button>
    </form>
</div>

<?php
require_once 'layout/footer.php';
?>
