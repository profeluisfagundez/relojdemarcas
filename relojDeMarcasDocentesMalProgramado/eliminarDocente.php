<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "ingresodocentes";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST["ci"])) {
        $ci = $_POST["ci"];
        $sql_delete_docente = "DELETE FROM docentes WHERE ci = $ci";
        if ($conn->query($sql_delete_docente) === TRUE) {
            echo "Docente eliminado correctamente.";
        } else {
            echo "Error al eliminar el docente: " . $conn->error;
        }
        $sql_delete_ingresos = "DELETE FROM ingresos WHERE Docentes_ci = $ci";
        if ($conn->query($sql_delete_ingresos) === TRUE) {
            echo "Marcas de entrada/salida del docente eliminadas correctamente.";
        } else {
            echo "Error al eliminar las marcas de entrada/salida del docente: " . $conn->error;
        }
    } else {
        echo "La cédula de identidad del docente no puede estar vacía.";
    }
}
$conn->close();
header("Location: index.html");
exit();
?>
