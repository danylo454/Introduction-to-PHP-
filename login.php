<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Сторінка Логін</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/loginStyle.css">
</head>
<body>
<?php include "_header.php"; ?>
<div class="container">
    <div class="wrapper">
        <div class="logo">
            <img src="images/logo.jpg" alt=""/>
        </div>
        <div class="text-center mt-4 name">Увійти в магазинчик</div>
        <form class="p-3 mt-3">
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
                <span class="fas fa-key"></span>
                <input
                        type="password"
                        name="passwordUser"
                        id="passwordUser"
                        placeholder="Пароль"
                />
            </div>
            <button type="submit" class="btn mt-3">Увійти</button>
        </form>
        <div class="text-center fs-6">
            <a href="#">Забув пароль?</a> або <a href="#">Зареєструватися</a>
        </div>
    </div>

</div>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
