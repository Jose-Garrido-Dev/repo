# Crear bd

CREATE TABLE archivos (
    id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre_ori  VARCHAR(255),
    nombre_sys  VARCHAR(255),
    mime        VARCHAR(100),
    peso        BIGINT,
    ruta        VARCHAR(255),
    subido_en   DATETIME DEFAULT CURRENT_TIMESTAMP
);