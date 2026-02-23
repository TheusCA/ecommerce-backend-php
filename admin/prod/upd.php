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

$verifica = mysqli_query($link, "SELECT * FROM prod WHERE id = $id");
$prod = mysqli_fetch_assoc($verifica);

if (!$prod) {
    echo "<p style='color:red;'>Produto não encontrado.</p>";
    echo "<a href='/sistema/admin/prod/index.php'>Voltar</a>";
    exit;
}

if ($prod["owner_id"] != $usuario_id) {
    echo "<p style='color:red;'>Você não tem permissão para editar este produto.</p>";
    echo "<a href='/sistema/admin/prod/index.php'>Voltar</a>";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $preco = $_POST["preco"];
    $categoria_id = $_POST["categoria_id"];

    $sql = "UPDATE prod 
            SET nome = '" . mysqli_real_escape_string($link, $nome) . "',
                preco = '" . mysqli_real_escape_string($link, $preco) . "',
                category_id = " . intval($categoria_id) . "
            WHERE id = $id AND owner_id = $usuario_id";

    if (mysqli_query($link, $sql)) {
        header("Location: /sistema/admin/prod/index.php?msg=Produto atualizado com sucesso");
        exit;
    } else {
        $mensagem = "Erro ao atualizar produto: " . mysqli_error($link);
    }
}

include("../../header.php");
include("../menu.php");
?>

<h3>EDITAR PRODUTO</h3>

<form method="POST">
    <?php if (isset($mensagem)): ?>
        <p style="color:red;"><?= $mensagem ?></p>
    <?php endif; ?>

    Nome:<br>
    <input type="text" name="nome" value="<?= htmlspecialchars($prod['nome']) ?>" required><br><br>

    Preço:<br>
    <input type="number" step="0.01" name="preco" value="<?= $prod['preco'] ?>" required><br><br>

    Categoria:<br>
    <select name="categoria_id" required>
        <?php
        $cats = mysqli_query($link, "SELECT * FROM category ORDER BY name");
        while ($c = mysqli_fetch_assoc($cats)) {
            $sel = ($c["id"] == $prod["category_id"]) ? "selected" : "";
            echo "<option value='{$c['id']}' $sel>{$c['name']}</option>";
        }
        ?>
    </select>
    <br><br>

    <input type="submit" value="Salvar Alterações">
</form>

<br><a href="/sistema/admin/prod/index.php">Voltar</a>

<?php
include("../../footer.php");
?>
