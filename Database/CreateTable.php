    <?php

    //Connect with DATABASE
    require_once("Connect.php");
    $products = "products";
    $users = "users";

    $create_products = "CREATE TABLE IF NOT EXISTS $products (
            product_id INT PRIMARY KEY AUTO_INCREMENT,
            product_name VARCHAR (20) UNIQUE,
            product_category VARCHAR (20),
            product_price FLOAT,
            product_stock INT,
            product_description TEXT,
            product_image VARCHAR (50)
        );";

    $create_users = "CREATE TABLE IF NOT EXISTS $users(
            user_id INT PRIMARY KEY AUTO_INCREMENT,
            user_name VARCHAR (30),
            user_email VARCHAR (30) UNIQUE,
            user_password VARCHAR (40),
            user_contact VARCHAR (15),
            user_address VARCHAR (30)
        );";


    try {

        $pdo->exec($create_products);
        $pdo->exec($create_users);
        echo " $products and $users table are created";

    } catch (PDOException $pde) {
        echo $pde->getMessage();
    }
    ?>
