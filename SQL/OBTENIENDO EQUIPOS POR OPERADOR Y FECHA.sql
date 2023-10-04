-- OBTENIENDO REGISTROS DE TODOS LOS INGRESOS DEL OPERADOR, ORDENADOS POR FECHA DESDE EL MAS RECIENTE
SELECT 
    t1.id_ingreso,
    t2.numero_bien,
		t4.nombre_departamento,
    t1.fecha_recibido,
    t3.nombre,
    t1.problema,
    t1.estado 
FROM 
    equipos_ingresados t1 
INNER JOIN 
    equipos t2 ON t1.id_equipo = t2.id_equipo
INNER JOIN 
    operadores t3 ON t3.id_operador = t1.recibido_por
INNER JOIN
		departamentos t4 ON t2.departamento = t4.id_departamento
WHERE 
    recibido_por = 1
ORDER BY 
    t1.fecha_recibido DESC;


-- OBTENIENDO REGISTROS DEL MES 9 (SEPTIEMBRE)
SELECT 
    t1.id_ingreso,
    t2.numero_bien,
		t4.nombre_departamento,
    t1.fecha_recibido,
    t3.nombre,
    t1.problema,
    t1.estado 
FROM 
    equipos_ingresados t1 
INNER JOIN 
    equipos t2 ON t1.id_equipo = t2.id_equipo
INNER JOIN 
    operadores t3 ON t3.id_operador = t1.recibido_por
INNER JOIN
		departamentos t4 ON t2.departamento = t4.id_departamento
WHERE 
    recibido_por = 1
    AND MONTH(t1.fecha_recibido) = 9
ORDER BY 
    t1.fecha_recibido DESC;



-- OBTENIENDO EQUIPOS ENTREGADOS POR OPERADOR 
SELECT 
	t1.id_entrega,
	t2.id_ingreso,
	t4.numero_bien,
	t5.nombre_departamento,
	t1.fecha_entrega,
	t3.nombre,
	t2.problema,
	t1.conclusion 
FROM 
	equipos_salida t1
INNER JOIN
	equipos_ingresados t2 ON t2.id_ingreso = t1.ingreso
INNER JOIN
	operadores t3 ON t3.id_operador = t1.entregado_por
INNER JOIN
	equipos t4 ON t4.id_equipo = t2.id_equipo
INNER JOIN
	departamentos t5 ON t5.id_departamento = t4.departamento
WHERE 
	t1.entregado_por = 12
ORDER BY t1.fecha_entrega DESC


-- OBTENIENDO TODOS LOS EQUIPOS ENTREGADOS POR OPERADOR Y POR MES
SELECT 
	t1.id_entrega,
	t2.id_ingreso,
	t4.numero_bien,
	t5.nombre_departamento,
	t1.fecha_entrega,
	t3.nombre,
	t2.problema,
	t1.conclusion 
FROM 
	equipos_salida t1
INNER JOIN
	equipos_ingresados t2 ON t2.id_ingreso = t1.ingreso
INNER JOIN
	operadores t3 ON t3.id_operador = t1.entregado_por
INNER JOIN
	equipos t4 ON t4.id_equipo = t2.id_equipo
INNER JOIN
	departamentos t5 ON t5.id_departamento = t4.departamento
WHERE 
	t1.entregado_por = 1
	AND MONTH(t1.fecha_entrega) = 9
ORDER BY t1.fecha_entrega DESC
	
	
SELECT * FROM equipos_salida WHERE entregado_por = 12 -- 9 REGISTROS
SELECT * FROM equipos_salida -- 17 REGISTROS