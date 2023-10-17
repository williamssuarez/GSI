SELECT
t1.id_entrega,
t4.numero_bien as equipo,
t4.usuario,
t5.nombre_departamento as departamento,
t4.fecha_registro,
t4.cpu,
t4.memoria_ram,
t4.almacenamiento,
t8.nombre,
t3.fecha_recibido,
t3.recibido_por,
t7.nombres,
t1.fecha_entrega,
t6.nombres as administrador,
t1.fecha_aprobacion,
t2.nombres as entregado_por,
t3.problema,
t1.conclusion
FROM
equipos_salida t1 
INNER JOIN usuarios t2 ON t2.id_user = t1.entregado_por
INNER JOIN equipos_ingresados t3 ON t3.id_ingreso = t1.ingreso 
INNER JOIN equipos t4 ON t4.id_equipo = t3.id_equipo
INNER JOIN departamentos t5 ON t5.id_departamento = t4.departamento
INNER JOIN usuarios t6 ON t6.id_user = t1.id_administrador
INNER JOIN usuarios t7 ON t7.id_user = t3.recibido_por 
INNER JOIN sistemas_operativos t8 ON t8.id_os = t4.sistema_operativo
WHERE t4.id_equipo = 3
ORDER BY  t3.fecha_recibido ASC