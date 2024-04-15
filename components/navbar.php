<?php
    require_once "helpers/user_helper.php";
    $conn = connect();
?>

<div class="navbar">
    <nav>
        <div>
            <a href="/" class="logo">
                <img src="/assets/logo.png" alt="logo">
                <span>Lynith Shop</span>
            </a>
        </div>

        <div>
            <script>
                function searchProducts() {
                    const search = document.getElementById("search").value;
                    window.location.href = `/search.php?q=${search}`;
                }
            </script>

            <input type="text" name="search" id="search" class="textbox" placeholder="Search..." onchange="searchProducts()">

            <a href="/">Home</a>
            <a href="/cart/cart.php">Cart</a>
            <?php if (is_logged_in()) { ?>
                <?php 
                    $user = get_logged_in_user($conn);
                    if (has_permission($user["permissions"], PERMISSION_ADMIN)) { 
                ?>
                    <a href="/admin.php">Admin</a>
                <?php } ?>

                <a href="/profile.php">Profile</a>
                <a href="/logout.php">Logout</a>
            <?php } else { ?>
                <a href="/login.php">Login</a>
                <a href="/register.php">Register</a>
            <?php } ?>
        </div>
    </nav>
</div>