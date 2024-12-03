<?php
include('layouts/header.php');

// Recebe a data de nascimento no formato YYYY-MM-DD
$data_nascimento = $_POST['data_nascimento'];

// Carrega o arquivo XML com os signos
$signos = simplexml_load_file("signos.xml");

// Extrai o dia e o mês da data de nascimento
list($ano, $mes, $dia) = explode("-", $data_nascimento);
$data_nascimento_formatada = "$mes-$dia";

// Inicializa o signo como "não encontrado"
$signo_encontrado = null;

// Percorre os signos no XML
foreach ($signos->signo as $signo) {
    // Extrai as datas de início e fim de cada signo
    $data_inicio = $signo->dataInicio; // Ex.: 21/03
    $data_fim = $signo->dataFim;       // Ex.: 20/04

    // Converte as datas de início e fim para o formato MM-DD para comparar
    list($dia_inicio, $mes_inicio) = explode("/", $data_inicio);
    list($dia_fim, $mes_fim) = explode("/", $data_fim);

    $data_inicio_formatada = "$mes_inicio-$dia_inicio";
    $data_fim_formatada = "$mes_fim-$dia_fim";

    // Ajusta a lógica para signos que cruzam o ano (ex.: Sagitário e Capricórnio)
    if ($data_inicio_formatada > $data_fim_formatada) {
        // Caso a data de nascimento seja de Dezembro ou Janeiro
        if ($data_nascimento_formatada >= $data_inicio_formatada || $data_nascimento_formatada <= $data_fim_formatada) {
            $signo_encontrado = $signo;
            break;
        }
    } else {
        // Signos normais que não cruzam o ano
        if ($data_nascimento_formatada >= $data_inicio_formatada && $data_nascimento_formatada <= $data_fim_formatada) {
            $signo_encontrado = $signo;
            break;
        }
    }
}

// Exibe o resultado
if ($signo_encontrado) {
    echo "<h1>" . $signo_encontrado->signoNome . "</h1>";
    echo "<p>" . $signo_encontrado->descricao . "</p>";
} else {
    echo "<h1>Signo não encontrado!</h1>";
}
?>
