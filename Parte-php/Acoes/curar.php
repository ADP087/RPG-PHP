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

if(!isset($_SESSION["player"])) {
    echo json_encode([
        "ok" => false,
        "erro" => "Nenhuma batalha foi iniciada.",
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

$acao = $_POST["acao"] ?? "";

if($acao !== "curar") {
    echo json_encode([
        "ok" => false,
        "erro" => "Ação inválida.",
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

$player = $_SESSION["player"];
$vidaPlayer = (int)($_SESSION["vida_player"] ?? 0);

if($vidaPlayer <= 0) {
    echo json_encode([
        "ok" => false,
        "erro" => "A batalha já terminou.",
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

if($vidaPlayer >= $player["vida_max"]) {
    echo json_encode([
        "ok" => false,
        "error" => "A vida do " . $player["nome"] . " já está cheia",
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

$mensagens = '';

$curaConquistada = rand(1, (int)($player["vida_max"] / 2));

$vidaPlayer += $curaConquistada;

if($vidaPlayer > $player["vida_max"]) {
    $vidaPlayer = $player["vida_max"];

    $mensagens = $player["nome"] . " conseguiu encher o HP";
} else {
    $mensagens = $player["nome"] . " conseguiu curar " . $curaConquistada . "HP";
}

$_SESSION["vida_player"] = $vidaPlayer;

echo json_encode([
    "ok" => true,
    "mensagens" => $mensagens,
    "vidaPlayer" => $vidaPlayer,
    "vidaMaxPlayer" => (int)$player["vida_max"],
], JSON_UNESCAPED_UNICODE);
exit;

?>