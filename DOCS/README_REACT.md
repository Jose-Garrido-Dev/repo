# ⚛️ Guía Front‑End React – Consumo de API REST “Categorías & Productos”

> Paso a paso para levantar un **frontend React 18 + Vite** que consuma la API Laravel creada anteriormente, usando **Hooks**, **formularios** y buenas prácticas modernas.

---

## 0. Prerrequisitos

| Herramienta | Versión recomendada | Notas |
|-------------|--------------------|-------|
| Node.js     | ≥ 18.x             | Incluye npm 9 o +yarn 1/berry/pnpm |
| Vite CLI    | ≥ 5.x              | `npm create vite@latest` |
| React       | 18.x               | Incluido por Vite plantilla |
| Axios       | 1.x                | Cliente HTTP (o usa `fetch`) |
| React Hook Form | 7.x           | Manejo rápido de formularios |
| React Query | ^5 (opcional)      | Caché de datos y deduplicación |

---

## 1. Crear el proyecto

```bash
# 1.1  Bootstrap con Vite + TS
npm create vite@latest react-products -- --template react-ts
cd react-products

# 1.2  Instalar dependencias utilitarias
npm i axios @tanstack/react-query react-hook-form

# 1.3  (Dev) ESLint + Prettier + Testing Library
npm i -D eslint prettier eslint-config-prettier @testing-library/react @testing-library/jest-dom
```

Configura `.env` (prefijo **VITE_**):

```ini
VITE_API_URL=http://localhost:8000/api
```

---

## 2. Estructura sugerida

```
src/
 ├─ api/              # capa de acceso remoto
 │   └─ client.ts
 ├─ hooks/            # custom hooks reusables
 │   ├─ useCategories.ts
 │   └─ useProducts.ts
 ├─ components/
 │   ├─ CategoryList.tsx
 │   ├─ ProductList.tsx
 │   └─ ProductForm.tsx
 ├─ pages/
 │   └─ Dashboard.tsx
 ├─ App.tsx
 └─ main.tsx
```

---

## 3. Capa **API**

### 3.1  Cliente Axios centralizado

```ts
// src/api/client.ts
import axios from 'axios';

export const api = axios.create({
  baseURL: import.meta.env.VITE_API_URL,
  headers: { 'Content-Type': 'application/json' },
});

// Interceptores para auth, logs, errores globales…
api.interceptors.response.use(
  (r) => r,
  (err) => {
    console.error(err.response?.data || err.message);
    return Promise.reject(err);
  }
);
```

### 3.2  Endpoints (ejemplo)

```ts
// src/api/products.ts
import { api } from './client';

export interface Product {
  id: number;
  category_id: number;
  name: string;
  description?: string;
  price: number;
  stock: number;
}

export const getProducts = (categoryId?: number) =>
  api.get<Product[]>('/products', { params: { category_id: categoryId } });

export const createProduct = (data: Omit<Product, 'id'>) =>
  api.post<Product>('/products', data);
```

---

## 4. **React Query** + Hooks

```ts
// src/hooks/useProducts.ts
import { useQuery, useMutation, useQueryClient } from '@tanstack/react-query';
import { getProducts, createProduct } from '../api/products';

export function useProducts(categoryId?: number) {
  return useQuery({
    queryKey: ['products', categoryId],
    queryFn: () => getProducts(categoryId).then((r) => r.data),
  });
}

export function useCreateProduct() {
  const qc = useQueryClient();
  return useMutation({
    mutationFn: createProduct,
    onSuccess: () => qc.invalidateQueries({ queryKey: ['products'] }),
  });
}
```

En `main.tsx` envuelve tu app:

```tsx
import { QueryClient, QueryClientProvider } from '@tanstack/react-query';
const client = new QueryClient();

<React.StrictMode>
  <QueryClientProvider client={client}>
    <App />
  </QueryClientProvider>
</React.StrictMode>
```

---

## 5. Formularios con **React Hook Form**

