<?php
include "../includes/auth.php";
include "../includes/admin.php"; 
include "../includes/config.php";

$livre_id = $_GET["livre_id"] ?? null;

if (!$livre_id) {
    header("Location: index.php");
    exit;
}


$stmt = $pdo->prepare("SELECT titre, disponible FROM livre WHERE id = ?");
$stmt->execute([$livre_id]);
$livre = $stmt->fetch();

if (!$livre || !$livre["disponible"]) {
    header("Location: index.php");
    exit;
}


$etudiants = $pdo->query("
    SELECT id, nom, prenom, classe
    FROM etudiant
    ORDER BY nom
")->fetchAll();
?>

<?php include "../includes/head.php"; ?>
<?php include "../includes/navbar.php"; ?>

<div class="container mt-5">
    <div class="card p-4">

        <h4 class="mb-3">
            📘 Emprunter le livre :
            <span class="text-info"><?= htmlspecialchars($livre["titre"]) ?></span>
        </h4>

        <form method="POST" action="emprtEtudiant.php">

            <input type="hidden" name="livre_id" value="<?= $livre_id ?>">

            <div class="mb-3">
                <label class="form-label">Étudiant</label>
                <select name="etudiant_id" class="form-select" required>
                    <option value="">-- Choisir un étudiant --</option>
                    <?php foreach ($etudiants as $e): ?>
                        <option value="<?= $e["id"] ?>">
                            <?= htmlspecialchars($e["prenom"] . " " . $e["nom"]) ?>
                            (<?= $e["classe"] ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="index.php" class="btn btn-secondary">Annuler</a>
                <button class="btn btn-info">
                    📚 Emprunter
                </button>
            </div>

        </form>
    </div>
</div>

<?php include "../includes/footer.php"; ?>
