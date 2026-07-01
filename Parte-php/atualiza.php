<?php
$nome = $_POST['nome'];
$classe = $_POST['classe'];
$vida = $_POST['vida'];
$ataque = $_POST['ataque'];
$defesa = $_POST['defesa'];

$sql = "UPDATE guerreiros SET 
    nome = '$nome', 
    classe = '$classe', 
    vida = '$vida', 
    ataque = '$ataque', 
    defesa = '$defesa' 
    WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "<h3 class='suc'>Personagem alterado com sucesso!</h3>";

        echo "<script>
            setTimeout(function() {
                window.location.href = 'lista.php';
            }, 2000);
        </script>";
    } else {
        echo "<h3 class='err'>Erro: " . $conn->error . "</h3>";
    }
?>