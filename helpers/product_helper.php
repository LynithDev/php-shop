<?php
    if (basename(__FILE__) === basename($_SERVER['SCRIPT_FILENAME'])) {
        header("HTTP/1.0 404 Not Found");
        exit;
    }

    function set_featured_product($conn, $product_id) {
        query(
            $conn, 
            "UPDATE featured_products SET product_id = ? WHERE id = 1",
            "i", $product_id
        );
    }

    function search_products($conn, $query) {
        $stmt = query(
            $conn, 
            "SELECT * FROM products WHERE `name` LIKE ? OR `description` LIKE ?",
            "ss", "%$query%", "%$query%"
        );
        return mysqli_fetch_all($stmt);
    }

    function get_categories($conn) {
        $stmt = query(
            $conn, 
            "SELECT * FROM categories"
        );
        return mysqli_fetch_all($stmt);
    }

    function get_category($conn, $id) {
        $stmt = query(
            $conn, 
            "SELECT * FROM categories WHERE id = ?",
            "i", $id
        );
        return mysqli_fetch_assoc($stmt);
    }

    function get_product($conn, $id) {
        $stmt = query(
            $conn, 
            "SELECT * FROM products WHERE id = ?",
            "i", $id
        );
        return mysqli_fetch_assoc($stmt);
    }

    function get_similar_products($conn, $product_id, $category) {
        $stmt = query(
            $conn, 
            "SELECT * FROM products WHERE category_id = ? AND id != ? ORDER BY RAND() LIMIT 4",
            "ii", $category, $product_id
        );
        return mysqli_fetch_all($stmt);
    }

    function get_products_by_category_and_author($conn, $category, $author) {
        $stmt = query(
            $conn, 
            "SELECT * FROM products WHERE category_id = ? AND author_id = ?",
            "ii", $category, $author
        );

        return mysqli_fetch_all($stmt);
    }

    function get_products_by_category($conn, $category, $limit = 25, $page = 1) {
        $stmt = null;

        if ($limit && $page) {
            $stmt = query(
                $conn, 
                "SELECT * FROM products WHERE category_id = ? LIMIT ? OFFSET ?",
                "iii", $category, $limit, ($page - 1) * $limit
            );
        } else {
            $stmt = query(
                $conn, 
                "SELECT * FROM products WHERE category_id = ?",
                "i", $category
            );
        }

        return mysqli_fetch_all($stmt);
    }

    function get_featured_product($conn) {
        $stmt = query($conn, "
            SELECT 
                p.id,
                p.name,
                p.description,
                p.price
            FROM featured_products fp
            INNER JOIN products p ON fp.product_id = p.id
            LIMIT 1
        ");
        
        return mysqli_fetch_assoc($stmt);
    }

    function format_price($price) {
        return substr_replace($price, ',', -2, 0) . 'zł';
    }

    function remove_product($conn, $id) {
        query(
            $conn, 
            "DELETE FROM products WHERE id = ?",
            "i", $id
        );

        $image_path = $_SERVER['DOCUMENT_ROOT'] . "/user_content/uploads/products/$id.png";
        unlink($image_path);

        return true;
    }

    function add_product($conn, $image, $name, $description, $price, $category, $author) {
        try {
            query(
                $conn, 
                "INSERT INTO products (`name`, `description`, `price`, `category_id`, `author_id`) VALUES (?, ?, ?, ?, ?)",
                "ssiii", $name, $description, $price, $category, $author
            );
    
            $product_id = query(
                $conn, 
                "SELECT id FROM products ORDER BY id DESC LIMIT 1"
            )->fetch_assoc()["id"];
            
            $image_path = $image['tmp_name'];
            $new_image_path = $_SERVER['DOCUMENT_ROOT'] . "/user_content/uploads/products/$product_id.png";
            move_uploaded_file($image_path, $new_image_path);

            return $product_id;
        } catch (Exception $err) {
            return false;
        }
    }

?>