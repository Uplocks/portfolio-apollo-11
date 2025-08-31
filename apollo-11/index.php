<?php

/* CONSTANTES */
const lua_distancia = 384400;
const trecho_km = 15376;

/* RECEBER OS VALORES DO FORM */
$combustivel_inicial = isset($_POST['total_combustivel']) ? (float)$_POST['total_combustivel'] : 0;
$consumo = isset($_POST['consumo']) ? (float)$_POST['consumo'] : 0;
$nome_completo = isset($_POST['nome_completo']) ? htmlspecialchars($_POST['nome_completo']) : "Piloto";

/* INÍCIO DAS VARIÁVEIS */
$distancia_foguete = 0;
$combustivel_atual = $combustivel_inicial;
$historico_combustivel = [];

/* LOOP */
while ($combustivel_atual >= $consumo && $distancia_foguete < lua_distancia) {
    $historico_combustivel[] = [
        "trecho" => ($distancia_foguete / trecho_km) + 1,
        "distancia" => $distancia_foguete,
        "combustivel_restante" => round($combustivel_atual, 2)
    ];
    $distancia_foguete += trecho_km;
    $combustivel_atual -= $consumo;
}

$missao_sucesso = ($distancia_foguete >= lua_distancia);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apollo 11 - Resultado da Missão</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="results-container">
        <h2>📑Relatório da Missão</h2>

        <?php 
        if ($missao_sucesso) {
            echo '<h3>Um pequeno passo para o homem, mas um grande passo para a humanidade!</h3>';
            echo '<h4> Parabéns, '. $nome_completo ."! </h4>";
            echo '<img src="images/astronauta_feliz.png" alt="Sucesso" width="200">';
            echo '<p>Combustível restante: <strong>' . round($combustivel_atual, 2) . ' litros</strong>.</p>';
        } else {
            echo '<h3> Missão falhou! Sem combustível suficiente... 💥</h3>';
            echo '<img src="images/astronauta_sad.png" alt="Falha" width="200">';
            echo '<p>Distância percorrida: <strong>' . $distancia_foguete . ' Km</strong></p>';
        }

        echo '<h3>Histórico da Viagem:</h3>';
        echo '<ul class="mission-log">';
        foreach ($historico_combustivel as $registro) {
            echo '<li>Ao início do Trecho ' . $registro['trecho'] . ' (' . $registro['distancia'] . ' Km), o tanque tinha: ' . $registro['combustivel_restante'] . ' litros.</li>';
        }
        echo '</ul>';
        ?>
        <br>
        <a href="index.html" class="button-link">⬅️ Realizar nova missão</a>

    </div>

</body>
</html>