<?php
session_start();
header("Content-Type: application/json; charset=utf-8");

if($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode([
        "ok" => false,
        "erro" => "Requisição inválida.",
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

if(!isset($_SESSION["player"], $_SESSION["computador"])) {
    echo json_encode([
        "ok" => false,
        "erro" => "Nenhum batalha foi iniciada.",
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

$acao = $_POST["acao"] ?? "";

if($acao !== "bater") {
    echo json_encode([
        "ok" => false,
        "erro" => "Ação inválida.",
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

$player = $_SESSION["player"];
$computador = $_SESSION["computador"];

$vidaPlayer = (int)($_SESSION["vida_player"] ?? 0);
$vidaComputador = (int)($_SESSION["vida_computador"] ?? 0);

if($vidaPlayer <= 0 || $vidaComputador <= 0) {
    echo json_encode([
        "ok" => false,
        "erro" => "A batalha já terminou.",
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

$mensagens = [];
$fim = false;
$vencedor = null;

// Jogador ataca
$danoPlayer = rand((int)($player["ataque"] / 2), (int)$player["ataque"]);
$danoFinal = max(0, $danoPlayer - (int)((int)$computador["defesa"]) / 2);

$vidaComputador -= $danoFinal;

if($vidaComputador < 0) {
    $vidaComputador = 0;
}

$mensagens[] = $player["nome"] . " atacou causando " . $danoFinal . " de dano.";

if($vidaComputador === 0) {
    $mensagens[] = $computador["nome"] . " morreu! " . $player["nome"] . " venceu!";
    $fim = true;
    $vencedor = "player";
} else {
    // Computador batendo
    $danoComp = rand((int)($computador["ataque"] / 2), (int)$computador["ataque"]);
    $danoFinal = max(0, $danoComp - (int)((int)$player["defesa"]) / 2);

    $vidaPlayer -= $danoFinal;

    if($vidaPlayer < 0) {
        $vidaPlayer = 0;
    }

    $mensagens[] = $computador["nome"] . " atacou causando " . $danoFinal . " de dano.";

    if($vidaPlayer === 0) {
        $mensagens[] = $player["nome"] . " morreu! " . $computador["nome"] . " venceu!";
        $fim = true;
        $vencedor = "computador";
    }
}

// Atualiza a sessão
$_SESSION["vida_player"] = $vidaPlayer;
$_SESSION["vida_computador"] = $vidaComputador;

if($fim) {
    $_SESSION["batalha_ativa"] = false;
    $_SESSION["turno"] = null;
} else {
    $_SESSION["turno"] = "player";
}

echo json_encode([
    "ok" => true,
    "mensagens" => $mensagens,
    "vidaPlayer" => $vidaPlayer,
    "vidaComputador" => $vidaComputador,
    "vidaMaxPlayer" => (int)$player["vida_max"],
    "vidaMaxComputador" => (int)$computador["vida_max"],
    "fim" => $fim,
    "vencedor" => $vencedor
], JSON_UNESCAPED_UNICODE);
exit;

?>