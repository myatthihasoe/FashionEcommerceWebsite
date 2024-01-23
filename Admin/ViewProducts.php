<?php
require_once("../Style/Head.php");
require_once("../Database/Connect.php");

$view_products = "SELECT products.*, category.Category as 'category_name' 
                    FROM products LEFT JOIN category 
                        ON products.category_id = category.id;";

$stmt = $pdo->query($view_products);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// if (isset($_POST['edit'])) {
//     echo "edit button clicked";
//     $id = $_POST['id'];
//     echo "id is $id";
//     header("Location: UpdateProduct.php?id=$id");
// }

if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    header("Location:DeleteProduct.php?id=$id");
}

?>

<div class="container mt-2" style="background-color: grey;">
    <a href="CreateProducts.php" class="btn btn-outline-light my-2">Create</a>
    <!-- primary,  -->
    <table class="table table-info">
        <thead>
            <tr class="table-warning">
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Category</th>
                <th scope="col">Price</th>
                <th scope="col">Stock</th>
                <th scope="col">Description</th>
                <th scope="col">Image</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($result as $product) : ?>
                <tr>
                    <th scope="row"><?= $product['product_id'] ?></th>
                    <td><?= $product['product_name'] ?></td>
                    <td><?= $product['category_name'] ?></td>
                    <td><?= $product['product_price'] ?></td>
                    <td><?= $product['product_stock'] ?></td>
                    <td><?= $product['product_description'] ?></td>
                    <td><?= $product['product_image'] ?></td>
                    <td>
                        <!-- <form method="POST" action="UpdateProduct.php?id= <?= $product['product_id'] ?>"> -->
                        <form method="POST">
                            <input type="hidden" value=<?= $product['product_id'] ?> name="id">
                            <button class="btn" name="edit"><i class="fas fa-edit"></i>Update</button>
                            <button class="btn" name="delete"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>