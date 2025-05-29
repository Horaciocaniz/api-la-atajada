<?php header('Access-Control-Allow-Origin: *'); ?>
<?php
header('Access-Control-Allow-Origin: https://la-atajada.com');
header("Content-Type: application/json");




// Aquí sigue tu código...


// api/get_academias.php
// Al inicio del archivo PHP

try {
    // Conexión a la base de datos
    $pdo = new PDO("mysql:host=localhostsql203.infinityfree.com;dbname=if0_38490454_asistencia;charset=utf8", "if0_38490454", "Horaciocaniz7", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    // Consulta para obtener todas las academias
    $stmt = $pdo->prepare("SELECT id, nombre FROM academias ORDER BY nombre ASC");
    $stmt->execute();
    $academias = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Puedes agregar una ruta de logo genérico si aún no tienes logos reales
    foreach ($academias as &$a) {
        $a['logo'] = "la-atajada-logo.png"; // Ajusta esto según tu estructura real
    }

    echo json_encode($academias);

} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
    http_response_code(500);
}
