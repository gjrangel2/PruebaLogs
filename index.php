<?php
// Nombre del archivo .log
$logFile = 'reporteWhatsapp.log';


$lines = file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);


$logs = [];


foreach ($lines as $line) {
   
    $parts = explode('|', $line);

    // Validar que la línea tenga al menos 3 columnas
    if (count($parts) >= 3) {
        // Organizar la información en un array asociativo
        $logs[] = [
            'fecha' => $parts[0],                 
            'telefono' => (strpos($line, 'ERRO') == true) ?                        $parts[2] : $parts[1],
            'tipo' => (strpos($parts[1], 'ERRO') == true ||                        strpos($line, 'ERRO') == true) ? 'Error' : 'OK', 
            'detalle' => (strpos($line, 'ERRO') == true) ?                         implode(' | ', array_slice($parts, 3)) : implode('                 | ', array_slice($parts, 2)),
            'adicional' => (strpos($line, 'ERRO') !== false ?
                implode(' | ', array_slice($parts, 0,2)):implode('             | ', array_slice($parts, 2)) )
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Logs</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f8;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            background-color: #white;
        }
        thead {
            background-color: #4CAF50;
            color: white;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .error {
            background-color: #ffebeb !important;
        }
        .tag {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            color: white;
        }
        .tag-info {
            background-color: darkblue;
        }
        .tag-error {
            background-color: yellow;
        }
    </style>
</head>
<body>

<h1>Reporte de Log de WhatsApp</h1>

<table>
    <thead>
        <tr>
            <th>Fecha y Hora</th>
            <th>Teléfono</th>
            <th>Tipo</th>
            <th>Detalle</th>
            <th>Adicional</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($logs as $log): ?>
            <tr class="<?php echo ($log['tipo'] == 'Error') ? 'error' : ''; ?>">
                <td><?php echo $log['fecha']; ?></td>
                <td><?php echo $log['telefono']; ?></td>
                <td>
                    <?php if ($log['tipo'] == 'Error'): ?>
                        <span class="tag tag-error">Error</span>
                    <?php else: ?>
                        <span class="tag tag-info">OK</span>
                    <?php endif; ?>
                </td>
                <td><?php echo $log['detalle']; ?></td>
                <td><?php echo $log['adicional']; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>