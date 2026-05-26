<?php
header("Content-Type: application/json");
error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once("conexion.php");

$accion = $_POST['accion'] ?? '';

switch($accion){
    
    case "registrar":
        $id_usuario = "";
        $nombre = trim($_POST["nombre"] ?? "");
        $correo = trim($_POST["correo"] ?? "");
        $contrasena = trim($_POST["contrasena"] ?? "");
        $id_rol = intval($_POST["id_rol"] ?? 0);

        if($nombre=="" || $correo=="" || $contrasena=="" || $id_rol==0){
            echo json_encode(["status"=>"error","mensaje"=>"Campos vacíos o rol inválido"]);
            exit;
        }

        // Verificar si ya existe correo
        $verificar = $conn->prepare("SELECT id_usuario FROM usuario WHERE correo = ?");
        $verificar->bind_param("s", $correo);
        $verificar->execute();
        $verificar->store_result();

        if($verificar->num_rows > 0){
            echo json_encode(["status"=>"error","mensaje"=>"Correo ya registrado"]);
            exit;
        }

        $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO usuario (nombre, correo, contrasena, id_rol) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $nombre, $correo, $contrasena_hash, $id_rol);

        if($stmt->execute()){
            echo json_encode(["status"=>"ok","mensaje"=>"Usuario registrado"]);
        }else{
            echo json_encode(["status"=>"error","mensaje"=>$stmt->error]);
        }

        $stmt->close();
        break;

    default:
        echo json_encode(["status"=>"error","mensaje"=>"Acción no válida"]);
}

$conn->close();
?>