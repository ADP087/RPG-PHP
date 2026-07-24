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

$player = $_SESSION["player"];
$vidaPlayer = (int)($_SESSION["vida_player"] ?? 0);

$computador = $_SESSION["computador"];
$vidaComputador = (int)($_SESSION["vida_computador"] ?? 0);

$mensagens = [];
$fim = false;
$vencedor = null;

$turno = $_SESSION["turno"] ?? "player";

if($vidaPlayer <= 0 || $vidaComputador <= 0) {
    echo json_encode([
        "ok" => false,
        "erro" => "A batalha já terminou.",
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

if($turno !== "player") {
    $acaoComputador = rand(1, 100);

    if($acaoComputador <= 70 || $vidaComputador == $computador["vida_max"]) {
        // ATAQUE
        $danoComputador = rand((int)($computador["ataque"] / 2), (int)$computador["ataque"]);
        $danoFinal = max(0, $danoComputador - (int)((int)$player["defesa"]) / 2);

        $vidaPlayer -= $danoFinal;

        if($vidaPlayer < 0) {
            $vidaPlayer = 0;
        }

        $mensagens[] = $computador["nome"] . " atacou causando " . $danoFinal . " de dano.";

        if($vidaPlayer === 0) {
            $mensagens[] = $player["nome"] . " morreu! " . $computador["nome"] . " venceu!";
            $fim = true;
            $vencedor = $computador["nome"];
        }

    } else {
        // CURA
        $curaConquistada = rand(1, (int)($computador["vida_max"] / 2));

        $vidaComputador += $curaConquistada;

        if($vidaComputador >= $computador["vida_max"]) {
            $vidaComputador = $computador["vida_max"];

            $mensagens[] = $computador["nome"] . " conseguiu encher o HP";
        } else {
            $mensagens[] = $computador["nome"] . " conseguiu curar " . $curaConquistada . "HP";
        }
    }

    // Atualiza a sessão
    $_SESSION["vida_player"] = $vidaPlayer;
    $_SESSION["vida_computador"] = $vidaComputador;

    $_SESSION["turno"] = "player";

    echo json_encode([
        "ok" => true,
        "mensagens" => $mensagens,
        "vidaPlayer" => $vidaPlayer,
        "vidaComputador" => $vidaComputador,
        "vidaMaxPlayer" => (int)$player["vida_max"],
        "vidaMaxComputador" => (int)$computador["vida_max"],
        "fim" => $fim,
        "vencedor" => null
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

switch($acao) {
    case 'curar':
        if($vidaPlayer >= $player["vida_max"]) {
            echo json_encode([
                "ok" => false,
                "erro" => "A vida do " . $player["nome"] . " já está cheia",
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $curaConquistada = rand(1, (int)($player["vida_max"] / 2));

        $vidaPlayer += $curaConquistada;

        if($vidaPlayer >= $player["vida_max"]) {
            $vidaPlayer = $player["vida_max"];

            $mensagens[] = $player["nome"] . " conseguiu encher o HP";
        } else {
            $mensagens[] = $player["nome"] . " conseguiu curar " . $curaConquistada . "HP";
        }

        // Atualiza a sessão
        $_SESSION["vida_player"] = $vidaPlayer;
        break;

    case 'bater':
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
            $vencedor = $player["nome"];
        }

        // Atualiza a sessão
        $_SESSION["vida_computador"] = $vidaComputador;
        break;
    
    default:
        echo json_encode([
            "ok" => false,
            "erro" => "Ação inválida.",
        ], JSON_UNESCAPED_UNICODE);
        exit;
}

$_SESSION["turno"] = "computador";

echo json_encode([
    "ok" => true,
    "mensagens" => $mensagens,
    "vidaPlayer" => $vidaPlayer,
    "vidaComputador" => $vidaComputador,
    "vidaMaxPlayer" => (int)$player["vida_max"],
    "vidaMaxComputador" => (int)$computador["vida_max"],
    "fim" => $fim,
    "vencedor" => $vencedor
], JSON_UNESCAPED_UNICODE); // Aqui está enviando tudo de forma de texto
exit;
?>