<?php
session_start();
include("db.php");

$stmt = $conn->query("SELECT * FROM books");
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head><title>Livres</title></head>
<body>
<h2>Liste des livres</h2>
<table border="1">
<tr><th>Titre</th><th>Auteur</th><th>Disponibilité</th><th>Action</th></tr>
<?php foreach($books as $b) { ?>
<tr>
  <td><?= $b['title'] ?></td>
  <td><?= $b['author'] ?></td>
  <td><?= $b['available'] ? "Disponible" : "Emprunté" ?></td>
  <td>
    <?php if($b['available']) { ?>
      <a href="borrow.php?id=<?= $b['id'] ?>">Emprunter</a>
    <?php } else { ?>
      <a href="return.php?id=<?= $b['id'] ?>">Retourner</a>
    <?php } ?>
  </td>
</tr>
<?php } ?>
</table>
</body>
</html>
