<?php
// URL de la API con los parámetros necesarios
$token = "7256|KYdMEURxaugN4gSpBQHett0FUDUytHtCmQLS9MuF"; // esto se obtiene de la cuenta de apis.aqpfact.pe
$ruc = "20100190797";
$url = "https://apis.aqpfact.pe/api/ruc/$ruc";

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
    $ruc = isset($data['data']['ruc']) ? $data['data']['ruc'] : "No disponible";
    $razonSocial = isset($data['data']['nombre_o_razon_social']) ? $data['data']['nombre_o_razon_social'] : "No disponible";
    $direccion = isset($data['data']['direccion']) ? $data['data']['direccion'] : "No disponible";
    $direccionCompleta = isset($data['data']['direccion_completa']) ? $data['data']['direccion_completa'] : "No disponible";
    $estado = isset($data['data']['estado']) ? $data['data']['estado'] : "No disponible";
    $condicion = isset($data['data']['condicion']) ? $data['data']['condicion'] : "No disponible";
    $departamento = isset($data['data']['departamento']) ? $data['data']['departamento'] : "No disponible";
    $provincia = isset($data['data']['provincia']) ? $data['data']['provincia'] : "No disponible";
    $distrito = isset($data['data']['distrito']) ? $data['data']['distrito'] : "No disponible";
    $ubigeoSunat = isset($data['data']['ubigeo_sunat']) ? $data['data']['ubigeo_sunat'] : "No disponible";
    $esAgenteDeRetencion = isset($data['data']['es_agente_de_retencion']) ? $data['data']['es_agente_de_retencion'] : "No disponible";
    $esBuenContribuyente = isset($data['data']['es_buen_contribuyente']) ? $data['data']['es_buen_contribuyente'] : "No disponible";

    // Mostrar los datos obtenidos
    echo "RUC: " . $ruc . "\n";
    echo "Razón Social: " . $razonSocial . "\n";
    echo "Dirección: " . $direccion . "\n";
    echo "Dirección Completa: " . $direccionCompleta . "\n";
    echo "Estado: " . $estado . "\n";
    echo "Condición: " . $condicion . "\n";
    echo "Departamento: " . $departamento . "\n";
    echo "Provincia: " . $provincia . "\n";
    echo "Distrito: " . $distrito . "\n";
    echo "Ubigeo SUNAT: " . $ubigeoSunat . "\n";
    echo "¿Es agente de retención?: " . $esAgenteDeRetencion . "\n";
    echo "¿Es buen contribuyente?: " . $esBuenContribuyente . "\n";
} else {
    // Manejar errores o respuestas no exitosas
    echo "Error: No se pudo obtener la información correctamente.\n";
    if (isset($data['message'])) {
        echo "Mensaje de la API: " . $data['message'] . "\n";
    }
}
?>