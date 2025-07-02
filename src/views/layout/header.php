<?php
// src/views/layout/header.php (V6.3 - Definitivo)
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}
$page = $_GET['page'] ?? 'dashboard';
$pageTitles = [
    'dashboard' => 'Inicio / Comunicados',
    'capacitaciones' => 'Gestión de Capacitaciones', 'capacitacion_editar' => 'Editar Capacitación', 'capacitacion_detalle' => 'Detalle de Capacitación',
    'equipamientos' => 'Gestión de Equipamientos', 'equipo_editar' => 'Editar Equipo', 'equipo_detalle' => 'Detalle de Equipo',
    'accidentes' => 'Registro de Accidentes', 'accidente_editar' => 'Editar Accidente', 'accidente_detalle' => 'Detalle de Accidente',
    'historial' => 'Historial y Estadísticas',
    'bitacora' => 'Bitácora de Actividades',
];
$currentPageTitle = $pageTitles[$page] ?? 'Panel de Control';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grand LUX - <?php echo $currentPageTitle; ?></title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

<div class="main-wrapper">
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="index.php" class="sidebar-brand">Grand LUX</a>
        </div>
        <nav class="sidebar-nav">
            <a href="index.php?page=dashboard" class="<?php echo ($currentPage === 'dashboard') ? 'active' : ''; ?>">
                <svg class="sidebar-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                <span>Inicio</span>
            </a>
            <a href="index.php?page=capacitaciones" class="<?php echo ($currentPage === 'capacitaciones') ? 'active' : ''; ?>">
                <svg class="sidebar-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3.33 1.67 6.67 1.67 10 0v-5"/></svg>
                <span>Capacitaciones</span>
            </a>
            <a href="index.php?page=equipamientos" class="<?php echo ($currentPage === 'equipamientos') ? 'active' : ''; ?>">
                <svg class="sidebar-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"/><path d="m9 12 2 2 4-4"/></svg>
                <span>Equipamientos</span>
            </a>
            <a href="index.php?page=accidentes" class="<?php echo ($currentPage === 'accidentes') ? 'active' : ''; ?>">
                <svg class="sidebar-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><path d="M12 18v-6"/><path d="M12 6v.01"/></svg>
                <span>Accidentes</span>
            </a>
            <a href="index.php?page=historial" class="<?php echo ($currentPage === 'historial') ? 'active' : ''; ?>">
                <svg class="sidebar-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="M7 12v5h12V8l-5 5-4-4-3 3"/></svg>
                <span>Historial</span>
            </a>
             <?php if ($_SESSION['user_role'] === 'administrador'): ?>
                <hr style="border-color: var(--color-borde); margin: 1rem 0;">
                <a href="index.php?page=bitacora" class="<?php echo ($currentPage === 'bitacora') ? 'active' : ''; ?>">
                    <svg class="sidebar-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/><path d="M8 14h.01"/><path d="M12 14h.01"/><path d="M16 14h.01"/><path d="M8 18h.01"/><path d="M12 18h.01"/><path d="M16 18h.01"/></svg>
                    <span>Bitácora</span>
                </a>
            <?php endif; ?>
        </nav>
        <div class="sidebar-footer">
            <div class="user-profile">
                <div class="user-info">
                    <strong><?php echo htmlspecialchars($_SESSION['user_name']); ?></strong>
                    <p><small>(<?php echo htmlspecialchars($_SESSION['user_role']); ?>)</small></p>
                </div>
                <button id="alert-bell-button" class="alert-button" title="Notificaciones de Mantenimiento">
                    <svg class="sidebar-icon-bell" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
                    <?php if (count($alertas_mantenimiento) > 0): ?>
                        <span class="alert-badge"><?php echo count($alertas_mantenimiento); ?></span>
                    <?php endif; ?>
                </button>
            </div>
            <a href="index.php?action=logout" class="btn btn-danger btn-sm" style="width: 100%;">
                <svg class="sidebar-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
                <span>Cerrar Sesión</span>
            </a>
        </div>
    </aside>
    <div class="content-wrapper">
        <header class="mobile-header">
            <button class="mobile-menu-button" id="mobile-menu-button" aria-label="Abrir menú">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/></svg>
            </button>
            <span class="mobile-header-title"><?php echo $currentPageTitle; ?></span>
        </header>
        <main class="content">
            <h1 class="desktop-title"><?php echo $currentPageTitle; ?></h1>