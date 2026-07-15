<?php 
session_start();
include("Conexao.php");

$sql = "SELECT * FROM guerreiros";
$resultados = $conn->query($sql);

function percentualVida(int $vidaAtual, int $vidaMax) : float {
    if($vidaMax <= 0) {
        return 0;
    }

    $p = ($vidaAtual / $vidaMax) * 100;
    return max(0, min(100, $p));
}

$emBatalha = isset($_SESSION["player"], $_SESSION["computador"], $_SESSION["vida_player"], $_SESSION["vida_computador"]);

$player = $emBatalha ? $_SESSION["player"] : null;
$computador = $emBatalha ? $_SESSION["computador"] : null;

$vidaPlayer = $emBatalha ? (int)$_SESSION["vida_player"] : 0;
$vidaComputador = $emBatalha ? (int)$_SESSION["vida_computador"] : 0;

$vidaMaxPlayer = $emBatalha ? (int)$player["vida_max"] : 0;
$vidaMaxComputador = $emBatalha ? (int)$computador["vida_max"] : 0;
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../src/style-batalha.css">
    <title>Batalha</title>
</head>
<body>
    <header>
        <form method="post" class="form-esolha" action="Acoes/iniciarBatalha.php">
            <label>
                <p>Escolha o guerreiro que deseja ser: </p>
                <select name="escolha" id="escolha">
                    <?php foreach ($resultados as $usuario) : ?>
                        <option value="<?= (int)$usuario['id']?>">
                            <?= htmlspecialchars($usuario['nome']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>

            <input type="submit" name="enviar" value="<?= $emBatalha ? 'Trocar Guerreiro' : 'Batalhar' ?>">
        </form>
    </header>

    <main>
        <div class="container">
            <div class="personagens">
                <div class="div-personagem">
                    <?php if($emBatalha) : ?>
                        <h2>Player: <?= htmlspecialchars($player['nome']) ?> (HP: <?= $vidaPlayer ?>)</h2>
                    <?php else: ?>
                        <h2>Player</h2>
                    <?php endif; ?>    

                    <div class="quadro-img">
                        <?php if($emBatalha): ?>
                        <img src="../src/imgs/<?= htmlspecialchars($player['classe']) ?>.png" alt='Personagem do player'>
                        <?php endif; ?>
                    </div>

                    <div class="vida" id="vida-player">
                        <?= $emBatalha ? "HP: {$vidaPlayer} / {$vidaMaxPlayer}" : "HP: --" ?>
                    </div>

                    <div class="barra-vida">
                        <div class="barra-preenchida" id="barra-player" style="width: <?= $emBatalha ? percentualVida($vidaPlayer, $vidaMaxPlayer) : 0 ?>%"></div>
                    </div>
                </div>

                <h3>VS</h3>

                <div class="div-personagem">
                    <?php if($emBatalha) : ?>
                        <h2>Computador: <?= htmlspecialchars($computador['nome']) ?> (HP: <?= $vidaComputador ?>)</h2>
                    <?php else: ?>
                        <h2>Computador</h2>
                    <?php endif; ?>    

                    <div class="quadro-img">
                        <?php if($emBatalha): ?>
                        <img src="../src/imgs/<?= htmlspecialchars($computador['classe']) ?>.png" alt='Personagem do computador'>
                        <?php endif; ?>
                    </div>

                    <div class="vida" id="vida-computador">
                        <?= $emBatalha ? "HP: {$vidaComputador} / {$vidaMaxComputador}" : "HP: --" ?>
                    </div>

                    <div class="barra-vida">
                        <div class="barra-preenchida" id="barra-computador" style="width: <?= $emBatalha ? percentualVida($vidaComputador, $vidaMaxComputador) : 0 ?>%"></div>
                    </div>
                </div>
            </div>

            <br>
            <br>

            <div class="campo-batalha">
                <div class="chat-dano">
                    <?php if($emBatalha): ?>
                        <p>A batalha começou, escolha uma das ações:</p>
                    <?php else: ?>
                        <p>Escolha um guerreiro e clique em batalhar.</p>
                    <?php endif; ?>
                </div>

                <div class="espaco">
                    <div class="acoes">
                        <button class="btn-cura">Curar</button>
                        <button class="btn-bater" <?= $emBatalha ? '' : 'disabled' ?>>Bater</button>
                        <button class="btn-esquivar">Esquivar</button>
                        <button class="btn-reinicia">Reiniciar</button>
                    </div>
                </div>
            </div>

            <br>
            <br>

            <a href="../index.html">Voltar</a>
        </div>

    </main>

    <script src="Ajax/batalha.js" defer></script>
</body>
</html>