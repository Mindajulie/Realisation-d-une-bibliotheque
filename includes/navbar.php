<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<nav class="navbar navbar-expand-lg navbar-dark navbar-futur fixed-top">
    <div class="container-fluid px-4">

        
        <a class="navbar-brand fw-bold text-info d-flex align-items-center gap-2" href="/biblio/index.php">
            <i class="fas fa-book-open"></i>
            <span>BIBLIO</span>
        </a>

        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        
        <div class="collapse navbar-collapse" id="menu">
            <ul class="navbar-nav ms-auto align-items-center gap-2">

                
                <?php if ($_SESSION["role"] === "admin"): ?>

                    <li class="nav-item">
                        <a class="nav-link nav-anim" href="/biblio/dashboard/admin/index.php">
                            <i class="fas fa-chart-line"></i> Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link nav-anim" href="/biblio/user/index.php">
                            <i class="fas fa-users"></i> Utilisateurs
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link nav-anim" href="/biblio/livre/index.php">
                            <i class="fas fa-book"></i> Livres
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link nav-anim" href="/biblio/etudiant/index.php">
                            <i class="fas fa-user-graduate"></i> Étudiants
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link nav-anim" href="/biblio/emprunt/index.php">
                            <i class="fas fa-clock"></i> Emprunts
                        </a>
                    </li>

                
                <?php else: ?>

                    <li class="nav-item">
                        <a class="nav-link nav-anim" href="/biblio/dashboard/user/index.php">
                            <i class="fas fa-user"></i> Mon dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link nav-anim" href="/biblio/livre/index.php">
                            <i class="fas fa-book"></i> Catalogue
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link nav-anim" href="/biblio/emprunt/index.php">
                            <i class="fas fa-clock"></i> Mes emprunts
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link nav-anim" href="/biblio/profile/index.php">
                            <i class="fas fa-id-card"></i> Profil
                        </a>
                    </li>

                <?php endif; ?>

                
                <li class="nav-item ms-lg-3">
                    <span class="badge badge-role px-3 py-2">
                        <?= strtoupper(htmlspecialchars($_SESSION["role"])) ?>
                    </span>
                </li>

                
                <li class="nav-item ms-lg-2">
                    <a class="btn btn-outline-danger btn-sm px-3" href="/biblio/auth/logout.php">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
                </li>

            </ul>
        </div>
    </div>
</nav>

<!-- ESPACE POUR NAVBAR FIXED -->
<div class="navbar-spacer"></div>
