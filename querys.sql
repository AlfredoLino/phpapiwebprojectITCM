SELECT *
FROM profesor JOIN grupo ON profesor._id = grupo.profesor
JOIN asignacion ON grupo._id = asignacion.grupo

SELECT alumno.ncontrol, asignacion.grupo, asignacion.calificacion FROM profesor JOIN grupo ON profesor._id = grupo.profesor JOIN asignacion ON grupo._id = asignacion.grupo JOIN alumno ON asignacion.alumno = alumno.ncontrol