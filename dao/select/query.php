<?php

$todosDepartamentosQuery = "SELECT DEPARTAMENTO_ID, DEPARTAMENTOS_DESC,ceco  FROM departamento where markfordelete = 0";
$actualizaDepartamentoQuery = "SELECT DEPARTAMENTO_ID, DEPARTAMENTOS_DESC, ceco FROM departamento where DEPARTAMENTO_ID = ? and markfordelete = 0";
$todosAutorizadoresQuery = "SELECT usuario_id as AUTORIZADOR_ID, upper(nombre) as AUTORIZADOR_NOMBRE, upper(apellido) as AUTORIZADOR_APELLIDOS, logon as AUTORIZADOR_EMAIL FROM usuario where role_id = 3 order by AUTORIZADOR_NOMBRE,AUTORIZADOR_APELLIDOS";
$maximaSolicidud = "SELECT MAX(SOLICITUD_ID)+1 AS SOLICITUD_MAX FROM solicitud";
$solicitudPorValidadorJSONQuery = "SELECT d1.solicitud_id as solicitud_id, d1.departamento_id as departamento_id, d1.subdepartamento_id as subdepartamento_id, d1.nombre_solicitante as nombre_solicitante, d1.apellidos_solicitante as apellidos_solicitante, d1.autorizador_id as autorizador_id, d1.descripcion_solicitante as descripcion_solicitante, d1.email_solicitante as email_solicitante, d1.status_id as status_id, d1.fecha_alta as fecha_alta, d1.fecha_validacion as fecha_validacion, d1.fecha_cierre as fecha_cierre, de1.departamentos_desc as departamentos_desc, sd1.subdepartamento_desc as subdepartamentos_desc FROM solicitud d1 inner join departamento de1 on d1.departamento_id = de1.departamento_id inner join subdepartamento sd1 on d1.subdepartamento_id = sd1.subdepartamento_id and d1.departamento_id = sd1.departamento_id and de1.markfordelete= 0 and sd1.markfordelete = 0 WHERE d1.status_id = 1 and d1.autorizador_id = ?";
$loginQuery = "SELECT usuario_id, nombre, apellido, role_id FROM usuario";
$updateSolicitudQuery = "UPDATE solicitud SET";
$solicitudPorRealizarQuery = "SELECT s1.solicitud_id, s1.departamento_id, s1.nombre_solicitante, s1.apellidos_solicitante, s1.autorizador_id, s1.descripcion_solicitante, s1.email_solicitante, s1.status_id, s1.fecha_alta, s1.fecha_validacion, s1.fecha_cierre, d1.departamentos_desc FROM solicitud s1 inner join departamento d1 on d1.departamento_id = s1.departamento_id and d1.markfordelete = 0 WHERE s1.status_id = 2";
$solicitudEnCursoQuery = "SELECT s1.solicitud_id, s1.departamento_id, s1.nombre_solicitante, s1.apellidos_solicitante, s1.autorizador_id, s1.descripcion_solicitante, s1.email_solicitante, s1.status_id, s1.fecha_alta, s1.fecha_validacion, s1.fecha_cierre, d1.departamentos_desc FROM solicitud s1 inner join departamento d1 on d1.departamento_id = s1.departamento_id and d1.markfordelete = 0  WHERE s1.status_id = 4";
$solicitudEnCursoPlantillaQuery = "SELECT s1.solicitud_id, s1.departamento_id, s1.nombre_solicitante, s1.apellidos_solicitante, s1.autorizador_id, s1.descripcion_solicitante, s1.email_solicitante, s1.status_id, s1.fecha_alta, s1.fecha_validacion, s1.fecha_cierre, d1.departamentos_desc,s1.usuario_plantilla FROM solicitud s1 inner join departamento d1 on d1.departamento_id = s1.departamento_id and d1.markfordelete = 0  WHERE s1.status_id = 4";
$solicitudGuardadaQuery = "SELECT s1.solicitud_id, s1.departamento_id, s1.nombre_solicitante, s1.apellidos_solicitante, s1.autorizador_id, s1.descripcion_solicitante, s1.email_solicitante, s1.status_id, s1.fecha_alta, s1.fecha_validacion, s1.fecha_cierre, d1.departamentos_desc FROM solicitud s1 inner join departamento d1 on d1.departamento_id = s1.departamento_id  and d1.markfordelete = 0 WHERE s1.status_id = 5";
$existeTrabajoQuery = "SELECT TRABAJO_ID FROM trabajo WHERE SOLICITUD_ID = ";
$recuperaEncoladoQuery = "SELECT r1.tipo_id as TIPO_ID,r1.tipo_desc as TIPO_DESC,d1.detalle_id as DETALLE_ID,d1.descripcion as DESCRIPCION,d1.precio as PRECIO, 0 as UNIDADES, 0 as PRECIOTOTAL FROM tipo r1 inner join detalle d1 on r1.tipo_id = d1.tipo_id WHERE r1.tipo_id = 2 ORDER BY r1.tipo_id, d1.detalle_id";
$recuperaEspiralQuery = "SELECT r1.tipo_id as TIPO_ID,r1.tipo_desc as TIPO_DESC,d1.detalle_id as DETALLE_ID,d1.descripcion as DESCRIPCION,d1.precio as PRECIO, 0 as UNIDADES, 0 as PRECIOTOTAL FROM tipo r1 inner join detalle d1 on r1.tipo_id = d1.tipo_id WHERE r1.tipo_id = 1 ORDER BY r1.tipo_id, d1.detalle_id";
$recuperaVariosUnoQuery = "SELECT r1.tipo_id as TIPO_ID,r1.tipo_desc as TIPO_DESC,d1.detalle_id as DETALLE_ID,d1.descripcion as DESCRIPCION,d1.precio as PRECIO, 0 as UNIDADES, 0 as PRECIOTOTAL FROM tipo r1 inner join detalle d1 on r1.tipo_id = d1.tipo_id WHERE r1.tipo_id = 3 ORDER BY r1.tipo_id, d1.detalle_id";
$recuperaColorQuery = "SELECT r1.tipo_id as TIPO_ID,r1.tipo_desc as TIPO_DESC,d1.detalle_id as DETALLE_ID,d1.descripcion as DESCRIPCION,d1.precio as PRECIO, 0 as UNIDADES, 0 as PRECIOTOTAL FROM tipo r1 inner join detalle d1 on r1.tipo_id = d1.tipo_id WHERE r1.tipo_id = 4 ORDER BY r1.tipo_id, d1.detalle_id";
$recuperaByNQuery = "SELECT r1.tipo_id as TIPO_ID,r1.tipo_desc as TIPO_DESC,d1.detalle_id as DETALLE_ID,d1.descripcion as DESCRIPCION,d1.precio as PRECIO, 0 as UNIDADES, 0 as PRECIOTOTAL FROM tipo r1 inner join detalle d1 on r1.tipo_id = d1.tipo_id WHERE r1.tipo_id = 5 ORDER BY r1.tipo_id, d1.detalle_id";
$recuperaVariosDosQuery = "SELECT r1.tipo_id as TIPO_ID,r1.tipo_desc as TIPO_DESC,d1.detalle_id as DETALLE_ID,d1.descripcion as DESCRIPCION,d1.precio as PRECIO, 0 as UNIDADES, 0 as PRECIOTOTAL FROM tipo r1 inner join detalle d1 on r1.tipo_id = d1.tipo_id WHERE r1.tipo_id = 6 ORDER BY r1.tipo_id, d1.detalle_id";
$recuperaVariosDosExtraQuery = "SELECT r1.tipo_id as TIPO_ID,r1.tipo_desc as TIPO_DESC,d1.detalle_id as DETALLE_ID,d1.descripcion as DESCRIPCION,d1.precio as PRECIO, 0 as UNIDADES, 0 as PRECIOTOTAL FROM tipo r1 inner join detalle d1 on r1.tipo_id = d1.tipo_id WHERE r1.tipo_id = 7 ORDER BY r1.tipo_id, d1.detalle_id";
$recuperaEncoladoDetalleQuery = "SELECT r1.tipo_id as TIPO_ID,r1.tipo_desc as TIPO_DESC,d1.detalle_id as DETALLE_ID,d1.descripcion as DESCRIPCION,d1.precio as PRECIO,td1.unidades as UNIDADES, td1.preciototal as PRECIOTOTAL FROM tipo r1 inner join detalle d1 on r1.tipo_id = d1.tipo_id left join trabajodetalle td1 on r1.tipo_id = td1.tipo_id and d1.detalle_id = td1.detalle_id WHERE r1.tipo_id = 2 and td1.solicitud_id = ";
$recuperaEspiralDetalleQuery = "SELECT r1.tipo_id as TIPO_ID,r1.tipo_desc as TIPO_DESC,d1.detalle_id as DETALLE_ID,d1.descripcion as DESCRIPCION,d1.precio as PRECIO,td1.unidades as UNIDADES, td1.preciototal as PRECIOTOTAL FROM tipo r1 inner join detalle d1 on r1.tipo_id = d1.tipo_id left join trabajodetalle td1 on r1.tipo_id = td1.tipo_id and d1.detalle_id = td1.detalle_id WHERE r1.tipo_id = 1 and td1.solicitud_id = ";
$recuperaVariosUnoDetalleQuery = "SELECT r1.tipo_id as TIPO_ID,r1.tipo_desc as TIPO_DESC,d1.detalle_id as DETALLE_ID,d1.descripcion as DESCRIPCION,d1.precio as PRECIO,td1.unidades as UNIDADES, td1.preciototal as PRECIOTOTAL FROM tipo r1 inner join detalle d1 on r1.tipo_id = d1.tipo_id left join trabajodetalle td1 on r1.tipo_id = td1.tipo_id and d1.detalle_id = td1.detalle_id WHERE r1.tipo_id = 3 and td1.solicitud_id = ";
$recuperaColorDetalleQuery = "SELECT r1.tipo_id as TIPO_ID,r1.tipo_desc as TIPO_DESC,d1.detalle_id as DETALLE_ID,d1.descripcion as DESCRIPCION,d1.precio as PRECIO,td1.unidades as UNIDADES, td1.preciototal as PRECIOTOTAL FROM tipo r1 inner join detalle d1 on r1.tipo_id = d1.tipo_id left join trabajodetalle td1 on r1.tipo_id = td1.tipo_id and d1.detalle_id = td1.detalle_id WHERE r1.tipo_id = 4 and td1.solicitud_id = ";
$recuperaByNDetalleQuery = "SELECT r1.tipo_id as TIPO_ID,r1.tipo_desc as TIPO_DESC,d1.detalle_id as DETALLE_ID,d1.descripcion as DESCRIPCION,d1.precio as PRECIO,td1.unidades as UNIDADES, td1.preciototal as PRECIOTOTAL FROM tipo r1 inner join detalle d1 on r1.tipo_id = d1.tipo_id left join trabajodetalle td1 on r1.tipo_id = td1.tipo_id and d1.detalle_id = td1.detalle_id WHERE r1.tipo_id = 5 and td1.solicitud_id = ";
$recuperaVariosDosDetalleQuery = "SELECT r1.tipo_id as TIPO_ID,r1.tipo_desc as TIPO_DESC,d1.detalle_id as DETALLE_ID,d1.descripcion as DESCRIPCION,d1.precio as PRECIO,td1.unidades as UNIDADES, td1.preciototal as PRECIOTOTAL FROM tipo r1 inner join detalle d1 on r1.tipo_id = d1.tipo_id left join trabajodetalle td1 on r1.tipo_id = td1.tipo_id and d1.detalle_id = td1.detalle_id WHERE r1.tipo_id = 6 and td1.solicitud_id = ";
$recuperaMaxUsuario = "SELECT MAX(USUARIO_ID)+1 AS idUsuario FROM usuario";
$recuperaUsuarios = "SELECT USUARIO_ID, LOGON, PASSWORD,NOMBRE,APELLIDO,ROLE_ID FROM usuario order by nombre,apellido";
$recuperaTipos = "SELECT TIPO_ID, TIPO_DESC FROM tipo";
$recuperaMaxDetalle = "SELECT MAX(DETALLE_ID)+1 AS DETALLEID FROM detalle WHERE TIPO_ID=?";
$recuperaSubtotalEspiral = "SELECT precioEspiral from trabajo where trabajo_id = ? and solicitud_id = ?";
$recuperaSubtotalEncolado = "SELECT precioEncolado from trabajo where trabajo_id = ? and solicitud_id = ?";
$recuperaSubtotalVarios1 = "SELECT precioVarios1 from trabajo where trabajo_id = ? and solicitud_id = ?";
$recuperaSubtotalColor = "SELECT precioColor from trabajo where trabajo_id = ? and solicitud_id = ?";
$recuperaSubtotalVarios2 = "SELECT precioVarios2 from trabajo where trabajo_id = ? and solicitud_id = ?";
$recuperaSubtotalByN = "SELECT precioByN from trabajo where trabajo_id = ? and solicitud_id = ?";
$generaInforme2 = "select trabajo_id, solicitud_id, fecha_inicio, fecha_fin, CeCo, codigo, precioEncuadernacion, PrecioVarios, precioColor, precioByN from trabajo";
$recuperaDetalleVarios2 = "SELECT r1.tipo_id as TIPO_ID,r1.tipo_desc as TIPO_DESC,d1.detalle_id as DETALLE_ID,d1.descripcion as DESCRIPCION,d1.precio as PRECIO,td1.unidades as UNIDADES, td1.preciototal as PRECIOTOTAL FROM tipo r1 inner join detalle d1 on r1.tipo_id = d1.tipo_id left join trabajodetalle td1 on r1.tipo_id = td1.tipo_id and d1.detalle_id = td1.detalle_id WHERE r1.tipo_id in (6,7) and td1.solicitud_id =";
$consultaUsuarioQuery = "SELECT USUARIO_ID, LOGON, NOMBRE, APELLIDO, ROLE_ID, password FROM usuario WHERE USUARIO_ID = ?";
$consultaUsuarioValidador = "SELECT distinct(departamento_id) FROM usuariodepartamento  WHERE USUARIO_ID = ?";
$consultaTodosTrabajos = "SELECT s1.solicitud_id, d1.departamentos_desc, sd1.subdepartamento_desc, s1.nombre_solicitante, s1.apellidos_solicitante,s1.fecha_alta, s1.fecha_cierre,u1.nombre,u1.apellido, s1.descripcion_solicitante, s1.email_solicitante,s2.status_desc, s1.status_id, s1.fecha_alta from solicitud s1 inner join departamento d1 on s1.departamento_id = d1.departamento_id and d1.markfordelete = 0  inner join subdepartamento sd1 on s1.departamento_id = sd1.departamento_id and s1.subdepartamento_id = sd1.subdepartamento_id inner join status s2 on s1.status_id = s2.status_id inner join usuario u1 on s1.autorizador_id = u1.usuario_id order by s1.solicitud_id";
$generaInforme="select d1.treintabarra as codigo, d1.CeCo,t1.departamento_id,d1.departamentos_desc,s1.fecha_cierre, t1.precioByN,t1.precioColor, t1.precioEncuadernacion,t1.PrecioVarios from trabajo t1 inner join departamento d1 on t1.departamento_id = d1.departamento_id and d1.markfordelete = 0 inner join solicitud s1 on t1.solicitud_id = s1.solicitud_id and s1.status_id = 6";
$generaInformeGlobal = "SELECT t1.codigo,t1.CeCo,t1.departamento_id,d1.departamentos_desc,sum(t1.precioByN) as byn,sum(t1.precioColor) as color,sum(t1.precioEncuadernacion) as encuadernacion,sum(t1.PrecioVarios) as varios FROM trabajo t1 INNER JOIN departamento d1 ON t1.departamento_id = d1.departamento_id and d1.markfordelete = 0  group by t1.codigo";
$generaInformeGlobalMes = "SELECT sd1.treintabarra as codigo,d1.CeCo,t1.departamento_id,d1.departamentos_desc,sum(t1.precioByN) as byn,sum(t1.precioColor) as color,sum(t1.precioEncuadernacion) as encuadernacion,sum(t1.PrecioVarios) as varios, gi1.byn_total as impresorasByN, gi1.color_total as impresorasColor, gm1.byn_total as maquinasByN, gm1.color_total as maquinasColor, sd1.subdepartamento_desc as subdepartamentos_desc FROM trabajo t1 INNER JOIN departamento d1 ON t1.departamento_id = d1.departamento_id LEFT OUTER JOIN gastos_impresora gi1 ON t1.departamento_id = gi1.departamento_id LEFT OUTER JOIN gastos_maquina gm1 ON t1.departamento_id = gm1.departamento_id INNER JOIN solicitud s1 on t1.solicitud_id = s1.solicitud_id and s1.status_id = 6"; 
$recuperaEmail = "select logon from usuario where usuario_id = ?";
$recuperaTodosDetalles = "select d1.tipo_id as tipoTipoId, d1.detalle_id as detalleId, d1.descripcion as detalleDescripcion, d1.precio as detallePrecio	from detalle d1 where d1.tipo_id = ";
$consultaTodosTrabajosMes = "SELECT s1.solicitud_id, d1.departamentos_desc,sd1.subdepartamento_desc, s1.nombre_solicitante, s1.apellidos_solicitante,s1.fecha_alta, s1.fecha_cierre, u1.nombre,u1.apellido, s1.descripcion_solicitante, s1.email_solicitante,s2.status_desc, s1.status_id, s1.fecha_alta from solicitud s1 inner join departamento d1 on s1.departamento_id = d1.departamento_id inner join subdepartamento sd1 on s1.departamento_id = sd1.departamento_id and s1.subdepartamento_id = sd1.subdepartamento_id inner join status s2 on s1.status_id = s2.status_id inner join usuario u1 on s1.autorizador_id = u1.usuario_id where 1=1 ";

