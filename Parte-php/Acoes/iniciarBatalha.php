<?php
session_start();
include("../Conexao.php");

if($_SERVER["REQUEST_METHOD"] !== "POST" || !isset($_POST["escolha"])) {
    header("Location: ../batalha.php");
    exit;
}

$playerID = filter_input(INPUT_POST, "escolha", FILTER_VALIDATE_INT);

if(!$playerID) {
    header("Location: ../batalha.php");
    exit;
}

// Buscar o PLAYER
$sqlPlayer = "SELECT * FROM guerreiros WHERE id = ?";
$stmtPlayer = $conn->prepare($sqlPlayer);
$stmtPlayer->bind_param("i", $playerID);
$stmtPlayer->execute();
$resPlayer = $stmtPlayer->get_result();
$player = $resPlayer->fetch_assoc();

if(!$player) {
    header("Location: ../batalha.php");
    exit;
}

// Buscar o COMPUTADOR
$sqlComp = "SELECT * FROM guerreiros WHERE id <> ? ORDER BY RAND() LIMIT 1";
$stmtComp = $conn->prepare($sqlComp);
$stmtComp->bind_param("i", $playerID);
$stmtComp->execute();
$resComp = $stmtComp->get_result();
$computador = $resComp->fetch_assoc();

if(!$computador) {
    header("Location: ../batalha.php");
    exit;
}

// Salva o estado da batalha na sessão
$_SESSION["player"] = [
    "id" => (int)$player["id"],
    "nome" => $player["nome"],
    "classe" => $player["classe"],
    "ataque" => (int)$player["ataque"],
    "defesa" => (int)$player["defesa"],
    "vida_max" => (int)$player["vida"]
];

$_SESSION["computador"] = [
    "id" => (int)$computador["id"],
    "nome" => $computador["nome"],
    "classe" => $computador["classe"],
    "ataque" => (int)$computador["ataque"],
    "defesa" => (int)$computador["defesa"],
    "vida_max" => (int)$computador["vida"]
];

$_SESSION["vida_player"] = (int)$player["vida"];
$_SESSION["vida_computador"] = (int)$computador["vida"];

// Controle do turno
$_SESSION["turno"] = "player";
$_SESSION["batalha_ativa"] = true;

header("Location: ../batalha.php");
exit;
?>