<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Subir archivos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
  <h1 class="mb-4">Cargar archivos</h1>

  <form action="upload.php" method="POST" enctype="multipart/form-data"
        class="border rounded-3 p-4 bg-white shadow-sm">
    <div class="mb-3">
      <label class="form-label">Selecciona uno o varios archivos</label>
      <input class="form-control" type="file" name="ficheros[]" multiple required>
    </div>

    <button class="btn btn-primary">Subir</button>
    <a href="listar.php" class="btn btn-outline-secondary">Ver archivos</a>
  </form>
</div>
</body>
</html>
