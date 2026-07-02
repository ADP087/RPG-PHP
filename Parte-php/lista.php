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
    <link rel="stylesheet" href="../src/style.css">
    <title>Lista dos Guerreiros</title>
</head>
<body>
    <div class="container-tabela">
        <h1>Guerreiros cadastrado:</h1>

        <div class="table-scroll">
            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Classe</th>
                        <th>Vida</th>
                        <th>Ataque</th>
                        <th>Defesa</th>
                        <th>Botões</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach($resultados as $usuario) {
                        echo "<tr>";
                            echo "<td>{$usuario['nome']}</td>";
                            echo "<td>{$usuario['classe']}</td>";
                            echo "<td>{$usuario['vida']}</td>";
                            echo "<td>{$usuario['ataque']}</td>";
                            echo "<td>{$usuario['defesa']}</td>";
                            echo "<td><button data-id='{$usuario['id']}' class='edit' title='Editar'><img src='../src/imgs/lapis.png' alt='Editar'></button> 
                            <button data-id='{$usuario['id']}' class='apaga' title='Excluir'><img src='../src/imgs/lixeira.png' alt='Excluir'></button>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="links">
            <a href="../index.html" class="btn-vol">Voltar</a>
            <a href="cadastro.php" class="btn-cads">Cadastrar novo Guerreiro</a>
        </div>
    </div>

    <script>
        const btnEditar = document.querySelectorAll('.edit');
        const btnExcluir = document.querySelectorAll('.apaga');

        btnEditar.forEach(botao => {
            botao.addEventListener('click', () => {
                const id = botao.dataset.id;

                window.location.href = "editar.php?id=" + id;
            });
        });

        btnExcluir.forEach(botao => {
            botao.addEventListener('click', () => {
                const id = botao.dataset.id;

                if(confirm("Deseja realmente excluir esse guerreiro")) {
                    window.location.href = "excluir.php?id=" + id;
                }
            });
        });
    </script>
</body>
</html>