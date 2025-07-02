<?php
// public/generar_reporte.php (Reescrito con FPDF y ZONA HORARIA CORREGIDA)

session_start();

// LÍNEA AÑADIDA PARA CORREGIR LA HORA
date_default_timezone_set('America/Montevideo');

// Cargamos la librería FPDF manualmente
require_once __DIR__ . '/../lib/fpdf186/fpdf.php';
require_once __DIR__ . '/../src/core/Database.php';

if (!isset($_SESSION['user_id'])) {
    die('Acceso denegado. Por favor, inicie sesión.');
}

$pdo = Database::getInstance();

// --- La lógica para obtener los datos filtrados no cambia ---
$filtro_hotel = $_GET['filtro_hotel'] ?? 'todos';
$filtro_fecha_desde = $_GET['filtro_fecha_desde'] ?? '';
$filtro_fecha_hasta = $_GET['filtro_fecha_hasta'] ?? '';
$where_clauses = [];
$params = [];
if ($filtro_hotel !== 'todos' && !empty($filtro_hotel)) { $where_clauses[] = "h.id_hotel = ?"; $params[] = $filtro_hotel; }
if (!empty($filtro_fecha_desde)) { $where_clauses[] = "fecha >= ?"; $params[] = $filtro_fecha_desde; }
if (!empty($filtro_fecha_hasta)) { $where_clauses[] = "fecha <= ?"; $params[] = $filtro_fecha_hasta . ' 23:59:59'; }
$where_sql = count($where_clauses) > 0 ? "WHERE " . implode(' AND ', $where_clauses) : "";
$sql_capacitaciones = "SELECT h.nombre as nombre_hotel, COUNT(c.id_capacitacion) as total FROM hoteles h LEFT JOIN capacitaciones c ON h.id_hotel = c.id_hotel " . str_replace('fecha', 'c.fecha', $where_sql) . " GROUP BY h.id_hotel ORDER BY h.nombre";
$stmt_cap = $pdo->prepare($sql_capacitaciones);
$stmt_cap->execute($params);
$stats_capacitaciones = $stmt_cap->fetchAll(PDO::FETCH_KEY_PAIR);
$sql_accidentes = "SELECT h.nombre as nombre_hotel, COUNT(a.id_accidente) as total FROM hoteles h LEFT JOIN accidentes a ON a.id_hotel = a.id_hotel " . str_replace('fecha', 'a.fecha', $where_sql) . " GROUP BY h.id_hotel ORDER BY h.nombre";
$stmt_acc = $pdo->prepare($sql_accidentes);
$stmt_acc->execute($params);
$stats_accidentes = $stmt_acc->fetchAll(PDO::FETCH_KEY_PAIR);
$hotelesStmt = $pdo->query("SELECT id_hotel, nombre FROM hoteles ORDER BY nombre");
$hoteles = $hotelesStmt->fetchAll();


// --- Creación del PDF con FPDF ---

class PDF extends FPDF {
    // Cabecera de página
    function Header() {
        $this->SetFont('Arial','B',15);
        $this->Cell(0,10, 'Reporte Estadistico - Grand LUX',0,1,'C');
        $this->SetFont('Arial','',9);
        // Usamos la hora ya configurada con la zona horaria correcta
        $this->Cell(0,5, 'Fecha de generacion: ' . date('d/m/Y H:i'),0,1,'C');
        $this->Ln(10);
    }

    // Pie de página
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
    }
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',12);

// Cabecera de la tabla
$pdf->SetFont('','B', 11);
$pdf->SetFillColor(230,230,230);
$pdf->Cell(80, 10, 'Hotel', 1, 0, 'L', true);
$pdf->Cell(55, 10, 'Capacitaciones', 1, 0, 'C', true);
$pdf->Cell(55, 10, 'Accidentes', 1, 1, 'C', true);
$pdf->SetFont('','', 10);

// Datos de la tabla
foreach ($hoteles as $hotel) {
    if ($filtro_hotel === 'todos' || $filtro_hotel == $hotel['id_hotel']) {
        $nombre_hotel = utf8_decode($hotel['nombre']);
        $total_cap = $stats_capacitaciones[$hotel['nombre']] ?? 0;
        $total_acc = $stats_accidentes[$hotel['nombre']] ?? 0;
        
        $pdf->Cell(80, 8, $nombre_hotel, 1);
        $pdf->Cell(55, 8, $total_cap, 1, 0, 'C');
        $pdf->Cell(55, 8, $total_acc, 1, 1, 'C');
    }
}

$pdf->Output('D', 'reporte_estadistico_grandlux.pdf');
exit;