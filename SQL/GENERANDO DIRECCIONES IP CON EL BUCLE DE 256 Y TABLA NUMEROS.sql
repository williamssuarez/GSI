-- Genera e inserta las direcciones IP
INSERT INTO direccion_ip (direccion)
SELECT CONCAT('192.9.', n1.numero, '.', n2.numero)
FROM numeros AS n1
CROSS JOIN numeros AS n2;

-- Elimina la tabla de números si ya no la necesitas
DROP TABLE numeros;

-- Elimina las direcciones inferiores a la 192.9.100.1
DELETE FROM direccion_ip WHERE id_ip < 358