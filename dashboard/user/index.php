<?php
include "../../includes/auth.php";
include "../../includes/config.php";


$livresDispo = $pdo->query("
    SELECT COUNT(*) FROM livre WHERE disponible = 1
")->fetchColumn();


$stmt = $pdo->prepare("
    SELECT livre.titre, emprunt.dateEmprunt
    FROM emprunt
    JOIN livre ON livre.id = emprunt.livre_id
    WHERE emprunt.user_id = ?
      AND emprunt.dateRetour IS NULL
");
$stmt->execute([$_SESSION["user_id"]]);
$emprunts = $stmt->fetchAll();
?>

<?php include "../../includes/head.php"; ?>
<?php include "../../includes/navbar.php"; ?>

<div class="container mt-5">

    
    <div class="card p-4 mb-4 fade-in">
        <h3>👋 Bienvenue <?= htmlspecialchars($_SESSION["prenom"]) ?></h3>
        <p class="text-muted">Voici votre espace personnel</p>

       
    </div>

    <div class="row g-4">

        
        <div class="col-md-4">
            <div class="card user-card text-center p-4">
                <h5>📚 Livres disponibles</h5>
                <h2 class="text-info"><?= $livresDispo ?></h2>
            </div>
        </div>

        
        <div class="col-md-8">
            <div class="card p-4 user-card">
                <h5 class="mb-3">📖 Mes emprunts en cours</h5>

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Livre</th>
                            <th>Date d'emprunt</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($emprunts): ?>
                            <?php foreach ($emprunts as $e): ?>
                                <tr>
                                    <td><?= htmlspecialchars($e["titre"]) ?></td>
                                    <td><?= date("d/m/Y", strtotime($e["dateEmprunt"])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="2" class="text-center text-muted">
                                    Aucun emprunt en cours 📭
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

            </div>
        </div>

    </div>

</div>

<?php include "../../includes/footer.php"; ?>
