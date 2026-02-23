<?php
include("../config.inc.php");
include("../session.php");
validaSessao();

$link = mysqli_connect("localhost", "root", "", "sistema");

$usuario_id = $_SESSION["usuario_id"] ?? $_SESSION["CONTA_ID"] ?? null;

$result = mysqli_query($link, "
    SELECT p.*, c.name AS categoria, a.username AS dono
    FROM prod p
    LEFT JOIN category c ON p.category_id = c.id
    LEFT JOIN account a ON p.owner_id = a.id
    ORDER BY p.id DESC
");

include("../../header.php");
include("../menu.php");
?>

<h3>LISTA DE PRODUTOS</h3>

<table border="1" cellpadding="6" cellspacing="0">
<tr>
    <th>ID</th>
    <th>Nome</th>
    <th>Preço</th>
    <th>Categoria</th>
    <th>Dono</th>
    <th>Ações</th>
</tr>

<?php
while ($r = mysqli_fetch_assoc($result)):
?>
<tr>
    <td><?= $r["id"] ?></td>
    <td><?= htmlspecialchars($r["nome"]) ?></td>
    <td>R$ <?= number_format($r["preco"], 2, ',', '.') ?></td>
    <td><?= $r["categoria"] ?></td>
    <td><?= $r["dono"] ?></td>
    <td>
        <?php if ($r["owner_id"] == $usuario_id): ?>
            <a href="upd.php?id=<?= $r['id'] ?>">Editar</a> |
            <a href="del.php?id=<?= $r['id'] ?>" onclick="return confirm('Excluir produto?')">Excluir</a>
        <?php else: ?>
            <span style="color:#ff3333; font-weight:bold;">⛔ Sem permissão</span>
        <?php endif; ?>
    </td>
</tr>
<?php endwhile; ?>
</table>

<br><a href="add.php">Novo Produto</a>

<?php
include("../../footer.php");
?>
