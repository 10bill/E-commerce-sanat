<?php

include 'connexion.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admins.php');
}
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);

    $update_name = $conn->prepare("UPDATE `admins` SET name = ? WHERE id = ?");
    $update_name->execute([$name, $admin_id]);
    $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
    $select_old_pass = $conn->prepare("SELECT password FROM `admins` WHERE id = ?");
    $select_old_pass->execute([$admin_id]);
    $fetch_prev_pass = $select_old_pass->fetch(PDO::FETCH_ASSOC);
    $prev_pass = $fetch_prev_pass['password'];
    $old_pass = sha1($_POST['old_pass']);
    $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
    $new_pass = sha1($_POST['new_pass']);
    $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
    $confirm_pass = sha1($_POST['confirm_pass']);
    $confirm_pass = filter_var($confirm_pass, FILTER_SANITIZE_STRING);

    if ($old_pass == $empty_pass) {
        $message[] = "Veuillez entrer l'ancien mot de pass";
    } elseif ($old_pass != $prev_pass) {
        $message[] = "L'ancien mot de passe ne correspond pas";
    } elseif ($new_pass != $confirm_pass) {
        $message[] = 'Veuillez confirmer le mot de pass';
    } else {
        if ($new_pass != $empty_pass) {
            $update_pass = $conn->prepare("UPDATE `admins` SET password = ? WHERE id = ?");
            $update_pass->execute([$confirm_pass, $admin_id]);
            $message[] = 'Mot de pass modifer avec succèe';
        } else {
            $message[] = 'Veuillez entrer le nouveau mot de pass';
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
    <title>Modifier produit</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin_style.css">
</head>

<body>
    <?php include 'admin_header.php' ?>

    <section class="form-container">
        <form action="" method="post">
            <h3>Modifier le profile</h3>
            <input type="text" name="name" required placeholder="Entrer le nom d'utilisateur" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')" value="<?= $fetch_profile['name'] ?>">
            <input type="password" name="old_pass" required placeholder="entrer l'ancien mot de pass" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" name="new_pass" required placeholder="entrer le nouveau mot de pass" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" name="confirm_pass" required placeholder="confirmer le nouveau mot de passe" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="submit" value="Modifier" name="submit" class="btn">
        </form>
    </section>

    <script type="text/javascript" src="./admin_script.js"></script>
</body>

</html>