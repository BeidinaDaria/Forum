<?php
include_once("php/classes.php");?>
<!DOCTYPE html>
<html lang="ru">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    </head>
    <body>
        <header>
            <div class="logo">
                <img src="../assets/img/Logo.png" alt="Forum">
                <div class="contact">
                    <h2>8 (958) 222-55-11</h2>
                    <h2>8 (918) 94-20-800</h2>
                </div>
            </div>
            <button id="nav_adaptiv" style="width:25%" class="nav_adaptiv" onclick="adaptivMenu('nav')">
                <img src="../assets/img/menu.webp" alt="Menu">
            </button>
            <nav class="hide">
                <a aria-current="page" href="index.php?page=1">О нас</a>
                <a aria-current="page" href="index.php?page=2">О танцах</a>
                <a aria-current="page" href="index.php?page=3">Новости</a>
                <!-- <a href="cup.html">Forum Cup</a> -->
                <a aria-current="page" href="index.php?page=4">Расписание занятий</a>
                <a aria-current="page" href="index.php?page=5">Галерея</a>
                <a aria-current="page" href="index.php?page=6">Личный кабинет</a>
            </nav>
        </header>
        <script>
    function adaptivMenu(str) {
        let navig = document.querySelector(str);
        if (navig.className == "show")
            navig.className = 'hide';
        else navig.className = 'show';
    };
</script>
<main id="main" style="background-image:url(assets/img/background.png);">
    <div class="action">
        <h1>Воплощение вашей истории через искусство движения</h1>
        <h2>Первый месяц занятий - бесплатно!</h2>
    </div>
    <form method="get" enctype="multipart/form-data" >
        <?php if (isset($_GET['appbtn'])){
            if (isset($_GET['name'])&&(isset($_GET['phone'])||isset($_GET['email']))){
                application($_GET['name'],$_GET['phone'],$_GET['email']);
            }
            else {
                include_once("application.php");
                $_GET['appbtn']=null;
            }
        }?>
        <input type="submit" name="appbtn" id="appbtn" value="Оставить заявку">
    </form>
</main>
