<?php 
    include("Conexao.php");
    
    $id = (int) $_GET['id'];

    $sql = "SELECT * FROM guerreiros WHERE id = $id";
    $resultado = $conn->query($sql);
    $guerreiro = $resultado->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../src/style.css">
    <title>Alterar Guerreiro</title>
</head>
<body>
    <div class="container">
        <h1>Cadastro</h1>

        <form method="post" class="form-cads">
            <label>
                <p>Nome:</p>
                <input type="text" name="nome" id="nome" placeholder="Nome do guerreiro" value="<?= $guerreiro['nome']; ?>">
            </label>

            <br>

            <label>
                <p>Classe:</p>
                <select name="classe" id="classe">
                    <option value="barbaro" <?= $guerreiro['classe'] == 'barbaro' ? 'selected' : '' ?> >Bárbaro</option>
                    <option value="arqueiro" <?= $guerreiro['classe'] == 'arqueiro' ? 'selected' : '' ?> >Arqueiro</option>
                    <option value="mago" <?= $guerreiro['classe'] == 'mago' ? 'selected' : '' ?> >Mago</option>
                </select>
            </label>

            <br>

            <label>
                <p>Vida:</p>
                <input type="text" name="vida" id="vida" placeholder="Vida do guerreiro" value="<?= $guerreiro['vida'] ?>">
            </label>

            <br>

            <label>
                <p>Ataque  :</p>
                <input type="text" name="ataque" id="ataque" placeholder="Ataque do guerreiro" value="<?= $guerreiro['ataque'] ?>">
            </label>

            <br>

            <label>
                <p>Defesa:</p>
                <input type="text" name="defesa" id="defesa" placeholder="Defesa do guerreiro" value="<?= $guerreiro['defesa'] ?>">
            </label>

            <br>
            <br>

            <div class="links">
                <a href="lista.php">Voltar</a>
                <input type="submit" name="enviar" value="Salvar">
            </div>
        </form>

        <?php
            if(isset($_POST['enviar'])) {
                include("atualiza.php");
            }
        ?>
    </div>
</body>
</html>