$generaInformeMes = "select
						s1.solicitud_id as codigo,
						d1.CeCo as ceco,
						t1.departamento_id  as departamentoId,
						d1.departamentos_desc as departamentoDesc,
						s1.fecha_cierre  as fechaCierre,
						t1.precioByN as byn,
						t1.precioColor as color,
						t1.precioEncuadernacion as encuadernacion,
						t1.PrecioVarios as varios,
						sd1.subdepartamento_desc as subdepartamentos_desc,
						s1.descripcion_solicitante as descripcion,
						s1.nombre_solicitante as nombre,
						s1.apellidos_solicitante as apellido
					from trabajo t1
						inner join departamento d1 on t1.departamento_id = d1.departamento_id
						inner join solicitud s1 on t1.solicitud_id = s1.solicitud_id and s1.status_id = 6
						right join subdepartamento sd1 on sd1.departamento_id = s1.departamento_id and sd1.subdepartamento_id = s1.subdepartamento_id
					where  YEAR(s1.fecha_cierre) =";

$generaInformeMesGestor = "select sd1.treintabarra as codigo, d1.CeCo as ceco,t1.departamento_id as departamentoId,d1.departamentos_desc as departamentoDesc,s1.fecha_cierre as fechaCierre, t1.precioByN as byn,t1.precioColor as color, t1.precioEncuadernacion as encuadernacion,t1.PrecioVarios as varios, sd1.subdepartamento_desc as subdepartamentos_desc from trabajo t1 inner join departamento d1 on t1.departamento_id = d1.departamento_id inner join solicitud s1 on t1.solicitud_id = s1.solicitud_id and s1.status_id = 6 inner join subdepartamento sd1 on sd1.departamento_id = s1.departamento_id and sd1.subdepartamento_id = s1.subdepartamento_id where  YEAR(s1.fecha_cierre) =";
$recuperaDptoXAutorizador = "select distinct(d1.departamento_id) as DEPARTAMENTO_ID, d1.departamentos_desc as DEPARTAMENTOS_DESC, d1.ceco as CECO from usuario u1 inner join usuariodepartamento ud1 on ud1.usuario_id = u1.usuario_id inner join departamento d1 on ud1.departamento_id = d1.departamento_id where role_id = 3 and u1.usuario_id = ";
$recuperaDptoXAutorizadorArray = "select distinct d1.departamento_id as DEPARTAMENTO_ID from usuario u1 inner join usuariodepartamento ud1 on ud1.usuario_id = u1.usuario_id inner join departamento d1 on ud1.departamento_id = d1.departamento_id where role_id = 3 and u1.usuario_id = ?";
$recuperaDptoAlta = "select departamento_id from usuariodepartamento where usuario_id = ? and departamento_id = ?";
$departamentosAutorizadorQuery = "select distinct(d1.departamento_id) as DEPARTAMENTO_ID, d1.departamentos_desc as DEPARTAMENTOS_DESC from departamento d1 inner join usuariodepartamento ud1 on ud1.departamento_id = d1.departamento_id and ud1.usuario_id = ";
$recuperaRole = "select role_id,role_desc from role";
$recuperaStatus = "select status_id from solicitud where solicitud_id = ?";
$recuperaCorreoSolicitud = "select email_solicitante from solicitud where solicitud_id = ?";
$recuperaAnio = "select distinct(YEAR(fecha_alta)) as fecha_alta from solicitud";
$recuperaAnioMes = "SELECT YEAR( fecha_alta ) AS anio_alta, MONTH( fecha_alta ) AS mes_alta FROM solicitud group BY anio_alta , mes_alta ORDER BY anio_alta desc,mes_alta desc";
$recuperaAnioMesCierre = "SELECT YEAR( fecha_alta ) AS anio_alta, MONTH( fecha_alta ) AS mes_alta FROM solicitud where status_id in (2,4,5)group BY anio_alta , mes_alta ORDER BY anio_alta desc,mes_alta desc";
$recuperaInformeDetalleValida = "select s1.solicitud_id as solicitudId, sd1.treintabarra as esb, de1.ceco as codigo, de1.departamentos_desc as departamento, sd1.subdepartamento_desc as subdepartamento, s1.nombre_solicitante as nombre, s1.apellidos_solicitante as apellidos,trim(s1.descripcion_solicitante) as descripcion, s1.fecha_cierre as fecha, t1.precioEncuadernacion as encuadernacion, t1.precioByN as byn, t1.precioColor as color, t1.PrecioVarios as varios, '0' AS BYN_MAQUINA, '0'  AS COLOR_MAQUINA, '0' AS BYN_IMPRESORA,  '0'  AS COLOR_IMPRESORA from solicitud s1 inner join trabajo t1 on s1.solicitud_id = t1.solicitud_id inner join departamento de1 on s1.departamento_id = de1.departamento_id inner join subdepartamento sd1 on s1.departamento_id = sd1.departamento_id and s1.subdepartamento_id = sd1.subdepartamento_id where s1.status_id = 6 and s1.departamento_id in (select ud1.departamento_id from usuariodepartamento ud1 where ud1.usuario_id = ";
$recuperaInformeGlobalValida =  "select sd1.treintabarra as esb, de1.ceco as codigo, de1.departamentos_desc as departamento, sd1.subdepartamento_desc as subdepartamento, sum(t1.precioEncuadernacion) as encuadernacion, sum(t1.precioByN) as byn, sum(t1.precioColor) as color, sum(t1.PrecioVarios) as varios from solicitud s1 inner join trabajo t1 on s1.solicitud_id = t1.solicitud_id inner join departamento de1 on s1.departamento_id = de1.departamento_id inner join subdepartamento sd1 on s1.departamento_id = sd1.departamento_id and s1.subdepartamento_id = sd1.subdepartamento_id where s1.status_id = 6 and s1.departamento_id in (select ud1.departamento_id from usuariodepartamento ud1 where ud1.usuario_id =";
$consultaImpresoras = "SELECT IMPRESORA_ID, MODELO, EDIFICIO, UBICACION,FECHA,SERIE,NUMERO FROM impresoras order by UBICACION";
$consultaImpresorasPorId = "SELECT IMPRESORA_ID, MODELO, EDIFICIO, UBICACION,FECHA,SERIE,NUMERO FROM impresoras WHERE IMPRESORA_ID = ?";
$recuperaMaxSubDptoQuery = "select MAX(subdepartamento_id)+1 from subdepartamento where departamento_id = ?";
$recuperaSubdptoXDpto = "SELECT departamento_id, subdepartamento_id, subdepartamento_desc, treintabarra from subdepartamento where departamento_id = ? and markfordelete = 0";
$recuperaIdSubdptoXDpto = "SELECT subdepartamento_id from subdepartamento where departamento_id = ? and markfordelete = 0";
$recuperaPrecioByNCierre = "select precio from detalle d1 inner join tipo t1 on d1.tipo_id = t1.tipo_id and t1.tipo_desc like '%Blanco%' where d1.descripcion='B/N'";
$recuperaPrecioColorCierre = "select precio from detalle d1 inner join tipo t1 on d1.tipo_id = t1.tipo_id and t1.tipo_desc like '%Color%' where d1.descripcion like '%Color A4%'";
$existeGastoImpresora = "SELECT * FROM gastos_impresora where departamento_id=? and YEAR(periodo) = ? and MONTH(periodo) = ?";
$recuperaGastosCierre = "SELECT departamento_id,periodo, byn_precio,byn_total,color_unidades, color_precio,color_total, byn_unidades FROM gastos_impresora WHERE YEAR(periodo) = ? and MONTH(periodo) = ?";
$existeGastoMaquina = "SELECT * FROM gastos_maquina where departamento_id=? and YEAR(periodo) = ? and MONTH(periodo) = ?";
$recuperaGastosMaquinaCierre = "SELECT departamento_id,periodo, byn_precio,byn_total,color_unidades, color_precio,color_total, byn_unidades  FROM gastos_maquina WHERE YEAR(periodo) = ? and MONTH(periodo) = ?";
$recuperaPrecioByNMaquCierre = "select precio from detalle d1 inner join tipo t1 on d1.tipo_id = t1.tipo_id and t1.tipo_desc like '%Blanco%' where d1.descripcion='B/N'";
$recuperaPrecioColorMaquCierre = "select precio from detalle d1 inner join tipo t1 on d1.tipo_id = t1.tipo_id and t1.tipo_desc like '%Color%' where d1.descripcion like '%Color A4%'";
$recuperaUsuariosConsulta = "select usuario_id, logon, nombre, apellido, role_id from usuario where nombre like ? and apellido like ? and logon like ? and role_id=?";
$generaInformeGlobalMesAdmin = "SELECT 
									d1.departamento_id, d1.departamentos_desc, 
									round(i1.byn_total+i1.color_total,2) as totalImpresoras,
									round(m1.byn_total+m1.color_total,2) as totalMaquinas,
									round(sum(t1.precioByN),2) as byn, 
									round(sum(t1.precioColor),2) as color, 
									round(sum(t1.precioEncuadernacion),2) as encuadernacion, 
									round(sum(t1.PrecioVarios),2) as varios 
								FROM
									departamento d1
										LEFT OUTER JOIN 
											gastos_impresora i1 on 
												i1.departamento_id = d1.departamento_id and 
												month(i1.periodo) = ? and 
												YEAR(i1.periodo) = ?
										LEFT OUTER JOIN 
											gastos_maquina m1 on 
												m1.departamento_id=d1.departamento_id and 
												month(m1.periodo) = ? and 
												YEAR(m1.periodo) = ?
										LEFT OUTER JOIN 
											trabajo t1 on 
												t1.departamento_id = d1.departamento_id
                                                and t1.solicitud_id in (
                                                    select 
                                                    	solicitud_id 
                                                    from
                                                    	solicitud 
                                                    where 
                                                    	status_id = 6 and 
                                                    	month(fecha_cierre) = ? and 
                                                    	YEAR(fecha_cierre) = ?)
								WHERE d1.departamento_id like ?
								GROUP BY d1.departamento_id";

