# 🐬 Chuleta de MySQL
_Referencias rápidas de comandos y consultas habituales (MySQL 8)._

---

## Índice
1. [Conexión y ayuda](#conexión-y-ayuda)
2. [Gestión de bases de datos](#gestión-de-bases-de-datos)
3. [Gestión de tablas](#gestión-de-tablas)
4. [Tipos de datos](#tipos-de-datos)
5. [Consultas SELECT](#consultas-select)
6. [Funciones comunes](#funciones-comunes)
7. [Joins](#joins)
8. [Índices y claves](#índices-y-claves)
9. [Usuarios y privilegios](#usuarios-y-privilegios)
10. [Transacciones](#transacciones)
11. [Exportar / importar](#exportar--importar)
12. [Procedimientos, triggers & views](#procedimientos-triggers--views)

---

## Conexión y ayuda
```bash
mysql -u root -p                         # conectar
mysql -h host -P 3306 -u user -p         # con host/puerto

STATUS;                                  # info de conexión
HELP;                                    # ayuda general
HELP SELECT;                             # ayuda de comando
SOURCE script.sql;                       # ejecutar fichero SQL
```

---

## Gestión de bases de datos
```sql
CREATE DATABASE tienda CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
SHOW DATABASES;
USE tienda;
DROP DATABASE tienda;
ALTER DATABASE tienda CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci;
```

---

## Gestión de tablas
```sql
CREATE TABLE productos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  precio DECIMAL(10,2) DEFAULT 0,
  creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

DESCRIBE productos;          -- estructura
SHOW TABLES;                 -- todas las tablas
ALTER TABLE productos
  ADD COLUMN stock INT DEFAULT 0,
  MODIFY precio DECIMAL(12,2),
  DROP COLUMN stock;

RENAME TABLE productos TO items;
DROP TABLE items;
```

---

## Tipos de datos
| Categoría | Tipo | Comentario |
|-----------|------|------------|
| Numéricos | `INT`, `BIGINT`, `DECIMAL(p,s)`, `FLOAT`, `DOUBLE` | |
| Cadenas   | `VARCHAR(n)`, `CHAR(n)`, `TEXT`, `MEDIUMTEXT`      | |
| Fecha / hora | `DATE`, `DATETIME`, `TIMESTAMP`, `TIME`, `YEAR` | |
| Booleanos | `TINYINT(1)` o `BOOLEAN` (alias de tinyint) | |

---

## Consultas SELECT
```sql
SELECT * FROM productos;
SELECT nombre, precio FROM productos WHERE precio > 10 ORDER BY precio DESC LIMIT 5 OFFSET 10;

-- alias y expresiones
SELECT id, UPPER(nombre) AS mayus, precio*1.19 AS precio_con_iva FROM productos;

-- filtros
SELECT * FROM ventas WHERE fecha BETWEEN '2024-01-01' AND '2024-12-31';
SELECT * FROM clientes WHERE nombre LIKE 'Juan%';

-- group by + having
SELECT cliente_id, SUM(total) AS total_anual
FROM ventas
GROUP BY cliente_id
HAVING total_anual > 1000;
```

---

## Funciones comunes
```sql
-- cadenas
CONCAT(a,b), SUBSTRING(c,1,5), LENGTH(txt), LOWER(), UPPER(), REPLACE()

-- fechas
NOW(), CURDATE(), DATE_ADD(fecha, INTERVAL 7 DAY), DATEDIFF(f2,f1), YEAR()

-- numéricos
ROUND(n,2), CEIL(), FLOOR(), RAND()

-- agregación
COUNT(*), SUM(c), AVG(c), MIN(), MAX()
```

---

## Joins
```sql
-- inner
SELECT p.*, c.nombre
FROM productos p
JOIN categorias c ON c.id = p.categoria_id;

-- left
SELECT c.*, p.nombre
FROM categorias c
LEFT JOIN productos p ON p.categoria_id = c.id;

-- self join
SELECT e1.nombre AS jefe, e2.nombre AS empleado
FROM empleados e1
JOIN empleados e2 ON e1.id = e2.jefe_id;
```

---

## Índices y claves
```sql
-- clave primaria compuesta
ALTER TABLE ventas ADD PRIMARY KEY (id, linea);

-- clave foránea
ALTER TABLE productos
  ADD CONSTRAINT fk_cat
  FOREIGN KEY (categoria_id) REFERENCES categorias(id)
  ON DELETE CASCADE;

-- índice simple/único
CREATE INDEX idx_precio ON productos(precio);
CREATE UNIQUE INDEX idx_email ON clientes(email);
```

---

## Usuarios y privilegios
```sql
CREATE USER 'app'@'localhost' IDENTIFIED BY 'secret';
GRANT SELECT, INSERT, UPDATE ON tienda.* TO 'app'@'localhost';
FLUSH PRIVILEGES;

-- ver permisos
SHOW GRANTS FOR 'app'@'localhost';
ALTER USER 'app'@'localhost' IDENTIFIED BY 'newpass';
DROP USER 'app'@'localhost';
```

---

## Transacciones
```sql
START TRANSACTION;
UPDATE cuentas SET saldo = saldo - 100 WHERE id = 1;
UPDATE cuentas SET saldo = saldo + 100 WHERE id = 2;
COMMIT;        -- o ROLLBACK;
```

---

## Exportar / importar
```bash
# dump completo
mysqldump -u root -p tienda > tienda.sql

# sólo estructura
mysqldump -u root -p --no-data tienda > schema.sql

# importar
mysql -u root -p tienda < tienda.sql
```

---

## Procedimientos, triggers & views
```sql
-- procedimiento almacenado
DELIMITER //
CREATE PROCEDURE top_clientes(IN limite INT)
BEGIN
  SELECT nombre, total FROM clientes ORDER BY total DESC LIMIT limite;
END//
DELIMITER ;

CALL top_clientes(10);

-- trigger
CREATE TRIGGER tg_upd BEFORE UPDATE ON productos
FOR EACH ROW SET NEW.actualizado_en = NOW();

-- vista
CREATE VIEW v_productos_caros AS
SELECT * FROM productos WHERE precio > 1000;
```

---

> **Tip:** Ejecuta `SHOW ENGINE INNODB STATUS\G` para diagnosticar bloqueos y claves foráneas.

Fin de la chuleta. ¡A codificar! 🛠️
