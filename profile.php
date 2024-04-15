<?php
    require_once 'helpers/user_helper.php';
    require_once 'helpers/product_helper.php';
    require_once 'layout.php';

    if (!is_logged_in()) {
        header("Location: /");
        exit;
    }

    $conn = connect();
    $user = get_user_by_id($conn, $_SESSION["user_id"]);

    head("Profile");
    css("/styles/components/product_category.css");
    css("/styles/pages/profile.css");
    end_head();
?>

<main>
    <h1 style="margin-bottom: 0;">Welcome</h1>
    <p style="font-size: 24px;"><?php echo $user["login"]; ?></p>

    <h1>Your Products</h1>
    <div class="categories">
        <?php 
            $categories = get_categories($conn);
            foreach ($categories as $category) {
                $products = get_products_by_category_and_author($conn, $category[0], $user["id"]);
                if (empty($products)) continue;
        ?>
            <div class="category">
                <h2><?php echo $category[1] ?></h2>

                <div class="products">
                    <?php foreach ($products as $product) { ?>
                        <div class="product">
                            <a href="/products/product.php?id=<?php echo $product[0] ?>">
                                <div class="image">
                                    <img src="/user_content/uploads/products/<?php echo $product[0] ?>.png" alt="preview of product">
                                </div>

                                <div class="details">
                                    <span class="name"><?php echo $product[1] ?></span>
                                    <span class="description"><?php echo $product[2] ?></span>
                                    <span class="price"><?php echo format_price($product[3]) ?></span>
                                </div>
                            </a>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </div>
</main>

<?php foot($conn); ?>