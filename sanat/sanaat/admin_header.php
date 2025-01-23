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
        <a href="tableau.php" class="logo">Panneau <span>d'administration</span></a>

        <nav class="navbar">
            <a href="acceuil.php">Acceuil</a>
            <a href="produits.php">Produit</a>
            <a href="commande_passe.php">Commande</a>
            <a href="compte_administration.php">Compte</a>
            <a href="user.php">Utilisateur</a>
            <a href="message.php">Message</a>
        </nav>
        <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <div id="user-btn" class="fas fa-user"></div>
        </div>
        <div class="profile">
            <?php
            $select_profile = $conn->prepare("SELECT * FROM `admins` WHERE id = ?");
            $select_profile->execute([$admin_id]);
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
            ?>
            <p><?= $fetch_profile['name']; ?></p>
            <a href="modifier_profile.php" class="btn">Modifier le profile</a>
            <div class="flex-btn">
                <a href="admins.php" class="option-btn">Connexion</a>
                <a href="inscription.php" class="option-btn">
                    S'inscrire</a>
            </div>
            <a href="admin_deconnecter.php" onclick="return confirm('Etes vous sur de vous déconnecter?');"
                class="delete-btn">Se déconnecter</a>
        </div>
    </section>
</header>