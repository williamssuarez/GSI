-- Actualizar las primeras 1,340 direcciones IP que aún no tienen asignado un departamento (ID de departamento nulo) con el ID del departamento deseado (por ejemplo, 1 para el primer departamento)

-- TECNOLOGIA Y SISTEMAS
UPDATE direccion_ip
SET id_departamento = 26
WHERE id_ip <= 1698;

-- BIENES
UPDATE direccion_ip
SET id_departamento = 1
WHERE id_ip <= 3038 AND id_departamento IS NULL;

-- RADIO MUNICIPAL
UPDATE direccion_ip
SET id_departamento = 3
WHERE id_ip <= 4378 AND id_departamento IS NULL;

-- AUDITORIA INTERNA
UPDATE direccion_ip
SET id_departamento = 4
WHERE id_ip <= 5718 AND id_departamento IS NULL;

-- PRESUPUESTO
UPDATE direccion_ip
SET id_departamento = 5
WHERE id_ip <= 7058 AND id_departamento IS NULL;

-- TESORERIA
UPDATE direccion_ip
SET id_departamento = 6
WHERE id_ip <= 8398 AND id_departamento IS NULL;

-- CATASTRO DIRECCION
UPDATE direccion_ip
SET id_departamento = 8
WHERE id_ip <= 9738 AND id_departamento IS NULL;

-- CATASTRO JURIDICO
UPDATE direccion_ip
SET id_departamento = 9
WHERE id_ip <= 11078 AND id_departamento IS NULL;

-- CATASTRO ECONOMICO
UPDATE direccion_ip
SET id_departamento = 10
WHERE id_ip <= 12418  AND id_departamento IS NULL;

-- CATASTRO ATENCION
UPDATE direccion_ip
SET id_departamento = 11
WHERE id_ip <= 13758 AND id_departamento IS NULL;

-- CATASTRO FISICO
UPDATE direccion_ip
SET id_departamento = 12
WHERE id_ip <= 15098 AND id_departamento IS NULL;

-- SALA POLITICA
UPDATE direccion_ip
SET id_departamento = 13
WHERE id_ip <= 16438 AND id_departamento IS NULL;

-- SINDICATO DE EMPLEADOS
UPDATE direccion_ip
SET id_departamento = 14
WHERE id_ip <= 17778 AND id_departamento IS NULL;

-- GESTION SOCIAL
UPDATE direccion_ip
SET id_departamento = 15
WHERE id_ip <= 19118 AND id_departamento IS NULL;

-- RH DIRECCION 
UPDATE direccion_ip
SET id_departamento = 16
WHERE id_ip <= 20458 AND id_departamento IS NULL;

-- RH FONDO DE PROTECCION
UPDATE direccion_ip
SET id_departamento = 17
WHERE id_ip <= 21798 AND id_departamento IS NULL;

-- RH ADMINISTRACION
UPDATE direccion_ip
SET id_departamento = 18
WHERE id_ip <= 23138 AND id_departamento IS NULL;

-- RH NOMINA
UPDATE direccion_ip
SET id_departamento = 19
WHERE id_ip <= 24478 AND id_departamento IS NULL;

-- RH JURIDICO 
UPDATE direccion_ip
SET id_departamento = 20
WHERE id_ip <= 25818 AND id_departamento IS NULL;

-- RH SEGURIDAD LABORAL
UPDATE direccion_ip
SET id_departamento = 21
WHERE id_ip <= 27158 AND id_departamento IS NULL;

-- RH BIOMETRICO
UPDATE direccion_ip
SET id_departamento = 22
WHERE id_ip <= 28498 AND id_departamento IS NULL;

-- INGENIERIA MUNICIPAL
UPDATE direccion_ip
SET id_departamento = 23
WHERE id_ip <= 29838 AND id_departamento IS NULL;

-- CONSTRUGIRARDOT
UPDATE direccion_ip
SET id_departamento = 24
WHERE id_ip <= 31178 AND id_departamento IS NULL;

-- INGENIERIA AMBIENTES
UPDATE direccion_ip
SET id_departamento = 25
WHERE id_ip <= 32518 AND id_departamento IS NULL;

-- SATRIM
UPDATE direccion_ip
SET id_departamento = 27
WHERE id_ip <= 33858 AND id_departamento IS NULL;

-- DESPACHO
UPDATE direccion_ip
SET id_departamento = 29
WHERE id_ip <= 35198 AND id_departamento IS NULL;

-- SINDICATURA
UPDATE direccion_ip
SET id_departamento = 30
WHERE id_ip <= 36538 AND id_departamento IS NULL;

-- RELACIONES PUBLICAS
UPDATE direccion_ip
SET id_departamento = 31
WHERE id_ip <= 37878 AND id_departamento IS NULL;

--  PRENSA
UPDATE direccion_ip
SET id_departamento = 32
WHERE id_ip <= 39218 AND id_departamento IS NULL;

-- ATENCION CIUDADANA
UPDATE direccion_ip
SET id_departamento = 33
WHERE id_ip <= 40558 AND id_departamento IS NULL;

-- ADMINSITRACION
UPDATE direccion_ip
SET id_departamento = 34
WHERE id_ip <= 41898 AND id_departamento IS NULL;

-- COMPRA
UPDATE direccion_ip
SET id_departamento = 35
WHERE id_ip <= 43238 AND id_departamento IS NULL;

-- CATASTRO ARCHIVO
UPDATE direccion_ip
SET id_departamento = 36
WHERE id_ip <= 44578 AND id_departamento IS NULL;

-- SERVICIOS GENERALES
UPDATE direccion_ip
SET id_departamento = 37
WHERE id_ip <= 45918 AND id_departamento IS NULL;


