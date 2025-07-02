<?php
// src/views/equipo_editar.php (Ahora es Registrar Mantenimiento)
require_once 'layout/header.php';
?>

<h1>Registrar Mantenimiento Realizado</h1>

<div class="card">
    <h3>Equipo: <?php echo htmlspecialchars($equipo['tipo_equipo']); ?> (<?php echo htmlspecialchars($equipo['nombre_hotel']); ?>)</h3>
    <p style="color: var(--color-texto-secundario);">Ubicación: <?php echo htmlspecialchars($equipo['ubicacion']); ?></p>

    <form action="index.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="realizar_mantenimiento" value="1">
        <input type="hidden" name="id_equipo" value="<?php echo $equipo['id_equipo']; ?>">

        <div class="form-group">
            <label for="fecha_ultimo_mantenimiento">Fecha en que se realizó el mantenimiento</label>
            <input type="date" name="fecha_ultimo_mantenimiento" id="fecha_ultimo_mantenimiento" value="<?php echo date('Y-m-d'); ?>" required class="form-control">
        </div>
        
        <div class="form-group">
            <label for="fecha_proximo_mantenimiento">Nueva Fecha de Próximo Mantenimiento</label>
            <input type="date" name="fecha_proximo_mantenimiento" id="fecha_proximo_mantenimiento" required class="form-control">
        </div>

        <div class="form-group">
            <label for="descripcion">Descripción del trabajo realizado (opcional)</label>
            <textarea name="descripcion" id="descripcion" rows="3" class="form-control"></textarea>
        </div>

        <div class="form-group">
            <label for="prueba_mantenimiento">Foto de Prueba (Obligatorio)</label>
            <input type="file" name="prueba_mantenimiento" id="prueba_mantenimiento" required class="form-control" accept="image/*">
        </div>

        <button type="submit" class="btn btn-success">
            <i data-lucide="check-check"></i>
            <span>Confirmar Mantenimiento</span>
        </button>
        <a href="index.php?page=equipamientos" class="btn btn-secondary" style="margin-left: 10px;">
            <i data-lucide="x-circle"></i>
            <span>Cancelar</span>
        </a>
    </form>
</div>

<?php
require_once 'layout/footer.php';
?>
