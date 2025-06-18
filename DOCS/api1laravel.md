# API REST con Laravel 10 + Frontend JS/Bootstrap
Guía paso a paso — lista para clonar en Git ✨

---

## 0️⃣ Qué vamos a construir
* **Back‑end:** API REST con Laravel 10 y CRUD completo del recurso `Tarea`.
* **Front‑end:** Una sola página `index.html` con **Bootstrap 5** y JavaScript puro (`fetch`) que consume la API.

Estructura resultante:

```
.
├─ app/
│  └─ Http/Controllers/API/TaskController.php
├─ database/migrations/2024_…_create_tasks_table.php
├─ public/index.html
└─ README.md   ← este archivo
```

---

## 1️⃣ Requisitos previos

| Herramienta          | Versión mínima | Comprobar con |
|----------------------|---------------|---------------|
| PHP                  | 8.1           | `php -v`      |
| Composer             | 2.x           | `composer -V` |
| Node + npm           | 18 / 9        | `node -v && npm -v` |
| MySQL o MariaDB      | 8.x           | `mysql --version`   |

---

## 2️⃣ Crear y configurar el proyecto

```bash
# 2.1 – Nuevo proyecto Laravel
composer create-project laravel/laravel tasks-api "10.*"
cd tasks-api

# 2.2 – Configurar base de datos
cp .env.example .env
php artisan key:generate
```

Edita `.env`:

```
DB_DATABASE=tasks
DB_USERNAME=root
DB_PASSWORD=secret
```

Crea la BD (por consola o tu cliente):

```sql
CREATE DATABASE tasks CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

---

## 3️⃣ Modelo y migración `Task`

```bash
php artisan make:model Task -m
```

`database/migrations/xxxx_create_tasks_table.php`

```php
Schema::create('tasks', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->boolean('completed')->default(false);
    $table->timestamps();
});
```

Ejecuta:

```bash
php artisan migrate
```

---

## 4️⃣ Controlador API y rutas

```bash
php artisan make:controller API/TaskController --api
```

`app/Http/Controllers/API/TaskController.php`

```php
<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        return Task::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'     => 'required|string|max:255',
            'completed' => 'boolean',
        ]);

        return Task::create($data);
    }

    public function show(Task $task)
    {
        return $task;
    }

    public function update(Request $request, Task $task)
    {
        $data = $request->validate([
            'title'     => 'sometimes|required|string|max:255',
            'completed' => 'boolean',
        ]);

        $task->update($data);

        return $task;
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return response()->noContent();
    }
}
```

Enrolla las rutas en `routes/api.php`:

```php
use App\Http\Controllers\API\TaskController;

Route::apiResource('tasks', TaskController::class);
```

Lanza servidor:

```bash
php artisan serve   # http://localhost:8000
```

---

## 5️⃣ Prueba rápida con cURL

```bash
# Crear
curl -X POST http://localhost:8000/api/tasks      -H "Content-Type: application/json"      -d '{"title":"Aprender Laravel"}'

# Listar
curl http://localhost:8000/api/tasks
```

---

## 6️⃣ Frontend sencillo

Crea `public/index.html`

```html
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Tablero de tareas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
  <h1 class="mb-4">Tareas</h1>

  <!-- Formulario nueva tarea -->
  <div class="input-group mb-3">
    <input id="newTitle" class="form-control" placeholder="Nueva tarea…">
    <button id="addBtn" class="btn btn-primary">Agregar</button>
  </div>

  <!-- Tabla -->
  <table class="table table-striped">
    <thead><tr><th>Hecha</th><th>Título</th><th></th></tr></thead>
    <tbody id="tbody"></tbody>
  </table>

<script>
const API = 'http://localhost:8000/api/tasks';
const tbody   = document.getElementById('tbody');
const addBtn  = document.getElementById('addBtn');
const newTitle= document.getElementById('newTitle');

/* Leer */
async function load() {
  const res = await fetch(API);
  const tasks = await res.json();
  tbody.innerHTML = tasks.map(t => `
    <tr data-id="${t.id}">
      <td><input class="form-check-input toggle" type="checkbox" ${t.completed?'checked':''}></td>
      <td class="${t.completed?'text-decoration-line-through':''}">${t.title}</td>
      <td><button class="btn btn-sm btn-danger delete">🗑️</button></td>
    </tr>
  `).join('');
}
load();

/* Crear */
addBtn.onclick = async () => {
  const title = newTitle.value.trim();
  if (!title) return;
  await fetch(API, {
    method:'POST',
    headers:{'Content-Type':'application/json'},
    body:JSON.stringify({ title })
  });
  newTitle.value='';
  load();
};

/* Actualizar / eliminar */
tbody.onclick = async e => {
  const tr = e.target.closest('tr');
  if(!tr) return;
  const id = tr.dataset.id;

  if (e.target.classList.contains('toggle')) {
    await fetch(\`\${API}/\${id}\`, {
      method:'PUT',
      headers:{'Content-Type':'application/json'},
      body:JSON.stringify({ completed:e.target.checked })
    });
  }
  if (e.target.classList.contains('delete')) {
    if (confirm('¿Eliminar tarea?')) {
      await fetch(\`\${API}/\${id}\`, { method:'DELETE' });
    }
  }
  load();
};
</script>
</body></html>
```

Abre <http://localhost:8000/index.html> y prueba.

---

## 7️⃣ Preparar y subir a Git

```bash
echo "vendor/"       >> .gitignore
echo "node_modules/" >> .gitignore
echo ".env"          >> .gitignore

git init
git add .
git commit -m "API Laravel 10 + Front JS/Bootstrap"
git remote add origin https://github.com/TU_USUARIO/tu-repo.git
git push -u origin main
```

---

## 8️⃣ Extensiones sugeridas

1. **Validación de errores en el front** (alertas Bootstrap).  
2. **Autenticación** (Laravel Sanctum o JWT).  
3. Paginación con `->paginate()` + scroll infinito.  
4. Migrar el front a Vue, React o Alpine para UI más rica.

¡Listo! 🚀
