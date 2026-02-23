<?php
include("../config.inc.php");
include("../session.php");
validaSessao();

$id = $_GET["id"] ?? null;

if (!$id) {
    header("Location: /sistema/admin/cat/index.php");
    exit;
}

$link = mysqli_connect("localhost", "root", "", "sistema");

$sql = "DELETE FROM category WHERE id = " . intval($id);

try {
    if (!mysqli_query($link, $sql)) {
        throw new Exception(mysqli_error($link));
    }

    header("Location: /sistema/admin/cat/index.php?msg=Categoria excluída com sucesso");
    exit;

} catch (Exception $e) {
    if (str_contains($e->getMessage(), 'a foreign key constraint fails')) {
        $mensagem = "❌ Não é possível excluir esta categoria, pois há produtos vinculados a ela.";
    } else {
        $mensagem = "⚠️ Erro ao excluir categoria: " . $e->getMessage();
    }

    header("Location: /sistema/admin/cat/index.php?error=" . urlencode($mensagem));
    exit;
}

mysqli_close($link);
?>
