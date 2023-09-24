CREATE TABLE dispositivos  (
  id_dispositivos INT AUTO_INCREMENT PRIMARY KEY,
  nombre_dispositivo varchar(70),
  total_asignaciones int NULL
);

CREATE TABLE direccion_ip (
	id_ip INT AUTO_INCREMENT PRIMARY KEY,
	direccion VARCHAR(15),
	id_departamento INT,
	estado INT
);

CREATE TABLE direcciones_asignadas (
	id_asignacion INT AUTO_INCREMENT PRIMARY KEY,
	id_direccion INT, 
	tipo_dispositivo INT,
	fecha_asignada TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL
);

ALTER TABLE direccion_ip
ADD FOREIGN KEY (id_departamento)
REFERENCES departamentos (id_departamento)

ALTER TABLE direcciones_asignadas
ADD FOREIGN KEY (id_direccion)
REFERENCES direccion_ip (id_ip)

ALTER TABLE direcciones_asignadas
ADD FOREIGN KEY (tipo_dispositivo)
REFERENCES dispositivos (id_dispositivos)