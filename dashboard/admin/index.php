<?php
include "../../includes/auth.php";
include "../../includes/admin.php";
include "../../includes/config.php";


$totalEtudiant = $pdo->query("SELECT COUNT(*) FROM etudiant")->fetchColumn();
$totalLivres = $pdo->query("SELECT COUNT(*) FROM livre")->fetchColumn();
$livresEmpruntes = $pdo->query("SELECT COUNT(*) FROM livre WHERE disponible = 0")->fetchColumn();
$empruntsEnCours = $pdo->query("SELECT COUNT(*) FROM emprunt WHERE dateRetour IS NULL")->fetchColumn();


$lastEmprunts = $pdo->query("
    SELECT 
        users.nom, users.prenom,
        livre.titre,
        emprunt.dateEmprunt
    FROM emprunt
    JOIN users ON users.id = emprunt.user_id
    JOIN livre ON livre.id = emprunt.livre_id
    ORDER BY emprunt.dateEmprunt DESC
    LIMIT 5
")->fetchAll();
?>

<?php include "../../includes/head.php"; ?>
<?php include "../../includes/navbar.php"; ?>

<div class="container mt-5">

    
    <div class="mb-4 fade-in">
        <h2>👑 Dashboard Administrateur</h2>
        <p class="text-muted">Vue globale et contrôle du système</p>
    </div>

    
    <div class="row g-4 mb-4">

        <div class="col-md-3">
            <div class="card stat-card text-center p-4">
                <h6>🎓 Etudiants</h6>
                <h2 class="text-info"><?= $totalEtudiant ?></h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card text-center p-4">
                <h6>📚 Livres</h6>
                <h2 class="text-success"><?= $totalLivres ?></h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card text-center p-4">
                <h6>📖 Empruntés</h6>
                <h2 class="text-warning"><?= $livresEmpruntes ?></h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card text-center p-4">
                <h6>⏳ En cours</h6>
                <h2 class="text-danger"><?= $empruntsEnCours ?></h2>
            </div>
        </div>

    </div>

    
    <div class="card p-4 fade-in">
        <h5 class="mb-3">📌 Derniers emprunts</h5>

        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Utilisateur</th>
                    <th>Livre</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($lastEmprunts): ?>
                    <?php foreach ($lastEmprunts as $e): ?>
                        <tr>
                            <td><?= htmlspecialchars($e["prenom"]." ".$e["nom"]) ?></td>
                            <td><?= htmlspecialchars($e["titre"]) ?></td>
                            <td><?= date("d/m/Y", strtotime($e["dateEmprunt"])) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" class="text-center text-muted">
                            Aucun emprunt enregistré 📭
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

<?php include "../../includes/footer.php"; ?>
