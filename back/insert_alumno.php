<?php

include("conexion.php");

$dni                    = $_POST['dni'];
$nombre                 = $_POST['nombre'];
$apellido               = $_POST['apellido'];
$fecha_nacimiento       = $_POST['fecha_nacimiento'];
$domicilio              = $_POST['domicilio'];
$localidad_id           = $_POST['localidad_id'];
$escuela_primaria_id    = $_POST['escuela_primaria_id'];

$tutor_dni              = $_POST['tutor_dni'];
$tutor_nombre           = $_POST['tutor_nombre'];
$tutor_apellido         = $_POST['tutor_apellido'];
$tutor_fecha_nacimiento = $_POST['tutor_fecha_nacimiento'];
$tutor_telefono         = $_POST['tutor_telefono'];
$tutor_email            = $_POST['tutor_email'];

$escuela_primera_opcion_id  = $_POST['escuela_primera_opcion_id'];
$escuela_segunda_opcion_id  = $_POST['escuela_segunda_opcion_id'] ?: NULL;
$escuela_tercera_opcion_id  = $_POST['escuela_tercera_opcion_id'] ?: NULL;
$turno_preferencia          = $_POST['turno_preferencia'];
$vinculo_escuela            = $_POST['vinculo_escuela'];

// Insertar tutor
$stmt = mysqli_prepare($conexion, "INSERT INTO tutores (dni, nombre, apellido, fecha_nacimiento, telefono, email) VALUES (?, ?, ?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, "ssssss", $tutor_dni, $tutor_nombre, $tutor_apellido, $tutor_fecha_nacimiento, $tutor_telefono, $tutor_email);
mysqli_stmt_execute($stmt);
if (mysqli_stmt_errno($stmt)) {
    echo json_encode(["status" => "error", "mensaje" => "Error al insertar tutor: " . mysqli_stmt_error($stmt)]);
    exit;
}
$tutor_id = mysqli_insert_id($conexion);

// Insertar estudiante
$stmt = mysqli_prepare($conexion, "INSERT INTO estudiantes (dni, nombre, apellido, fecha_nacimiento, domicilio, localidad_id, escuela_primaria_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, "sssssii", $dni, $nombre, $apellido, $fecha_nacimiento, $domicilio, $localidad_id, $escuela_primaria_id);
mysqli_stmt_execute($stmt);
if (mysqli_stmt_errno($stmt)) {
    echo json_encode(["status" => "error", "mensaje" => "Error al insertar estudiante: " . mysqli_stmt_error($stmt)]);
    exit;
}
$estudiante_id = mysqli_insert_id($conexion);

// Insertar inscripcion
$stmt = mysqli_prepare($conexion, "INSERT INTO inscripciones (estudiante_id, tutor_id, escuela_primera_opcion_id, escuela_segunda_opcion_id, escuela_tercera_opcion_id, turno_preferencia, vinculo_escuela) VALUES (?, ?, ?, ?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, "iiiiiss", $estudiante_id, $tutor_id, $escuela_primera_opcion_id, $escuela_segunda_opcion_id, $escuela_tercera_opcion_id, $turno_preferencia, $vinculo_escuela);
mysqli_stmt_execute($stmt);
if (mysqli_stmt_errno($stmt)) {
    echo json_encode(["status" => "error", "mensaje" => "Error al insertar inscripción: " . mysqli_stmt_error($stmt)]);
    exit;
}

echo json_encode(["status" => "ok", "mensaje" => "Alumno inscripto correctamente"]);
?>