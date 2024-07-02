<?php

include 'connexion.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admins.php');
};

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
    $cpass = sha1($_POST['cpass']);
    $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);


    $select_admin = $conn->prepare("SELECT * FROM `admins` WHERE name = ?");
    $select_admin->execute([$name]);
    if ($select_admin->rowCount() > 0) {
        $message[] = "Le nom d'utilisateur existe déja";
    } else {
        if ($pass != $cpass) {
            $message[] = 'Veuillez confirmer le mot de pass';
        } else {
            $insert_admin = $conn->prepare("INSERT INTO `admins`(name,password) VALUES(?,?)");
            $insert_admin->execute([$name, $cpass]);
            $message[] = 'Nouvel administrateur enregistré';
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
    <title>Inscription</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin_style.css">
</head>

<body>
    <?php include 'admin_header.php' ?>

    <section class="form-container">
        <form action="" method="post">
            <h3>Inscription</h3>
            <input type="text" name="name" required placeholder="Entrer le nom d'utilisateur" class="box"
                maxlength="50">
            <input type="password" name="pass" required placeholder="entrer le mot de pass" class="box" maxlength="50"
                oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" name="cpass" required placeholder="confirmer le mot de passe" class="box"
                maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="submit" value="inscription" name="submit" class="btn">
            <p>Avez vous déjà un compte? <a href="admins.php">Se connecter</a></p>
        </form>
    </section>



    <script type="text/javascript" src="./admin_script.js"></script>
</body>

</html>