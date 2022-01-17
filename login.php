<?php
$error = null;

if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
$link = "https";
else $link = "http";

// Here append the common URL characters.
$link .= "://";

// Append the host(domain name, ip) to the URL.
$link .= $_SERVER['HTTP_HOST'];

// Append the requested resource location to the URL
// $link .= $_SERVER['REQUEST_URI'];


if(isset($_POST['login'])){
    if (empty($_POST['name']))
    {
       $error = "Please enter a name";
    }
    else if(empty($_POST["password"])){
        $error = "Please enter a password";
    }
    else if(!empty($_POST['name']) && !empty($_POST['password'])){
        $name = $_POST['name'];
        $password = $_POST['password'];
        if($name == "Daniel" && $password == "Daniel"){
            header("Location:" . $link . "/product/secret/products.php?page=1");
            exit;
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
    <link rel="stylesheet" href="http://localhost/product/secret/styles/login.css">
    <title>Login</title>
</head>
<body>
    <form action="login.php" method="post" id="login-form">
        <div class="form-field">
            <label for="name">Username</label>
            <input type="text" name="name">
        </div>
        <div class="form-field">
            <label for="password">Password</label>
            <input type="password" name="password">
        </div>
        <div class="form-field">
            <input type="submit" name="login" value="login">
        </div>
    </form>
    <div id="display errors"><?php if($error) echo $error?></div>
</body>
</html>