$generaInformeGlobalMesGestor = "SELECT 
									d1.departamento_id, d1.departamentos_desc, 
									round(i1.byn_total+i1.color_total,2) as totalImpresoras,
									round(m1.byn_total+m1.color_total,2) as totalMaquinas,
									round(sum(t1.precioByN),2) as byn, 
									round(sum(t1.precioColor),2) as color, 
									round(sum(t1.precioEncuadernacion),2) as encuadernacion, 
									round(sum(t1.PrecioVarios),2) as varios,
									d1.ceco as ceco
								FROM
									departamento d1
										LEFT OUTER JOIN 
											gastos_impresora i1 on 
												i1.departamento_id = d1.departamento_id and 
												month(i1.periodo) = ? and 
												YEAR(i1.periodo) = ?
										LEFT OUTER JOIN 
											gastos_maquina m1 on 
												m1.departamento_id=d1.departamento_id and 
												month(m1.periodo) = ? and 
												YEAR(m1.periodo) = ?
										LEFT OUTER JOIN 
											trabajo t1 on 
												t1.departamento_id = d1.departamento_id
                                                and t1.solicitud_id in (
                                                    select 
                                                    	solicitud_id 
                                                    from
                                                    	solicitud 
                                                    where 
                                                    	status_id = 6 and 
                                                    	month(fecha_cierre) = ? and 
                                                    	YEAR(fecha_cierre) = ?)
								WHERE d1.departamento_id like ?
								GROUP BY d1.departamento_id";

