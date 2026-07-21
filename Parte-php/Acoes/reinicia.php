<?php
session_start();

unset($_SESSION["player"]);
unset($_SESSION["computador"]);
unset($_SESSION["vida_player"]);
unset($_SESSION["vida_computador"]);
unset($_SESSION["turno"]);
unset($_SESSION["batalha_ativa"]);

header("Content-Type: aplication/json");

echo json_encode([
    "ok" => true
]);
?>