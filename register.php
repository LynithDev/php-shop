<?php
    require_once 'helpers/user_helper.php';
    require_once 'helpers/product_helper.php';
    require_once 'layout.php';

    $invalid_register = false;

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $conn = connect();
        $login = $_POST["login"];
        $password = $_POST["password"];
        $confirm_password = $_POST["confirm_password"];

        if ($password === $confirm_password) {
            $user = register($conn, $login, $password);
    
            if ($user === true) {
                login($conn, $login, $password);
                header("Location: /");
                exit;
            } else {
                $invalid_register = $user;
            }
        } else {
            $invalid_register = "Passwords do not match";
        }
    }

    head("Register");
    css("/styles/pages/login_register.css");
    end_head();
?>

<main>
    <div class="form_container">
        <div class="account_form">
            <form action="/register.php" method="POST">
                <h1>Register</h1>
                <input class="textbox large" type="text" name="login" id="login" placeholder="Username" autocomplete="off">
                <input class="textbox large" type="password" name="password" id="password" placeholder="Password">
                <input class="textbox large" type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password">
                <input class="button primary" type="submit" value="register">
                <span class="error"><?php if ($invalid_register) { echo $invalid_register; } ?></span>
            </form>

            <div class="graphic">
                <img src="/assets/graphics/undraw_welcome.svg" alt="Register graphic">
            </div>
        </div>
    </div>
</main>

<?php foot($conn); ?>