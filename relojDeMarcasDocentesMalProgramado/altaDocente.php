<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "ingresodocentes";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$ci = $_POST['ci'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];

$sql = "INSERT INTO docentes (ci, nombre, apellido) VALUES ('$ci', '$nombre', '$apellido')";

if ($conn->query($sql) === TRUE) {
    echo "Docente agregado correctamente.";
} else {
    echo "Error al agregar el docente: " . $conn->error;
}

$conn->close();
header("Location: index.html");
exit();
?>
