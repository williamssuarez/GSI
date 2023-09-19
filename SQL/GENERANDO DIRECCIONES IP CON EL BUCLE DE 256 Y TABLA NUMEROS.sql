-- Crea una tabla para almacenar las direcciones IP con una columna de ID autoincremental
CREATE TABLE direcciones_ip (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ip VARCHAR(15)
);

-- Genera e inserta las direcciones IP
INSERT INTO direcciones_ip (ip)
SELECT CONCAT('192.9.', n1.numero, '.', n2.numero)
FROM numeros AS n1
CROSS JOIN numeros AS n2;

-- Elimina la tabla de números si ya no la necesitas
DROP TABLE numeros;
