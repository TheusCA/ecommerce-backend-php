<?php
include("../config.inc.php");
include("../session.php");
validaSessao();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];

    $link = mysqli_connect("localhost", "root", "", "sistema");

    $sql = "INSERT INTO category (name) VALUES ('" . mysqli_real_escape_string($link, $name) . "')";

    if (mysqli_query($link, $sql)) {
        header("Location: /sistema/admin/cat/index.php");
        exit;
    } else {
        $mensagem = "Erro ao adicionar categoria: " . mysqli_error($link);
    }
    mysqli_close($link);
}

include("../../header.php");
include("../menu.php");
?>

<h3>ADICIONAR CATEGORIA</h3>

<form method="POST">
    <?php if (isset($mensagem)): ?>
        <p style="color: red;"><?= $mensagem ?></p>
    <?php endif; ?>
    Nome da Categoria:
    <br>
    <input type="text" name="name" value="<?=isset($name)?htmlspecialchars($name):"";?>" required>
    <br><br>
    <input type="submit" value="Adicionar">
</form>

<br><a href="/sistema/admin/cat/index.php" style="color: black;">Voltar para Categorias</a>

<?php
include("../../footer.php");
?>