$generaInformeDetalleMesGestor = "SELECT	
									sd1.treintabarra as codigo,
									d1.CeCo as ceco,					
									t1.departamento_id as departamento_id,
								    d1.departamentos_desc,
									ROUND(t1.precioByN,2) as byn,
									ROUND(t1.precioColor,2) as color,
									ROUND(t1.precioEncuadernacion,2) as encuadernacion,
									ROUND(t1.PrecioVarios,2) as varios,
								    sd1.subdepartamento_desc as subdepartamentos_desc,
									'0' as gastosImpresoras
								FROM
									trabajo t1
										INNER JOIN departamento d1 ON t1.departamento_id = d1.departamento_id
										INNER JOIN solicitud s1 on t1.solicitud_id = s1.solicitud_id
								        inner join subdepartamento sd1 on d1.departamento_id = sd1.departamento_id and sd1.subdepartamento_id = s1.subdepartamento_id
								WHERE
									YEAR(s1.fecha_cierre) = ? and
									month(s1.fecha_cierre) = ? and
								    s1.status_id = 6 and
									s1.departamento_id like ? AND
								    s1.subdepartamento_id like ?
								UNION 
								SELECT	
									'Impresora' as codigo,
									'Impresoras' as ceco,					
									d1.departamento_id as departamento_id,
								    d1.departamentos_desc,
									'0' as byn,
									'0' as color,
									'0' as encuadernacion,
									'0' as varios,
								    'Impresoras' as subdepartamentos_desc,
									round(i1.byn_total+i1.color_total,2) as gastosImpresoras
								FROM
									departamento d1
										INNER JOIN gastos_impresora i1 ON i1.departamento_id = d1.departamento_id
								WHERE
									YEAR(i1.periodo) = ? and
									month(i1.periodo) = ? and
									d1.departamento_id = ?";

