<?php
session_start();
include("db.php");

$idBook = $_GET['id'];
$student = $_SESSION['student'];
$date = date("Y-m-d");

$stmt = $conn->prepare("INSERT INTO borrows(student_id, book_id, borrow_date) VALUES(?,?,?)");
$stmt->execute([$student, $idBook, $date]);

$conn->prepare("UPDATE books SET available=0 WHERE id=?")->execute([$idBook]);

header("Location: books.php");
?>
