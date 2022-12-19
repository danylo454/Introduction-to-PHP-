
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Головна сторінка</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include "_header.php"; ?>

<?php
include_once "connection_database.php";
?>

<div class="container">
        <div class="container containerMain py-5">
            <div class="row">
                <?php
                $sql = "SELECT p.id, p.name, p.price, pi.name as image
                from tbl_products p, tbl_product_images pi 
                where p.id=pi.product_id
                and pi.priority=1;";
                foreach ($dbh->query($sql) as $row) {
                    $id = $row['id'];
                    $image = $row['image'];
                    $name = $row["name"];
                    $price = $row["price"];
                    echo '
                <div class="col-md-6 col-lg-4 mb-4 mb-md-0">      
                    <div class="card">
                    
                        <img src="images/' . $image . '" class="card-img-top" alt="Клавіатура"/>           
                        <div class="card-body">
                        
                            <div class="d-flex justify-content-between mb-3" style="height: 100px">
                               <h5 class="mb-0">' . $name . '</h5>
                           </div>

                           <div class="mb-2 d-flex justify-content-between ">
                                <h5 class="text-dark mb-0">' . $price . '₴</h5>
                                <a href="product.php?id=' . $id . '" class="btn btn-success">Купить</a>
                                <a href="#" class="btn btn-success" data-delete="'.$id.'">Видалить</a>
                                <a href="editProduct.php?id=' . $id . '" class="btn btn-success">Редагування</a>
                            </div>
                       </div>
                    </div>            
                </div>
                    ';
                }
                ?>


            </div>
        </div>
</div>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/jquery-3.6.2.min.js"></script>
<script src="js/axios.min.js"></script>
<script>
    $(function(){
       $("body").on('click', "[data-delete]", function(e) {
           e.preventDefault();
           //console.log("Delete element ", e.target);
           const id = this.dataset["delete"];
           var bodyFormData = new FormData();
           bodyFormData.append('id', id);
           axios({
               method: "post",
               url: "/deleteProduct.php",
               data: bodyFormData
           }).then(function(resp) {
               console.log("SERVER Response ", resp);
           });
       });
    });
</script>
</body>
</html>