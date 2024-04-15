<?php
    if (basename(__FILE__) === basename($_SERVER['SCRIPT_FILENAME'])) {
        header("HTTP/1.0 404 Not Found");
        exit;
    }

    function connect() {
        return mysqli_connect("localhost", "root", "", "shop");
    }

    function query($conn, $query, $types = null, ...$params) {
        try {
            $stmt = mysqli_prepare($conn, $query);
            
            if ($types != null) {
                mysqli_stmt_bind_param($stmt, $types, ...$params);
            }
            
            mysqli_stmt_execute($stmt);

            $res = mysqli_stmt_get_result($stmt);

            return $res;
        } catch (Exception $err) {
            echo $err;
            return null;
        }
    }

    session_start();

    function head($title) {
        echo '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>'.$title.'</title>
                <link rel="preconnect" href="https://fonts.googleapis.com">
                <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
                <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
                <link rel="stylesheet" href="/styles/global.css">
        ';
    }

    function end_head() {
        echo '</head><body>';
        include "components/navbar.php";
    }

    function foot($conn = null) {
        if ($conn) {
            mysqli_close($conn);
        }

        echo "</body></html>";
    }

    function css($path) {
        echo "<link rel=\"stylesheet\" href=\"$path\">";
    }

?>