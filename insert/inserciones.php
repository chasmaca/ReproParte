<?php

$solicitudInsert = "INSERT INTO solicitud";
$sentenciaInsertTrabajo = "INSERT INTO trabajo(trabajo_id,solicitud_id,fecha_fin,CeCo,usuario_id,observaciones,codigo,orden,precioByN,precioColor,precioEncuadernacion,PrecioVarios,PrecioEspiral,PrecioEncolado,PrecioVarios1,PrecioVarios2,status_id, departamento_id)VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$sentenciaInsertDetalle = "INSERT INTO trabajodetalle (trabajo_id,tipo_id,detalle_id,unidades,observaciones,fecha_cierre,solicitud_id,preciototal)VALUES(?,?,?,?,?,?,?,?)";
$sentenciaInsertDepartamento = "INSERT INTO departamento (DEPARTAMENTOS_DESC, ceco) VALUES (?,?)";
$sentenciaInsertSubDepartamento = "INSERT INTO subdepartamento (departamento_id, subdepartamento_id, subdepartamento_desc, treintabarra ) VALUES (?,?,?,?)";
$sentenciaInsertUsuario = "INSERT INTO usuario (USUARIO_ID,LOGON,PASSWORD,NOMBRE,APELLIDO,ROLE_ID) VALUES (?,?,?,?,?,?)";
$sentenciaInsertArticulo = "INSERT INTO detalle (DETALLE_ID, TIPO_ID, DESCRIPCION, PRECIO) VALUES (?,?,?,?)";
$sentenciaInsertaExtra = "INSERT INTO detalle values (?,?,?,?)";
$sentenciaInsertUsuarioValida = "INSERT INTO usuariodepartamento values (?,?,?)";
$sentenciaInsertImpresoras = "INSERT INTO impresoras (modelo,edificio,ubicacion,fecha,serie,numero) values (?,?,?,STR_TO_DATE(?, '%d/%m/%Y %r'),?,?)";
$sentenciaInsertSolicitud = "insert into solicitud (solicitud_id, departamento_id,nombre_solicitante,apellidos_solicitante,autorizador_id,descripcion_solicitante,email_solicitante,status_id,fecha_alta,subdepartamento_id) values (?,?,?,?,?,?,?,?,STR_TO_DATE(?, '%d/%m/%Y %r'),?)";
$sentenciaInsertGastosImpresora = "insert into gastos_impresora (departamento_id,periodo,byn_unidades,byn_precio,byn_total,color_unidades,color_precio,color_total) values (?,?,?,?,?,?,?,?)";
$sentenciaInsertGastosMaquina = "insert into gastos_maquina (departamento_id,periodo,byn_unidades,byn_precio,byn_total,color_unidades,color_precio,color_total) values (?,?,?,?,?,?,?,?)";
$sentenciaInsertDetalleJSON = "insert into trabajodetalle (trabajo_id, tipo_id, detalle_id,unidades, solicitud_id,precioTotal) values (?,?,?,?,?,?)";
$saveVarios2ExtraJSON = "insert into detalle (detalle_id, tipo_id, descripcion, precio) values (?,?,?,?)";
$saveVarios2ExtraTrabajoJSON = "insert into trabajodetalle (trabajo_id, tipo_id, detalle_id, unidades, solicitud_id,preciototal) values (?,?,?,?,?,?)";
$insertTrabajoJSON = "insert into trabajo (trabajo_id, solicitud_id, fecha_inicio, CeCo, codigo, orden, departamento_id, subdepartamento_id) values (?,?,STR_TO_DATE(?, '%d/%m/%Y %r'),?,?,?,?,?)";
?>