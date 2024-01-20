<?php
    // Inclui o arquivo que contém a lógica de conexão com o banco de dados
    include("conexao.php");

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

    // Define uma consulta SQL para selecionar todos os registros da tabela "cursos"
    $sql = "SELECT * FROM cursos";

    // Executa a consulta SQL no banco de dados usando a conexão estabelecida
    $executar = mysqli_query($conexao, $sql);

    // Inicializa um array vazio chamado $cursos, que será usado para armazenar os resultados da consulta
    $cursos = [];

    // Inicializa uma variável $indice que será usada como índice para o array $cursos
    $indice = 0;

    // Inicia um loop que percorre cada linha do resultado da consulta
    while($linha = mysqli_fetch_assoc($executar)) {
        // Armazena o valor da coluna 'idCurso' da linha atual no array $cursos
        $cursos[$indice]['idCurso'] = $linha['idCurso'];

        // Armazena o valor da coluna 'nomeCurso' da linha atual no array $cursos
        $cursos[$indice]['nomeCurso'] = $linha['nomeCurso'];

        // Armazena o valor da coluna 'valorCurso' da linha atual no array $cursos
        $cursos[$indice]['valorCurso'] = $linha['valorCurso'];

        // Incrementa o índice para a próxima iteração do loop
        $indice++;
    }

    // Converte o array $cursos para o formato JSON e imprime como resposta
    echo json_encode(['cursos' => $cursos]);

    // O script PHP é encerrado
?>
