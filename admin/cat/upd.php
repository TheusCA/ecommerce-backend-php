<?php
include("../config.inc.php");
include("../session.php");
validaSessao();

$name = '';
$mensagem = '';
$id = $_GET["id"] ?? null;

if (!$id) {
    header("Location: /sistema/admin/cat/index.php");
    exit;
}

$link = mysqli_connect("localhost", "root", "", "sistema");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"] ?? '';

    $sql = "UPDATE category SET name = ? WHERE id = ?";

    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "si", $name, $id);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: /sistema/admin/cat/index.php");
            exit;
        } else {
            $mensagem = "Erro ao atualizar categoria: " . mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    } else {
        $mensagem = "Erro na preparação da query: " . mysqli_error($link);
    }
} else {
    $sql = "SELECT name FROM category WHERE id = ?";
    
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) == 1) {
            $category = mysqli_fetch_assoc($result);
            $name = $category["name"];
        } else {
            header("Location: /sistema/admin/cat/index.php");
            exit;
        }
        mysqli_stmt_close($stmt);
    }
}
mysqli_close($link);

include("../../header.php");
include("../menu.php");
?>

<h3>EDITAR CATEGORIA</h3>

<form method="POST">
    <?php if (!empty($mensagem)): ?>
        <p style="color: red;"><?= htmlspecialchars($mensagem) ?></p>
    <?php endif; ?>
    
    Nome da Categoria:
    <br>
    <input type="text" name="name" value="<?= htmlspecialchars($name); ?>" required>
    <br><br>
    <input type="submit" value="Atualizar">
</form>

<br>
<a href="/sistema/admin/cat/index.php" style="color: black;">Voltar para Categorias</a>

<?php
include("../../footer.php");
?>