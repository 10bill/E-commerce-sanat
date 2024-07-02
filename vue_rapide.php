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
    <title>Visualisation</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php include 'user_header.php'; ?>

    <section class="vue-rapide">
        <h1 class="heading">visualisation</h1>
        <?php
        $pid = $_GET['pid'];
        $select_produit = $conn->prepare("SELECT * FROM `produits` WHERE id = ? ");
        $select_produit->execute([$pid]);
        if ($select_produit->rowCount() > 0) {
            while ($fetch_produit = $select_produit->fetch(PDO::FETCH_ASSOC)) {
        ?>
                <form action="" method="post" class="box">
                    <input type="hidden" name="pid" value="<?= $fetch_produit['id']; ?>">
                    <input type="hidden" name="name" value="<?= $fetch_produit['name']; ?>">
                    <input type="hidden" name="prix" value="<?= $fetch_produit['prix']; ?>">
                    <input type="hidden" name="image" value="<?= $fetch_produit['image_01']; ?>">



                    <div class="image-container">
                        <div class="big-image">
                            <img src="uploaded_img/<?= $fetch_produit['image_01']; ?> " alt="">
                        </div>
                        <div class="small-image">
                            <img src="uploaded_img/<?= $fetch_produit['image_01']; ?> " alt="">
                            <img src="uploaded_img/<?= $fetch_produit['image_02']; ?> " alt="">
                            <img src="uploaded_img/<?= $fetch_produit['image_03']; ?> " alt="">
                        </div>
                    </div>

                    <div class="content">
                        <div class="flex">
                            <div class="name"><?= $fetch_produit['name']; ?></div>
                            <div class="prix"><span><?= $fetch_produit['prix']; ?></span> €
                            </div>
                            <input type="number" name="qte" class="qte" min="1" max="99" value="1" onkeypress="if(this.value.length ==2) return false;">
                        </div>
                        <div class="details"><?= $fetch_produit['details']; ?></div>
                        <div class="flex-btn">
                            <input type="submit" value="ajouter au panier" name="ajouter_au_panier" class="btn">
                            <input type="submit" value="ajouter a la liste" name="ajouter_à_la_liste" class="option-btn">
                        </div>
                    </div>
                </form>
        <?php
            }
        } else {
            echo '<p class="empty"> pas de produit trouvé</p>';
        }
        ?>
    </section>




    <?php include 'footer.php'; ?>
    <script type="text/javascript" src="./script.js"></script>

</body>

</html>