<?php

include 'connexion.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admins.php');
};
if (isset($_POST['ajouter_produit'])) {
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $prix = $_POST['prix'];
    $prix = filter_var($prix, FILTER_SANITIZE_STRING);
    $details = $_POST['details'];
    $details = filter_var($details, FILTER_SANITIZE_STRING);

    $image_01 = $_FILES['image_01']['name'];
    $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING);
    $image_01_size = $_FILES['image_01']['size'];
    $image_01_tmp_name = $_FILES['image_01']['tmp_name'];
    $image_01_folder = 'uploaded_img/' . $image_01;

    $image_02 = $_FILES['image_02']['name'];
    $image_02 = filter_var($image_02, FILTER_SANITIZE_STRING);
    $image_02_size = $_FILES['image_02']['size'];
    $image_02_tmp_name = $_FILES['image_02']['tmp_name'];
    $image_02_folder = 'uploaded_img/' . $image_02;

    $image_03 = $_FILES['image_03']['name'];
    $image_03 = filter_var($image_03, FILTER_SANITIZE_STRING);
    $image_03_size = $_FILES['image_03']['size'];
    $image_03_tmp_name = $_FILES['image_03']['tmp_name'];
    $image_03_folder = 'uploaded_img/' . $image_03;

    $select_produits = $conn->prepare("SELECT * FROM `produits` WHERE name= ?");
    $select_produits->execute([$name]);
    if ($select_produits->rowCount() > 0) {
        $message[] = 'Le nom du produit existe déjà';
    } else {
        if ($image_01_size > 2000000 or $image_02_size > 2000000 or $image_03_size > 2000000) {
            $message[] = "la taille de l'image est trop grande";
        } else {
            move_uploaded_file($image_01_tmp_name, $image_01_folder);
            move_uploaded_file($image_02_tmp_name, $image_02_folder);
            move_uploaded_file($image_03_tmp_name, $image_03_folder);

            $insert_produits = $conn->prepare("INSERT INTO `produits` (name, details, prix, image_01, image_02, image_03)
            VALUES(?,?,?,?,?,?)");
            $insert_produits->execute([$name, $details, $prix, $image_01, $image_02, $image_03]);

            $message[] = 'Nouveau produit ajouter';
        }
    }
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete_produits_image = $conn->prepare("SELECT * FROM `produits` WHERE id = ?");
    $delete_produits_image->execute([$delete_id]);
    $fetch_delete_image = $delete_produits_image->fetch(PDO::FETCH_ASSOC);
    unlink('uploaded_img/' . $fetch_delete_image['image_01']);
    unlink('uploaded_img/' . $fetch_delete_image['image_01']);
    unlink('uploaded_img/' . $fetch_delete_image['image_01']);
    $delete_produits = $conn->prepare("DELETE FROM `produits` WHERE id = ?");
    $delete_produits->execute([$delete_id]);
    $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE pid = ?");
    $delete_cart->execute([$delete_id]);
    $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE pid = ?");
    $delete_wishlist->execute([$delete_id]);
    header('location:produits.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produit</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin_style.css">
</head>

<body>
    <?php include 'admin_header.php' ?>

    <section class="ajouter-produit">
        <h1 class="heading">Ajouter de nouveaux produits</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="flex">
                <div class="inputBox">
                    <span>Nom du produit *</span>
                    <input type="text" required placeholder="Entrer le nom du produit" name="name" maxlength="100"
                        class="box">
                </div>
                <div class="inputBox">
                    <span>prix du produit *</span>
                    <input type="number" min="0" max="99999999999" required placeholder="Entrer le prix du produit"
                        name="prix" maxlength="100" onkeypress="if(this.value.length == 10) return false;" class="box">
                </div>
                <div class="inputBox">
                    <span>image 01 *</span>
                    <input type="file" name="image_01" class="box" accept="image/jpg, image/jpeg, image/png, image/webp"
                        required>
                </div>
                <div class="inputBox">
                    <span>image 02 *</span>
                    <input type="file" name="image_02" class="box" accept="image/jpg, image/jpeg, image/png, image/webp"
                        required>
                </div>
                <div class="inputBox">
                    <span>image 03 *</span>
                    <input type="file" name="image_03" class="box" accept="image/jpg, image/jpeg, image/png, image/webp"
                        required>
                </div>
                <div class="inputBox">
                    <span>Détail du produit</span>
                    <textarea name="details" class="box" placeholder="Entrer les détails du produit" required
                        maxlength="500" cols="30" rows="10"></textarea>
                </div>
                <input type="submit" value="Ajouter le produit" name="ajouter_produit" class="btn">
            </div>

        </form>
    </section>

    <section class="show-produits" style="padding-top: 0;">
        <h1 class="heading">produits ajoutés</h1>
        <div class="box-container">

            <?php
            $show_produits = $conn->prepare("SELECT * FROM `produits`");
            $show_produits->execute();
            if ($show_produits->rowCount() > 0) {
                while ($fetch_produits = $show_produits->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <div class="box">

                <img src="uploaded_img/<?= $fetch_produits['image_01']; ?>" alt="">
                <div class="name"><?= $fetch_produits['name']; ?></div>
                <div class="prix"><?= $fetch_produits['prix']; ?> €</div>
                <div class="details"><?= $fetch_produits['details']; ?></div>
                <div class="flex-btn">
                    <a href="modifier_produit.php?update=<?= $fetch_produits['id']; ?>" class="option-btn">Modifier</a>
                </div>

            </div>
            <?php
                }
            } else {
                echo '<p class="empty">Pas de produit ajoutés</p>';
            }
            ?>
        </div>
    </section>

    <script type=" text/javascript" src="./admin_script.js"></script>
</body>

</html>