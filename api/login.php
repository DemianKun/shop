<?php
session_start();
header("Content-Type: application/json");
error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once("conexion.php");

$accion = $_POST['accion'] ?? '';

switch($accion){

    case "login":

        $correo = trim($_POST['correo'] ?? "");
        $contrasena = trim($_POST["contrasena"] ?? "");

        if (empty($correo) || empty($contrasena)) {
            echo json_encode([
                "status" => "error",
                "message" => "Campos vacíos"
            ]);
            exit;
        }

        $sql = "SELECT id_usuario, correo, contrasena, id_rol 
                FROM usuario 
                WHERE correo = ?";

        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            echo json_encode([
                "status" => "error",
                "message" => "Error en prepare"
            ]);
            exit;
        }

        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows === 1) {
            $usuario = $resultado->fetch_assoc();

            if (password_verify($contrasena, $usuario['contrasena'])) {

                $_SESSION['id_usuario'] = $usuario['id_usuario'];
                $_SESSION['id_rol'] = $usuario['id_rol'];

                echo json_encode([
                    "status" => "success",
                    "id_usuario" => $usuario['id_usuario'],
                    "id_rol" => $usuario['id_rol']
                ]);

            } else {
                echo json_encode([
                    "status" => "error",
                    "message" => "Contraseña incorrecta"
                ]);
            }

        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Correo no encontrado"
            ]);
        }

        $stmt->close();
        break;

    default:
        echo json_encode([
            "status" => "error",
            "message" => "Acción no válida"
        ]);
        break;
}

$conn->close();
?>