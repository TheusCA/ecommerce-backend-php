<?php
include("../config.inc.php");
include("../session.php");
validaSessao();

$link = mysqli_connect("localhost", "root", "", "sistema");

$usuario_id = $_SESSION["usuario_id"] ?? $_SESSION["CONTA_ID"] ?? null;

if (!$usuario_id) {
    echo "<p style='color:red;'>Erro: sessão expirada ou usuário não identificado.</p>";
    exit;
}

$id = intval($_GET["id"]);

$check = mysqli_query($link, "SELECT owner_id FROM prod WHERE id = $id");
$p = mysqli_fetch_assoc($check);

if (!$p) {
    echo "<p style='color:red;'>❌ Produto não encontrado.</p>";
    echo "<a href='/sistema/admin/prod/index.php'>Voltar</a>";
    exit;
}

if ($p["owner_id"] != $usuario_id) {
    echo "<p style='color:red;'>❌ Você não pode excluir este produto (não é o dono).</p>";
    echo "<a href='/sistema/admin/prod/index.php'>Voltar</a>";
    exit;
}

$sql = "DELETE FROM prod WHERE id = $id AND owner_id = $usuario_id";
if (mysqli_query($link, $sql)) {
    header("Location: /sistema/admin/prod/index.php?msg=Produto excluído com sucesso");
    exit;
} else {
    echo "<p style='color:red;'>Erro ao excluir: " . mysqli_error($link) . "</p>";
}

mysqli_close($link);
?>
