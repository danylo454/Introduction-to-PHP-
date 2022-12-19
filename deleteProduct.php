<?php
include_once "connection_database.php";
$id = $_POST['id'];

//Видаляэмо фото з проекту
$sql = "SELECT pi.name 
        from tbl_product_images pi 
        where pi.product_id = :id";
$sth = $dbh->prepare($sql);
$sth->execute(['id' => $id]);
$images = $sth->fetchAll();
foreach ($images as $row) {
    $pathImagesdirec = "images/";
    $nameimages = $row["name"];
    $fullPath = $pathImagesdirec.$nameimages;
    unlink($fullPath);
}
unlink($row["name"]);

//видаляємо фотки
$sql = 'DELETE FROM tbl_product_images WHERE product_id= :id;';
$stmt = $dbh->prepare($sql);
$stmt->execute([':id' => $id]);
//видаляємо продукт
$sql = 'DELETE FROM tbl_products WHERE id = :id;';
$stmt = $dbh->prepare($sql);
$stmt->execute([':id' => $id]);
echo "Успішне видалення";

?>