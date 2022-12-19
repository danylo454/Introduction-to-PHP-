<?php
include_once "connection_database.php";
$id = $_GET['id'];
$name = '';
$price = '';
$description = '';
$sql = 'SELECT p.id, p.name, p.price, p.description 
        from tbl_products p
        where p.id=:id;';

$sth = $dbh->prepare($sql);
$sth->execute(['id' => $id]);

if ($row = $sth->fetch()) {
    $name = $row['name'];
    $price = $row['price'];
    $description = $row['description'];
}
$sql = "SELECT pi.id, pi.name, pi.priority 
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
    <title>Сторінка Редагувати Товар</title>
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
                <h1>Магазинчик<br>Оновлення товару</h1>

            </div>
        </div>

        <div class="mb-3">
            <div class="container">
                <div class="row" id="list_images">
                    <?php foreach ($images as $row) {
                        echo '
                        <div class="col-md-2 item-image">
                        <div class="row">
                            <div class="col-6">
                                <div class="fs-4 ms-2">
                                    <label for="'.$row["id"].'">
                                        <i class="fa fa-pencil" style="cursor: pointer;" aria-hidden="true"></i>
                                    </label>
                                    <input type="file" class="form-control d-none edit" id="'.$row["id"].'">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-end fs-4 text-danger me-2 remove">
                                    <i class="fa fa-times" style="cursor: pointer" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                        <div>
                            <img src="images/'.$row["name"].'" id="'.$row["id"].'_image" alt="photo" style="width: 100%;height: 150px;border-radius: 50px;">
                            <input type="hidden" id="'.$row["id"].'_file" value="images/' . $row["name"] . '" name="images[]">
                        </div>
                        
                        </div>                                           
                        ';

                    }
                    ?>
                    <div class="col-md-2">
                        <label for="image" style="cursor: pointer;" class="form-label text-success">
                            <i class="fa fa-plus-square-o" style="font-size:120px" aria-hidden="true"></i>
                        </label>
                        <input type="file" class="form-control d-none" id="image" multiple>
                    </div>
                </div>
            </div>
        </div>


        <div class="container">
            <div class="displeyFlex_Space_Bettwen">

                <div class="form-field">
                    <input type="text" name="nameProduct" id="nameProduct" value="<?php echo $name; ?>">
                </div>

                <div class="form-field d-flex align-items-center">
                    <input type="number" name="priceProduct" id="priceProduct" value="<?php echo $price; ?>">
                </div>
            </div>
            <textarea name="descriptionProducts" id="descriptionProducts"

                      class="form-field_description" cols='120' rows='6'><?php echo $description; ?></textarea>
            <button class="btn mt-3">Оновити</button>
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

    //window.onload
    $(function () {
//-----------------------SELECT IMAGES LIST---------------------------
        const image = document.getElementById("image");
        image.onchange = function (e) {
            const files = e.target.files;
            for (let i = 0; i < files.length; i++) {
                const reader = new FileReader();
                reader.addEventListener('load', function () {
                    const base64 = reader.result;
                    const id = uuidv4();
                    const data = `
                        <div class="row">
                            <div class="col-6">
                                <div class="fs-4 ms-2">
                                    <label for="${id}">
                                        <i class="fa fa-pencil" style="cursor: pointer;" aria-hidden="true"></i>
                                    </label>
                                    <input type="file" class="form-control d-none edit" id="${id}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-end fs-4 text-danger me-2 remove">
                                    <i class="fa fa-times" style="cursor: pointer" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                        <div>
                            <img src="${base64}" id="${id}_image" alt="photo" style="width: 100%;height: 150px;border-radius: 50px;">
                            <input type="hidden" id="${id}_file" value="${base64}" name="images[]">
                        </div>
                    `;
                    const item = document.createElement('div');
                    item.className = "col-md-2 item-image";
                    item.innerHTML = data;
                    document.getElementById('list_images').prepend(item);
                });
                const file = files[i];
                if (file)
                    reader.readAsDataURL(file);
            }
            image.value = "";
        }
//-----------------------REMOVE ITEM BY LIST---------------------------------------------
        $("#list_images").on('click', '.remove', function () {
            $(this).closest('.item-image').remove();
        });
//-----------------------CHANGE IMAGE LIST ITEM-------------------------------------
        let edit_id = 0;
        const reader = new FileReader();
        reader.addEventListener('load', () => {
            const base64 = reader.result;
            document.getElementById(`${edit_id}_image`).src = base64;
            document.getElementById(`${edit_id}_file`).value = base64;
        });


        $("#list_images").on('change', '.edit', function (e) {
            edit_id = e.target.id;
            const file = e.target.files[0];
            reader.readAsDataURL(file);
            this.value = "";
        });
    });
</script>
</body>
</html>


