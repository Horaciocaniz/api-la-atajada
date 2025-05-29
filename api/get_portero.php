<?php
header("Access-Control-Allow-Origin: https://la-atajada.com");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");



if (!isset($_GET['id'])) {
    echo json_encode(['error' => 'ID de portero no especificado']);
    exit;
}

$id = $_GET['id'];

try {
    // Conexión a la base de datos
    $pdo = new PDO("mysql:host=localhostsql203.infinityfree.com;dbname=if0_38490454_asistencia;charset=utf8", "if0_38490454", "Horaciocaniz7", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    $sql = "SELECT 
            p.id,
            p.nombre,
            p.imagen,
            a.nombre AS academia,
            xp.ovr_actual,
            xp.xp_total,
            xp.xp_necesario,
            xp.xp_atr,
            xp.xp_jae,
            xp.xp_voz,
            xp.xp_cai,
            xp.xp_jpie
        FROM porteros p
        LEFT JOIN academias a ON p.academia_id = a.id
        LEFT JOIN xp_portero xp ON xp.portero_id = p.id
        WHERE p.id = ?";



    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $portero = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($portero) {
        echo json_encode($portero);
    } else {
        echo json_encode(['error' => 'Portero no encontrado']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
}
