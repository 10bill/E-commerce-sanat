<?php

include 'connexion.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admins.php');
};
if (isset($_POST['update'])) {
    $pid = $_POST['pid'];
    $pid = filter_var($pid, FILTER_SANITIZE_STRING);
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $prix = $_POST['prix'];
    $prix = filter_var($prix, FILTER_SANITIZE_STRING);
    $details = $_POST['details'];
    $details = filter_var($details, FILTER_SANITIZE_STRING);


    $update_produit = $conn->prepare("UPDATE `produits` SET name = ?, details = ?, prix = ? WHERE id = ?");
    $update_produit->execute([$name, $details, $prix, $pid]);

    $message[] = 'Produit modifier';

    $old_image_01 = $_POST['old_image_01'];
    $image_01 = $_FILES['image_01']['name'];
    $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING);
    $image_01_size = $_FILES['image_01']['size'];
    $image_01_tmp_name = $_FILES['image_01']['tmp_name'];
    $image_01_folder = 'uploaded_img/' . $image_01;

    if (!empty($image_01)) {
        if ($image_01_size > 2000000) {
            $message[] = "la taille de l'image est trop grande";
        } else {
            $update_image_01 = $conn->prepare("UPDATE `produits` SET image_01 = ? WHERE id = ? ");
            $update_image_01->execute([$image_01, $pid]);
            move_uploaded_file($image_01_tmp_name, $image_01_folder);
            unlink('uploaded_img/' . $old_image_01);
            $message[] = "l'image 01 modifier";
        }
    }

    $old_image_02 = $_POST['old_image_02'];
    $image_02 = $_FILES['image_02']['name'];
    $image_02 = filter_var($image_02, FILTER_SANITIZE_STRING);
    $image_02_size = $_FILES['image_02']['size'];
    $image_02_tmp_name = $_FILES['image_02']['tmp_name'];
    $image_02_folder = 'uploaded_img/' . $image_02;


    if (!empty($image_02)) {
        if ($image_02_size > 2000000) {
            $message[] = "la taille de l'image est trop grande";
        } else {
            $update_image_02 = $conn->prepare("UPDATE `produits` SET image_02 = ? WHERE id = ? ");
            $update_image_02->execute([$image_02, $pid]);
            move_uploaded_file($image_02_tmp_name, $image_02_folder);
            unlink('uploaded_img/' . $old_image_02);
            $message[] = "l'image 02 modifier";
        }
    }

    $old_image_03 = $_POST['old_image_03'];
    $image_03 = $_FILES['image_03']['name'];
    $image_03 = filter_var($image_03, FILTER_SANITIZE_STRING);
    $image_03_size = $_FILES['image_03']['size'];
    $image_03_tmp_name = $_FILES['image_03']['tmp_name'];
    $image_03_folder = 'uploaded_img/' . $image_03;


    if (!empty($image_03)) {
        if ($image_03_size > 2000000) {
            $message[] = "la taille de l'image est trop grande";
        } else {
            $update_image_03 = $conn->prepare("UPDATE `produits` SET image_03 = ? WHERE id = ? ");
            $update_image_03->execute([$image_03, $pid]);
            move_uploaded_file($image_03_tmp_name, $image_03_folder);
            unlink('uploaded_img/' . $old_image_03);
            $message[] = "l'image 03 modifier";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier profile</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin_style.css">
</head>

<body>
    <?php include 'admin_header.php' ?>

    <section class="modifier-produit">
        <h1 class="heading">Modifier le produit</h1>
        <?php
        $update_id = $_GET['update'];
        $show_produits = $conn->prepare("SELECT * FROM `produits` WHERE id = ?");
        $show_produits->execute([$update_id]);
        if ($show_produits->rowCount() > 0) {
            while ($fetch_produits = $show_produits->fetch(PDO::FETCH_ASSOC)) {
        ?>
                <form action="" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="pid" value="<?= $fetch_produits['id']; ?>">
                    <input type="hidden" name="old_image_01" value="<?= $fetch_produits['image_01']; ?>">
                    <input type="hidden" name="old_image_02" value="<?= $fetch_produits['image_02']; ?>">
                    <input type="hidden" name="old_image_03" value="<?= $fetch_produits['image_03']; ?>">
                    <div class="image-container">
                        <div class="main-image">
                            <img src="uploaded_img/<?= $fetch_produits['image_01']; ?>" alt="">
                        </div>
                        <div class="sub-images">
                            <img src="uploaded_img/<?= $fetch_produits['image_01']; ?>" alt="">
                            <img src="uploaded_img/<?= $fetch_produits['image_02']; ?>" alt="">
                            <img src="uploaded_img/<?= $fetch_produits['image_03']; ?>" alt="">
                        </div>
                    </div>
                    <span>Modifier le nom</span>
                    <input type="text" required placeholder="Entrer le nom du produit" name="name" maxlength="100" class="box" value="<?= $fetch_produits['name']; ?>">
                    <span>Modifier le prix</span>
                    <input type="number" min="0" max="99999999999" required placeholder="Entrer le prix du produit" name="prix" maxlength="100" onkeypress="if(this.value.length == 10) return false;" class="box" value="<?= $fetch_produits['prix']; ?>">
                    <span>Modifier les détails</span>
                    <textarea name="details" class="box" placeholder="Entrer les détails du produit" required maxlength="500" cols="30" rows="10"><?= $fetch_produits['details']; ?></textarea>
                    <span>Modifier l'image 01</span>
                    <input type="file" name="image_01" class="box" accept="image/jpg, image/jpeg, image/png, image/webp">
                    <span>Modifier l'image 02</span>
                    <input type="file" name="image_02" class="box" accept="image/jpg, image/jpeg, image/png, image/webp">
                    <span>Modifier l'image 03</span>
                    <input type="file" name="image_03" class="box" accept="image/jpg, image/jpeg, image/png, image/webp">
                    <div class="flex-btn">
                        <input type="submit" value="Modifier" class="btn" name="update">
                        <a href="produit.php" class="option-btn">Retour</a>
                    </div>
                </form>
        <?php
            }
        } else {
            echo '<p class="empty">Pas de produit ajoutés</p>';
        }
        ?>
    </section>


    <script type="text/javascript" src="./admin_script.js"></script>
</body>

</html>