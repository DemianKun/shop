<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once("conexion.php");

$resultado = $conn->query("
    SELECT id_usuario, nombre, fecha_registro, id_rol 
    FROM usuario
    ORDER BY id_rol
");

$roles = [
    3 => []
];

while($row = $resultado->fetch_assoc()){
    $roles[$row['id_rol']][] = $row;
}
?>

<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial; }
        ul { list-style: none; padding: 0; }
        li { background: #f2f2f2; margin: 5px 0; padding: 8px; border-radius: 5px; }
        h2 { background: #007bff; color: white; padding: 6px; }
    </style>
</head>
<body>
    
<h2> Repartidores </h2>
<ul>
<?php foreach($roles[3] as $usuario): ?>
    <li>
        ID: <?= $usuario['id_usuario'] ?> |
        Nombre: <?= htmlspecialchars($usuario['nombre']) ?> |
        Fecha: <?= $usuario['fecha_registro'] ?> |
        Rol: <?= $usuario['id_rol'] ?>
    </li>
<?php endforeach; ?>
</ul>

</body>
</html>