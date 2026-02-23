<?php
include("./config.inc.php");
include("../header.php");

$link = mysqli_connect("localhost", "root", "", "sistema");

$categories = [];
$sql_cat = "SELECT id, name FROM category ORDER BY name;";
$result_cat = mysqli_query($link, $sql_cat);
if ($result_cat) {
    while ($row_cat = mysqli_fetch_assoc($result_cat)) {
        $categories[] = $row_cat;
    }
}

$kw = $_GET["kw"] ?? "";
$selected_category_id = $_GET["category_id"] ?? "";

$sql = "SELECT p.id, p.nome, p.preco, c.name as category_name FROM prod p LEFT JOIN category c ON p.category_id = c.id ";
$where_clauses = [];

if (!empty($kw)) {
    $where_clauses[] = "p.nome LIKE "."'%".$kw."%'";
}

if (!empty($selected_category_id)) {
    $where_clauses[] = "p.category_id = ".$selected_category_id."";
}

if (!empty($where_clauses)) {
    $sql .= " WHERE " . implode(" AND ", $where_clauses);
}

$sql .= " ORDER BY p.nome;";

$result = mysqli_query($link, $sql);
mysqli_close($link);

?>

<h3>USER</h3>

<form method="GET">
    Palavra-Chave:
    <br>
    <input type="text" name="kw" value="<?= htmlspecialchars($kw); ?>">
    <br><br>
    Categoria:
    <br>
    <select name="category_id">
        <option value="">-- Todas as Categorias --</option>
        <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat["id"] ?>" <?= ($selected_category_id == $cat["id"]) ? 'selected' : '' ?>>
                <?= htmlspecialchars($cat["name"]) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <br><br>
    <input type="submit" value="Buscar">
</form>

<a href="/sistema/user/carrinho.php" style="color: black;">CARRINHO</a><br><br>

<?php
if (mysqli_num_rows($result) > 0) {
    ?>
    <table border="1">
        <tr>
            <th>Nome</th>
            <th>Preço</th>
            <th>Categoria</th>
            <th>COMPRAR</th>
        </tr>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <tr>
                <td><?= htmlspecialchars($row["nome"]); ?></td>
                <td><?= htmlspecialchars($row["preco"]); ?></td>
                <td><?= htmlspecialchars($row["category_name"] ?? "N/A"); ?></td>
                <td align="center"><a href="/sistema/user/carrinho.php?a=<?= htmlspecialchars($row["id"]); ?>" style="color: black;">(+)</a></td>
            </tr>
            <?php
        }
        ?>
    </table>
    <?php
} else {
    echo "Sem produtos.";
}
?>

<br><a href="/sistema/user/carrinho.php" style="color: black;">Index</a>

<?php
include("../footer.php");
?>
