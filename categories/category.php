<?php
    set_include_path(__DIR__ . "/../");
    require_once 'helpers/product_helper.php';
    require_once 'helpers/user_helper.php';
    require_once 'layout.php';

    $conn = connect();

    $category_id = $_GET["id"];
    $category = get_category($conn, $category_id);
    if (!$category) {
        header("HTTP/1.0 404 Not Found");
        exit;
    }

    head($category["name"]);
    css("/styles/components/product_category.css");
    css("/styles/pages/category.css");
    end_head();

    $products = get_products_by_category($conn, $category_id, null);
?>

<main>
    <?php
        if (empty($products)) {
            echo "<p>No products found in this category</p>";
        } else {
            $category = array($category_id, $category["name"]);
            $product_category_hide_view_all = true;
            include "components/product_category.php";
        }
    ?>
</main>

<?php foot($conn); ?>