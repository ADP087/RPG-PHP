<?php
include("Conexao.php");

$id = (int) $_GET['id'];

$sql = "DELETE FROM guerreiros WHERE id = $id";
$resultado = $conn->query($sql); 

if ($conn->query($sql) === TRUE) {
    header("Location: lista.php");
    exit;
} else {
    echo "<h3 class='err'>Erro: " . $conn->error . "</h3>";
}
?>