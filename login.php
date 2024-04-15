<?php
    require_once 'helpers/user_helper.php';
    require_once 'helpers/product_helper.php';
    require_once 'layout.php';

    $invalid_login = false;

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $conn = connect();
        $login = $_POST["login"];
        $password = $_POST["password"];

        $user = login($conn, $login, $password);

        if ($user) {
            header("Location: /");
            exit;
        } else {
            $invalid_login = true;
        }
    }

    head("Login");
    css("/styles/pages/login_register.css");
    end_head();
?>

<main>
    <div class="form_container">
        <div class="account_form">
            <form action="/login.php" method="POST">
                <h1>Login</h1>
                <input class="textbox large" type="text" name="login" id="login" placeholder="Username" autocomplete="off">
                <input class="textbox large" type="password" name="password" id="password" placeholder="Password">
                <input class="button primary" type="submit" value="Login">
                <span class="error"><?php if ($invalid_login) { ?>Invalid login or password<?php } ?></span>
            </form>

            <div class="graphic">
                <img src="/assets/graphics/undraw_login.svg" alt="Login graphic">
            </div>
        </div>
    </div>
</main>

<?php foot($conn); ?>