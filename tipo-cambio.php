<?php
// URL de la API con los parámetros necesarios
$token = "7256|KYdMEURxaugN4gSpBQHett0FUDUytHtCmQLS9MuF"; // esto se obtiene de la cuenta de apis.aqpfact.pe
$dia = "2024-05-26";
$url = "https://apis.aqpfact.pe/api/tipo-cambio-dia/$dia";

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
    // Extraer datos específicos de la respuesta
    $fechaBusqueda = isset($data['data']['fecha_busqueda']) ? $data['data']['fecha_busqueda'] : "No disponible";
    $fechaSunat = isset($data['data']['fecha_sunat']) ? $data['data']['fecha_sunat'] : "No disponible";
    $venta = isset($data['data']['venta']) ? $data['data']['venta'] : "No disponible";
    $compra = isset($data['data']['compra']) ? $data['data']['compra'] : "No disponible";
    $origen = isset($data['data']['origen']) ? $data['data']['origen'] : "No disponible";
    $moneda = isset($data['data']['moneda']) ? $data['data']['moneda'] : "No disponible";

    // Mostrar los datos obtenidos
    echo "Fecha de búsqueda: " . $fechaBusqueda . "\n";
    echo "Fecha SUNAT: " . $fechaSunat . "\n";
    echo "Tipo de cambio (venta): " . $venta . "\n";
    echo "Tipo de cambio (compra): " . $compra . "\n";
    echo "Origen de datos: " . $origen . "\n";
    echo "Moneda: " . $moneda . "\n";
} else {
    // Manejar errores o respuestas no exitosas
    echo "Error: No se pudo obtener la información correctamente.\n";
    if (isset($data['message'])) {
        echo "Mensaje de la API: " . $data['message'] . "\n";
    }
}
?>