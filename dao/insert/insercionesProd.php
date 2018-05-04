<?php

$solicitudInsert = "INSERT INTO SOLICITUD";
$sentenciaInsertTrabajo = "INSERT INTO trabajo(trabajo_id,solicitud_id, fecha_fin,CeCo, usuario_id, observaciones, codigo,orden, precioByN, precioColor, precioEncuadernacion,PrecioVarios)VALUES(?,?,?,?,?,?,?,?,?,?,?,?)";
$sentenciaInsertDetalle = "INSERT INTO trabajodetalle (trabajo_id,tipo_id,detalle_id,unidades,observaciones,fecha_cierre,solicitud_id,preciototal)VALUES(?,?,?,?,?,?,?,?)";
$sentenciaUpdateTrabajoDetalle = "UPDATE trabajodetalle SET UNIDADES=?,PRECIOTOTAL=? WHERE SOLICITUD_ID = ? AND TRABAJO_ID = ? AND TIPO_ID = ? AND DETALLE_ID = ?";
$sentenciaCierreSolicitud = "UPDATE SOLICITUD SET STATUS_ID=? WHERE SOLICITUD_ID = ?";
$sentenciaInsertDepartamento = "INSERT INTO DEPARTAMENTO (DEPARTAMENTOS_DESC) VALUES (?)";
$sentenciaUpdateDepartamento = "UPDATE DEPARTAMENTO SET DEPARTAMENTOS_DESC = ? WHERE  DEPARTAMENTO_ID = ?";
?>