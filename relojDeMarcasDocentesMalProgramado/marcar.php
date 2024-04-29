<?php
date_default_timezone_set('America/Montevideo');
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "ingresodocentes";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

function marcarEntrada($ci, $observacion, $conn) {
    $fecha = date("Y-m-d");
    $hora = date("H:i:s");

    $sql = "INSERT INTO ingresos (fecha, Docentes_ci, hora, observacion, tipo) VALUES ('$fecha', $ci, '$hora', '$observacion', 1)";

    if ($conn->query($sql) === TRUE) {
        echo "Marca de entrada realizada correctamente.";
    } else {
        echo "Error al marcar entrada: " . $conn->error;
    }
}

function marcarSalida($ci, $observacion, $conn) {
    $fecha = date("Y-m-d");
    $hora = date("H:i:s");

    $sql = "INSERT INTO ingresos (fecha, Docentes_ci, hora, observacion, tipo) VALUES ('$fecha', $ci, '$hora', '$observacion', 2)";

    if ($conn->query($sql) === TRUE) {
        echo "Marca de salida realizada correctamente.";
    } else {
        echo "Error al marcar salida: " . $conn->error;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST["ci"])) {
        $ci = $_POST["ci"];
        $observacion_entrada = isset($_POST["observacion_entrada"]) ? $_POST["observacion_entrada"] : "";
        marcarEntrada($ci, $observacion_entrada, $conn);
    }

    if (!empty($_POST["ci_salida"])) {
        $ci_salida = $_POST["ci_salida"];
        $observacion_salida = isset($_POST["observacion_salida"]) ? $_POST["observacion_salida"] : "";
        marcarSalida($ci_salida, $observacion_salida, $conn);
    }
}
$conn->close();
header("Location: index.html");
exit();
?>
