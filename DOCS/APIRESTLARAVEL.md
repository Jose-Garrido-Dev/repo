# 📦 Guía Paso a Paso – API CRUD “Categorías & Productos” con **Laravel 10**

> Documento pensado para que puedas **replicar el proyecto en vivo durante una entrevista técnica**  
> (o contarlo en detalle ante preguntas de arquitectura, comandos y buenas prácticas).

---

## 0. Stack y versiones claves  

| Herramienta | Versión recomendada | Notas |
|-------------|--------------------|-------|
| PHP         | ≥ 8.2              | Requiere ext-pdo_mysql, mbstring, openssl… |
| Composer    | ≥ 2.x              | Instalación global |
| Laravel CLI | opcional (`laravel new`) | Se puede usar `composer create-project` |
| DB          | MySQL 8 / MariaDB 10 | o cualquier driver PDO soportado |
| PHPUnit     | ^10 (dev-dependencia) | Para tests automáticos |

---

## 1. Crear el proyecto desde cero

```bash
# 1.1  Proyecto limpio
composer create-project laravel/laravel laravel-products-api "10.*"
cd laravel-products-api

# 1.2  Variables de entorno
cp .env.example .env
php artisan key:generate
# -> editar .env: DB_DATABASE, DB_USERNAME, DB_PASSWORD
```

---

## 2. Dominios de negocio

| Entidad     | Campos principales                       | Relación           |
|-------------|------------------------------------------|--------------------|
| **Category**| id, name, description, timestamps        | 1 :N → Products    |
| **Product** | id, category_id, name, description, price, stock, timestamps | N :1 ← Category |

---

## 3. Modelos, migraciones y factories

```bash
php artisan make:model Category -m -f
php artisan make:model Product  -m -f
```

### 3.1  Migraciones

