<?php
if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $name = $_POST['nameProduct'];
    $price = $_POST['priceProduct'];
    $description = $_POST['descriptionProducts'];
    $images = $_POST['imgProduct'];
    echo $images;
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

        <div class="custom__form">
            <div class="custom__image-container">
                <label id="add-img-label" for="add-single-img">Додати фото </label>
                <input type="file" id="add-single-img" accept="image/jpeg"/>
            </div>
            <input
                    type="file"
                    id="image-input"
                    name="photos"
                    accept="image/jpeg"
                    multiple
            />
            <br/>
        </div>


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
<script>
    // Global variables
    const imgInputHelper = document.getElementById("add-single-img");
    const imgInputHelperLabel = document.getElementById("add-img-label");
    const imgContainer = document.querySelector(".custom__image-container");
    const imgFiles = [];

    const addImgHandler = () => {
        const file = imgInputHelper.files[0];
        if (!file) return;
        // Generate img preview
        const reader = new FileReader();
        reader.readAsDataURL(file);
        console.log(file.name);
        reader.onload = () => {
            const newImg = document.createElement("img");
            newImg.id = "imgProduct";
            newImg.src = reader.result;
            imgContainer.insertBefore(newImg, imgInputHelperLabel);
        };
        // Store img file
        imgFiles.push(file);
        // Reset image input
        imgInputHelper.value = "";
        return;
    };


    imgInputHelper.addEventListener("change", addImgHandler);


</script>
</body>
</html>
