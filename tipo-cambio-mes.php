<?php
// URL de la API con los parámetros necesarios
$token = "7256|KYdMEURxaugN4gSpBQHett0FUDUytHtCmQLS9MuF"; // esto se obtiene de la cuenta de apis.aqpfact.pe
$anio="2024";
$mes = "12";
$url = "https://apis.aqpfact.pe/api/tipo-cambio-mes/$anio/$mes";

// Configuración de contexto HTTP para la solicitud
$options = array(
    "http" => array(
        "method" => "GET", // Método HTTP
        "header" => "Content-Type: application/json\r\n" .
            "Authorization: Bearer $token\r\n"
    )
);

$context = stream_context_create($options);

// Realizar la solicitud a la API
$response = file_get_contents($url, false, $context);

// Verificar si la respuesta fue obtenida correctamente
if ($response === false) {
    echo "Error al realizar la solicitud a la API.";
    exit;
}

// Convertir la respuesta JSON en un arreglo asociativo de PHP
$data = json_decode($response, true);

// Verificar si la conversión fue exitosa y si el campo 'success' es verdadero
if (is_array($data) && isset($data['success']) && $data['success']) {
    // Extraer el arreglo de datos
    $records = isset($data['data']) ? $data['data'] : [];

    // Verificar que el arreglo no esté vacío
    if (!empty($records)) {
        echo "<table border='1' cellspacing='0' cellpadding='5'>";
        echo "<tr>";
        echo "<th>Fecha</th>";
        echo "<th>Compra</th>";
        echo "<th>Venta</th>";
        echo "</tr>";

        // Recorrer cada registro y mostrar los datos
        foreach ($records as $record) {
            $fecha = isset($record['fecha']) ? $record['fecha'] : "1.000";
            $compra = isset($record['compra']) ? $record['compra'] : "1.000";
            $venta = isset($record['venta']) ? $record['venta'] : "1.000";

            echo "<tr>";
            echo "<td>$fecha</td>";
            echo "<td>$compra</td>";
            echo "<td>$venta</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No se encontraron registros en los datos.";
    }
} else {
    // Manejar errores o respuestas no exitosas
    echo "Error: No se pudo obtener la información correctamente.";
    if (isset($data['message'])) {
        echo "Mensaje de la API: " . $data['message'];
    }
}
?>