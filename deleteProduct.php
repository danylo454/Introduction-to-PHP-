<?php
include_once "connection_database.php";
$id=$_POST['id'];
//видаляємо фотки
$sql = 'DELETE FROM tbl_product_images WHERE product_id= :id;';
$stmt = $dbh->prepare($sql);
$stmt->execute([':id'=>$id]);
//видаляємо продукт
$sql = 'DELETE FROM tbl_products WHERE id = :id;';
$stmt = $dbh->prepare($sql);
$stmt->execute([':id'=>$id]);
echo "Успішне видалення";

?>