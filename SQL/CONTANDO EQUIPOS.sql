-- CONTANDO EQUIPOS CON ESTADO EN 0
SELECT
	COUNT( estado ) AS estado 
FROM
	equipos_ingresados 
WHERE
	estado != 0 -- CONTANDO EQUIPOS CON ESTADO EN 1
SELECT
	COUNT( estado ) AS estado 
FROM
	equipos_ingresados 
WHERE
	estado = 0 -- CONSULTA PARA OBTENER AL EQUIPO Y DETERMINAR SI ESTA PENDEIENTE O ESTA ENTREGADO DEPENDIENDO DE SI EL CAMPO ESTADO ES = 0 O = 1 (0 FALSO, 1 TRUE)
SELECT
	*,
IF
	( estado = 0, 'PENDIENTE', 'ENTREGADO' ) AS estado_descriptivo 
FROM
	equipos_ingresados;-- LO MISMO PERO FANCIER
SELECT
	*,
CASE
		
		WHEN estado = 0 THEN
		'PENDIENTE' ELSE 'ENTREGADO' 
	END AS estado_descriptivo 
FROM
	equipos_ingresados;
SELECT
	* 
FROM
	equipos_ingresados 
WHERE
	id_equipo = 2 UPDATE equipos_ingresados 
	SET estado = 1 
WHERE
	id_equipo = 2 SELECT
	* 
FROM
	equipos_salida