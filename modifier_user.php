<?php

include 'connexion.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
    header('location:acceuil.php');
}
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);

    $update_profile = $conn->prepare("UPDATE `user` SET name = ?, email = ? WHERE id = ?");
    $update_profile->execute([$name, $email, $user_id]);

    $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
    $select_prev_pass = $conn->prepare("SELECT password FROM `user` WHERE id= ?");
    $select_prev_pass->execute([$user_id]);
    $fetch_prev_pass = $select_prev_pass->fetch(PDO::FETCH_ASSOC);
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
        $message[] = 'le mot de passe ne correspond pas';
    } else {
        if ($new_pass != $empty_pass) {
            $update_pass = $conn->prepare("UPDATE `user` SET password = ? WHERE id = ?");
            $update_pass->execute([$confirm_pass, $user_id]);
            $message[] = 'Mot de pass modifer avec succè';
        } else {
            $message[] = 'Veuillez entrer le nouveau mot de pass';
        }
    }
}




?>



<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier utilisateur</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php include 'user_header.php'; ?>


    <section class="form-container">

        <form action="" method="POST">
            <h3>Modifier mon profile</h3>
            <input type="text" required maxlength="20" name="name" placeholder="entrer votre nom" class="box"
                oninput="this.value = this.value.replace(/\s/g, '')" value="<?= $fetch_profile['name'] ?>">
            <input type="email" required maxlength="50" name="email" placeholder="entrer votre email" class="box"
                oninput="this.value = this.value.replace(/\s/g, '')" value="<?= $fetch_profile['email'] ?>">
            <input type="password" maxlength="20" name="old_pass" placeholder="entrer votre ancien mot de passe"
                class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" maxlength="20" name="new_pass" placeholder="entrer votre nouveau mot de passe"
                class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" maxlength="20" name="confirm_pass" placeholder="confirmer votre nouveau mot de passe"
                class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="submit" value="modifier" class="btn" name="submit">

        </form>

    </section>




    <?php include 'footer.php'; ?>
    <script type="text/javascript" src="./script.js"></script>

</body>

</html>