<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "ingresodocentes";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$fecha_inicio = $_POST['fecha_inicio'];
$fecha_fin = $_POST['fecha_fin'];

$sql = "SELECT ingresos.fecha, ingresos.hora, docentes.nombre, docentes.apellido, ingresos.observacion, 
            CASE 
                WHEN ingresos.tipo = 1 THEN 'Entrada' 
                WHEN ingresos.tipo = 2 THEN 'Salida' 
            END AS tipo
        FROM ingresos
        INNER JOIN docentes ON ingresos.Docentes_ci = docentes.ci
        WHERE ingresos.fecha BETWEEN '$fecha_inicio' AND '$fecha_fin'
        ORDER BY ingresos.fecha DESC, ingresos.hora DESC";

$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setCellValue('A1', 'Fecha');
    $sheet->setCellValue('B1', 'Hora');
    $sheet->setCellValue('C1', 'Nombre');
    $sheet->setCellValue('D1', 'Apellido');
    $sheet->setCellValue('E1', 'Tipo');
    $sheet->setCellValue('F1', 'Observación');
    $row = 2;
    while ($row_data = $result->fetch_assoc()) {
        $sheet->setCellValue('A' . $row, $row_data['fecha']);
        $sheet->setCellValue('B' . $row, $row_data['hora']);
        $sheet->setCellValue('C' . $row, $row_data['nombre']);
        $sheet->setCellValue('D' . $row, $row_data['apellido']);
        $sheet->setCellValue('E' . $row, $row_data['tipo']);
        $sheet->setCellValue('F' . $row, $row_data['observacion']);
        $row++;
    }
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="marcas_entradas_salidas_por_fecha.xlsx"');
    header('Cache-Control: max-age=0');
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
} else {
    echo "No hay datos para exportar.";
}
$conn->close();
header("Location: index.html");
?>