$recuperaSubdepartamentoPorIdQuery = "SELECT subdepartamento_desc from subdepartamento s1 inner join solicitud s2 on s2.subdepartamento_id = s1.subdepartamento_id and s2.departamento_id=s1.departamento_id and s2.solicitud_id = ? and s1.markfordelete = 0";
$recuperaDptoXAutorizadorJSON = "select distinct(d1.departamento_id) as DEPARTAMENTO_ID, d1.departamentos_desc as DEPARTAMENTOS_DESC, d1.ceco as CECO from usuario u1 inner join usuariodepartamento ud1 on ud1.usuario_id = u1.usuario_id inner join departamento d1 on ud1.departamento_id = d1.departamento_id where role_id = 3 and d1.markfordelete = 0 and u1.usuario_id = ?";
$recuperaValidadorGlobalTodosDpto = 
"SELECT
sd1.treintabarra AS esb,de1.ceco AS codigo,de1.departamentos_desc AS departamento,sd1.subdepartamento_desc AS subdepartamento,SUM(t1.precioEncuadernacion) AS encuadernacion,SUM(t1.precioByN) AS byn,SUM(t1.precioColor) AS color,SUM(t1.PrecioVarios) AS varios
FROM
solicitud s1 INNER JOIN trabajo t1 ON s1.solicitud_id = t1.solicitud_id INNER JOIN departamento de1 ON s1.departamento_id = de1.departamento_id and de1.markfordelete=0 INNER JOIN subdepartamento sd1 ON s1.departamento_id = sd1.departamento_id AND s1.subdepartamento_id = sd1.subdepartamento_id and sd1.markfordelete=0
WHERE
s1.status_id = 6 AND s1.departamento_id IN(	SELECT ud1.departamento_id FROM usuariodepartamento ud1 WHERE ud1.usuario_id = ?) AND MONTH(s1.fecha_validacion) = ? AND YEAR(s1.fecha_validacion) = ?
GROUP BY de1.ceco 
UNION
SELECT
'IMPRESORA' AS esb, 'IMPRESORA' AS codigo, 'IMPRESORA' AS departamento, 'IMPRESORA' AS subdepartamento, '0' AS encuadernacion, round(sum(byn_total),2) as byn, round(sum(color_total),2)  as color, '0' as varios 
FROM 
gastos_impresora 
WHERE
departamento_id in (SELECT ud1.departamento_id FROM usuariodepartamento ud1 WHERE ud1.usuario_id = ?) AND MONTH(periodo) = ? AND YEAR(periodo) = ? 
UNION
SELECT
'MAQUINA' AS esb, 'MAQUINA' AS codigo, 'MAQUINA' AS departamento, 'MAQUINA' AS subdepartamento, '0' AS encuadernacion, round(sum(byn_total),2) as byn, round(sum(color_total),2)  as color, '0' as varios 
FROM 
gastos_maquina 
WHERE 
departamento_id in (SELECT ud1.departamento_id FROM usuariodepartamento ud1 WHERE ud1.usuario_id = ?) AND MONTH(periodo) = ? AND YEAR(periodo) = ?";
$recuperaValidadorGlobalPorDpto =
"SELECT
sd1.treintabarra AS esb,de1.ceco AS codigo,de1.departamentos_desc AS departamento,sd1.subdepartamento_desc AS subdepartamento,SUM(t1.precioEncuadernacion) AS encuadernacion,SUM(t1.precioByN) AS byn,SUM(t1.precioColor) AS color,SUM(t1.PrecioVarios) AS varios
FROM
solicitud s1 INNER JOIN trabajo t1 ON s1.solicitud_id = t1.solicitud_id INNER JOIN departamento de1 ON s1.departamento_id = de1.departamento_id and de1.markfordelete=0 INNER JOIN subdepartamento sd1 ON s1.departamento_id = sd1.departamento_id AND s1.subdepartamento_id = sd1.subdepartamento_id and sd1.markfordelete=0
WHERE
s1.status_id = 6 AND s1.departamento_id IN(?) AND MONTH(s1.fecha_validacion) = ? AND YEAR(s1.fecha_validacion) = ?
GROUP BY de1.ceco UNION
SELECT
'IMPRESORA' AS esb,'IMPRESORA' AS codigo,'IMPRESORA' AS departamento,'IMPRESORA' AS subdepartamento,'0' AS encuadernacion,round(sum(byn_total),2) as byn,round(sum(color_total),2)  as color,'0' as varios
FROM
gastos_impresora
WHERE
departamento_id in (?) AND MONTH(periodo) = ? AND YEAR(periodo) = ?
UNION
SELECT
'MAQUINA' AS esb,'MAQUINA' AS codigo,'MAQUINA' AS departamento,'MAQUINA' AS subdepartamento,'0' AS encuadernacion,round(sum(byn_total),2) as byn,round(sum(color_total),2)  as color,'0' as varios
FROM
gastos_maquina
WHERE
departamento_id in (?) AND MONTH(periodo) = ? AND YEAR(periodo) = ?";
$recuperaTodosUsuarios = 
"SELECT DISTINCT CONCAT(usuario.nombre, ' ', usuario.apellido) as nombre, role.role_desc as rol, departamento.departamentos_desc as nombreDepartamento 
		from usuario inner join role on role.role_id = usuario.role_id inner join usuariodepartamento on usuariodepartamento.usuario_id = usuario.usuario_id 
		inner join departamento on departamento.departamento_id = usuariodepartamento.departamento_id and departamento.markfordelete=0 ORDER BY nombre, nombreDepartamento ASC";
