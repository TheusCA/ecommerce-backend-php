<?php
include("../config.inc.php");
include("../session.php");
validaSessao();

$link = mysqli_connect("localhost", "root", "", "sistema");

$owner_id = $_SESSION["usuario_id"] ?? $_SESSION["CONTA_ID"] ?? null;

if (!$owner_id) {
    echo "<p style='color:red;'>Erro: sessão expirada ou usuário não identificado.</p>";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $preco = $_POST["preco"];
    $categoria_id = $_POST["categoria_id"];

    $sql = "INSERT INTO prod (nome, preco, category_id, owner_id)
            VALUES ('" . mysqli_real_escape_string($link, $nome) . "', 
                    '" . mysqli_real_escape_string($link, $preco) . "', 
                    " . intval($categoria_id) . ", 
                    " . intval($owner_id) . ")";

    if (mysqli_query($link, $sql)) {
        header("Location: /sistema/admin/prod/index.php?msg=Produto adicionado com sucesso");
        exit;
    } else {
        $mensagem = "Erro ao adicionar produto: " . mysqli_error($link);
    }
}

include("../../header.php");
include("../menu.php");
?>

<h3>ADICIONAR PRODUTO</h3>

<form method="POST">
    <?php if (isset($mensagem)): ?>
        <p style="color:red;"><?= $mensagem ?></p>
    <?php endif; ?>

    Nome:<br>
    <input type="text" name="nome" required><br><br>

    Preço:<br>
    <input type="number" step="0.01" name="preco" required><br><br>

    Categoria:<br>
    <select name="categoria_id" required>
        <option value="">Selecione...</option>
        <?php
        $cats = mysqli_query($link, "SELECT * FROM category ORDER BY name");
        while ($c = mysqli_fetch_assoc($cats)) {
            echo "<option value='{$c['id']}'>{$c['name']}</option>";
        }
        ?>
    </select>
    <br><br>

    <input type="submit" value="Adicionar">
</form>

<br><a href="/sistema/admin/prod/index.php">Voltar</a>

<?php
include("../../footer.php");
?>
