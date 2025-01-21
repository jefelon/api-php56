<?php
// URL de la API
$token = "7256|KYdMEURxaugN4gSpBQHett0FUDUytHtCmQLS9MuF"; // esto se obtiene de la cuenta de apis.aqpfact.pe
$url = "https://apis.aqpfact.pe/api/validacion_multiple_cpe";

// Datos que deseas enviar en el cuerpo de la solicitud POST
$data = array(
    'comprobantes' => array(
        array(
            'ruc_emisor' => '20348687191',
            'codigo_tipo_documento' => '01',
            'serie_documento' => 'F001',
            'numero_documento' => 345069,
            'fecha_de_emision' => '2025-01-15',
            'total' => 1801.74
        ),
        array(
            'ruc_emisor' => '20384734091',
            'codigo_tipo_documento' => '03',
            'serie_documento' => 'B002',
            'numero_documento' => 410,
            'fecha_de_emision' => '2021-09-30',
            'total' => 210.00
        )
    )
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
    echo "Solicitud exitosa. Datos recibidos: ";

    // Obtener la cantidad de comprobantes
    $cantidad_de_comprobantes = isset($data['data']['cantidad_de_comprobantes']) ? $data['data']['cantidad_de_comprobantes'] : 0;
    echo "Cantidad de comprobantes: $cantidad_de_comprobantes <br>";

    // Recorrer los comprobantes y mostrar el estado
    foreach ($data['data']['comprobantes'] as $comprobante) {
        $ruc_emisor = $comprobante['ruc_emisor'];
        $codigo_tipo_documento = $comprobante['codigo_tipo_documento'];
        $serie_documento = $comprobante['serie_documento'];
        $numero_documento = $comprobante['numero_documento'];
        $fecha_de_emision = $comprobante['fecha_de_emision'];
        $total = $comprobante['total'];
        $comprobante_estado_codigo = $comprobante['comprobante_estado_codigo'];
        $comprobante_estado_descripcion = $comprobante['comprobante_estado_descripcion'];

        echo "Comprobante: $codigo_tipo_documento $serie_documento-$numero_documento<br>";
        echo "RUC Emisor: $ruc_emisor, Fecha de emisión: $fecha_de_emision, Total: $total<br>";
        echo "Estado: $comprobante_estado_codigo ($comprobante_estado_descripcion)<br><br>";
    }
} else {
    // Manejar errores o respuestas no exitosas
    echo "Error: No se pudo obtener la información correctamente.";
    if (isset($data['message'])) {
        echo "Mensaje de la API: " . $data['message'];
    }
}
?>
