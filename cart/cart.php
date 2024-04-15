<?php
    set_include_path(__DIR__ . "/../");
    require_once 'helpers/product_helper.php';
    require_once 'helpers/cart_helper.php';
    require_once 'helpers/user_helper.php';
    require_once 'layout.php';

    $conn = connect();

    $action = $_GET["action"];

    switch ($action) {
        default:
            break;

        case 'ADD_TO_CART': {
            $product_id = $_POST["id"];
            add_to_cart($product_id);

            header("Location: /cart/cart.php");
            exit;
        }

        case 'REMOVE_FROM_CART': {
            $product_id = $_POST["id"];
            remove_from_cart($product_id);

            header("Location: /cart/cart.php");
            exit;
        }

        case 'CHECKOUT': {
            $user_id = $user["id"];

            clear_cart();

            header("Location: /");
            exit;
        }
    }

    $cart = get_cart_products($conn);

    head("Cart");
    css("/styles/pages/cart.css");
    end_head();
?>

<main>
    <h1>Cart</h1>

    <div class="cart">
        <?php
            if (empty($cart)) {
                echo "<p>Your cart is empty</p>";
            } else {
                $total = 0;
                foreach ($cart as $product) {
                    $total += $product[3];
        ?>
                    <div class="cart_item">
                        <div class="image">
                            <img src="/user_content/uploads/products/<?php echo $product[0]; ?>.png" alt="preview of product">
                        </div>

                        <div class="details">
                            <span class="name"><?php echo $product[1]; ?></span>
                            <span class="price"><?php echo format_price($product[3]); ?></span>

                            <form action="/cart/cart.php?action=REMOVE_FROM_CART" method="post">
                                <input type="hidden" name="id" value="<?php echo $product[0]; ?>">
                                <input type="submit" class="button danger" value="Remove" />
                            </form>
                        </div>

                    </div>
        <?php
                }
        ?>
                <div class="total">
                    <span>Total: <?php echo format_price($total); ?></span>
                </div>

                <form action="/cart/cart.php?action=CHECKOUT" method="post">
                    <button class="button primary">Checkout</button>
                </form>
        <?php
            }
        ?>
    </div>
</main>

<?php foot($conn); ?>