<?php
require 'db.php';
$archivos = $pdo->query('SELECT * FROM archivos ORDER BY subido_en DESC')->fetchAll();
$imgMimes  = ['image/jpeg','image/png','image/gif','image/webp'];
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Archivos subidos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
      .file-card img      { object-fit: cover; width:100%; height:120px; }
      .file-icon          { font-size:4rem; }
  </style>
</head>
<body class="bg-light">

<div class="container py-5">
  <h1 class="mb-4">Mis archivos</h1>
  <a href="index.php" class="btn btn-outline-primary mb-4">← Volver a subir</a>

  <div class="row g-4">
    <?php foreach ($archivos as $f): ?>
      <div class="col-12 col-sm-6 col-md-4 col-lg-3">
        <div class="card file-card shadow-sm h-100">
          <?php if (in_array($f['mime'], $imgMimes)): ?>
              <!-- Miniatura de imagen -->
              <img src="<?= htmlspecialchars($f['ruta']) ?>"
                   alt="<?= htmlspecialchars($f['nombre_ori']) ?>">
          <?php else: ?>
              <!-- Icono genérico -->
              <div class="d-flex align-items-center justify-content-center file-icon py-4">
                  📄
              </div>
          <?php endif; ?>

          <div class="card-body p-3 d-flex flex-column">
            <h6 class="card-title text-truncate" title="<?= htmlspecialchars($f['nombre_ori']) ?>">
              <?= htmlspecialchars($f['nombre_ori']) ?>
            </h6>
            <small class="text-muted mb-2">
              <?= round($f['peso']/1048576, 2) ?> MB
            </small>

            <a href="<?= htmlspecialchars($f['ruta']) ?>" download
               class="btn btn-sm btn-outline-primary mt-auto">
              Descargar
            </a>
          </div>
        </div>
      </div>
    <?php endforeach ?>
  </div>
</div>
</body>
</html>
