<?php
include("../config.inc.php");
include("../session.php");
validaSessao();
include("../../header.php");
include("../menu.php");
?>

<h3>CATEGORIAS</h3>

<?php if (isset($_GET['error'])): ?>
    <p style="color:red; font-weight:bold;">
        ❌ <?= urldecode($_GET['error']) ?>
    </p>
<?php elseif (isset($_GET['msg'])): ?>
    <p style="color:green; font-weight:bold;">
        ✅ <?= urldecode($_GET['msg']) ?>
    </p>
<?php endif; ?>

<a href="/sistema/admin/cat/add.php" style="color: black;">ADICIONAR CATEGORIA</a><br><br>

<?php
$link = mysqli_connect("localhost", "root", "", "sistema");
$sql = "SELECT * FROM category ORDER BY name;";
$result = mysqli_query($link, $sql);

if (mysqli_num_rows($result) > 0) {
    ?>
    <table border="1">
        <tr>
            <th>Nome</th>
            <th>Ações</th>
        </tr>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <tr>
                <td><?= htmlspecialchars($row["name"]); ?></td>
                <td align="center">
                    <a href="/sistema/admin/cat/upd.php?id=<?= $row["id"]; ?>" style="color: black;">Editar</a> |
                    <a href="/sistema/admin/cat/del.php?id=<?= $row["id"]; ?>" style="color: black;">Excluir</a>
                </td>
            </tr>
            <?php
        }
        ?>
    </table>
    <?php
} else {
    echo "Sem categorias cadastradas.";
}
mysqli_close($link);
?>

<?php
include("../../footer.php");
?>
