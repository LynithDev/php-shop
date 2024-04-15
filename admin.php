<?php
    require_once "helpers/user_helper.php";
    require_once "helpers/product_helper.php";
    require_once "layout.php";
    
    if (!is_logged_in()) {
        header("Location: /login.php");
        exit;
    }

    $conn = connect();
    $user = get_logged_in_user($conn);
    if (!has_permission($user["permissions"], PERMISSION_ADMIN)) {
        header("HTTP/1.0 404 Not Found");
        exit;
    }

    $status_msg = null;

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $action = $_GET["action"];
        
        switch ($action) {
            default:
                break;

            case 'SET_FEATURED': {
                $product_id = $_POST["id"];
                $product = get_product($conn, $product_id);

                if ($product) {
                    set_featured_product($conn, $product_id);
                    header("Location: /");
                    exit;
                } else {
                    $status_msg = "Product not found";
                }

                break;
            }

            case 'ADD_PRODUCT': {
                $image = $_FILES["image"];
                $name = $_POST["name"];
                $description = $_POST["description"];
                $price = $_POST["price"];
                $category = $_POST["category"];
                $author = $user["id"];

                $product_id = add_product($conn, $image, $name, $description, $price, $category, $author);

                if ($product_id) {
                    header("Location: /products/product.php?id=" . $product_id);
                    exit;
                } else {
                    header("HTTP/1.0 500 Internal Server Error");
                    exit;
                }

                break;
            }

            case 'REMOVE_PRODUCT': {
                $product_id = $_POST["id"];
                $product = get_product($conn, $product_id);

                if ($product) {
                    remove_product($conn, $product_id);
                    header("Location: /");
                    exit;
                } else {
                    $status_msg = "Product not found";
                }

                break;
            }
        }
    }

    head("Admin");
    css("/styles/pages/admin.css");
    end_head();
?>

<main style="row-gap: 20px;">
    <span style="color: red; font-size: 18px;"><?php if ($status_msg) echo $status_msg; ?></span>

    <form class="form" action="/admin.php?action=SET_FEATURED" method="POST">
        <h2>Set Featured Product</h2>
        <input type="number" name="id">
        <input type="submit" value="Set" class="button primary">
    </form>

    <form class="form" action="/admin.php?action=ADD_PRODUCT" method="POST" enctype="multipart/form-data">
        <h2>New Product</h2>

        <input class="textbox" type="file" name="image">
        <input type="text" name="name" placeholder="Product Name" class="textbox" required autocomplete="off">
        <textarea name="description" rows="4" class="textbox" placeholder="Product Description" required></textarea>
        <input type="number" name="price" placeholder="Product Price" class="textbox" required>

        <select name="category">
            <option value="" disabled selected>Select Category</option>
            <?php
                $categories = get_categories($conn);
                foreach ($categories as $category) {
                    echo "<option class=\"textbox\" value=\"" . $category[0] . "\">" . $category[1] . "</option>";
                }
            ?>
        </select>

        <input type="submit" value="Add" class="button primary">
    </form>
</main>

<?php foot($conn); ?>