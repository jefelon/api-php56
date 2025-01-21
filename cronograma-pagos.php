<?php
// URL de la API
$token = "7256|KYdMEURxaugN4gSpBQHett0FUDUytHtCmQLS9MuF"; // esto se obtiene de la cuenta de apis.aqpfact.pe
$anio = "2024";
$ruc = "20100190797";
$url = "https://apis.aqpfact.pe/api/cronograma/$anio/$ruc";

// Configuración de contexto HTTP para la solicitud GET
$options = array(
    "http" => array(
        "method" => "GET", // Método HTTP
        "header" => "Content-Type: application/json\r\n" .
            "Authorization: Bearer $token\r\n" // Authorization token
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

// Verificar si la conversión fue exitosa
if (is_array($data) && !empty($data)) {
    // Mostrar los datos en una tabla HTML
    echo "<table border='1' cellspacing='0' cellpadding='5'>";
    echo "<tr><th>Periodo</th><th>Vencimiento</th></tr>";

    // Recorrer los registros y mostrar los datos
    foreach ($data as $record) {
        $periodo = isset($record['periodo']) ? $record['periodo'] : "Desconocido";
        $vencimiento = isset($record['vencimiento']) ? $record['vencimiento'] : "Desconocido";

        echo "<tr>";
        echo "<td>$periodo</td>";
        echo "<td>$vencimiento</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    // Manejar errores o respuestas no exitosas
    echo "Error: No se pudo obtener la información correctamente.";
}
?>
