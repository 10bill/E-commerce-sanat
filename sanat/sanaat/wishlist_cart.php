<?php

if (isset($_POST['ajouter_à_la_liste'])) {

    if ($user_id == '') {
        header('location:connexion_user.php');
    } else {
        $pid = $_POST['pid'];
        $pid = filter_var($pid, FILTER_SANITIZE_STRING);
        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $prix = $_POST['prix'];
        $prix = filter_var($prix, FILTER_SANITIZE_STRING);
        $image = $_POST['image'];
        $image = filter_var($image, FILTER_SANITIZE_STRING);

        $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name= ? AND user_id = ?");
        $check_wishlist_numbers->execute([$name, $user_id]);

        $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name= ? AND user_id = ?");
        $check_cart_numbers->execute([$name, $user_id]);

        if ($check_wishlist_numbers->rowCount() > 0) {
            $message[] = 'produit déja ajouter dans la liste';
        } elseif ($check_cart_numbers->rowCount() > 0) {
            $message[] = 'produit déja ajouter au panier';
        } else {
            $insert_wishlist = $conn->prepare("INSERT INTO `wishlist` (user_id, pid, name, prix,image) VALUES(?,?,?,?,?)");
            $insert_wishlist->execute([$user_id,  $pid,  $name,  $prix, $image]);
            $message[] = 'ajouter à la liste';
        }
    }
}
if (isset($_POST['ajouter_au_panier'])) {

    if ($user_id == '') {
        header('location:connexion_user.php');
    } else {
        $pid = $_POST['pid'];
        $pid = filter_var($pid, FILTER_SANITIZE_STRING);
        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $prix = $_POST['prix'];
        $prix = filter_var($prix, FILTER_SANITIZE_STRING);
        $image = $_POST['image'];
        $image = filter_var($image, FILTER_SANITIZE_STRING);
        $qte = $_POST['qte'];
        $qte = filter_var($qte, FILTER_SANITIZE_STRING);

        $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name= ? AND user_id = ?");
        $check_cart_numbers->execute([$name, $user_id]);

        if ($check_cart_numbers->rowCount() > 0) {
            $message[] = 'produit déja ajouter au panier';
        } else {

            $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name= ? AND user_id = ?");
            $check_wishlist_numbers->execute([$name, $user_id]);

            if ($check_wishlist_numbers->rowCount() > 0) {
                $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE name= ? AND user_id = ?");
                $delete_wishlist->execute([$name, $user_id]);
            }
            $insert_cart = $conn->prepare("INSERT INTO `cart` (user_id, pid, name, prix, quantity, image) VALUES(?,?,?,?,?,?)");
            $insert_cart->execute([$user_id,  $pid,  $name,  $prix, $qte, $image]);
            $message[] = 'produit ajouter au panier';
        }
    }
}
