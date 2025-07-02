<?php
// src/views/layout/footer.php (V6.3 - Final y Estable con Modal de Alertas)
?>
        </main>
    </div>
</div>

<div id="alert-modal" class="alert-modal-overlay" style="display: none;">
    <div class="alert-modal-content">
        <div class="alert-modal-header">
            <h2>Alertas de Mantenimiento</h2>
            <button id="alert-modal-close" class="alert-modal-close-button">&times;</button>
        </div>
        <div class="alert-modal-body">
            <?php if (empty($alertas_mantenimiento)): ?>
                <p style="text-align: center; color: var(--color-texto-secundario);">No hay mantenimientos próximos en los siguientes 30 días.</p>
            <?php else: ?>
                <ul>
                    <?php foreach ($alertas_mantenimiento as $alerta): 
                        $fecha_vencimiento = new DateTime($alerta['fecha_proximo_mantenimiento']);
                        $hoy = new DateTime();
                        $hoy->setTime(0, 0, 0);
                        $fecha_vencimiento->setTime(0, 0, 0);
                        $diferencia = $hoy->diff($fecha_vencimiento);
                        $dias_restantes = $diferencia->days;
                        if($diferencia->invert) { $dias_restantes = 0; }
                    ?>
                        <li>
                            <div class="alert-item">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="alert-icon"><path d="m21.73 18-8-14a2 2 0 0 0-3.46 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>
                                <div class="alert-text">
                                    <strong><?php echo htmlspecialchars($alerta['tipo_equipo']); ?></strong> en <?php echo htmlspecialchars($alerta['ubicacion']); ?> (<?php echo htmlspecialchars($alerta['nombre_hotel']); ?>)
                                    <small>Vence en <?php echo $dias_restantes; ?> días (<?php echo date('d/m/Y', strtotime($alerta['fecha_proximo_mantenimiento'])); ?>)</small>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</div>
<script>
    // Script para la funcionalidad del menú móvil
    document.addEventListener('DOMContentLoaded', () => {
        const sidebar = document.getElementById('sidebar');
        const menuButton = document.getElementById('mobile-menu-button');
        const navLinks = document.querySelectorAll('.sidebar-nav a, .sidebar-footer a');
        let overlay = null;

        const openMenu = () => {
            if (sidebar && !sidebar.classList.contains('open')) {
                sidebar.classList.add('open');
                if (!overlay) {
                    overlay = document.createElement('div');
                    overlay.className = 'overlay';
                    document.body.appendChild(overlay);
                    overlay.onclick = closeMenu;
                }
            }
        };
        const closeMenu = () => {
            if (sidebar && sidebar.classList.contains('open')) {
                sidebar.classList.remove('open');
                if (overlay) {
                    overlay.remove();
                    overlay = null;
                }
            }
        };

        if (menuButton) {
            menuButton.addEventListener('click', (e) => {
                e.stopPropagation();
                sidebar.classList.contains('open') ? closeMenu() : openMenu();
            });
        }
        
        navLinks.forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth <= 992) {
                    closeMenu();
                }
            });
        });
    });

    // Script para el modal de alertas
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('alert-modal');
        const openButton = document.getElementById('alert-bell-button');
        const closeButton = document.getElementById('alert-modal-close');

        const openModal = () => { if(modal) modal.style.display = 'flex'; };
        const closeModal = () => { if(modal) modal.style.display = 'none'; };

        if (openButton) { openButton.addEventListener('click', openModal); }
        if (closeButton) { closeButton.addEventListener('click', closeModal); }

        if(modal) {
            modal.addEventListener('click', (event) => {
                if (event.target === modal) {
                    closeModal();
                }
            });
        }
    });
</script>

</body>
</html>