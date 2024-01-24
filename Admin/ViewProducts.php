<?php
require_once("../Style/Head.php");
require_once("../Database/Connect.php");

$view_products = "SELECT products.*, category.Category as 'product_category' 
                    FROM products LEFT JOIN category 
                        ON products.category_id = category.id;";

$stmt = $pdo->query($view_products);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['edit'])) {
    echo "edit button clicked";
    $id = $_POST['id'];
    echo "id is $id";
    header("Location: UpdateProducts.php?id=$id");
}

if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    header("Location:DeleteProduct.php?id=$id");
}

?>



<!-- Css  -->

<head>
    <link rel="stylesheet" href="../css/ViewProductInfo.css">
</head>

<body>
    
    <div class="container bootstrap snippets bootdey" style="margin-top: 10px" ;>
        <a href="CreateProducts.php" class="btn btn-primary my-2" style="color: white;">Create</a>
    </div>

    <!-- Font awesome HTML and CSS  -->
    <div class="container mt-1">
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <div class="panel">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col col-sm-12 col-xs-12">
                                <h4 class="title">View Products Information</h4>
                            </div>

                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
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
                                        <td><?= $product['product_category'] ?></td>
                                        <td><?= $product['product_price'] ?> Ks</td>
                                        <td><?= $product['product_stock'] ?></td>
                                        <td><?= $product['product_description'] ?></td>
                                        <td><?= $product['product_image'] ?></td>
                                        <td>
                                            <form method="POST">
                                                <input type="hidden" value=<?= $product['product_id'] ?> name="id">
                                                <button class="btn btn-outline-dark" name="edit"><i class="fas fa-edit"></i>Edit</button>
                                                <button class="btn btn-outline-dark" name="delete" title="delete"><i class="fa-solid fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<!-- <ul class="action-list">
    <li><a class="btn" name="edit" data-tip="edit"><i class="fa fa-edit"></i></a></li>
    <li><a class="btn" name="delete" data-tip="delete"><i class="fa fa-trash"></i></a></li>
</ul> -->