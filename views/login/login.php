<?php
$errors = array();

function passRegister($auth, $username, $password) {
    if ($auth->register($username, $password)) {
        $_SESSION['loggedIn'] = true;
        header('Location: /');
        exit;
    } else {
        $_SESSION['loggedIn'] = false;
        return "Registration failed";
    }
}

function passLogin($auth, $username, $password) {
    if ($auth->login($username, $password)) {
        $_SESSION['loggedIn'] = true;
        header('Location: /');
        exit;
    } else {
        $_SESSION['loggedIn'] = false;
        return "Login failed";
    }
}

if (isset($_POST['auth'])) {
    $auth = new \Wuzzy\MusicPlayer\Auth\Auth;

    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($_POST['auth'] == 'register') {
        $errors[] = passRegister($auth, $username, $password);
    } else if ($_POST['auth'] == 'login') {
        $errors[] = passLogin($auth, $username, $password);
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login and Register</title>
</head>
<body>
    <p>
        <?php
        foreach ($errors as $error) {
            echo $error . '<br>';
        }
        ?>
    </p>
    <h1>Login</h1>
    <form action="login" method="post">
        <label for="login_username">Username:</label>
        <input id="login_username" name="username" required="" type="text" />
        <label for="login_password">Password:</label>
        <input id="login_password" name="password" required="" type="password" />
        <input name="auth" value="login" type="submit" value="Login" />
    </form>

    <h1>Register</h1>
    <form action="login" method="post">
        <label for="username">Username:</label>
        <input id="username" name="username" required="" type="text" />
        <label for="password">Password:</label>
        <input id="password" name="password" required="" type="password" />
        <input name="auth" value="register" type="submit" value="Register" />
    </form>
</body>
</html>
