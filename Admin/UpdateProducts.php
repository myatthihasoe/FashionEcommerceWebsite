<?php
require_once("../Style/Head.php");
require_once("../Database/Connect.php");
$id = $_GET['id'];
$view_products = "SELECT products.*, category.Category as 'product_category' 
                    FROM products LEFT JOIN category 
                        ON products.category_id = category.id where product_id=$id";
$stmt = $pdo->query($view_products);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

function getImage()
{

    //get image path to store in database
    $imgPath =  "../img/" . $_FILES['image']['name'];
    //move chosen image full path into project images/folder
    $isUploaded = move_uploaded_file($_FILES['image']['tmp_name'], $imgPath);
    return $isUploaded ? $imgPath : ""; //insert empty in database
}

if (isset($_POST['update'])) {
    echo "update clicked";
    $name = $_POST['pro_name'];
    $cat = $_POST['pro_category'];
    $price = $_POST['pro_price'];
    $stock = $_POST['pro_stock'];
    $description = $_POST['pro_description'];

    $img = getImage();
    echo "SELECTED image" . $img;

    //Not working
    $update_product = "UPDATE products SET 
                        product_name = '$name',
                        category_id='$cat',
                        product_price='$price',
                        product_stock='$stock',
                        product_description='$description',
                        product_image='$img' 
                        WHERE product_id='$id'";

    try {
        $stmt = $pdo->exec($update_product);
        header("Location: UpdateProduct.php?id=$id&success=true");
    } catch (PDOException $e) {
        // echo "<script>alert('Please Check Database. Data is not updated.')</script>";
        echo $e->getMessage();
    }
}

if (isset($_GET['success'])) {
    echo "<script>alert('Product Updated.')</script>";
}

if (isset($_POST['delete'])) {
    header("Location:DeleteProduct.php?id=$id");
}
?>

<style>
    body {
        margin-top: 20px;
    }

    .avatar {
        width: 200px;
        height: 200px;
    }
</style>

<div>
    <!-- <h1>ID <?= $id ?> Update Page </h1> -->
    <div class="container bootstrap snippets bootdey">
        <a href="ViewProducts.php" class="btn btn-outline-success">Home</a>
        
        <h1 class="alert alert-info alert-dismissable mt-2">Edit Product ID <?= $id ?></h1>
        <hr>
        <div class="row">
            <!-- left column -->
            <div class="col-md-3">
                <div class="text-center">
                    <form method="POST" enctype="multipart/form-data">
                        <h6>Select a product photo</h6>
                        <!-- <input type="file" class="form-control" name="image" accept=".jpg, .png, .jpeg"> -->
                        <img id="imageView" style=" object-fit: contain;" class="avatar img-thumbnail bg-light mb-2">
                        <input type="file" id="image" name="image">

                        <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                const image = document.getElementById("image");
                                const imageView = document.getElementById("imageView");
                                // console.log(image, imageView);

                                image.addEventListener("change", () => {
                                    // console.log(image.files[0]);
                                    if (image.files[0]) {
                                        const imageReader = new FileReader();

                                        imageReader.onload = (ev) => {
                                            imageView.src = ev.target.result;
                                        }
                                        imageReader.readAsDataURL(image.files[0]);
                                    }
                                })
                            });
                        </script>
                </div>
            </div>

            <!-- edit form column -->
            <div class="col-md-9 personal-info">
                <div class="alert alert-primary ">
                    <h3>Product ID <?= $id ?> Detail Information</h3>
                </div>
                <div class="form-group d-flex my-2 ">
                    <label class="col-lg-3 control-label"> ID:</label>
                    <div class="col-lg-8">
                        <input class="form-control" type="text" readonly value="<?= $result['product_id'] ?>">
                    </div>
                </div>
                <div class="form-group d-flex my-2">
                    <label class="col-lg-3 control-label"> Name:</label>
                    <div class="col-lg-8">
                        <input class="form-control" type="text" value="<?= $result['product_name'] ?>" name="pro_name">
                    </div>
                </div>
                <div class="form-group d-flex my-2">
                    <label class="col-lg-3 control-label"> Category:</label>
                    <div class="col-lg-8">
                        <select class="form-control" name="pro_category" id="pro_category" value="<?= $result['product_category'] ?>" required>
                            <?php
                            $categories =  "SELECT * from category"; //condition par lar may yan (on category.id = products.category_id)
                            $stmt = $pdo->query($categories);
                            foreach ($cat = $stmt->fetchAll(PDO::FETCH_ASSOC) as $each) :
                            ?>
                                <option value="<?php echo $each['id'] ?>">
                                    <?php echo $each['Category'] ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <div class="form-group d-flex my-2">
                    <label class="col-lg-3 control-label">Price:</label>
                    <div class="col-lg-8">
                        <input class="form-control" type="text" value="<?= $result['product_price'] ?>" name="pro_price">
                    </div>
                </div>
                <div class="form-group d-flex my-2 ">
                    <label class="col-lg-3 control-label">Stock:</label>
                    <div class="col-lg-8">
                        <input class="form-control" type="text" value="<?= $result['product_stock'] ?>" name="pro_stock">
                    </div>
                </div>
                <div class="form-group d-flex my-2 ">
                    <label class="col-lg-3 control-label">Description:</label>
                    <div class="col-lg-8">
                        <textarea class="form-control" name="pro_description"><?= $result['product_description'] ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" name="update">Update</button>
                    <button class="btn btn-danger" name="delete">Delete</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <hr>
</div>