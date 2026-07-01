<?php 
include("Conexao.php");

$sql = "SELECT * FROM guerreiros";
$resultados = $conn->query($sql);

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
        <form method="post" class="form-esolha">
            <label>
                <p>Escolha o guerreiro que deseja ser: </p>
                <select name="escolha" id="escolha">
                    <?php
                    foreach($resultados as $usuario) {
                        echo "<option value=". $usuario['id'] .">". $usuario['nome'] . "</option>";
                    }
                    ?>
                </select>
            </label>

            <input type="submit" name="enviar" value="Batalhar">
        </form>
    </header>

    <main>
        <?php
        if(isset($_POST['enviar'])) {
            // Selecionando o player
            $playerID = $_POST['escolha'];
            $sqlPlayer = "SELECT * FROM guerreiros WHERE id = $playerID";
            $resPlayer = $conn->query($sqlPlayer);
            $player = $resPlayer->fetch_assoc();

            // Selecionando computador
            $sqlComp = "SELECT * FROM guerreiros WHERE id != $playerID ORDER BY RAND() LIMIT 1";
            $resComp = $conn->query($sqlComp);
            $computador = $resComp->fetch_assoc();

            // VIDA
            $vida_player = $player["vida"];
            $vida_computador = $computador["vida"];
        }
        ?>
        
        <div class="container">
            <div class="personagens">
                <div class="div-personagem">
                    <?php
                    if(isset($_POST['enviar'])) {
                        echo "<h2>Player: {$player['nome']} (HP: $vida_player)</h2>";
                    } else {
                    echo "<h2>Player</h2>";
                    }
                    ?>

                    <div class="quadro-img">
                        <?php
                        if(isset($_POST['enviar'])) {
                            echo "<img src='../src/imgs/{$player['classe']}.png' alt='Personagem do player'>";
                        }
                        ?>
                    </div>

                    <div class="vida"></div>
                </div>

                <h3>VS</h3>

                <div class="div-personagem">
                    <?php
                    if(isset($_POST['enviar'])) {
                        echo "<h2>Computador: {$computador['nome']} (HP: $vida_computador)</h2>";
                    } else {
                        echo "<h2>Computador</h2>";
                    }
                    ?>

                    <div class="quadro-img">
                        <?php
                        if(isset($_POST['enviar'])) {
                            echo "<img src='../src/imgs/{$computador['classe']}.png' alt='Personagem do computador'>";
                        }
                        ?>
                    </div>

                    <div class="vida"></div>
                </div>
            </div>

            <br>
            <br>

            <div class="campo-batalha">
                <div class="chat-dano">
                <?php
                if(isset($_POST['enviar'])) {
                    // Começando jogo
                    $inicio = rand(1, 2);

                    if($inicio === 1) {
                        $turno = "player";
                        echo "<h3>O PLAYER começa!</h3>";
                    } else {
                        $turno = "computador";
                        echo "<h3>O COMPUTADOR começa!</h3>";
                    }

                    while($vida_player > 0 && $vida_computador > 0) {
                        if($turno === "player") {
                            $ataque = rand(0, $player["ataque"]);
                            $vida_computador -= $ataque;

                            if($vida_computador < 0) $vida_computador = 0;

                            echo "<p><b>{$player['nome']}</b> atacou causando $ataque de dano.</p>";
                            echo "<p>HP do computador: $vida_computador</p>";

                            if($vida_computador === 0) {
                                echo "<h2>Computador morreu! PLAYER venceu!</h2>";
                                break;
                            }

                            $turno = "computador";

                        } else {

                            $ataque = rand(0, $computador["ataque"]);

                            $vida_player -= $ataque;

                            if($vida_player < 0) $vida_player = 0;

                            echo "<p><b>{$computador['nome']}</b> atacou causando $ataque de dano.</p>";
                            echo "<p>HP do player: $vida_player</p>";

                            if($vida_player === 0) {
                                echo "<h2>Player morreu! COMPUTADOR venceu!</h2>";
                                break;
                            }

                            $turno = "player";
                        }

                        echo "<hr>";
                    }
                }
                ?>
                </div>

                <div class="acoes">
                    <button class="btn-cura">Curar</button>
                    <button class="btn-bater">Bater</button>
                    <button class="btn-defender">Defender</button>
                </div>
            </div>

            <br>
            <br>

            <a href="../index.html">Voltar</a>
        </div>

    </main>
</body>
</html>