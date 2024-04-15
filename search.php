<?php
    set_include_path(__DIR__ . "/../");
    require_once 'helpers/product_helper.php';
    require_once 'helpers/user_helper.php';
    require_once 'layout.php';

    $conn = connect();

    $query = $_GET["q"];
    $products = search_products($conn, $query);

    head("Search: $query");
    css("/styles/components/product_category.css");
    css("/styles/pages/category.css");
    end_head();
?>

<main>
    <?php
        if (empty($products)) {
            echo "<p>No products found for '$query'</p>";
        } else {
            $category = array(null, "Search Results");
            $product_category_hide_view_all = true;
            include "components/product_category.php";
        }
    ?>
</main>