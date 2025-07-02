<?php
// src/views/dashboard.php (Refactorizado V4 - JS Corregido)
require_once 'layout/header.php';
?>

<?php if ($_SESSION['user_role'] === 'administrador'): ?>
<div class="card">
    <h3>Nuevo Comunicado</h3>
    <form action="index.php" method="POST">
        <input type="hidden" name="nuevo_comunicado" value="1">
        <div class="form-group">
            <label for="titulo">Título</label>
            <input type="text" name="titulo" id="titulo" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="contenido">Mensaje</label>
            <textarea name="contenido" id="contenido" rows="4" class="form-control" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="sidebar-icon"><line x1="22" x2="11" y1="2" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
            <span>Publicar Comunicado</span>
        </button>
    </form>
</div>
<?php endif; ?>

<div id="comunicados-container">
    <?php if (empty($comunicados)): ?>
        <div class="card" style="text-align: center;">
            <p>No hay comunicados para mostrar.</p>
        </div>
    <?php else: ?>
        <?php foreach ($comunicados as $comunicado): ?>
            <div class="card">
                <h3><?php echo htmlspecialchars($comunicado['titulo']); ?></h3>
                <p style="font-size: 0.9rem; color: var(--color-texto-secundario);">Publicado por <strong><?php echo htmlspecialchars($comunicado['nombre_completo']); ?></strong> el <?php echo date('d/m/Y H:i', strtotime($comunicado['fecha_publicacion'])); ?></p>
                <p class="comment-content" style="margin-top: 1.5rem;"><?php echo nl2br(htmlspecialchars($comunicado['contenido'])); ?></p>
                
                <div class="comment-list" id="comment-list-<?php echo $comunicado['id_comunicado']; ?>">
                    <hr style="border-color: var(--color-borde); margin: 2rem 0;">
                    <h4>Respuestas</h4>
                    <?php 
                        $id_comunicado_actual = $comunicado['id_comunicado'];
                        if (isset($comentarios_agrupados[$id_comunicado_actual]) && !empty($comentarios_agrupados[$id_comunicado_actual])):
                    ?>
                        <?php foreach ($comentarios_agrupados[$id_comunicado_actual] as $comentario): ?>
                            <div class="comment-item">
                                <p class="comment-content"><?php echo nl2br(htmlspecialchars($comentario['contenido'])); ?></p>
                                <p class="comment-meta">
                                    &mdash; <strong><?php echo htmlspecialchars($comentario['nombre_completo']); ?></strong>
                                    <span>el <?php echo date('d/m/Y H:i', strtotime($comentario['fecha_publicacion'])); ?></span>
                                </p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="no-comments" id="no-comments-<?php echo $comunicado['id_comunicado']; ?>">No hay respuestas todavía.</p>
                    <?php endif; ?>
                </div>

                <form class="comment-form" method="POST" action="index.php?action=add_comment">
                    <input type="hidden" name="id_comunicado" value="<?php echo $id_comunicado_actual; ?>">
                    <div class="form-group">
                        <textarea name="contenido" rows="2" placeholder="Escriba su respuesta..." required class="form-control"></textarea>
                    </div>
                    <button type="submit" class="btn btn-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="sidebar-icon"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                        <span>Enviar Respuesta</span>
                    </button>
                </form>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.body.addEventListener('submit', function(event) {
        if (event.target.matches('.comment-form')) {
            event.preventDefault();
            const form = event.target;
            const formData = new FormData(form);
            const idComunicado = formData.get('id_comunicado');
            const button = form.querySelector('button');
            const buttonSpan = form.querySelector('span');
            const originalButtonText = buttonSpan.textContent;

            button.disabled = true;
            buttonSpan.textContent = 'Enviando...';

            fetch(form.action, {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('La respuesta del servidor no fue OK.');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    const newComment = data.comment;
                    const commentList = document.getElementById('comment-list-' + idComunicado);
                    
                    const noCommentsMessage = document.getElementById('no-comments-' + idComunicado);
                    if (noCommentsMessage) noCommentsMessage.remove();
                    
                    const commentDiv = document.createElement('div');
                    commentDiv.className = 'comment-item';
                    
                    const date = new Date(newComment.fecha_publicacion.replace(' ', 'T'));
                    const formattedDate = date.toLocaleDateString('es-ES', { day: '2-digit', month: '2-digit', year: 'numeric' }) + ' ' + date.toLocaleTimeString('es-ES', {hour: '2-digit', minute:'2-digit'});

                    commentDiv.innerHTML = `
                        <p class="comment-content">${escapeHTML(newComment.contenido)}</p>
                        <p class="comment-meta">
                            &mdash; <strong>${escapeHTML(newComment.nombre_completo)}</strong>
                            <span>el ${formattedDate}</span>
                        </p>`;
                    
                    commentList.appendChild(commentDiv);
                    form.querySelector('textarea').value = '';
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error en la petición fetch:', error);
                alert('Ocurrió un error de conexión. Por favor, recargue la página e inténtelo de nuevo.');
            })
            .finally(() => {
                button.disabled = false;
                buttonSpan.textContent = originalButtonText;
            });
        }
    });

    function escapeHTML(str) {
        const p = document.createElement('p');
        p.textContent = str;
        return p.innerHTML;
    }
});
</script>

<?php
require_once 'layout/footer.php';
?>
