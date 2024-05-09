<?php
require('class.pdofactory.php');
require('abstract.databoundobject.php');
require('filtrarinformacion.php');

$strDSN = "pgsql:dbname=usuaris;host=localhost;port=5432";
$objPDO = PDOFactory::GetPDO($strDSN, "postgres", "root", array());
$objPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Realiza una consulta a la base de datos para obtener los datos de la tabla datosTwitter
$query = "SELECT url, author_name, provider_name FROM datosTwitter"; // Solo selecciona las columnas existentes
$stmt = $objPDO->query($query);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$url = $row['url'];
$author_name = $row['author_name'];
$author_url = isset($row['author_url']) ? $row['author_url'] : "N/A"; // Verifica si la columna existe antes de acceder a ella
$provider_name = $row['provider_name'];

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de Tweets</title>
    <style>
        body {
            background-color: #f2f2f2; /* Gris claro */
            font-family: Arial, sans-serif;
        }
        table {
            width: 80%;
            margin: 0 auto; /* Centra la tabla */
            border-collapse: collapse;
            border: 3px solid #000; /* Borde de 3px sólido negro */
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #000;
        }
        th {
            background-color: #ccc; /* Gris claro para encabezados */
        }
        tr:nth-child(even) {
            background-color: #f9f9f9; /* Gris más claro para filas pares */
        }
    </style>
</head>
<body>
    <h1>Tabla de Tweets</h1>
    <table>
        <tr>
            <th>Url del tweet</th>
            <th>Nombre autor</th>
            <th>Url autor</th>
            <th>Nombre proveedor</th>
        </tr>
        <tr>
            <td><?php echo $url; ?></td>
            <td><?php echo $author_name; ?></td>
            <td><?php echo $author_url; ?></td>
            <td><?php echo $provider_name; ?></td>
        </tr>
    </table>
</body>
</html>
