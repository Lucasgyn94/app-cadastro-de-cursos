<?php
    // variáveis
    $url = "localhost";
    $usuario = "root";
    $senha = "";
    $base = "api";

    //conexão
    $conexao = mysqli_connect($url, $usuario, $senha, $base);

    // Correção de erros sobre caracteres especiais
    mysqli_set_charset($conexao, "utf8");
?>