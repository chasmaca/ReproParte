<?php
$sentenciaUpdateUsuario = "UPDATE usuario set LOGON = ?, NOMBRE = ?, APELLIDO= ?, ROLE_ID= ?, PASSWORD=? WHERE USUARIO_ID = ?";
$sentenciaUpdateProducto = "UPDATE detalle SET DESCRIPCION = ?, PRECIO =? WHERE DETALLE_ID=? AND TIPO_ID = ?";
$sentenciaUpdateImpresoras = "UPDATE impresoras set modelo=?, edificio=?,ubicacion=?, fecha=STR_TO_DATE(?, '%d/%m/%Y %r'), serie=?, numero=? where impresora_id=?";
$sentenciaEstadoSolicitud = "UPDATE solicitud SET STATUS_ID=? WHERE SOLICITUD_ID = ?";
$sentenciaEstadoSolicitudPlantilla = "UPDATE solicitud SET STATUS_ID = ?, usuario_plantilla = ? WHERE SOLICITUD_ID = ?";
$sentenciaActualizaEstado = "UPDATE trabajo set status_id = ? where solicitud_id = ? and trabajo_id = 1";
$sentenciaUpdateTrabajoSubtotal = "UPDATE trabajo SET PrecioByN = ?, PrecioColor = ?, PrecioEncuadernacion = ?, PrecioVarios = ?, PrecioEspiral = ?, PrecioEncolado = ?, PrecioVarios1 = ?, PrecioVarios2 = ?  WHERE trabajo_id = ? AND solicitud_id = ?";
$sentenciaUpdateSubDepartamento = "update subdepartamento set subdepartamento_desc = ?, treintabarra = ? where departamento_id = ? and subdepartamento_id = ?";
$sentenciaUpdateDepartamento = "UPDATE departamento SET DEPARTAMENTOS_DESC = ?, ceco=? WHERE DEPARTAMENTO_ID = ?";
$sentenciaUpdateTrabajoDetalle = "UPDATE trabajodetalle SET UNIDADES=?,PRECIOTOTAL=? WHERE SOLICITUD_ID = ? AND TRABAJO_ID = ? AND TIPO_ID = ? AND DETALLE_ID = ?";
$sentenciaCierreSolicitud = "UPDATE solicitud SET STATUS_ID=? WHERE SOLICITUD_ID = ?";
$sentenciaUpdatePassword = "UPDATE usuario SET PASSWORD=? WHERE LOGON=?";
$sentenciaUpdateGastosImpresoraByN = "UPDATE gastos_impresora set byn_unidades = ?,  byn_precio = ?, byn_total = ? where departamento_id=? and  YEAR(periodo) = ? and MONTH(periodo) = ?";
$sentenciaUpdateGastosImpresoraColor = "UPDATE gastos_impresora set color_unidades = ?, color_precio = ?, color_total = ? where departamento_id=? and  YEAR(periodo) = ? and MONTH(periodo) = ?";
$sentenciaUpdateGastosMaquinaByN = "UPDATE gastos_maquina set byn_unidades = ?,  byn_precio = ?, byn_total = ? where departamento_id=? and YEAR(periodo) = ? and MONTH(periodo) = ?";
$sentenciaUpdateGastosMaquinaColor = "UPDATE gastos_maquina set color_unidades = ?, color_precio = ?, color_total = ? where departamento_id=? and YEAR(periodo) = ? and MONTH(periodo) = ?";
$sentenciaUpdateDepartamentoSolicitud = "UPDATE solicitud set departamento_id = ?, subdepartamento_id = ? where solicitud_id = ?";
$sentenciaUpdateSubdepartamentoSolicitud = "UPDATE solicitud set subdepartamento_id = ? where solicitud_id = ?";
$sentenciaUpdateStatusDosSolicitud = "UPDATE solicitud set status_id = ?, fecha_validacion = now() where solicitud_id = ?";
$sentenciaUpdateDetalleJSON = "UPDATE trabajodetalle set unidades=?, preciototal=? where trabajo_id = ? and tipo_id = ? and detalle_id = ? and solicitud_id = ?";
$sentenciaActualizaSubTotales = "UPDATE trabajo set precioVarios = ?, precioVarios1 = ?, precioVarios2 = ?, precioColor = ?, precioByN = ?, precioEncuadernacion = ?, precioEspiral = ?, precioEncolado = ? where solicitud_id = ?";
$updateTrabajoJSON = "UPDATE trabajo set fecha_inicio = STR_TO_DATE(?, '%d/%m/%Y') where solicitud_id = ?";
$sentenciaStatus6Solicitud = "UPDATE solicitud set status_id = ?, fecha_cierre = now() where solicitud_id = ?";
$updateVarios2ExtraTrabajoJSON = "UPDATE trabajodetalle set unidades = ?, preciototal = ?, fecha_cierre = now() where trabajo_id=1 and tipo_id = 7 and solicitud_id = ? and detalle_id = ?";
$sentenciaCierreSolicitud= "UPDATE solicitud set status_id = 6, fecha_cierre = ? where status_id in (2,4,5) and YEAR(fecha_alta)=? and MONTH(fecha_alta) = ?";
?>