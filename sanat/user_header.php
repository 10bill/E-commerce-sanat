<?php
if (isset($message)) {
    foreach ($message as $message) {
        echo '
            <div class="message">
            <span>' . $message . '</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
        </div>
            
            ';
    }
}

?>

<header class="header">

    <section class="flex">
        <a href="admins.php" class="logo"><span>S</span>anat</a>



        <nav class="navbar">
            <a href="acceuil.php">Acceuil</a>
            <a href="avis.php">Avis</a>
            <a href="commande.php">Commande</a>
            <a href="Magasin.php">Magasin</a>
            <a href="contact.php">Contact</a>
        </nav>
        <div class="icons">
            <?php

            $count_wishlist_items = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
            $count_wishlist_items->execute([$user_id]);
            $count_wishlist_items = $count_wishlist_items->rowCount();

            $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $count_cart_items->execute([$user_id]);
            $count_cart_items =  $count_cart_items->rowCount();

            ?>
            <div id="menu-btn" class="fas fa-bars"></div>
            <a href="recherche.php"><i class="fas fa-search"></i></a>
            <a href="wishlist.php"><i class="fas fa-heart"></i><span><?= $count_wishlist_items ?></span></a>
            <a href="cart.php"><i class="fas fa-shopping-cart"></i><span><?= $count_cart_items ?></span></a>
            <div id="user-btn" class="fas fa-user"></div>
        </div>
        <div class="profile">
            <?php
            $select_profile = $conn->prepare("SELECT * FROM `user` WHERE id = ?");
            $select_profile->execute([$user_id]);
            if ($select_profile->rowCount() > 0) {
                $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);


            ?>
            <p><?= $fetch_profile['name']; ?></p>
            <a href="modifier_user.php" class="btn">Modifier le profile</a>
            <div class="flex-btn">
                <a href="connexion_user.php" class="option-btn">Connexion</a>
                <a href="inscription_user.php" class="option-btn">
                    S'inscrire</a>
            </div>
            <a href="user_deconnecter.php" onclick="return confirm('Etes vous sur de vous déconnecter?');"
                class="delete-btn">Se déconnecter</a>
            <?php

            } else {
            ?>
            <p>Veuillez vous connecter d'abord</p>
            <div class="flex-btn">
                <a href="connexion_user.php" class="option-btn">Connexion</a>
                <a href="inscription_user.php" class="option-btn">
                    S'inscrire</a>
            </div>
            <?php
            }
            ?>
        </div>
    </section>
</header>