```tsx
// src/components/ProductForm.tsx
import { useForm } from 'react-hook-form';
import { useCreateProduct } from '../hooks/useProducts';
import { Product } from '../api/products';

type FormInput = Omit<Product, 'id'>;

export const ProductForm = () => {
  const { register, handleSubmit, reset } = useForm<FormInput>();
  const { mutate, isPending } = useCreateProduct();

  const onSubmit = (data: FormInput) => {
    mutate(data, {
      onSuccess: () => reset(),
    });
  };

  return (
    <form onSubmit={handleSubmit(onSubmit)} className="card p-4 space-y-2">
      <input {...register('name', { required: true })} placeholder="Nombre" />
      <input type="number" step="0.01" {...register('price', { valueAsNumber: true })} placeholder="Precio" />
      <input type="number" {...register('stock', { valueAsNumber: true })} placeholder="Stock" />
      <select {...register('category_id', { valueAsNumber: true })}>
        {/* opciones de categorías … */}
      </select>
      <button disabled={isPending}>Guardar</button>
    </form>
  );
};
```

---

## 6. Componentes de listado

```tsx
// src/components/ProductList.tsx
import { useProducts } from '../hooks/useProducts';

export const ProductList = () => {
  const { data, isLoading, error } = useProducts();

  if (isLoading) return <p>Cargando…</p>;
  if (error) return <p>Error al cargar productos</p>;

  return (
    <ul className="divide-y">
      {data!.map((p) => (
        <li key={p.id} className="flex justify-between py-2">
          <span>{p.name}</span>
          <span>${p.price.toFixed(2)}</span>
        </li>
      ))}
    </ul>
  );
};
```

---

## 7. Rutas y página principal

```tsx
// src/pages/Dashboard.tsx
import { ProductForm } from '../components/ProductForm';
import { ProductList } from '../components/ProductList';

export default function Dashboard() {
  return (
    <div className="grid md:grid-cols-2 gap-8 p-6">
      <section>
        <h2 className="text-xl font-bold mb-2">Nuevo producto</h2>
        <ProductForm />
      </section>
      <section>
        <h2 className="text-xl font-bold mb-2">Inventario</h2>
        <ProductList />
      </section>
    </div>
  );
}
```

En `App.tsx` usa React Router (opcional) o renderiza `Dashboard` directamente.

---

## 8. Manejo de errores globales

```tsx
// Ejemplo quick & dirty con toast
import { toast } from 'react-hot-toast';
api.interceptors.response.use(
  (r) => r,
  (err) => {
    toast.error(err.response?.data?.message ?? err.message);
    return Promise.reject(err);
  }
);
```

---

## 9. Tests con **Jest + Testing Library**

```tsx
// src/__tests__/ProductList.test.tsx
import { render, screen } from '@testing-library/react';
import { QueryClient, QueryClientProvider } from '@tanstack/react-query';
import { rest } from 'msw';
import { setupServer } from 'msw/node';
import { ProductList } from '../components/ProductList';

const server = setupServer(
  rest.get('http://localhost:8000/api/products', (_, res, ctx) =>
    res(ctx.json([{ id: 1, name: 'Teclado', price: 50, stock: 10, category_id: 1 }]))
  )
);

beforeAll(() => server.listen());
afterEach(() => server.resetHandlers());
afterAll(() => server.close());

test('muestra productos', async () => {
  const qc = new QueryClient();
  render(
    <QueryClientProvider client={qc}>
      <ProductList />
    </QueryClientProvider>
  );
  expect(await screen.findByText(/Teclado/i)).toBeInTheDocument();
});
```

---

## 10. Build y despliegue

```bash
npm run build          # genera dist/
# Ejemplo Netlify:
netlify deploy --dir=dist --prod
```

> Asegúrate de añadir la variable `VITE_API_URL` en el entorno de tu hosting.

---

## 11. Checklist para la entrevista

| Tema que pueden preguntar          | Ya cubierto |
|-----------------------------------|-------------|
| useState / useEffect básicos      | ✅ |
| Custom hook para datos            | ✅ (`useProducts`) |
| React Query (caché + refetch)     | ✅ |
| Formularios controlados           | ✅ RHF |
| Validación mínima                 | ✅ |
| Manejo global de errores          | ✅ axios interceptor |
| Variables de entorno (.env)       | ✅ |
| Testing (RTL + MSW)               | ✅ ejemplo |

---

## 12. Recursos extra

* React Query docs – <https://tanstack.com/query/latest>
* React Hook Form – <https://react-hook-form.com>
* Axios interceptors – <https://axios-http.com/docs/interceptors>
* Tailwind CSS (para estilos rápidos) – <https://tailwindcss.com>

---

MIT © 2025 — Tu Nombre
