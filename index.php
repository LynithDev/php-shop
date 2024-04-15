<?php
    require_once 'helpers/user_helper.php';
    require_once 'helpers/product_helper.php';
    require_once 'layout.php';

    $conn = connect();

    head("Home");
    css("/styles/components/product_category.css");
    css("/styles/pages/index.css");
    end_head();
?>

<main>
    <div class="featured_product">
        <?php $featured = get_featured_product($conn); ?>
        <div>
            <div class="details">
                <span class="name"><?php echo $featured["name"]; ?></span>
                <span class="description"><?php echo $featured["description"]; ?></span>
                <div class="buttons">
                    <a class="button secondary" href="/products/product.php?id=<?php echo $featured["id"]; ?>">View</a>
                    <span class="price"><?php echo format_price($featured["price"]); ?></span>
                </div>
            </div>

            <div class="image">
                <img src="/user_content/uploads/products/<?php echo $featured["id"]; ?>.png" alt="preview of product">
            </div>
        </div>
    </div>

    <div class="categories">
        <?php 
            $categories = get_categories($conn);
            foreach ($categories as $category) {
                $products = get_products_by_category($conn, $category[0]);
                if (empty($products)) continue;

                include "components/product_category.php";
            }
        ?>
    </div>
</main>

<?php foot($conn); ?>
