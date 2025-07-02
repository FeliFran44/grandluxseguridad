<?php
// src/views/accidente_editar.php (Refactorizado V4)
require_once 'layout/header.php';
?>

<h1>Editar Evento #<?php echo htmlspecialchars($accidente['id_accidente']); ?></h1>

<div class="card">
    <h3>Datos del Evento</h3>
    <form action="index.php" method="POST">
        <input type="hidden" name="editar_accidente" value="1">
        <input type="hidden" name="id_accidente" value="<?php echo $accidente['id_accidente']; ?>">
        
        <div class="form-group">
            <label for="tipo_evento">Tipo de Evento</label>
            <input type="text" name="tipo_evento" id="tipo_evento" required value="<?php echo htmlspecialchars($accidente['tipo_evento']); ?>" class="form-control">
        </div>
        <?php if ($_SESSION['user_role'] === 'administrador'): ?>
        <div class="form-group">
            <label for="id_hotel">Hotel</label>
            <select name="id_hotel" id="id_hotel" required class="form-control">
                <?php foreach ($hoteles as $hotel): ?>
                    <option value="<?php echo $hotel['id_hotel']; ?>" <?php echo ($hotel['id_hotel'] == $accidente['id_hotel']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($hotel['nombre']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <?php endif; ?>
        <div class="form-group">
            <label for="fecha">Fecha y Hora del Evento</label>
            <input type="datetime-local" name="fecha" id="fecha" required value="<?php echo date('Y-m-d\TH:i', strtotime($accidente['fecha'])); ?>" class="form-control">
        </div>
        <div class="form-group">
            <label for="area">Área / Ubicación</label>
            <input type="text" name="area" id="area" required value="<?php echo htmlspecialchars($accidente['area']); ?>" class="form-control">
        </div>
        <div class="form-group">
            <label for="afectados">Personas Afectadas</label>
            <textarea name="afectados" id="afectados" rows="3" class="form-control"><?php echo htmlspecialchars($accidente['afectados']); ?></textarea>
        </div>
        <div class="form-group">
            <label for="causa">Causa Raíz</label>
            <textarea name="causa" id="causa" rows="4" class="form-control"><?php echo htmlspecialchars($accidente['causa']); ?></textarea>
        </div>
        <div class="form-group">
            <label for="medidas_tomadas">Medidas Correctivas</label>
            <textarea name="medidas_tomadas" id="medidas_tomadas" rows="4" class="form-control"><?php echo htmlspecialchars($accidente['medidas_tomadas']); ?></textarea>
        </div>
        
        <button type="submit" class="btn btn-success"><i data-lucide="check-circle"></i><span>Guardar Cambios</span></button>
        <a href="index.php?page=accidentes" class="btn btn-secondary" style="margin-left: 10px;"><span>Cancelar</span></a>
    </form>
</div>
    
<div class="card">
    <h3>Gestionar Documentos Adjuntos</h3>
    <?php if (empty($documentos)): ?>
        <p>No hay documentos adjuntos para este evento.</p>
    <?php else: ?>
        <table class="table">
            <?php foreach ($documentos as $doc): ?>
                <tr>
                    <td>
                        <a href="uploads/accidentes/<?php echo htmlspecialchars($doc['ruta_archivo']); ?>" target="_blank">
                           <i data-lucide="file-text" style="vertical-align: middle; margin-right: 8px;"></i><?php echo htmlspecialchars($doc['ruta_archivo']); ?>
                        </a>
                    </td>
                    <td style="text-align: right;">
                        <a href="index.php?action=documento_accidente_eliminar&id_doc=<?php echo $doc['id_documento']; ?>&id_accidente=<?php echo $accidente['id_accidente']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de que desea eliminar este documento?');">
                           <i data-lucide="trash-2"></i> <span>Eliminar</span>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    
    <h4 style="margin-top: 2rem;">Añadir Nuevos Documentos</h4>
    <form action="index.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="agregar_documentos_accidente" value="1">
        <input type="hidden" name="id_accidente" value="<?php echo $accidente['id_accidente']; ?>">
        <div class="form-group">
            <input type="file" name="documentos[]" multiple required class="form-control">
        </div>
        <button type="submit" class="btn btn-primary"><i data-lucide="upload"></i><span>Subir Archivos</span></button>
    </form>
</div>

<?php
require_once 'layout/footer.php';
?>