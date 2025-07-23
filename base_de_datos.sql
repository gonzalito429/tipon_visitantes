-- Crear la base de datos
CREATE DATABASE tipon_db;

-- Conectarse a la base
\c tipon_db;

-- Crear tabla de usuarios
CREATE TABLE usuarios (
    id SERIAL PRIMARY KEY,
    username TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL
);

-- Usuario por defecto
INSERT INTO usuarios (username, password) VALUES ('admin', 'a654321');

-- Crear tabla de visitantes
CREATE TABLE visitantes (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    dni CHAR(8) NOT NULL,
    fecha DATE NOT NULL,
    hora_entrada TIME,
    hora_salida TIME,
);

-- Función: total visitantes por día
CREATE OR REPLACE FUNCTION total_visitantes_por_dia(fecha_consulta DATE)
RETURNS INTEGER AS $$
DECLARE
    cantidad INTEGER;
BEGIN
    SELECT COUNT(*) INTO cantidad FROM visitantes WHERE fecha = fecha_consulta;
    RETURN cantidad;
END;
$$ LANGUAGE plpgsql;

-- Procedimiento: insertar visitante (verifica duplicado)
CREATE OR REPLACE PROCEDURE registrar_visitante(nombre TEXT, dni CHAR(8), fecha DATE, hora TIME)
LANGUAGE plpgsql AS $$
BEGIN
    IF NOT EXISTS (
        SELECT 1 FROM visitantes WHERE dni = registrar_visitante.dni AND fecha = registrar_visitante.fecha
    ) THEN
        INSERT INTO visitantes(nombre, dni, fecha, hora_entrada)
        VALUES (registrar_visitante.nombre, registrar_visitante.dni, registrar_visitante.fecha, registrar_visitante.hora);
    END IF;
END;
$$;

-- Cursor: listar visitantes por día
CREATE OR REPLACE FUNCTION visitantes_por_dia_cursor(fecha_objetivo DATE)
RETURNS VOID AS $$
DECLARE
    reg RECORD;
    cur CURSOR FOR SELECT * FROM visitantes WHERE fecha = fecha_objetivo;
BEGIN
    OPEN cur;
    LOOP
        FETCH cur INTO reg;
        EXIT WHEN NOT FOUND;
        RAISE NOTICE 'Visitante: %, DNI: %', reg.nombre, reg.dni;
    END LOOP;
    CLOSE cur;
END;
$$ LANGUAGE plpgsql;

-- Trigger: registra observación cuando un visitante no registra salida
CREATE OR REPLACE FUNCTION marcar_sin_salida()
RETURNS TRIGGER AS $$
BEGIN
    IF NEW.hora_salida IS NULL THEN
        NEW.observaciones := 'NO REGISTRÓ SALIDA';
    END IF;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trg_sin_salida
BEFORE INSERT ON visitantes
FOR EACH ROW
EXECUTE FUNCTION marcar_sin_salida();