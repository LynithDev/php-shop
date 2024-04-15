<?php
    if (basename(__FILE__) === basename($_SERVER['SCRIPT_FILENAME'])) {
        header("HTTP/1.0 404 Not Found");
        exit;
    }

    function add_to_cart($product_id) {
        $cart = $_SESSION["cart"];

        if (!isset($cart)) {
            $cart = array();
        }

        // if (in_array($product_id, $cart)) {
        //     $cart[$product_id] += 1;
        // }

        array_push($cart, $product_id);
        $_SESSION["cart"] = $cart;
    }

    function remove_from_cart($product_id) {
        $cart = $_SESSION["cart"];

        if (!isset($cart)) {
            return;
        }

        $index = array_search($product_id, $cart);
        if ($index !== false) {
            unset($cart[$index]);
        }

        $_SESSION["cart"] = $cart;
    }

    function get_cart() {
        $cart = $_SESSION["cart"];

        if (!isset($cart)) {
            return array();
        }

        return $cart;
    }

    function clear_cart() {
        $_SESSION["cart"] = array();
    }

    function get_cart_products($conn) {
        $cart = get_cart();

        if (empty($cart)) {
            return array();
        }

        $in = str_repeat('?,', count($cart) - 1) . '?';
        $stmt = query(
            $conn, 
            "SELECT * FROM products WHERE id IN ($in)",
            str_repeat('i', count($cart)),
            ...$cart
        );

        return mysqli_fetch_all($stmt);
    }

?>