\`\`\`php
Schema::create('categories', function (Blueprint $table) {
    $table->id();
    $table->string('name')->unique();
    $table->text('description')->nullable();
    $table->timestamps();
});
\`\`\`

\`\`\`php
Schema::create('products', function (Blueprint $table) {
    $table->id();
    $table->foreignId('category_id')->constrained()->cascadeOnDelete();
    $table->string('name');
    $table->text('description')->nullable();
    $table->decimal('price', 10, 2);
    $table->unsignedInteger('stock')->default(0);
    $table->timestamps();
});
\`\`\`

### 3.2  Modelos con relaciones

\`\`\`php
class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
\`\`\`

\`\`\`php
class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'name', 'description', 'price', 'stock',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
\`\`\`

### 3.3  Factories (datos dummy)

\`\`\`php
public function definition(): array
{
    return [
        'name'        => ucfirst($this->faker->unique()->word),
        'description' => $this->faker->sentence,
    ];
}
\`\`\`

\`\`\`php
public function definition(): array
{
    return [
        'category_id' => Category::factory(),
        'name'        => $this->faker->words(3, true),
        'description' => $this->faker->sentence,
        'price'       => $this->faker->randomFloat(2, 1, 999),
        'stock'       => $this->faker->numberBetween(0, 200),
    ];
}
\`\`\`

---

## 4. Seeders de ejemplo

\`\`\`php
public function run(): void
{
    Category::factory()
        ->count(5)           // 5 categorías
        ->hasProducts(20)    // 20 productos por categoría
        ->create();
}
\`\`\`

**Ejecutar migraciones + semilla**

```bash
php artisan migrate:fresh --seed
```

---

## 5. Controladores API

```bash
php artisan make:controller API/CategoryController --api
php artisan make:controller API/ProductController  --api
```

### 5.1  `CategoryController`

\`\`\`php
class CategoryController extends Controller
{
    public function index()
    {
        return Category::withCount('products')->paginate(10);
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'name' => 'required|string|max:120|unique:categories',
            'description' => 'nullable|string',
        ]);
        return Category::create($data);
    }

    public function show(Category $category)
    {
        return $category->load('products');
    }

    public function update(Request $r, Category $category)
    {
        $data = $r->validate([
            'name' => 'sometimes|required|string|max:120|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
        ]);
        $category->update($data);
        return $category->fresh();
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return response()->noContent();
    }
}
\`\`\`

### 5.2  `ProductController`

\`\`\`php
class ProductController extends Controller
{
    public function index(Request $r)
    {
        $q = Product::with('category');
        if ($r->filled('category_id')) {
            $q->where('category_id', $r->category_id);
        }
        return $q->paginate(10);
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:120',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
        ]);
        return Product::create($data);
    }

    public function show(Product $product)
    {
        return $product->load('category');
    }

    public function update(Request $r, Product $product)
    {
        $data = $r->validate([
            'category_id' => 'sometimes|exists:categories,id',
            'name'        => 'sometimes|required|string|max:120',
            'description' => 'nullable|string',
            'price'       => 'sometimes|required|numeric|min:0',
            'stock'       => 'sometimes|required|integer|min:0',
        ]);
        $product->update($data);
        return $product->fresh();
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return response()->noContent();
    }
}
\`\`\`

---

## 6. Rutas (`routes/api.php`)

\`\`\`php
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ProductController;

Route::apiResource('categories', CategoryController::class);
Route::apiResource('products',   ProductController::class);

// ➜ Para proteger con JWT:
// Route::middleware('auth:api')->group(function () { … });
\`\`\`

---

## 7. Correr la API

```bash
php artisan serve       # http://127.0.0.1:8000
```

**Prueba rápida:**

```bash
curl -X POST http://127.0.0.1:8000/api/categories   -H "Content-Type: application/json"   -d '{"name":"Audio","description":"Parlantes y auriculares"}'
```

---

## 8. Tests de integración (opcional)

\`\`\`bash
composer require --dev phpunit/phpunit
php artisan make:test ProductApiTest
\`\`\`

\`\`\`php
class ProductApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_lifecycle(): void
    {
        $cat = Category::factory()->create();

        // crear
        $product = $this->postJson('/api/products', [
            'category_id' => $cat->id,
            'name'        => 'Mouse óptico',
            'price'       => 19.99,
            'stock'       => 50,
        ])->assertCreated()->json();

        // leer
        $this->getJson('/api/products/'.$product['id'])
             ->assertOk()
             ->assertJsonPath('name', 'Mouse óptico');

        // actualizar
        $this->putJson('/api/products/'.$product['id'], [
            'stock' => 45,
        ])->assertOk()->assertJsonPath('stock', 45);

        // eliminar
        $this->deleteJson('/api/products/'.$product['id'])
             ->assertNoContent();

        $this->getJson('/api/products/'.$product['id'])
             ->assertNotFound();
    }
}
\`\`\`

```bash
php artisan test
```

---

## 9. Integrar JWT (rápido)

1. `composer require php-open-source-saver/jwt-auth`  
2. `php artisan vendor:publish --provider="PHPOpenSourceSaver\JWTAuth\Providers\LaravelServiceProvider"`  
3. `php artisan jwt:secret`  
4. Edita `config/auth.php` → guard `api` con driver `jwt`.  
5. Envuelve rutas CRUD con `middleware('auth:api')`.  
6. Crea `AuthController` (login, refresh, logout).

---

## 10. Checklist de entrevista

| Ítem                           | ¿Incluido? |
|--------------------------------|------------|
| Migraciones limpias            | ✅ |
| Eloquent relationships         | ✅ |
| Validación de entrada          | ✅ |
| Paginación + filtro            | ✅ |
| Factories + seeders            | ✅ |
| Tests automáticos              | ✅ |
| Lista de comandos artisan      | ✅ |
| Paso a JWT                     | ✅ |

---

## 11. Licencia

MIT © 2025 – Tu Nombre
