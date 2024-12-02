<?php include('layouts/header.php'); ?>

<?php
// Receber a data de nascimento
$data_nascimento = $_POST['data_nascimento'];
$data_formatada = date("d/m", strtotime($data_nascimento));

// Carregar o arquivo XML
$signos = simplexml_load_file("signos.xml");

// Iterar os signos e encontrar o correspondente
$signo_encontrado = null;
foreach ($signos->signo as $signo) {
    $dataInicio = DateTime::createFromFormat('d/m', (string)$signo->dataInicio);
    $dataFim = DateTime::createFromFormat('d/m', (string)$signo->dataFim);
    $dataAtual = DateTime::createFromFormat('d/m', $data_formatada);

    if (($dataAtual >= $dataInicio) && ($dataAtual <= $dataFim)) {
        $signo_encontrado = $signo;
        break;
    }
}
?>

<div class="container mt-5 text-center">
    <?php if ($signo_encontrado): ?>
        <h1><?php echo $signo_encontrado->signoNome; ?></h1>
        <p><?php echo $signo_encontrado->descricao; ?></p>
    <?php else: ?>
        <h1>Signo não encontrado!</h1>
    <?php endif; ?>
    <a href="index.php" class="btn btn-secondary mt-3">Voltar</a>
</div>
