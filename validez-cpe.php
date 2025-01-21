<?php
// URL de la API
$token = "7256|KYdMEURxaugN4gSpBQHett0FUDUytHtCmQLS9MuF"; // esto se obtiene de la cuenta de apis.aqpfact.pe
$url = "https://apis.aqpfact.pe/api/cpe";

// Datos que deseas enviar en el cuerpo de la solicitud POST
$data = array(
    'ruc_emisor' => '20384734091',
    'codigo_tipo_documento' => '03',
    'serie_documento' => 'B002',
    'numero_documento' => '409',
    'fecha_de_emision' => '2021-09-30',
    'total' => '210.00'
);

// Convertir los datos a formato JSON
$jsonData = json_encode($data);

// Configuración de contexto HTTP para la solicitud POST
$options = array(
    "http" => array(
        "method" => "POST", // Método HTTP
        "header" => "Content-Type: application/json\r\n" .
            "Authorization: Bearer $token\r\n" .
            "Content-Length: " . strlen($jsonData) . "\r\n", // Asegúrate de enviar el tamaño del contenido
        "content" => $jsonData // Enviar el cuerpo de la solicitud en formato JSON
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
    // Procesar los datos recibidos
    echo "Solicitud exitosa. Estado del comprobante: ";
    $comprobante_estado_codigo = isset($data['data']['comprobante_estado_codigo']) ? $data['data']['comprobante_estado_codigo'] : "Desconocido";
    $comprobante_estado_descripcion = isset($data['data']['comprobante_estado_descripcion']) ? $data['data']['comprobante_estado_descripcion'] : "Desconocido";

    echo "Código: $comprobante_estado_codigo, Descripción: $comprobante_estado_descripcion";
} else {
    // Manejar errores o respuestas no exitosas
    echo "Error: No se pudo obtener la información correctamente.";
    if (isset($data['message'])) {
        echo "Mensaje de la API: " . $data['message'];
    }
}
?>
