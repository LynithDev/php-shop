<?php
    if (basename(__FILE__) === basename($_SERVER['SCRIPT_FILENAME'])) {
        header("HTTP/1.0 404 Not Found");
        exit;
    }

    function register($conn, $login, $password) {
        if (strlen($login) < 4) {
            return "Login too short (4+ characters required)";
        }

        if (strlen($password) < 6) {
            return "Password too short (6+ characters required)";
        }

        $check = query(
            $conn, 
            "SELECT COUNT(*) FROM users WHERE `login` = ?",
            "s", $login
        );

        $count = mysqli_fetch_row($check)[0];
        if ($count > 0) {
            return "Login already taken";
        }

        query(
            $conn, 
            "INSERT INTO users (`login`, `password`) VALUES (?, ?)",
            "ss", $login,  password_hash($password, PASSWORD_DEFAULT)
        );

        return true;
    }

    function get_user_by_id($conn, $id) {
        $stmt = query(
            $conn, 
            "SELECT * FROM users WHERE `id` = ?",
            "i", $id
        );
        
        return mysqli_fetch_assoc($stmt);
    }

    function login($conn, $login, $password) {
        $stmt = query(
            $conn, 
            "SELECT * FROM users WHERE `login` = ?",
            "s", $login
        );

        $user = mysqli_fetch_assoc($stmt);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user["login"];
            setcookie("user_id", $user['id'], time() + 60 * 60 * 24 * 30);
            
            return true;
        }

        return false;
    }

    function logout() {
        if (is_logged_in()) {
            $_SESSION = array();
            session_destroy();
            setcookie("user_id", "", time() - 1);
        }
    }
    
    function is_logged_in() {
        return isset($_COOKIE['user_id']) && isset($_SESSION['user_id']);
    }

    function get_logged_in_user($conn) {
        if (is_logged_in()) {
            return get_user_by_id($conn, $_SESSION['user_id']);
        }

        return null;
    }
    
    // TODO: Bitwise permissions
    const PERMISSION_NONE = 0;
    const PERMISSION_ADMIN = 1;
    // const PERMISSION_ADD_PRODUCTS = 2;
    // const PERMISSION_DELETE_PRODUCTS = 4;
    // const PERMISSION_EDIT_PRODUCTS = 8;

    function add_permission($conn, $user_id, $permission) {
        query(
            $conn, 
            "UPDATE users SET permissions = permissions | ? WHERE id = ?",
            "ii", $permission, $user_id
        );
    }

    function remove_permission($conn, $user_id, $permission) {
        query(
            $conn, 
            "UPDATE users SET permissions = permissions & ~? WHERE id = ?",
            "ii", $permission, $user_id
        );
    }

    function has_permission($user_permissions, $permission) {
        return ($user_permissions & $permission) === $permission;
    }

?>