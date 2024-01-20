<?php
// Incluindo o arquivo de conexão
include("conexao.php");

// Configurações CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

// Verifica se é uma solicitação OPTIONS e responde imediatamente sem processar o restante do código
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("Access-Control-Allow-Methods: POST, OPTIONS"); // Adicionei OPTIONS para permitir a verificação prévia (preflight) CORS
    http_response_code(200);
    exit;
}

// Obter dados do corpo da requisição
$obterDados = file_get_contents("php://input");

// Extrair os dados do formato JSON
$extrair = json_decode($obterDados);

// Verifica se os dados foram decodificados corretamente
if (!$extrair) {
    http_response_code(400);
    echo json_encode(['error' => 'Dados inválidos']);
    exit;
}

// Separar os dados do JSON
$nomeCurso = $extrair->curso->nomeCurso;
$valorCurso = $extrair->curso->valorCurso;

// Verifica se os dados esperados estão presentes
if (empty($nomeCurso) || !is_numeric($valorCurso)) {
    http_response_code(400);
    echo json_encode(['error' => 'Dados inválidos']);
    exit;
}

// Construir a consulta SQL para inserir os dados na tabela 'cursos'
$sql = "INSERT INTO cursos (nomeCurso, valorCurso) VALUES ('$nomeCurso', '$valorCurso')";

// Executar a consulta SQL na conexão com o banco de dados
if (mysqli_query($conexao, $sql)) {
    // Preparar os dados do curso para exportação
    $curso = [
        'nomeCurso' => $nomeCurso,
        'valorCurso' => $valorCurso
    ];

    // Codificar os dados do curso em formato JSON e imprimir na saída
    echo json_encode(['curso' => $curso]);
} else {
    // Se houver um erro na consulta SQL
    http_response_code(500);
    echo json_encode(['error' => 'Erro interno no servidor']);
}
?>