$variosUnoQuery = "select d1.tipo_id as tipo,d1.detalle_id as detalle,d1.descripcion as descripcion,d1.precio as precio,td.unidades as unidades,td.preciototal as preciototal
from detalle d1 left OUTER join	trabajodetalle td on td.tipo_id=d1.tipo_id and td.detalle_id=d1.detalle_id and td.solicitud_id = ? where d1.tipo_id = 3";
$colorQuery = "select d1.tipo_id as tipo,d1.detalle_id as detalle,d1.descripcion as descripcion,d1.precio as precio,td.unidades as unidades,td.preciototal as preciototal
from detalle d1 left OUTER join	trabajodetalle td on td.tipo_id=d1.tipo_id and td.detalle_id=d1.detalle_id and td.solicitud_id = ? where d1.tipo_id = 4";
$encuadernacionQuery = "select d1.tipo_id as tipo,d1.detalle_id as detalle,d1.descripcion as descripcion,d1.precio as precio,td.unidades as unidades,td.preciototal as preciototal
from detalle d1 left OUTER join	trabajodetalle td on td.tipo_id=d1.tipo_id and td.detalle_id=d1.detalle_id and td.solicitud_id = ? where d1.tipo_id = 1";
$encoladoQuery = "select d1.tipo_id as tipo,d1.detalle_id as detalle,d1.descripcion as descripcion,d1.precio as precio,td.unidades as unidades,td.preciototal as preciototal
from detalle d1 left OUTER join	trabajodetalle td on td.tipo_id=d1.tipo_id and td.detalle_id=d1.detalle_id and td.solicitud_id = ? where d1.tipo_id = 2";
$blancoYNegroQuery = "select d1.tipo_id as tipo,d1.detalle_id as detalle,d1.descripcion as descripcion,d1.precio as precio,td.unidades as unidades,td.preciototal as preciototal
from detalle d1 left OUTER join	trabajodetalle td on td.tipo_id=d1.tipo_id and td.detalle_id=d1.detalle_id and td.solicitud_id = ? where d1.tipo_id = 5";
$varios2Query = "select d1.tipo_id as tipo,d1.detalle_id as detalle,d1.descripcion as descripcion,d1.precio as precio,td.unidades as unidades,td.preciototal as preciototal
from detalle d1 left OUTER join	trabajodetalle td on td.tipo_id=d1.tipo_id and td.detalle_id=d1.detalle_id and td.solicitud_id = ? where d1.tipo_id = 6";
$varios2QueryTabla = "select d1.tipo_id as tipo,d1.detalle_id as detalle,d1.descripcion as descripcion,d1.precio as precio,td.unidades as unidades,td.preciototal as preciototal from detalle d1 inner join trabajodetalle td on td.tipo_id=d1.tipo_id and td.detalle_id=d1.detalle_id where d1.tipo_id = 6 and td.solicitud_id = ?";
$varios2ExtraQuery = "select d1.tipo_id as tipo,d1.detalle_id as detalle,d1.descripcion as descripcion,d1.precio as precio,td.unidades as unidades,td.preciototal as preciototal
from detalle d1 inner join trabajodetalle td on td.tipo_id=d1.tipo_id and td.detalle_id=d1.detalle_id and td.solicitud_id = ? where d1.tipo_id = 7";

