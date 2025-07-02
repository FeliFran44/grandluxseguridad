<?php
// src/views/historial.php (Responsive Final)
require_once 'layout/header.php';
?>

<div class="card">
    <h3>Filtros de Búsqueda</h3>
    <form action="index.php" method="GET">
        <input type="hidden" name="page" value="historial">
        <div style="display: flex; gap: 1rem; align-items: flex-end; flex-wrap: wrap;">
            <div class="form-group" style="flex: 1 1 200px;">
                <label for="filtro_hotel">Hotel</label>
                <select name="filtro_hotel" id="filtro_hotel" class="form-control">
                    <option value="todos">Todos los Hoteles</option>
                    <?php foreach ($hoteles as $hotel): ?>
                        <option value="<?php echo $hotel['id_hotel']; ?>" <?php echo (isset($filtro_hotel) && $filtro_hotel == $hotel['id_hotel']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($hotel['nombre']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group" style="flex: 1 1 200px;">
                <label for="filtro_fecha_desde">Fecha Desde</label>
                <input type="date" name="filtro_fecha_desde" id="filtro_fecha_desde" value="<?php echo htmlspecialchars($filtro_fecha_desde ?? ''); ?>" class="form-control">
            </div>
            <div class="form-group" style="flex: 1 1 200px;">
                <label for="filtro_fecha_hasta">Fecha Hasta</label>
                <input type="date" name="filtro_fecha_hasta" id="filtro_fecha_hasta" value="<?php echo htmlspecialchars($filtro_fecha_hasta ?? ''); ?>" class="form-control">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    <i data-lucide="search"></i>
                    <span>Filtrar</span>
                </button>
            </div>
        </div>
    </form>
</div>

<div class="card">
    <h3>Visualización y Exportación</h3>
    <div style="width: 100%; max-width: 900px; margin: auto; margin-bottom: 2rem; background: var(--color-superficie); padding: 1rem; border-radius: var(--radio-borde);">
        <canvas id="graficoGeneral"></canvas>
    </div>
    <a href="generar_reporte.php?<?php echo http_build_query($_GET); ?>" target="_blank" class="btn btn-info">
        <i data-lucide="file-down"></i>
        <span>Exportar a PDF</span>
    </a>
</div>

<div class="card">
    <h3>Resumen de Registros en Tabla</h3>
    <div style="overflow-x: auto;">
        <table class="table">
            <thead>
                <tr>
                    <th>Hotel</th>
                    <th style="text-align: center;">Capacitaciones Realizadas</th>
                    <th style="text-align: center;">Accidentes / Incidentes Reportados</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($hoteles as $hotel): ?>
                    <?php if ($filtro_hotel === 'todos' || $filtro_hotel == $hotel['id_hotel']): ?>
                    <tr>
                        <td style="font-weight: 600;"><?php echo htmlspecialchars($hotel['nombre']); ?></td>
                        <td style="text-align: center; font-size: 1.2rem; font-weight: 700;"><?php echo $stats_capacitaciones[$hotel['nombre']] ?? 0; ?></td>
                        <td style="text-align: center; font-size: 1.2rem; font-weight: 700;"><?php echo $stats_accidentes[$hotel['nombre']] ?? 0; ?></td>
                    </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labels = <?php echo $chart_labels; ?>;
    const dataCapacitaciones = <?php echo $chart_data_capacitaciones; ?>;
    const dataAccidentes = <?php echo $chart_data_accidentes; ?>;
    
    // Configuración del gráfico adaptada al tema oscuro
    const data = {
        labels: labels,
        datasets: [
            {
                label: 'Capacitaciones',
                data: dataCapacitaciones,
                backgroundColor: 'rgba(34, 211, 238, 0.5)',
                borderColor: 'rgba(34, 211, 238, 1)',
                borderWidth: 1
            },
            {
                label: 'Accidentes',
                data: dataAccidentes,
                backgroundColor: 'rgba(244, 63, 94, 0.5)',
                borderColor: 'rgba(244, 63, 94, 1)',
                borderWidth: 1
            }
        ]
    };

    const config = {
        type: 'bar',
        data: data,
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { 
                        color: 'var(--color-texto-secundario)',
                        font: { family: "'Inter', sans-serif" }
                    },
                    grid: { color: 'var(--color-borde)' }
                },
                x: {
                    ticks: { 
                        color: 'var(--color-texto-secundario)',
                        font: { family: "'Inter', sans-serif" }
                    },
                    grid: { color: 'var(--color-borde)' }
                }
            },
            responsive: true,
            plugins: {
                legend: {
                    labels: { 
                        color: 'var(--color-texto-principal)',
                        font: { family: "'Inter', sans-serif" }
                    }
                },
                title: {
                    display: true,
                    text: 'Comparativa de Registros por Hotel',
                    color: 'var(--color-texto-principal)',
                    font: { 
                        size: 18,
                        family: "'Inter', sans-serif",
                        weight: '600'
                    }
                }
            }
        }
    };

    // Renderizamos el gráfico
    const miGrafico = new Chart(
        document.getElementById('graficoGeneral'),
        config
    );
</script>

<?php
require_once 'layout/footer.php';
?>
