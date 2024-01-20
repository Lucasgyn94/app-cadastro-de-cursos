<?php
// Incluindo o arquivo de conexão
include("conexao.php");

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: DELETE, OPTIONS"); // Adicione DELETE às permissões

// Verifica se é uma solicitação OPTIONS e responde imediatamente sem processar o restante do código
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Separar os dados do JSON
$idCurso = $_GET['idCurso'];

// Construir a consulta SQL para excluir os dados na tabela 'cursos'
$sql = "DELETE FROM cursos WHERE idCurso=$idCurso";

$result = mysqli_query($conexao, $sql);

if (!$result) {
    http_response_code(500);
    echo json_encode(['error' => mysqli_error($conexao)]);
    exit;
}

// Não é necessário retornar um JSON neste caso
?>
