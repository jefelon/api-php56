<?php
// URL de la API con los parámetros necesarios
$token = "7256|KYdMEURxaugN4gSpBQHett0FUDUytHtCmQLS9MuF"; // esto se obtiene de la cuenta de apis.aqpfact.pe
$dni = "27427864";
$url = "https://apis.aqpfact.pe/api/dni/$dni";

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
    $numero = isset($data['data']['numero']) ? $data['data']['numero'] : "No disponible";
    $nombres = isset($data['data']['nombres']) ? $data['data']['nombres'] : "No disponible";
    $nombreCompleto = isset($data['data']['nombre_completo']) ? $data['data']['nombre_completo'] : "No disponible";
    $apellidoPaterno = isset($data['data']['apellido_paterno']) ? $data['data']['apellido_paterno'] : "No disponible";
    $apellidoMaterno = isset($data['data']['apellido_materno']) ? $data['data']['apellido_materno'] : "No disponible";


    // Mostrar los datos obtenidos
    echo "Número de documento: " . $numero . "\n";
    echo "Nombres: " . $nombres . "\n";
    echo "Apellido paterno: " . $apellidoPaterno . "\n";
    echo "Apellido materno: " . $apellidoMaterno . "\n";
    echo "Nombre completo: " . $nombreCompleto . "\n";
} else {
    // Manejar errores o respuestas no exitosas
    echo "Error: No se pudo obtener la información correctamente.\n";
    if (isset($data['message'])) {
        echo "Mensaje de la API: " . $data['message'] . "\n";
    }
}
?>
