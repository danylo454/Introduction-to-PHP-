<?php
include_once "connection_database.php";
$id=$_GET['id'];
$name='';
$price='';
$description='';
$sql = 'SELECT p.id, p.name, p.price, p.description 
        from tbl_products p
        where p.id=:id;';

$sth = $dbh->prepare($sql);
$sth->execute(['id' => $id]);
if ($row = $sth->fetch()) {
    $name=$row['name'];
    $price=$row['price'];
    $description=$row['description'];
}
$sql = "SELECT pi.name, pi.priority 
        FROM tbl_product_images pi
        WHERE pi.product_id=:id
        ORDER BY pi.priority;";
$sth = $dbh->prepare($sql);
$sth->execute(['id' => $id]);
$images = $sth->fetchAll();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Перегдял товару</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">


</head>
<body>


<?php include "_header.php"; ?>

<div class="container">
    <!--    <h1>Товар</h1>-->

    <div class="container mt-5 mb-5">
        <div class="row d-flex justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="images p-3">

                                <div class="text-center p-4">
                                    <img id="main-image" src="images/<?php echo $images[0]['name']; ?>" width="250" />
                                </div>
                                <div class="thumbnail text-center">
                                    <?php
                                    foreach ($images as $row)
                                    {
                                        echo'<img onclick="change_image(this)" src="images/'.$row["name"].'" width="70">';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="product p-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center"> <i class="fa fa-long-arrow-left"></i> <span class="ml-1">Back</span> </div> <i class="fa fa-shopping-cart text-muted"></i>
                                </div>
                                <div class="mt-4 mb-3"> <span class="text-uppercase text-muted brand">Orianz</span>
                                    <h5 class="text-uppercase"><?php echo $name; ?></h5>
                                    <div class="price d-flex flex-row align-items-center"> <span class="act-price">$<?php echo $price; ?></span>
                                        <!--                                        <div class="ml-2"> <small class="dis-price">$59</small> <span>40% OFF</span> </div>-->
                                    </div>
                                </div>
                                <p class="about"><?php echo $description; ?></p>
                                <div class="cart mt-4 align-items-center"> <button class="btn btn-danger text-uppercase mr-2 px-4">Add to cart</button> <i class="fa fa-heart text-muted"></i> <i class="fa fa-share-alt text-muted"></i> </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="js/bootstrap.bundle.min.js"></script>

<script>
    function change_image(image){
        var container = document.getElementById("main-image");
        container.src = image.src;
    }
    document.addEventListener("DOMContentLoaded", function(event) {
    });
</script>
</body>
</html>