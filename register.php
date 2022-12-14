<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Сторінка Регестрації</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/registerStyle.css">
    <link rel="stylesheet" href="css/cropper.min.css">
    <style>
        .preview {
            height: 100px !important;
            width: 100px !important;
            border: 1px solid silver;
            overflow: hidden;
        }
    </style>
</head>
<body>
<?php include "_header.php"; ?>
<div class="container">
    <div class="wrapper">
        <div class="logo">
            <img src="images/logo.jpg" alt=""/>
        </div>
        <div class="text-center mt-4 name">Регестрація в магазинчик</div>
        <form class="p-3 mt-3" enctype="multipart/form-data" method="post">

            <div class="avatarUser">
                <label for="image" class="form-label">
                    <img class="avatarUserIMG"
                         src="images/default_portret.png"
                         alt=""
                         width="300"
                         id="selectImage">
                </label>
                <input type="file" class="form-control d-none"
                       id="image" name="image">

            </div>


            <div class="form-field d-flex align-items-center">
                <span class="far fa-user"></span>
                <input
                        type="text"
                        name="userLogin"
                        id="userLogin"
                        placeholder="Логін"
                />
            </div>
            <div class="form-field d-flex align-items-center">
                <span class="far fa-user"></span>
                <input
                        type="text"
                        name="userName"
                        id="userName"
                        placeholder="Ім'я"
                />
            </div>
            <div class="form-field d-flex align-items-center">
                <span class="far fa-user"></span>
                <input
                        type="text"
                        name="userSurname"
                        id="userSurname"
                        placeholder="Прізвище"
                />
            </div>
            <div class="form-field d-flex align-items-center">
                <span class="far fa-user"></span>
                <input
                        type="number"
                        name="userPhone"
                        id="userPhone"
                        placeholder="Телефон"
                />
            </div>
            <div class="form-field d-flex align-items-center">
                <span class="far fa-user"></span>
                <input
                        type="text"
                        name="userCountry"
                        id="userCountry"
                        placeholder="Країна"
                />
            </div>
            <div class="form-field d-flex align-items-center">
                <span class="far fa-user"></span>
                <input
                        type="text"
                        name="userEmail"
                        id="userEmail"
                        placeholder="Електронна пошта"
                />
            </div>
            <div class="form-field d-flex align-items-center">
                <span class="fas fa-key"></span>
                <input
                        type="password"
                        name="passwordUser"
                        id="passwordUser"
                        placeholder="Пароль"
                />
            </div>
            <button type="submit" class="btn mt-3">Зареєструватися</button>
        </form>
    </div>

</div>

<script src="js/bootstrap.bundle.min.js"></script>
<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/_modalCropper.php');
?>

<script src="js/cropper.min.js"></script>
<script>
    const image = document.getElementById("image");
    const imageUser = document.getElementById("selectImage");
    const imgCropper = document.getElementById("imgCropper");
    const imgPrev = document.getElementById("imgPrev");
    const btnCrop = document.getElementById("btnAdd");
    const cropper = new Cropper(imgCropper, {
        aspectRatio: 1 / 1,
        viewMode: 1,
        preview: imgPrev
    });
    image.onchange = function (e) {
        // console.log("select file", e);
        const file = e.target.files[0];
        if (file) {
            const url = URL.createObjectURL(file);
            const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById("cropperModal"));
            modal.show();
            cropper.replace(url);
            image.src = url;
            image.value = "";
        }
    }
    btnCrop.onclick = function (e) {
        const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById("cropperModal"));
        var imgsrc = document.getElementById("image").src;
        imageUser.src = imgsrc;
        console.log(imgsrc);
        modal.hide();

    }

</script>
</body>
</html>
