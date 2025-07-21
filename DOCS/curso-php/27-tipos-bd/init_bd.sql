-- 1️⃣ Crea la base de datos con codificación UTF-8
CREATE DATABASE php-tipos-bd
  CHARACTER SET utf8mb4            -- Soporta emojis y todos los caracteres
  COLLATE utf8mb4_general_ci;      -- Intercalación

-- 2️⃣ Selecciona la BD para las siguientes órdenes
USE ejemplo_crud;

-- 3️⃣ Crea la tabla `users`
CREATE TABLE users (
  id       INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,  -- PK autoincremental
  username VARCHAR(50)  NOT NULL UNIQUE,             -- Usuario único
  passhash VARCHAR(255) NOT NULL,                    -- Hash de la contraseña
  role     ENUM('admin','user') DEFAULT 'user'       -- Rol predeterminado
);

-- 4️⃣ Inserta un usuario de prueba (clave = admin123)
INSERT INTO users (username, passhash, role)
VALUES (
  'admin',
  '$2y$10$5DrWxUuUUKHuqKRV6YuJwOjQR7ZMVnAP54N6HbRzU9cX.eC042jn2',
  'admin'
);