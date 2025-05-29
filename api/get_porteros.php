<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");


if (!isset($_GET['id_academia'])) {
    echo json_encode(['error' => 'Parámetro id_academia requerido']);
    exit;
}

$idAcademia = intval($_GET['id_academia']);

try {
    // Conexión a la base de datos
    $pdo = new PDO("mysql:host=sql203.infinityfree.com;dbname=if0_38490454_asistencia;charset=utf8", "if0_38490454", "Horaciocaniz7", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);


    // Obtener nombre de la academia
    $stmtAcademia = $pdo->prepare("SELECT nombre FROM academias WHERE id = :idAcademia");
    $stmtAcademia->execute(['idAcademia' => $idAcademia]);
    $academia = $stmtAcademia->fetch(PDO::FETCH_ASSOC);

    if (!$academia) {
        echo json_encode(['error' => 'Academia no encontrada']);
        exit;
    }

    // Obtener porteros de la academia
    $stmt = $pdo->prepare("
        SELECT p.id, p.nombre, p.imagen, x.ovr_actual AS ovr
        FROM porteros p
        LEFT JOIN xp_portero x ON p.id = x.portero_id
        WHERE p.academia_id = :idAcademia
        ORDER BY p.nombre ASC
    ");
    $stmt->execute(['idAcademia' => $idAcademia]);
    $porteros = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Resultado combinado
    echo json_encode([
        'academia' => $academia['nombre'],
        'porteros' => $porteros
    ]);

} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
