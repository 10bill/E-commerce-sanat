<?php

include 'connexion.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
    $cpass = sha1($_POST['cpass']);
    $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

    $select_user = $conn->prepare("SELECT * FROM `user` WHERE email = ?");
    $select_user->execute([$email]);
    $row = $select_user->fetch(PDO::FETCH_ASSOC);

    if ($select_user->rowCount() > 0) {
        $message[] = "nom d'utilisateur existant";
    } else {

        if ($pass != $cpass) {
            $message[] = 'le mot de passe ne correspond pas';
        } else {
            $insert_user = $conn->prepare("INSERT INTO `user` (name, email, password) VALUES(?,?,?);");
            $insert_user->execute([$name, $email, $cpass]);
            $message[] = 'inscription reussite';
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
    <title>Inscription utilisateur</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php include 'user_header.php'; ?>


    <section class="form-container">

        <form action="" method="POST">
            <h3>Inscription</h3>
            <input type="text" required maxlength="20" name="name" placeholder="entrer votre nom" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="email" required maxlength="50" name="email" placeholder="entrer votre email" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" required maxlength="20" name="pass" placeholder="entrer votre mot de passe" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" required maxlength="20" name="cpass" placeholder="confirmer votre mot de passe" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="submit" value="inscription" class="btn" name="submit">
            <p>Avez vous déjà un compte?</p>
            <a href="connexion_user.php" class="option-btn">Se connecter</a>
        </form>

    </section>



    <?php include 'footer.php'; ?>
    <script type="text/javascript" src="./script.js"></script>

</body>

</html>