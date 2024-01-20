<?php 
// Incluindo o arquivo de conexão
include("conexao.php");

// Definindo cabeçalhos para permitir requisições cross-origin
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: PUT, OPTIONS"); // Adicionando OPTIONS para permitir a verificação prévia (preflight) CORS

// Verifica se é uma solicitação OPTIONS e responde imediatamente sem processar o restante do código
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Obter dados do corpo da requisição
$obterDados = file_get_contents("php://input");

// Extrair os dados do formato JSON
$extrair = json_decode($obterDados);

// Separar os dados do JSON
$idCurso = $extrair->cursos->idCurso;
$nomeCurso = $extrair->cursos->nomeCurso;
$valorCurso = $extrair->cursos->valorCurso;

// Construir a consulta SQL para alterar os dados na tabela 'cursos'
$sql = "UPDATE cursos SET nomeCurso='$nomeCurso', valorCurso=$valorCurso WHERE idCurso=$idCurso";

// Executar a consulta SQL na conexão com o banco de dados
$result = mysqli_query($conexao, $sql);

// Verificar se houve algum erro na execução da consulta
if (!$result) {
    http_response_code(500);
    echo json_encode(['error' => mysqli_error($conexao)]);
    exit;
}

// Preparar os dados do curso para exportação
$curso = [
    'idCurso' => $idCurso,
    'nomeCurso' => $nomeCurso,
    'valorCurso' => $valorCurso
];

// Codificar os dados do curso em formato JSON e imprimir na saída
echo json_encode(['curso' => $curso]);
?>
