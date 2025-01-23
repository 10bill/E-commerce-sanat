<?php

include 'connexion.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}
include 'wishlist_cart.php';

?>



<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceuil</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php include 'user_header.php'; ?>

    <div class="home-bg">
        <section class="swiper home-slider">

            <div class="swiper-wrapper">
                <div class="swiper-slide slide">
                    <div class="image">
                        <img src="images/jbl3.png" alt="">
                    </div>
                    <div class="content">
                        <span> Obtenez 60% de réduction
                            <br> sur tous vos achats en ligne</br> avec Sanat le meilleur service en ligne</br>
                        </span>
                        <h3>casque jbl</h3>
                        <a href="magasin.php" class="btn">ACHETEZ MAINTENANT</a>
                    </div>
                </div>
                <div class="swiper-slide slide">

                    <div class="image">
                        <img src="images/iphone16.png" alt="">
                    </div>
                    <div class="content">
                        <span> Obtenez 60% de réduction
                            <br> sur tous vos achats en ligne</br> avec Sanat le meilleur service en ligne</br>
                        </span>
                        <h3>iphone 14 pro max</h3>
                        <a href="magasin.php" class="btn">ACHETEZ MAINTENANT</a>
                    </div>
                </div>
                <div class="swiper-slide slide">

                    <div class="image">
                        <img src="images/appareil photo.png" alt="">
                    </div>
                    <div class="content">
                        <span> Obtenez 60% de réduction
                            <br> sur tous vos achats en ligne</br> avec Sanat le meilleur service en ligne</br>
                        </span>
                        <h3>appareil photo</h3>
                        <a href="magasin.php" class="btn">ACHETEZ MAINTENANT</a>
                    </div>
                </div>

            </div>

        </section>
    </div>

    <section class="home-categorie">
        <h1 class="heading">Catégories de produits</h1>
        <div class=" swiper categorie-slider">
            <div class="swiper-wrapper">
                <a href="categorie.php?categorie=ordinateur" class="swiper-slide slide">
                    <img src="images/pc.jpg" alt="">
                    <h3>ordinateur</h3>
                </a>

                <a href="categorie.php?categorie=télévision" class="swiper-slide slide">
                    <img src="images/télévision samsung 3.jpg" alt="">
                    <h3>télévision</h3>
                </a>
                <a href="categorie.php?categorie=veste" class="swiper-slide slide">
                    <img src="images/veste.jpg" alt="">
                    <h3>veste</h3>
                </a>
                <a href="categorie.php?categorie=crampons" class="swiper-slide slide">
                    <img src="images/adidas.jpg" alt="">
                    <h3>crampons</h3>
                </a>
                <a href="categorie.php?categorie=iphone 13 pro max" class="swiper-slide slide">
                    <img src="images/iphone 13 pro max.jpg" alt="">
                    <h3>iphone </h3>
                </a>
                <a href="categorie.php?categorie=congélateur" class="swiper-slide slide">
                    <img src="images/congélateur.jpeg" alt="">
                    <h3>congélateur</h3>
                </a>
                <a href="categorie.php?categorie=jbl" class="swiper-slide slide">
                    <img src="images/jbl.jpg" alt="">
                    <h3>casque jbl</h3>
                </a>
                <a href="categorie.php?categorie=appareil photo" class="swiper-slide slide">
                    <img src="images/appareil photo.png" alt="">
                    <h3>Appareil numérique</h3>
                </a>
                <a href="categorie.php?categorie=montre" class="swiper-slide slide">
                    <img src="images/montre.webp" alt="">
                    <h3>montre</h3>

                </a>
                <a href="categorie.php?categorie=sac à main" class="swiper-slide slide">
                    <img src="images/gucci 1.jpg" alt="">
                    <h3>sac à main</h3>
                </a>
                <a href="categorie.php?categorie=valise" class="swiper-slide slide">
                    <img src="images/valise 2.jpg" alt="">
                    <h3>valise</h3>
                </a>
                <a href="categorie.php?categorie=jacket" class="swiper-slide slide">
                    <img src="images/jacket.webp" alt="">
                    <h3>jacket</h3>
                </a>

            </div>

        </div>
    </section>

    <section class="home-produits">
        <h1 class="heading">Dernier produits</h1>
        <div class="swiper produits-slider">
            <div class="swiper-wrapper">
                <?php
                $select_produit = $conn->prepare("SELECT * FROM `produits` LIMIT 15 ");
                $select_produit->execute();
                if ($select_produit->rowCount() > 0) {
                    while ($fetch_produit = $select_produit->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <form action="" method="post" class="slide swiper-slide">
                    <input type="hidden" name="pid" value="<?= $fetch_produit['id']; ?>">
                    <input type="hidden" name="name" value="<?= $fetch_produit['name']; ?>">
                    <input type="hidden" name="prix" value="<?= $fetch_produit['prix']; ?>">
                    <input type="hidden" name="image" value="<?= $fetch_produit['image_01']; ?>">


                    <button type="submit" name="ajouter_à_la_liste" class="fas fa-heart"></button>
                    <a href="vue_rapide.php?pid=<?= $fetch_produit['id']; ?>" class="fas fa-eye"></a>
                    <img src="uploaded_img/<?= $fetch_produit['image_01']; ?> " class="image" alt="">
                    <div class="name"><?= $fetch_produit['name']; ?></div>
                    <div class="flex">
                        <div class="prix"><span><?= $fetch_produit['prix']; ?></span> €
                        </div>
                        <input type="number" name="qte" class="qte" min="1" max="99" value="1"
                            onkeypress="if(this.value.length ==2) return false;">
                    </div>
                    <input type="submit" value="ajouter au panier" name="ajouter_au_panier" class="btn">
                </form>
                <?php
                    }
                } else {
                    echo '<p class="empty"> Aucun produit ajouter</p>';
                }
                ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </section>











    <?php include 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
    <script type="text/javascript" src="./script.js"></script>

    <script>
    var swiper = new Swiper(".home-slider", {
        loop: true,
        grabCursor: true,
        pagination: {
            el: ".swiper-pagination",
        },
    });
    var swiper = new Swiper(".categorie-slider", {
        loop: true,
        grabCursor: true,
        spaceBetween: 20,
        pagination: {
            el: ".swiper-pagination",
        },
        breakpoints: {
            0: {
                slidesPerView: 2,
            },
            650: {
                slidesPerView: 2,
            },
            768: {
                slidesPerView: 3,

            },
            1024: {
                slidesPerView: 4,

            },
        },

    });

    var swiper = new Swiper(".produits-slider", {
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