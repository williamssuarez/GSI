-- OBTENIENDO EL NOMBRE DE LA RESTRICCION PARA ELIMINAR LA RELACION
SELECT constraint_name
FROM information_schema.key_column_usage
WHERE referenced_table_name = 'departamentos' AND table_name = 'equipos_ingresados';

-- ELIMINANDO LA RELACION 
ALTER TABLE equipos_ingresados DROP FOREIGN KEY equipos_ingresados_ibfk_1;

-- ELIMINANDO LA COLUMNA DE LA TABLA
ALTER TABLE equipos_ingresados DROP COLUMN departamento;