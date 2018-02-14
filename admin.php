<?php
session_start();

if ($_SESSION['admin'] == true) {
    header("location: index.php");
    exit();
}
else if (sha1($_POST['password']) == "0a6160c5ea90730ce1a8030f38c82984ea600ea2") {
    $_SESSION['admin'] = true;
    header("location: index.php");
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>FatJapan</title>

    <?php include("includes/fonts.php"); ?>

    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/admin-login.css">
</head>
<body>
    
<form action="" method="post">
    <div><img src="img/profile.png"></div>
    <input type="password" name="password" placeholder="Admin Password">
    <input type="submit" value="SUBMIT">
</form>

</body>
</html>