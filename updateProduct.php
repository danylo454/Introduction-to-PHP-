<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/lib/guidv4.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/connection_database.php');
$idProduct = $_POST['idProduct'];
$nameProduct = $_POST['nameProduct'];
$priceProduct = $_POST['priceProduct'];
$descriptionProduct = $_POST['descriptionProducts'];
$imagesProduct = $_POST['images'];
$sql = "UPDATE tbl_products SET name='$nameProduct',price='$priceProduct',description='$descriptionProduct' WHERE id='$idProduct'";
$sth = $dbh->prepare($sql);
$sth->execute();
header("Location: /");
exit();
?>
