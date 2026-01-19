<?php
require "../includes/auth.php";
require "../includes/config.php";

$isAdmin = $_SESSION["role"] === "admin";


$livres = $pdo->query("
    SELECT 
        l.*,
        (
            SELECT COUNT(*) 
            FROM emprunt e 
            WHERE e.livre_id = l.id 
              AND e.dateRetour IS NULL
        ) AS enCours
    FROM livre l
    ORDER BY l.titre
")->fetchAll();
?>

<?php include "../includes/head.php"; ?>
<?php include "../includes/navbar.php"; ?>

<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>📚 Catalogue des livres</h3>

        <?php if ($isAdmin): ?>
            <a href="add.php" class="btn btn-success">
                <i class="fas fa-plus"></i> Ajouter un livre
            </a>
        <?php endif; ?>
    </div>

    <div class="card p-4">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Auteur</th>
                    <th>Date d'édition</th>
                    <th>Statut</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>

            <?php foreach ($livres as $l): ?>
                <tr>
                    <td><?= htmlspecialchars($l["titre"]) ?></td>
                    <td><?= htmlspecialchars($l["auteur"]) ?></td>
                    <td><?= $l["dateEdition"] ?: "—" ?></td>

                    <td>
                        <?php if ($l["enCours"]): ?>
                            <span class="badge bg-danger">Emprunté</span>
                        <?php else: ?>
                            <span class="badge bg-success">Disponible</span>
                        <?php endif; ?>
                    </td>

                    <td class="text-end">

                        
                        <?php if ($isAdmin): ?>

                            <a href="edit.php?id=<?= $l["id"] ?>"
                               class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>

                            <a href="delete.php?id=<?= $l["id"] ?>"
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('Supprimer ce livre ?')">
                                <i class="fas fa-trash"></i>
                            </a>

                            <?php if (!$l["enCours"]): ?>
                                <a href="emprunter_etudiant.php?livre_id=<?= $l["id"] ?>"
                                   class="btn btn-sm btn-info">
                                    <i class="fas fa-user-graduate"></i>
                                Emprunter
                                </a>
                            <?php else: ?>
                                <span class="text-muted ms-2">—</span>
                            <?php endif; ?>

                
                        <?php else: ?>

                            <?php if (!$l["enCours"]): ?>
                                <a href="emprunter.php?id=<?= $l["id"] ?>"
                                   class="btn btn-sm btn-primary">
                                    <i class="fas fa-book-reader"></i>
                                    Emprunter
                                </a>
                            <?php else: ?>
                                <span class="text-muted">Indisponible</span>
                            <?php endif; ?>

                        <?php endif; ?>

                    </td>
                </tr>
            <?php endforeach; ?>

            <?php if (count($livres) === 0): ?>
                <tr>
                    <td colspan="5" class="text-center">
                        Aucun livre enregistré
                    </td>
                </tr>
            <?php endif; ?>

            </tbody>
        </table>
    </div>
</div>

<?php include "../includes/footer.php"; ?>
