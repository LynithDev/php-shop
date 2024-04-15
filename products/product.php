<?php
    set_include_path(__DIR__ . "/../");
    require_once "helpers/product_helper.php";
    require_once "layout.php";

    $conn = connect();
    $product_id = $_GET["id"];
    $product = get_product($conn, $product_id);

    if (!$product) {
        header("HTTP/1.0 404 Not Found");
        exit;
    }

    head("Product - " . $product["name"]);
    css("/styles/components/product_category.css");
    css("/styles/pages/product.css");
    end_head();
?>

<main>
    <div class="current_product">
        <div class="image">
            <img src="/user_content/uploads/products/<?php echo $product["id"]; ?>.png" alt="preview of product">
        </div>

        <div class="details">
            <span class="name"><?php echo $product["name"]; ?></span>
            <span class="description"><?php echo $product["description"]; ?></span>
            <span class="price"><?php echo format_price($product["price"]); ?></span>
            
            <div class="buttons">
                <script>
                    function addToCart() {
                        const product_id = <?php echo $product["id"]; ?>;
                        fetch("/cart/cart.php?action=ADD_TO_CART", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/x-www-form-urlencoded"
                            },
                            body: `id=${product_id}`
                        }).then(() => {
                            window.location.href = "/cart/cart.php";
                        });
                    }
                </script>

                <a class="button primary" href="/cart/buy?id=<?php echo $product["id"]; ?>">Buy Now</a>
                <button class="button tertiary" onclick="addToCart()" >Add to Cart</button>
                <?php
                    if (is_logged_in()) {
                        $user = get_logged_in_user($conn);
                        if (has_permission($user["permissions"], PERMISSION_ADMIN)) {
                ?>
                            <script>
                                function removeProduct() {
                                    const product_id = <?php echo $product["id"]; ?>;
                                    if (confirm("Are you sure you want to remove this product?")) {
                                        fetch("/admin.php?action=REMOVE_PRODUCT", {
                                            method: "POST",
                                            headers: {
                                                "Content-Type": "application/x-www-form-urlencoded"
                                            },
                                            body: `id=${product_id}`
                                        }).then(() => {
                                            window.location.href = "/admin.php";
                                        });
                                    }
                                }
                            </script>
                            <button class="button danger" onclick="removeProduct()">Remove</button>
                <?php
                        }
                    }
                ?>
            </div>
        </div>
    </div>

    <?php
        $category = array($product["category_id"], "Similar Products");
        $products = get_similar_products($conn, $product["id"], $product["category_id"]);
        include "components/product_category.php";
    ?>
</main>

<?php foot($conn); ?>