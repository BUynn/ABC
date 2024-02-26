<?php
    define('HOST', '127.0.0.1');
    define('USER', 'root');
    define('PASS', '');
    define('DB_NAME', 'lab08');

    function create_connection() {
        $conn = new mysqli(hostname: HOST, username: USER,password: PASS,database: DB_NAME);
        if($conn->connect_error) {
            die('Can not connect to the sever:' . $conn->connect_error);
        }
        return $conn;
    }

    create_connection();
?>

