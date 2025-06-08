<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "ingresodocentes";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql = "SELECT ingresos.fecha, ingresos.hora, docentes.nombre, docentes.apellido, ingresos.observacion, 
            CASE 
                WHEN ingresos.tipo = 1 THEN 'Entrada' 
                WHEN ingresos.tipo = 2 THEN 'Salida' 
            END AS tipo
        FROM ingresos
        INNER JOIN docentes ON ingresos.Docentes_ci = docentes.ci
        ORDER BY ingresos.fecha DESC, ingresos.hora DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marcas de Entradas/Salidas</title>
    <link rel="stylesheet" href="styleMarcasEntradaSalida.css">
</head>
<body>
    <h1>Marcas de Entradas/Salidas</h1>
    <div class="container">
        <?php
        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>Fecha</th>";
            echo "<th>Hora</th>";
            echo "<th>Nombre</th>";
            echo "<th>Apellido</th>";
            echo "<th>Tipo</th>";
            echo "<th>Observación</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["fecha"] . "</td>";
                echo "<td>" . $row["hora"] . "</td>";
                echo "<td>" . $row["nombre"] . "</td>";
                echo "<td>" . $row["apellido"] . "</td>";
                echo "<td>" . $row["tipo"] . "</td>";
                echo "<td>" . ($row["observacion"] ? $row["observacion"] : "-") . "</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        } else {
            echo "<p>No hay marcas de entradas/salidas registradas.</p>";
        }
        ?>
    </div>
</body>
</html>

<?php
$conn->close();
?>
