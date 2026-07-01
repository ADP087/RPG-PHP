<?php include("Conexao.php") ?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../src/style.css">
    <title>Cadastro Guerreiro</title>
</head>
<body>
    <div class="container">
        <h1>Cadastro</h1>

        <form method="post" class="form-cads">
            <label>
                <p>Nome:</p>
                <input type="text" name="nome" id="nome" placeholder="Nome do guerreiro">
            </label>

            <br>

            <label>
                <p>Classe:</p>
                <select name="classe" id="classe">
                    <option value="barbaro">Bárbaro</option>
                    <option value="arqueiro">Arqueiro</option>
                    <option value="mago">Mago</option>
                </select>
            </label>

            <br>

            <label>
                <p>Vida:</p>
                <input type="text" name="vida" id="vida" placeholder="Vida do guerreiro">
            </label>

            <br>

            <label>
                <p>Ataque  :</p>
                <input type="text" name="ataque" id="ataque" placeholder="Ataque do guerreiro">
            </label>

            <br>

            <label>
                <p>Defesa:</p>
                <input type="text" name="defesa" id="defesa" placeholder="Defesa do guerreiro">
            </label>

            <br>
            <br>

            <div class="links">
                <a href="../index.html">Voltar</a>
                <input type="submit" name="enviar" value="Cadastrar">
            </div>
        </form>

        <?php
            if(isset($_POST['enviar'])) {
                $nome = $_POST['nome'];
                $classe = $_POST['classe'];
                $vida = $_POST['vida'];
                $ataque = $_POST['ataque'];
                $defesa = $_POST['defesa'];

                $sql = "INSERT INTO guerreiros (nome, classe, vida, ataque, defesa) VALUES ('$nome', '$classe', '$vida', '$ataque', '$defesa')";

                if ($conn->query($sql) === TRUE) {
                    echo "<h3 class='suc'>Personagem cadastrado com sucesso!</h3>";

                    echo "<script>
                        setTimeout(function() {
                            window.location.href = '../index.html';
                        }, 2000);
                    </script>";
                } else {
                    echo "<h3 class='err'>Erro: " . $conn->error . "</h3>";
                }
            }
        ?>
    </div>
</body>
</html>

