<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include_once($_SERVER['DOCUMENT_ROOT'] . '/lib/guidv4.php');
    $name = $_POST['nameProduct'];
    $price = $_POST['priceProduct'];
    $description = $_POST['descriptionProducts'];
    include_once($_SERVER['DOCUMENT_ROOT'] . '/connection_database.php');
    $sql = 'INSERT INTO tbl_products (name, price, date_create, description) VALUES(:name, :price, NOW(), :description);';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':description', $description);
    $stmt->execute();

    $sql = "SELECT LAST_INSERT_ID() as id;";
    $item = $dbh->query($sql)->fetch();
    $insert_id = $item['id'];

    $images = $_POST['images'];
    $count=1;
    foreach ($images as $base64) {
        $dir_save = 'images/';
        $image_name = guidv4() . '.jpeg';
        $uploadfile = $dir_save . $image_name;
        list(, $data) = explode(',', $base64);
        $data = base64_decode($data);
        file_put_contents($uploadfile, $data);
        $sql = 'INSERT INTO tbl_product_images (name, datecreate, priority, product_id) VALUES(:name, NOW(), :priority, :product_id);';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':name', $image_name);
        $stmt->bindParam(':priority', $count);
        $stmt->bindParam(':product_id', $insert_id);
        $stmt->execute();
        $count++;
    }

    header("Location: /");
    exit();

}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Сторінка Додати Товар</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/addProductStyle.css">
    <script src="https://kit.fontawesome.com/73f35a2344.js" crossorigin="anonymous"></script>
</head>
<body>
<?php include "_header.php"; ?>

<div class="wrapper">

    <form class="p-3 mt-3" enctype="multipart/form-data" method="post">

        <div class="row">
            <div class="col-12 logo">
                <img class="logoImg"
                     id="imgAvatar"
                     alt=""
                     src="images/logo.jpg">
                <h1>Магазинчик<br>Додавання товару</h1>

            </div>
        </div>

        <div class="mb-3">
            <div class="container">
                <div class="row" id="list_images">
                    <div class="col-md-3" id="selectImages">
                        <label for="image"
                               style="font-size: 120px; cursor:pointer;"
                               class="form-label text-success">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                        </label>
                        <input type="file" class="d-none" multiple id="image" >
                    </div>
                </div>
            </div>
        </div>



        <div class="container">
        <div class="displeyFlex_Space_Bettwen">

            <div class="form-field">
                <input type="text" name="nameProduct" id="nameProduct" placeholder="Назва Товару">
            </div>

            <div class="form-field d-flex align-items-center">
                <input type="number" name="priceProduct" id="priceProduct" placeholder="Ціна">
            </div>
        </div>
        <textarea name="descriptionProducts" id="descriptionProducts" placeholder="Опис Товару"
                  class="form-field_description" cols='120' rows='6'></textarea>
        <button class="btn mt-3">Додати Товар</button>
    </form>

</div>

<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/jquery-3.6.2.min.js"></script>
<script>

    function uuidv4() {
        return ([1e7] + -1e3 + -4e3 + -8e3 + -1e11).replace(/[018]/g, c =>
            (c ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> c / 4).toString(16)
        );
    }
    $(function() {
        const image = document.getElementById("image");
        image.onchange=function(e){
            const files = e.target.files;
            //console.log("Files", files);
            for (let i = 0; i<files.length;i++)
            {
                const reader = new FileReader();
                reader.addEventListener('load', function() {
                    const base64=reader.result;
                    // console.log("base64", base64);
                    const id=uuidv4();
                    const data=`
                    <div class="row">
                        <div class="col-6">
                            <div class="fs-4 ms-2">
                                <label for="${id}" style="cursor: pointer">
                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                </label>
                                <input type="file" class="d-none edit" id="${id}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-end fs-4 text-danger me2 remove">
                                <i class="fa fa-times" style="cursor: pointer" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                    <div>
                        <img src="${base64}" id="${id}_image" width="100%">
                        <input type="hidden" id="${id}_file" value="${base64}" name="images[]">
                    </div>
                   `;
                    const item=document.createElement('div');
                    item.className="col-md-3 item-image";
                    item.innerHTML=data;
                    $("#selectImages").before(item);
                });
                const file = files[i];
                reader.readAsDataURL(file);
            }
        }

        //--------------remove item---------
        $("#list_images").on("click", '.remove', function() {
            $(this).closest(".item-image").remove();
        });
        //---------edit item------
        let edit_id=0;
        $("#list_images").on("change", '.edit', function(e) {
            edit_id = e.target.id;
            const reader = new FileReader();
            reader.addEventListener('load',function() {
                const base64=reader.result;
                document.getElementById(`${edit_id}_image`).src=base64;
                document.getElementById(`${edit_id}_file`).value=base64;
            });
            console.log("Edit id", edit_id);
            const file = e.target.files[0];
            reader.readAsDataURL(file);
            this.value="";
        });
    });
</script>
</body>
</html>
