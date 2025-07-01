<?php
// ─────────────────────────── 1) Conexión a la base de datos ──────────────────────────
require 'db.php';                        // Carga $pdo (objeto PDO) desde db.php

// ─────────────────────────── 2) Carpeta destino ──────────────────────────────────────
$destino = __DIR__ . '/uploads/';        // Ruta absoluta: …/uploads/
if (!is_dir($destino)) {                 // Si la carpeta aún no existe …
    // Crea la carpeta con permisos 0755 (rwx r-x r-x). true = creación recursiva
    if (!mkdir($destino, 0755, true)) {
        die('❌ No pude crear la carpeta de destino: ' . $destino);
    }
}

// ─────────────────────────── 3) Tipos MIME permitidos ────────────────────────────────
$permitidos = [
    // Imágenes
    'image/jpeg', 'image/png', 'image/gif', 'image/webp',
    // Documentos
    'application/pdf',
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document', // DOCX
    'application/vnd.ms-excel',                                                // XLS
    // Vídeo
    'video/mp4', 'video/quicktime',                                            // MP4, MOV
];

// ─────────────────────────── 4) Límite de tamaño ─────────────────────────────────────
$maxBytes = 2 * 1024 * 1024 * 1024; // 2 GB (en bytes)

// ─────────────────────────── 5) Recorremos todos los archivos subidos ───────────────
foreach ($_FILES['ficheros']['error'] as $i => $error) {

    // 5-a) Comprobamos si hubo error en la subida
    if ($error !== UPLOAD_ERR_OK) {
        echo "Error en fichero $i: $error<br>";
        continue;                         // Pasa al siguiente archivo
    }

    // 5-b) Variables de cada archivo
    $tmpPath        = $_FILES['ficheros']['tmp_name'][$i]; // ruta temporal
    $nombreOriginal = $_FILES['ficheros']['name'][$i];     // nombre original
    $mime           = mime_content_type($tmpPath);         // MIME real
    $peso           = $_FILES['ficheros']['size'][$i];     // tamaño en bytes

    // 5-c) Validaciones de tipo y tamaño
    if (!in_array($mime, $permitidos)) {
        echo "Tipo no permitido: $nombreOriginal ($mime)<br>";
        continue;
    }
    if ($peso > $maxBytes) {
        echo "Archivo demasiado grande: $nombreOriginal<br>";
        continue;
    }

    // 5-d) Renombrado seguro (hash aleatorio + extensión)
    $extension     = pathinfo($nombreOriginal, PATHINFO_EXTENSION);
    $nombreSistema = bin2hex(random_bytes(16)) . '.' . $extension;

    // 5-e) Mover el archivo desde tmp → carpeta final
    if (!move_uploaded_file($tmpPath, $destino . $nombreSistema)) {
        echo "Falló mover archivo $nombreOriginal<br>";
        continue;
    }

    // 5-f) Registrar metadatos en la base de datos
    $stmt = $pdo->prepare(
        'INSERT INTO archivos (nombre_ori, nombre_sys, mime, peso, ruta)
         VALUES (:ori, :sys, :mime, :peso, :ruta)'
    );
    $stmt->execute([
        ':ori'  => $nombreOriginal,
        ':sys'  => $nombreSistema,
        ':mime' => $mime,
        ':peso' => $peso,
        ':ruta' => 'uploads/' . $nombreSistema, // ruta relativa para servir el archivo
    ]);

    // 5-g) Mensaje de éxito
    echo "Subido $nombreOriginal<br>";

    // 5-h) Redirección opcional al formulario (evita recarga doble al refrescar)
    header('Location: index.php');
    exit;  // Importante: termina el script después de redirigir
}
