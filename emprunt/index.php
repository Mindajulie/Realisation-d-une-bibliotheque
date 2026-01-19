<?php
include "../includes/auth.php";
include "../includes/config.php";

$isAdmin = $_SESSION["role"] === "admin";

if ($isAdmin) {
    
    $stmt = $pdo->query("
        SELECT 
            e.id,
            e.emprunteur_type,
            e.dateEmprunt,
            e.dateRetour,

            l.titre,

            u.prenom AS user_prenom,
            u.nom AS user_nom,

            et.prenom AS etu_prenom,
            et.nom AS etu_nom,
            et.classe,

            a.prenom AS admin_prenom,
            a.nom AS admin_nom

        FROM emprunt e
        JOIN livre l ON l.id = e.livre_id
        LEFT JOIN users u ON u.id = e.user_id
        LEFT JOIN etudiant et ON et.id = e.etudiant_id
        LEFT JOIN users a ON a.id = e.admin_id

        ORDER BY e.dateEmprunt DESC
    ");
    $emprunts = $stmt->fetchAll();

} else {
    
    $stmt = $pdo->prepare("
        SELECT 
            e.id,
            e.dateEmprunt,
            e.dateRetour,
            l.titre
        FROM emprunt e
        JOIN livre l ON l.id = e.livre_id
        WHERE e.user_id = ?
        ORDER BY e.dateEmprunt DESC
    ");
    $stmt->execute([$_SESSION["user_id"]]);
    $emprunts = $stmt->fetchAll();
}
?>

<?php include "../includes/head.php"; ?>
<?php include "../includes/navbar.php"; ?>

<div class="container mt-5">

    <h3 class="mb-4">📦 Gestion des emprunts</h3>

    <div class="card p-4">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <?php if ($isAdmin): ?>
                        <th>Emprunteur</th>
                        <th>Type</th>
                    <?php endif; ?>

                    <th>Livre</th>
                    <th>Date emprunt</th>
                    <th>Date retour</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>

            <?php foreach ($emprunts as $e): ?>
                <tr>

                <?php if ($isAdmin): ?>
                    <td>
                        <?php if ($e["emprunteur_type"] === "user"): ?>
                            👤 <?= htmlspecialchars($e["user_prenom"] . " " . $e["user_nom"]) ?>
                        <?php else: ?>
                            🎓 <?= htmlspecialchars($e["etu_prenom"] . " " . $e["etu_nom"]) ?>
                            <small class="text-muted">(<?= $e["classe"] ?>)</small>
                        <?php endif; ?>
                    </td>

                    <td>
                        <span class="badge 
                            <?= $e["emprunteur_type"] === "user" ? "bg-info" : "bg-warning" ?>">
                            <?= strtoupper($e["emprunteur_type"]) ?>
                        </span>
                    </td>
                <?php endif; ?>

                    <td><?= htmlspecialchars($e["titre"]) ?></td>

                    <td><?= $e["dateEmprunt"] ?></td>

                    <td>
                        <?= $e["dateRetour"] 
                            ? $e["dateRetour"] 
                            : "<span class='text-warning'>En cours</span>" ?>
                    </td>

                    <td class="text-end">

<?php if (!$e["dateRetour"]): ?>

    <?php if ($isAdmin): ?>
        <a href="retourner.php?id=<?= $e["id"] ?>"
         class="btn btn-sm btn-success">
            🔄 Retourner
        </a>

    <?php else: ?>
        <a href="retourner.php?id=<?= $e["id"] ?>"
           class="btn btn-sm btn-success">
            🔁 Retourner
        </a>
    <?php endif; ?>

<?php else: ?>
    —
<?php endif; ?>

</td>


                </tr>
            <?php endforeach; ?>

            <?php if (count($emprunts) === 0): ?>
                <tr>
                    <td colspan="<?= $isAdmin ? 6 : 4 ?>">
                        Aucun emprunt enregistré
                    </td>
                </tr>
            <?php endif; ?>

            </tbody>
        </table>
    </div>
</div>

<?php include "../includes/footer.php"; ?>
