<?php

include 'connexion.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}

?>



<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La boîte à questions</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php include 'user_header.php'; ?>


    <section class="about">
        <div class="row">
            <div class="image">
                <img src="images/images.jpg" alt="">
            </div>
            <div class="content">
                <h3>Pourquoi nous choisir ? </h3>
                <p>Nous sommes les meilleurs dans le domaine de la vente en ligne!</p>
                <a href="contact.php" class="btn">Nous contacter</a>
            </div>
        </div>
    </section>

    <section class="revue">
        <h1 class="heading">avis clients</h1>
        <div class="swiper revue-slider">
            <div class="swiper-wrapper">
                <div class="swiper-slide slide">
                    <img src="images/image3.jpg" alt="">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                        Labore maiores earum culpa ea possimus illum.</p>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <h3>Arnold</h3>
                </div>
                <div class="swiper-slide slide">
                    <img src="images/image1.jpg" alt="">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                        Labore maiores earum culpa ea possimus illum.</p>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <h3>marcel</h3>
                </div>
                <div class="swiper-slide slide">
                    <img src="images/image2.jpg" alt="">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                        Labore maiores earum culpa ea possimus illum.</p>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <h3>josephine</h3>
                </div>
                <div class="swiper-slide slide">
                    <img src="images/image4.jpg" alt="">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                        Labore maiores earum culpa ea possimus illum.</p>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <h3>Afrique mon afrique</h3>
                </div>
            </div>
            <div class="swiper-pagination"></div>
        </div>

    </section>


    <?php include 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
    <script type="text/javascript" src="./script.js"></script>

    <script>
    var swiper = new Swiper(".revue-slider", {
        loop: true,
        grabCursor: true,
        spaceBetween: 20,
        pagination: {
            el: ".swiper-pagination",
        },
        breakpoints: {
            550: {
                slidesPerView: 2,
            },
            768: {
                slidesPerView: 2,

            },
            1024: {
                slidesPerView: 3,

            },
        },

    });
    </script>
</body>

</html>