$consultaDetalleJSON = "SELECT unidades, preciototal FROM trabajodetalle WHERE trabajo_id = ? and tipo_id = ? and detalle_id = ? and solicitud_id = ?";
$detalleVarios2PorId = "SELECT detalle_id, tipo_id, descripcion, precio from detalle where tipo_id = 6 and detalle_id = ?";
$sentenciaDepartamentoJSON = "SELECT d1.departamentos_desc, d1.ceco from departamento d1 inner join solicitud s1 on s1.departamento_id = d1.departamento_id and s1.solicitud_id = ? and d1.markfordelete = 0";
$sentenciaSubDepartamentoJSON = "SELECT d1.subdepartamento_desc, d1.treintabarra from subdepartamento d1 inner join solicitud s1 on s1.subdepartamento_id = d1.subdepartamento_id and s1.solicitud_id = ? and d1.markfordelete = 0";
$sentenciaSolicitanteJSON = "SELECT nombre_solicitante as nombre, apellidos_solicitante as apellido from solicitud where solicitud_id = ?";
$recuperaDetalleSubdepartamento = "SELECT departamento_id, subdepartamento_id, subdepartamento_desc, treintabarra from subdepartamento where departamento_id = ? and subdepartamento_id = ? and markfordelete = 0";
$sentenciaLogonJSON = "SELECT usuario_id, logon, password, nombre, apellido, role_id from usuario where logon = ? and password = ?";
$consultaTrabajoJSON = "SELECT solicitud_id from trabajo where solicitud_id = ?";
$consultaCeco = "SELECT d1.ceco from departamento d1 inner join solicitud s1 on s1.departamento_id = d1.departamento_id and s1.solicitud_id = ? and d1.markfordelete=0";
$consultaCodigo = "SELECT sd1.treintabarra from subdepartamento sd1 inner join solicitud s1 on s1.departamento_id = sd1.departamento_id and s1.subdepartamento_id = sd1.subdepartamento_id and s1.solicitud_id = ? and sd1.markfordelete=0";
$consultaDepartamentoId = "SELECT d1.departamento_id from departamento d1 inner join solicitud s1 on s1.departamento_id = d1.departamento_id and s1.solicitud_id = ? and d1.markfordelete=0";
$consultaSubDepartamentoId = "SELECT sd1.subdepartamento_id from subdepartamento sd1 inner join solicitud s1 on s1.departamento_id = sd1.departamento_id and s1.subdepartamento_id = sd1.subdepartamento_id and s1.solicitud_id = ? and sd1.markfordelete = 0";

$comprobarVarios2ExtraJSON = "SELECT detalle_id, tipo_id, descripcion, precio from detalle where tipo_id=7 and  descripcion = ? and  precio = ?";
$comprobarVarios2TrabajoExtraJSON = "SELECT trabajo_id, tipo_id, detalle_id, unidades,fecha_cierre,solicitud_id, preciototal from trabajodetalle where tipo_id=7 and solicitud_id = ? and detalle_id = ?";
$listadoVarios2Query = "SELECT detalle_id, tipo_id, descripcion, precio from detalle where tipo_id = 7  and lower(descripcion) like ?";
?>
