<div class="category">
    <div class="header">
        <h2><?php echo $category[1] ?></h2>
        <?php if (!$product_category_hide_view_all) { ?>
        <div class="view_more">
            <a href="/categories/category.php?id=<?php echo $category[0] ?>" class="button secondary">View All</a>
        </div>
        <?php } ?>
    </div>

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