<?php
session_start();
include("db.php");

$idBook = $_GET['id'];
$date = date("Y-m-d");

$conn->prepare("UPDATE borrows SET return_date=? WHERE book_id=? AND student_id=?")
     ->execute([$date, $idBook, $_SESSION['student']]);

$conn->prepare("UPDATE books SET available=1 WHERE id=?")->execute([$idBook]);

header("Location: livres.php");
?>
