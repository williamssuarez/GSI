ALTER TABLE direcciones_asignadas
ADD FOREIGN KEY (equipo)
REFERENCES equipos (id_equipo)
