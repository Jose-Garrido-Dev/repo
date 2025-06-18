# Pruebas unitarias y de integración en Laravel 10  
_Añade calidad y confianza a tu API_

---

## 1️⃣ ¿Qué vamos a probar?

El CRUD de **Tareas** (`TaskController`).  
Comprobaremos que:

| Caso | Método HTTP | Respuesta esperada |
|------|-------------|--------------------|
| Crear tarea           | `POST /api/tasks` | **201** y JSON con la tarea |
| Listar tareas         | `GET /api/tasks`  | **200** y JSON array        |
| Mostrar tarea         | `GET /api/tasks/{id}` | **200** y tarea concreta |
| Actualizar tarea      | `PUT /api/tasks/{id}` | **200** y cambios reflejados |
| Eliminar tarea        | `DELETE /api/tasks/{id}` | **204** (sin contenido)  |

---

## 2️⃣ Preparar el entorno de tests

1. **Base de datos en memoria** – en `phpunit.xml` cambia la conexión:

```xml
<server name="DB_CONNECTION" value="sqlite"/>
<server name="DB_DATABASE"   value=":memory:"/>
```

2. **Trait RefreshDatabase**  
   Cada prueba arranca con migraciones limpias.

---

## 3️⃣ Crear el archivo de prueba

```bash
php artisan make:test TaskTest --unit
```

> Usaremos **Feature** en lugar de Unit para abarcar HTTP + BD.

Cambia la ubicación a `tests/Feature/TaskTest.php` y pega:

```php
<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function puede_crear_una_tarea()
    {
        $payload = ['title' => 'Primera tarea'];

        $this->postJson('/api/tasks', $payload)
             ->assertCreated()
             ->assertJsonFragment($payload);

        $this->assertDatabaseHas('tasks', $payload);
    }

    /** @test */
    public function lista_todas_las_tareas()
    {
        Task::factory()->count(3)->create();

        $this->getJson('/api/tasks')
             ->assertOk()
             ->assertJsonCount(3);
    }

    /** @test */
    public function muestra_una_tarea_por_id()
    {
        $task = Task::factory()->create();

        $this->getJson("/api/tasks/{$task->id}")
             ->assertOk()
             ->assertJson(['id' => $task->id]);
    }

    /** @test */
    public function actualiza_una_tarea()
    {
        $task = Task::factory()->create();

        $this->putJson("/api/tasks/{$task->id}", ['completed' => true])
             ->assertOk()
             ->assertJson(['completed' => true]);

        $this->assertDatabaseHas('tasks', [
            'id'        => $task->id,
            'completed' => true,
        ]);
    }

    /** @test */
    public function elimina_una_tarea()
    {
        $task = Task::factory()->create();

        $this->deleteJson("/api/tasks/{$task->id}")
             ->assertNoContent();

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
```

---

## 4️⃣ Factoría para `Task`

```bash
php artisan make:factory TaskFactory --model=Task
```

`database/factories/TaskFactory.php`

```php
public function definition(): array
{
    return [
        'title'     => fake()->sentence(3),
        'completed' => fake()->boolean(),
    ];
}
```

---

## 5️⃣ Ejecución

```bash
./vendor/bin/phpunit        # o  php artisan test
```

Deberías ver algo como:

```
PASS  Tests\Feature\TaskTest
✓ puede_crear_una_tarea
✓ lista_todas_las_tareas
✓ muestra_una_tarea_por_id
✓ actualiza_una_tarea
✓ elimina_una_tarea
```

---

## 6️⃣ Consejos extra

| Tip | Descripción |
|-----|-------------|
| **Pestañas de cobertura** | `php artisan test --coverage` (+Xdebug) |
| **Pruebas con autenticación** | Usa método `actingAs()` con un usuario |
| **Datos aleatorios** | `faker()` produce títulos variados |
| **CI/CD** | Añade `php artisan test` en tu pipeline (GitHub Actions, GitLab CI…) |

¡Listo! Ahora tu API cuenta con un conjunto básico de pruebas que puedes ampliar con validaciones, paginación o control de errores.
